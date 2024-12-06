<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to delete feedback.");
}

$user_id = $_SESSION['user_id'];
$feedback_id = $_GET['id'];

// Delete the feedback
$sql = "DELETE FROM feedback WHERE id = '$feedback_id' AND user_id = '$user_id'";

if ($conn->query($sql) === TRUE) {
    echo "Feedback deleted successfully. <a href='user_dashboard.php'>Back to Dashboard</a>";
} else {
    echo "Error: " . $conn->error;
}
?>
