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

.zo-anubis-wrap {
	background: #fff7e8;
	border: 2px solid #c9a25d;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-anubis-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-anubis-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-anubis-topbar {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-anubis-pill {
	background: #ffffff;
	border: 1px solid #c9a25d;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 14px;
	font-weight: bold;
}

.zo-anubis-board {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	max-width: 420px;
	margin: 0 auto 16px;
}

.zo-anubis-door {
	appearance: none;
	border: 2px solid #b88c40;
	border-radius: 14px;
	background: #d8b06d;
	color: #3b2a12;
	min-height: 86px;
	font-size: 30px;
	font-weight: bold;
	cursor: pointer;
	padding: 10px;
	transition: transform 0.15s ease, opacity 0.15s ease, background 0.15s ease;
}

.zo-anubis-door:hover,
.zo-anubis-door:focus {
	transform: translateY(-2px);
}

.zo-anubis-door.is-open-safe {
	background: #e8f7df;
	border-color: #77ab4d;
}

.zo-anubis-door.is-open-trap {
	background: #ffe4e4;
	border-color: #d97b7b;
}

.zo-anubis-door:disabled {
	cursor: default;
	opacity: 0.95;
}

.zo-anubis-controls {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-anubis-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #8a5d2b;
	color: #fff;
	min-width: 120px;
}

.zo-anubis-btn:hover,
.zo-anubis-btn:focus {
	opacity: 0.92;
}

.zo-anubis-status {
	min-height: 24px;
	font-size: 15px;
	font-weight: bold;
	margin-top: 8px;
}

.zo-anubis-help {
	margin-top: 10px;
	font-size: 14px;
	line-height: 1.5;
}

@media (max-width: 520px) {
	.zo-anubis-title {
		font-size: 24px;
	}

	.zo-anubis-board {
		gap: 8px;
	}

	.zo-anubis-door {
		min-height: 72px;
		font-size: 26px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--anubisin-kapilari');

	games.forEach(function (game) {
		const board = game.querySelector('.zo-anubis-board');
		const levelEl = game.querySelector('.zo-anubis-level');
		const scoreEl = game.querySelector('.zo-anubis-score');
		const heartsEl = game.querySelector('.zo-anubis-hearts');
		const bestEl = game.querySelector('.zo-anubis-best');
		const statusEl = game.querySelector('.zo-anubis-status');
		const restartBtn = game.querySelector('.zo-anubis-restart');

		let level = 1;
		let score = 0;
		let hearts = 3;
		let best = 0;
		let safeDoor = 0;
		let locked = false;

		function shuffle(array) {
			for (let i = array.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = array[i];
				array[i] = array[j];
				array[j] = temp;
			}
			return array;
		}

		function updateStats() {
			levelEl.textContent = 'Seviye: ' + level;
			scoreEl.textContent = 'Skor: ' + score;
			heartsEl.textContent = 'Can: ' + hearts;
			bestEl.textContent = 'En iyi: ' + best;
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function revealAllDoors(chosenIndex) {
			const doors = board.querySelectorAll('.zo-anubis-door');

			doors.forEach(function (door, index) {
				door.disabled = true;

				if (index === safeDoor) {
					door.textContent = '💎';
					door.classList.add('is-open-safe');
				} else {
					door.textContent = index === chosenIndex ? '💀' : '🐍';
					door.classList.add('is-open-trap');
				}
			});
		}

		function nextRound() {
			if (hearts <= 0) {
				if (score > best) {
					best = score;
				}
				updateStats();
				setStatus('Oyun bitti. Tekrar oyna.');
				locked = true;
				return;
			}

			locked = false;
			buildBoard();
			updateStats();
			setStatus('Doğru kapıyı seç.');
		}

		function handleChoice(index) {
			if (locked) {
				return;
			}

			locked = true;
			revealAllDoors(index);

			if (index === safeDoor) {
				score += level * 2;
				setStatus('Doğru kapı. Hazineyi buldun.');
				if (score > best) {
					best = score;
				}
				level += 1;
			} else {
				hearts -= 1;
				setStatus('Yanlış kapı. Tuzak vardı.');
			}

			updateStats();

			window.setTimeout(function () {
				nextRound();
			}, 900);
		}

		function buildBoard() {
			const doorCount = 8;
			const indexes = shuffle([0, 1, 2, 3, 4, 5, 6, 7].slice());
			safeDoor = indexes[0];
			board.innerHTML = '';

			for (let i = 0; i < doorCount; i++) {
				const door = document.createElement('button');
				door.type = 'button';
				door.className = 'zo-anubis-door';
				door.textContent = '🚪';
				door.setAttribute('aria-label', 'Kapı ' + (i + 1));
				door.addEventListener('click', function () {
					handleChoice(i);
				});
				board.appendChild(door);
			}
		}

		function restartGame() {
			level = 1;
			score = 0;
			hearts = 3;
			locked = false;
			buildBoard();
			updateStats();
			setStatus('Doğru kapıyı seç.');
		}

		restartBtn.addEventListener('click', restartGame);

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_anubisin_kapilari_render')) {
	function zo_game_anubisin_kapilari_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-anubisin-kapilari-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--anubisin-kapilari" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-anubis-wrap">
				<h3 class="zo-anubis-title">Anubis'in Kapıları</h3>
				<p class="zo-anubis-text">Mısır tapınağında sekiz kapı var. Sadece birinde hazine var. Doğru kapıyı seç ve ilerle.</p>

				<div class="zo-anubis-topbar">
					<div class="zo-anubis-pill zo-anubis-level">Seviye: 1</div>
					<div class="zo-anubis-pill zo-anubis-score">Skor: 0</div>
					<div class="zo-anubis-pill zo-anubis-hearts">Can: 3</div>
					<div class="zo-anubis-pill zo-anubis-best">En iyi: 0</div>
				</div>

				<div class="zo-anubis-board" aria-label="Kapılar"></div>

				<div class="zo-anubis-controls">
					<button type="button" class="zo-anubis-btn zo-anubis-restart">Tekrar Oyna</button>
				</div>

				<div class="zo-anubis-status">Doğru kapıyı seç.</div>
				<div class="zo-anubis-help">Her turda sadece bir kapı güvenlidir. Yanlış seçimde can kaybedersin.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'anubisin-kapilari',
	'name'            => 'Anubis\'in Kapıları',
	'author'          => 'Arslan',
	'description'     => 'Mısır temalı şans ve seçim oyunu.',
	'render_callback' => 'zo_game_anubisin_kapilari_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);