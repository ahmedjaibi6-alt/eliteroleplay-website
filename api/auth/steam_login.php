<?php
require_once '../../config.php';
require_once '../../steam_auth.php';

if (DEV_MODE) {
    // Mock Steam Login
    $_SESSION['steam_data'] = [
        'steamid' => '76561198000000000',
        'personaname' => 'DevUser',
        'avatar' => 'assets/avatar.png',
        'profileurl' => '#'
    ];
    
    // Simulate DB Insert/Update for Steam User
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn->connect_error) {
        $steamId = $_SESSION['steam_data']['steamid'];
        $name = $_SESSION['steam_data']['personaname'];
        $avatar = $_SESSION['steam_data']['avatar'];
        
        // Upsert
        $stmt = $conn->prepare("INSERT INTO users (steam_id, username, avatar_url, is_whitelisted) VALUES (?, ?, ?, 0) ON DUPLICATE KEY UPDATE username=?, avatar_url=?");
        $stmt->bind_param("sssss", $steamId, $name, $avatar, $name, $avatar);
        $stmt->execute();
        $_SESSION['user_db_id'] = $stmt->insert_id ?: $conn->query("SELECT id FROM users WHERE steam_id='$steamId'")->fetch_object()->id;
        $conn->close();
    }

    header("Location: " . SITE_URL . "/index.php?login_step=2");
    exit;
}

// Real Steam Login
$returnUrl = SITE_URL . '/api/auth/steam_callback.php';
$steam = new SteamAuth(STEAM_API_KEY, $returnUrl);
header("Location: " . $steam->getLoginUrl());
exit;
?>
