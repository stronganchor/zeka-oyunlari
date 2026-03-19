<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 980px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--top-down-shooter {
	font-family: Arial, sans-serif;
	background: linear-gradient(180deg, #173322 0%, #102416 100%);
	color: #ffffff;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
}

.zo-game-root--top-down-shooter * {
	box-sizing: border-box;
}

.zo-game-root--top-down-shooter .tds-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #aee8ff;
}

.zo-game-root--top-down-shooter .tds-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #dbe7df;
	margin-bottom: 14px;
}

.zo-game-root--top-down-shooter .tds-topbar {
	display: flex;
	justify-content: center;
	align-items: center;
	gap: 10px;
	flex-wrap: wrap;
	margin-bottom: 12px;
}

.zo-game-root--top-down-shooter .tds-stat {
	background: rgba(255,255,255,0.08);
	border: 1px solid rgba(255,255,255,0.14);
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--top-down-shooter .tds-health-wrap {
	max-width: 260px;
	margin: 0 auto 12px;
}

.zo-game-root--top-down-shooter .tds-health-bar {
	width: 100%;
	height: 20px;
	background: #6b6b6b;
	border: 2px solid #ffffff;
	border-radius: 999px;
	overflow: hidden;
}

.zo-game-root--top-down-shooter .tds-health-fill {
	height: 100%;
	width: 100%;
	background: #32b45a;
	transition: width 0.15s linear;
}

.zo-game-root--top-down-shooter .tds-board-wrap {
	position: relative;
	width: 100%;
	max-width: 940px;
	margin: 0 auto;
}

.zo-game-root--top-down-shooter .tds-board {
	position: relative;
	width: 100%;
	aspect-ratio: 900 / 650;
	background: #1e5d33;
	border: 3px solid #3e5d45;
	border-radius: 16px;
	overflow: hidden;
	touch-action: none;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.04);
	cursor: crosshair;
}

.zo-game-root--top-down-shooter .tds-player,
.zo-game-root--top-down-shooter .tds-enemy,
.zo-game-root--top-down-shooter .tds-bullet {
	position: absolute;
}

.zo-game-root--top-down-shooter .tds-player {
	background: #3c78ff;
	border-radius: 8px;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.16);
}

.zo-game-root--top-down-shooter .tds-enemy {
	background: #dc3c3c;
	border-radius: 6px;
	box-shadow: inset 0 0 0 2px rgba(255,255,255,0.12);
}

.zo-game-root--top-down-shooter .tds-bullet {
	background: #fadc46;
	border-radius: 3px;
}

.zo-game-root--top-down-shooter .tds-aim-line {
	position: absolute;
	left: 0;
	top: 0;
	width: 0;
	height: 2px;
	background: #ffffff;
	transform-origin: 0 50%;
	pointer-events: none;
	opacity: 0.9;
}

.zo-game-root--top-down-shooter .tds-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
	background: rgba(8, 14, 10, 0.68);
}

.zo-game-root--top-down-shooter .tds-overlay[hidden] {
	display: none;
}

.zo-game-root--top-down-shooter .tds-panel {
	background: rgba(21, 36, 25, 0.96);
	border: 1px solid rgba(255,255,255,0.14);
	border-radius: 18px;
	padding: 22px;
	max-width: 450px;
	width: 100%;
}

.zo-game-root--top-down-shooter .tds-panel-title {
	font-size: 34px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--top-down-shooter .tds-panel-text {
	font-size: 16px;
	line-height: 1.55;
	color: #d7e6da;
	margin-bottom: 14px;
}

.zo-game-root--top-down-shooter .tds-btn-row {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--top-down-shooter .tds-btn {
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

.zo-game-root--top-down-shooter .tds-btn:hover,
.zo-game-root--top-down-shooter .tds-btn:focus {
	background: #3358a5;
	outline: none;
}

.zo-game-root--top-down-shooter .tds-controls {
	margin-top: 14px;
	font-size: 14px;
	color: #d5e4d8;
	line-height: 1.5;
}

@media (max-width: 640px) {
	.zo-game-root--top-down-shooter .tds-title {
		font-size: 26px;
	}

	.zo-game-root--top-down-shooter .tds-panel-title {
		font-size: 28px;
	}

	.zo-game-root--top-down-shooter .tds-btn {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--top-down-shooter');

	games.forEach(function (game) {
		const board = game.querySelector('[data-role="board"]');
		const bulletsLayer = game.querySelector('[data-role="bullets"]');
		const enemiesLayer = game.querySelector('[data-role="enemies"]');
		const playerEl = game.querySelector('[data-role="player"]');
		const aimLineEl = game.querySelector('[data-role="aim-line"]');
		const scoreEl = game.querySelector('[data-role="score"]');
		const healthEl = game.querySelector('[data-role="health"]');
		const healthFillEl = game.querySelector('[data-role="health-fill"]');
		const overlay = game.querySelector('[data-role="overlay"]');
		const overlayTitle = game.querySelector('[data-role="overlay-title"]');
		const overlayText = game.querySelector('[data-role="overlay-text"]');
		const startBtn = game.querySelector('[data-role="start-btn"]');
		const restartBtn = game.querySelector('[data-role="restart-btn"]');

		const CONFIG = {
			width: 900,
			height: 650,
			playerSize: 40,
			playerSpeed: 5,
			maxHealth: 100,
			bulletSize: 8,
			bulletSpeed: 10,
			shootCooldown: 200,
			enemySize: 35,
			enemySpeed: 2,
			spawnDelay: 900
		};

		const state = {
			player: {
				x: CONFIG.width / 2 - CONFIG.playerSize / 2,
				y: CONFIG.height / 2 - CONFIG.playerSize / 2,
				size: CONFIG.playerSize
			},
			playerHealth: CONFIG.maxHealth,
			score: 0,
			gameOver: false,
			running: false,
			started: false,
			rafId: null,
			lastTime: 0,
			lastSpawnTime: 0,
			lastShotTime: 0,
			mouseX: CONFIG.width / 2,
			mouseY: CONFIG.height / 2,
			keys: {
				left: false,
				right: false,
				up: false,
				down: false
			},
			bullets: [],
			enemies: []
		};

		function scaleX(value) {
			return (value / CONFIG.width) * 100;
		}

		function scaleY(value) {
			return (value / CONFIG.height) * 100;
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
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
				x: state.player.x,
				y: state.player.y,
				width: state.player.size,
				height: state.player.size
			};
		}

		function randomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		function updateHud() {
			scoreEl.textContent = String(state.score);
			healthEl.textContent = String(state.playerHealth);
			healthFillEl.style.width = ((state.playerHealth / CONFIG.maxHealth) * 100) + '%';
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

		function resetGame() {
			state.player.x = CONFIG.width / 2 - CONFIG.playerSize / 2;
			state.player.y = CONFIG.height / 2 - CONFIG.playerSize / 2;
			state.playerHealth = CONFIG.maxHealth;
			state.score = 0;
			state.gameOver = false;
			state.running = false;
			state.started = false;
			state.rafId = null;
			state.lastTime = 0;
			state.lastSpawnTime = 0;
			state.lastShotTime = 0;
			state.bullets = [];
			state.enemies = [];
			state.mouseX = CONFIG.width / 2;
			state.mouseY = CONFIG.height / 2;
			state.keys.left = false;
			state.keys.right = false;
			state.keys.up = false;
			state.keys.down = false;
			updateHud();
			render();
			showOverlay(
				'Top-Down Shooter',
				'Move with WASD or Arrow keys. Click or tap inside the board to shoot. Press Restart any time.',
				true
			);
		}

		function spawnEnemy() {
			const side = ['top', 'bottom', 'left', 'right'][randomInt(0, 3)];
			let x = 0;
			let y = 0;

			if (side === 'top') {
				x = randomInt(0, CONFIG.width - CONFIG.enemySize);
				y = -CONFIG.enemySize;
			} else if (side === 'bottom') {
				x = randomInt(0, CONFIG.width - CONFIG.enemySize);
				y = CONFIG.height;
			} else if (side === 'left') {
				x = -CONFIG.enemySize;
				y = randomInt(0, CONFIG.height - CONFIG.enemySize);
			} else {
				x = CONFIG.width;
				y = randomInt(0, CONFIG.height - CONFIG.enemySize);
			}

			state.enemies.push({
				x: x,
				y: y,
				size: CONFIG.enemySize
			});
		}

		function shootAt(targetX, targetY, now) {
			if (state.gameOver || !state.running) {
				return;
			}

			if (now - state.lastShotTime < CONFIG.shootCooldown) {
				return;
			}

			const playerCenterX = state.player.x + state.player.size / 2;
			const playerCenterY = state.player.y + state.player.size / 2;
			const dxRaw = targetX - playerCenterX;
			const dyRaw = targetY - playerCenterY;
			const distance = Math.hypot(dxRaw, dyRaw);

			if (distance === 0) {
				return;
			}

			state.bullets.push({
				x: playerCenterX,
				y: playerCenterY,
				dx: dxRaw / distance,
				dy: dyRaw / distance,
				size: CONFIG.bulletSize
			});

			state.lastShotTime = now;
		}

		function updatePlayer() {
			let moveX = 0;
			let moveY = 0;

			if (state.keys.left) {
				moveX -= CONFIG.playerSpeed;
			}
			if (state.keys.right) {
				moveX += CONFIG.playerSpeed;
			}
			if (state.keys.up) {
				moveY -= CONFIG.playerSpeed;
			}
			if (state.keys.down) {
				moveY += CONFIG.playerSpeed;
			}

			state.player.x = clamp(state.player.x + moveX, 0, CONFIG.width - state.player.size);
			state.player.y = clamp(state.player.y + moveY, 0, CONFIG.height - state.player.size);
		}

		function updateBullets() {
			const kept = [];

			state.bullets.forEach(function (bullet) {
				bullet.x += bullet.dx * CONFIG.bulletSpeed;
				bullet.y += bullet.dy * CONFIG.bulletSpeed;

				if (
					bullet.x >= 0 &&
					bullet.x <= CONFIG.width &&
					bullet.y >= 0 &&
					bullet.y <= CONFIG.height
				) {
					kept.push(bullet);
				}
			});

			state.bullets = kept;
		}

		function updateEnemies() {
			const playerCenterX = state.player.x + state.player.size / 2;
			const playerCenterY = state.player.y + state.player.size / 2;
			const kept = [];

			state.enemies.forEach(function (enemy) {
				const enemyCenterX = enemy.x + enemy.size / 2;
				const enemyCenterY = enemy.y + enemy.size / 2;
				let dx = playerCenterX - enemyCenterX;
				let dy = playerCenterY - enemyCenterY;
				const distance = Math.hypot(dx, dy);

				if (distance !== 0) {
					dx /= distance;
					dy /= distance;
				}

				enemy.x += dx * CONFIG.enemySpeed;
				enemy.y += dy * CONFIG.enemySpeed;

				if (rectsIntersect(
					{ x: enemy.x, y: enemy.y, width: enemy.size, height: enemy.size },
					playerRect()
				)) {
					state.playerHealth -= 20;
					if (state.playerHealth <= 0) {
						state.playerHealth = 0;
						state.gameOver = true;
					}
				} else {
					kept.push(enemy);
				}
			});

			state.enemies = kept;
		}

		function handleBulletHits() {
			const newBullets = [];

			state.bullets.forEach(function (bullet) {
				const bulletRect = {
					x: bullet.x,
					y: bullet.y,
					width: CONFIG.bulletSize,
					height: CONFIG.bulletSize
				};

				let hit = false;

				for (let i = 0; i < state.enemies.length; i++) {
					const enemy = state.enemies[i];
					const enemyRect = {
						x: enemy.x,
						y: enemy.y,
						width: enemy.size,
						height: enemy.size
					};

					if (rectsIntersect(bulletRect, enemyRect)) {
						state.enemies.splice(i, 1);
						state.score += 1;
						hit = true;
						break;
					}
				}

				if (!hit) {
					newBullets.push(bullet);
				}
			});

			state.bullets = newBullets;
		}

		function renderPlayer() {
			playerEl.style.left = scaleX(state.player.x) + '%';
			playerEl.style.top = scaleY(state.player.y) + '%';
			playerEl.style.width = scaleX(state.player.size) + '%';
			playerEl.style.height = scaleY(state.player.size) + '%';
		}

		function renderBullets() {
			bulletsLayer.innerHTML = '';

			state.bullets.forEach(function (bullet) {
				const el = document.createElement('div');
				el.className = 'tds-bullet';
				el.style.left = scaleX(bullet.x) + '%';
				el.style.top = scaleY(bullet.y) + '%';
				el.style.width = scaleX(CONFIG.bulletSize) + '%';
				el.style.height = scaleY(CONFIG.bulletSize) + '%';
				bulletsLayer.appendChild(el);
			});
		}

		function renderEnemies() {
			enemiesLayer.innerHTML = '';

			state.enemies.forEach(function (enemy) {
				const el = document.createElement('div');
				el.className = 'tds-enemy';
				el.style.left = scaleX(enemy.x) + '%';
				el.style.top = scaleY(enemy.y) + '%';
				el.style.width = scaleX(enemy.size) + '%';
				el.style.height = scaleY(enemy.size) + '%';
				enemiesLayer.appendChild(el);
			});
		}

		function renderAimLine() {
			const playerCenterX = state.player.x + state.player.size / 2;
			const playerCenterY = state.player.y + state.player.size / 2;
			const dx = state.mouseX - playerCenterX;
			const dy = state.mouseY - playerCenterY;
			const distance = Math.hypot(dx, dy);
			const angle = Math.atan2(dy, dx) * (180 / Math.PI);

			aimLineEl.style.left = scaleX(playerCenterX) + '%';
			aimLineEl.style.top = scaleY(playerCenterY) + '%';
			aimLineEl.style.width = scaleX(distance) + '%';
			aimLineEl.style.transform = 'rotate(' + angle + 'deg)';
		}

		function render() {
			renderPlayer();
			renderBullets();
			renderEnemies();
			renderAimLine();
			updateHud();
		}

		function stopLoop() {
			state.running = false;
			if (state.rafId) {
				window.cancelAnimationFrame(state.rafId);
				state.rafId = null;
			}
		}

		function endGame() {
			state.gameOver = true;
			stopLoop();
			render();
			showOverlay('Game Over', 'Final Score: ' + state.score + '. Press Restart to play again.', false);
		}

		function tick(timestamp) {
			if (!state.running) {
				return;
			}

			if (!state.lastTime) {
				state.lastTime = timestamp;
				state.lastSpawnTime = timestamp;
			}

			updatePlayer();

			if (timestamp - state.lastSpawnTime >= CONFIG.spawnDelay) {
				spawnEnemy();
				state.lastSpawnTime = timestamp;
			}

			updateBullets();
			updateEnemies();
			handleBulletHits();
			render();

			if (state.gameOver) {
				endGame();
				return;
			}

			state.rafId = window.requestAnimationFrame(tick);
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

		function boardPointFromClient(clientX, clientY) {
			const rect = board.getBoundingClientRect();
			return {
				x: ((clientX - rect.left) / rect.width) * CONFIG.width,
				y: ((clientY - rect.top) / rect.height) * CONFIG.height
			};
		}

		function updateMouseFromEvent(e) {
			const point = boardPointFromClient(e.clientX, e.clientY);
			state.mouseX = clamp(point.x, 0, CONFIG.width);
			state.mouseY = clamp(point.y, 0, CONFIG.height);
			renderAimLine();
		}

		game.addEventListener('keydown', function (e) {
			const key = e.key;

			if (key === 'ArrowLeft' || key === 'a' || key === 'A') {
				state.keys.left = true;
				e.preventDefault();
			}
			if (key === 'ArrowRight' || key === 'd' || key === 'D') {
				state.keys.right = true;
				e.preventDefault();
			}
			if (key === 'ArrowUp' || key === 'w' || key === 'W') {
				state.keys.up = true;
				e.preventDefault();
			}
			if (key === 'ArrowDown' || key === 's' || key === 'S') {
				state.keys.down = true;
				e.preventDefault();
			}
			if ((key === 'r' || key === 'R') && !state.running) {
				resetGame();
				e.preventDefault();
			}
			if ((key === ' ' || key === 'Spacebar') && !state.running && overlay.hidden === false) {
				startLoop();
				e.preventDefault();
			}
		});

		game.addEventListener('keyup', function (e) {
			const key = e.key;

			if (key === 'ArrowLeft' || key === 'a' || key === 'A') {
				state.keys.left = false;
			}
			if (key === 'ArrowRight' || key === 'd' || key === 'D') {
				state.keys.right = false;
			}
			if (key === 'ArrowUp' || key === 'w' || key === 'W') {
				state.keys.up = false;
			}
			if (key === 'ArrowDown' || key === 's' || key === 'S') {
				state.keys.down = false;
			}
		});

		board.addEventListener('mousemove', function (e) {
			updateMouseFromEvent(e);
		});

		board.addEventListener('pointerdown', function (e) {
			updateMouseFromEvent(e);
			shootAt(state.mouseX, state.mouseY, performance.now());
			game.focus();
		});

		board.addEventListener('click', function (e) {
			updateMouseFromEvent(e);
			shootAt(state.mouseX, state.mouseY, performance.now());
			game.focus();
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

if (!function_exists('zo_game_top_down_shooter_render')) {
	function zo_game_top_down_shooter_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-top-down-shooter-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--top-down-shooter" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="tds-title">Top-Down Shooter</div>
			<div class="tds-instructions">Move with WASD or Arrow keys. Click or tap inside the board to shoot toward the pointer. Survive and score points.</div>

			<div class="tds-topbar">
				<div class="tds-stat">Score: <span data-role="score">0</span></div>
				<div class="tds-stat">Health: <span data-role="health">100</span></div>
			</div>

			<div class="tds-health-wrap">
				<div class="tds-health-bar">
					<div class="tds-health-fill" data-role="health-fill"></div>
				</div>
			</div>

			<div class="tds-board-wrap">
				<div class="tds-board" data-role="board">
					<div class="tds-aim-line" data-role="aim-line"></div>
					<div data-role="bullets"></div>
					<div data-role="enemies"></div>
					<div class="tds-player" data-role="player"></div>

					<div class="tds-overlay" data-role="overlay">
						<div class="tds-panel">
							<div class="tds-panel-title" data-role="overlay-title">Top-Down Shooter</div>
							<div class="tds-panel-text" data-role="overlay-text">Move, shoot, survive, and restart when needed.</div>
							<div class="tds-btn-row">
								<button type="button" class="tds-btn" data-role="start-btn">Start</button>
								<button type="button" class="tds-btn" data-role="restart-btn">Restart</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="tds-controls">Move: WASD or Arrows. Shoot: Click or tap. Restart: button. The game ends when health reaches zero.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'top-down-shooter',
	'name'            => 'Top-Down Shooter',
	'author'          => 'Arslan',
	'description'     => 'A browser-based top-down shooter with movement, shooting, enemies, score, health, and restart.',
	'render_callback' => 'zo_game_top_down_shooter_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);