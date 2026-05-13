<?php
require_once '../../config.php';
require_once '../rate_limiter.php';

// Rate limiting
$rateLimiter = new RateLimiter(3, 600); // 3 applications per 10 minutes
$clientIP = getClientIP();

if (!$rateLimiter->isAllowed($clientIP, 'application_submit')) {
    $retryAfter = $rateLimiter->getRetryAfter($clientIP, 'application_submit');
    http_response_code(429);
    echo json_encode([
        'success' => false,
        'error' => 'Too many applications. Please wait ' . ceil($retryAfter / 60) . ' minutes.'
    ]);
    exit;
}

// Validate POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Sanitize and validate inputs
$discord_name = trim($_POST['discord_name'] ?? '');
$discord_id = trim($_POST['discord_id'] ?? '');
$steam_name = trim($_POST['steam_name'] ?? '');
$age = intval($_POST['age'] ?? 0);
$char_name = trim($_POST['char_name'] ?? '');
$char_ethnicity = trim($_POST['char_ethnicity'] ?? '');
$char_backstory = trim($_POST['char_backstory'] ?? '');
$char_objectives = trim($_POST['char_objectives'] ?? '');
$source = trim($_POST['source'] ?? '');
$reason = trim($_POST['reason'] ?? '');
$experience = trim($_POST['experience'] ?? '');

// Validation
$errors = [];

if (empty($discord_name)) {
    $errors[] = 'Discord username is required';
}

if (empty($discord_id)) {
    $errors[] = 'Discord ID is required';
} else if (!preg_match('/^\d{17,20}$/', $discord_id)) {
    $errors[] = 'Discord ID must be between 17 and 20 digits';
}

if (empty($steam_name)) {
    $errors[] = 'Steam name is required';
}

if ($age < 18 || $age > 99) {
    $errors[] = 'You must be 18 or older';
}

if (empty($char_name) || strlen($char_name) < 3) {
    $errors[] = 'Character name must be at least 3 characters';
}

if (empty($char_ethnicity)) {
    $errors[] = 'Character ethnicity is required';
}

if (empty($char_backstory) || strlen($char_backstory) < 30) {
    $errors[] = 'Please provide a more detailed backstory (minimum 30 characters)';
}

if (empty($char_objectives) || strlen($char_objectives) < 10) {
    $errors[] = 'Please describe your character objectives (minimum 10 characters)';
}

if (empty($source)) {
    $errors[] = 'Please tell us how you found us';
}

if (empty($reason) || strlen($reason) < 20) {
    $errors[] = 'Please provide a detailed reason (minimum 20 characters)';
}

if (empty($experience) || strlen($experience) < 10) {
    $errors[] = 'Please describe your roleplay experience (minimum 10 characters)';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Send to Discord Webhook
$webhookUrl = env('DISCORD_WEBHOOK_URL', '');
$progress = [
    'discord' => false,
    'database' => false,
    'sheets' => false
];

if (!empty($webhookUrl)) {
    $embed = [
        'title' => '📋 New Whitelist Application',
        'color' => hexdec('88DA22'),
        'fields' => [
            ['name' => 'Discord Username', 'value' => $discord_name, 'inline' => true],
            ['name' => 'Discord ID', 'value' => $discord_id, 'inline' => true],
            ['name' => 'Steam', 'value' => $steam_name, 'inline' => true],
            ['name' => 'Age', 'value' => $age, 'inline' => true],
            ['name' => 'Character Name', 'value' => $char_name, 'inline' => true],
            ['name' => 'Ethnicity', 'value' => $char_ethnicity, 'inline' => true],
            ['name' => 'Source', 'value' => $source, 'inline' => true],
            ['name' => 'Objectives', 'value' => substr($char_objectives, 0, 1024), 'inline' => false],
            ['name' => 'Backstory', 'value' => substr($char_backstory, 0, 1024), 'inline' => false],
            ['name' => 'Why Join?', 'value' => substr($reason, 0, 1024), 'inline' => false],
            ['name' => 'Experience', 'value' => substr($experience, 0, 1024), 'inline' => false]
        ],
        'footer' => ['text' => 'Elite Roleplay Applications'],
        'timestamp' => date('c')
    ];

    $data = ['embeds' => [$embed]];

    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 second timeout
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        $progress['discord'] = true;
    } else {
        error_log("Discord webhook failed: HTTP $httpCode - $response");
    }
}

// Optionally store in database
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("INSERT INTO applications (discord_name, discord_id, steam_name, age, character_name, char_ethnicity, char_backstory, char_objectives, source, reason, experience, submitted_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        
        if ($stmt) {
            $stmt->bind_param("sssisssssss", $discord_name, $discord_id, $steam_name, $age, $char_name, $char_ethnicity, $char_backstory, $char_objectives, $source, $reason, $experience);
            if ($stmt->execute()) {
                $progress['database'] = true;
            }
            $stmt->close();
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    error_log("Application DB insert failed: " . $e->getMessage());
}

// Log to Google Sheets
require_once '../google_sheets.php';

$sheetsMethod = env('GOOGLE_SHEETS_METHOD', 'webapp'); // 'api' or 'webapp'

if ($sheetsMethod === 'webapp') {
    // Method 1: Web App (Easier - Recommended)
    $webAppUrl = env('GOOGLE_SHEETS_WEBAPP_URL', '');
    
    if (!empty($webAppUrl)) {
        $sheetsLogger = new GoogleSheetsLogger('', '');
        $rowData = [
            date('Y-m-d H:i:s'), // Timestamp
            $discord_name,
            $discord_id,
            $steam_name,
            $age,
            $char_name,
            $char_ethnicity,
            $char_backstory,
            $char_objectives,
            $source,
            substr($reason, 0, 500), // Truncate for sheets
            substr($experience, 0, 500)
        ];
        
        $success = $sheetsLogger->appendViaWebApp($webAppUrl, $rowData);
        
        if ($success) {
            $progress['sheets'] = true;
        } else {
            error_log("Google Sheets Web App logging failed");
        }
    }
} else {
    // Method 2: Direct API (Requires API Key + Public Sheet)
    $spreadsheetId = env('GOOGLE_SHEETS_ID', '');
    $apiKey = env('GOOGLE_SHEETS_API_KEY', '');
    
    if (!empty($spreadsheetId) && !empty($apiKey)) {
        $sheetsLogger = new GoogleSheetsLogger($spreadsheetId, $apiKey);
        $rowData = [
            date('Y-m-d H:i:s'),
            $discord_name,
            $discord_id,
            $steam_name,
            $age,
            $char_name,
            $source,
            substr($reason, 0, 500),
            substr($experience, 0, 500)
        ];
        
        $success = $sheetsLogger->appendRow($rowData);
        
        if ($success) {
            $progress['sheets'] = true;
        } else {
            error_log("Google Sheets API logging failed");
        }
    }
}

echo json_encode([
    'success' => true,
    'message' => 'Application submitted successfully! We will review it and contact you on Discord.',
    'progress' => $progress
]);
?>
