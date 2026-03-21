<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 720px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--sequence-memory .sm-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	text-align: center;
}

.zo-game-root--sequence-memory .sm-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	color: #1f2933;
}

.zo-game-root--sequence-memory .sm-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	color: #52606d;
}

.zo-game-root--sequence-memory .sm-topbar {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--sequence-memory .sm-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
}

.zo-game-root--sequence-memory .sm-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--sequence-memory .sm-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--sequence-memory .sm-status {
	min-height: 28px;
	margin-bottom: 14px;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--sequence-memory .sm-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--sequence-memory .sm-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--sequence-memory .sm-sequence-card {
	background: #f8fbff;
	border: 2px dashed #9fb3c8;
	border-radius: 18px;
	padding: 16px;
	margin-bottom: 16px;
}

.zo-game-root--sequence-memory .sm-sequence-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #7b8794;
	margin-bottom: 8px;
	text-transform: uppercase;
	letter-spacing: 0.04em;
}

.zo-game-root--sequence-memory .sm-sequence-display {
	font-size: 30px;
	font-weight: 700;
	line-height: 1.3;
	color: #7c3aed;
	min-height: 40px;
	word-break: break-word;
}

.zo-game-root--sequence-memory .sm-grid {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 14px;
	margin-bottom: 16px;
}

.zo-game-root--sequence-memory .sm-pad {
	border: 0;
	border-radius: 20px;
	min-height: 120px;
	font-size: 34px;
	font-weight: 700;
	cursor: pointer;
	color: #ffffff;
	transition: transform 0.15s ease, opacity 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
}

.zo-game-root--sequence-memory .sm-pad:hover,
.zo-game-root--sequence-memory .sm-pad:focus {
	transform: translateY(-1px);
}

.zo-game-root--sequence-memory .sm-pad:disabled {
	cursor: default;
	transform: none;
	opacity: 1;
}

.zo-game-root--sequence-memory .sm-pad--1 {
	background: #ef4444;
}

.zo-game-root--sequence-memory .sm-pad--2 {
	background: #2563eb;
}

.zo-game-root--sequence-memory .sm-pad--3 {
	background: #0b6e4f;
}

.zo-game-root--sequence-memory .sm-pad--4 {
	background: #f59e0b;
}

.zo-game-root--sequence-memory .sm-pad.is-lit {
	filter: brightness(1.35);
	box-shadow: 0 0 0 5px rgba(255, 255, 255, 0.7), 0 0 0 9px rgba(124, 58, 237, 0.22);
}

.zo-game-root--sequence-memory .sm-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 12px;
}

.zo-game-root--sequence-memory .sm-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--sequence-memory .sm-btn:hover,
.zo-game-root--sequence-memory .sm-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--sequence-memory .sm-btn--show {
	background: #2563eb;
	color: #ffffff;
}

.zo-game-root--sequence-memory .sm-btn--restart {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--sequence-memory .sm-progress {
	font-size: 14px;
	color: #52606d;
}

@media (max-width: 600px) {
	.zo-game-root--sequence-memory .sm-topbar {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--sequence-memory .sm-title {
		font-size: 24px;
	}

	.zo-game-root--sequence-memory .sm-sequence-display {
		font-size: 26px;
	}

	.zo-game-root--sequence-memory .sm-pad {
		min-height: 100px;
		font-size: 30px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--sequence-memory');

	games.forEach(function (game) {
		const levelEl = game.querySelector('.sm-level');
		const scoreEl = game.querySelector('.sm-score');
		const livesEl = game.querySelector('.sm-lives');
		const bestEl = game.querySelector('.sm-best');
		const statusEl = game.querySelector('.sm-status');
		const sequenceDisplayEl = game.querySelector('.sm-sequence-display');
		const showBtn = game.querySelector('.sm-btn--show');
		const restartBtn = game.querySelector('.sm-btn--restart');
		const progressEl = game.querySelector('.sm-progress');
		const pads = game.querySelectorAll('.sm-pad');

		let sequence = [];
		let playerIndex = 0;
		let level = 1;
		let score = 0;
		let lives = 3;
		let best = 0;
		let canPlay = false;
		let showingSequence = false;

		function randomPad() {
			return Math.floor(Math.random() * 4) + 1;
		}

		function wait(ms) {
			return new Promise(function (resolve) {
				window.setTimeout(resolve, ms);
			});
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
			levelEl.textContent = String(level);
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			bestEl.textContent = String(best);
			progressEl.textContent = 'Remember the order, then tap it back';
		}

		function setPadsDisabled(disabled) {
			pads.forEach(function (pad) {
				pad.disabled = disabled;
			});
		}

		function lightPad(number) {
			const pad = game.querySelector('.sm-pad--' + number);
			if (pad) {
				pad.classList.add('is-lit');
			}
		}

		function dimPad(number) {
			const pad = game.querySelector('.sm-pad--' + number);
			if (pad) {
				pad.classList.remove('is-lit');
			}
		}

		async function flashPad(number, duration) {
			lightPad(number);
			await wait(duration);
			dimPad(number);
		}

		function resetPlayerTurn() {
			playerIndex = 0;
			canPlay = true;
			setPadsDisabled(false);
			sequenceDisplayEl.textContent = '?';
		}

		async function showSequence() {
			if (showingSequence) {
				return;
			}

			showingSequence = true;
			canPlay = false;
			setPadsDisabled(true);
			sequenceDisplayEl.textContent = sequence.join(' - ');
			setStatus('Watch the sequence carefully.', '');

			await wait(500);

			for (let i = 0; i < sequence.length; i++) {
				await flashPad(sequence[i], 420);
				await wait(170);
			}

			showingSequence = false;
			resetPlayerTurn();
			setStatus('Now repeat the sequence.', '');
		}

		function addStep() {
			sequence.push(randomPad());
		}

		function startLevel() {
			updateStats();
			addStep();
			showSequence();
		}

		function endGame() {
			canPlay = false;
			setPadsDisabled(true);
			sequenceDisplayEl.textContent = 'Game Over';
			setStatus('Final score: ' + score + '. Press Restart to play again.', 'bad');
		}

		function handleCorrectRound() {
			score += 1;
			if (level > best) {
				best = level;
			}
			setStatus('Correct. Get ready for the next level.', 'good');
			canPlay = false;
			setPadsDisabled(true);
			level += 1;
			updateStats();

			window.setTimeout(function () {
				startLevel();
			}, 900);
		}

		function handleWrongTap() {
			lives -= 1;
			updateStats();

			if (lives <= 0) {
				endGame();
				return;
			}

			canPlay = false;
			setPadsDisabled(true);
			setStatus('Wrong order. Watch the sequence again.', 'bad');

			window.setTimeout(function () {
				showSequence();
			}, 900);
		}

		function handlePadClick(number) {
			if (!canPlay || showingSequence) {
				return;
			}

			flashPad(number, 180);

			if (number === sequence[playerIndex]) {
				playerIndex += 1;

				if (playerIndex >= sequence.length) {
					handleCorrectRound();
				} else {
					setStatus('Good. Keep going.', 'good');
				}
			} else {
				handleWrongTap();
			}
		}

		function restartGame() {
			sequence = [];
			playerIndex = 0;
			level = 1;
			score = 0;
			lives = 3;
			canPlay = false;
			showingSequence = false;
			sequenceDisplayEl.textContent = '-';
			setStatus('Watch the sequence, then repeat it.', '');
			updateStats();
			startLevel();
		}

		pads.forEach(function (pad) {
			pad.addEventListener('click', function () {
				const number = parseInt(pad.getAttribute('data-pad'), 10);
				handlePadClick(number);
			});
		});

		showBtn.addEventListener('click', function () {
			if (lives > 0) {
				showSequence();
			}
		});

		restartBtn.addEventListener('click', restartGame);

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_sequence_memory_render')) {
	function zo_game_sequence_memory_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-sequence-memory-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--sequence-memory" id="<?php echo esc_attr($instance_id); ?>">
			<div class="sm-card">
				<h2 class="sm-title">Sequence Memory</h2>
				<p class="sm-instructions">Watch the color pads light up. Then tap them back in the same order. Each level adds one more step.</p>

				<div class="sm-topbar">
					<div class="sm-stat">
						<span class="sm-stat-label">Level</span>
						<span class="sm-stat-value sm-level">1</span>
					</div>
					<div class="sm-stat">
						<span class="sm-stat-label">Score</span>
						<span class="sm-stat-value sm-score">0</span>
					</div>
					<div class="sm-stat">
						<span class="sm-stat-label">Lives</span>
						<span class="sm-stat-value sm-lives">3</span>
					</div>
					<div class="sm-stat">
						<span class="sm-stat-label">Best</span>
						<span class="sm-stat-value sm-best">0</span>
					</div>
				</div>

				<div class="sm-status" aria-live="polite">Watch the sequence, then repeat it.</div>

				<div class="sm-sequence-card">
					<span class="sm-sequence-label">Sequence</span>
					<div class="sm-sequence-display">-</div>
				</div>

				<div class="sm-grid">
					<button type="button" class="sm-pad sm-pad--1" data-pad="1">1</button>
					<button type="button" class="sm-pad sm-pad--2" data-pad="2">2</button>
					<button type="button" class="sm-pad sm-pad--3" data-pad="3">3</button>
					<button type="button" class="sm-pad sm-pad--4" data-pad="4">4</button>
				</div>

				<div class="sm-actions">
					<button type="button" class="sm-btn sm-btn--show">Show Again</button>
					<button type="button" class="sm-btn sm-btn--restart">Restart</button>
				</div>

				<div class="sm-progress">Remember the order, then tap it back</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'sequence-memory',
	'name'            => 'Sequence Memory',
	'author'          => 'Arslan',
	'description'     => 'Watch a growing sequence and repeat it in the correct order.',
	'render_callback' => 'zo_game_sequence_memory_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);