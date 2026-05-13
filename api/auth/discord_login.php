<?php
require_once '../../config.php';

if (DEV_MODE) {
    // Mock Discord Login
    $_SESSION['discord_user'] = [
        'id' => '123456789012345678',
        'username' => 'DiscordDev',
        'discriminator' => '0000',
        'avatar' => null
    ];
    
    // Whitelist Check Simulation
    $_SESSION['is_whitelisted'] = true;
    
    // DB Link
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn->connect_error) {
        $discordId = $_SESSION['discord_user']['id'];
        $dbId = $_SESSION['user_db_id'] ?? 0;
        
        if ($dbId) {
            $stmt = $conn->prepare("UPDATE users SET discord_id = ?, is_whitelisted = 1 WHERE id = ?");
            $stmt->bind_param("si", $discordId, $dbId);
            $stmt->execute();
        }
        $conn->close();
    }
    
    header("Location: ../../index.php?login_success=1");
    exit;
}

// Real Discord OAuth
// Generate State Token for CSRF Protection
$_SESSION['oauth2state'] = bin2hex(random_bytes(16));

$params = [
    'client_id' => DISCORD_CLIENT_ID,
    'redirect_uri' => DISCORD_REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'identify guilds.members.read',
    'state' => $_SESSION['oauth2state']
];

$url = "https://discord.com/api/oauth2/authorize?" . http_build_query($params);
header("Location: " . $url);
exit;
?>
