document.addEventListener("DOMContentLoaded", function () {
    console.log("Script Loaded Successfully!");

    // Ensure dropdowns work
    const dropdowns = document.querySelectorAll(".dropdown");
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener("click", function () {
            this.classList.toggle("active");
        });
    });

    // Redirect 'Get Started' button to challenges
    const ctaButton = document.querySelector(".cta");
    if (ctaButton) {
        ctaButton.addEventListener("click", function () {
            window.location.href = "challenge.php"; // Ensure this exists
        });
    }

    // Ensure leaderboard is visible if logged in
    if (document.querySelector("li a[href='leaderboard.php']")) {
        console.log("Leaderboard Link Available");
    }
});
