<?php
session_start(); // Start the session
require 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_identifier = trim($_POST["user_identifier"]); // Can be email or username
    $password = $_POST["password"];

    // ✅ Validate Inputs
    if (empty($user_identifier) || empty($password)) {
        echo json_encode(["success" => false, "message" => "All fields are required!"]);
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
            // Store session variables
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            
            // ✅ Return success response with redirection
            echo json_encode(["success" => true, "redirect" => "index.php"]);
            exit();
        } else {
            echo json_encode(["success" => false, "message" => "Invalid password!"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found!"]);
    }

    $stmt->close();
    $conn->close();
}
?>
