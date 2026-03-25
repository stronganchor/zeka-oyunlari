<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--category-blitz {
	font-family: Arial, sans-serif;
	background: linear-gradient(180deg, #f7f9ff 0%, #eef3ff 100%);
	color: #1f2940;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
	border: 2px solid #d9e3ff;
}

.zo-game-root--category-blitz * {
	box-sizing: border-box;
}

.zo-game-root--category-blitz .cb-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #2b4ea2;
}

.zo-game-root--category-blitz .cb-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #4d5d87;
	margin-bottom: 14px;
}

.zo-game-root--category-blitz .cb-topbar {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--category-blitz .cb-stat {
	background: #ffffff;
	border: 1px solid #d8e2ff;
	border-radius: 14px;
	padding: 10px 12px;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--category-blitz .cb-panel {
	background: #ffffff;
	border: 1px solid #d8e2ff;
	border-radius: 16px;
	padding: 16px;
	margin-bottom: 14px;
}

.zo-game-root--category-blitz .cb-round {
	font-size: 14px;
	color: #6b7aa6;
	margin-bottom: 8px;
	text-transform: uppercase;
	letter-spacing: 0.06em;
}

.zo-game-root--category-blitz .cb-letter {
	font-size: 58px;
	font-weight: 700;
	line-height: 1;
	color: #21409a;
	margin-bottom: 8px;
}

.zo-game-root--category-blitz .cb-category {
	font-size: 28px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--category-blitz .cb-status {
	font-size: 16px;
	line-height: 1.5;
	color: #4d5d87;
	min-height: 24px;
}

.zo-game-root--category-blitz .cb-input-row {
	display: flex;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 14px;
}

.zo-game-root--category-blitz .cb-input {
	flex: 1 1 280px;
	width: 100%;
	padding: 14px 14px;
	font-size: 18px;
	border: 1px solid #b9c9f5;
	border-radius: 12px;
	outline: none;
	background: #fff;
	color: #1f2940;
}

.zo-game-root--category-blitz .cb-input:focus {
	border-color: #4a73de;
	box-shadow: 0 0 0 3px rgba(74, 115, 222, 0.12);
}

.zo-game-root--category-blitz .cb-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--category-blitz .cb-btn {
	appearance: none;
	border: 1px solid #5578d8;
	background: #2c4f9e;
	color: #fff;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	min-width: 140px;
}

.zo-game-root--category-blitz .cb-btn:hover,
.zo-game-root--category-blitz .cb-btn:focus {
	background: #3a63c2;
	outline: none;
}

.zo-game-root--category-blitz .cb-btn--secondary {
	background: #ffffff;
	color: #2c4f9e;
}

.zo-game-root--category-blitz .cb-btn--secondary:hover,
.zo-game-root--category-blitz .cb-btn--secondary:focus {
	background: #eef3ff;
}

.zo-game-root--category-blitz .cb-history {
	background: #ffffff;
	border: 1px solid #d8e2ff;
	border-radius: 16px;
	padding: 14px;
	text-align: left;
}

.zo-game-root--category-blitz .cb-history-title {
	font-size: 15px;
	font-weight: 700;
	color: #57688f;
	margin-bottom: 10px;
	text-transform: uppercase;
	letter-spacing: 0.06em;
}

.zo-game-root--category-blitz .cb-history-list {
	display: flex;
	flex-direction: column;
	gap: 8px;
}

.zo-game-root--category-blitz .cb-history-item {
	background: #f7f9ff;
	border: 1px solid #e1e8ff;
	border-radius: 12px;
	padding: 10px 12px;
	font-size: 14px;
	line-height: 1.45;
	color: #33415f;
}

.zo-game-root--category-blitz .cb-history-item strong {
	color: #1f2940;
}

@media (max-width: 640px) {
	.zo-game-root--category-blitz .cb-title {
		font-size: 26px;
	}

	.zo-game-root--category-blitz .cb-topbar {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--category-blitz .cb-letter {
		font-size: 46px;
	}

	.zo-game-root--category-blitz .cb-category {
		font-size: 24px;
	}

	.zo-game-root--category-blitz .cb-btn {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--category-blitz');

	games.forEach(function (game) {
		const roundsPerGame = 10;
		const roundTime = 12;

		const categories = [
			'Animal',
			'Food',
			'Fruit',
			'Color',
			'Country',
			'City',
			'Job',
			'Sport',
			'School Thing',
			'Clothing',
			'Body Part',
			'Vehicle',
			'Toy',
			'Thing in a House',
			'Thing in Nature'
		];

		const letters = 'ABCDEFGHIKLMNOPRSTUVWY'.split('');

		const els = {
			score: game.querySelector('[data-role="score"]'),
			round: game.querySelector('[data-role="round"]'),
			timer: game.querySelector('[data-role="timer"]'),
			best: game.querySelector('[data-role="best"]'),
			letter: game.querySelector('[data-role="letter"]'),
			category: game.querySelector('[data-role="category"]'),
			status: game.querySelector('[data-role="status"]'),
			input: game.querySelector('[data-role="input"]'),
			submit: game.querySelector('[data-role="submit"]'),
			skip: game.querySelector('[data-role="skip"]'),
			restart: game.querySelector('[data-role="restart"]'),
			history: game.querySelector('[data-role="history"]')
		};

		const state = {
			score: 0,
			best: 0,
			round: 1,
			timeLeft: roundTime,
			currentLetter: '',
			currentCategory: '',
			timerId: null,
			gameOver: false,
			usedPairs: new Set(),
			history: []
		};

		function randomFrom(arr) {
			return arr[Math.floor(Math.random() * arr.length)];
		}

		function makePair() {
			let tries = 0;
			while (tries < 200) {
				const letter = randomFrom(letters);
				const category = randomFrom(categories);
				const key = letter + '|' + category;
				if (!state.usedPairs.has(key)) {
					state.usedPairs.add(key);
					return { letter: letter, category: category };
				}
				tries++;
			}
			return { letter: randomFrom(letters), category: randomFrom(categories) };
		}

		function clearTimer() {
			if (state.timerId) {
				window.clearInterval(state.timerId);
				state.timerId = null;
			}
		}

		function normalize(text) {
			return text
				.toLowerCase()
				.replace(/[^a-zA-ZğüşöçıİĞÜŞÖÇ\s-]/g, '')
				trim();
		}

		function startsWithLetter(answer, letter) {
			if (!answer) {
				return false;
			}
			const first = answer.charAt(0).toUpperCase();
			return first === letter.toUpperCase();
		}

		function updateHud() {
			els.score.textContent = String(state.score);
			els.round.textContent = String(state.round) + ' / ' + String(roundsPerGame);
			els.timer.textContent = String(state.timeLeft);
			els.best.textContent = String(state.best);
			els.letter.textContent = state.currentLetter;
			els.category.textContent = state.currentCategory;
		}

		function renderHistory() {
			els.history.innerHTML = '';

			if (state.history.length === 0) {
				const item = document.createElement('div');
				item.className = 'cb-history-item';
				item.textContent = 'No answers yet.';
				els.history.appendChild(item);
				return;
			}

			state.history.slice().reverse().forEach(function (entry) {
				const item = document.createElement('div');
				item.className = 'cb-history-item';
				item.innerHTML = '<strong>' + entry.letter + ' - ' + entry.category + '</strong>: ' + entry.answer + ' (' + entry.result + ')';
				els.history.appendChild(item);
			});
		}

		function setStatus(text) {
			els.status.textContent = text;
		}

		function nextRound() {
			clearTimer();

			if (state.round > roundsPerGame) {
				endGame();
				return;
			}

			const pair = makePair();
			state.currentLetter = pair.letter;
			state.currentCategory = pair.category;
			state.timeLeft = roundTime;
			els.input.value = '';
			updateHud();
			setStatus('Type a word that matches the category and starts with ' + state.currentLetter + '.');
			startTimer();
			els.input.focus();
		}

		function startTimer() {
			clearTimer();
			state.timerId = window.setInterval(function () {
				state.timeLeft -= 1;
				updateHud();

				if (state.timeLeft <= 0) {
					recordAnswer('(no answer)', 'timeout');
					state.round += 1;
					nextRound();
				}
			}, 1000);
		}

		function recordAnswer(answer, result) {
			state.history.push({
				letter: state.currentLetter,
				category: state.currentCategory,
				answer: answer,
				result: result
			});
			renderHistory();
		}

		function submitAnswer() {
			if (state.gameOver) {
				return;
			}

			const raw = els.input.value.trim();
			const answer = normalize(raw);

			if (!raw) {
				setStatus('Type an answer first.');
				els.input.focus();
				return;
			}

			if (startsWithLetter(answer, state.currentLetter)) {
				state.score += 1;
				recordAnswer(raw, 'correct');
				setStatus('Correct.');
			} else {
				recordAnswer(raw, 'wrong letter');
				setStatus('That does not start with ' + state.currentLetter + '.');
			}

			state.round += 1;
			nextRound();
		}

		function skipRound() {
			if (state.gameOver) {
				return;
			}

			recordAnswer('(skipped)', 'skipped');
			state.round += 1;
			nextRound();
		}

		function endGame() {
			clearTimer();
			state.gameOver = true;
			if (state.score > state.best) {
				state.best = state.score;
			}
			updateHud();
			setStatus('Game over. Final score: ' + state.score + ' out of ' + roundsPerGame + '.');
		}

		function restartGame() {
			clearTimer();
			state.score = 0;
			state.round = 1;
			state.timeLeft = roundTime;
			state.currentLetter = '';
			state.currentCategory = '';
			state.gameOver = false;
			state.usedPairs = new Set();
			state.history = [];
			renderHistory();
			nextRound();
		}

		els.submit.addEventListener('click', function () {
			submitAnswer();
		});

		els.skip.addEventListener('click', function () {
			skipRound();
		});

		els.restart.addEventListener('click', function () {
			restartGame();
		});

		els.input.addEventListener('keydown', function (e) {
			if (e.key === 'Enter') {
				submitAnswer();
				e.preventDefault();
			}
		});

		renderHistory();
		restartGame();
	});
});
JS;

if (!function_exists('zo_game_category_blitz_render')) {
	function zo_game_category_blitz_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-category-blitz-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--category-blitz" id="<?php echo esc_attr($instance_id); ?>">
			<div class="cb-title">Category Blitz</div>
			<div class="cb-instructions">Each round gives you one letter and one category. Type a word that matches both before the timer runs out.</div>

			<div class="cb-topbar">
				<div class="cb-stat">Score: <span data-role="score">0</span></div>
				<div class="cb-stat">Round: <span data-role="round">1 / 10</span></div>
				<div class="cb-stat">Time: <span data-role="timer">12</span></div>
				<div class="cb-stat">Best: <span data-role="best">0</span></div>
			</div>

			<div class="cb-panel">
				<div class="cb-round">Current Challenge</div>
				<div class="cb-letter" data-role="letter">A</div>
				<div class="cb-category" data-role="category">Animal</div>
				<div class="cb-status" data-role="status">Type a word that matches the category and starts with the shown letter.</div>
			</div>

			<div class="cb-input-row">
				<input type="text" class="cb-input" data-role="input" placeholder="Type your answer here" maxlength="40" autocomplete="off" />
			</div>

			<div class="cb-actions">
				<button type="button" class="cb-btn" data-role="submit">Submit</button>
				<button type="button" class="cb-btn cb-btn--secondary" data-role="skip">Skip</button>
				<button type="button" class="cb-btn cb-btn--secondary" data-role="restart">Restart</button>
			</div>

			<div class="cb-history">
				<div class="cb-history-title">Round History</div>
				<div class="cb-history-list" data-role="history"></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'category-blitz',
	'name'            => 'Category Blitz',
	'author'          => 'Arslan',
	'description'     => 'A fast category word game where players answer with the correct starting letter before time runs out.',
	'render_callback' => 'zo_game_category_blitz_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);