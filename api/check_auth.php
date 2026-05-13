<?php
require_once '../config.php';

header('Content-Type: application/json');

// Return user authentication status
if (isLoggedIn()) {
    $userData = getUserData();
    echo json_encode([
        'authenticated' => true,
        'user' => $userData
    ]);
} else {
    echo json_encode([
        'authenticated' => false
    ]);
}
?>
