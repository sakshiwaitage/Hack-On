<?php
header("Content-Type: application/json");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_game";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$action = $_GET['action'] ?? '';

if ($action == "save_score") {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $conn->real_escape_string($data['username']);
    $score = (int)$data['score'];
    $query = "INSERT INTO scores (username, score) VALUES ('$username', '$score')";
    $conn->query($query);
    echo json_encode(["message" => "Score saved successfully"]);
}

if ($action == "get_leaderboard") {
    $result = $conn->query("SELECT username, MAX(score) as high_score FROM scores GROUP BY username ORDER BY high_score DESC LIMIT 10");
    $leaderboard = [];
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
    echo json_encode($leaderboard);
}

if ($action == "get_badge") {
    $username = $conn->real_escape_string($_GET['username']);
    $result = $conn->query("SELECT MAX(score) as high_score FROM scores WHERE username='$username'");
    $row = $result->fetch_assoc();
    $highScore = (int)$row['high_score'];
    $badge = "";
    if ($highScore >= 100) $badge = "🏆 Master";
    elseif ($highScore >= 50) $badge = "🥈 Expert";
    elseif ($highScore >= 20) $badge = "🥉 Beginner";
    echo json_encode(["badge" => $badge]);
}
$conn->close();
?>
