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

if ($_SERVER["REQUEST_METHOD"] === 'GET') {
    header('Content-Type: application/json');
    $id = $_GET['id'];
    $video = array();
    $stmt = $conn->prepare('SELECT videos.thumbnail, videos.title, categories.name as category, tags.name as tag_name from videos left join categories on videos.category_id = categories.id left join tagdetails on videos.id = tagdetails.video_id left join tags on tagdetails.tag_id = tags.id where videos.id = ?;');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $video[] = $row;
            }
            $responsive = ['status' => 200, 'video' => $video];
            echo json_encode($responsive);
        }
    } else {
        $responsive = ['status' => 400, 'message' => 'No get data'];
        echo json_encode($responsive);
    }
}

$conn->close();