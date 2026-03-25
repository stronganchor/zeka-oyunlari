
<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--meyve-topla * {
	box-sizing: border-box;
}

.zo-game-root--meyve-topla {
	max-width: 980px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--meyve-topla .zo-mt-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 20px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.zo-game-root--meyve-topla .zo-mt-title {
	margin: 0 0 8px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
}

.zo-game-root--meyve-topla .zo-mt-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	color: #4b5563;
}

.zo-game-root--meyve-topla .zo-mt-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--meyve-topla .zo-mt-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--meyve-topla .zo-mt-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--meyve-topla .zo-mt-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--meyve-topla .zo-mt-button {
	padding: 10px 16px;
	border-radius: 12px;
	border: 1px solid #2563eb;
	background: #2563eb;
	color: #ffffff;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--meyve-topla .zo-mt-button:hover,
.zo-game-root--meyve-topla .zo-mt-button:focus {
	opacity: 0.92;
}

.zo-game-root--meyve-topla .zo-mt-layout {
	display: grid;
	grid-template-columns: 1fr 260px;
	gap: 16px;
}

.zo-game-root--meyve-topla .zo-mt-board-wrap {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 16px;
	padding: 12px;
}

.zo-game-root--meyve-topla .zo-mt-canvas {
	display: block;
	width: 100%;
	max-width: 100%;
	height: auto;
	background: linear-gradient(180deg, #dff6ff 0%, #f0fff4 100%);
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	outline: none;
	touch-action: none;
}

.zo-game-root--meyve-topla .zo-mt-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 16px;
	padding: 14px;
}

.zo-game-root--meyve-topla .zo-mt-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
}

.zo-game-root--meyve-topla .zo-mt-side p,
.zo-game-root--meyve-topla .zo-mt-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #4b5563;
}

.zo-game-root--meyve-topla .zo-mt-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--meyve-topla .zo-mt-message {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #ecfeff;
	border: 1px solid #a5f3fc;
	font-size: 14px;
	font-weight: 700;
	color: #0f766e;
}

.zo-game-root--meyve-topla .zo-mt-touch {
	display: none;
	margin-top: 14px;
	grid-template-columns: repeat(3, 64px);
	grid-template-rows: repeat(2, 64px);
	gap: 8px;
	justify-content: center;
}

.zo-game-root--meyve-topla .zo-mt-touch-btn {
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	background: #ffffff;
	font-size: 24px;
	font-weight: 700;
	cursor: pointer;
	user-select: none;
}

.zo-game-root--meyve-topla .zo-mt-touch-btn[data-dir="up"] {
	grid-column: 2;
	grid-row: 1;
}

.zo-game-root--meyve-topla .zo-mt-touch-btn[data-dir="left"] {
	grid-column: 1;
	grid-row: 2;
}

.zo-game-root--meyve-topla .zo-mt-touch-btn[data-dir="down"] {
	grid-column: 2;
	grid-row: 2;
}

.zo-game-root--meyve-topla .zo-mt-touch-btn[data-dir="right"] {
	grid-column: 3;
	grid-row: 2;
}

@media (max-width: 860px) {
	.zo-game-root--meyve-topla .zo-mt-layout {
		grid-template-columns: 1fr;
	}

	.zo-game-root--meyve-topla .zo-mt-touch {
		display: grid;
	}
}

@media (max-width: 640px) {
	.zo-game-root--meyve-topla {
		padding: 10px;
	}

	.zo-game-root--meyve-topla .zo-mt-wrap {
		padding: 12px;
	}

	.zo-game-root--meyve-topla .zo-mt-title {
		font-size: 24px;
	}

	.zo-game-root--meyve-topla .zo-mt-stat {
		font-size: 13px;
		padding: 8px 10px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--meyve-topla');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-mt-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = root.querySelector('.zo-mt-start');
		const restartButton = root.querySelector('.zo-mt-restart');
		const scoreEl = root.querySelector('.zo-mt-score');
		const levelEl = root.querySelector('.zo-mt-level');
		const livesEl = root.querySelector('.zo-mt-lives');
		const bestEl = root.querySelector('.zo-mt-best');
		const messageEl = root.querySelector('.zo-mt-message');
		const touchButtons = root.querySelectorAll('.zo-mt-touch-btn');

		const WIDTH = 720;
		const HEIGHT = 440;

		const state = {
			running: false,
			gameOver: false,
			score: 0,
			level: 1,
			lives: 3,
			best: 0,
			lastTime: 0,
			player: null,
			fruits: [],
			muds: [],
			keys: {
				up: false,
				down: false,
				left: false,
				right: false
			}
		};

		const fruitTypes = ['🍎', '🍌', '🍓', '🍇', '🍊'];
		const mudEmoji = '🟤';

		try {
			const savedBest = parseInt(localStorage.getItem('zo_meyve_topla_best') || '0', 10);
			if (!isNaN(savedBest) && savedBest > 0) {
				state.best = savedBest;
			}
		} catch (e) {}

		function rand(min, max) {
			return Math.random() * (max - min) + min;
		}

		function randInt(min, max) {
			return Math.floor(rand(min, max + 1));
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function updateStats() {
			scoreEl.textContent = String(state.score);
			levelEl.textContent = String(state.level);
			livesEl.textContent = String(state.lives);
			bestEl.textContent = String(state.best);
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function createPlayer() {
			return {
				x: WIDTH / 2,
				y: HEIGHT / 2,
				r: 20,
				speed: 4.3,
				hitCooldown: 0
			};
		}

		function createFruit() {
			return {
				x: rand(40, WIDTH - 40),
				y: rand(40, HEIGHT - 40),
				r: 16,
				emoji: fruitTypes[randInt(0, fruitTypes.length - 1)]
			};
		}

		function createMud(level) {
			return {
				x: rand(60, WIDTH - 60),
				y: rand(60, HEIGHT - 60),
				r: rand(18, 28),
				dx: rand(1.0 + (level * 0.15), 1.8 + (level * 0.2)) * (Math.random() < 0.5 ? -1 : 1),
				dy: rand(1.0 + (level * 0.15), 1.8 + (level * 0.2)) * (Math.random() < 0.5 ? -1 : 1)
			};
		}

		function distance(a, b) {
			const dx = a.x - b.x;
			const dy = a.y - b.y;
			return Math.sqrt((dx * dx) + (dy * dy));
		}

		function resetObjects() {
			state.player = createPlayer();
			state.fruits = [];
			state.muds = [];

			const fruitCount = Math.min(3 + state.level, 9);
			const mudCount = Math.min(2 + Math.floor(state.level / 2), 8);

			for (let i = 0; i < fruitCount; i++) {
				state.fruits.push(createFruit());
			}

			for (let i = 0; i < mudCount; i++) {
				state.muds.push(createMud(state.level));
			}
		}

		function resetGame() {
			state.running = false;
			state.gameOver = false;
			state.score = 0;
			state.level = 1;
			state.lives = 3;
			state.lastTime = 0;
			resetObjects();
			updateStats();
			setMessage('Başlamak için "Oyunu Başlat" düğmesine bas.');
			draw();
		}

		function startGame() {
			state.running = true;
			state.gameOver = false;
			state.lastTime = performance.now();
			setMessage('Meyveleri topla. Çamurlara dikkat et.');
			requestAnimationFrame(loop);
		}

		function endGame() {
			state.running = false;
			state.gameOver = true;

			if (state.score > state.best) {
				state.best = state.score;
				try {
					localStorage.setItem('zo_meyve_topla_best', String(state.best));
				} catch (e) {}
			}

			updateStats();
			setMessage('Oyun bitti. Skorun: ' + state.score + '.');
			draw();
		}

		function nextLevel() {
			state.level += 1;
			resetObjects();
			updateStats();
			setMessage('Harika. ' + state.level + '. seviyeye geçtin.');
		}

		function movePlayer() {
			const p = state.player;

			if (state.keys.up) p.y -= p.speed;
			if (state.keys.down) p.y += p.speed;
			if (state.keys.left) p.x -= p.speed;
			if (state.keys.right) p.x += p.speed;

			p.x = clamp(p.x, p.r, WIDTH - p.r);
			p.y = clamp(p.y, p.r, HEIGHT - p.r);

			if (p.hitCooldown > 0) {
				p.hitCooldown -= 1;
			}
		}

		function moveMuds() {
			for (let i = 0; i < state.muds.length; i++) {
				const mud = state.muds[i];
				mud.x += mud.dx;
				mud.y += mud.dy;

				if (mud.x <= mud.r || mud.x >= WIDTH - mud.r) {
					mud.dx *= -1;
				}

				if (mud.y <= mud.r || mud.y >= HEIGHT - mud.r) {
					mud.dy *= -1;
				}
			}
		}

		function collectFruits() {
			for (let i = state.fruits.length - 1; i >= 0; i--) {
				const fruit = state.fruits[i];
				if (distance(state.player, fruit) < state.player.r + fruit.r) {
					state.fruits.splice(i, 1);
					state.score += 10;
				}
			}

			if (state.fruits.length === 0) {
				nextLevel();
			}
		}

		function checkMudHits() {
			if (state.player.hitCooldown > 0) {
				return;
			}

			for (let i = 0; i < state.muds.length; i++) {
				const mud = state.muds[i];
				if (distance(state.player, mud) < state.player.r + mud.r) {
					state.lives -= 1;
					state.player.hitCooldown = 60;
					updateStats();

					if (state.lives <= 0) {
						endGame();
						return;
					}

					setMessage('Dikkat. Bir can gitti.');
					break;
				}
			}
		}

		function update() {
			movePlayer();
			moveMuds();
			collectFruits();
			checkMudHits();
			updateStats();
		}

		function drawBackground() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			ctx.save();
			ctx.fillStyle = 'rgba(255,255,255,0.35)';
			for (let i = 0; i < 12; i++) {
				ctx.beginPath();
				ctx.arc(40 + (i * 60), 30 + ((i % 2) * 12), 10, 0, Math.PI * 2);
				ctx.fill();
			}
			ctx.restore();

			ctx.save();
			ctx.fillStyle = '#86efac';
			ctx.fillRect(0, HEIGHT - 40, WIDTH, 40);
			ctx.restore();
		}

		function drawPlayer() {
			const p = state.player;
			if (!p) return;

			ctx.save();

			if (p.hitCooldown > 0 && Math.floor(p.hitCooldown / 5) % 2 === 0) {
				ctx.globalAlpha = 0.45;
			}

			ctx.beginPath();
			ctx.fillStyle = '#2563eb';
			ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
			ctx.fill();

			ctx.fillStyle = '#ffffff';
			ctx.beginPath();
			ctx.arc(p.x - 6, p.y - 4, 3, 0, Math.PI * 2);
			ctx.arc(p.x + 6, p.y - 4, 3, 0, Math.PI * 2);
			ctx.fill();

			ctx.strokeStyle = '#ffffff';
			ctx.lineWidth = 2;
			ctx.beginPath();
			ctx.arc(p.x, p.y + 3, 7, 0.2, Math.PI - 0.2);
			ctx.stroke();

			ctx.restore();
		}

		function drawFruits() {
			ctx.save();
			ctx.font = '28px Arial';
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';

			for (let i = 0; i < state.fruits.length; i++) {
				const fruit = state.fruits[i];
				ctx.fillText(fruit.emoji, fruit.x, fruit.y + 2);
			}

			ctx.restore();
		}

		function drawMuds() {
			ctx.save();
			ctx.font = '28px Arial';
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';

			for (let i = 0; i < state.muds.length; i++) {
				const mud = state.muds[i];
				ctx.fillText(mudEmoji, mud.x, mud.y + 2);
			}

			ctx.restore();
		}

		function drawOverlay() {
			if (state.running) {
				return;
			}

			ctx.save();
			ctx.fillStyle = 'rgba(15, 23, 42, 0.16)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			ctx.textAlign = 'center';
			ctx.fillStyle = '#0f172a';

			if (state.gameOver) {
				ctx.font = 'bold 36px Arial';
				ctx.fillText('Oyun Bitti', WIDTH / 2, HEIGHT / 2 - 8);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Skor: ' + state.score, WIDTH / 2, HEIGHT / 2 + 28);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Meyve Topla', WIDTH / 2, HEIGHT / 2 - 8);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Başlamak için düğmeye bas', WIDTH / 2, HEIGHT / 2 + 28);
			}

			ctx.restore();
		}

		function draw() {
			drawBackground();
			drawFruits();
			drawMuds();
			drawPlayer();
			drawOverlay();
		}

		function loop(timestamp) {
			if (!state.running) {
				draw();
				return;
			}

			state.lastTime = timestamp;
			update();
			draw();

			if (state.running) {
				requestAnimationFrame(loop);
			}
		}

		function setKeyState(code, isDown) {
			if (code === 'ArrowUp' || code === 'KeyW') state.keys.up = isDown;
			if (code === 'ArrowDown' || code === 'KeyS') state.keys.down = isDown;
			if (code === 'ArrowLeft' || code === 'KeyA') state.keys.left = isDown;
			if (code === 'ArrowRight' || code === 'KeyD') state.keys.right = isDown;
		}

		window.addEventListener('keydown', function (e) {
			if (!root.contains(document.activeElement) && document.activeElement !== document.body) {
				return;
			}

			if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'KeyW', 'KeyA', 'KeyS', 'KeyD', 'Space'].indexOf(e.code) !== -1) {
				e.preventDefault();
			}

			if (e.code === 'Space' && !state.running) {
				startGame();
				return;
			}

			setKeyState(e.code, true);
		});

		window.addEventListener('keyup', function (e) {
			setKeyState(e.code, false);
		});

		startButton.addEventListener('click', function () {
			if (!state.running) {
				startGame();
				canvas.focus();
			}
		});

		restartButton.addEventListener('click', function () {
			resetGame();
			canvas.focus();
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

		updateStats();
		resetGame();
	});
});
JS;

if (!function_exists('zo_meyve_topla_render')) {
	function zo_meyve_topla_render($post_id = 0, $game = array()) {
		$game_id = 'zo-meyve-topla-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--meyve-topla" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-mt-wrap">
				<h2 class="zo-mt-title">Meyve Topla</h2>
				<p class="zo-mt-subtitle">Meyveleri topla, çamurlardan kaç, bölüm atla.</p>

				<div class="zo-mt-topbar">
					<div class="zo-mt-stats">
						<div class="zo-mt-stat">Skor: <span class="zo-mt-score">0</span></div>
						<div class="zo-mt-stat">Seviye: <span class="zo-mt-level">1</span></div>
						<div class="zo-mt-stat">Can: <span class="zo-mt-lives">3</span></div>
						<div class="zo-mt-stat">En İyi: <span class="zo-mt-best">0</span></div>
					</div>

					<div class="zo-mt-controls">
						<button type="button" class="zo-mt-button zo-mt-start">Oyunu Başlat</button>
						<button type="button" class="zo-mt-button zo-mt-restart">Sıfırla</button>
					</div>
				</div>

				<div class="zo-mt-layout">
					<div class="zo-mt-board-wrap">
						<canvas class="zo-mt-canvas" width="720" height="440" tabindex="0" aria-label="Meyve Topla oyunu alanı"></canvas>

						<div class="zo-mt-touch">
							<button type="button" class="zo-mt-touch-btn" data-dir="up">↑</button>
							<button type="button" class="zo-mt-touch-btn" data-dir="left">←</button>
							<button type="button" class="zo-mt-touch-btn" data-dir="down">↓</button>
							<button type="button" class="zo-mt-touch-btn" data-dir="right">→</button>
						</div>

						<div class="zo-mt-message">Başlamak için "Oyunu Başlat" düğmesine bas.</div>
					</div>

					<div class="zo-mt-side">
						<h3>Nasıl Oynanır</h3>
						<ul>
							<li>Mavi karakteri hareket ettir.</li>
							<li>Meyveleri toplayınca skor kazanırsın.</li>
							<li>Tüm meyveler bitince yeni seviyeye geçersin.</li>
							<li>Çamurlara çarparsan can kaybedersin.</li>
						</ul>

						<h3>Kontroller</h3>
						<ul>
							<li>Ok tuşları</li>
							<li>veya W A S D</li>
							<li>Boşluk tuşu ile başlat</li>
						</ul>

						<p>Bu oyun kısa, renkli ve çocuk dostu olduğu için Azad için iyi bir başlangıç oyunu olur.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'meyve-topla',
	'name'            => 'Meyve Topla',
	'author'          => 'Arslan',
	'description'     => 'Renkli ve kolay bir meyve toplama oyunu.',
	'render_callback' => 'zo_meyve_topla_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);