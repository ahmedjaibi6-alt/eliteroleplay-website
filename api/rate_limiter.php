<?php
/**
 * Simple Rate Limiter
 * Prevents brute force attacks on authentication endpoints
 */

class RateLimiter {
    private $maxAttempts;
    private $timeWindow;
    private $storageFile;
    
    public function __construct($maxAttempts = 5, $timeWindow = 300) {
        $this->maxAttempts = $maxAttempts;
        $this->timeWindow = $timeWindow; // 5 minutes default
        $this->storageFile = sys_get_temp_dir() . '/rate_limit.json';
    }
    
    /**
     * Check if IP is rate limited
     * @param string $identifier (IP address or user ID)
     * @param string $action (e.g., 'login', 'discord_auth')
     * @return bool True if allowed, False if rate limited
     */
    public function isAllowed($identifier, $action = 'default') {
        $key = $this->getKey($identifier, $action);
        $data = $this->loadData();
        
        // Clean old entries
        $data = $this->cleanOldEntries($data);
        
        if (!isset($data[$key])) {
            $data[$key] = [
                'count' => 1,
                'first_attempt' => time()
            ];
            $this->saveData($data);
            return true;
        }
        
        $entry = $data[$key];
        $timePassed = time() - $entry['first_attempt'];
        
        // Reset if time window expired
        if ($timePassed > $this->timeWindow) {
            $data[$key] = [
                'count' => 1,
                'first_attempt' => time()
            ];
            $this->saveData($data);
            return true;
        }
        
        // Check if limit exceeded
        if ($entry['count'] >= $this->maxAttempts) {
            return false;
        }
        
        // Increment counter
        $data[$key]['count']++;
        $this->saveData($data);
        return true;
    }
    
    /**
     * Get remaining time until rate limit expires
     */
    public function getRetryAfter($identifier, $action = 'default') {
        $key = $this->getKey($identifier, $action);
        $data = $this->loadData();
        
        if (!isset($data[$key])) {
            return 0;
        }
        
        $timePassed = time() - $data[$key]['first_attempt'];
        $remaining = $this->timeWindow - $timePassed;
        
        return max(0, $remaining);
    }
    
    private function getKey($identifier, $action) {
        return md5($identifier . '_' . $action);
    }
    
    private function loadData() {
        if (!file_exists($this->storageFile)) {
            return [];
        }
        
        $content = file_get_contents($this->storageFile);
        return json_decode($content, true) ?: [];
    }
    
    private function saveData($data) {
        file_put_contents($this->storageFile, json_encode($data));
    }
    
    private function cleanOldEntries($data) {
        $now = time();
        foreach ($data as $key => $entry) {
            if (($now - $entry['first_attempt']) > $this->timeWindow) {
                unset($data[$key]);
            }
        }
        return $data;
    }
}

/**
 * Helper function to get client IP
 */
function getClientIP() {
    // In production behind a proxy (like Cloudflare), use the specific header.
    // Otherwise, always trust REMOTE_ADDR first to prevent spoofing.
    
    // Cloudflare Check
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    
    // Fallback to REMOTE_ADDR (Most secure if not behind a proxy)
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    }

    // Optional: Handle other proxies only if you know they are reliable
    $ipHeaders = [
        'HTTP_X_REAL_IP',
        'HTTP_X_FORWARDED_FOR'
    ];
    
    foreach ($ipHeaders as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = $_SERVER[$header];
            if (strpos($ip, ',') !== false) {
                $ips = explode(',', $ip);
                $ip = trim($ips[0]);
            }
            return $ip;
        }
    }
    
    return '0.0.0.0';
}
?>
