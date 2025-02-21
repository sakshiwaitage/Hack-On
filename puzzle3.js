document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("theme-title").innerText = "🏠 Everyday Vocabulary Crossword";

    const crosswordGrid = [
        ["T", "A", "B", "L", "E"],
        ["", "", "", "", ""],
        ["P", "H", "O", "N", "E"],
        ["", "", "", "", ""],
        ["C", "L", "O", "C", "K"],
        ["", "", "", "", ""]
    ];

    const clues = [
        { number: 1, clue: "A piece of furniture with legs used for eating or working (5 letters)", answer: "TABLE" },
        // { number: 2, clue: "You sit on this (5 letters)", answer: "CHAIR" },
        { number: 2, clue: "A device used to call or text people (5 letters)", answer: "PHONE" },
        // { number: 4, clue: "It tells time (5 letters)", answer: "CLOCK" },
        { number: 3, clue: "A common food made from flour (5 letters)", answer: "BREAD" }
    ];

    generateCrossword(crosswordGrid, clues);
});




function generateCrossword(crosswordGrid, clues) {
    const crosswordContainer = document.getElementById("crossword-container");
    const clueList = document.getElementById("clue-list");
    
    // Clear previous content
    crosswordContainer.innerHTML = "";
    clueList.innerHTML = "";

    // Generate crossword grid
    const inputs = [];
    crosswordGrid.forEach((row, rowIndex) => {
        row.forEach((cell, colIndex) => {
            const input = document.createElement("input");
            input.type = "text";
            input.classList.add("cell");
            input.maxLength = 1;
            input.dataset.row = rowIndex;
            input.dataset.col = colIndex;
            
            if (cell) {
                input.dataset.answer = cell;
                inputs.push(input);
            } else {
                input.disabled = true;
            }

            crosswordContainer.appendChild(input);
        });
    });

    // Add clues
    clues.forEach(clue => {
        const li = document.createElement("li");
        li.textContent = `${clue.number}. ${clue.clue}`;
        clueList.appendChild(li);
    });

    // Auto-move to next input box when typing
    inputs.forEach((input, index) => {
        input.addEventListener("input", (e) => {
            if (e.target.value.length === 1) {
                if (inputs[index + 1]) {
                    inputs[index + 1].focus();
                }
            }
        });

        // Move back on Backspace
        input.addEventListener("keydown", (e) => {
            if (e.key === "Backspace" && e.target.value === "") {
                if (inputs[index - 1]) {
                    inputs[index - 1].focus();
                }
            }
        });
    });

    // Check answers
    document.getElementById("check-button").addEventListener("click", () => {
        let allCorrect = true;

        inputs.forEach(cell => {
            if (!cell.disabled) {
                if (cell.value.toUpperCase() === cell.dataset.answer) {
                    cell.style.backgroundColor = "#90ee90"; // Green for correct
                } else {
                    cell.style.backgroundColor = "#ffcccb"; // Red for incorrect
                    allCorrect = false;
                }
            }
        });

        if (allCorrect) {
            document.getElementById("result-message").innerHTML = "🎉 <b>Congratulations!</b> 🎉<br>You Passed the Test!";
            document.getElementById("result-message").style.display = "block";
        } else {
            document.getElementById("result-message").style.display = "none";
        }
    });
}
