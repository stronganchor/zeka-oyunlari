<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 920px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--coin-collector-running {
	font-family: Arial, sans-serif;
	background: linear-gradient(180deg, #162032 0%, #0f1522 100%);
	color: #ffffff;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
}

.zo-game-root--coin-collector-running * {
	box-sizing: border-box;
}

.zo-game-root--coin-collector-running .ccr-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #9ddbff;
}

.zo-game-root--coin-collector-running .ccr-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #d8e1f3;
	margin-bottom: 14px;
}

.zo-game-root--coin-collector-running .ccr-topbar {
	display: flex;
	justify-content: center;
	align-items: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 12px;
}

.zo-game-root--coin-collector-running .ccr-stat {
	background: rgba(255,255,255,0.08);
	border: 1px solid rgba(255,255,255,0.14);
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--coin-collector-running .ccr-board-wrap {
	position: relative;
	width: 100%;
	max-width: 900px;
	margin: 0 auto;
}

.zo-game-root--coin-collector-running .ccr-board {
	position: relative;
	width: 100%;
	aspect-ratio: 3 / 2;
	background: linear-gradient(180deg, #1b2740 0%, #121927 100%);
	border: 3px solid #3a4d7a;
	border-radius: 16px;
	overflow: hidden;
	touch-action: none;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.04);
}

.zo-game-root--coin-collector-running .ccr-ground {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 0;
	height: 54px;
	background: #18261b;
	border-top: 2px solid rgba(255,255,255,0.08);
}

.zo-game-root--coin-collector-running .ccr-line {
	position: absolute;
	bottom: 18px;
	width: 40px;
	height: 8px;
	background: #32b450;
	border-radius: 4px;
}

.zo-game-root--coin-collector-running .ccr-player,
.zo-game-root--coin-collector-running .ccr-enemy,
.zo-game-root--coin-collector-running .ccr-coin {
	position: absolute;
}

.zo-game-root--coin-collector-running .ccr-player {
	background: #3278ff;
	border-radius: 8px;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.15);
}

.zo-game-root--coin-collector-running .ccr-enemy {
	background: #dc3232;
	border-radius: 6px;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.12);
}

.zo-game-root--coin-collector-running .ccr-coin {
	background: #ffd700;
	border-radius: 50%;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.22);
}

.zo-game-root--coin-collector-running .ccr-coin::after {
	content: '';
	position: absolute;
	left: 50%;
	top: 50%;
	width: 38%;
	height: 38%;
	transform: translate(-50%, -50%);
	border-radius: 50%;
	border: 2px solid rgba(255,255,255,0.34);
}

.zo-game-root--coin-collector-running .ccr-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
	background: rgba(7, 10, 18, 0.72);
}

.zo-game-root--coin-collector-running .ccr-overlay[hidden] {
	display: none;
}

.zo-game-root--coin-collector-running .ccr-panel {
	background: rgba(22, 31, 52, 0.96);
	border: 1px solid rgba(255,255,255,0.14);
	border-radius: 18px;
	padding: 22px;
	max-width: 430px;
	width: 100%;
}

.zo-game-root--coin-collector-running .ccr-panel-title {
	font-size: 34px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--coin-collector-running .ccr-panel-text {
	font-size: 16px;
	line-height: 1.55;
	color: #d7e1f7;
	margin-bottom: 14px;
}

.zo-game-root--coin-collector-running .ccr-btn-row {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--coin-collector-running .ccr-btn {
	appearance: none;
	border: 1px solid #6b8de3;
	background: #284785;
	color: #ffffff;
	border-radius: 12px;
	padding: 11px 16px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	min-width: 140px;
}

.zo-game-root--coin-collector-running .ccr-btn:hover,
.zo-game-root--coin-collector-running .ccr-btn:focus {
	background: #3358a5;
	outline: none;
}

.zo-game-root--coin-collector-running .ccr-controls {
	margin-top: 14px;
	font-size: 14px;
	color: #cad6f3;
	line-height: 1.5;
}

@media (max-width: 640px) {
	.zo-game-root--coin-collector-running .ccr-title {
		font-size: 26px;
	}

	.zo-game-root--coin-collector-running .ccr-panel-title {
		font-size: 28px;
	}

	.zo-game-root--coin-collector-running .ccr-btn {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--coin-collector-running');

	games.forEach(function (game) {
		const board = game.querySelector('[data-role="board"]');
		const linesLayer = game.querySelector('[data-role="lines"]');
		const coinsLayer = game.querySelector('[data-role="coins"]');
		const enemiesLayer = game.querySelector('[data-role="enemies"]');
		const playerEl = game.querySelector('[data-role="player"]');
		const scoreEl = game.querySelector('[data-role="score"]');
		const overlay = game.querySelector('[data-role="overlay"]');
		const overlayTitle = game.querySelector('[data-role="overlay-title"]');
		const overlayText = game.querySelector('[data-role="overlay-text"]');
		const startBtn = game.querySelector('[data-role="start-btn"]');
		const restartBtn = game.querySelector('[data-role="restart-btn"]');

		const CONFIG = {
			width: 900,
			height: 600,
			playerSize: 40,
			playerX: 120,
			playerSpeedY: 6,
			worldSpeed: 5,
			coinSize: 24,
			enemySize: 35,
			maxCoins: 6,
			maxEnemies: 4,
			lineCount: 12
		};

		const state = {
			playerY: CONFIG.height / 2,
			score: 0,
			gameOver: false,
			started: false,
			running: false,
			rafId: null,
			upPressed: false,
			downPressed: false,
			touchActive: false,
			lines: [],
			coins: [],
			enemies: []
		};

		function randomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		function scaleX(value) {
			return (value / CONFIG.width) * 100;
		}

		function scaleY(value) {
			return (value / CONFIG.height) * 100;
		}

		function rectsIntersect(a, b) {
			return (
				a.x < b.x + b.width &&
				a.x + a.width > b.x &&
				a.y < b.y + b.height &&
				a.y + a.height > b.y
			);
		}

		function playerRect() {
			return {
				x: CONFIG.playerX,
				y: state.playerY,
				width: CONFIG.playerSize,
				height: CONFIG.playerSize
			};
		}

		function spawnCoin() {
			state.coins.push({
				x: randomInt(CONFIG.width + 50, CONFIG.width + 500),
				y: randomInt(50, CONFIG.height - 50 - CONFIG.coinSize)
			});
		}

		function spawnEnemy() {
			state.enemies.push({
				x: randomInt(CONFIG.width + 100, CONFIG.width + 700),
				y: randomInt(40, CONFIG.height - 40 - CONFIG.enemySize)
			});
		}

		function resetGame() {
			state.playerY = CONFIG.height / 2;
			state.score = 0;
			state.gameOver = false;
			state.started = false;
			state.running = false;
			state.lines = [];
			state.coins = [];
			state.enemies = [];

			for (let i = 0; i < CONFIG.maxCoins; i++) {
				spawnCoin();
			}

			for (let i = 0; i < CONFIG.maxEnemies; i++) {
				spawnEnemy();
			}

			for (let i = 0; i < CONFIG.lineCount; i++) {
				state.lines.push(i * 80);
			}

			updateHud();
			render();
			showOverlay(
				'Coin Collector',
				'Collect coins while running. Avoid red enemies. Touching the top or bottom edge ends the game.',
				true
			);
		}

		function updateHud() {
			scoreEl.textContent = String(state.score);
		}

		function showOverlay(title, text, startVisible) {
			overlayTitle.textContent = title;
			overlayText.textContent = text;
			startBtn.hidden = !startVisible;
			restartBtn.hidden = false;
			overlay.hidden = false;
		}

		function hideOverlay() {
			overlay.hidden = true;
		}

		function renderLines() {
			linesLayer.innerHTML = '';
			state.lines.forEach(function (x) {
				const line = document.createElement('div');
				line.className = 'ccr-line';
				line.style.left = scaleX(x) + '%';
				linesLayer.appendChild(line);
			});
		}

		function renderCoins() {
			coinsLayer.innerHTML = '';
			state.coins.forEach(function (coin) {
				const el = document.createElement('div');
				el.className = 'ccr-coin';
				el.style.left = scaleX(coin.x) + '%';
				el.style.top = scaleY(coin.y) + '%';
				el.style.width = scaleX(CONFIG.coinSize) + '%';
				el.style.height = scaleY(CONFIG.coinSize) + '%';
				coinsLayer.appendChild(el);
			});
		}

		function renderEnemies() {
			enemiesLayer.innerHTML = '';
			state.enemies.forEach(function (enemy) {
				const el = document.createElement('div');
				el.className = 'ccr-enemy';
				el.style.left = scaleX(enemy.x) + '%';
				el.style.top = scaleY(enemy.y) + '%';
				el.style.width = scaleX(CONFIG.enemySize) + '%';
				el.style.height = scaleY(CONFIG.enemySize) + '%';
				enemiesLayer.appendChild(el);
			});
		}

		function renderPlayer() {
			playerEl.style.left = scaleX(CONFIG.playerX) + '%';
			playerEl.style.top = scaleY(state.playerY) + '%';
			playerEl.style.width = scaleX(CONFIG.playerSize) + '%';
			playerEl.style.height = scaleY(CONFIG.playerSize) + '%';
		}

		function render() {
			renderPlayer();
			renderLines();
			renderCoins();
			renderEnemies();
		}

		function gameOver() {
			state.gameOver = true;
			stopLoop();
			showOverlay('Game Over', 'Final Score: ' + state.score + '. Press Restart to play again.', false);
		}

		function updatePlayer() {
			if (state.upPressed) {
				state.playerY -= CONFIG.playerSpeedY;
			}
			if (state.downPressed) {
				state.playerY += CONFIG.playerSpeedY;
			}

			if (state.playerY <= 0 || state.playerY + CONFIG.playerSize >= CONFIG.height) {
				gameOver();
			}
		}

		function updateLines() {
			for (let i = 0; i < state.lines.length; i++) {
				state.lines[i] -= CONFIG.worldSpeed;
				if (state.lines[i] < -40) {
					state.lines[i] = CONFIG.width + randomInt(0, 40);
				}
			}
		}

		function updateCoins() {
			state.coins.forEach(function (coin) {
				coin.x -= CONFIG.worldSpeed;
			});

			state.coins = state.coins.filter(function (coin) {
				return coin.x + CONFIG.coinSize >= 0;
			});

			while (state.coins.length < CONFIG.maxCoins) {
				spawnCoin();
			}
		}

		function updateEnemies() {
			state.enemies.forEach(function (enemy) {
				enemy.x -= CONFIG.worldSpeed + 2;
			});

			state.enemies = state.enemies.filter(function (enemy) {
				return enemy.x + CONFIG.enemySize >= 0;
			});

			while (state.enemies.length < CONFIG.maxEnemies) {
				spawnEnemy();
			}
		}

		function handleCoinCollection() {
			const player = playerRect();
			const remaining = [];

			state.coins.forEach(function (coin) {
				const coinRect = {
					x: coin.x,
					y: coin.y,
					width: CONFIG.coinSize,
					height: CONFIG.coinSize
				};

				if (rectsIntersect(player, coinRect)) {
					state.score += 1;
				} else {
					remaining.push(coin);
				}
			});

			state.coins = remaining;

			while (state.coins.length < CONFIG.maxCoins) {
				spawnCoin();
			}

			updateHud();
		}

		function handleEnemyCollision() {
			const player = playerRect();

			for (let i = 0; i < state.enemies.length; i++) {
				const enemy = state.enemies[i];
				const enemyRect = {
					x: enemy.x,
					y: enemy.y,
					width: CONFIG.enemySize,
					height: CONFIG.enemySize
				};

				if (rectsIntersect(player, enemyRect)) {
					gameOver();
					return;
				}
			}
		}

		function tick() {
			if (!state.running) {
				return;
			}

			updatePlayer();

			if (state.gameOver) {
				render();
				return;
			}

			updateLines();
			updateCoins();
			updateEnemies();
			handleCoinCollection();
			handleEnemyCollision();
			render();

			if (state.running) {
				state.rafId = window.requestAnimationFrame(tick);
			}
		}

		function startLoop() {
			if (state.running) {
				return;
			}

			state.running = true;
			state.started = true;
			state.gameOver = false;
			hideOverlay();
			state.rafId = window.requestAnimationFrame(tick);
		}

		function stopLoop() {
			state.running = false;
			if (state.rafId) {
				window.cancelAnimationFrame(state.rafId);
				state.rafId = null;
			}
		}

		function movePlayerToPointer(clientY) {
			const rect = board.getBoundingClientRect();
			const y = ((clientY - rect.top) / rect.height) * CONFIG.height;
			state.playerY = y - CONFIG.playerSize / 2;

			if (state.playerY < 0) {
				state.playerY = 0;
			}
			if (state.playerY + CONFIG.playerSize > CONFIG.height) {
				state.playerY = CONFIG.height - CONFIG.playerSize;
			}

			renderPlayer();
		}

		game.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') {
				state.upPressed = true;
				e.preventDefault();
			}
			if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') {
				state.downPressed = true;
				e.preventDefault();
			}
			if ((e.key === ' ' || e.key === 'Spacebar') && !state.running && overlay.hidden === false) {
				startLoop();
				e.preventDefault();
			}
		});

		game.addEventListener('keyup', function (e) {
			if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') {
				state.upPressed = false;
			}
			if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') {
				state.downPressed = false;
			}
		});

		board.addEventListener('pointerdown', function (e) {
			state.touchActive = true;
			movePlayerToPointer(e.clientY);
			board.setPointerCapture(e.pointerId);
		});

		board.addEventListener('pointermove', function (e) {
			if (!state.touchActive) {
				return;
			}
			movePlayerToPointer(e.clientY);
		});

		board.addEventListener('pointerup', function () {
			state.touchActive = false;
		});

		board.addEventListener('pointercancel', function () {
			state.touchActive = false;
		});

		startBtn.addEventListener('click', function () {
			startLoop();
			game.focus();
		});

		restartBtn.addEventListener('click', function () {
			stopLoop();
			resetGame();
			game.focus();
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_coin_collector_running_render')) {
	function zo_game_coin_collector_running_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-coin-collector-running-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--coin-collector-running" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="ccr-title">Coin Collector Running</div>
			<div class="ccr-instructions">Use Up and Down arrows or W and S to move. On mobile, drag up and down. Collect coins and avoid red enemies.</div>

			<div class="ccr-topbar">
				<div class="ccr-stat">Score: <span data-role="score">0</span></div>
			</div>

			<div class="ccr-board-wrap">
				<div class="ccr-board" data-role="board">
					<div class="ccr-ground"></div>
					<div data-role="lines"></div>
					<div data-role="coins"></div>
					<div data-role="enemies"></div>
					<div class="ccr-player" data-role="player"></div>

					<div class="ccr-overlay" data-role="overlay">
						<div class="ccr-panel">
							<div class="ccr-panel-title" data-role="overlay-title">Coin Collector</div>
							<div class="ccr-panel-text" data-role="overlay-text">Collect coins while running. Avoid red enemies and the screen edges.</div>
							<div class="ccr-btn-row">
								<button type="button" class="ccr-btn" data-role="start-btn">Start</button>
								<button type="button" class="ccr-btn" data-role="restart-btn">Restart</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="ccr-controls">Restart is always available. Score goes up when you collect coins. The game ends if you hit an enemy or touch the top or bottom edge.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'coin-collector-running',
	'name'            => 'Coin Collector Running',
	'author'          => 'Arslan',
	'description'     => 'A running coin collector game with keyboard and mobile touch controls.',
	'render_callback' => 'zo_game_coin_collector_running_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);