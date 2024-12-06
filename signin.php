<?php

include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to find user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['account_type'] = $row['account_type'];

            // Redirect to user dashboard
            header("Location: user.html");
        } else {
            echo "Incorrect password. <a href='signin.html'>Try Again</a>";
        }
    } else {
        echo "No account found with this email. <a href='signuppp.html'>Sign Up</a>";
    }
}
?>
