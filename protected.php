<?php
session_start([
    'cookie_lifetime' => 86400, // Session cookie lasts for 1 day
    'cookie_secure' => true,    // Use secure cookies (HTTPS only)
    'cookie_httponly' => true, // Prevent JavaScript access to cookies
    'use_strict_mode' => true, // Prevent session fixation attacks
    ]);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not authenticated
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Protected Page</title>
</head>
<body>
    <h2>Welcome to the Protected Page</h2>
    <p>You are logged in!</p>
    <a href="logout.php">Logout</a>
</body>
</html>