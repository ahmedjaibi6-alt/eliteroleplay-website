<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';


$server_ip = 'eliterp.serverloom.com';
$server_port = '30120';

// Function to fetch URL with timeout
function fetch_data($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

// 1. Get Players info
$start = microtime(true);
$players_json = fetch_data("http://$server_ip:$server_port/players.json");
$end = microtime(true);
$latency = round(($end - $start) * 1000); // ms

$players = json_decode($players_json, true);
$real_player_count = is_array($players) ? count($players) : 0;
$player_count = $real_player_count;

// Fake player logic: If real players exceed threshold, add boost
if (defined('FAKE_PLAYER_THRESHOLD') && defined('FAKE_PLAYER_BOOST')) {
    if ($real_player_count > FAKE_PLAYER_THRESHOLD) {
        $player_count += FAKE_PLAYER_BOOST;
    }
} else {
    // Fallback if constants aren't defined
    if ($real_player_count > 15) {
        $player_count += 17;
    }
}



// 2. Get Server info (max players)
$info_json = fetch_data("http://$server_ip:$server_port/info.json");
$info = json_decode($info_json, true);
$max_players = isset($info['vars']['sv_maxClients']) ? intval($info['vars']['sv_maxClients']) : 128; // Default to 128 if not found

echo json_encode([
    'online' => $players_json !== false,
    'players' => $player_count,
    'max_players' => $max_players,
    'latency' => $latency,
    'error' => $players_json === false ? 'Server offline or unreachable' : null
]);
?>
