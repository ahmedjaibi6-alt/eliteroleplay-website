<?php
require_once '../../config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_db_id']) || !isset($_SESSION['is_whitelisted']) || !$_SESSION['is_whitelisted']) {
    echo json_encode(['error' => 'Not authenticated or whitelisted']);
    exit;
}

$userId = $_SESSION['user_db_id'];
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// SECURITY: Double-check whitelist status in database (prevent session manipulation)
$stmt = $conn->prepare("SELECT is_whitelisted, steam_id, discord_id FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || $user['is_whitelisted'] != 1) {
    echo json_encode(['error' => 'Not whitelisted in database']);
    $conn->close();
    exit;
}

// SECURITY: Verify account binding integrity
if (empty($user['steam_id']) || empty($user['discord_id'])) {
    echo json_encode(['error' => 'Account binding incomplete']);
    $conn->close();
    exit;
}

// Check if already in queue
$stmt = $conn->prepare("SELECT id FROM queue WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$check = $stmt->get_result();

if ($check && $check->num_rows > 0) {
    echo json_encode(['status' => 'already_in_queue']);
    exit;
}
$stmt->close();

// Add to queue
$stmt = $conn->prepare("INSERT INTO queue (user_id, status) VALUES (?, 'waiting')");
$stmt->bind_param("i", $userId);
if ($stmt->execute()) {
    echo json_encode(['status' => 'joined']);
} else {
    echo json_encode(['error' => 'db_error']);
}
$conn->close();
?>
