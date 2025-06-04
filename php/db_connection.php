<?php
// db_connect.php
// This file establishes a connection to your MySQL database.

$servername = "localhost"; // Your database server name (e.g., 'localhost' or an IP address)
$username = "root";      // Your MySQL username
$password = "";          // Your MySQL password (often empty for local development)
$dbname = "college_cms"; // The name of the database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, stop script execution and display an error message
    die("Connection failed: " . $conn->connect_error);
}
?>
