<?php
require_once '../../config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_db_id'])) {
    echo json_encode(['error' => 'auth_required']);
    exit;
}

$userId = $_SESSION['user_db_id'];
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    echo json_encode(['error' => 'db_connection_failed']);
    exit;
}

// SECURITY: Validate whitelist status from database (prevent session manipulation)
$stmt = $conn->prepare("SELECT is_whitelisted, steam_id, discord_id FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || $user['is_whitelisted'] != 1) {
    echo json_encode(['error' => 'not_whitelisted', 'in_queue' => false]);
    $conn->close();
    exit;
}

// Get my entry
$stmt = $conn->prepare("SELECT id, joined_at, status FROM queue WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$res = $stmt->get_result();
if (!$res) {
    echo json_encode(['error' => 'db_query_failed']);
    exit;
}
$myEntry = $res->fetch_assoc();
$stmt->close();

if (!$myEntry) {
    echo json_encode(['in_queue' => false]);
    exit;
}

// Count people ahead
// Count people ahead
$id = $myEntry['id'];
$stmt = $conn->prepare("SELECT COUNT(*) as pos FROM queue WHERE id < ? AND status = 'waiting'");
$stmt->bind_param("i", $id);
$stmt->execute();
$countRes = $stmt->get_result();

$position = 1;
if ($countRes) {
    $position = $countRes->fetch_object()->pos + 1;
}
$stmt->close();

// REAL QUEUE LOGIC: Check server slot availability via API
// Only promote #1 if there is a slot on the actual FiveM server

$server_ip = 'eliterp.serverloom.com';
$server_port = '30120';

// Function to fetch URL with timeout (Helper)
function fetch_data_queue($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$should_promote = false;

if ($position <= 1 && $myEntry['status'] == 'waiting') {
    // Check server
    $players_json = fetch_data_queue("http://$server_ip:$server_port/players.json");
    
    if ($players_json !== false) {
        $players = json_decode($players_json, true);
        $current_players = is_array($players) ? count($players) : 0;
        
        // Get Max Players
        $info_json = fetch_data_queue("http://$server_ip:$server_port/info.json");
        $info = json_decode($info_json, true);
        $max_players = isset($info['vars']['sv_maxClients']) ? intval($info['vars']['sv_maxClients']) : 128;
             
        // ALLOW ENTRY if less than max (Reserve 1 slot just in case or strict < max)
        if ($current_players < $max_players) {
            $should_promote = true;
        }
    }
}

if ($should_promote) {
    $stmt = $conn->prepare("UPDATE queue SET status = 'ready', ready_at = NOW() WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $myEntry['status'] = 'ready';
}

echo json_encode([
    'in_queue' => true,
    'position' => $position,
    'status' => $myEntry['status'] // 'waiting' or 'ready'
]);

$conn->close();
?>
