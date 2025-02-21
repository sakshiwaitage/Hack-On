<?php
$servername = "localhost";
$username = "root";  // Change if you set a MySQL password
$password = "DBMS@123";      // Leave blank if no password
$database = "gamedb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully to MySQL!";
?>
