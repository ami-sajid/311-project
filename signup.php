<?php
// Include the database connection
include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $full_name = $conn->real_escape_string($_POST['full-name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $account_type = $conn->real_escape_string($_POST['account-type']);
    $password = $conn->real_escape_string($_POST['password']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert user data
    $sql = "INSERT INTO users (full_name, email, phone, address, account_type, password)
            VALUES ('$full_name', '$email', '$phone', '$address', '$account_type', '$hashed_password')";

    // Execute the query and handle errors
    if ($conn->query($sql) === TRUE) {
        echo "Account created successfully! <a href='signin.html'>Sign in here</a>";
    } else {
        echo "Error: " . $conn->error;
    }
    
    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
