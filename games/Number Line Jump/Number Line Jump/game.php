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

.zo-game-root--number-line-jump .nlj-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	text-align: center;
}

.zo-game-root--number-line-jump .nlj-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	color: #1f2933;
}

.zo-game-root--number-line-jump .nlj-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	color: #52606d;
}

.zo-game-root--number-line-jump .nlj-topbar {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--number-line-jump .nlj-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
}

.zo-game-root--number-line-jump .nlj-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--number-line-jump .nlj-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--number-line-jump .nlj-challenge-card {
	background: #f8fbff;
	border: 2px dashed #9fb3c8;
	border-radius: 18px;
	padding: 16px;
	margin-bottom: 16px;
}

.zo-game-root--number-line-jump .nlj-challenge-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #7b8794;
	margin-bottom: 8px;
	text-transform: uppercase;
	letter-spacing: 0.04em;
}

.zo-game-root--number-line-jump .nlj-challenge {
	font-size: 30px;
	font-weight: 700;
	line-height: 1.3;
	color: #0f172a;
	word-break: break-word;
}

.zo-game-root--number-line-jump .nlj-status {
	min-height: 28px;
	margin-bottom: 14px;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--number-line-jump .nlj-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--number-line-jump .nlj-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--number-line-jump .nlj-line-wrap {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	padding: 18px 14px 26px;
	margin-bottom: 16px;
	overflow-x: auto;
}

.zo-game-root--number-line-jump .nlj-line {
	position: relative;
	min-width: 620px;
	height: 120px;
}

.zo-game-root--number-line-jump .nlj-track {
	position: absolute;
	left: 28px;
	right: 28px;
	top: 58px;
	height: 6px;
	background: #bcccdc;
	border-radius: 999px;
}

.zo-game-root--number-line-jump .nlj-ticks {
	position: absolute;
	left: 28px;
	right: 28px;
	top: 32px;
	display: flex;
	justify-content: space-between;
}

.zo-game-root--number-line-jump .nlj-tick {
	position: relative;
	width: 1px;
	flex: 1 1 auto;
	max-width: 1px;
}

.zo-game-root--number-line-jump .nlj-tick::before {
	content: '';
	position: absolute;
	left: 50%;
	transform: translateX(-50%);
	top: 16px;
	width: 4px;
	height: 24px;
	background: #7b8794;
	border-radius: 999px;
}

.zo-game-root--number-line-jump .nlj-tick-label {
	position: absolute;
	left: 50%;
	transform: translateX(-50%);
	top: -8px;
	font-size: 15px;
	font-weight: 700;
	color: #102a43;
	white-space: nowrap;
}

.zo-game-root--number-line-jump .nlj-marker,
.zo-game-root--number-line-jump .nlj-target-marker {
	position: absolute;
	top: 46px;
	width: 22px;
	height: 22px;
	border-radius: 50%;
	transform: translateX(-50%);
}

.zo-game-root--number-line-jump .nlj-marker {
	background: #2563eb;
	border: 3px solid #1d4ed8;
	box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
}

.zo-game-root--number-line-jump .nlj-target-marker {
	background: #f59e0b;
	border: 3px solid #b45309;
	opacity: 0.75;
}

.zo-game-root--number-line-jump .nlj-jump-text {
	position: absolute;
	top: 80px;
	transform: translateX(-50%);
	font-size: 14px;
	font-weight: 700;
	color: #7c3aed;
	white-space: nowrap;
}

.zo-game-root--number-line-jump .nlj-controls {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 12px;
	margin-bottom: 16px;
}

.zo-game-root--number-line-jump .nlj-jump-btn {
	border: 0;
	border-radius: 16px;
	padding: 16px 10px;
	font-size: 22px;
	font-weight: 700;
	cursor: pointer;
	background: #2563eb;
	color: #ffffff;
	transition: transform 0.15s ease, opacity 0.15s ease, background 0.15s ease;
}

.zo-game-root--number-line-jump .nlj-jump-btn:hover,
.zo-game-root--number-line-jump .nlj-jump-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--number-line-jump .nlj-jump-btn--left {
	background: #ef4444;
}

.zo-game-root--number-line-jump .nlj-jump-btn--right {
	background: #0b6e4f;
}

.zo-game-root--number-line-jump .nlj-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 12px;
}

.zo-game-root--number-line-jump .nlj-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--number-line-jump .nlj-btn:hover,
.zo-game-root--number-line-jump .nlj-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--number-line-jump .nlj-btn--check {
	background: #0b6e4f;
	color: #ffffff;
}

.zo-game-root--number-line-jump .nlj-btn--reset {
	background: #f59e0b;
	color: #ffffff;
}

.zo-game-root--number-line-jump .nlj-btn--restart {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--number-line-jump .nlj-progress {
	font-size: 14px;
	color: #52606d;
}

@media (max-width: 600px) {
	.zo-game-root--number-line-jump .nlj-topbar {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--number-line-jump .nlj-title {
		font-size: 24px;
	}

	.zo-game-root--number-line-jump .nlj-challenge {
		font-size: 25px;
	}

	.zo-game-root--number-line-jump .nlj-controls {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--number-line-jump .nlj-jump-btn {
		font-size: 20px;
		padding: 14px 8px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--number-line-jump');

	games.forEach(function (game) {
		const scoreEl = game.querySelector('.nlj-score');
		const roundEl = game.querySelector('.nlj-round');
		const streakEl = game.querySelector('.nlj-streak');
		const movesEl = game.querySelector('.nlj-moves');
		const challengeEl = game.querySelector('.nlj-challenge');
		const statusEl = game.querySelector('.nlj-status');
		const lineEl = game.querySelector('.nlj-line');
		const ticksEl = game.querySelector('.nlj-ticks');
		const markerEl = game.querySelector('.nlj-marker');
		const targetMarkerEl = game.querySelector('.nlj-target-marker');
		const jumpTextEl = game.querySelector('.nlj-jump-text');
		const checkBtn = game.querySelector('.nlj-btn--check');
		const resetBtn = game.querySelector('.nlj-btn--reset');
		const restartBtn = game.querySelector('.nlj-btn--restart');
		const progressEl = game.querySelector('.nlj-progress');
		const jumpButtons = game.querySelectorAll('.nlj-jump-btn');

		let totalRounds = 10;
		let round = 1;
		let score = 0;
		let streak = 0;
		let moves = 0;
		let startNumber = 0;
		let targetNumber = 0;
		let currentNumber = 0;
		let minNumber = 0;
		let maxNumber = 10;
		let roundDone = false;

		function randomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
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

		function updateStats() {
			scoreEl.textContent = String(score);
			roundEl.textContent = String(round);
			streakEl.textContent = String(streak);
			movesEl.textContent = String(moves);
			progressEl.textContent = 'Round ' + round + ' of ' + totalRounds;
		}

		function renderTicks() {
			ticksEl.innerHTML = '';

			for (let i = minNumber; i <= maxNumber; i++) {
				const tick = document.createElement('div');
				tick.className = 'nlj-tick';

				const label = document.createElement('div');
				label.className = 'nlj-tick-label';
				label.textContent = String(i);

				tick.appendChild(label);
				ticksEl.appendChild(tick);
			}
		}

		function getPercentForNumber(number) {
			if (maxNumber === minNumber) {
				return 50;
			}
			return ((number - minNumber) / (maxNumber - minNumber)) * 100;
		}

		function renderMarkers(lastJumpText) {
			const currentPercent = getPercentForNumber(currentNumber);
			const targetPercent = getPercentForNumber(targetNumber);

			markerEl.style.left = 'calc(28px + (' + currentPercent + '% * (100% - 56px) / 100))';
			targetMarkerEl.style.left = 'calc(28px + (' + targetPercent + '% * (100% - 56px) / 100))';

			if (lastJumpText) {
				jumpTextEl.textContent = lastJumpText;
				jumpTextEl.style.left = markerEl.style.left;
			} else {
				jumpTextEl.textContent = '';
			}
		}

		function buildRound() {
			startNumber = randomInt(0, 10);
			let jumpCount = randomInt(2, 4);
			let steps = [];
			let simulated = startNumber;

			for (let i = 0; i < jumpCount; i++) {
				const stepOptions = [1, 2, 3];
				const step = stepOptions[randomInt(0, stepOptions.length - 1)];
				const direction = Math.random() < 0.5 ? -1 : 1;

				if (simulated + (step * direction) < 0) {
					steps.push(step);
					simulated += step;
				} else {
					steps.push(step * direction);
					simulated += step * direction;
				}
			}

			targetNumber = simulated;
			minNumber = Math.min(startNumber, targetNumber) - 2;
			maxNumber = Math.max(startNumber, targetNumber) + 2;

			if (minNumber < 0) {
				maxNumber += Math.abs(minNumber);
				minNumber = 0;
			}

			currentNumber = startNumber;
			moves = 0;
			roundDone = false;

			const stepWords = steps.map(function (step) {
				if (step > 0) {
					return '+' + step;
				}
				return String(step);
			});

			challengeEl.textContent = 'Start at ' + startNumber + '. Make jumps to land on ' + targetNumber + '.';
			renderTicks();
			renderMarkers('');
			updateStats();
			setStatus('Use the jump buttons to move along the number line.', '');
		}

		function moveBy(step) {
			if (roundDone) {
				return;
			}

			const next = currentNumber + step;

			if (next < minNumber || next > maxNumber) {
				setStatus('That jump goes off the number line.', 'bad');
				return;
			}

			currentNumber = next;
			moves += 1;
			updateStats();
			renderMarkers((step > 0 ? '+' : '') + step);

			if (currentNumber === targetNumber) {
				setStatus('Nice. You landed on the target. Press Check.', 'good');
			} else if (currentNumber < targetNumber) {
				setStatus('You are below the target.', '');
			} else {
				setStatus('You are above the target.', '');
			}
		}

		function checkAnswer() {
			if (roundDone) {
				return;
			}

			if (currentNumber === targetNumber) {
				score += 1;
				streak += 1;
				roundDone = true;
				updateStats();
				setStatus('Correct. You landed exactly on ' + targetNumber + '.', 'good');

				window.setTimeout(function () {
					if (round < totalRounds) {
						round += 1;
						buildRound();
					} else {
						endGame();
					}
				}, 900);
			} else {
				streak = 0;
				roundDone = true;
				updateStats();
				setStatus('Not yet. You landed on ' + currentNumber + ' but needed ' + targetNumber + '.', 'bad');

				window.setTimeout(function () {
					if (round < totalRounds) {
						round += 1;
						buildRound();
					} else {
						endGame();
					}
				}, 1100);
			}
		}

		function resetRound() {
			if (roundDone) {
				return;
			}

			currentNumber = startNumber;
			moves = 0;
			updateStats();
			renderMarkers('');
			setStatus('Round reset. Try again from the start.', '');
		}

		function endGame() {
			challengeEl.textContent = score === totalRounds ? 'Perfect Game' : 'Finished';
			progressEl.textContent = 'Game finished';
			setStatus('Final score: ' + score + ' / ' + totalRounds, score >= Math.ceil(totalRounds / 2) ? 'good' : '');
			roundDone = true;
		}

		jumpButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				const step = parseInt(button.getAttribute('data-step'), 10);
				moveBy(step);
			});
		});

		checkBtn.addEventListener('click', checkAnswer);
		resetBtn.addEventListener('click', resetRound);
		restartBtn.addEventListener('click', function () {
			round = 1;
			score = 0;
			streak = 0;
			buildRound();
		});

		buildRound();
	});
});
JS;

if (!function_exists('zo_game_number_line_jump_render')) {
	function zo_game_number_line_jump_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-number-line-jump-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--number-line-jump" id="<?php echo esc_attr($instance_id); ?>">
			<div class="nlj-card">
				<h2 class="nlj-title">Number Line Jump</h2>
				<p class="nlj-instructions">Start at the given number. Use jump buttons to move left or right on the number line. Try to land exactly on the target number.</p>

				<div class="nlj-topbar">
					<div class="nlj-stat">
						<span class="nlj-stat-label">Score</span>
						<span class="nlj-stat-value nlj-score">0</span>
					</div>
					<div class="nlj-stat">
						<span class="nlj-stat-label">Round</span>
						<span class="nlj-stat-value nlj-round">1</span>
					</div>
					<div class="nlj-stat">
						<span class="nlj-stat-label">Streak</span>
						<span class="nlj-stat-value nlj-streak">0</span>
					</div>
					<div class="nlj-stat">
						<span class="nlj-stat-label">Moves</span>
						<span class="nlj-stat-value nlj-moves">0</span>
					</div>
				</div>

				<div class="nlj-challenge-card">
					<span class="nlj-challenge-label">Challenge</span>
					<div class="nlj-challenge">Start at 3. Make jumps to land on 8.</div>
				</div>

				<div class="nlj-status" aria-live="polite">Use the jump buttons to move along the number line.</div>

				<div class="nlj-line-wrap">
					<div class="nlj-line">
						<div class="nlj-track"></div>
						<div class="nlj-ticks"></div>
						<div class="nlj-target-marker"></div>
						<div class="nlj-marker"></div>
						<div class="nlj-jump-text"></div>
					</div>
				</div>

				<div class="nlj-controls">
					<button type="button" class="nlj-jump-btn nlj-jump-btn--left" data-step="-3">-3</button>
					<button type="button" class="nlj-jump-btn nlj-jump-btn--left" data-step="-2">-2</button>
					<button type="button" class="nlj-jump-btn nlj-jump-btn--right" data-step="2">+2</button>
					<button type="button" class="nlj-jump-btn nlj-jump-btn--right" data-step="3">+3</button>
				</div>

				<div class="nlj-actions">
					<button type="button" class="nlj-btn nlj-btn--check">Check</button>
					<button type="button" class="nlj-btn nlj-btn--reset">Reset Round</button>
					<button type="button" class="nlj-btn nlj-btn--restart">Restart Game</button>
				</div>

				<div class="nlj-progress">Round 1 of 10</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'number-line-jump',
	'name'            => 'Number Line Jump',
	'author'          => 'Arslan',
	'description'     => 'Jump along a number line and try to land exactly on the target number.',
	'render_callback' => 'zo_game_number_line_jump_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);