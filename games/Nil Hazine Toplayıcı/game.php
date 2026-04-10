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

.zo-nile-wrap {
	background: #eef8ff;
	border: 2px solid #7bb7d9;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-nile-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-nile-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-nile-topbar {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-nile-pill {
	background: #ffffff;
	border: 1px solid #7bb7d9;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 14px;
	font-weight: bold;
}

.zo-nile-scene {
	position: relative;
	height: 280px;
	border-radius: 16px;
	overflow: hidden;
	border: 2px solid #7bb7d9;
	background: linear-gradient(to bottom, #b8e5ff 0%, #dff4ff 48%, #6cc2ea 48%, #3a9dca 100%);
	margin-bottom: 16px;
}

.zo-nile-sun {
	position: absolute;
	top: 18px;
	right: 22px;
	width: 44px;
	height: 44px;
	border-radius: 50%;
	background: #ffd34d;
}

.zo-nile-pyramid {
	position: absolute;
	bottom: 125px;
	width: 0;
	height: 0;
	border-left: 52px solid transparent;
	border-right: 52px solid transparent;
	border-bottom: 86px solid #caa15a;
	opacity: 0.95;
}

.zo-nile-pyramid--1 {
	left: 36px;
}

.zo-nile-pyramid--2 {
	left: 118px;
	bottom: 130px;
	border-left-width: 40px;
	border-right-width: 40px;
	border-bottom-width: 66px;
}

.zo-nile-boat {
	position: absolute;
	left: 30px;
	bottom: 42px;
	width: 88px;
	height: 34px;
}

.zo-nile-boat-body {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 0;
	height: 18px;
	background: #7c4d22;
	border-radius: 0 0 18px 18px;
}

.zo-nile-boat-top {
	position: absolute;
	left: 10px;
	right: 10px;
	bottom: 14px;
	height: 8px;
	background: #9a6731;
	border-radius: 8px;
}

.zo-nile-cargo {
	position: absolute;
	left: 50%;
	bottom: 16px;
	transform: translateX(-50%);
	font-size: 22px;
	line-height: 1;
}

.zo-nile-item {
	position: absolute;
	top: -50px;
	font-size: 28px;
	line-height: 1;
	user-select: none;
}

.zo-nile-controls {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-nile-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #2f8fbd;
	color: #fff;
	min-width: 120px;
}

.zo-nile-btn:hover,
.zo-nile-btn:focus {
	opacity: 0.92;
}

.zo-nile-btn:disabled {
	opacity: 0.6;
	cursor: default;
}

.zo-nile-status {
	min-height: 24px;
	font-size: 15px;
	font-weight: bold;
	margin-top: 8px;
}

.zo-nile-help {
	margin-top: 10px;
	font-size: 14px;
	line-height: 1.5;
}

@media (max-width: 560px) {
	.zo-nile-title {
		font-size: 24px;
	}

	.zo-nile-scene {
		height: 250px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--nil-hazine-toplayici');

	games.forEach(function (game) {
		const scene = game.querySelector('.zo-nile-scene');
		const boat = game.querySelector('.zo-nile-boat');
		const scoreEl = game.querySelector('.zo-nile-score');
		const livesEl = game.querySelector('.zo-nile-lives');
		const bestEl = game.querySelector('.zo-nile-best');
		const statusEl = game.querySelector('.zo-nile-status');
		const startBtn = game.querySelector('.zo-nile-start');
		const restartBtn = game.querySelector('.zo-nile-restart');

		let running = false;
		let score = 0;
		let lives = 3;
		let best = 0;
		let boatX = 30;
		let keys = { left: false, right: false };
		let items = [];
		let animationId = null;
		let spawnTimer = 0;
		let difficulty = 1;

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function updateStats() {
			scoreEl.textContent = 'Skor: ' + score;
			livesEl.textContent = 'Can: ' + lives;
			bestEl.textContent = 'En iyi: ' + best;
		}

		function clearItems() {
			items.forEach(function (item) {
				if (item.el && item.el.parentNode) {
					item.el.parentNode.removeChild(item.el);
				}
			});
			items = [];
		}

		function stopLoop() {
			if (animationId) {
				cancelAnimationFrame(animationId);
				animationId = null;
			}
		}

		function resetGame() {
			running = false;
			score = 0;
			lives = 3;
			boatX = 30;
			spawnTimer = 0;
			difficulty = 1;
			clearItems();
			boat.style.left = boatX + 'px';
			statusEl.textContent = 'Hazır. Nil üzerinde hazineleri topla.';
			startBtn.disabled = false;
			updateStats();
			stopLoop();
		}

		function startGame() {
			if (running) {
				return;
			}
			running = true;
			score = 0;
			lives = 3;
			boatX = 30;
			spawnTimer = 0;
			difficulty = 1;
			clearItems();
			boat.style.left = boatX + 'px';
			statusEl.textContent = 'Altınları yakala. Timsahlardan kaç.';
			startBtn.disabled = true;
			updateStats();
			loop();
		}

		function spawnItem() {
			const good = Math.random() > 0.28;
			const el = document.createElement('div');
			el.className = 'zo-nile-item';
			el.textContent = good ? (Math.random() > 0.5 ? '🪙' : '💎') : '🐊';

			const sceneWidth = scene.clientWidth;
			const x = Math.floor(Math.random() * Math.max(1, sceneWidth - 40)) + 6;

			el.style.left = x + 'px';
			el.style.top = '-40px';
			scene.appendChild(el);

			items.push({
				el: el,
				x: x,
				y: -40,
				speed: good ? (2.3 + difficulty * 0.22) : (2.8 + difficulty * 0.28),
				type: good ? 'good' : 'bad'
			});
		}

		function updateBoat() {
			const maxX = scene.clientWidth - boat.offsetWidth - 8;

			if (keys.left) {
				boatX -= 6;
			}
			if (keys.right) {
				boatX += 6;
			}

			boatX = clamp(boatX, 8, maxX);
			boat.style.left = boatX + 'px';
		}

		function gameOver() {
			running = false;
			startBtn.disabled = false;
			if (score > best) {
				best = score;
			}
			updateStats();
			statusEl.textContent = 'Oyun bitti. Tekrar başla.';
			stopLoop();
		}

		function updateItems() {
			const boatRect = {
				left: boatX,
				right: boatX + boat.offsetWidth,
				top: scene.clientHeight - 76,
				bottom: scene.clientHeight - 18
			};

			for (let i = items.length - 1; i >= 0; i--) {
				const item = items[i];
				item.y += item.speed;
				item.el.style.top = item.y + 'px';

				const itemRect = {
					left: item.x,
					right: item.x + 28,
					top: item.y,
					bottom: item.y + 28
				};

				const hit = itemRect.right > boatRect.left &&
					itemRect.left < boatRect.right &&
					itemRect.bottom > boatRect.top &&
					itemRect.top < boatRect.bottom;

				if (hit) {
					if (item.type === 'good') {
						score += 1;
						statusEl.textContent = 'Hazine yakaladın.';
						if (score % 6 === 0) {
							difficulty += 1;
						}
					} else {
						lives -= 1;
						statusEl.textContent = 'Timsaha çarptın.';
						if (lives <= 0) {
							item.el.parentNode.removeChild(item.el);
							items.splice(i, 1);
							updateStats();
							gameOver();
							return;
						}
					}

					if (item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					items.splice(i, 1);
					updateStats();
					continue;
				}

				if (item.y > scene.clientHeight + 10) {
					if (item.type === 'good') {
						statusEl.textContent = 'Bir hazineyi kaçırdın.';
					}
					if (item.el.parentNode) {
						item.el.parentNode.removeChild(item.el);
					}
					items.splice(i, 1);
				}
			}
		}

		function loop() {
			if (!running) {
				return;
			}

			updateBoat();
			updateItems();

			spawnTimer += 1;
			const spawnRate = Math.max(34, 72 - difficulty * 3);

			if (spawnTimer >= spawnRate) {
				spawnItem();
				spawnTimer = 0;
			}

			animationId = requestAnimationFrame(loop);
		}

		startBtn.addEventListener('click', startGame);
		restartBtn.addEventListener('click', resetGame);

		game.addEventListener('keydown', function (event) {
			if (event.code === 'ArrowLeft') {
				event.preventDefault();
				keys.left = true;
			}
			if (event.code === 'ArrowRight') {
				event.preventDefault();
				keys.right = true;
			}
		});

		game.addEventListener('keyup', function (event) {
			if (event.code === 'ArrowLeft') {
				event.preventDefault();
				keys.left = false;
			}
			if (event.code === 'ArrowRight') {
				event.preventDefault();
				keys.right = false;
			}
		});

		scene.addEventListener('touchstart', function (event) {
			const touch = event.changedTouches[0];
			const rect = scene.getBoundingClientRect();
			const x = touch.clientX - rect.left;

			if (x < rect.width / 2) {
				boatX -= 38;
			} else {
				boatX += 38;
			}
		}, { passive: true });

		game.setAttribute('tabindex', '0');
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_nil_hazine_toplayici_render')) {
	function zo_game_nil_hazine_toplayici_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-nil-hazine-toplayici-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--nil-hazine-toplayici" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-nile-wrap">
				<h3 class="zo-nile-title">Nil Hazine Toplayıcı</h3>
				<p class="zo-nile-text">Kayığını sağa sola götür. Nil nehrine düşen altın ve değerli taşları topla. Timsahlardan kaç.</p>

				<div class="zo-nile-topbar">
					<div class="zo-nile-pill zo-nile-score">Skor: 0</div>
					<div class="zo-nile-pill zo-nile-lives">Can: 3</div>
					<div class="zo-nile-pill zo-nile-best">En iyi: 0</div>
				</div>

				<div class="zo-nile-scene" aria-label="Oyun alanı">
					<div class="zo-nile-sun"></div>
					<div class="zo-nile-pyramid zo-nile-pyramid--1"></div>
					<div class="zo-nile-pyramid zo-nile-pyramid--2"></div>

					<div class="zo-nile-boat" aria-hidden="true">
						<div class="zo-nile-boat-body"></div>
						<div class="zo-nile-boat-top"></div>
						<div class="zo-nile-cargo">⛵</div>
					</div>
				</div>

				<div class="zo-nile-controls">
					<button type="button" class="zo-nile-btn zo-nile-start">Başla</button>
					<button type="button" class="zo-nile-btn zo-nile-restart">Sıfırla</button>
				</div>

				<div class="zo-nile-status">Hazır. Nil üzerinde hazineleri topla.</div>
				<div class="zo-nile-help">Bilgisayarda sol ve sağ ok tuşlarıyla oynanır. Telefonda oyun alanının soluna veya sağına dokun.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'nil-hazine-toplayici',
	'name'            => 'Nil Hazine Toplayıcı',
	'author'          => 'Arslan',
	'description'     => 'Mısır temalı hazine yakalama oyunu.',
	'render_callback' => 'zo_game_nil_hazine_toplayici_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);