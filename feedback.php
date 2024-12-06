<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit feedback.");
}

$user_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // SQL query to insert feedback (No update to users table)
    $sql = "INSERT INTO feedback (user_id, name, email, subject, message) 
            VALUES ('$user_id', '$name', '$email', '$subject', '$message')";

    // Execute query and check if successful
    if ($conn->query($sql) === TRUE) {
        echo "Feedback submitted successfully. <a href='user.html'>Back to Home</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>