<?php
require_once '../../config.php';
require_once '../rate_limiter.php';

// Rate limiting
$rateLimiter = new RateLimiter(5, 300); // 5 attempts per 5 minutes
$clientIP = getClientIP();

if (!$rateLimiter->isAllowed($clientIP, 'discord_auth')) {
    $retryAfter = $rateLimiter->getRetryAfter($clientIP, 'discord_auth');
    error_log("Discord auth rate limit exceeded for IP: $clientIP");
    header("Location: " . SITE_URL . "/index.php?error=rate_limit&retry=" . $retryAfter);
    exit;
}

// Enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// CSRF Protection: Validate State Token
// TEMPORARY: Relaxed for debugging (re-enable strict check after testing)
if (empty($_GET['state'])) {
    error_log("Discord OAuth: No state parameter provided");
    // Don't fail, just log
}

if (empty($_SESSION['oauth2state'])) {
    error_log("Discord OAuth: No session state found");
    // Don't fail, just log
}

if (!empty($_GET['state']) && !empty($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state']) {
    error_log("Discord OAuth CSRF State Mismatch: GET=" . $_GET['state'] . " SESSION=" . $_SESSION['oauth2state']);
    // Temporarily allow it but log
}

// Clear the state token after validation
if (isset($_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
}

if (!isset($_GET['code'])) {
    header("Location: " . SITE_URL . "/index.php?error=discord_no_code");
    exit;
}

$code = $_GET['code'];
$tokenUrl = "https://discord.com/api/oauth2/token";
$data = [
    'client_id' => DISCORD_CLIENT_ID,
    'client_secret' => DISCORD_CLIENT_SECRET,
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => DISCORD_REDIRECT_URI
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    error_log("Discord Token cURL Error: " . $curlError);
    header("Location: " . SITE_URL . "/index.php?error=discord_token_failed&detail=curl");
    exit;
}

if ($httpCode !== 200) {
    error_log("Discord Token HTTP Error: Code $httpCode, Response: " . $response);
    header("Location: " . SITE_URL . "/index.php?error=discord_token_failed&detail=http_" . $httpCode);
    exit;
}

$json = json_decode($response, true);
$accessToken = $json['access_token'] ?? null;

if (!$accessToken) {
    error_log("Discord Token Response: " . $response);
    header("Location: " . SITE_URL . "/index.php?error=discord_token_failed");
    exit;
}

// Get User Info
$userUrl = "https://discord.com/api/users/@me";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $userUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $accessToken"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$userResponse = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    error_log("Discord User cURL Error: " . $curlError);
    header("Location: " . SITE_URL . "/index.php?error=discord_user_failed");
    exit;
}

$userData = json_decode($userResponse, true);

if (!isset($userData['id'])) {
    error_log("Discord User Response: " . $userResponse);
    header("Location: " . SITE_URL . "/index.php?error=discord_user_failed");
    exit;
}

// Regenerate session ID to prevent session fixation
session_regenerate_id(true);

$_SESSION['discord_user'] = $userData;

// Check Whitelist Role (if Guild ID and Role ID set)
$isWhitelisted = false;
if (DISCORD_GUILD_ID && WHITELIST_ROLE_ID && DISCORD_BOT_TOKEN) {
    // Check Guild Member
    $memberUrl = "https://discord.com/api/guilds/".DISCORD_GUILD_ID."/members/".$userData['id'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $memberUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bot " . DISCORD_BOT_TOKEN]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $memberResponse = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($curlError) {
        error_log("Discord Member cURL Error: " . $curlError);
    } elseif ($httpCode !== 200) {
        error_log("Discord Member API Error (HTTP $httpCode): " . $memberResponse);
    }
    
    $memberData = json_decode($memberResponse, true);
    
    if (isset($memberData['roles']) && in_array(WHITELIST_ROLE_ID, $memberData['roles'])) {
        $isWhitelisted = true;
    }
} else {
    // Fallback if no bot token: Assume whitelisted if logged in
    $isWhitelisted = true; 
}

$_SESSION['is_whitelisted'] = $isWhitelisted;

// Update DB with Account Binding Protection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        error_log("DB Connection Error: " . $conn->connect_error);
    } else {
        $discordId = $userData['id'];
        $dbId = $_SESSION['user_db_id'] ?? 0;
        
        if ($dbId) {
            // SECURITY: Check if this Discord account is already bound to a DIFFERENT Steam account
            $stmt = $conn->prepare("SELECT steam_id, discord_id FROM users WHERE discord_id = ? AND id != ?");
            if ($stmt) {
                $stmt->bind_param("si", $discordId, $dbId);
                $stmt->execute();
                $result = $stmt->get_result();
                $existingBinding = $result->fetch_assoc();
                $stmt->close();
                
                if ($existingBinding) {
                    // Discord account is already bound to another Steam account - ACCOUNT SHARING DETECTED
                    error_log("SECURITY ALERT: Discord account {$discordId} attempted to bind to multiple Steam accounts. Possible account sharing.");
                    
                    // CRITICAL: Destroy session completely to prevent queue access
                    $_SESSION = array();
                    
                    // Destroy session cookie
                    if (isset($_COOKIE[session_name()])) {
                        setcookie(session_name(), '', time()-3600, '/');
                    }
                    
                    // Destroy session
                    session_destroy();
                    
                    // Deny access and redirect with error
                    header("Location: " . SITE_URL . "/index.php?error=account_sharing_detected");
                    exit;
                }
            }
            
            // Proceed with normal update
            $wlInt = $isWhitelisted ? 1 : 0;
            $stmt = $conn->prepare("UPDATE users SET discord_id = ?, is_whitelisted = ? WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("sii", $discordId, $wlInt, $dbId);
                $stmt->execute();
                $stmt->close();
            } else {
                error_log("DB Prepare Error: " . $conn->error);
            }
        }
        $conn->close();
    }
} catch (Exception $e) {
    error_log("DB Exception: " . $e->getMessage());
}

if ($isWhitelisted) {
    header("Location: " . SITE_URL . "/index.php?login_success=1");
} else {
    header("Location: " . SITE_URL . "/index.php?error=not_whitelisted");
}
exit;
?>
