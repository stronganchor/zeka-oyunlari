<?php
/**
 * Rule Guess Puzzle Game Module
 * A puzzle game where players discover hidden rules through experimentation
 */

return [
    'name' => 'Rule Guess Puzzle',
    'description' => 'Rule Guess Puzzle is an engaging puzzle game where players must discover hidden rules through experimentation. Start with simple patterns and progress to more complex ones. Test different inputs, observe results, and unlock the secret rules!',
    'category' => 'Puzzle',
    'difficulty' => 'Medium',
    'inline_style' => '
        <style>
            .rule-guess-container {
                max-width: 700px;
                margin: 0 auto;
                padding: 20px;
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 12px;
                color: white;
            }
            .rule-guess-header {
                text-align: center;
                margin-bottom: 30px;
            }
            .rule-guess-description {
                background: rgba(255, 255, 255, 0.1);
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
                border-left: 4px solid #ffd700;
                backdrop-filter: blur(10px);
            }
            .level-section {
                text-align: center;
                margin-bottom: 20px;
            }
            .level-btn {
                padding: 8px 16px;
                margin: 0 5px;
                background: rgba(255, 255, 255, 0.2);
                color: white;
                border: 2px solid white;
                border-radius: 20px;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.3s;
            }
            .level-btn.active {
                background: #ffd700;
                color: #333;
            }
            .level-btn:hover {
                background: rgba(255, 255, 255, 0.3);
            }
            .input-section {
                margin-bottom: 20px;
            }
            .input-group {
                display: flex;
                gap: 10px;
                margin-bottom: 10px;
                align-items: center;
                justify-content: center;
            }
            .input-field {
                padding: 12px;
                border: 2px solid #ddd;
                border-radius: 25px;
                font-size: 16px;
                width: 200px;
                text-align: center;
                background: white;
                color: #333;
            }
            .test-btn {
                padding: 12px 24px;
                background: #ffd700;
                color: #333;
                border: none;
                border-radius: 25px;
                cursor: pointer;
                font-size: 16px;
                font-weight: bold;
                transition: all 0.3s;
            }
            .test-btn:hover {
                background: #ffed4e;
                transform: scale(1.05);
            }
            .results-section {
                margin-top: 20px;
            }
            .result-item {
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(255, 255, 255, 0.3);
                padding: 12px;
                margin-bottom: 8px;
                border-radius: 8px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                color: #333;
                animation: fadeIn 0.5s;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .result-input {
                font-weight: bold;
                color: #333;
            }
            .result-output.correct {
                color: #27ae60;
                font-weight: bold;
            }
            .result-output.incorrect {
                color: #e74c3c;
                font-weight: bold;
            }
            .hint-section {
                margin-top: 30px;
                padding: 15px;
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 8px;
                backdrop-filter: blur(10px);
            }
            .hint-btn {
                padding: 10px 20px;
                background: #f39c12;
                color: white;
                border: none;
                border-radius: 20px;
                cursor: pointer;
                margin-top: 10px;
                transition: all 0.3s;
            }
            .hint-btn:hover {
                background: #e67e22;
            }
            .hint-text {
                margin-top: 10px;
                display: none;
                color: #fff3cd;
                font-style: italic;
            }
            .win-message {
                text-align: center;
                color: #ffd700;
                font-size: 20px;
                font-weight: bold;
                margin-top: 20px;
                display: none;
                animation: bounce 1s infinite;
            }
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }
            .progress-bar {
                width: 100%;
                height: 10px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 5px;
                margin-bottom: 10px;
                overflow: hidden;
            }
            .progress-fill {
                height: 100%;
                background: #ffd700;
                width: 0%;
                transition: width 0.5s;
            }
        </style>
    ',
    'inline_script' => '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const inputField = document.getElementById("rule-input");
                const testBtn = document.getElementById("test-btn");
                const resultsList = document.getElementById("results-list");
                const hintBtn = document.getElementById("hint-btn");
                const hintText = document.getElementById("hint-text");
                const winMessage = document.getElementById("win-message");
                const levelBtns = document.querySelectorAll(".level-btn");
                const progressFill = document.querySelector(".progress-fill");

                let currentLevel = 1;
                let attempts = 0;
                const maxAttempts = 15;

                const levels = {
                    1: {
                        rule: "sum of digits equals 10",
                        description: "Find numbers where the sum of their digits equals 10",
                        examples: [19, 28, 37, 46, 55, 64, 73, 82, 91]
                    },
                    2: {
                        rule: "number is a perfect square",
                        description: "Find perfect square numbers",
                        examples: [1, 4, 9, 16, 25, 36, 49, 64, 81, 100]
                    },
                    3: {
                        rule: "number is prime",
                        description: "Find prime numbers",
                        examples: [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97]
                    }
                };

                function isPrime(num) {
                    if (num <= 1) return false;
                    if (num <= 3) return true;
                    if (num % 2 === 0 || num % 3 === 0) return false;
                    for (let i = 5; i * i <= num; i += 6) {
                        if (num % i === 0 || num % (i + 2) === 0) return false;
                    }
                    return true;
                }

                function calculateDigitSum(num) {
                    return num.toString().split("").reduce((sum, digit) => sum + parseInt(digit), 0);
                }

                function testInput(input, level) {
                    const num = parseInt(input);
                    if (isNaN(num) || num < 0 || num > 999) {
                        return { result: "Invalid input (use 0-999)", correct: false };
                    }

                    let correct = false;
                    let explanation = "";

                    switch(level) {
                        case 1:
                            const sum = calculateDigitSum(num);
                            correct = sum === 10;
                            explanation = correct ? "✓ Correct! Sum of digits: " + sum : "✗ Incorrect. Sum of digits: " + sum;
                            break;
                        case 2:
                            const sqrt = Math.sqrt(num);
                            correct = sqrt === Math.floor(sqrt);
                            explanation = correct ? "✓ Correct! √" + num + " = " + sqrt : "✗ Incorrect. Not a perfect square";
                            break;
                        case 3:
                            correct = isPrime(num);
                            explanation = correct ? "✓ Correct! " + num + " is prime" : "✗ Incorrect. " + num + " is not prime";
                            break;
                    }

                    return { result: explanation, correct: correct };
                }

                function updateProgress() {
                    const results = resultsList.querySelectorAll(".result-output");
                    let correctCount = 0;
                    results.forEach(result => {
                        if (result.classList.contains("correct")) {
                            correctCount++;
                        }
                    });
                    const progress = Math.min((correctCount / 5) * 100, 100);
                    progressFill.style.width = progress + "%";

                    if (correctCount >= 5) {
                        setTimeout(() => {
                            winMessage.textContent = "🎉 Level " + currentLevel + " Complete! Rule: " + levels[currentLevel].rule;
                            winMessage.style.display = "block";
                            if (currentLevel < 3) {
                                setTimeout(() => {
                                    changeLevel(currentLevel + 1);
                                }, 3000);
                            }
                        }, 500);
                    }
                }

                function changeLevel(level) {
                    currentLevel = level;
                    attempts = 0;
                    resultsList.innerHTML = "";
                    winMessage.style.display = "none";
                    hintText.style.display = "none";
                    progressFill.style.width = "0%";

                    levelBtns.forEach(btn => btn.classList.remove("active"));
                    document.querySelector(`[data-level="${level}"]`).classList.add("active");

                    const levelDesc = document.querySelector(".level-description");
                    levelDesc.textContent = levels[level].description;
                }

                levelBtns.forEach(btn => {
                    btn.addEventListener("click", function() {
                        const level = parseInt(this.dataset.level);
                        changeLevel(level);
                    });
                });

                testBtn.addEventListener("click", function() {
                    const input = inputField.value.trim();
                    if (!input) return;

                    attempts++;
                    const testResult = testInput(input, currentLevel);

                    const resultItem = document.createElement("div");
                    resultItem.className = "result-item";
                    resultItem.innerHTML = `
                        <span class="result-input">Input: ${input}</span>
                        <span class="result-output ${testResult.correct ? 'correct' : 'incorrect'}">${testResult.result}</span>
                    `;
                    resultsList.appendChild(resultItem);

                    inputField.value = "";
                    updateProgress();

                    if (attempts >= maxAttempts && !winMessage.style.display) {
                        hintText.textContent = "Hint: " + levels[currentLevel].description + ". Try numbers like: " + levels[currentLevel].examples.slice(0, 3).join(", ");
                        hintText.style.display = "block";
                    }
                });

                inputField.addEventListener("keypress", function(e) {
                    if (e.key === "Enter") {
                        testBtn.click();
                    }
                });

                hintBtn.addEventListener("click", function() {
                    hintText.style.display = "block";
                });

                // Initialize level 1
                changeLevel(1);
            });
        </script>
    ',
    'content' => '
        <div class="rule-guess-container">
            <div class="rule-guess-header">
                <h2>Rule Guess Puzzle</h2>
            </div>

            <div class="rule-guess-description">
                <p><strong>How to play:</strong> Rule Guess Puzzle is a puzzle game where the player is not told the main rule at first. They must discover it by testing actions and watching what happens.</p>
                <p>Choose a level, enter numbers, and try to figure out the hidden pattern. Find 5 correct examples to advance!</p>
            </div>

            <div class="level-section">
                <button class="level-btn active" data-level="1">Level 1</button>
                <button class="level-btn" data-level="2">Level 2</button>
                <button class="level-btn" data-level="3">Level 3</button>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p class="level-description">Find numbers where the sum of their digits equals 10</p>
            </div>

            <div class="input-section">
                <div class="input-group">
                    <input type="text" id="rule-input" class="input-field" placeholder="Enter a number (0-999)" maxlength="3">
                    <button id="test-btn" class="test-btn">Test</button>
                </div>
            </div>

            <div class="results-section">
                <h3>Test Results:</h3>
                <div id="results-list"></div>
            </div>

            <div class="hint-section">
                <p>Need help? Try different numbers and look for patterns in the results.</p>
                <button id="hint-btn" class="hint-btn">Show Hint</button>
                <div id="hint-text" class="hint-text"></div>
            </div>

            <div id="win-message" class="win-message"></div>
        </div>
    '
];
