<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 620px;
	margin: 0 auto;
	padding: 16px;
	text-align: center;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-scarab-wrap {
	background: #fff8e8;
	border: 2px solid #c9a65c;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-scarab-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-scarab-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-scarab-topbar {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-scarab-pill {
	background: #ffffff;
	border: 1px solid #c9a65c;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 14px;
	font-weight: bold;
}

.zo-scarab-board {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 8px;
	max-width: 360px;
	margin: 0 auto 16px;
	padding: 10px;
	background: #f3dfb2;
	border: 2px solid #c9a65c;
	border-radius: 16px;
}

.zo-scarab-tile {
	min-height: 62px;
	border: 2px solid #b78d3f;
	border-radius: 12px;
	background: #fffdf6;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 28px;
	font-weight: bold;
	user-select: none;
}

.zo-scarab-tile.is-player {
	background: #dff4ff;
	border-color: #5fa8cc;
}

.zo-scarab-tile.is-goal {
	background: #eef8d9;
	border-color: #83ae4d;
}

.zo-scarab-controls {
	display: grid;
	grid-template-columns: repeat(3, 76px);
	gap: 8px;
	justify-content: center;
	margin-bottom: 10px;
}

.zo-scarab-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #c98d2b;
	color: #fff;
	min-height: 48px;
}

.zo-scarab-btn:hover,
.zo-scarab-btn:focus {
	opacity: 0.92;
}

.zo-scarab-action-row {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-scarab-action {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #8c6239;
	color: #fff;
	min-width: 120px;
}

.zo-scarab-action:hover,
.zo-scarab-action:focus {
	opacity: 0.92;
}

.zo-scarab-status {
	min-height: 24px;
	font-size: 15px;
	font-weight: bold;
	margin-top: 8px;
}

.zo-scarab-help {
	margin-top: 10px;
	font-size: 14px;
	line-height: 1.5;
}

@media (max-width: 480px) {
	.zo-scarab-title {
		font-size: 24px;
	}

	.zo-scarab-board {
		max-width: 320px;
	}

	.zo-scarab-tile {
		min-height: 54px;
		font-size: 24px;
	}

	.zo-scarab-controls {
		grid-template-columns: repeat(3, 68px);
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--kutsal-bocek-labirenti');

	games.forEach(function (game) {
		const board = game.querySelector('.zo-scarab-board');
		const statusEl = game.querySelector('.zo-scarab-status');
		const stepsEl = game.querySelector('.zo-scarab-steps');
		const levelEl = game.querySelector('.zo-scarab-level');
		const bestEl = game.querySelector('.zo-scarab-best');

		const upBtn = game.querySelector('.zo-scarab-up');
		const downBtn = game.querySelector('.zo-scarab-down');
		const leftBtn = game.querySelector('.zo-scarab-left');
		const rightBtn = game.querySelector('.zo-scarab-right');
		const restartBtn = game.querySelector('.zo-scarab-restart');
		const nextBtn = game.querySelector('.zo-scarab-next');

		const levels = [
			{
				player: { x: 0, y: 0 },
				goal: { x: 4, y: 4 },
				walls: ['1,0', '1,1', '3,1', '3,2', '1,3', '2,3']
			},
			{
				player: { x: 0, y: 4 },
				goal: { x: 4, y: 0 },
				walls: ['1,4', '1,3', '2,1', '3,1', '3,2', '0,2', '1,2']
			},
			{
				player: { x: 2, y: 4 },
				goal: { x: 2, y: 0 },
				walls: ['0,3', '1,3', '3,3', '4,3', '1,1', '2,1', '3,1', '0,0', '4,0']
			}
		];

		let currentLevel = 0;
		let player = { x: 0, y: 0 };
		let goal = { x: 4, y: 4 };
		let walls = [];
		let steps = 0;
		let best = null;
		let won = false;

		function wallKey(x, y) {
			return x + ',' + y;
		}

		function updateStats() {
			stepsEl.textContent = 'Adım: ' + steps;
			levelEl.textContent = 'Seviye: ' + (currentLevel + 1) + '/' + levels.length;
			bestEl.textContent = 'En iyi: ' + (best === null ? '-' : best);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function buildBoard() {
			board.innerHTML = '';

			for (let y = 0; y < 5; y++) {
				for (let x = 0; x < 5; x++) {
					const tile = document.createElement('div');
					tile.className = 'zo-scarab-tile';

					if (walls.indexOf(wallKey(x, y)) !== -1) {
						tile.textContent = '🧱';
					} else if (player.x === x && player.y === y) {
						tile.classList.add('is-player');
						tile.textContent = '🪲';
					} else if (goal.x === x && goal.y === y) {
						tile.classList.add('is-goal');
						tile.textContent = '💎';
					} else {
						tile.textContent = '·';
					}

					board.appendChild(tile);
				}
			}
		}

		function loadLevel(levelIndex) {
			const level = levels[levelIndex];
			currentLevel = levelIndex;
			player = { x: level.player.x, y: level.player.y };
			goal = { x: level.goal.x, y: level.goal.y };
			walls = level.walls.slice();
			steps = 0;
			won = false;
			updateStats();
			buildBoard();
			setStatus('Böceği çıkış hazinesine götür.');
		}

		function finishLevel() {
			won = true;

			if (best === null || steps < best) {
				best = steps;
			}

			updateStats();
			buildBoard();

			if (currentLevel === levels.length - 1) {
				setStatus('Bütün seviyeleri bitirdin.');
			} else {
				setStatus('Kazandın. Sonraki seviyeye geç.');
			}
		}

		function tryMove(dx, dy) {
			if (won && currentLevel === levels.length - 1) {
				return;
			}

			const nextX = player.x + dx;
			const nextY = player.y + dy;

			if (nextX < 0 || nextX > 4 || nextY < 0 || nextY > 4) {
				setStatus('Duvarın dışına çıkamazsın.');
				return;
			}

			if (walls.indexOf(wallKey(nextX, nextY)) !== -1) {
				setStatus('Taş duvara çarptın.');
				return;
			}

			player.x = nextX;
			player.y = nextY;
			steps += 1;
			updateStats();
			buildBoard();

			if (player.x === goal.x && player.y === goal.y) {
				finishLevel();
			} else {
				setStatus('Devam et.');
			}
		}

		upBtn.addEventListener('click', function () {
			tryMove(0, -1);
		});

		downBtn.addEventListener('click', function () {
			tryMove(0, 1);
		});

		leftBtn.addEventListener('click', function () {
			tryMove(-1, 0);
		});

		rightBtn.addEventListener('click', function () {
			tryMove(1, 0);
		});

		restartBtn.addEventListener('click', function () {
			loadLevel(currentLevel);
		});

		nextBtn.addEventListener('click', function () {
			if (currentLevel < levels.length - 1) {
				loadLevel(currentLevel + 1);
			} else {
				loadLevel(0);
			}
		});

		game.addEventListener('keydown', function (event) {
			if (event.code === 'ArrowUp') {
				event.preventDefault();
				tryMove(0, -1);
			}
			if (event.code === 'ArrowDown') {
				event.preventDefault();
				tryMove(0, 1);
			}
			if (event.code === 'ArrowLeft') {
				event.preventDefault();
				tryMove(-1, 0);
			}
			if (event.code === 'ArrowRight') {
				event.preventDefault();
				tryMove(1, 0);
			}
		});

		game.setAttribute('tabindex', '0');
		loadLevel(0);
	});
});
JS;

if (!function_exists('zo_game_kutsal_bocek_labirenti_render')) {
	function zo_game_kutsal_bocek_labirenti_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-kutsal-bocek-labirenti-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--kutsal-bocek-labirenti" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-scarab-wrap">
				<h3 class="zo-scarab-title">Kutsal Böcek Labirenti</h3>
				<p class="zo-scarab-text">Mısır'ın kutsal böceğini taş duvarların arasından geçir. Hazineye ulaşırsan seviye biter.</p>

				<div class="zo-scarab-topbar">
					<div class="zo-scarab-pill zo-scarab-steps">Adım: 0</div>
					<div class="zo-scarab-pill zo-scarab-level">Seviye: 1/3</div>
					<div class="zo-scarab-pill zo-scarab-best">En iyi: -</div>
				</div>

				<div class="zo-scarab-board" aria-label="Labirent oyun alanı"></div>

				<div class="zo-scarab-controls">
					<div></div>
					<button type="button" class="zo-scarab-btn zo-scarab-up">↑</button>
					<div></div>

					<button type="button" class="zo-scarab-btn zo-scarab-left">←</button>
					<div></div>
					<button type="button" class="zo-scarab-btn zo-scarab-right">→</button>

					<div></div>
					<button type="button" class="zo-scarab-btn zo-scarab-down">↓</button>
					<div></div>
				</div>

				<div class="zo-scarab-action-row">
					<button type="button" class="zo-scarab-action zo-scarab-restart">Tekrar Başla</button>
					<button type="button" class="zo-scarab-action zo-scarab-next">Sonraki Seviye</button>
				</div>

				<div class="zo-scarab-status">Böceği çıkış hazinesine götür.</div>
				<div class="zo-scarab-help">Bilgisayarda ok tuşlarıyla da oynayabilirsin.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'kutsal-bocek-labirenti',
	'name'            => 'Kutsal Böcek Labirenti',
	'author'          => 'Arslan',
	'description'     => 'Mısır temalı labirent ve yön bulma oyunu.',
	'render_callback' => 'zo_game_kutsal_bocek_labirenti_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);