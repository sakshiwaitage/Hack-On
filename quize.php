<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_game";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['subject']) && isset($_GET['difficulty'])) {
    $subject = $_GET['subject'];
    $difficulty = $_GET['difficulty'];
    
    $sql = "SELECT id, question, option1, option2, option3, correct_answer FROM questions WHERE subject = ? AND difficulty = ? ORDER BY RAND() LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $subject, $difficulty);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = [
            "question" => $row['question'],
            "options" => [$row['option1'], $row['option2'], $row['option3']],
            "answer" => $row['correct_answer']
        ];
    }
    
    echo json_encode($questions);
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];
    $subject = $data['subject'];
    $difficulty = $data['difficulty'];
    $score = $data['score'];
    
    $sql = "INSERT INTO scores (username, subject, difficulty, score) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $subject, $difficulty, $score);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Score saved successfully!"]);
    } else {
        echo json_encode(["error" => "Error saving score."]);
    }
    $stmt->close();
}

$conn->close();
?>
