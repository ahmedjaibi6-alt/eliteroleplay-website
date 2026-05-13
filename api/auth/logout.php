<?php
require_once '../../config.php';

session_unset();
session_destroy();

// Redirect back to homepage
header("Location: ../../index.php");
exit;
?>
