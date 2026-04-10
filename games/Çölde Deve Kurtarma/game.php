<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 640px;
	margin: 0 auto;
	padding: 16px;
	text-align: center;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-camel-wrap {
	background: #fff7e8;
	border: 2px solid #d4b06b;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-camel-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-camel-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-camel-topbar {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-camel-pill {
	background: #ffffff;
	border: 1px solid #d4b06b;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 14px;
	font-weight: bold;
}

.zo-camel-board {
	display: grid;
	grid-template-columns: repeat(6, minmax(0, 1fr));
	gap: 8px;
	max-width: 420px;
	margin: 0 auto 16px;
	padding: 10px;
	background: #f6e2b7;
	border: 2px solid #d4b06b;
	border-radius: 16px;
}

.zo-camel-cell {
	min-height: 58px;
	border: 2px solid #c79849;
	border-radius: 12px;
	background: #fffdf7;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 28px;
	user-select: none;
}

.zo-camel-cell.is-player {
	background: #e8f6ff;
	border-color: #67a7ca;
}

.zo-camel-cell.is-goal {
	background: #eef8dc;
	border-color: #88af55;
}

.zo-camel-cell.is-danger {
	background: #fff0f0;
	border-color: #d97b7b;
}

.zo-camel-controls {
	display: grid;
	grid-template-columns: repeat(3, 76px);
	gap: 8px;
	justify-content: center;
	margin-bottom: 10px;
}

.zo-camel-btn {
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

.zo-camel-btn:hover,
.zo-camel-btn:focus {
	opacity: 0.92;
}

.zo-camel-action-row {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-camel-action {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #8b6138;
	color: #fff;
	min-width: 120px;
}

.zo-camel-action:hover,
.zo-camel-action:focus {
	opacity: 0.92;
}

.zo-camel-status {
	min-height: 24px;
	font-size: 15px;
	font-weight: bold;
	margin-top: 8px;
}

.zo-camel-help {
	margin-top: 10px;
	font-size: 14px;
	line-height: 1.5;
}

@media (max-width: 520px) {
	.zo-camel-title {
		font-size: 24px;
	}

	.zo-camel-board {
		max-width: 360px;
	}

	.zo-camel-cell {
		min-height: 48px;
		font-size: 24px;
	}

	.zo-camel-controls {
		grid-template-columns: repeat(3, 68px);
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--colde-deve-kurtarma');

	games.forEach(function (game) {
		const board = game.querySelector('.zo-camel-board');
		const statusEl = game.querySelector('.zo-camel-status');
		const waterEl = game.querySelector('.zo-camel-water');
		const levelEl = game.querySelector('.zo-camel-level');
		const bestEl = game.querySelector('.zo-camel-best');

		const upBtn = game.querySelector('.zo-camel-up');
		const downBtn = game.querySelector('.zo-camel-down');
		const leftBtn = game.querySelector('.zo-camel-left');
		const rightBtn = game.querySelector('.zo-camel-right');
		const restartBtn = game.querySelector('.zo-camel-restart');
		const nextBtn = game.querySelector('.zo-camel-next');

		const levels = [
			{
				player: { x: 0, y: 5 },
				goal: { x: 5, y: 0 },
				water: 10,
				traps: ['1,5', '2,4', '2,3', '4,2', '4,1']
			},
			{
				player: { x: 0, y: 0 },
				goal: { x: 5, y: 5 },
				water: 11,
				traps: ['1,0', '1,1', '3,2', '3,3', '2,4', '4,4']
			},
			{
				player: { x: 2, y: 5 },
				goal: { x: 2, y: 0 },
				water: 9,
				traps: ['0,4', '1,4', '3,4', '4,4', '1,2', '2,2', '3,2', '0,0', '5,0']
			}
		];

		let currentLevel = 0;
		let player = { x: 0, y: 0 };
		let goal = { x: 5, y: 5 };
		let traps = [];
		let water = 0;
		let best = null;
		let ended = false;

		function trapKey(x, y) {
			return x + ',' + y;
		}

		function updateStats() {
			waterEl.textContent = 'Su: ' + water;
			levelEl.textContent = 'Seviye: ' + (currentLevel + 1) + '/' + levels.length;
			bestEl.textContent = 'En iyi su: ' + (best === null ? '-' : best);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function buildBoard() {
			board.innerHTML = '';

			for (let y = 0; y < 6; y++) {
				for (let x = 0; x < 6; x++) {
					const cell = document.createElement('div');
					cell.className = 'zo-camel-cell';

					if (player.x === x && player.y === y) {
						cell.classList.add('is-player');
						cell.textContent = '🐪';
					} else if (goal.x === x && goal.y === y) {
						cell.classList.add('is-goal');
						cell.textContent = '💧';
					} else if (traps.indexOf(trapKey(x, y)) !== -1) {
						cell.classList.add('is-danger');
						cell.textContent = '🔥';
					} else {
						cell.textContent = '·';
					}

					board.appendChild(cell);
				}
			}
		}

		function loadLevel(levelIndex) {
			const level = levels[levelIndex];
			currentLevel = levelIndex;
			player = { x: level.player.x, y: level.player.y };
			goal = { x: level.goal.x, y: level.goal.y };
			traps = level.traps.slice();
			water = level.water;
			ended = false;
			updateStats();
			buildBoard();
			setStatus('Deveyi suya ulaştır.');
		}

		function loseGame(message) {
			ended = true;
			buildBoard();
			setStatus(message);
		}

		function winLevel() {
			ended = true;

			if (best === null || water > best) {
				best = water;
			}

			updateStats();
			buildBoard();

			if (currentLevel === levels.length - 1) {
				setStatus('Bütün seviyeleri geçtin.');
			} else {
				setStatus('Kazandın. Sonraki seviyeye geç.');
			}
		}

		function tryMove(dx, dy) {
			if (ended) {
				return;
			}

			const nextX = player.x + dx;
			const nextY = player.y + dy;

			if (nextX < 0 || nextX > 5 || nextY < 0 || nextY > 5) {
				setStatus('Çölün dışına gidemezsin.');
				return;
			}

			player.x = nextX;
			player.y = nextY;
			water -= 1;

			if (water < 0) {
				water = 0;
			}

			if (traps.indexOf(trapKey(nextX, nextY)) !== -1) {
				updateStats();
				loseGame('Sıcak kum tuzağına bastın. Tekrar dene.');
				return;
			}

			updateStats();
			buildBoard();

			if (player.x === goal.x && player.y === goal.y) {
				winLevel();
				return;
			}

			if (water === 0) {
				loseGame('Suyun bitti. Tekrar dene.');
				return;
			}

			setStatus('Dikkatli ilerle.');
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

if (!function_exists('zo_game_colde_deve_kurtarma_render')) {
	function zo_game_colde_deve_kurtarma_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-colde-deve-kurtarma-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--colde-deve-kurtarma" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-camel-wrap">
				<h3 class="zo-camel-title">Çölde Deve Kurtarma</h3>
				<p class="zo-camel-text">Deveyi çölün içinden geçir. Sıcak kum tuzaklarına basmadan suya ulaş. Her adımda su azalır.</p>

				<div class="zo-camel-topbar">
					<div class="zo-camel-pill zo-camel-water">Su: 0</div>
					<div class="zo-camel-pill zo-camel-level">Seviye: 1/3</div>
					<div class="zo-camel-pill zo-camel-best">En iyi su: -</div>
				</div>

				<div class="zo-camel-board" aria-label="Çöl oyun alanı"></div>

				<div class="zo-camel-controls">
					<div></div>
					<button type="button" class="zo-camel-btn zo-camel-up">↑</button>
					<div></div>

					<button type="button" class="zo-camel-btn zo-camel-left">←</button>
					<div></div>
					<button type="button" class="zo-camel-btn zo-camel-right">→</button>

					<div></div>
					<button type="button" class="zo-camel-btn zo-camel-down">↓</button>
					<div></div>
				</div>

				<div class="zo-camel-action-row">
					<button type="button" class="zo-camel-action zo-camel-restart">Tekrar Başla</button>
					<button type="button" class="zo-camel-action zo-camel-next">Sonraki Seviye</button>
				</div>

				<div class="zo-camel-status">Deveyi suya ulaştır.</div>
				<div class="zo-camel-help">Bilgisayarda ok tuşlarıyla da oynayabilirsin.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'colde-deve-kurtarma',
	'name'            => 'Çölde Deve Kurtarma',
	'author'          => 'Arslan',
	'description'     => 'Mısır temalı yön bulma ve dikkat oyunu.',
	'render_callback' => 'zo_game_colde_deve_kurtarma_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);