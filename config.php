<?php
// Elite RP Configuration

// Load environment variables
require_once __DIR__ . '/env_loader.php';
loadEnv(__DIR__ . '/.env');

// Database Configuration
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_USER', env('DB_USER', 'eliterpp'));
define('DB_PASS', env('DB_PASS', ''));
define('DB_NAME', env('DB_NAME', 'zap1345966_'));

// Development Mode (Set to false in production)
// If true, authentication simulates success without external API calls
define('DEV_MODE', env('DEV_MODE', false));

// Steam Configuration
define('STEAM_API_KEY', env('STEAM_API_KEY', ''));
// Domain for Steam OpenID (auto-detected usually, but good to set)
define('STEAM_DOMAIN', env('STEAM_DOMAIN', 'localhost')); 

// Discord Configuration
define('DISCORD_CLIENT_ID', env('DISCORD_CLIENT_ID', ''));
define('DISCORD_CLIENT_SECRET', env('DISCORD_CLIENT_SECRET', ''));
define('DISCORD_REDIRECT_URI', env('DISCORD_REDIRECT_URI', ''));
define('DISCORD_BOT_TOKEN', env('DISCORD_BOT_TOKEN', '')); 
define('DISCORD_GUILD_ID', env('DISCORD_GUILD_ID', ''));
define('WHITELIST_ROLE_ID', env('WHITELIST_ROLE_ID', ''));

// Social Links
define('DISCORD_INVITE_URL', env('DISCORD_INVITE_URL', 'https://discord.com/invite/eliteroleplaytn'));
define('INSTAGRAM_URL', env('INSTAGRAM_URL', 'https://www.instagram.com/elite_roleplay_tn/'));
define('YOUTUBE_URL', env('YOUTUBE_URL', 'https://www.youtube.com/@Eliteroleplay_tn'));
define('TIKTOK_URL', env('TIKTOK_URL', 'https://www.tiktok.com/@eliteroleplay765'));
define('SITE_URL', env('SITE_URL', 'https://eliteroleplay.4.at'));
define('SERVER_OPEN', true); // Set to true when the server is officially launched
define('HIDE_COUNTDOWN', false); // Set to true to hide exact time with a glitch effect

// Secure Session Configuration
if (session_status() === PHP_SESSION_NONE) {
    // Prevent session fixation attacks
    ini_set('session.use_strict_mode', '1');
    
    // Prevent JavaScript access to session cookie (XSS protection)
    ini_set('session.cookie_httponly', '1');
    
    // Only send cookie over HTTPS (set to 1 in production)
    ini_set('session.cookie_secure', '1');
    
    // Prevent CSRF attacks via cookies
    ini_set('session.cookie_samesite', 'Lax');
    
    // Increase session security
    ini_set('session.use_only_cookies', '1');
    
    session_start();
}
?>
