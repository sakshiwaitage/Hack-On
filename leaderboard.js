function loadLeaderboard(gameType) {
    fetch(`php/leaderboard.php?game_type=${gameType}`)
        .then(response => response.json())
        .then(data => {
            let leaderboardHTML = "<h2>Leaderboard 🏆</h2><ol>";
            data.forEach((player, index) => {
                leaderboardHTML += `<li>${index + 1}. ${player.username} - ${player.score} pts (${player.subject} - ${player.difficulty})</li>`;
            });
            leaderboardHTML += "</ol>";
            document.getElementById("leaderboard").innerHTML = leaderboardHTML;
        })
        .catch(error => console.error("Error loading leaderboard:", error));
}

// Load leaderboard for quizzes by default
loadLeaderboard('quiz');
