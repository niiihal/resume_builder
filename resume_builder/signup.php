<?php
include 'db.php'; // Connect to database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo "Email already exists! Try logging in.";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Sign Up Successful! Redirecting...";
            header("refresh:2; url=login.html"); // Redirect to login page after 2 seconds
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $check_email->close();
    $conn->close();
}
