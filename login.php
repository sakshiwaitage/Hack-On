<?php
session_start();
require 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_identifier = trim($_POST["user_identifier"]);
    $password = $_POST["password"];

    if (empty($user_identifier) || empty($password)) {
        header("Location: login.html"); // Redirect back to login if fields are empty
        exit();
    }

    // ✅ Check if input is an email or username
    if (filter_var($user_identifier, FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT id, username, email, password FROM users WHERE email = ?";
    } else {
        $query = "SELECT id, username, email, password FROM users WHERE username = ?";
    }

    // ✅ Prepare and execute SQL statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_identifier);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $email, $hashed_password);
        $stmt->fetch();

        // ✅ Verify Password
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;

            // ✅ Redirect to index.php immediately
            header("Location: index.php");
            exit();
        }
    }

    // Redirect back to login if credentials are incorrect
    header("Location: login.html");
    exit();

    $stmt->close();
    $conn->close();
}
?>
