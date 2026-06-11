<?php
// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "event_platform";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8mb4");
?>