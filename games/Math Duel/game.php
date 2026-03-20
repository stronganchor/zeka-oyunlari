
<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--math-duel .md-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	text-align: center;
}

.zo-game-root--math-duel .md-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	color: #1f2933;
}

.zo-game-root--math-duel .md-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	color: #52606d;
}

.zo-game-root--math-duel .md-topbar {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 18px;
}

.zo-game-root--math-duel .md-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
}

.zo-game-root--math-duel .md-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--math-duel .md-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--math-duel .md-problem-wrap {
	margin-bottom: 18px;
	padding: 18px;
	background: #f8fbff;
	border: 2px dashed #9fb3c8;
	border-radius: 18px;
}

.zo-game-root--math-duel .md-problem-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #7b8794;
	margin-bottom: 8px;
	text-transform: uppercase;
	letter-spacing: 0.04em;
}

.zo-game-root--math-duel .md-problem {
	font-size: 42px;
	font-weight: 700;
	line-height: 1.2;
	color: #0f172a;
	word-break: break-word;
}

.zo-game-root--math-duel .md-options {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 12px;
	margin-bottom: 16px;
}

.zo-game-root--math-duel .md-option-btn {
	border: 0;
	border-radius: 16px;
	padding: 18px 14px;
	font-size: 28px;
	font-weight: 700;
	cursor: pointer;
	background: #2563eb;
	color: #ffffff;
	transition: transform 0.15s ease, opacity 0.15s ease, background 0.15s ease;
}

.zo-game-root--math-duel .md-option-btn:hover,
.zo-game-root--math-duel .md-option-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--math-duel .md-option-btn.is-correct {
	background: #0b6e4f;
}

.zo-game-root--math-duel .md-option-btn.is-wrong {
	background: #c81e1e;
}

.zo-game-root--math-duel .md-option-btn:disabled {
	opacity: 0.75;
	cursor: default;
	transform: none;
}

.zo-game-root--math-duel .md-status {
	min-height: 28px;
	margin-bottom: 16px;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--math-duel .md-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--math-duel .md-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--math-duel .md-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--math-duel .md-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--math-duel .md-btn:hover,
.zo-game-root--math-duel .md-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--math-duel .md-btn--next {
	background: #0b6e4f;
	color: #ffffff;
}

.zo-game-root--math-duel .md-btn--restart {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--math-duel .md-progress {
	font-size: 14px;
	color: #52606d;
}

@media (max-width: 600px) {
	.zo-game-root--math-duel .md-topbar {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--math-duel .md-title {
		font-size: 24px;
	}

	.zo-game-root--math-duel .md-problem {
		font-size: 34px;
	}

	.zo-game-root--math-duel .md-options {
		grid-template-columns: 1fr;
	}

	.zo-game-root--math-duel .md-option-btn {
		font-size: 24px;
		padding: 16px 12px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--math-duel');

	games.forEach(function (game) {
		const playerScoreEl = game.querySelector('.md-player-score');
		const cpuScoreEl = game.querySelector('.md-cpu-score');
		const roundEl = game.querySelector('.md-round');
		const streakEl = game.querySelector('.md-streak');
		const problemEl = game.querySelector('.md-problem');
		const optionsWrap = game.querySelector('.md-options');
		const statusEl = game.querySelector('.md-status');
		const progressEl = game.querySelector('.md-progress');
		const nextBtn = game.querySelector('.md-btn--next');
		const restartBtn = game.querySelector('.md-btn--restart');

		let totalRounds = 10;
		let round = 1;
		let playerScore = 0;
		let cpuScore = 0;
		let streak = 0;
		let currentAnswer = null;
		let canAnswer = true;

		function randomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		function shuffleArray(array) {
			const copy = array.slice();
			for (let i = copy.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = copy[i];
				copy[i] = copy[j];
				copy[j] = temp;
			}
			return copy;
		}

		function setStatus(message, type) {
			statusEl.textContent = message;
			statusEl.classList.remove('is-good', 'is-bad');

			if (type === 'good') {
				statusEl.classList.add('is-good');
			} else if (type === 'bad') {
				statusEl.classList.add('is-bad');
			}
		}

		function updateTopbar() {
			playerScoreEl.textContent = String(playerScore);
			cpuScoreEl.textContent = String(cpuScore);
			roundEl.textContent = String(Math.min(round, totalRounds));
			streakEl.textContent = String(streak);
			progressEl.textContent = 'Round ' + Math.min(round, totalRounds) + ' of ' + totalRounds;
		}

		function generateProblem() {
			const ops = ['+', '-', '×'];
			const op = ops[randomInt(0, ops.length - 1)];
			let a = 0;
			let b = 0;
			let answer = 0;

			if (op === '+') {
				a = randomInt(1, 20);
				b = randomInt(1, 20);
				answer = a + b;
			} else if (op === '-') {
				a = randomInt(8, 25);
				b = randomInt(1, a);
				answer = a - b;
			} else {
				a = randomInt(2, 12);
				b = randomInt(2, 10);
				answer = a * b;
			}

			return {
				text: a + ' ' + op + ' ' + b,
				answer: answer
			};
		}

		function buildOptions(correctAnswer) {
			const options = [correctAnswer];

			while (options.length < 4) {
				const offset = randomInt(-10, 10);
				const wrong = correctAnswer + offset;

				if (wrong >= 0 && options.indexOf(wrong) === -1) {
					options.push(wrong);
				}
			}

			return shuffleArray(options);
		}

		function renderRound() {
			if (round > totalRounds) {
				endGame();
				return;
			}

			const problem = generateProblem();
			currentAnswer = problem.answer;
			canAnswer = true;

			problemEl.textContent = problem.text;
			optionsWrap.innerHTML = '';

			const options = buildOptions(problem.answer);

			options.forEach(function (option) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'md-option-btn';
				btn.textContent = String(option);

				btn.addEventListener('click', function () {
					if (!canAnswer) {
						return;
					}
					handleAnswer(option, btn);
				});

				optionsWrap.appendChild(btn);
			});

			updateTopbar();
			setStatus('Pick the right answer before the computer gets ahead.', '');
			nextBtn.disabled = true;
		}

		function handleAnswer(selectedAnswer, clickedButton) {
			if (!canAnswer) {
				return;
			}

			canAnswer = false;

			const buttons = optionsWrap.querySelectorAll('.md-option-btn');
			buttons.forEach(function (btn) {
				btn.disabled = true;
				if (Number(btn.textContent) === currentAnswer) {
					btn.classList.add('is-correct');
				}
			});

			if (selectedAnswer === currentAnswer) {
				playerScore += 1;
				streak += 1;
				setStatus('Correct. You win this round.', 'good');
			} else {
				cpuScore += 1;
				streak = 0;
				clickedButton.classList.add('is-wrong');
				setStatus('Wrong. The computer wins this round.', 'bad');
			}

			updateTopbar();
			nextBtn.disabled = false;
		}

		function endGame() {
			optionsWrap.innerHTML = '';
			problemEl.textContent = playerScore > cpuScore ? 'You Win' : (playerScore < cpuScore ? 'Computer Wins' : 'Tie Game');

			if (playerScore > cpuScore) {
				setStatus('Final score: You ' + playerScore + ' - ' + cpuScore + ' Computer', 'good');
			} else if (playerScore < cpuScore) {
				setStatus('Final score: You ' + playerScore + ' - ' + cpuScore + ' Computer', 'bad');
			} else {
				setStatus('Final score: You ' + playerScore + ' - ' + cpuScore + ' Computer', '');
			}

			progressEl.textContent = 'Game finished';
			roundEl.textContent = String(totalRounds);
			nextBtn.disabled = true;
		}

		function nextRound() {
			if (round > totalRounds) {
				return;
			}

			if (canAnswer) {
				setStatus('Answer this round first.', 'bad');
				return;
			}

			round += 1;
			renderRound();
		}

		function restartGame() {
			round = 1;
			playerScore = 0;
			cpuScore = 0;
			streak = 0;
			currentAnswer = null;
			canAnswer = true;
			renderRound();
		}

		nextBtn.addEventListener('click', nextRound);
		restartBtn.addEventListener('click', restartGame);

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_math_duel_render')) {
	function zo_game_math_duel_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-math-duel-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--math-duel" id="<?php echo esc_attr($instance_id); ?>">
			<div class="md-card">
				<h2 class="md-title">Math Duel</h2>
				<p class="md-instructions">Solve the math problem and beat the computer. Each correct answer wins you the round. Each wrong answer gives the round to the computer.</p>

				<div class="md-topbar">
					<div class="md-stat">
						<span class="md-stat-label">You</span>
						<span class="md-stat-value md-player-score">0</span>
					</div>
					<div class="md-stat">
						<span class="md-stat-label">Computer</span>
						<span class="md-stat-value md-cpu-score">0</span>
					</div>
					<div class="md-stat">
						<span class="md-stat-label">Round</span>
						<span class="md-stat-value md-round">1</span>
					</div>
					<div class="md-stat">
						<span class="md-stat-label">Streak</span>
						<span class="md-stat-value md-streak">0</span>
					</div>
				</div>

				<div class="md-problem-wrap">
					<span class="md-problem-label">Problem</span>
					<div class="md-problem">7 + 5</div>
				</div>

				<div class="md-options"></div>

				<div class="md-status" aria-live="polite"></div>

				<div class="md-actions">
					<button type="button" class="md-btn md-btn--next">Next Round</button>
					<button type="button" class="md-btn md-btn--restart">Restart</button>
				</div>

				<div class="md-progress">Round 1 of 10</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'math-duel',
	'name'            => 'Math Duel',
	'author'          => 'Arslan',
	'description'     => 'Answer math questions and try to beat the computer over 10 rounds.',
	'render_callback' => 'zo_game_math_duel_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);