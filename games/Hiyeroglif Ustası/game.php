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

.zo-scribe-wrap {
	background: #fff8e8;
	border: 2px solid #caa35d;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-scribe-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-scribe-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-scribe-topbar {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-scribe-pill {
	background: #ffffff;
	border: 1px solid #caa35d;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 14px;
	font-weight: bold;
}

.zo-scribe-symbol {
	font-size: 56px;
	line-height: 1;
	margin: 14px 0 8px;
}

.zo-scribe-options {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
	margin: 16px 0;
}

.zo-scribe-option {
	appearance: none;
	border: 2px solid #c49035;
	border-radius: 14px;
	background: #fffdf7;
	color: #3b2a12;
	padding: 14px 12px;
	font-size: 18px;
	font-weight: bold;
	cursor: pointer;
	min-height: 64px;
	transition: transform 0.15s ease, background 0.15s ease, border-color 0.15s ease;
}

.zo-scribe-option:hover,
.zo-scribe-option:focus {
	transform: translateY(-2px);
}

.zo-scribe-option.is-correct {
	background: #e9f8df;
	border-color: #79ab50;
}

.zo-scribe-option.is-wrong {
	background: #ffe7e7;
	border-color: #d97f7f;
}

.zo-scribe-controls {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-scribe-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #8b6236;
	color: #fff;
	min-width: 120px;
}

.zo-scribe-btn:hover,
.zo-scribe-btn:focus {
	opacity: 0.92;
}

.zo-scribe-btn:disabled {
	opacity: 0.6;
	cursor: default;
}

.zo-scribe-status {
	min-height: 24px;
	font-size: 15px;
	font-weight: bold;
	margin-top: 8px;
}

.zo-scribe-help {
	margin-top: 10px;
	font-size: 14px;
	line-height: 1.5;
}

@media (max-width: 520px) {
	.zo-scribe-title {
		font-size: 24px;
	}

	.zo-scribe-options {
		grid-template-columns: 1fr;
	}

	.zo-scribe-symbol {
		font-size: 48px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--hiyeroglif-ustasi');

	games.forEach(function (game) {
		const symbolEl = game.querySelector('.zo-scribe-symbol');
		const promptEl = game.querySelector('.zo-scribe-prompt');
		const optionsEl = game.querySelector('.zo-scribe-options');
		const scoreEl = game.querySelector('.zo-scribe-score');
		const roundEl = game.querySelector('.zo-scribe-round');
		const bestEl = game.querySelector('.zo-scribe-best');
		const statusEl = game.querySelector('.zo-scribe-status');
		const startBtn = game.querySelector('.zo-scribe-start');
		const restartBtn = game.querySelector('.zo-scribe-restart');
		const nextBtn = game.querySelector('.zo-scribe-next');

		const questions = [
			{ symbol: '☀️', answer: 'Güneş', options: ['Güneş', 'Nehir', 'Taç', 'Kedi'] },
			{ symbol: '🐈', answer: 'Kedi', options: ['Kuş', 'Yılan', 'Kedi', 'Çöl'] },
			{ symbol: '👑', answer: 'Taç', options: ['Deve', 'Taç', 'Kapı', 'Su'] },
			{ symbol: '🐍', answer: 'Yılan', options: ['Yılan', 'Balık', 'Taş', 'Altın'] },
			{ symbol: '💧', answer: 'Su', options: ['Güneş', 'Su', 'Kum', 'Firavun'] },
			{ symbol: '🪙', answer: 'Altın', options: ['Kum', 'Altın', 'Kedi', 'Nehir'] },
			{ symbol: '🏺', answer: 'Vazo', options: ['Vazo', 'Ağaç', 'Taç', 'Ay'] },
			{ symbol: '🦅', answer: 'Kuş', options: ['Kapı', 'Kuş', 'Kılıç', 'Su'] }
		];

		let deck = [];
		let index = 0;
		let score = 0;
		let best = 0;
		let locked = false;
		let playing = false;

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
			scoreEl.textContent = 'Skor: ' + score;
			roundEl.textContent = 'Tur: ' + (playing ? (index + 1) + '/' + deck.length : '0/' + questions.length);
			bestEl.textContent = 'En iyi: ' + best;
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function finishGame() {
			playing = false;
			locked = true;
			if (score > best) {
				best = score;
			}
			updateStats();
			setStatus('Oyun bitti. Tekrar oynayabilirsin.');
			nextBtn.disabled = true;
			startBtn.disabled = false;
		}

		function renderQuestion() {
			if (index >= deck.length) {
				finishGame();
				return;
			}

			const current = deck[index];
			symbolEl.textContent = current.symbol;
			promptEl.textContent = 'Bu Mısır işareti neyi gösteriyor?';
			optionsEl.innerHTML = '';
			locked = false;

			const optionList = shuffle(current.options.slice());

			optionList.forEach(function (optionText) {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'zo-scribe-option';
				btn.textContent = optionText;

				btn.addEventListener('click', function () {
					if (locked) {
						return;
					}
					locked = true;

					const buttons = optionsEl.querySelectorAll('.zo-scribe-option');

					buttons.forEach(function (button) {
						if (button.textContent === current.answer) {
							button.classList.add('is-correct');
						}
						if (button === btn && button.textContent !== current.answer) {
							button.classList.add('is-wrong');
						}
						button.disabled = true;
					});

					if (optionText === current.answer) {
						score += 10;
						setStatus('Doğru cevap.');
					} else {
						setStatus('Yanlış cevap.');
					}

					updateStats();
					nextBtn.disabled = false;
				});

				optionsEl.appendChild(btn);
			});

			nextBtn.disabled = true;
			updateStats();
		}

		function startGame() {
			deck = shuffle(questions.slice());
			index = 0;
			score = 0;
			playing = true;
			startBtn.disabled = true;
			nextBtn.disabled = true;
			setStatus('Doğru anlamı seç.');
			renderQuestion();
		}

		function restartGame() {
			symbolEl.textContent = '𓂀';
			promptEl.textContent = 'Başlamak için Başla butonuna bas.';
			optionsEl.innerHTML = '';
			score = 0;
			index = 0;
			playing = false;
			locked = true;
			startBtn.disabled = false;
			nextBtn.disabled = true;
			updateStats();
			setStatus('Hazır.');
		}

		function nextQuestion() {
			if (!playing || !locked) {
				return;
			}
			index += 1;
			renderQuestion();
		}

		startBtn.addEventListener('click', startGame);
		restartBtn.addEventListener('click', restartGame);
		nextBtn.addEventListener('click', nextQuestion);

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_hiyeroglif_ustasi_render')) {
	function zo_game_hiyeroglif_ustasi_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-hiyeroglif-ustasi-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--hiyeroglif-ustasi" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-scribe-wrap">
				<h3 class="zo-scribe-title">Hiyeroglif Ustası</h3>
				<p class="zo-scribe-text">Eski Mısır yazı işaretlerini tahmin et. Doğru anlamı seç ve puan topla.</p>

				<div class="zo-scribe-topbar">
					<div class="zo-scribe-pill zo-scribe-score">Skor: 0</div>
					<div class="zo-scribe-pill zo-scribe-round">Tur: 0/8</div>
					<div class="zo-scribe-pill zo-scribe-best">En iyi: 0</div>
				</div>

				<div class="zo-scribe-symbol">𓂀</div>
				<div class="zo-scribe-prompt">Başlamak için Başla butonuna bas.</div>

				<div class="zo-scribe-options" aria-label="Cevap seçenekleri"></div>

				<div class="zo-scribe-controls">
					<button type="button" class="zo-scribe-btn zo-scribe-start">Başla</button>
					<button type="button" class="zo-scribe-btn zo-scribe-next">Sonraki</button>
					<button type="button" class="zo-scribe-btn zo-scribe-restart">Sıfırla</button>
				</div>

				<div class="zo-scribe-status">Hazır.</div>
				<div class="zo-scribe-help">Amaç bütün işaretleri doğru tahmin edip en yüksek skoru yapmak.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'hiyeroglif-ustasi',
	'name'            => 'Hiyeroglif Ustası',
	'author'          => 'Arslan',
	'description'     => 'Mısır temalı tahmin ve bilgi oyunu.',
	'render_callback' => 'zo_game_hiyeroglif_ustasi_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);