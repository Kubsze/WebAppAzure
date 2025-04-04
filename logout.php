<?php
session_start([
    'cookie_lifetime' => 86400, // Session cookie lasts for 1 day
    'cookie_secure' => true,    // Use secure cookies (HTTPS only)
    'cookie_httponly' => true, // Prevent JavaScript access to cookies
    'use_strict_mode' => true, // Prevent session fixation attacks
    ]); // Start the session

// Destroy the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session itself

// Redirect to the login page
header("Location: login.php");
exit;
?>