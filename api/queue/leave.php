<?php
require_once '../../config.php';
header('Content-Type: application/json');

if (isset($_SESSION['user_db_id'])) {
    $userId = $_SESSION['user_db_id'];
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("DELETE FROM queue WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}

echo json_encode(['status' => 'left']);
?>
