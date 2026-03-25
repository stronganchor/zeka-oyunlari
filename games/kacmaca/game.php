<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--kacma-oyunu * {
	box-sizing: border-box;
}

.zo-game-root--kacma-oyunu {
	max-width: 980px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--kacma-oyunu .zo-ko-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.zo-game-root--kacma-oyunu .zo-ko-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
}

.zo-game-root--kacma-oyunu .zo-ko-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	color: #4b5563;
}

.zo-game-root--kacma-oyunu .zo-ko-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--kacma-oyunu .zo-ko-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--kacma-oyunu .zo-ko-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--kacma-oyunu .zo-ko-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--kacma-oyunu .zo-ko-select,
.zo-game-root--kacma-oyunu .zo-ko-button {
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	font-size: 15px;
}

.zo-game-root--kacma-oyunu .zo-ko-select {
	padding: 10px 12px;
	background: #ffffff;
}

.zo-game-root--kacma-oyunu .zo-ko-button {
	padding: 10px 16px;
	font-weight: 700;
	cursor: pointer;
	background: #2563eb;
	color: #ffffff;
	border-color: #2563eb;
}

.zo-game-root--kacma-oyunu .zo-ko-button:hover,
.zo-game-root--kacma-oyunu .zo-ko-button:focus {
	opacity: 0.92;
}

.zo-game-root--kacma-oyunu .zo-ko-layout {
	display: grid;
	grid-template-columns: 1fr 250px;
	gap: 16px;
}

.zo-game-root--kacma-oyunu .zo-ko-board-wrap {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 16px;
	padding: 12px;
}

.zo-game-root--kacma-oyunu .zo-ko-canvas {
	display: block;
	width: 100%;
	max-width: 100%;
	height: auto;
	background: linear-gradient(180deg, #f8fbff 0%, #eef5fb 100%);
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	outline: none;
	touch-action: none;
}

.zo-game-root--kacma-oyunu .zo-ko-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 16px;
	padding: 14px;
}

.zo-game-root--kacma-oyunu .zo-ko-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
}

.zo-game-root--kacma-oyunu .zo-ko-side p,
.zo-game-root--kacma-oyunu .zo-ko-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #4b5563;
}

.zo-game-root--kacma-oyunu .zo-ko-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--kacma-oyunu .zo-ko-message {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	color: #1d4ed8;
}

.zo-game-root--kacma-oyunu .zo-ko-touch {
	display: none;
	margin-top: 14px;
	grid-template-columns: repeat(3, 64px);
	grid-template-rows: repeat(2, 64px);
	gap: 8px;
	justify-content: center;
}

.zo-game-root--kacma-oyunu .zo-ko-touch-btn {
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	background: #ffffff;
	font-size: 24px;
	font-weight: 700;
	cursor: pointer;
	user-select: none;
}

.zo-game-root--kacma-oyunu .zo-ko-touch-btn[data-dir="up"] {
	grid-column: 2;
	grid-row: 1;
}

.zo-game-root--kacma-oyunu .zo-ko-touch-btn[data-dir="left"] {
	grid-column: 1;
	grid-row: 2;
}

.zo-game-root--kacma-oyunu .zo-ko-touch-btn[data-dir="down"] {
	grid-column: 2;
	grid-row: 2;
}

.zo-game-root--kacma-oyunu .zo-ko-touch-btn[data-dir="right"] {
	grid-column: 3;
	grid-row: 2;
}

@media (max-width: 860px) {
	.zo-game-root--kacma-oyunu .zo-ko-layout {
		grid-template-columns: 1fr;
	}

	.zo-game-root--kacma-oyunu .zo-ko-touch {
		display: grid;
	}
}

@media (max-width: 640px) {
	.zo-game-root--kacma-oyunu {
		padding: 10px;
	}

	.zo-game-root--kacma-oyunu .zo-ko-wrap {
		padding: 12px;
	}

	.zo-game-root--kacma-oyunu .zo-ko-title {
		font-size: 24px;
	}

	.zo-game-root--kacma-oyunu .zo-ko-stat {
		font-size: 13px;
		padding: 8px 10px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--kacma-oyunu');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-ko-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const levelSelect = root.querySelector('.zo-ko-select');
		const startButton = root.querySelector('.zo-ko-start');
		const restartButton = root.querySelector('.zo-ko-restart');
		const scoreEl = root.querySelector('.zo-ko-score');
		const timeEl = root.querySelector('.zo-ko-time');
		const levelEl = root.querySelector('.zo-ko-level');
		const bestEl = root.querySelector('.zo-ko-best');
		const messageEl = root.querySelector('.zo-ko-message');
		const touchButtons = root.querySelectorAll('.zo-ko-touch-btn');

		const WIDTH = 700;
		const HEIGHT = 440;

		const config = {
			easy: {
				label: 'Kolay',
				enemyCount: 4,
				enemySpeedMin: 1.2,
				enemySpeedMax: 2.1,
				playerSpeed: 4.2
			},
			medium: {
				label: 'Orta',
				enemyCount: 6,
				enemySpeedMin: 1.9,
				enemySpeedMax: 3.0,
				playerSpeed: 4.4
			},
			hard: {
				label: 'Zor',
				enemyCount: 8,
				enemySpeedMin: 2.8,
				enemySpeedMax: 4.0,
				playerSpeed: 4.6
			}
		};

		const state = {
			running: false,
			gameOver: false,
			score: 0,
			survivalTime: 0,
			best: 0,
			lastTime: 0,
			player: null,
			enemies: [],
			keys: {
				up: false,
				down: false,
				left: false,
				right: false
			},
			levelKey: 'easy'
		};

		try {
			const savedBest = parseInt(localStorage.getItem('zo_kacma_oyunu_best') || '0', 10);
			if (!isNaN(savedBest) && savedBest > 0) {
				state.best = savedBest;
			}
		} catch (e) {}

		function rand(min, max) {
			return Math.random() * (max - min) + min;
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function updateStats() {
			scoreEl.textContent = String(state.score);
			timeEl.textContent = state.survivalTime.toFixed(1) + ' sn';
			levelEl.textContent = config[state.levelKey].label;
			bestEl.textContent = String(state.best);
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function createPlayer() {
			const speed = config[state.levelKey].playerSpeed;
			return {
				x: WIDTH / 2 - 14,
				y: HEIGHT / 2 - 14,
				w: 28,
				h: 28,
				speed: speed,
				color: '#2563eb'
			};
		}

		function createEnemy(existingEnemies) {
			let enemy = null;
			let tries = 0;
			const level = config[state.levelKey];

			while (tries < 200) {
				const size = rand(24, 42);
				const x = rand(10, WIDTH - size - 10);
				const y = rand(10, HEIGHT - size - 10);

				const dx = rand(level.enemySpeedMin, level.enemySpeedMax) * (Math.random() < 0.5 ? -1 : 1);
				const dy = rand(level.enemySpeedMin, level.enemySpeedMax) * (Math.random() < 0.5 ? -1 : 1);

				const candidate = {
					x: x,
					y: y,
					w: size,
					h: size,
					dx: dx,
					dy: dy,
					color: '#ef4444'
				};

				if (!isColliding(candidate, state.player, 70)) {
					let overlaps = false;

					for (let i = 0; i < existingEnemies.length; i++) {
						if (isColliding(candidate, existingEnemies[i], 20)) {
							overlaps = true;
							break;
						}
					}

					if (!overlaps) {
						enemy = candidate;
						break;
					}
				}

				tries++;
			}

			if (!enemy) {
				enemy = {
					x: rand(10, WIDTH - 50),
					y: rand(10, HEIGHT - 50),
					w: 30,
					h: 30,
					dx: rand(level.enemySpeedMin, level.enemySpeedMax),
					dy: rand(level.enemySpeedMin, level.enemySpeedMax),
					color: '#ef4444'
				};
			}

			return enemy;
		}

		function isColliding(a, b, padding) {
			padding = padding || 0;
			return !(
				a.x + a.w + padding < b.x ||
				a.x > b.x + b.w + padding ||
				a.y + a.h + padding < b.y ||
				a.y > b.y + b.h + padding
			);
		}

		function resetGame() {
			state.levelKey = levelSelect.value in config ? levelSelect.value : 'easy';
			state.running = false;
			state.gameOver = false;
			state.score = 0;
			state.survivalTime = 0;
			state.lastTime = 0;
			state.player = createPlayer();
			state.enemies = [];

			for (let i = 0; i < config[state.levelKey].enemyCount; i++) {
				state.enemies.push(createEnemy(state.enemies));
			}

			updateStats();
			setMessage('Başlamak için "Oyunu Başlat" düğmesine bas.');
			draw();
		}

		function startGame() {
			state.levelKey = levelSelect.value in config ? levelSelect.value : 'easy';
			state.player = createPlayer();
			state.enemies = [];

			for (let i = 0; i < config[state.levelKey].enemyCount; i++) {
				state.enemies.push(createEnemy(state.enemies));
			}

			state.running = true;
			state.gameOver = false;
			state.score = 0;
			state.survivalTime = 0;
			state.lastTime = performance.now();

			updateStats();
			setMessage('Kaç. Kırmızı karelere değme.');
			requestAnimationFrame(loop);
		}

		function endGame() {
			state.running = false;
			state.gameOver = true;

			if (state.score > state.best) {
				state.best = state.score;
				try {
					localStorage.setItem('zo_kacma_oyunu_best', String(state.best));
				} catch (e) {}
			}

			updateStats();
			setMessage('Oyun bitti. Skorun: ' + state.score + '. Tekrar dene.');
			draw();
		}

		function movePlayer() {
			if (!state.player) {
				return;
			}

			if (state.keys.up) {
				state.player.y -= state.player.speed;
			}
			if (state.keys.down) {
				state.player.y += state.player.speed;
			}
			if (state.keys.left) {
				state.player.x -= state.player.speed;
			}
			if (state.keys.right) {
				state.player.x += state.player.speed;
			}

			state.player.x = clamp(state.player.x, 0, WIDTH - state.player.w);
			state.player.y = clamp(state.player.y, 0, HEIGHT - state.player.h);
		}

		function moveEnemies() {
			for (let i = 0; i < state.enemies.length; i++) {
				const enemy = state.enemies[i];

				enemy.x += enemy.dx;
				enemy.y += enemy.dy;

				if (enemy.x <= 0 || enemy.x + enemy.w >= WIDTH) {
					enemy.dx *= -1;
					enemy.x = clamp(enemy.x, 0, WIDTH - enemy.w);
				}

				if (enemy.y <= 0 || enemy.y + enemy.h >= HEIGHT) {
					enemy.dy *= -1;
					enemy.y = clamp(enemy.y, 0, HEIGHT - enemy.h);
				}
			}
		}

		function checkCollisions() {
			for (let i = 0; i < state.enemies.length; i++) {
				if (isColliding(state.player, state.enemies[i], 0)) {
					endGame();
					return;
				}
			}
		}

		function update(delta) {
			movePlayer();
			moveEnemies();
			checkCollisions();

			if (!state.running) {
				return;
			}

			state.survivalTime += delta;
			state.score = Math.floor(state.survivalTime * 10);
			updateStats();
		}

		function drawGrid() {
			ctx.save();
			ctx.strokeStyle = 'rgba(148, 163, 184, 0.20)';
			ctx.lineWidth = 1;

			for (let x = 20; x < WIDTH; x += 20) {
				ctx.beginPath();
				ctx.moveTo(x, 0);
				ctx.lineTo(x, HEIGHT);
				ctx.stroke();
			}

			for (let y = 20; y < HEIGHT; y += 20) {
				ctx.beginPath();
				ctx.moveTo(0, y);
				ctx.lineTo(WIDTH, y);
				ctx.stroke();
			}

			ctx.restore();
		}

		function drawPlayer() {
			const p = state.player;
			if (!p) {
				return;
			}

			ctx.fillStyle = p.color;
			ctx.fillRect(p.x, p.y, p.w, p.h);

			ctx.strokeStyle = '#ffffff';
			ctx.lineWidth = 2;
			ctx.strokeRect(p.x + 2, p.y + 2, p.w - 4, p.h - 4);
		}

		function drawEnemies() {
			for (let i = 0; i < state.enemies.length; i++) {
				const e = state.enemies[i];
				ctx.fillStyle = e.color;
				ctx.fillRect(e.x, e.y, e.w, e.h);

				ctx.strokeStyle = '#7f1d1d';
				ctx.lineWidth = 2;
				ctx.strokeRect(e.x + 1, e.y + 1, e.w - 2, e.h - 2);
			}
		}

		function drawOverlay() {
			if (state.running) {
				return;
			}

			ctx.save();
			ctx.fillStyle = 'rgba(15, 23, 42, 0.18)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#0f172a';
			ctx.textAlign = 'center';

			if (state.gameOver) {
				ctx.font = 'bold 36px Arial';
				ctx.fillText('Oyun Bitti', WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Skor: ' + state.score, WIDTH / 2, HEIGHT / 2 + 28);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Kaçma Oyunu', WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Başlamak için düğmeye bas', WIDTH / 2, HEIGHT / 2 + 28);
			}

			ctx.restore();
		}

		function draw() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);
			drawGrid();
			drawEnemies();
			drawPlayer();
			drawOverlay();
		}

		function loop(timestamp) {
			if (!state.running) {
				draw();
				return;
			}

			const deltaMs = timestamp - state.lastTime;
			state.lastTime = timestamp;
			const delta = Math.min(deltaMs / 1000, 0.05);

			update(delta);
			draw();

			if (state.running) {
				requestAnimationFrame(loop);
			}
		}

		function setKeyState(code, isDown) {
			if (code === 'ArrowUp' || code === 'KeyW') {
				state.keys.up = isDown;
			} else if (code === 'ArrowDown' || code === 'KeyS') {
				state.keys.down = isDown;
			} else if (code === 'ArrowLeft' || code === 'KeyA') {
				state.keys.left = isDown;
			} else if (code === 'ArrowRight' || code === 'KeyD') {
				state.keys.right = isDown;
			}
		}

		window.addEventListener('keydown', function (e) {
			if (!root.contains(document.activeElement) && document.activeElement !== document.body) {
				return;
			}

			if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'KeyW', 'KeyA', 'KeyS', 'KeyD', 'Space'].indexOf(e.code) !== -1) {
				e.preventDefault();
			}

			if (e.code === 'Space') {
				if (!state.running) {
					startGame();
				}
				return;
			}

			setKeyState(e.code, true);
		});

		window.addEventListener('keyup', function (e) {
			setKeyState(e.code, false);
		});

		startButton.addEventListener('click', function () {
			startGame();
			canvas.focus();
		});

		restartButton.addEventListener('click', function () {
			resetGame();
			canvas.focus();
		});

		levelSelect.addEventListener('change', function () {
			resetGame();
		});

		touchButtons.forEach(function (btn) {
			const dir = btn.getAttribute('data-dir');

			function pressStart(e) {
				e.preventDefault();
				if (dir === 'up') state.keys.up = true;
				if (dir === 'down') state.keys.down = true;
				if (dir === 'left') state.keys.left = true;
				if (dir === 'right') state.keys.right = true;
			}

			function pressEnd(e) {
				e.preventDefault();
				if (dir === 'up') state.keys.up = false;
				if (dir === 'down') state.keys.down = false;
				if (dir === 'left') state.keys.left = false;
				if (dir === 'right') state.keys.right = false;
			}

			btn.addEventListener('mousedown', pressStart);
			btn.addEventListener('mouseup', pressEnd);
			btn.addEventListener('mouseleave', pressEnd);
			btn.addEventListener('touchstart', pressStart, { passive: false });
			btn.addEventListener('touchend', pressEnd, { passive: false });
			btn.addEventListener('touchcancel', pressEnd, { passive: false });
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_kacma_oyunu_render')) {
	function zo_kacma_oyunu_render($post_id = 0, $game = array()) {
		$game_id = 'zo-kacma-oyunu-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--kacma-oyunu" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-ko-wrap">
				<h2 class="zo-ko-title">Kaçma Oyunu</h2>
				<p class="zo-ko-subtitle">Mavi kareyi hareket ettir. Kırmızı karelerden kaç. Kolay, Orta ve Zor seviye seçebilirsin.</p>

				<div class="zo-ko-topbar">
					<div class="zo-ko-stats">
						<div class="zo-ko-stat">Skor: <span class="zo-ko-score">0</span></div>
						<div class="zo-ko-stat">Süre: <span class="zo-ko-time">0.0 sn</span></div>
						<div class="zo-ko-stat">Seviye: <span class="zo-ko-level">Kolay</span></div>
						<div class="zo-ko-stat">En İyi: <span class="zo-ko-best">0</span></div>
					</div>

					<div class="zo-ko-controls">
						<select class="zo-ko-select" aria-label="Zorluk seç">
							<option value="easy">Kolay</option>
							<option value="medium">Orta</option>
							<option value="hard">Zor</option>
						</select>
						<button type="button" class="zo-ko-button zo-ko-start">Oyunu Başlat</button>
						<button type="button" class="zo-ko-button zo-ko-restart">Sıfırla</button>
					</div>
				</div>

				<div class="zo-ko-layout">
					<div class="zo-ko-board-wrap">
						<canvas class="zo-ko-canvas" width="700" height="440" tabindex="0" aria-label="Kaçma oyunu alanı"></canvas>

						<div class="zo-ko-touch">
							<button type="button" class="zo-ko-touch-btn" data-dir="up">↑</button>
							<button type="button" class="zo-ko-touch-btn" data-dir="left">←</button>
							<button type="button" class="zo-ko-touch-btn" data-dir="down">↓</button>
							<button type="button" class="zo-ko-touch-btn" data-dir="right">→</button>
						</div>

						<div class="zo-ko-message">Başlamak için "Oyunu Başlat" düğmesine bas.</div>
					</div>

					<div class="zo-ko-side">
						<h3>Nasıl Oynanır</h3>
						<ul>
							<li>Mavi kare sensin.</li>
							<li>Kırmızı karelere değersen oyun biter.</li>
							<li>Ok tuşları veya W A S D ile hareket et.</li>
							<li>Ne kadar uzun kaçarsan skorun o kadar artar.</li>
						</ul>

						<h3>Seviyeler</h3>
						<ul>
							<li><strong>Kolay:</strong> Daha az düşman, daha yavaş hız.</li>
							<li><strong>Orta:</strong> Daha fazla düşman, daha hızlı hareket.</li>
							<li><strong>Zor:</strong> En çok düşman, en hızlı tempo.</li>
						</ul>

						<p>Boşluk tuşu ile de oyunu başlatabilirsin.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'kacma-oyunu',
	'name'            => 'Kaçma Oyunu',
	'author'          => 'Arslan',
	'description'     => 'Kolay, orta ve zor seviyeleri olan basit bir kaçma oyunu.',
	'render_callback' => 'zo_kacma_oyunu_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);