<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'])) {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Check if token is valid and not expired
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token=? AND reset_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Update password and clear token
        $stmt = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, reset_expiry=NULL WHERE id=?");
        $stmt->bind_param("si", $new_password, $user_id);
        $stmt->execute();

        echo "Password reset successful! Redirecting to login...";
        header("refresh:3; url=login.html");
        header("Location: login.html?reset=success"); // Redirect to login after 3 seconds
        exit();
    } else {
        echo "Invalid or expired token!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: #f4f4f9;
        }

        .container {
            width: 40%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: auto;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            background: #ffcc00;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background: #e6b800;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? ''; ?>">
            <input type="password" name="new_password" placeholder="Enter new password" required>
            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
</body>

</html>