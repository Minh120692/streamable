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
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Xoá thành công', 'status' => 200]);
    } else {
        echo json_encode(['message' => 'Xoá không thành công', 'status' => 401]);
    }
    $stmt->close();
}

$conn->close();
