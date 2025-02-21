<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        .success-message {
            font-size: 18px;
            font-weight: bold;
            color: green;
        }
        .error-message {
            color: red;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
require 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // ✅ Validate Inputs
    if (empty($username) || empty($email) || empty($_POST["password"])) {
        echo "<p class='error-message'>All fields are required!</p>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='error-message'>Invalid email format!</p>";
        exit();
    }

    // ✅ Insert User Data
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<p class='success-message'>Signup successful! Redirecting to login page...</p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'login.html';
                }, 2000);
              </script>";
    } else {
        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
