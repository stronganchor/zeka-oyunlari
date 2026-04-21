<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--time-loop-runner {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #f8fbff;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-tl-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-tl-board {
	display: grid;
	grid-template-columns: repeat(5, 1fr);
	gap: 6px;
	margin-top: 10px;
}

.zo-tl-cell {
	aspect-ratio: 1;
	border-radius: 8px;
	border: 2px solid #cbd5e1;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 13px;
	font-weight: 700;
}

.zo-tl-cell[data-type="wall"] {
	background: #334155;
	color: #fff;
}

.zo-tl-cell[data-type="goal"] {
	background: #16a34a;
	color: #fff;
}

.zo-tl-cell[data-type="start"] {
	background: #2563eb;
	color: #fff;
}

.zo-tl-cell[data-type="path"] {
	background: #a7f3d0;
}

.zo-tl-routine {
	min-height: 36px;
	text-align: center;
	font-weight: 700;
	font-size: 18px;
	background: #e0f2fe;
	border-radius: 10px;
	padding: 8px;
}

.zo-tl-controls {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-tl-control {
	border: 0;
	border-radius: 10px;
	padding: 10px;
	font-weight: 700;
	background: #1e3a8a;
	color: #fff;
	cursor: pointer;
}

.zo-tl-actions,
.zo-tl-hud {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-top: 10px;
}

.zo-tl-btn {
	border: 0;
	border-radius: 10px;
	padding: 10px;
	background: #2563eb;
	color: #fff;
	font-weight: 700;
}

.zo-tl-stat {
	background: #eef2ff;
	border-radius: 10px;
	padding: 10px;
	text-align: center;
}

.zo-tl-status {
	min-height: 24px;
	text-align: center;
	font-weight: 700;
	margin-top: 10px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--time-loop-runner')) {
			return;
		}

		const board = game.querySelector('.zo-tl-board');
		const routine = game.querySelector('.zo-tl-routine');
		const status = game.querySelector('.zo-tl-status');
		const scoreEl = game.querySelector('.zo-tl-score');
		const roundEl = game.querySelector('.zo-tl-round');
		const inputEl = game.querySelector('.zo-tl-input');
		const startBtn = game.querySelector('.zo-tl-start');
		const checkBtn = game.querySelector('.zo-tl-check');
		const replayBtn = game.querySelector('.zo-tl-replay');
		const moveButtons = game.querySelectorAll('.zo-tl-control[data-move]');

		const size = 5;
		const total = 25;
		const startIndex = 0;
		const goalIndex = total - 1;
		const walls = {
			6: true,
			7: true,
			11: true,
			12: true,
			18: true,
		};

		let cells = [];
		let round = 1;
		let score = 0;
		let target = [];
		let moves = [];
		let accepting = false;
		let pathReplay = '';
		let lockedButtons = false;
		let lives = 3;

		function indexToRC(index) {
			return {
				r: Math.floor(index / size),
				c: index % size,
			};
		}

		for (let i = 0; i < total; i++) {
			const cell = document.createElement('button');
			cell.type = 'button';
			cell.className = 'zo-tl-cell';
			cell.dataset.index = String(i);
			cell.setAttribute('aria-label', 'Grid cell');
			board.appendChild(cell);
			cells.push(cell);
		}

		function paint() {
			cells.forEach(function (cell, index) {
				cell.textContent = '';
				cell.setAttribute('data-type', '');
				if (index === startIndex) {
					cell.setAttribute('data-type', 'start');
					cell.textContent = 'S';
				} else if (index === goalIndex) {
					cell.setAttribute('data-type', 'goal');
					cell.textContent = 'G';
				} else if (walls[index]) {
					cell.setAttribute('data-type', 'wall');
				}
			});
		}

		function newRoutine() {
			target = [];
			const moveset = ['U', 'D', 'L', 'R'];
			for (let i = 0; i < 5; i++) {
				target.push(moveset[Math.floor(Math.random() * moveset.length)]);
			}
			pathReplay = target.join(' ');
			routine.textContent = 'Repeat: ' + pathReplay;
		}

		function markCell(index, type) {
			if (index === startIndex || index === goalIndex || walls[index]) {
				return;
			}
			cells[index].setAttribute('data-type', type);
		}

		function clearPathMarks() {
			cells.forEach(function (cell, index) {
				if (index === startIndex || index === goalIndex || walls[index]) {
					return;
				}
				cell.removeAttribute('data-type');
			});
		}

		function runSimulation(sequence) {
			let index = startIndex;
			const blocked = Object.assign({}, walls);
			const steps = [];
			for (let i = 0; i < sequence.length; i++) {
				const move = sequence[i];
				const pos = indexToRC(index);
				let nr = pos.r;
				let nc = pos.c;
				if (move === 'U') {
					nr -= 1;
				}
				if (move === 'D') {
					nr += 1;
				}
				if (move === 'L') {
					nc -= 1;
				}
				if (move === 'R') {
					nc += 1;
				}
				if (nr < 0 || nc < 0 || nr >= size || nc >= size) {
					return { ok: false, reason: 'Out of bounds' };
				}
				const next = nr * size + nc;
				if (blocked[next]) {
					return { ok: false, reason: 'Hit obstacle' };
				}
				index = next;
				steps.push(index);
			}
			return { ok: true, index: index, steps: steps };
		}

		function startRound() {
			accepting = false;
			lockedButtons = false;
			moves = [];
			inputEl.textContent = '';
			clearPathMarks();
			moveButtons.forEach(function (button) {
				button.disabled = true;
			});
			checkBtn.disabled = true;
			newRoutine();
			status.textContent = 'Watch the loop sequence.';
			setTimeout(function () {
				status.textContent = 'Repeat it now.';
				routine.textContent = '';
				accepting = true;
				lockedButtons = false;
				moveButtons.forEach(function (button) {
					button.disabled = false;
				});
				checkBtn.disabled = false;
			}, 1500);
		}

		moveButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				if (!accepting || lockedButtons) {
					return;
				}
				const move = button.dataset.move;
				moves.push(move);
				inputEl.textContent = moves.join(' ');
				if (moves.length >= target.length) {
					accepting = false;
					moveButtons.forEach(function (btn) {
						btn.disabled = true;
					});
					checkBtn.disabled = false;
				}
			});
		});

		checkBtn.addEventListener('click', function () {
			if (moves.length < target.length) {
				status.textContent = 'Add all 5 moves.';
				return;
			}
			const result = runSimulation(moves);
			if (result.ok && result.index === goalIndex) {
				score += 1;
				round += 1;
				status.textContent = 'Great loop! You reached the goal.';
				result.steps.forEach(function (index) {
					markCell(index, 'path');
				});
				scoreEl.textContent = String(score);
				roundEl.textContent = String(round);
				setTimeout(function () {
					startRound();
				}, 900);
			} else {
				status.textContent = result.reason || 'Wrong path.';
				lives = lives - 1;
				if (lives <= 0) {
					status.textContent = 'No lives. Press Start.';
					checkBtn.disabled = true;
					replayBtn.disabled = true;
					moveButtons.forEach(function (btn) {
						btn.disabled = true;
					});
					return;
				}
				startRound();
			}
		});

		replayBtn.addEventListener('click', function () {
			if (!target.length) {
				return;
			}
			routine.textContent = 'Repeat: ' + pathReplay;
		});

		startBtn.addEventListener('click', function () {
			score = 0;
			round = 1;
			lives = 3;
			updateHud();
			paint();
			startRound();
		});

		function updateHud() {
			scoreEl.textContent = String(score);
			roundEl.textContent = String(round);
		}

		paint();
		updateHud();
		status.textContent = 'Press Start.';
	});
});
JS;

if (!function_exists('zo_game_time_loop_runner_render')) {
	function zo_game_time_loop_runner_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-time-loop-runner-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--time-loop-runner" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-tl-title">Time Loop Runner</h2>
			<div class="zo-tl-routine">Press Start.</div>
			<div class="zo-tl-board"></div>
			<div class="zo-tl-actions">
				<button type="button" class="zo-tl-control" data-move="U">Up</button>
				<button type="button" class="zo-tl-control" data-move="L">Left</button>
				<button type="button" class="zo-tl-control" data-move="R">Right</button>
				<button type="button" class="zo-tl-control" data-move="D">Down</button>
			</div>
			<div class="zo-tl-hud">
				<div class="zo-tl-stat">Score: <span class="zo-tl-score">0</span></div>
				<div class="zo-tl-stat">Round: <span class="zo-tl-round">1</span></div>
				<div class="zo-tl-stat">Your input: <span class="zo-tl-input"></span></div>
			</div>
			<div class="zo-tl-controls">
				<button type="button" class="zo-tl-btn zo-tl-start">Start</button>
				<button type="button" class="zo-tl-btn zo-tl-check">Check</button>
				<button type="button" class="zo-tl-btn zo-tl-replay">Replay</button>
			</div>
			<div class="zo-tl-status">Press Start.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'time-loop-runner',
	'name'            => 'Time Loop Runner',
	'author'          => 'Asker',
	'description'     => 'Watch a 5 step sequence and replay the moves without crashing.',
	'render_callback' => 'zo_game_time_loop_runner_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
