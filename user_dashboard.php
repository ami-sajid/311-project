<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view your dashboard.");
}

$user_id = $_SESSION['user_id'];

// Fetch the user's information (name and email)
$sql_user = "SELECT full_name, email FROM users WHERE user_id = '$user_id'";
$user_result = $conn->query($sql_user);

if ($user_result->num_rows == 0) {
    die("User not found.");
}

$user_row = $user_result->fetch_assoc();
$user_name = $user_row['full_name'];
$user_email = $user_row['email'];

// Fetch the feedback submitted by the logged-in user
$sql_feedback = "SELECT * FROM feedback WHERE user_id = '$user_id'";
$feedback_result = $conn->query($sql_feedback);

// Check if the email update form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_email'])) {
    $new_email = $_POST['new_email'];

    // Validate the email format
    if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        // Update the user's email in the database
        $sql_update_email = "UPDATE users SET email = '$new_email' WHERE user_id = '$user_id'";

        if ($conn->query($sql_update_email) === TRUE) {
            // Success message
            $user_email = $new_email;  // Update the email in the session
            $email_update_success = "Email updated successfully!";
        } else {
            // Error message
            $email_update_error = "Error updating email: " . $conn->error;
        }
    } else {
        $email_update_error = "Invalid email format.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
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

        .user-info {
            margin-bottom: 30px;
            text-align: center;
        }

        .user-info p {
            margin: 5px 0;
            color: #555;
        }

        .feedback-item {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .feedback-item:last-child {
            border-bottom: none;
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

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-back {
            margin-top: 20px;
            display: inline-block;
            background-color: #6c757d;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        .form-container {
            margin-top: 30px;
            text-align: center;
        }

        .form-container input {
            padding: 10px;
            width: 250px;
            margin-right: 10px;
            font-size: 16px;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        .error, .success {
            text-align: center;
            color: white;
            padding: 10px;
            margin-top: 20px;
        }

        .error {
            background-color: #dc3545;
        }

        .success {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Dashboard</h2>

        <div class="user-info">
            <p><strong>Name:</strong> <?php echo $user_name; ?></p>
            <p><strong>Email:</strong> <?php echo $user_email; ?></p>
        </div>

        <h3>Your Feedback</h3>

        <?php if ($feedback_result->num_rows > 0): ?>
            <?php while($row = $feedback_result->fetch_assoc()): ?>
                <div class="feedback-item">
                    <p><strong>Subject:</strong> <?php echo $row['subject']; ?></p>
                    <p><strong>Message:</strong> <?php echo nl2br($row['message']); ?></p>
                    <a href="edit_feedback.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                    <a href="delete_feedback.php?id=<?php echo $row['id']; ?>" class="btn btn-delete">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No feedback found.</p>
        <?php endif; ?>

        <!-- Go back button -->
        <a href="user.html" class="btn btn-back">Go Back to User Page</a>

        <!-- Edit Email Form -->
        <div class="form-container">
            <h4>Change Your Email</h4>

            <!-- Show error or success message -->
            <?php if (isset($email_update_error)): ?>
                <div class="error"><?php echo $email_update_error; ?></div>
            <?php endif; ?>

            <?php if (isset($email_update_success)): ?>
                <div class="success"><?php echo $email_update_success; ?></div>
            <?php endif; ?>

            <!-- Email Update Form -->
            <form method="POST">
                <input type="email" name="new_email" placeholder="Enter new email" required value="<?php echo $user_email; ?>">
                <button type="submit">Update Email</button>
            </form>
        </div>
    </div>
</body>
</html>
