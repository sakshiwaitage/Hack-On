<?php
include 'db.php';

$game_type = $_GET['game_type'] ?? 'quiz'; // Default to quiz if not provided

$sql = "SELECT username, score, subject, difficulty, date_played FROM leaderboard WHERE game_type = ? ORDER BY score DESC LIMIT 10";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $game_type);
$stmt->execute();
$result = $stmt->get_result();

$leaderboard = [];
while ($row = $result->fetch_assoc()) {
    $leaderboard[] = $row;
}

echo json_encode($leaderboard);

$stmt->close();
$conn->close();
?>
