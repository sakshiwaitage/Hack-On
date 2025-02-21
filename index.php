<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocabulary Learning Platform</title>
    <link rel="stylesheet" href="indexstyle.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <ul>
            <!-- Logo on the left -->
            <li class="logo">
                <img src="https://img.icons8.com/?size=100&id=N4VuU_HmGhBq&format=png&color=ffffff" width="40px">
                <span>Vocabulary Learning Platform</span>
            </li>

            <!-- Empty space to push items right -->
            <li class="spacer"></li>

            <!-- Navigation Links shifted to the right -->
            <li><a href="quizzes.php">Quizzes</a></li>
            <li class="dropdown">
                <a href="puzzles.php">Puzzles ▼</a>
                <ul class="dropdown-menu">
                    <li><a href="puzzle1.php">Science</a></li>
                    <li><a href="puzzle2.php">Business</a></li>
                    <li><a href="puzzle3.php">Everyday Language</a></li>
                </ul>
            </li>
            <li><a href="challenges.php">Challenges</a></li>
            <li><a href="leaderboard.php">Leaderboard</a></li>

            <!-- Logout Button -->
            <li class="right"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Introduction Section -->
    <section class="hero">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>Complete challenges, solve puzzles, and take quizzes to become a vocab master.</p>
        <a href="#challenges" class="cta">Get Started</a>
    </section>

    <section class="features">
        <div class="feature">
            <h2>Challenges</h2>
            <p>Engage in exciting word challenges to test and enhance your vocabulary.</p>
        </div>
        <div class="feature">
            <h2>Quizzes</h2>
            <p>Take interactive quizzes to solidify your word knowledge in a fun way.</p>
        </div>
        <div class="feature">
            <h2>Puzzles</h2>
            <p>Solve word puzzles that push your language skills to the next level.</p>
        </div>
        <div class="feature">
            <h2>Leaderboard</h2>
            <p>Compete with others and climb the leaderboard as you master new words.</p>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
