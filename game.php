<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? "Guest"; // If no username, set as Guest
    $game_type = $_POST['game_type'];  // quiz, challenges, or puzzles
    $score = $_POST['score'];
    $subject = $_POST['subject'];
    $difficulty = $_POST['difficulty'];

    $stmt = $conn->prepare("INSERT INTO leaderboard (username, game_type, score, subject, difficulty, date_played) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssiss", $username, $game_type, $score, $subject, $difficulty);

    if ($stmt->execute()) {
        echo "Score saved!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
