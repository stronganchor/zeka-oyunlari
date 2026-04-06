<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--penalti-krali * {
	box-sizing: border-box;
}

.zo-game-root--penalti-krali {
	max-width: 980px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--penalti-krali .zo-pk-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 22px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.zo-game-root--penalti-krali .zo-pk-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 32px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--penalti-krali .zo-pk-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--penalti-krali .zo-pk-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--penalti-krali .zo-pk-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--penalti-krali .zo-pk-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--penalti-krali .zo-pk-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--penalti-krali .zo-pk-btn {
	padding: 10px 16px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	color: #1f2937;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--penalti-krali .zo-pk-btn--primary {
	background: #16a34a;
	border-color: #16a34a;
	color: #ffffff;
}

.zo-game-root--penalti-krali .zo-pk-btn--danger {
	background: #ef4444;
	border-color: #ef4444;
	color: #ffffff;
}

.zo-game-root--penalti-krali .zo-pk-layout {
	display: grid;
	grid-template-columns: 1fr 280px;
	gap: 16px;
}

.zo-game-root--penalti-krali .zo-pk-board-wrap {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 12px;
}

.zo-game-root--penalti-krali .zo-pk-canvas {
	display: block;
	width: 100%;
	height: auto;
	background: linear-gradient(180deg, #93c5fd 0%, #86efac 45%, #4ade80 100%);
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	cursor: crosshair;
	touch-action: none;
}

.zo-game-root--penalti-krali .zo-pk-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--penalti-krali .zo-pk-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
	color: #0f172a;
}

.zo-game-root--penalti-krali .zo-pk-side p,
.zo-game-root--penalti-krali .zo-pk-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--penalti-krali .zo-pk-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--penalti-krali .zo-pk-shot-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 8px;
	margin-bottom: 14px;
}

.zo-game-root--penalti-krali .zo-pk-shot-btn {
	padding: 10px 8px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	font: inherit;
	font-size: 13px;
	font-weight: 700;
	cursor: pointer;
	text-align: center;
}

.zo-game-root--penalti-krali .zo-pk-shot-btn:hover,
.zo-game-root--penalti-krali .zo-pk-shot-btn:focus {
	outline: none;
	background: #eff6ff;
	border-color: #93c5fd;
}

.zo-game-root--penalti-krali .zo-pk-message {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	color: #1d4ed8;
	min-height: 48px;
}

.zo-game-root--penalti-krali .zo-pk-power-wrap {
	margin-top: 12px;
}

.zo-game-root--penalti-krali .zo-pk-power-label {
	margin-bottom: 6px;
	font-size: 13px;
	font-weight: 700;
	color: #334155;
}

.zo-game-root--penalti-krali .zo-pk-power-bar {
	height: 14px;
	border-radius: 999px;
	background: #e2e8f0;
	border: 1px solid #cbd5e1;
	overflow: hidden;
}

.zo-game-root--penalti-krali .zo-pk-power-fill {
	height: 100%;
	width: 0%;
	background: linear-gradient(90deg, #22c55e 0%, #f59e0b 50%, #ef4444 100%);
	border-radius: 999px;
}

@media (max-width: 860px) {
	.zo-game-root--penalti-krali .zo-pk-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 640px) {
	.zo-game-root--penalti-krali {
		padding: 10px;
	}

	.zo-game-root--penalti-krali .zo-pk-wrap {
		padding: 12px;
	}

	.zo-game-root--penalti-krali .zo-pk-title {
		font-size: 26px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--penalti-krali');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-pk-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = root.querySelector('.zo-pk-start');
		const restartButton = root.querySelector('.zo-pk-restart');
		const scoreEl = root.querySelector('.zo-pk-score');
		const shotsEl = root.querySelector('.zo-pk-shots');
		const bestEl = root.querySelector('.zo-pk-best');
		const levelEl = root.querySelector('.zo-pk-level');
		const messageEl = root.querySelector('.zo-pk-message');
		const powerFill = root.querySelector('.zo-pk-power-fill');
		const shotButtons = root.querySelectorAll('.zo-pk-shot-btn');

		const WIDTH = 780;
		const HEIGHT = 520;

		const state = {
			running: false,
			gameOver: false,
			score: 0,
			shotsLeft: 10,
			best: 0,
			level: 1,
			animating: false,
			currentAim: 'top-left',
			ball: null,
			keeper: null,
			resultText: '',
			savedFlash: 0,
			power: 70
		};

		const aimMap = {
			'top-left': {x: 260, y: 120},
			'top-center': {x: 390, y: 105},
			'top-right': {x: 520, y: 120},
			'mid-left': {x: 265, y: 165},
			'mid-center': {x: 390, y: 165},
			'mid-right': {x: 515, y: 165},
			'low-left': {x: 275, y: 215},
			'low-center': {x: 390, y: 220},
			'low-right': {x: 505, y: 215}
		};

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function updateStats() {
			scoreEl.textContent = String(state.score);
			shotsEl.textContent = String(state.shotsLeft);
			bestEl.textContent = String(state.best);
			levelEl.textContent = String(state.level);
			powerFill.style.width = state.power + '%';
		}

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function randomKeeperTarget() {
			const targets = [
				{x: 280, y: 150},
				{x: 390, y: 140},
				{x: 500, y: 150},
				{x: 320, y: 205},
				{x: 460, y: 205}
			];
			return targets[Math.floor(Math.random() * targets.length)];
		}

		function resetBall() {
			state.ball = {
				x: 390,
				y: 430,
				r: 18,
				startX: 390,
				startY: 430,
				targetX: 390,
				targetY: 180,
				t: 0,
				duration: 1.0
			};
		}

		function resetKeeper() {
			state.keeper = {
				x: 390,
				y: 180,
				w: 90,
				h: 46,
				armSpan: 130,
				targetX: 390,
				targetY: 180,
				t: 0,
				duration: 0.9
			};
		}

		function resetGame() {
			state.running = false;
			state.gameOver = false;
			state.score = 0;
			state.shotsLeft = 10;
			state.level = 1;
			state.animating = false;
			state.currentAim = 'top-left';
			state.resultText = '';
			state.savedFlash = 0;
			state.power = 70;

			try {
				const savedBest = parseInt(localStorage.getItem('zo_penalti_krali_best') || '0', 10);
				if (!isNaN(savedBest)) {
					state.best = savedBest;
				}
			} catch (e) {
				state.best = 0;
			}

			resetBall();
			resetKeeper();
			updateStats();
			setMessage('Başlat ve kaleye şut çek.');
			draw();
		}

		function startGame() {
			state.running = true;
			state.gameOver = false;
			state.animating = false;
			state.resultText = '';
			resetBall();
			resetKeeper();
			updateStats();
			setMessage('Bir yön seç ve şut çek.');
			draw();
		}

		function saveBestIfNeeded() {
			if (state.score > state.best) {
				state.best = state.score;
				try {
					localStorage.setItem('zo_penalti_krali_best', String(state.best));
				} catch (e) {}
			}
		}

		function endGame() {
			state.running = false;
			state.gameOver = true;
			saveBestIfNeeded();
			updateStats();
			setMessage('Oyun bitti. Tekrar başlat.');
			draw();
		}

		function getKeeperDifficultyOffset() {
			return Math.min(36, 8 + (state.level - 1) * 4);
		}

		function keeperSaves(ballX, ballY, keeperX, keeperY) {
			const dx = Math.abs(ballX - keeperX);
			const dy = Math.abs(ballY - keeperY);
			return dx <= (50 + getKeeperDifficultyOffset()) && dy <= 42;
		}

		function shootTo(aimKey) {
			if (!state.running || state.gameOver || state.animating) {
				return;
			}

			const target = aimMap[aimKey];
			if (!target) {
				return;
			}

			state.currentAim = aimKey;
			state.animating = true;
			state.resultText = '';

			resetBall();
			resetKeeper();

			state.ball.targetX = target.x;
			state.ball.targetY = target.y + (100 - state.power) * 0.8;
			state.ball.duration = 0.65 + ((100 - state.power) / 130);

			const keeperTarget = randomKeeperTarget();
			state.keeper.targetX = keeperTarget.x;
			state.keeper.targetY = keeperTarget.y;
			state.keeper.duration = 0.55 + Math.max(0, (6 - state.level)) * 0.04;

			setMessage('Şut çekildi...');
		}

		function lerp(a, b, t) {
			return a + (b - a) * t;
		}

		function updateAnimation() {
			if (!state.animating) {
				return;
			}

			state.ball.t += 0.03;
			state.keeper.t += 0.03 + (state.level * 0.002);

			const bt = clamp(state.ball.t / state.ball.duration, 0, 1);
			const kt = clamp(state.keeper.t / state.keeper.duration, 0, 1);

			state.ball.x = lerp(state.ball.startX, state.ball.targetX, bt);
			state.ball.y = lerp(state.ball.startY, state.ball.targetY, bt);

			state.keeper.x = lerp(390, state.keeper.targetX, kt);
			state.keeper.y = lerp(180, state.keeper.targetY, kt);

			if (bt >= 1) {
				state.animating = false;
				state.shotsLeft -= 1;

				if (keeperSaves(state.ball.x, state.ball.y, state.keeper.x, state.keeper.y)) {
					state.resultText = 'Kurtardı';
					state.savedFlash = 20;
					setMessage('Kaleci kurtardı.');
				} else {
					state.resultText = 'GOL';
					state.score += 1;
					if (state.score > 0 && state.score % 3 === 0) {
						state.level += 1;
					}
					setMessage('Gooool.');
				}

				saveBestIfNeeded();
				updateStats();

				if (state.shotsLeft <= 0) {
					endGame();
				} else {
					setTimeout(function () {
						if (!state.gameOver) {
							resetBall();
							resetKeeper();
							draw();
						}
					}, 350);
				}
			}
		}

		function drawSkyAndField() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = '#93c5fd';
			ctx.fillRect(0, 0, WIDTH, 210);

			ctx.fillStyle = '#4ade80';
			ctx.fillRect(0, 210, WIDTH, HEIGHT - 210);

			ctx.strokeStyle = 'rgba(255,255,255,0.85)';
			ctx.lineWidth = 4;
			ctx.beginPath();
			ctx.moveTo(150, 430);
			ctx.lineTo(630, 430);
			ctx.stroke();

			ctx.beginPath();
			ctx.arc(390, 430, 80, Math.PI, 0);
			ctx.stroke();
		}

		function drawGoal() {
			ctx.save();

			ctx.strokeStyle = '#ffffff';
			ctx.lineWidth = 6;
			ctx.strokeRect(230, 80, 320, 160);

			ctx.lineWidth = 2;
			for (let x = 230; x <= 550; x += 20) {
				ctx.beginPath();
				ctx.moveTo(x, 80);
				ctx.lineTo(x, 240);
				ctx.stroke();
			}
			for (let y = 80; y <= 240; y += 20) {
				ctx.beginPath();
				ctx.moveTo(230, y);
				ctx.lineTo(550, y);
				ctx.stroke();
			}

			ctx.restore();
		}

		function drawKeeper() {
			const k = state.keeper;

			ctx.save();

			ctx.strokeStyle = '#111827';
			ctx.lineWidth = 8;
			ctx.lineCap = 'round';

			ctx.beginPath();
			ctx.moveTo(k.x - 45, k.y);
			ctx.lineTo(k.x + 45, k.y);
			ctx.stroke();

			ctx.beginPath();
			ctx.moveTo(k.x, k.y - 26);
			ctx.lineTo(k.x, k.y + 30);
			ctx.stroke();

			ctx.beginPath();
			ctx.moveTo(k.x, k.y + 30);
			ctx.lineTo(k.x - 20, k.y + 58);
			ctx.moveTo(k.x, k.y + 30);
			ctx.lineTo(k.x + 20, k.y + 58);
			ctx.stroke();

			ctx.fillStyle = '#fbbf24';
			ctx.beginPath();
			ctx.arc(k.x, k.y - 40, 14, 0, Math.PI * 2);
			ctx.fill();

			ctx.restore();
		}

		function drawBall() {
			const b = state.ball;

			ctx.save();
			ctx.fillStyle = '#ffffff';
			ctx.beginPath();
			ctx.arc(b.x, b.y, b.r, 0, Math.PI * 2);
			ctx.fill();

			ctx.strokeStyle = '#111827';
			ctx.lineWidth = 2;
			ctx.stroke();

			ctx.beginPath();
			ctx.moveTo(b.x - 6, b.y);
			ctx.lineTo(b.x + 6, b.y);
			ctx.moveTo(b.x, b.y - 6);
			ctx.lineTo(b.x, b.y + 6);
			ctx.stroke();

			ctx.restore();
		}

		function drawAimHint() {
			if (!state.running || state.animating) {
				return;
			}

			const target = aimMap[state.currentAim];
			if (!target) {
				return;
			}

			ctx.save();
			ctx.strokeStyle = 'rgba(37,99,235,0.5)';
			ctx.lineWidth = 3;
			ctx.setLineDash([8, 8]);
			ctx.beginPath();
			ctx.moveTo(state.ball.x, state.ball.y);
			ctx.lineTo(target.x, target.y);
			ctx.stroke();
			ctx.setLineDash([]);

			ctx.fillStyle = 'rgba(37,99,235,0.20)';
			ctx.beginPath();
			ctx.arc(target.x, target.y, 18, 0, Math.PI * 2);
			ctx.fill();

			ctx.restore();
		}

		function drawResultText() {
			if (!state.resultText) {
				return;
			}

			ctx.save();
			ctx.textAlign = 'center';
			ctx.font = 'bold 42px Arial';
			ctx.fillStyle = state.resultText === 'GOL' ? '#16a34a' : '#dc2626';
			ctx.fillText(state.resultText, WIDTH / 2, 60);
			ctx.restore();
		}

		function drawCrowd() {
			for (let i = 0; i < WIDTH; i += 22) {
				ctx.fillStyle = i % 44 === 0 ? '#2563eb' : '#ef4444';
				ctx.fillRect(i, 0, 18, 24);
			}
		}

		function draw() {
			drawSkyAndField();
			drawCrowd();
			drawGoal();
			drawKeeper();
			drawAimHint();
			drawBall();
			drawResultText();

			if (!state.running && !state.gameOver) {
				ctx.save();
				ctx.fillStyle = 'rgba(15,23,42,0.10)';
				ctx.fillRect(0, 0, WIDTH, HEIGHT);
				ctx.fillStyle = '#0f172a';
				ctx.textAlign = 'center';
				ctx.font = 'bold 38px Arial';
				ctx.fillText('Penaltı Kralı', WIDTH / 2, HEIGHT / 2 - 10);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Başlat ve şut çek', WIDTH / 2, HEIGHT / 2 + 24);
				ctx.restore();
			}

			if (state.gameOver) {
				ctx.save();
				ctx.fillStyle = 'rgba(15,23,42,0.14)';
				ctx.fillRect(0, 0, WIDTH, HEIGHT);
				ctx.fillStyle = '#0f172a';
				ctx.textAlign = 'center';
				ctx.font = 'bold 40px Arial';
				ctx.fillText('Oyun Bitti', WIDTH / 2, HEIGHT / 2 - 16);
				ctx.font = 'bold 22px Arial';
				ctx.fillText('Skor: ' + state.score, WIDTH / 2, HEIGHT / 2 + 18);
				ctx.restore();
			}
		}

		function tick() {
			if (state.running && !state.gameOver) {
				updateAnimation();
			}
			draw();
			requestAnimationFrame(tick);
		}

		startButton.addEventListener('click', function () {
			startGame();
		});

		restartButton.addEventListener('click', function () {
			resetGame();
		});

		shotButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				const aim = btn.getAttribute('data-aim');
				shootTo(aim);
			});
		});

		window.addEventListener('keydown', function (e) {
			if (!state.running || state.gameOver) {
				return;
			}

			if (e.code === 'Digit1') shootTo('top-left');
			if (e.code === 'Digit2') shootTo('top-center');
			if (e.code === 'Digit3') shootTo('top-right');
			if (e.code === 'Digit4') shootTo('mid-left');
			if (e.code === 'Digit5') shootTo('mid-center');
			if (e.code === 'Digit6') shootTo('mid-right');
			if (e.code === 'Digit7') shootTo('low-left');
			if (e.code === 'Digit8') shootTo('low-center');
			if (e.code === 'Digit9') shootTo('low-right');
		});

		canvas.addEventListener('click', function (event) {
			if (!state.running || state.gameOver || state.animating) {
				return;
			}

			const rect = canvas.getBoundingClientRect();
			const x = (event.clientX - rect.left) * (canvas.width / rect.width);
			const y = (event.clientY - rect.top) * (canvas.height / rect.height);

			let closestKey = null;
			let closestDist = Infinity;

			Object.keys(aimMap).forEach(function (key) {
				const target = aimMap[key];
				const dx = x - target.x;
				const dy = y - target.y;
				const dist = Math.sqrt(dx * dx + dy * dy);

				if (dist < closestDist) {
					closestDist = dist;
					closestKey = key;
				}
			});

			if (closestKey) {
				shootTo(closestKey);
			}
		});

		let powerDirection = 1;
		setInterval(function () {
			if (!state.running || state.gameOver || state.animating) {
				return;
			}

			state.power += powerDirection * 3;
			if (state.power >= 100) {
				state.power = 100;
				powerDirection = -1;
			}
			if (state.power <= 25) {
				state.power = 25;
				powerDirection = 1;
			}

			updateStats();
		}, 80);

		resetGame();
		tick();
	});
});
JS;

if (!function_exists('zo_penalti_krali_render')) {
	function zo_penalti_krali_render($post_id = 0, $game = array()) {
		$game_id = 'zo-penalti-krali-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--penalti-krali" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-pk-wrap">
				<h2 class="zo-pk-title">Penaltı Kralı</h2>
				<p class="zo-pk-subtitle">Kaleye şut çek, gol at, skor yap. Basit ve eğlenceli futbol oyunu.</p>

				<div class="zo-pk-topbar">
					<div class="zo-pk-stats">
						<div class="zo-pk-stat">Skor: <span class="zo-pk-score">0</span></div>
						<div class="zo-pk-stat">Şut: <span class="zo-pk-shots">10</span></div>
						<div class="zo-pk-stat">Seviye: <span class="zo-pk-level">1</span></div>
						<div class="zo-pk-stat">En İyi: <span class="zo-pk-best">0</span></div>
					</div>

					<div class="zo-pk-controls">
						<button type="button" class="zo-pk-btn zo-pk-btn--primary zo-pk-start">Başlat</button>
						<button type="button" class="zo-pk-btn zo-pk-btn--danger zo-pk-restart">Sıfırla</button>
					</div>
				</div>

				<div class="zo-pk-layout">
					<div class="zo-pk-board-wrap">
						<canvas class="zo-pk-canvas" width="780" height="520" aria-label="Penaltı oyunu alanı"></canvas>
						<div class="zo-pk-message">Başlat ve kaleye şut çek.</div>

						<div class="zo-pk-power-wrap">
							<div class="zo-pk-power-label">Şut Gücü</div>
							<div class="zo-pk-power-bar">
								<div class="zo-pk-power-fill"></div>
							</div>
						</div>
					</div>

					<div class="zo-pk-side">
						<h3>Şut Yönü</h3>

						<div class="zo-pk-shot-grid">
							<button type="button" class="zo-pk-shot-btn" data-aim="top-left">1</button>
							<button type="button" class="zo-pk-shot-btn" data-aim="top-center">2</button>
							<button type="button" class="zo-pk-shot-btn" data-aim="top-right">3</button>
							<button type="button" class="zo-pk-shot-btn" data-aim="mid-left">4</button>
							<button type="button" class="zo-pk-shot-btn" data-aim="mid-center">5</button>
							<button type="button" class="zo-pk-shot-btn" data-aim="mid-right">6</button>
							<button type="button" class="zo-pk-shot-btn" data-aim="low-left">7</button>
							<button type="button" class="zo-pk-shot-btn" data-aim="low-center">8</button>
							<button type="button" class="zo-pk-shot-btn" data-aim="low-right">9</button>
						</div>

						<h3>Nasıl Oynanır</h3>
						<ul>
							<li>Başlat düğmesine bas.</li>
							<li>1-9 tuşlarıyla veya kaleye tıklayarak yön seç.</li>
							<li>Kaleciyi geçersen gol olur.</li>
							<li>Her 3 golde seviye artar.</li>
							<li>10 şut sonunda oyun biter.</li>
						</ul>

						<p>Futbol teması olduğu için çocukların çoğu bunu sever.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'penalti-krali',
	'name'            => 'Penaltı Kralı',
	'author'          => 'Arslan',
	'description'     => 'Çocuklar için basit ve eğlenceli penaltı futbol oyunu.',
	'render_callback' => 'zo_penalti_krali_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);