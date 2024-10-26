<?php

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


    header('Content-Type: application/json');
    $id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $category = htmlspecialchars($_POST['category']);
    $tagName = htmlspecialchars($_POST['tagName']);
    // Bắt đầu transaction để đảm bảo dữ liệu được xử lý toàn bộ hoặc không
    mysqli_begin_transaction($conn);


    try {
        // Cập nhật title trong bảng videos
        $stmt = $conn->prepare("UPDATE videos SET title = ? WHERE id = ?");
        $stmt->bind_param("si", $title, $id);
        if (!$stmt->execute()) {
            echo json_encode(['status' => 500, 'message' => 'Error updating video title: ' . $stmt->error]);
            exit();
        }
        $stmt->close();

        // Kiểm tra và cập nhật category
        $stmt = $conn->prepare("SELECT category_id FROM videos WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($categoryId);
        $stmt->fetch();
        $stmt->close();

        // Nếu category không tồn tại, thêm mới
        if (!$categoryId || $categoryId == 0) {
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->bind_param("s", $category);
            if ($stmt->execute()) {
                $categoryId2 = $stmt->insert_id; // Lấy ID của category vừa thêm
                // Cập nhật category_id trong bảng videos
                $stmt = $conn->prepare("UPDATE videos SET category_id = ? WHERE id = ?");
                $stmt->bind_param("ii", $categoryId2, $id);
                if (!$stmt->execute()) {
                    echo json_encode(['status' => 500, 'message' => 'Error updating category_id in videos: ' . $stmt->error]);
                    exit();
                }
            } else {
                echo json_encode(['status' => 500, 'message' => 'Error inserting category: ' . $stmt->error]);
                exit();
            }
            $stmt->close();
        } else {
            // Nếu category đã tồn tại, cập nhật lại tên
            $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $category, $categoryId);
            if (!$stmt->execute()) {
                echo json_encode(['status' => 500, 'message' => 'Error updating category name: ' . $stmt->error]);
                exit();
            }
            $stmt->close();
        }

        // Kiểm tra xem video đã có tag nào chưa
        $stmt = $conn->prepare(" SELECT tags.id as tag_id, tags.name as tag_name 
                                FROM videos 
                                INNER JOIN tagdetails ON videos.id = tagdetails.video_id 
                                INNER JOIN tags ON tags.id = tagdetails.tag_id 
                                WHERE videos.id = ?
                                ");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($tagId, $existingTagName);
        $stmt->fetch();
        $stmt->close();

        // Nếu video chưa có tag, thêm tag mới và cập nhật vào bảng tagdetails
        if (!$tagId) {
            // Thêm tag mới vào bảng tags
            $stmt = $conn->prepare("INSERT INTO tags (name) VALUES (?)");
            $stmt->bind_param("s", $tagName);
            if ($stmt->execute()) {
                $tagId = $stmt->insert_id; // Lấy ID của tag vừa thêm

                // Thêm vào bảng tagdetails
                $stmt = $conn->prepare("INSERT INTO tagdetails (video_id, tag_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $id, $tagId);
                if (!$stmt->execute()) {
                    echo json_encode(['status' => 500, 'message' => 'Error inserting into tagdetails: ' . $stmt->error]);
                    exit();
                }
            } else {
                echo json_encode(['status' => 500, 'message' => 'Error inserting tag: ' . $stmt->error]);
                exit();
            }
            $stmt->close();
        } else {
            // Nếu tag đã tồn tại, cập nhật lại tên tag trong bảng tags
            $stmt = $conn->prepare("UPDATE tags SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $tagName, $tagId);
            if (!$stmt->execute()) {
                echo json_encode(['status' => 500, 'message' => 'Error updating tag name: ' . $stmt->error]);
                exit();
            }
            $stmt->close();
        }


        // Commit transaction nếu không có lỗi
        mysqli_commit($conn);

        echo json_encode(['status' => 200, 'message' => 'Video updated successfully.']);
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        mysqli_rollback($conn);
        echo json_encode(['status' => 500, 'message' => 'Error: ' . $e->getMessage()]);
    }
}



$conn->close();
