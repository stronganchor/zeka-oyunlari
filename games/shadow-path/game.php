<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--shadow-path {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	box-sizing: border-box;
	border-radius: 14px;
	border: 2px solid #d8e2ec;
	background: #f7fbff;
	font-family: Arial, sans-serif;
}

.zo-sp-title {
	text-align: center;
	margin: 0 0 8px;
}

.zo-sp-board {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-sp-cell {
	min-height: 62px;
	border: 2px solid #aeb8c7;
	border-radius: 12px;
	background: #ecf2f9;
	cursor: pointer;
	font-size: 28px;
	font-weight: 700;
	color: #0f172a;
}

.zo-sp-cell.is-path {
	background: #fef08a;
	color: #111827;
}

.zo-sp-cell.is-correct {
	background: #dcfce7;
	border-color: #22c55e;
}

.zo-sp-cell.is-wrong {
	background: #fee2e2;
	border-color: #ef4444;
}

.zo-sp-hud {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	align-items: center;
	text-align: center;
}

.zo-sp-stat,
.zo-sp-button {
	background: #eef2ff;
	border-radius: 10px;
	padding: 8px;
}

.zo-sp-button {
	background: #2563eb;
	color: #fff;
	font-weight: 700;
	border: 0;
	cursor: pointer;
}

.zo-sp-status {
	min-height: 24px;
	text-align: center;
	margin-top: 10px;
	font-weight: 700;
}

@media (max-width: 640px) {
	.zo-sp-cell {
		min-height: 56px;
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--shadow-path')) {
			return;
		}

		const board = game.querySelector('.zo-sp-board');
		const startButton = game.querySelector('.zo-sp-start');
		const status = game.querySelector('.zo-sp-status');
		const scoreEl = game.querySelector('.zo-sp-score');
		const roundEl = game.querySelector('.zo-sp-round');

		const size = 4;
		const total = size * size;
		const targetLength = 8;

		let path = [];
		let expectedStep = 0;
		let round = 1;
		let score = 0;
		let canAnswer = false;
		const cells = [];

		for (let i = 0; i < total; i++) {
			const btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'zo-sp-cell';
			btn.dataset.index = String(i);
			btn.setAttribute('aria-label', 'Path cell');
			btn.addEventListener('click', handleInput);
			cells.push(btn);
			board.appendChild(btn);
		}

		function coord(index) {
			return {
				r: Math.floor(index / size),
				c: index % size,
			};
		}

		function isNeighbor(a, b) {
			const c1 = coord(a);
			const c2 = coord(b);
			return Math.abs(c1.r - c2.r) + Math.abs(c1.c - c2.c) === 1;
		}

		function randomPath() {
			const start = Math.floor(Math.random() * total);
			const values = [start];

			while (values.length < targetLength) {
				const current = values[values.length - 1];
				const c = coord(current);
				const options = [];
				if (c.r > 0) {
					options.push(current - size);
				}
				if (c.r < size - 1) {
					options.push(current + size);
				}
				if (c.c > 0) {
					options.push(current - 1);
				}
				if (c.c < size - 1) {
					options.push(current + 1);
				}
				const free = options.filter(function (item) {
					return values.indexOf(item) === -1;
				});
				if (!free.length) {
					break;
				}
				values.push(free[Math.floor(Math.random() * free.length)]);
			}

			return values;
		}

		function resetBoard() {
			cells.forEach(function (cell) {
				cell.textContent = '';
				cell.disabled = false;
				cell.classList.remove('is-path', 'is-correct', 'is-wrong');
			});
		}

		function clearPath() {
			path.forEach(function (index) {
				cells[index].classList.remove('is-path');
			});
		}

		function showPath() {
			path.forEach(function (index, step) {
				cells[index].textContent = String(step + 1);
				cells[index].classList.add('is-path');
			});
		}

		function startRound() {
			path = randomPath();
			expectedStep = 0;
			canAnswer = false;
			resetBoard();
			status.textContent = 'Watch the glowing path.';
			showPath();
			setTimeout(function () {
				clearPath();
				status.textContent = 'Repeat the path in order.';
				canAnswer = true;
			}, 1700);
		}

		function handleInput(e) {
			if (!canAnswer) {
				return;
			}

			const index = Number(e.currentTarget.dataset.index);
			const cell = e.currentTarget;
			const expected = path[expectedStep];

			if (!Number.isFinite(index)) {
				return;
			}

			if (index === expected) {
				cell.textContent = String(expectedStep + 1);
				cell.classList.add('is-correct');
				if (expectedStep >= 1) {
					const prev = path[expectedStep - 1];
					if (!isNeighbor(prev, index)) {
						status.textContent = 'Path jumped. Retry.';
						canAnswer = false;
						return;
					}
				}
				expectedStep += 1;
				if (expectedStep === path.length) {
					score += 1;
					round += 1;
					scoreEl.textContent = String(score);
					roundEl.textContent = String(round);
					canAnswer = false;
					status.textContent = 'Great job! Press start for next round.';
				}
			} else {
				status.textContent = 'Wrong order. Press start to try again.';
				canAnswer = false;
				cell.classList.add('is-wrong');
			}
		}

		startButton.addEventListener('click', function () {
			startRound();
		});

		scoreEl.textContent = String(score);
		roundEl.textContent = String(round);
		status.textContent = 'Press start to begin.';
		startRound();
	});
});
JS;

if (!function_exists('zo_game_shadow_path_render')) {
	function zo_game_shadow_path_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-shadow-path-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--shadow-path" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-sp-title">Shadow Path</h2>
			<div class="zo-sp-hud">
				<div class="zo-sp-stat">Score: <span class="zo-sp-score">0</span></div>
				<div class="zo-sp-stat">Round: <span class="zo-sp-round">1</span></div>
				<button type="button" class="zo-sp-button zo-sp-start">Start</button>
			</div>
			<div class="zo-sp-board"></div>
			<div class="zo-sp-status">Press start to begin.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'shadow-path',
	'name'            => 'Shadow Path',
	'author'          => 'Asker',
	'description'     => 'Watch a hidden path and repeat the cells in order.',
	'render_callback' => 'zo_game_shadow_path_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
