<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



$servername = "localhost:3306";
$username = "root";
$password = "root";
$dbname = "streamable";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    // Nhận dữ liệu từ AJAX
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if ($email) {
        // Kiểm tra xem email đã tồn tại hay chưa
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows() > 0) {
            echo json_encode(['message' => 'Email đã tồn tại', 'status' => 409]);
        } else {
            $stmt->close();

            $stmt = $conn->prepare("INSERT into users(username, email, password) value(?,?, ?)");
            $stmt->bind_param("sss", $email, $email, $password);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Đăng ký thành công', 'status' => 200]);
            } else {
                echo json_encode(['message' => 'Đăng ký không thành công', 'status' => 401]);
            }
            $stmt->close();
        }
    }
}

$conn->close();