<?php
require_once '../../config.php';
header('Content-Type: application/json');

$response = [
    'authenticated' => false,
    'steam' => null,
    'discord' => null,
    'whitelisted' => false
];

if (isset($_SESSION['user_db_id'])) {
    $response['authenticated'] = true;
    
    if (isset($_SESSION['steam_data'])) {
        $response['steam'] = $_SESSION['steam_data'];
    }
    
    if (isset($_SESSION['discord_user'])) {
        $response['discord'] = $_SESSION['discord_user'];
    }
    
    if (isset($_SESSION['is_whitelisted'])) {
        $response['whitelisted'] = $_SESSION['is_whitelisted'];
    }
}

echo json_encode($response);
?>
