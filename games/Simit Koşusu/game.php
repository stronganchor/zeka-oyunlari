<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 820px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--simit-run .sr-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	text-align: center;
}

.zo-game-root--simit-run .sr-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	color: #1f2933;
}

.zo-game-root--simit-run .sr-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	color: #52606d;
}

.zo-game-root--simit-run .sr-topbar {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--simit-run .sr-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
}

.zo-game-root--simit-run .sr-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--simit-run .sr-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--simit-run .sr-status {
	min-height: 28px;
	margin-bottom: 14px;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--simit-run .sr-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--simit-run .sr-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--simit-run .sr-field {
	position: relative;
	height: 420px;
	border-radius: 18px;
	border: 3px solid #bcccdc;
	overflow: hidden;
	background: linear-gradient(to bottom, #bfe6ff 0%, #d9f1ff 48%, #b9e38a 48%, #84c35f 100%);
	margin-bottom: 16px;
	user-select: none;
	touch-action: manipulation;
}

.zo-game-root--simit-run .sr-sun {
	position: absolute;
	right: 18px;
	top: 16px;
	width: 52px;
	height: 52px;
	border-radius: 50%;
	background: #ffd54f;
	box-shadow: 0 0 0 8px rgba(255, 213, 79, 0.2);
}

.zo-game-root--simit-run .sr-cloud {
	position: absolute;
	background: rgba(255, 255, 255, 0.82);
	border-radius: 999px;
}

.zo-game-root--simit-run .sr-cloud--1 {
	width: 90px;
	height: 28px;
	left: 70px;
	top: 52px;
}

.zo-game-root--simit-run .sr-cloud--2 {
	width: 120px;
	height: 34px;
	left: 220px;
	top: 82px;
}

.zo-game-root--simit-run .sr-cloud::before,
.zo-game-root--simit-run .sr-cloud::after {
	content: '';
	position: absolute;
	background: rgba(255, 255, 255, 0.9);
	border-radius: 50%;
}

.zo-game-root--simit-run .sr-cloud::before {
	width: 34px;
	height: 34px;
	left: 14px;
	top: -12px;
}

.zo-game-root--simit-run .sr-cloud::after {
	width: 42px;
	height: 42px;
	right: 14px;
	top: -18px;
}

.zo-game-root--simit-run .sr-ground-line {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 82px;
	height: 6px;
	background: #5c8f40;
}

.zo-game-root--simit-run .sr-runner {
	position: absolute;
	left: 78px;
	bottom: 88px;
	width: 70px;
	height: 90px;
}

.zo-game-root--simit-run .sr-runner-body {
	position: absolute;
	left: 18px;
	top: 18px;
	width: 34px;
	height: 44px;
	background: #ef4444;
	border-radius: 14px;
}

.zo-game-root--simit-run .sr-runner-head {
	position: absolute;
	left: 20px;
	top: 0;
	width: 30px;
	height: 30px;
	background: #f3c9a3;
	border-radius: 50%;
	border: 2px solid #c08a63;
}

.zo-game-root--simit-run .sr-runner-leg,
.zo-game-root--simit-run .sr-runner-arm {
	position: absolute;
	background: #102a43;
	border-radius: 999px;
	transform-origin: top center;
}

.zo-game-root--simit-run .sr-runner-leg--1 {
	left: 24px;
	top: 56px;
	width: 8px;
	height: 28px;
	transform: rotate(18deg);
}

.zo-game-root--simit-run .sr-runner-leg--2 {
	left: 40px;
	top: 56px;
	width: 8px;
	height: 28px;
	transform: rotate(-18deg);
}

.zo-game-root--simit-run .sr-runner-arm--1 {
	left: 12px;
	top: 24px;
	width: 8px;
	height: 24px;
	transform: rotate(26deg);
}

.zo-game-root--simit-run .sr-runner-arm--2 {
	left: 50px;
	top: 24px;
	width: 8px;
	height: 24px;
	transform: rotate(-26deg);
}

.zo-game-root--simit-run .sr-runner.is-jumping {
	transform: translateY(-96px);
}

.zo-game-root--simit-run .sr-runner.is-jumping .sr-runner-leg--1 {
	transform: rotate(-26deg);
}

.zo-game-root--simit-run .sr-runner.is-jumping .sr-runner-leg--2 {
	transform: rotate(26deg);
}

.zo-game-root--simit-run .sr-runner.is-jumping .sr-runner-arm--1 {
	transform: rotate(-30deg);
}

.zo-game-root--simit-run .sr-runner.is-jumping .sr-runner-arm--2 {
	transform: rotate(30deg);
}

.zo-game-root--simit-run .sr-item {
	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;
	font-weight: 700;
	pointer-events: none;
}

.zo-game-root--simit-run .sr-item--simit {
	width: 38px;
	height: 38px;
	border-radius: 50%;
	background: #b66a2c;
	border: 7px solid #f0c676;
	box-shadow: inset 0 0 0 2px rgba(120, 70, 30, 0.18);
}

.zo-game-root--simit-run .sr-item--simit::after {
	content: '';
	position: absolute;
	inset: 3px;
	border-radius: 50%;
	border: 2px dotted rgba(255, 255, 255, 0.45);
}

.zo-game-root--simit-run .sr-item--bad {
	width: 32px;
	height: 32px;
	background: #7b8794;
	border-radius: 7px;
	border: 3px solid #52606d;
	color: #ffffff;
	font-size: 18px;
}

.zo-game-root--simit-run .sr-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 12px;
}

.zo-game-root--simit-run .sr-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--simit-run .sr-btn:hover,
.zo-game-root--simit-run .sr-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--simit-run .sr-btn--jump {
	background: #2563eb;
	color: #ffffff;
}

.zo-game-root--simit-run .sr-btn--restart {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--simit-run .sr-progress {
	font-size: 14px;
	color: #52606d;
}

@media (max-width: 640px) {
	.zo-game-root--simit-run .sr-topbar {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--simit-run .sr-title {
		font-size: 24px;
	}

	.zo-game-root--simit-run .sr-field {
		height: 360px;
	}

	.zo-game-root--simit-run .sr-runner {
		left: 40px;
		transform: scale(0.92);
		transform-origin: bottom left;
	}

	.zo-game-root--simit-run .sr-runner.is-jumping {
		transform: translateY(-82px) scale(0.92);
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--simit-run');

	games.forEach(function (game) {
		const field = game.querySelector('.sr-field');
		const runner = game.querySelector('.sr-runner');
		const scoreEl = game.querySelector('.sr-score');
		const livesEl = game.querySelector('.sr-lives');
		const levelEl = game.querySelector('.sr-level');
		const bestEl = game.querySelector('.sr-best');
		const statusEl = game.querySelector('.sr-status');
		const progressEl = game.querySelector('.sr-progress');
		const jumpBtn = game.querySelector('.sr-btn--jump');
		const restartBtn = game.querySelector('.sr-btn--restart');

		let items = [];
		let score = 0;
		let lives = 3;
		let level = 1;
		let best = 0;
		let spawnTick = 0;
		let gameSpeed = 5;
		let isJumping = false;
		let jumpTimer = 0;
		let loopId = null;
		let ended = false;

		function setStatus(message, type) {
			statusEl.textContent = message;
			statusEl.classList.remove('is-good', 'is-bad');

			if (type === 'good') {
				statusEl.classList.add('is-good');
			} else if (type === 'bad') {
				statusEl.classList.add('is-bad');
			}
		}

		function updateStats() {
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			levelEl.textContent = String(level);
			bestEl.textContent = String(best);
			progressEl.textContent = 'Collect simit. Jump over crates.';
		}

		function clearItems() {
			items.forEach(function (item) {
				if (item.el && item.el.parentNode) {
					item.el.parentNode.removeChild(item.el);
				}
			});
			items = [];
		}

		function jump() {
			if (ended || isJumping) {
				return;
			}

			isJumping = true;
			jumpTimer = 28;
			runner.classList.add('is-jumping');
		}

		function createItem(type) {
			const el = document.createElement('div');
			el.className = 'sr-item sr-item--' + type;

			if (type === 'bad') {
				el.textContent = 'X';
			}

			field.appendChild(el);

			const item = {
				type: type,
				x: field.clientWidth + 20,
				y: type === 'simit' ? 250 : 304,
				width: type === 'simit' ? 38 : 32,
				height: type === 'simit' ? 38 : 32,
				el: el,
				hit: false
			};

			items.push(item);
		}

		function maybeSpawnItem() {
			spawnTick += 1;

			const spawnGap = Math.max(38, 78 - (level * 4));

			if (spawnTick < spawnGap) {
				return;
			}

			spawnTick = 0;

			const roll = Math.random();

			if (roll < 0.62) {
				createItem('simit');
			} else {
				createItem('bad');
			}
		}

		function runnerBox() {
			return {
				left: 88,
				right: 132,
				top: isJumping ? 140 : 236,
				bottom: isJumping ? 208 : 324
			};
		}

		function intersects(a, b) {
			return !(
				a.right < b.left ||
				a.left > b.right ||
				a.bottom < b.top ||
				a.top > b.bottom
			);
		}

		function endGame() {
			ended = true;
			if (loopId) {
				window.clearInterval(loopId);
				loopId = null;
			}
			setStatus('Oyun bitti. Restart ile tekrar başla.', 'bad');
		}

		function increaseDifficulty() {
			level = 1 + Math.floor(score / 8);
			gameSpeed = 5 + Math.min(6, Math.floor(score / 6));
		}

		function updateItems() {
			const player = runnerBox();

			for (let i = items.length - 1; i >= 0; i--) {
				const item = items[i];
				item.x -= gameSpeed;
				item.el.style.left = item.x + 'px';
				item.el.style.top = item.y + 'px';

				const box = {
					left: item.x,
					right: item.x + item.width,
					top: item.y,
					bottom: item.y + item.height
				};

				if (!item.hit && intersects(player, box)) {
					item.hit = true;

					if (item.type === 'simit') {
						score += 1;
						best = Math.max(best, score);
						increaseDifficulty();
						setStatus('Simit yakaladın.', 'good');
					} else {
						lives -= 1;
						setStatus('Kasaya çarptın.', 'bad');
						if (lives <= 0) {
							updateStats();
							item.el.parentNode.removeChild(item.el);
							items.splice(i, 1);
							endGame();
							return;
						}
					}

					item.el.parentNode.removeChild(item.el);
					items.splice(i, 1);
					updateStats();
					continue;
				}

				if (item.x < -60) {
					if (item.type === 'simit' && !item.hit) {
						setStatus('Simit kaçtı.', '');
					}
					if (item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					items.splice(i, 1);
				}
			}
		}

		function updateJump() {
			if (!isJumping) {
				return;
			}

			jumpTimer -= 1;

			if (jumpTimer <= 0) {
				isJumping = false;
				runner.classList.remove('is-jumping');
			}
		}

		function gameLoop() {
			if (ended) {
				return;
			}

			maybeSpawnItem();
			updateJump();
			updateItems();
		}

		function restartGame() {
			if (loopId) {
				window.clearInterval(loopId);
				loopId = null;
			}

			clearItems();
			score = 0;
			lives = 3;
			level = 1;
			best = 0;
			spawnTick = 0;
			gameSpeed = 5;
			isJumping = false;
			jumpTimer = 0;
			ended = false;
			runner.classList.remove('is-jumping');
			updateStats();
			setStatus('Başla. Simitleri topla ve kasalardan zıpla.', '');
			loopId = window.setInterval(gameLoop, 30);
		}

		jumpBtn.addEventListener('click', jump);
		restartBtn.addEventListener('click', restartGame);

		field.addEventListener('click', jump);

		game.addEventListener('keydown', function (event) {
			if (event.key === ' ' || event.key === 'ArrowUp') {
				event.preventDefault();
				jump();
			}
		});

		game.setAttribute('tabindex', '0');

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_simit_run_render')) {
	function zo_game_simit_run_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-simit-run-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--simit-run" id="<?php echo esc_attr($instance_id); ?>">
			<div class="sr-card">
				<h2 class="sr-title">Simit Koşusu</h2>
				<p class="sr-instructions">Simitleri topla. Kasalardan zıpla. Oyun alanına dokunarak, Jump düğmesiyle, boşluk tuşuyla ya da yukarı okla zıpla.</p>

				<div class="sr-topbar">
					<div class="sr-stat">
						<span class="sr-stat-label">Score</span>
						<span class="sr-stat-value sr-score">0</span>
					</div>
					<div class="sr-stat">
						<span class="sr-stat-label">Lives</span>
						<span class="sr-stat-value sr-lives">3</span>
					</div>
					<div class="sr-stat">
						<span class="sr-stat-label">Level</span>
						<span class="sr-stat-value sr-level">1</span>
					</div>
					<div class="sr-stat">
						<span class="sr-stat-label">Best</span>
						<span class="sr-stat-value sr-best">0</span>
					</div>
				</div>

				<div class="sr-status" aria-live="polite">Başla. Simitleri topla ve kasalardan zıpla.</div>

				<div class="sr-field">
					<div class="sr-sun"></div>
					<div class="sr-cloud sr-cloud--1"></div>
					<div class="sr-cloud sr-cloud--2"></div>
					<div class="sr-ground-line"></div>

					<div class="sr-runner">
						<div class="sr-runner-head"></div>
						<div class="sr-runner-body"></div>
						<div class="sr-runner-arm sr-runner-arm--1"></div>
						<div class="sr-runner-arm sr-runner-arm--2"></div>
						<div class="sr-runner-leg sr-runner-leg--1"></div>
						<div class="sr-runner-leg sr-runner-leg--2"></div>
					</div>
				</div>

				<div class="sr-actions">
					<button type="button" class="sr-btn sr-btn--jump">Jump</button>
					<button type="button" class="sr-btn sr-btn--restart">Restart</button>
				</div>

				<div class="sr-progress">Collect simit. Jump over crates.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'simit-run',
	'name'            => 'Simit Koşusu',
	'author'          => 'Arslan',
	'description'     => 'Collect simit and jump over crates in a fast endless runner.',
	'render_callback' => 'zo_game_simit_run_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);