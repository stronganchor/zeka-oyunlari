<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--lantern-hunt {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #f8fbff;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-lh-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-lh-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 6px;
	margin-top: 10px;
}

.zo-lh-card {
	aspect-ratio: 1;
	border: 2px solid #cbd5e1;
	border-radius: 10px;
	background: #ffffff;
	font-size: 28px;
	font-weight: 700;
	cursor: pointer;
}

.zo-lh-card[data-state="open"],
.zo-lh-card[data-state="matched"] {
	color: #0f172a;
}

.zo-lh-card[data-state="hidden"] {
	background: #e2e8f0;
}

.zo-lh-hints {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 6px;
	margin-top: 10px;
}

.zo-lh-hints button {
	border: 0;
	border-radius: 8px;
	padding: 8px 4px;
	font-size: 12px;
	background: #334155;
	color: #fff;
	font-weight: 700;
	cursor: pointer;
}

.zo-lh-hints button:disabled {
	opacity: 0.45;
}

.zo-lh-controls {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-lh-btn {
	border: 0;
	border-radius: 10px;
	padding: 10px;
	font-weight: 700;
	background: #2563eb;
	color: #fff;
	cursor: pointer;
}

.zo-lh-stat {
	padding: 10px;
	background: #eef2ff;
	border-radius: 10px;
	text-align: center;
}

.zo-lh-status {
	min-height: 24px;
	text-align: center;
	font-weight: 700;
	margin-top: 8px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--lantern-hunt')) {
			return;
		}

		const board = game.querySelector('.zo-lh-grid');
		const status = game.querySelector('.zo-lh-status');
		const scoreEl = game.querySelector('.zo-lh-score');
		const movesEl = game.querySelector('.zo-lh-moves');
		const rowHintButtons = game.querySelectorAll('.zo-lh-row-hint');
		const colHintButtons = game.querySelectorAll('.zo-lh-col-hint');
		const resetBtn = game.querySelector('.zo-lh-reset');
		const newBtn = game.querySelector('.zo-lh-new');

		const size = 4;
		const total = 16;
		let symbols = [];
		let boardState = [];
		let openCards = [];
		let matched = 0;
		let score = 0;
		let moves = 0;
		let rowUsed = [];
		let colUsed = [];

		for (let i = 0; i < total; i++) {
			const btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'zo-lh-card';
			btn.dataset.index = String(i);
			btn.dataset.state = 'hidden';
			btn.textContent = '?';
			btn.setAttribute('aria-label', 'Hidden lantern card');
			btn.addEventListener('click', function () {
				openCard(i);
			});
			board.appendChild(btn);
		}

		const cells = board.querySelectorAll('.zo-lh-card');

		function shuffle(arr) {
			const copy = arr.slice();
			for (let i = copy.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const t = copy[i];
				copy[i] = copy[j];
				copy[j] = t;
			}
			return copy;
		}

		function newGame() {
			const base = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
			symbols = shuffle(base.concat(base));
			boardState = symbols;
			matched = 0;
			openCards = [];
			moves = 0;
			rowUsed = Array(size).fill(false);
			colUsed = Array(size).fill(false);
			cells.forEach(function (cell, idx) {
				cell.dataset.state = 'hidden';
				cell.textContent = '?';
				cell.disabled = false;
			});
			rowHintButtons.forEach(function (button) {
				button.disabled = false;
			});
			colHintButtons.forEach(function (button) {
				button.disabled = false;
			});
			scoreEl.textContent = String(score);
			movesEl.textContent = String(moves);
			status.textContent = 'Open matching pairs. Use few hints.';
		}

		function checkWin() {
			if (matched >= total) {
				score += 1;
				scoreEl.textContent = String(score);
				status.textContent = 'Great! Board solved.';
				cells.forEach(function (cell) {
					cell.disabled = true;
				});
			}
		}

		function hideCard(index) {
			const cell = cells[index];
			if (cell.dataset.state === 'matched') {
				return;
			}
			cell.dataset.state = 'hidden';
			cell.textContent = '?';
		}

		function openCard(index) {
			const cell = cells[index];
			if (cell.dataset.state !== 'hidden') {
				return;
			}
			cell.dataset.state = 'open';
			cell.textContent = boardState[index];
			openCards.push(index);
			if (openCards.length === 2) {
				const first = openCards[0];
				const second = openCards[1];
				moves += 1;
				movesEl.textContent = String(moves);
				if (boardState[first] === boardState[second]) {
					cells[first].dataset.state = 'matched';
					cells[second].dataset.state = 'matched';
					matched += 2;
					openCards = [];
					checkWin();
				} else {
					const old = openCards.slice();
					openCards = [];
					setTimeout(function () {
						hideCard(old[0]);
						hideCard(old[1]);
					}, 600);
				}
			}
		}

		function revealHint(type, index) {
			let candidates = [];
			if (type === 'row') {
				if (rowUsed[index]) {
					return;
				}
				rowUsed[index] = true;
			}
			if (type === 'col') {
				if (colUsed[index]) {
					return;
				}
				colUsed[index] = true;
			}

			for (let i = 0; i < total; i++) {
				const r = Math.floor(i / size);
				const c = i % size;
				if (type === 'row' && r !== index) {
					continue;
				}
				if (type === 'col' && c !== index) {
					continue;
				}
				if (cells[i].dataset.state === 'hidden') {
					candidates.push(i);
				}
			}
			if (!candidates.length) {
				return;
			}

			const chosen = candidates[Math.floor(Math.random() * candidates.length)];
			const card = cells[chosen];
			card.dataset.state = 'open';
			card.textContent = boardState[chosen];
			setTimeout(function () {
				if (card.dataset.state === 'open') {
					card.dataset.state = 'hidden';
					card.textContent = '?';
				}
			}, 900);
			status.textContent = 'Hint used.';
		}

		rowHintButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				const index = Number(button.dataset.index);
				button.disabled = true;
				revealHint('row', index);
			});
		});

		colHintButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				const index = Number(button.dataset.index);
				button.disabled = true;
				revealHint('col', index);
			});
		});

		resetBtn.addEventListener('click', function () {
			newGame();
		});

		newBtn.addEventListener('click', function () {
			newGame();
		});

		newGame();
	});
});
JS;

if (!function_exists('zo_game_lantern_hunt_render')) {
	function zo_game_lantern_hunt_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-lantern-hunt-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--lantern-hunt" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-lh-title">Lantern Hunt</h2>
			<div class="zo-lh-grid"></div>
			<div class="zo-lh-hints">
				<button type="button" class="zo-lh-row-hint" data-index="0">Row 1</button>
				<button type="button" class="zo-lh-row-hint" data-index="1">Row 2</button>
				<button type="button" class="zo-lh-row-hint" data-index="2">Row 3</button>
				<button type="button" class="zo-lh-row-hint" data-index="3">Row 4</button>
				<button type="button" class="zo-lh-col-hint" data-index="0">Col 1</button>
				<button type="button" class="zo-lh-col-hint" data-index="1">Col 2</button>
				<button type="button" class="zo-lh-col-hint" data-index="2">Col 3</button>
				<button type="button" class="zo-lh-col-hint" data-index="3">Col 4</button>
			</div>
			<div class="zo-lh-controls">
				<button type="button" class="zo-lh-btn zo-lh-reset">Reset</button>
				<button type="button" class="zo-lh-btn zo-lh-new">New</button>
				<div class="zo-lh-stat">Moves: <span class="zo-lh-moves">0</span></div>
				<div class="zo-lh-stat">Score: <span class="zo-lh-score">0</span></div>
			</div>
			<div class="zo-lh-status">Open matching pairs.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'lantern-hunt',
	'name'            => 'Lantern Hunt',
	'author'          => 'Asker',
	'description'     => 'Reveal one cell at a time by row or column hints and match all lantern pairs.',
	'render_callback' => 'zo_game_lantern_hunt_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
