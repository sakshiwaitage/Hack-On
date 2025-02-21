document.addEventListener("DOMContentLoaded", () => {
    const crosswordGrid = [
        ["A", "P", "P", "L", "E"],
        ["", "", "", "", ""],
        ["G", "R", "A", "P", "E"],
        ["", "", "", "", ""],
        ["M", "A", "N", "G", "O"]
    ];

    const clues = [
        { number: 1, clue: "A red fruit (5 letters)", answer: "APPLE" },
        { number: 2, clue: "A purple fruit (5 letters)", answer: "GRAPE" },
        { number: 3, clue: "A tropical fruit (5 letters)", answer: "MANGO" }
    ];

    const crosswordContainer = document.getElementById("crossword-container");
    const clueList = document.getElementById("clue-list");

    // Create a result message element
    const resultMessage = document.createElement("div");
    resultMessage.id = "result-message";
    resultMessage.style.display = "none"; // Initially hidden
    document.body.appendChild(resultMessage);

    // Generate the crossword grid
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
                // Move to next input if exists
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

        document.querySelectorAll(".cell").forEach(cell => {
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
            resultMessage.innerHTML = "🎉 <b>Congratulations!</b> 🎉<br>You Passed the Test!";
            resultMessage.style.display = "block";
            resultMessage.style.fontSize = "30px";
            resultMessage.style.fontWeight = "bold";
            resultMessage.style.color = "green";
            resultMessage.style.marginTop = "20px";
        } else {
            resultMessage.style.display = "none"; // Hide message if not fully correct
        }
    });
});
