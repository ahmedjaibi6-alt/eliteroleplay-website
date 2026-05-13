<?php
/**
 * Google Sheets Integration for Elite RP
 * Logs application data to a Google Sheet
 */

class GoogleSheetsLogger {
    private $spreadsheetId;
    private $apiKey;
    
    public function __construct($spreadsheetId, $apiKey) {
        $this->spreadsheetId = $spreadsheetId;
        $this->apiKey = $apiKey;
    }
    
    /**
     * Append a row to the Google Sheet
     * @param array $data Array of values to append
     * @return bool Success status
     */
    public function appendRow($data) {
        // Using Google Sheets API v4 with API Key (simpler than OAuth for append-only)
        // Note: Sheet must be publicly editable or use Service Account
        
        $range = 'Applications!A:Z'; // Adjust sheet name if needed
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}/values/{$range}:append";
        
        $params = [
            'valueInputOption' => 'USER_ENTERED',
            'key' => $this->apiKey
        ];
        
        $body = [
            'values' => [$data]
        ];
        
        $ch = curl_init($url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        } else {
            error_log("Google Sheets API Error: HTTP $httpCode - $response");
            return false;
        }
    }
    
    /**
     * Alternative: Use Web App deployment (recommended for easier setup)
     * Requires deploying a Google Apps Script as a Web App
     */
    public function appendViaWebApp($webAppUrl, $data) {
        $ch = curl_init();
        $payload = json_encode(['data' => $data]);
        
        // Sending as a form parameter is much more reliable with Google redirects
        $postData = http_build_query(['json_payload' => $payload]);
        
        curl_setopt($ch, CURLOPT_URL, $webAppUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        
        // Bypass SSL for some environments
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            error_log("Google Sheets cURL Error: " . $error);
            return false;
        }
        
        return ($httpCode >= 200 && $httpCode < 400);
    }
}
?>
