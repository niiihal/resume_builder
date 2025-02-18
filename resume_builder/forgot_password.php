<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $token = bin2hex(random_bytes(50)); // Generate unique token
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expires in 1 hour

        // Store token in database
        $stmt = $conn->prepare("UPDATE users SET reset_token=?, reset_expiry=? WHERE email=?");
        $stmt->bind_param("sss", $token, $expiry, $email);
        $stmt->execute();

        // Send reset link (simulate sending email)
        $resetLink = "http://localhost/resume_builder/reset_password.php?token=$token";
        echo "Password reset link: <a href='$resetLink'>$resetLink</a>";
    } else {
        echo "No account found with this email!";
    }

    $stmt->close();
    $conn->close();
}
