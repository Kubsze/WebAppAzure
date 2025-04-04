<?php
ob_start();
session_start([
    'cookie_lifetime' => 86400, // Session cookie lasts for 1 day
    'cookie_secure' => true,    // Use secure cookies (HTTPS only)
    'cookie_httponly' => true, // Prevent JavaScript access to cookies
    'use_strict_mode' => true, // Prevent session fixation attacks
    ]); // Start the session

// Initialize variables for feedback messages
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        $error_message = "Please fill in all required fields.";
    } else {
        // Include the database connection file
        require 'db_connection.php';

        // Prepare and execute the SQL statement to fetch the user
        $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password_hash'])) {
                // Password is correct
                $_SESSION['user_id'] = $user['id']; // Store user ID in session
                $success_message = "Login successful!";
                header("Location: protected.php"); // Redirect to protected page
                ob_flush();
                exit;
            } else {
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Invalid username or password.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
