<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>Register</h2>
           <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
<?php
   // Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // Remove extra spaces
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    if (strlen($username) < 3 || strlen($username) > 50) {
        die("Username must be between 3 and 50 characters.");
    }

    if (strlen($password) < 6) {
        die("Password must be at least 6 characters long.");
    }
}
echo "$username $password";
// Hash the password securely
$password_hash = password_hash($password, PASSWORD_DEFAULT);

if (!$password_hash) {
    die("Password hashing failed.");
}

// Include the database connection file
require 'db_connection.php';

// Prepare and execute the SQL statement
$stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password_hash);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
       }

$stmt->close();
$conn->close();
?>