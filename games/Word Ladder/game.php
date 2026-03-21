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

.zo-game-root--word-ladder .wl-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	text-align: center;
}

.zo-game-root--word-ladder .wl-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	color: #1f2933;
}

.zo-game-root--word-ladder .wl-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	color: #52606d;
}

.zo-game-root--word-ladder .wl-topbar {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--word-ladder .wl-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
}

.zo-game-root--word-ladder .wl-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--word-ladder .wl-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--word-ladder .wl-goal-card,
.zo-game-root--word-ladder .wl-current-card {
	background: #f8fbff;
	border: 2px dashed #9fb3c8;
	border-radius: 18px;
	padding: 16px;
	margin-bottom: 14px;
}

.zo-game-root--word-ladder .wl-goal-label,
.zo-game-root--word-ladder .wl-current-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #7b8794;
	margin-bottom: 8px;
	text-transform: uppercase;
	letter-spacing: 0.04em;
}

.zo-game-root--word-ladder .wl-goal-row {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 16px;
	flex-wrap: wrap;
}

.zo-game-root--word-ladder .wl-word-chip {
	min-width: 90px;
	padding: 12px 16px;
	border-radius: 14px;
	font-size: 28px;
	font-weight: 700;
	line-height: 1;
	background: #ffffff;
	border: 2px solid #bcccdc;
	color: #102a43;
}

.zo-game-root--word-ladder .wl-word-chip--start {
	background: #eff6ff;
	border-color: #60a5fa;
}

.zo-game-root--word-ladder .wl-word-chip--target {
	background: #ecfdf3;
	border-color: #34d399;
}

.zo-game-root--word-ladder .wl-arrow {
	font-size: 28px;
	font-weight: 700;
	color: #7c3aed;
}

.zo-game-root--word-ladder .wl-current-word {
	font-size: 34px;
	font-weight: 700;
	line-height: 1.2;
	color: #7c3aed;
	word-break: break-word;
}

.zo-game-root--word-ladder .wl-status {
	min-height: 28px;
	margin-bottom: 14px;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--word-ladder .wl-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--word-ladder .wl-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--word-ladder .wl-letters {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 12px;
	margin-bottom: 14px;
}

.zo-game-root--word-ladder .wl-letter-box {
	background: #ffffff;
	border: 2px solid #bcccdc;
	border-radius: 16px;
	padding: 14px 10px;
}

.zo-game-root--word-ladder .wl-letter-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 8px;
}

.zo-game-root--word-ladder .wl-letter-value {
	display: block;
	font-size: 30px;
	font-weight: 700;
	color: #102a43;
	min-height: 36px;
}

.zo-game-root--word-ladder .wl-controls {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 12px;
	margin-bottom: 14px;
}

.zo-game-root--word-ladder .wl-select-btn,
.zo-game-root--word-ladder .wl-change-btn {
	border: 0;
	border-radius: 14px;
	padding: 14px 10px;
	font-size: 18px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease, background 0.15s ease;
}

.zo-game-root--word-ladder .wl-select-btn:hover,
.zo-game-root--word-ladder .wl-select-btn:focus,
.zo-game-root--word-ladder .wl-change-btn:hover,
.zo-game-root--word-ladder .wl-change-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--word-ladder .wl-select-btn {
	background: #e0f2fe;
	color: #0f172a;
	border: 2px solid #7dd3fc;
}

.zo-game-root--word-ladder .wl-select-btn.is-active {
	background: #2563eb;
	color: #ffffff;
	border-color: #1d4ed8;
}

.zo-game-root--word-ladder .wl-change-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--word-ladder .wl-change-btn {
	background: #2563eb;
	color: #ffffff;
	font-size: 24px;
	padding: 16px 10px;
}

.zo-game-root--word-ladder .wl-change-btn:disabled {
	opacity: 0.45;
	cursor: default;
	transform: none;
}

.zo-game-root--word-ladder .wl-history-card {
	background: #f8fbff;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	padding: 16px;
	margin-bottom: 16px;
	text-align: left;
}

.zo-game-root--word-ladder .wl-history-title {
	margin: 0 0 10px;
	font-size: 18px;
	font-weight: 700;
	color: #102a43;
	text-align: center;
}

.zo-game-root--word-ladder .wl-history-list {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	min-height: 36px;
}

.zo-game-root--word-ladder .wl-history-chip {
	padding: 8px 12px;
	border-radius: 999px;
	background: #ffffff;
	border: 2px solid #bcccdc;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--word-ladder .wl-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 12px;
}

.zo-game-root--word-ladder .wl-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--word-ladder .wl-btn:hover,
.zo-game-root--word-ladder .wl-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--word-ladder .wl-btn--undo {
	background: #f59e0b;
	color: #ffffff;
}

.zo-game-root--word-ladder .wl-btn--restart-round {
	background: #0b6e4f;
	color: #ffffff;
}

.zo-game-root--word-ladder .wl-btn--restart-game {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--word-ladder .wl-progress {
	font-size: 14px;
	color: #52606d;
}

@media (max-width: 600px) {
	.zo-game-root--word-ladder .wl-topbar {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--word-ladder .wl-title {
		font-size: 24px;
	}

	.zo-game-root--word-ladder .wl-word-chip {
		min-width: 72px;
		font-size: 24px;
	}

	.zo-game-root--word-ladder .wl-current-word {
		font-size: 28px;
	}

	.zo-game-root--word-ladder .wl-letters,
	.zo-game-root--word-ladder .wl-controls {
		grid-template-columns: 1fr;
	}

	.zo-game-root--word-ladder .wl-change-grid {
		grid-template-columns: repeat(4, 1fr);
	}

	.zo-game-root--word-ladder .wl-change-btn {
		font-size: 22px;
		padding: 14px 8px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--word-ladder');

	games.forEach(function (game) {
		const scoreEl = game.querySelector('.wl-score');
		const roundEl = game.querySelector('.wl-round');
		const movesEl = game.querySelector('.wl-moves');
		const bestEl = game.querySelector('.wl-best');
		const startEl = game.querySelector('.wl-start-word');
		const targetEl = game.querySelector('.wl-target-word');
		const currentEl = game.querySelector('.wl-current-word');
		const statusEl = game.querySelector('.wl-status');
		const historyListEl = game.querySelector('.wl-history-list');
		const progressEl = game.querySelector('.wl-progress');
		const letterValueEls = game.querySelectorAll('.wl-letter-value');
		const selectButtons = game.querySelectorAll('.wl-select-btn');
		const changeButtons = game.querySelectorAll('.wl-change-btn');
		const undoBtn = game.querySelector('.wl-btn--undo');
		const restartRoundBtn = game.querySelector('.wl-btn--restart-round');
		const restartGameBtn = game.querySelector('.wl-btn--restart-game');

		const ladders = [
			{ start: 'CAT', target: 'DOG', path: ['CAT', 'COT', 'DOT', 'DOG'] },
			{ start: 'SUN', target: 'FUN', path: ['SUN', 'FUN'] },
			{ start: 'MAP', target: 'TIP', path: ['MAP', 'TAP', 'TIP'] },
			{ start: 'BED', target: 'RED', path: ['BED', 'RED'] },
			{ start: 'HAT', target: 'BIG', path: ['HAT', 'BAT', 'BAG', 'BIG'] },
			{ start: 'PEN', target: 'CUP', path: ['PEN', 'PIN', 'PUN', 'CUN', 'CUP'] },
			{ start: 'BOX', target: 'RUG', path: ['BOX', 'BOG', 'BUG', 'RUG'] },
			{ start: 'CAR', target: 'FIN', path: ['CAR', 'CAN', 'FAN', 'FIN'] }
		];

		const letterOptions = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U'];

		let round = 1;
		let score = 0;
		let best = 0;
		let moves = 0;
		let totalRounds = 5;
		let roundData = null;
		let currentWord = '';
		let currentPath = [];
		let selectedPosition = 0;
		let usedRoundIndexes = [];

		function setStatus(message, type) {
			statusEl.textContent = message;
			statusEl.classList.remove('is-good', 'is-bad');

			if (type === 'good') {
				statusEl.classList.add('is-good');
			} else if (type === 'bad') {
				statusEl.classList.add('is-bad');
			}
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

		function getUniqueRoundData() {
			let availableIndexes = [];

			for (let i = 0; i < ladders.length; i++) {
				if (usedRoundIndexes.indexOf(i) === -1) {
					availableIndexes.push(i);
				}
			}

			if (!availableIndexes.length) {
				usedRoundIndexes = [];
				for (let j = 0; j < ladders.length; j++) {
					availableIndexes.push(j);
				}
			}

			const pickIndex = availableIndexes[Math.floor(Math.random() * availableIndexes.length)];
			usedRoundIndexes.push(pickIndex);
			return ladders[pickIndex];
		}

		function updateStats() {
			scoreEl.textContent = String(score);
			roundEl.textContent = String(round);
			movesEl.textContent = String(moves);
			bestEl.textContent = String(best);
			progressEl.textContent = 'Round ' + round + ' of ' + totalRounds;
		}

		function renderCurrentWord() {
			currentEl.textContent = currentWord;

			for (let i = 0; i < letterValueEls.length; i++) {
				letterValueEls[i].textContent = currentWord.charAt(i) || '';
			}
		}

		function renderHistory() {
			historyListEl.innerHTML = '';

			currentPath.forEach(function (word) {
				const chip = document.createElement('div');
				chip.className = 'wl-history-chip';
				chip.textContent = word;
				historyListEl.appendChild(chip);
			});
		}

		function renderSelectedPosition() {
			selectButtons.forEach(function (button) {
				const position = parseInt(button.getAttribute('data-position'), 10);
				button.classList.toggle('is-active', position === selectedPosition);
			});
		}

		function getAllowedLetters() {
			const nextWord = roundData.path[currentPath.length];
			const letters = [];

			if (nextWord) {
				letters.push(nextWord.charAt(selectedPosition));
			}

			const shuffledExtras = shuffleArray(letterOptions);
			for (let i = 0; i < shuffledExtras.length && letters.length < 8; i++) {
				if (letters.indexOf(shuffledExtras[i]) === -1) {
					letters.push(shuffledExtras[i]);
				}
			}

			return shuffleArray(letters);
		}

		function renderChangeButtons() {
			const letters = getAllowedLetters();

			changeButtons.forEach(function (button, index) {
				const letter = letters[index] || '';
				button.textContent = letter;
				button.disabled = !letter;
				button.setAttribute('data-letter', letter);
			});
		}

		function wordsDifferByOne(a, b) {
			if (a.length !== b.length) {
				return false;
			}

			let diff = 0;

			for (let i = 0; i < a.length; i++) {
				if (a.charAt(i) !== b.charAt(i)) {
					diff++;
				}
			}

			return diff === 1;
		}

		function finishRound() {
			score += 1;
			if (moves < best || best === 0) {
				best = moves;
			}
			updateStats();
			setStatus('Great. You reached ' + roundData.target + '.', 'good');

			window.setTimeout(function () {
				if (round < totalRounds) {
					round += 1;
					startRound();
				} else {
					endGame();
				}
			}, 1000);
		}

		function endGame() {
			setStatus('Finished. Score: ' + score + ' / ' + totalRounds, score >= 3 ? 'good' : '');
			progressEl.textContent = 'Game finished';
		}

		function applyLetter(letter) {
			if (!letter) {
				return;
			}

			const letters = currentWord.split('');
			const oldWord = currentWord;
			letters[selectedPosition] = letter;
			const nextWord = letters.join('');

			if (nextWord === oldWord) {
				setStatus('That letter is already there.', 'bad');
				return;
			}

			if (!wordsDifferByOne(oldWord, nextWord)) {
				setStatus('Change only one letter.', 'bad');
				return;
			}

			const expectedNextWord = roundData.path[currentPath.length];

			if (nextWord !== expectedNextWord) {
				setStatus('That step is not on this ladder. Try another letter.', 'bad');
				return;
			}

			currentWord = nextWord;
			currentPath.push(nextWord);
			moves += 1;
			updateStats();
			renderCurrentWord();
			renderHistory();

			if (currentWord === roundData.target) {
				renderChangeButtons();
				finishRound();
				return;
			}

			renderChangeButtons();
			setStatus('Nice. Change one more letter.', 'good');
		}

		function undoMove() {
			if (currentPath.length <= 1) {
				setStatus('Nothing to undo.', 'bad');
				return;
			}

			currentPath.pop();
			currentWord = currentPath[currentPath.length - 1];
			moves = Math.max(0, moves - 1);
			updateStats();
			renderCurrentWord();
			renderHistory();
			renderChangeButtons();
			setStatus('Last move removed.', '');
		}

		function restartRound() {
			currentWord = roundData.start;
			currentPath = [roundData.start];
			moves = 0;
			selectedPosition = 0;
			updateStats();
			renderCurrentWord();
			renderHistory();
			renderSelectedPosition();
			renderChangeButtons();
			setStatus('Change one letter at a time to reach the target word.', '');
		}

		function startRound() {
			roundData = getUniqueRoundData();
			startEl.textContent = roundData.start;
			targetEl.textContent = roundData.target;
			restartRound();
		}

		selectButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				selectedPosition = parseInt(button.getAttribute('data-position'), 10);
				renderSelectedPosition();
				renderChangeButtons();
				setStatus('Pick a new letter for position ' + (selectedPosition + 1) + '.', '');
			});
		});

		changeButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				const letter = button.getAttribute('data-letter') || '';
				applyLetter(letter);
			});
		});

		undoBtn.addEventListener('click', undoMove);
		restartRoundBtn.addEventListener('click', restartRound);
		restartGameBtn.addEventListener('click', function () {
			round = 1;
			score = 0;
			best = 0;
			usedRoundIndexes = [];
			startRound();
		});

		startRound();
	});
});
JS;

if (!function_exists('zo_game_word_ladder_render')) {
	function zo_game_word_ladder_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-word-ladder-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--word-ladder" id="<?php echo esc_attr($instance_id); ?>">
			<div class="wl-card">
				<h2 class="wl-title">Word Ladder</h2>
				<p class="wl-instructions">Start with the first word. Change one letter at a time to reach the target word. Each step must make a new valid ladder word in this puzzle.</p>

				<div class="wl-topbar">
					<div class="wl-stat">
						<span class="wl-stat-label">Score</span>
						<span class="wl-stat-value wl-score">0</span>
					</div>
					<div class="wl-stat">
						<span class="wl-stat-label">Round</span>
						<span class="wl-stat-value wl-round">1</span>
					</div>
					<div class="wl-stat">
						<span class="wl-stat-label">Moves</span>
						<span class="wl-stat-value wl-moves">0</span>
					</div>
					<div class="wl-stat">
						<span class="wl-stat-label">Best</span>
						<span class="wl-stat-value wl-best">0</span>
					</div>
				</div>

				<div class="wl-goal-card">
					<span class="wl-goal-label">Goal</span>
					<div class="wl-goal-row">
						<div class="wl-word-chip wl-word-chip--start wl-start-word">CAT</div>
						<div class="wl-arrow">→</div>
						<div class="wl-word-chip wl-word-chip--target wl-target-word">DOG</div>
					</div>
				</div>

				<div class="wl-current-card">
					<span class="wl-current-label">Current Word</span>
					<div class="wl-current-word">CAT</div>
				</div>

				<div class="wl-status" aria-live="polite">Change one letter at a time to reach the target word.</div>

				<div class="wl-letters">
					<div class="wl-letter-box">
						<span class="wl-letter-label">Letter 1</span>
						<span class="wl-letter-value">C</span>
					</div>
					<div class="wl-letter-box">
						<span class="wl-letter-label">Letter 2</span>
						<span class="wl-letter-value">A</span>
					</div>
					<div class="wl-letter-box">
						<span class="wl-letter-label">Letter 3</span>
						<span class="wl-letter-value">T</span>
					</div>
				</div>

				<div class="wl-controls">
					<button type="button" class="wl-select-btn is-active" data-position="0">Change 1st</button>
					<button type="button" class="wl-select-btn" data-position="1">Change 2nd</button>
					<button type="button" class="wl-select-btn" data-position="2">Change 3rd</button>
				</div>

				<div class="wl-change-grid">
					<button type="button" class="wl-change-btn" data-letter="">A</button>
					<button type="button" class="wl-change-btn" data-letter="">B</button>
					<button type="button" class="wl-change-btn" data-letter="">C</button>
					<button type="button" class="wl-change-btn" data-letter="">D</button>
					<button type="button" class="wl-change-btn" data-letter="">E</button>
					<button type="button" class="wl-change-btn" data-letter="">F</button>
					<button type="button" class="wl-change-btn" data-letter="">G</button>
					<button type="button" class="wl-change-btn" data-letter="">H</button>
				</div>

				<div class="wl-history-card">
					<h3 class="wl-history-title">Your Ladder</h3>
					<div class="wl-history-list"></div>
				</div>

				<div class="wl-actions">
					<button type="button" class="wl-btn wl-btn--undo">Undo</button>
					<button type="button" class="wl-btn wl-btn--restart-round">Restart Round</button>
					<button type="button" class="wl-btn wl-btn--restart-game">Restart Game</button>
				</div>

				<div class="wl-progress">Round 1 of 5</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'word-ladder',
	'name'            => 'Word Ladder',
	'author'          => 'Arslan',
	'description'     => 'Change one letter at a time to climb from the start word to the target word.',
	'render_callback' => 'zo_game_word_ladder_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);