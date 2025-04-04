<?php
// Database configuration
$host = '127.0.0.1';
$db_name = 'user_auth';
$dbusername = 'root'; // Replace with your MySQL username
$dbpassword = 'mariadb';     // Replace with your MySQL password

// Create a new mysqli connection
$conn = new mysqli($host, $dbusername, $dbpassword, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, username, password_hash, created_at FROM users";
$result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     // Output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "ID: " . $row["id"] . " - Username: " . $row["username"] . " - hash: " . $row["password_hash"] . " - Created at: " . $row["created_at"]. "<br>";
//         echo "\n";
//     }
// } else {
//     echo "0 results";
// }
echo "Database connection successful!";
?>