<?php
// Database connection variables
$host = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "gold_bank";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
