<?php
// Enable error logging (NOT display for security)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../steam_auth.php';
require_once __DIR__ . '/../rate_limiter.php';

// Rate limiting
$rateLimiter = new RateLimiter(5, 300); // 5 attempts per 5 minutes
$clientIP = getClientIP();

if (!$rateLimiter->isAllowed($clientIP, 'steam_login')) {
    $retryAfter = $rateLimiter->getRetryAfter($clientIP, 'steam_login');
    error_log("Rate limit exceeded for IP: $clientIP");
    header("Location: " . SITE_URL . "/index.php?error=rate_limit&retry=" . $retryAfter);
    exit;
}

if (DEV_MODE) {
    // Should not hit this callback in DEV_MODE usually, but just in case
    header("Location: " . SITE_URL . "/index.php?login_step=2");
    exit;
}

try {
    $returnUrl = SITE_URL . '/api/auth/steam_callback.php';
    $steam = new SteamAuth(STEAM_API_KEY, $returnUrl);
    
    if ($steam->validate()) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
        
        // Validation successful, session is set by SteamAuth class
        // We need to repackage it slightly or just use what SteamAuth set
        
        $defaultAvatar = 'https://avatars.steamstatic.com/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg';
        $steamData = [
            'steamid'    => $_SESSION['steamid'] ?? '',
            'personaname'=> $_SESSION['personaname'] ?? 'Player',
            'avatar'     => $_SESSION['avatar'] ?: $defaultAvatar,
            'profileurl' => $_SESSION['profileurl'] ?? ''
        ];
        
        $_SESSION['steam_data'] = $steamData;
        
        // DB Sync
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            throw new Exception("Database connection failed: " . $conn->connect_error);
        }
        
        $steamId = $steamData['steamid'];
        $name = htmlspecialchars($steamData['personaname'], ENT_QUOTES, 'UTF-8'); // Sanitize XSS
        $avatar = $steamData['avatar'];
        
        // Update Session with sanitized name
        $_SESSION['steam_data']['personaname'] = $name;
        
        $stmt = $conn->prepare("INSERT INTO users (steam_id, username, avatar_url, is_whitelisted) VALUES (?, ?, ?, 0) ON DUPLICATE KEY UPDATE username=?, avatar_url=?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("sssss", $steamId, $name, $avatar, $name, $avatar);
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        // Get DB ID (Prepared)
        $stmt = $conn->prepare("SELECT id FROM users WHERE steam_id = ?");
        $stmt->bind_param("s", $steamId);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
            $_SESSION['user_db_id'] = $row['id'];
        }
        $stmt->close();
        $conn->close();
        
        header("Location: " . SITE_URL . "/index.php?login_step=2");
    } else {
        // Failed — expose debug info in URL for diagnosis
        $debugInfo = 'validate_returned_false';
        $debugInfo .= '_mode=' . urlencode($_GET['openid_mode'] ?? 'MISSING');
        $debugInfo .= '_claimed=' . urlencode(substr($_GET['openid_claimed_id'] ?? 'MISSING', 0, 60));
        error_log("[steam_callback] Validation failed. GET params: " . json_encode($_GET));
        header("Location: " . SITE_URL . "/index.php?error=steam_auth_failed&debug=" . urlencode($debugInfo));
    }
} catch (Exception $e) {
    // Log error and redirect with error message
    error_log("Steam Callback Error: " . $e->getMessage());
    header("Location: " . SITE_URL . "/index.php?error=" . urlencode($e->getMessage()));
}
exit;
?>
