<?php

require 'vendor/autoload.php';

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\TimeCode;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$servername = "localhost:3306";
$username = "root";
$password = "root";
$dbname = "streamable";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die(json_encode(['status' => 500, 'message' => 'Connection failed: ' . mysqli_connect_error()]));
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Xử lý videos
    if (isset($_FILES['fileVideo']['name'])) {
        header('Content-Type: application/json');
        $target_dir_video = "uploads/videos/";
        $response = [];
        foreach ($_FILES['fileVideo']['name'] as $key => $nameVideo) {
            if ($_FILES['fileVideo']['error'][$key] == 0) {
                $target_file_video = $target_dir_video . basename($nameVideo);
                $file = basename($nameVideo);
                $uploadOk = 1;
                $videoFileType = strtolower(pathinfo($target_file_video, PATHINFO_EXTENSION));
                $tmp_name = $_FILES["fileVideo"]["tmp_name"][$key];

                // Kiểm tra định dạng file video
                $allowedTypes = ['mp4', 'avi', 'mov', 'mpeg'];
                if (!in_array($videoFileType, $allowedTypes)) {
                    $response[] = ['status' => 500, 'message' => "Sorry, only MP4, AVI, MOV, and MPEG files are allowed for file: . $nameVideo"];
                    $uploadOk = 0;
                }

                // Kiểm tra nếu $uploadOk để xử lý tải lên
                if ($uploadOk == 1) {
                    if (move_uploaded_file($tmp_name, $target_file_video)) {
                        // Khởi tạo đối tượng FFmpeg
                        $ffmpeg = FFMpeg::create([
                            'ffmpeg.binaries'  => 'D:\workspace\install\ffmpeg\ffmpeg-7.1-full_build\bin\ffmpeg.exe',
                            'ffprobe.binaries' => 'D:\workspace\install\ffmpeg\ffmpeg-7.1-full_build\bin\ffprobe.exe',
                            'timeout'          => 3600, // Thời gian chờ cho mỗi lệnh
                            'ffmpeg.threads'   => 12,   // Số luồng xử lý
                        ]);
                        $ffprobe = FFprobe::create([
                            'ffprobe.binaries' => 'D:\workspace\install\ffmpeg\ffmpeg-7.1-full_build\bin\ffprobe.exe',
                            'timeout'          => 3600, // Thời gian chờ cho mỗi lệnh
                            'ffmpeg.threads'   => 12,   // Số luồng xử lý
                        ]);

                        $video = $ffmpeg->open($target_file_video);

                        // Lấy độ dài video (duration)
                        try {
                            $duration = $ffprobe->format($target_file_video)->get('duration');
                        } catch (Exception $e) {
                            $response[] = ['status' => 500, 'message' => 'Error getting video duration for file: ' . $nameVideo . '. Error: ' . $e->getMessage()];
                            continue; // Chuyển sang video tiếp theo
                        }

                        // Lấy độ phân giải (resolution)
                        $video_stream = $ffprobe->streams($target_file_video)->videos()->first();
                        $width = $video_stream->get('width');
                        $height = $video_stream->get('height');
                        $resolution = $width . "x" . $height;

                        // Lấy bitrate
                        $bitrate = $video_stream->get('bit_rate');

                        // Tạo Thumbnail
                        $thumbnail_dir = 'uploads/thumbnails/';
                        $thumbnail_file = $thumbnail_dir . 'thumb_' . basename($nameVideo) . '.jpg';
                        $thumbnail = 'thumb_' . basename($nameVideo) . '.jpg';
                        $video->frame(TimeCode::fromSeconds(10))->save($thumbnail_file);

                        $description = "Description";
                        $status = "ready";
                        $title = explode('.', $nameVideo);

                        // Kiểm tra xem người dùng đã đăng nhập hay chưa
                        // Kiểm tra và bắt đầu session nếu chưa có session nào
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id']; // Lấy user_id từ session nếu người dùng đã đăng nhập
                        } else {
                            $user_id = null; // Gán user_id là NULL nếu người dùng chưa đăng nhập
                        }

                        // Câu lệnh SQL để lưu thông tin vào bảng videos
                        $stmt = $conn->prepare("INSERT INTO videos (user_id, file_path, thumbnail, title, description, duration, resolution, bitrate, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("issssdiss", $user_id, $file, $thumbnail, $title[0], $description, $duration, $resolution, $bitrate, $status);

                        if ($stmt->execute()) {

                            $response[] = ['status' => 200, 'message' => 'Video uploaded and information saved successfully.'];
                        } else {
                            $response[] = ['status' => 500, 'message' => 'Error: ' . $stmt->error];
                        }
                        $stmt->close();
                    } else {
                        $response[] = ['status' => 500, 'message' => 'Sorry, there was an error uploading your video: ' . basename($file_name)];
                    }
                }
            }
        }
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 400, 'message' => 'No video file uploaded or an error occurred during upload.']);
    }
}
$conn->close();