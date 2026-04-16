<?php
if (!defined('ABSPATH')) {
    exit;
}

$css = <<<'CSS'
.rule-guess-container {
    max-width: 760px;
    margin: 0 auto;
    padding: 24px;
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #3b82f6 0%, #6d28d9 100%);
    border-radius: 24px;
    color: #ffffff;
}
.rule-guess-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}
.rule-guess-title {
    margin: 0;
    font-size: 2rem;
    line-height: 1.1;
}
.rule-guess-author {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.8);
    background: rgba(255, 255, 255, 0.12);
    padding: 8px 14px;
    border-radius: 999px;
}
.rule-guess-description {
    background: rgba(255, 255, 255, 0.12);
    padding: 18px;
    border-radius: 18px;
    margin-bottom: 20px;
    border-left: 4px solid #fbbf24;
}
.level-section {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.level-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.level-btn {
    padding: 10px 18px;
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    cursor: pointer;
    transition: all 0.25s ease;
}
.level-btn.active,
.level-btn:hover {
    background: #fbbf24;
    color: #1f2937;
    border-color: transparent;
}
.level-description {
    flex: 1 1 100%;
    margin: 0;
    color: rgba(255, 255, 255, 0.88);
}
.input-section {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 20px;
}
.input-field {
    flex: 1 1 260px;
    padding: 14px 18px;
    border-radius: 18px;
    border: none;
    font-size: 1rem;
    width: 100%;
    max-width: 320px;
}
.test-btn,
.ask-btn,
.hint-btn {
    padding: 14px 22px;
    border: none;
    border-radius: 18px;
    font-size: 1rem;
    cursor: pointer;
    color: #1f2937;
    font-weight: 700;
}
.test-btn {
    background: #fbbf24;
}
.ask-btn {
    background: #8b5cf6;
    color: #ffffff;
}
.hint-btn {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}
.results-section,
.hint-section,
.asker-section {
    background: rgba(255, 255, 255, 0.12);
    padding: 18px;
    border-radius: 18px;
    margin-bottom: 16px;
}
.results-section h3,
.hint-section h3,
.asker-section h3 {
    margin: 0 0 10px;
}
.result-item {
    background: rgba(255, 255, 255, 0.92);
    border-radius: 14px;
    padding: 12px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    color: #111827;
}
.result-output.correct {
    color: #16a34a;
    font-weight: 700;
}
.result-output.incorrect {
    color: #dc2626;
    font-weight: 700;
}
.hint-text,
.asker-response {
    margin-top: 12px;
    display: none;
    color: rgba(31, 41, 55, 0.95);
}
.asker-response {
    background: #ffffff;
    color: #111827;
    border-radius: 16px;
    padding: 16px;
}
.win-message {
    margin-top: 18px;
    font-size: 1.05rem;
    font-weight: 700;
    color: #fef08a;
    display: none;
}
@media (max-width: 720px) {
    .rule-guess-container {
        padding: 18px;
    }
    .level-section {
        flex-direction: column;
        align-items: stretch;
    }
    .input-section {
        flex-direction: column;
    }
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
    const inputField = document.getElementById('rule-input');
    const testBtn = document.getElementById('test-btn');
    const hintBtn = document.getElementById('hint-btn');
    const askBtn = document.getElementById('ask-btn');
    const resultsList = document.getElementById('results-list');
    const hintText = document.getElementById('hint-text');
    const askerResponse = document.getElementById('asker-response');
    const winMessage = document.getElementById('win-message');
    const levelBtns = document.querySelectorAll('.level-btn');
    const levelDescription = document.querySelector('.level-description');

    let currentLevel = 1;
    let attempts = 0;
    const maxAttempts = 15;

    const levels = {
        1: {
            rule: 'Sum of digits equals 10',
            description: 'Find numbers whose digits add up to 10.',
            examples: [19, 28, 37, 46, 55],
            detailedExplanation: 'This level asks you to enter numbers where the sum of each digit equals 10. For example, 19 gives 1 + 9 = 10, and 46 gives 4 + 6 = 10. Try numbers with two or three digits to find the pattern.'
        },
        2: {
            rule: 'Perfect square',
            description: 'Find numbers that are perfect squares.',
            examples: [1, 4, 9, 16, 25],
            detailedExplanation: 'Perfect squares are numbers formed by multiplying an integer by itself, like 4 = 2 × 2 and 16 = 4 × 4. If the square root of a number is a whole number, it satisfies this rule.'
        },
        3: {
            rule: 'Prime number',
            description: 'Find numbers that are prime.',
            examples: [2, 3, 5, 7, 11],
            detailedExplanation: 'Prime numbers are greater than 1 and divisible only by 1 and themselves. For example, 7 is prime because no number other than 1 and 7 divides it evenly.'
        }
    };

    function isPrime(num) {
        if (num <= 1) return false;
        if (num <= 3) return true;
        if (num % 2 === 0 || num % 3 === 0) return false;
        for (let i = 5; i * i <= num; i += 6) {
            if (num % i === 0 || num % (i + 2) === 0) {
                return false;
            }
        }
        return true;
    }

    function digitSum(value) {
        return value
            .toString()
            .split('')
            .reduce((sum, digit) => sum + parseInt(digit, 10), 0);
    }

    function testValue(value, level) {
        const number = parseInt(value, 10);
        if (Number.isNaN(number) || number < 0 || number > 999) {
            return { message: 'Invalid input. Please enter a number between 0 and 999.', correct: false };
        }

        let correct = false;
        let message = '';

        if (level === 1) {
            const sum = digitSum(number);
            correct = sum === 10;
            message = correct ? '✓ Correct! Digit sum = 10.' : '✗ Incorrect. Digit sum = ' + sum + '.';
        } else if (level === 2) {
            const root = Math.sqrt(number);
            correct = root === Math.floor(root);
            message = correct ? '✓ Correct! ' + number + ' is a perfect square.' : '✗ Incorrect. ' + number + ' is not a perfect square.';
        } else if (level === 3) {
            correct = isPrime(number);
            message = correct ? '✓ Correct! ' + number + ' is prime.' : '✗ Incorrect. ' + number + ' is not prime.';
        }

        return { message, correct };
    }

    function updateLevel(level) {
        currentLevel = level;
        attempts = 0;
        resultsList.innerHTML = '';
        hintText.style.display = 'none';
        askerResponse.style.display = 'none';
        winMessage.style.display = 'none';
        levelBtns.forEach(btn => btn.classList.toggle('active', parseInt(btn.dataset.level, 10) === level));
        levelDescription.textContent = levels[level].description;
    }

    levelBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            updateLevel(parseInt(this.dataset.level, 10));
        });
    });

    testBtn.addEventListener('click', function () {
        const input = inputField.value.trim();
        if (!input) {
            return;
        }

        attempts += 1;
        const result = testValue(input, currentLevel);
        const item = document.createElement('div');
        item.className = 'result-item';
        item.innerHTML = `
            <span class="result-input">${input}</span>
            <span class="result-output ${result.correct ? 'correct' : 'incorrect'}">${result.message}</span>
        `;
        resultsList.appendChild(item);
        inputField.value = '';

        if (result.correct) {
            const correctCount = Array.from(resultsList.querySelectorAll('.result-output.correct')).length;
            if (correctCount >= 5) {
                winMessage.textContent = '🎉 Level ' + currentLevel + ' complete! Rule: ' + levels[currentLevel].rule;
                winMessage.style.display = 'block';
            }
        }

        if (attempts >= maxAttempts && hintText.style.display === 'none') {
            hintText.textContent = 'Hint: ' + levels[currentLevel].detailedExplanation;
            hintText.style.display = 'block';
        }
    });

    hintBtn.addEventListener('click', function () {
        hintText.textContent = 'Hint: ' + levels[currentLevel].detailedExplanation;
        hintText.style.display = 'block';
    });

    askBtn.addEventListener('click', function () {
        askerResponse.innerHTML = `
            <strong>🤖 AI Assistant:</strong><br>
            ${levels[currentLevel].detailedExplanation}<br><br>
            <strong>Try these examples:</strong> ${levels[currentLevel].examples.join(', ')}
        `;
        askerResponse.style.display = 'block';
        askerResponse.scrollIntoView({ behavior: 'smooth' });
    });

    updateLevel(1);
});
JS;

if (!function_exists('zo_game_rule_guess_puzzle_render')) {
    function zo_game_rule_guess_puzzle_render($post_id = 0, $module = array()) {
        $instance_id = 'zo-rule-guess-puzzle-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

        ob_start();
        ?>
        <div class="rule-guess-container" id="<?php echo esc_attr($instance_id); ?>">
            <div class="rule-guess-header">
                <div>
                    <h2 class="rule-guess-title">Rule Guess Puzzle</h2>
                    <p class="rule-guess-description">Discover the hidden rule by testing inputs and studying the results. Progress through levels and learn patterns along the way.</p>
                </div>
                <div class="rule-guess-author">By Asker</div>
            </div>

            <div class="level-section">
                <div class="level-buttons">
                    <button type="button" class="level-btn active" data-level="1">Level 1</button>
                    <button type="button" class="level-btn" data-level="2">Level 2</button>
                    <button type="button" class="level-btn" data-level="3">Level 3</button>
                </div>
                <p class="level-description">Find numbers whose digits add up to 10.</p>
            </div>

            <div class="input-section">
                <input type="text" id="rule-input" class="input-field" placeholder="Enter a number (0-999)">
                <button type="button" id="test-btn" class="test-btn">Test</button>
                <button type="button" id="hint-btn" class="hint-btn">Hint</button>
            </div>

            <div class="results-section">
                <h3>Test Results</h3>
                <div id="results-list"></div>
            </div>

            <div class="asker-section">
                <p>Need a clearer explanation?</p>
                <button type="button" id="ask-btn" class="ask-btn">Ask AI Assistant</button>
                <div id="asker-response" class="asker-response"></div>
            </div>

            <div class="hint-text" id="hint-text"></div>
            <div class="win-message" id="win-message"></div>
        </div>
        <?php
        return ob_get_clean();
    }
}

return array(
    'slug'            => 'rule-guess-puzzle',
    'name'            => 'Rule Guess Puzzle',
    'author'          => 'Asker',
    'description'     => 'A hidden-rule puzzle game where players test numbers and discover the secret rule by observing feedback.',
    'render_callback' => 'zo_game_rule_guess_puzzle_render',
    'inline_style'    => $css,
    'inline_script'   => $js,
);
