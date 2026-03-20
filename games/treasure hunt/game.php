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

.zo-game-root--treasure-hunt {
	font-family: Arial, sans-serif;
	background: linear-gradient(180deg, #f7fbf3 0%, #edf7e7 100%);
	color: #1f2a1f;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
	border: 2px solid #cfe5c1;
}

.zo-game-root--treasure-hunt * {
	box-sizing: border-box;
}

.zo-game-root--treasure-hunt .th-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #2a5d2a;
}

.zo-game-root--treasure-hunt .th-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #3f5540;
	margin-bottom: 14px;
}

.zo-game-root--treasure-hunt .th-topbar {
	background: #222;
	color: #fff;
	border-radius: 14px;
	padding: 14px;
	margin-bottom: 14px;
	text-align: left;
}

.zo-game-root--treasure-hunt .th-score {
	font-size: 18px;
	font-weight: 700;
	margin-bottom: 6px;
}

.zo-game-root--treasure-hunt .th-help {
	font-size: 13px;
	color: #d9d9d9;
}

.zo-game-root--treasure-hunt .th-message {
	margin-top: 8px;
	font-size: 18px;
	font-weight: 700;
}

.zo-game-root--treasure-hunt .th-message--win {
	color: #7dff9c;
}

.zo-game-root--treasure-hunt .th-message--lose {
	color: #ff8080;
}

.zo-game-root--treasure-hunt .th-board-wrap {
	display: flex;
	justify-content: center;
	margin-bottom: 14px;
}

.zo-game-root--treasure-hunt .th-board {
	display: grid;
	grid-template-columns: repeat(10, minmax(0, 1fr));
	gap: 4px;
	width: 100%;
	max-width: 560px;
	aspect-ratio: 1 / 1;
	background: #bcd8ab;
	border: 3px solid #8fb37d;
	border-radius: 16px;
	padding: 8px;
	touch-action: none;
}

.zo-game-root--treasure-hunt .th-cell {
	position: relative;
	background: #dff5d8;
	border: 1px solid #93af8a;
	border-radius: 8px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 24px;
	font-weight: 700;
	user-select: none;
	aspect-ratio: 1 / 1;
}

.zo-game-root--treasure-hunt .th-cell__player {
	width: 68%;
	height: 68%;
	border-radius: 50%;
	background: #2f6fff;
	border: 2px solid #111;
	color: #fff;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 18px;
	font-weight: 700;
}

.zo-game-root--treasure-hunt .th-cell__treasure {
	width: 64%;
	height: 64%;
	border-radius: 8px;
	background: gold;
	border: 2px solid brown;
	color: #111;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 18px;
	font-weight: 700;
}

.zo-game-root--treasure-hunt .th-cell__trap {
	width: 64%;
	height: 64%;
	border-radius: 8px;
	background: #d93030;
	border: 2px solid #111;
	color: #fff;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 18px;
	font-weight: 700;
}

.zo-game-root--treasure-hunt .th-actions {
	display: flex;
	flex-direction: column;
	align-items: center;
	gap: 12px;
}

.zo-game-root--treasure-hunt .th-btn {
	appearance: none;
	border: 1px solid #5578d8;
	background: #2c4f9e;
	color: #fff;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	min-width: 180px;
}

.zo-game-root--treasure-hunt .th-btn:hover,
.zo-game-root--treasure-hunt .th-btn:focus {
	background: #3a63c2;
	outline: none;
}

.zo-game-root--treasure-hunt .th-mobile-controls {
	display: grid;
	grid-template-columns: repeat(3, 64px);
	grid-template-rows: repeat(2, 64px);
	gap: 8px;
	justify-content: center;
}

.zo-game-root--treasure-hunt .th-move {
	appearance: none;
	border: 1px solid #7b9680;
	background: #eef5e7;
	color: #223022;
	border-radius: 12px;
	font-size: 24px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--treasure-hunt .th-move:hover,
.zo-game-root--treasure-hunt .th-move:focus {
	background: #dfead4;
	outline: none;
}

.zo-game-root--treasure-hunt .th-move--up {
	grid-column: 2;
	grid-row: 1;
}

.zo-game-root--treasure-hunt .th-move--left {
	grid-column: 1;
	grid-row: 2;
}

.zo-game-root--treasure-hunt .th-move--down {
	grid-column: 2;
	grid-row: 2;
}

.zo-game-root--treasure-hunt .th-move--right {
	grid-column: 3;
	grid-row: 2;
}

@media (max-width: 640px) {
	.zo-game-root--treasure-hunt .th-title {
		font-size: 26px;
	}

	.zo-game-root--treasure-hunt .th-cell {
		font-size: 20px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--treasure-hunt');

	games.forEach(function (game) {
		const GRID_W = 10;
		const GRID_H = 10;
		const TREASURE_COUNT = 5;
		const TRAP_COUNT = 6;

		const boardEl = game.querySelector('[data-role="board"]');
		const scoreEl = game.querySelector('[data-role="score"]');
		const messageEl = game.querySelector('[data-role="message"]');
		const restartBtn = game.querySelector('[data-role="restart"]');
		const moveButtons = game.querySelectorAll('[data-move]');

		const state = {
			player: { x: 0, y: 0 },
			score: 0,
			gameOver: false,
			win: false,
			treasures: new Set(),
			traps: new Set()
		};

		function keyFor(x, y) {
			return x + ',' + y;
		}

		function randomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		function resetGame() {
			state.player.x = 0;
			state.player.y = 0;
			state.score = 0;
			state.gameOver = false;
			state.win = false;
			state.treasures = new Set();
			state.traps = new Set();

			const taken = new Set([keyFor(0, 0)]);

			while (state.treasures.size < TREASURE_COUNT) {
				const x = randomInt(0, GRID_W - 1);
				const y = randomInt(0, GRID_H - 1);
				const key = keyFor(x, y);
				if (!taken.has(key)) {
					state.treasures.add(key);
					taken.add(key);
				}
			}

			while (state.traps.size < TRAP_COUNT) {
				const x = randomInt(0, GRID_W - 1);
				const y = randomInt(0, GRID_H - 1);
				const key = keyFor(x, y);
				if (!taken.has(key)) {
					state.traps.add(key);
					taken.add(key);
				}
			}

			render();
		}

		function movePlayer(dx, dy) {
			if (state.gameOver) {
				return;
			}

			const newX = state.player.x + dx;
			const newY = state.player.y + dy;

			if (newX < 0 || newX >= GRID_W || newY < 0 || newY >= GRID_H) {
				return;
			}

			state.player.x = newX;
			state.player.y = newY;

			const pos = keyFor(newX, newY);

			if (state.traps.has(pos)) {
				state.gameOver = true;
				state.win = false;
			} else if (state.treasures.has(pos)) {
				state.treasures.delete(pos);
				state.score += 1;
				if (state.treasures.size === 0) {
					state.gameOver = true;
					state.win = true;
				}
			}

			render();
		}

		function renderTop() {
			scoreEl.textContent = 'Score: ' + state.score + '/' + TREASURE_COUNT;

			if (!state.gameOver) {
				messageEl.textContent = '';
				messageEl.className = 'th-message';
				return;
			}

			if (state.win) {
				messageEl.textContent = 'You found all the treasure. You win.';
				messageEl.className = 'th-message th-message--win';
			} else {
				messageEl.textContent = 'You hit a trap. Game over.';
				messageEl.className = 'th-message th-message--lose';
			}
		}

		function makePlayer() {
			const el = document.createElement('div');
			el.className = 'th-cell__player';
			el.textContent = 'P';
			return el;
		}

		function makeTreasure() {
			const el = document.createElement('div');
			el.className = 'th-cell__treasure';
			el.textContent = '$';
			return el;
		}

		function makeTrap() {
			const el = document.createElement('div');
			el.className = 'th-cell__trap';
			el.textContent = 'X';
			return el;
		}

		function renderBoard() {
			boardEl.innerHTML = '';

			for (let y = 0; y < GRID_H; y++) {
				for (let x = 0; x < GRID_W; x++) {
					const cell = document.createElement('div');
					cell.className = 'th-cell';

					const pos = keyFor(x, y);

					if (state.treasures.has(pos)) {
						cell.appendChild(makeTreasure());
					}

					if (state.gameOver && state.traps.has(pos)) {
						cell.appendChild(makeTrap());
					}

					if (state.player.x === x && state.player.y === y) {
						cell.appendChild(makePlayer());
					}

					boardEl.appendChild(cell);
				}
			}
		}

		function render() {
			renderTop();
			renderBoard();
		}

		game.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowUp') {
				movePlayer(0, -1);
				e.preventDefault();
			}
			if (e.key === 'ArrowDown') {
				movePlayer(0, 1);
				e.preventDefault();
			}
			if (e.key === 'ArrowLeft') {
				movePlayer(-1, 0);
				e.preventDefault();
			}
			if (e.key === 'ArrowRight') {
				movePlayer(1, 0);
				e.preventDefault();
			}
			if (e.key === 'r' || e.key === 'R') {
				resetGame();
				e.preventDefault();
			}
		});

		moveButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				const move = button.getAttribute('data-move');

				if (move === 'up') {
					movePlayer(0, -1);
				}
				if (move === 'down') {
					movePlayer(0, 1);
				}
				if (move === 'left') {
					movePlayer(-1, 0);
				}
				if (move === 'right') {
					movePlayer(1, 0);
				}

				game.focus();
			});
		});

		restartBtn.addEventListener('click', function () {
			resetGame();
			game.focus();
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_treasure_hunt_render')) {
	function zo_game_treasure_hunt_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-treasure-hunt-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--treasure-hunt" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="th-title">Treasure Hunt</div>
			<div class="th-instructions">Use arrow keys to move. Collect all treasure to win. Touch a trap and the game ends. Press R or use Restart to play again.</div>

			<div class="th-topbar">
				<div class="th-score" data-role="score">Score: 0/5</div>
				<div class="th-help">Arrow keys = move. R = restart.</div>
				<div class="th-message" data-role="message"></div>
			</div>

			<div class="th-board-wrap">
				<div class="th-board" data-role="board"></div>
			</div>

			<div class="th-actions">
				<button type="button" class="th-btn" data-role="restart">Restart</button>

				<div class="th-mobile-controls">
					<button type="button" class="th-move th-move--up" data-move="up" aria-label="Move up">↑</button>
					<button type="button" class="th-move th-move--left" data-move="left" aria-label="Move left">←</button>
					<button type="button" class="th-move th-move--down" data-move="down" aria-label="Move down">↓</button>
					<button type="button" class="th-move th-move--right" data-move="right" aria-label="Move right">→</button>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'treasure-hunt',
	'name'            => 'Treasure Hunt',
	'author'          => 'Arslan',
	'description'     => 'A simple treasure hunt grid game with traps, score, restart, and mobile controls.',
	'render_callback' => 'zo_game_treasure_hunt_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);