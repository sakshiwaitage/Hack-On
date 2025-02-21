function saveScore(score, gameType) {
    let playerName = localStorage.getItem("playerName") || "Guest" + Math.floor(Math.random() * 1000);

    let formData = new FormData();
    formData.append("player_name", playerName);
    formData.append("score", score);
    formData.append("game_type", gameType);

    fetch("save_score.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error("Error:", error));
}
