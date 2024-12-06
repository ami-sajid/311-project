<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to edit feedback.");
}

$user_id = $_SESSION['user_id'];
$feedback_id = $_GET['id'];

// Fetch the feedback data
$sql = "SELECT * FROM feedback WHERE id = '$feedback_id' AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Feedback not found.");
}

$row = $result->fetch_assoc();

// Handle form submission to update feedback
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "UPDATE feedback SET subject = '$subject', message = '$message' WHERE id = '$feedback_id' AND user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Feedback updated successfully. <a href='user_dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Your Feedback</h2>
        <form method="POST">
            <label for="subject">Subject:</label><br>
            <input type="text" id="subject" name="subject" value="<?php echo $row['subject']; ?>" required><br><br>

            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="4" required><?php echo $row['message']; ?></textarea><br><br>

            <button type="submit" class="btn">Update Feedback</button>
        </form>
    </div>
</body>
</html>
