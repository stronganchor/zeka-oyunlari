<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 680px;
	margin: 0 auto;
	padding: 16px;
	text-align: center;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-speed-sort-wrap {
	background: #f6f8ff;
	border: 2px solid #8ea3ff;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-speed-sort-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-speed-sort-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-speed-sort-topbar {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-speed-sort-pill {
	background: #ffffff;
	border: 1px solid #8ea3ff;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 14px;
	font-weight: bold;
}

.zo-speed-sort-target {
	margin: 14px 0;
	padding: 16px;
	border: 2px dashed #8ea3ff;
	border-radius: 16px;
	background: #ffffff;
}

.zo-speed-sort-target-label {
	font-size: 15px;
	margin-bottom: 6px;
	font-weight: bold;
}

.zo-speed-sort-target-value {
	font-size: 40px;
	line-height: 1;
	font-weight: bold;
}

.zo-speed-sort-grid {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
	margin: 16px 0;
}

.zo-speed-sort-btn {
	appearance: none;
	border: 2px solid #6f86e8;
	border-radius: 14px;
	background: #ffffff;
	color: #1f2a5a;
	padding: 16px 12px;
	font-size: 22px;
	font-weight: bold;
	cursor: pointer;
	min-height: 74px;
	transition: transform 0.15s ease, background 0.15s ease, border-color 0.15s ease;
}

.zo-speed-sort-btn:hover,
.zo-speed-sort-btn:focus {
	transform: translateY(-2px);
}

.zo-speed-sort-btn.is-correct {
	background: #e8f8e4;
	border-color: #69b15d;
}

.zo-speed-sort-btn.is-wrong {
	background: #ffe8e8;
	border-color: #d97b7b;
}

.zo-speed-sort-controls {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-speed-sort-action {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #5b72d8;
	color: #fff;
	min-width: 120px;
}

.zo-speed-sort-action:hover,
.zo-speed-sort-action:focus {
	opacity: 0.92;
}

.zo-speed-sort-action:disabled {
	opacity: 0.6;
	cursor: default;
}

.zo-speed-sort-status {
	min-height: 24px;
	font-size: 15px;
	font-weight: bold;
	margin-top: 8px;
}

.zo-speed-sort-help {
	margin-top: 10px;
	font-size: 14px;
	line-height: 1.5;
}

@media (max-width: 520px) {
	.zo-speed-sort-title {
		font-size: 24px;
	}

	.zo-speed-sort-grid {
		grid-template-columns: 1fr;
	}

	.zo-speed-sort-target-value {
		font-size: 34px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--speed-sort');

	games.forEach(function (game) {
		const roundEl = game.querySelector('.zo-speed-sort-round');
		const scoreEl = game.querySelector('.zo-speed-sort-score');
		const bestEl = game.querySelector('.zo-speed-sort-best');
		const timeEl = game.querySelector('.zo-speed-sort-time');
		const targetValueEl = game.querySelector('.zo-speed-sort-target-value');
		const targetLabelEl = game.querySelector('.zo-speed-sort-target-label');
		const gridEl = game.querySelector('.zo-speed-sort-grid');
		const statusEl = game.querySelector('.zo-speed-sort-status');
		const startBtn = game.querySelector('.zo-speed-sort-start');
		const restartBtn = game.querySelector('.zo-speed-sort-restart');

		let score = 0;
		let best = 0;
		let round = 0;
		let timeLeft = 30;
		let timer = null;
		let playing = false;
		let correctValue = 0;
		let currentMode = 'smallest';

		function shuffle(array) {
			for (let i = array.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = array[i];
				array[i] = array[j];
				array[j] = temp;
			}
			return array;
		}

		function randomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		function updateStats() {
			roundEl.textContent = 'Tur: ' + round;
			scoreEl.textContent = 'Skor: ' + score;
			bestEl.textContent = 'En iyi: ' + best;
			timeEl.textContent = 'Süre: ' + timeLeft;
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function stopTimer() {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}
		}

		function endGame() {
			playing = false;
			stopTimer();
			gridEl.innerHTML = '';
			targetValueEl.textContent = '⏰';
			targetLabelEl.textContent = 'Süre bitti';
			if (score > best) {
				best = score;
			}
			updateStats();
			setStatus('Oyun bitti. Tekrar başla.');
			startBtn.disabled = false;
		}

		function buildRound() {
			if (!playing) {
				return;
			}

			round += 1;
			gridEl.innerHTML = '';

			const values = [];
			while (values.length < 4) {
				const num = randomInt(1, 99);
				if (values.indexOf(num) === -1) {
					values.push(num);
				}
			}

			currentMode = Math.random() > 0.5 ? 'smallest' : 'largest';
			correctValue = currentMode === 'smallest'
				? Math.min.apply(null, values)
				: Math.max.apply(null, values);

			targetValueEl.textContent = currentMode === 'smallest' ? '⬇️' : '⬆️';
			targetLabelEl.textContent = currentMode === 'smallest'
				? 'En küçük sayıyı seç'
				: 'En büyük sayıyı seç';

			const mixed = shuffle(values.slice());

			mixed.forEach(function (value) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'zo-speed-sort-btn';
				btn.textContent = value;

				btn.addEventListener('click', function () {
					if (!playing) {
						return;
					}

					const buttons = gridEl.querySelectorAll('.zo-speed-sort-btn');
					buttons.forEach(function (button) {
						button.disabled = true;
					});

					if (value === correctValue) {
						btn.classList.add('is-correct');
						score += 1;
						setStatus('Doğru.');
						updateStats();

						window.setTimeout(function () {
							buildRound();
						}, 220);
					} else {
						btn.classList.add('is-wrong');

						buttons.forEach(function (button) {
							if (parseInt(button.textContent, 10) === correctValue) {
								button.classList.add('is-correct');
							}
						});

						setStatus('Yanlış.');
						window.setTimeout(function () {
							endGame();
						}, 500);
					}
				});

				gridEl.appendChild(btn);
			});

			updateStats();
		}

		function startGame() {
			score = 0;
			round = 0;
			timeLeft = 30;
			playing = true;
			startBtn.disabled = true;
			setStatus('Hızlı seç.');
			updateStats();
			buildRound();

			stopTimer();
			timer = window.setInterval(function () {
				timeLeft -= 1;
				updateStats();

				if (timeLeft <= 0) {
					endGame();
				}
			}, 1000);
		}

		function resetView() {
			stopTimer();
			playing = false;
			score = 0;
			round = 0;
			timeLeft = 30;
			gridEl.innerHTML = '';
			targetValueEl.textContent = '⚡';
			targetLabelEl.textContent = 'Başlamak için Başla butonuna bas';
			setStatus('Hazır.');
			startBtn.disabled = false;
			updateStats();
		}

		startBtn.addEventListener('click', startGame);
		restartBtn.addEventListener('click', resetView);

		resetView();
	});
});
JS;

if (!function_exists('zo_game_speed_sort_render')) {
	function zo_game_speed_sort_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-speed-sort-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--speed-sort" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-speed-sort-wrap">
				<h3 class="zo-speed-sort-title">Speed Sort</h3>
				<p class="zo-speed-sort-text">Hızlı düşün. En büyük ya da en küçük sayıyı hemen bul. Yanlış seçersen oyun biter.</p>

				<div class="zo-speed-sort-topbar">
					<div class="zo-speed-sort-pill zo-speed-sort-round">Tur: 0</div>
					<div class="zo-speed-sort-pill zo-speed-sort-score">Skor: 0</div>
					<div class="zo-speed-sort-pill zo-speed-sort-best">En iyi: 0</div>
					<div class="zo-speed-sort-pill zo-speed-sort-time">Süre: 30</div>
				</div>

				<div class="zo-speed-sort-target">
					<div class="zo-speed-sort-target-label">Başlamak için Başla butonuna bas</div>
					<div class="zo-speed-sort-target-value">⚡</div>
				</div>

				<div class="zo-speed-sort-grid" aria-label="Sayı seçenekleri"></div>

				<div class="zo-speed-sort-controls">
					<button type="button" class="zo-speed-sort-action zo-speed-sort-start">Başla</button>
					<button type="button" class="zo-speed-sort-action zo-speed-sort-restart">Sıfırla</button>
				</div>

				<div class="zo-speed-sort-status">Hazır.</div>
				<div class="zo-speed-sort-help">Amaç süre bitmeden mümkün olduğu kadar çok doğru seçim yapmak.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'speed-sort',
	'name'            => 'Speed Sort',
	'author'          => 'Arslan',
	'description'     => 'Hızlı sayı seçme ve dikkat oyunu.',
	'render_callback' => 'zo_game_speed_sort_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);