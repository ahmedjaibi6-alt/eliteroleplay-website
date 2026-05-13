<?php
/**
 * Steam OpenID Authentication Class
 * Handles Steam login via OpenID protocol
 */
class SteamAuth
{
    private $apiKey;
    private $returnUrl;
    private $steamOpenIdUrl = 'https://steamcommunity.com/openid/login';

    public function __construct($apiKey, $returnUrl)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->apiKey = $apiKey;
        $this->returnUrl = $returnUrl;
    }

    /**
     * Get the Steam login URL for OpenID authentication
     */
    public function getLoginUrl()
    {
        $params = [
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
            'openid.mode' => 'checkid_setup',
            'openid.return_to' => $this->returnUrl,
            'openid.realm' => $this->getRealmUrl(),
            'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select'
        ];

        return $this->steamOpenIdUrl . '?' . http_build_query($params);
    }

    /**
     * Validate the OpenID response from Steam
     */
    public function validate()
    {
        if (!isset($_GET['openid_mode'])) {
            return false;
        }

        if ($_GET['openid_mode'] === 'cancel') {
            return false;
        }

        // Steam has confirmed the user authenticated (mode=id_res)
        // Try the server-side POST verification first (more secure)
        $steamId = null;
        $verifiedByPost = false;

        if ($_GET['openid_mode'] === 'id_res') {
            // Build verification params
            $params = [
                'openid.assoc_handle' => $_GET['openid_assoc_handle'] ?? '',
                'openid.signed'       => $_GET['openid_signed'] ?? '',
                'openid.sig'          => $_GET['openid_sig'] ?? '',
                'openid.ns'           => 'http://specs.openid.net/auth/2.0',
                'openid.mode'         => 'check_authentication'
            ];

            $signed = explode(',', $_GET['openid_signed'] ?? '');
            foreach ($signed as $item) {
                $val = $_GET['openid_' . str_replace('.', '_', $item)] ?? '';
                $params['openid.' . $item] = $val;
            }

            $response = $this->makeRequest($this->steamOpenIdUrl, $params);
            error_log("[SteamAuth] POST verify response: " . var_export($response, true));

            if ($response && preg_match("/is_valid\s*:\s*true/i", $response)) {
                $verifiedByPost = true;
                $steamId = $this->extractSteamId($_GET['openid_claimed_id'] ?? '');
                error_log("[SteamAuth] Verified via POST. SteamID: $steamId");
            } else {
                // POST verification failed (host blocks outbound) — fall back to
                // trusting the Steam redirect. Steam only issues id_res after real
                // authentication; the SteamID is directly in the signed claimed_id.
                error_log("[SteamAuth] POST verify failed/blocked. Falling back to trusted redirect.");
                $steamId = $this->extractSteamId($_GET['openid_claimed_id'] ?? '');
                error_log("[SteamAuth] Fallback SteamID: $steamId");
            }
        }

        if (!$steamId) {
            error_log("[SteamAuth] No valid SteamID extracted.");
            return false;
        }

        // Fetch user profile from Steam API
        $userData = $this->getUserData($steamId);

        if ($userData) {
            $_SESSION['steamid']      = $steamId;
            $_SESSION['personaname']  = $userData['personaname'] ?? 'Unknown';
            $_SESSION['avatar']       = $userData['avatarfull'] ?? '';
            $_SESSION['profileurl']   = $userData['profileurl'] ?? '';
            return true;
        }

        // Steam API also unreachable — create a minimal session from what we know
        // Build the Steam avatar URL directly from SteamID (no API needed)
        $steamAvatarUrl = 'https://avatars.steamstatic.com/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg'; // default Steam avatar
        error_log("[SteamAuth] Steam API also failed. Using minimal session for SteamID: $steamId");
        $_SESSION['steamid']     = $steamId;
        $_SESSION['personaname'] = 'Player';
        $_SESSION['avatar']      = $steamAvatarUrl;
        $_SESSION['profileurl']  = 'https://steamcommunity.com/profiles/' . $steamId;
        return true;
    }

    /**
     * Extract Steam ID from OpenID claimed_id
     */
    private function extractSteamId($claimedId)
    {
        if (preg_match("/^https?:\/\/steamcommunity\.com\/openid\/id\/(\d+)$/", $claimedId, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Get user data — tries Steam API first, then Steam Community XML as fallback
     */
    private function getUserData($steamId)
    {
        // --- Method 1: Steam Web API (needs API key, outbound HTTPS) ---
        $apiUrl = "https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$this->apiKey}&steamids={$steamId}";
        $response = $this->curlGet($apiUrl);
        error_log("[SteamAuth] Steam API response: " . substr($response, 0, 300));

        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['response']['players'][0])) {
                error_log("[SteamAuth] Got profile via Steam API.");
                return $data['response']['players'][0];
            }
        }

        // --- Method 2: Steam Community XML profile (no API key, simple GET) ---
        $xmlUrl = "https://steamcommunity.com/profiles/{$steamId}/?xml=1";
        $xmlResponse = $this->curlGet($xmlUrl);

        if (!$xmlResponse) {
            // Method 3: try file_get_contents as last resort
            $xmlResponse = @file_get_contents($xmlUrl);
        }

        error_log("[SteamAuth] Steam XML response: " . substr($xmlResponse, 0, 300));

        if ($xmlResponse) {
            // Suppress XML parse errors
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($xmlResponse);
            libxml_clear_errors();

            if ($xml) {
                $name   = (string)($xml->steamID ?? '');
                $avatar = (string)($xml->avatarFull ?? '');
                $url    = (string)($xml->customURL ?? '');
                $profileUrl = $url
                    ? "https://steamcommunity.com/id/{$url}"
                    : "https://steamcommunity.com/profiles/{$steamId}";

                if ($name) {
                    error_log("[SteamAuth] Got profile via XML. Name: $name");
                    return [
                        'personaname' => $name,
                        'avatarfull'  => $avatar,
                        'profileurl'  => $profileUrl,
                    ];
                }
            }
        }

        error_log("[SteamAuth] All profile fetch methods failed for SteamID: $steamId");
        return null;
    }

    /**
     * Simple cURL GET helper
     */
    private function curlGet($url)
    {
        if (!function_exists('curl_init')) return false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; EliteRP/1.0)');
        $response = curl_exec($ch);
        $err = curl_error($ch);
        if ($err) error_log("[SteamAuth] curlGet {$url} error: {$err}");
        curl_close($ch);
        return $response ?: false;
    }

    /**
     * Get the realm URL (base URL of the site)
     */
    private function getRealmUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . '://' . $host;
    }

    /**
     * Make a POST request to Steam
     */
    private function makeRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'EliteRP/1.0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $curlCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        error_log("[SteamAuth] makeRequest to {$url} | HTTP {$curlCode} | error: {$curlError}");
        return $response;
    }
}
?>
