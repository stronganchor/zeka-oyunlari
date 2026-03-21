<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 700px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--balance-game .bg-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	text-align: center;
}

.zo-game-root--balance-game .bg-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	color: #1f2933;
}

.zo-game-root--balance-game .bg-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	color: #52606d;
}

.zo-game-root--balance-game .bg-topbar {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--balance-game .bg-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
}

.zo-game-root--balance-game .bg-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--balance-game .bg-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--balance-game .bg-status {
	min-height: 28px;
	margin-bottom: 14px;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--balance-game .bg-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--balance-game .bg-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--balance-game .bg-equation-card,
.zo-game-root--balance-game .bg-answer-card {
	background: #f8fbff;
	border: 2px dashed #9fb3c8;
	border-radius: 18px;
	padding: 16px;
	margin-bottom: 16px;
}

.zo-game-root--balance-game .bg-equation-label,
.zo-game-root--balance-game .bg-answer-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #7b8794;
	margin-bottom: 8px;
	text-transform: uppercase;
	letter-spacing: 0.04em;
}

.zo-game-root--balance-game .bg-equation {
	font-size: 34px;
	font-weight: 700;
	line-height: 1.3;
	color: #0f172a;
	word-break: break-word;
}

.zo-game-root--balance-game .bg-answer {
	font-size: 30px;
	font-weight: 700;
	line-height: 1.3;
	color: #2563eb;
	min-height: 40px;
	word-break: break-word;
}

.zo-game-root--balance-game .bg-choices {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 12px;
	margin-bottom: 16px;
}

.zo-game-root--balance-game .bg-choice-btn {
	border: 0;
	border-radius: 16px;
	padding: 18px 12px;
	font-size: 28px;
	font-weight: 700;
	cursor: pointer;
	background: #2563eb;
	color: #ffffff;
	transition: transform 0.15s ease, opacity 0.15s ease, background 0.15s ease;
}

.zo-game-root--balance-game .bg-choice-btn:hover,
.zo-game-root--balance-game .bg-choice-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--balance-game .bg-choice-btn.is-correct {
	background: #0b6e4f;
}

.zo-game-root--balance-game .bg-choice-btn.is-wrong {
	background: #c81e1e;
}

.zo-game-root--balance-game .bg-choice-btn:disabled {
	opacity: 0.75;
	cursor: default;
	transform: none;
}

.zo-game-root--balance-game .bg-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 12px;
}

.zo-game-root--balance-game .bg-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--balance-game .bg-btn:hover,
.zo-game-root--balance-game .bg-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--balance-game .bg-btn--next {
	background: #0b6e4f;
	color: #ffffff;
}

.zo-game-root--balance-game .bg-btn--restart {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--balance-game .bg-progress {
	font-size: 14px;
	color: #52606d;
}

@media (max-width: 600px) {
	.zo-game-root--balance-game .bg-topbar {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--balance-game .bg-title {
		font-size: 24px;
	}

	.zo-game-root--balance-game .bg-equation {
		font-size: 28px;
	}

	.zo-game-root--balance-game .bg-answer {
		font-size: 26px;
	}

	.zo-game-root--balance-game .bg-choices {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--balance-game .bg-choice-btn {
		font-size: 24px;
		padding: 16px 10px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--balance-game');

	games.forEach(function (game) {
		const scoreEl = game.querySelector('.bg-score');
		const roundEl = game.querySelector('.bg-round');
		const streakEl = game.querySelector('.bg-streak');
		const livesEl = game.querySelector('.bg-lives');
		const equationEl = game.querySelector('.bg-equation');
		const answerEl = game.querySelector('.bg-answer');
		const choicesWrap = game.querySelector('.bg-choices');
		const statusEl = game.querySelector('.bg-status');
		const progressEl = game.querySelector('.bg-progress');
		const nextBtn = game.querySelector('.bg-btn--next');
		const restartBtn = game.querySelector('.bg-btn--restart');

		let totalRounds = 10;
		let round = 1;
		let score = 0;
		let streak = 0;
		let lives = 3;
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
			scoreEl.textContent = String(score);
			roundEl.textContent = String(Math.min(round, totalRounds));
			streakEl.textContent = String(streak);
			livesEl.textContent = String(lives);
			progressEl.textContent = 'Round ' + Math.min(round, totalRounds) + ' of ' + totalRounds;
		}

		function buildQuestion() {
			const x = randomInt(1, 12);
			const leftPart = randomInt(1, 10);
			const useAddition = Math.random() < 0.5;
			let equation = '';
			let answer = 0;

			if (useAddition) {
				answer = x + leftPart;
				equation = '⚖️  x + ' + leftPart + ' = ' + answer;
			} else {
				answer = x - leftPart;
				equation = '⚖️  x - ' + leftPart + ' = ' + answer;
			}

			return {
				equation: equation,
				answer: x
			};
		}

		function buildChoices(correctAnswer) {
			const options = [correctAnswer];

			while (options.length < 6) {
				const candidate = correctAnswer + randomInt(-5, 5);
				if (candidate >= 0 && options.indexOf(candidate) === -1) {
					options.push(candidate);
				}
			}

			return shuffleArray(options);
		}

		function renderRound() {
			if (round > totalRounds || lives <= 0) {
				endGame();
				return;
			}

			const question = buildQuestion();
			currentAnswer = question.answer;
			canAnswer = true;

			equationEl.textContent = question.equation;
			answerEl.textContent = '?';
			choicesWrap.innerHTML = '';

			const choices = buildChoices(question.answer);

			choices.forEach(function (choice) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'bg-choice-btn';
				btn.textContent = String(choice);

				btn.addEventListener('click', function () {
					if (!canAnswer) {
						return;
					}
					handleAnswer(choice, btn);
				});

				choicesWrap.appendChild(btn);
			});

			updateTopbar();
			setStatus('Pick the number that makes the scale balance.', '');
			nextBtn.disabled = true;
		}

		function handleAnswer(selected, clickedButton) {
			if (!canAnswer) {
				return;
			}

			canAnswer = false;
			answerEl.textContent = 'x = ' + currentAnswer;

			const buttons = choicesWrap.querySelectorAll('.bg-choice-btn');
			buttons.forEach(function (btn) {
				btn.disabled = true;
				if (Number(btn.textContent) === currentAnswer) {
					btn.classList.add('is-correct');
				}
			});

			if (selected === currentAnswer) {
				score += 1;
				streak += 1;
				setStatus('Correct. The equation is balanced.', 'good');
			} else {
				lives -= 1;
				streak = 0;
				clickedButton.classList.add('is-wrong');
				setStatus('Not balanced. The right answer is ' + currentAnswer + '.', 'bad');
			}

			updateTopbar();
			nextBtn.disabled = false;
		}

		function endGame() {
			choicesWrap.innerHTML = '';
			answerEl.textContent = '';

			if (lives <= 0) {
				equationEl.textContent = 'Game Over';
				setStatus('You ran out of lives. Final score: ' + score + ' / ' + totalRounds, 'bad');
			} else if (score === totalRounds) {
				equationEl.textContent = 'Perfect Balance';
				setStatus('Amazing. Final score: ' + score + ' / ' + totalRounds, 'good');
			} else {
				equationEl.textContent = 'Finished';
				setStatus('Final score: ' + score + ' / ' + totalRounds, score >= Math.ceil(totalRounds / 2) ? 'good' : '');
			}

			progressEl.textContent = 'Game finished';
			roundEl.textContent = String(Math.min(round - 1, totalRounds));
			nextBtn.disabled = true;
		}

		function nextRound() {
			if (round > totalRounds || lives <= 0) {
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
			score = 0;
			streak = 0;
			lives = 3;
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

if (!function_exists('zo_game_balance_game_render')) {
	function zo_game_balance_game_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-balance-game-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--balance-game" id="<?php echo esc_attr($instance_id); ?>">
			<div class="bg-card">
				<h2 class="bg-title">Balance Game</h2>
				<p class="bg-instructions">Find the missing number that makes the math balance. Each wrong answer costs one life. Try to finish all 10 rounds.</p>

				<div class="bg-topbar">
					<div class="bg-stat">
						<span class="bg-stat-label">Score</span>
						<span class="bg-stat-value bg-score">0</span>
					</div>
					<div class="bg-stat">
						<span class="bg-stat-label">Round</span>
						<span class="bg-stat-value bg-round">1</span>
					</div>
					<div class="bg-stat">
						<span class="bg-stat-label">Streak</span>
						<span class="bg-stat-value bg-streak">0</span>
					</div>
					<div class="bg-stat">
						<span class="bg-stat-label">Lives</span>
						<span class="bg-stat-value bg-lives">3</span>
					</div>
				</div>

				<div class="bg-status" aria-live="polite">Pick the number that makes the scale balance.</div>

				<div class="bg-equation-card">
					<span class="bg-equation-label">Equation</span>
					<div class="bg-equation">⚖️ x + 3 = 8</div>
				</div>

				<div class="bg-answer-card">
					<span class="bg-answer-label">Missing Number</span>
					<div class="bg-answer">?</div>
				</div>

				<div class="bg-choices"></div>

				<div class="bg-actions">
					<button type="button" class="bg-btn bg-btn--next">Next Round</button>
					<button type="button" class="bg-btn bg-btn--restart">Restart</button>
				</div>

				<div class="bg-progress">Round 1 of 10</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'balance-game',
	'name'            => 'Balance Game',
	'author'          => 'Arslan',
	'description'     => 'Solve simple balance equations by finding the missing number.',
	'render_callback' => 'zo_game_balance_game_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);