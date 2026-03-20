<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 640px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--turkish-word-builder .zo-twb-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--turkish-word-builder .zo-twb-title {
	font-size: 28px;
	font-weight: 700;
	margin-bottom: 8px;
}

.zo-game-root--turkish-word-builder .zo-twb-subtitle {
	font-size: 15px;
	color: #555;
	margin-bottom: 16px;
}

.zo-game-root--turkish-word-builder .zo-twb-status {
	min-height: 24px;
	font-weight: 700;
	margin-bottom: 12px;
	color: #0b5;
}

.zo-game-root--turkish-word-builder .zo-twb-stats {
	display: flex;
	justify-content: center;
	gap: 10px;
	margin-bottom: 14px;
	flex-wrap: wrap;
}

.zo-game-root--turkish-word-builder .zo-twb-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 6px 12px;
	font-size: 13px;
	font-weight: 700;
}

.zo-game-root--turkish-word-builder .zo-twb-word {
	font-size: 26px;
	letter-spacing: 6px;
	margin-bottom: 12px;
	font-weight: 700;
}

.zo-game-root--turkish-word-builder .zo-twb-letters {
	display: flex;
	justify-content: center;
	gap: 8px;
	flex-wrap: wrap;
	margin-bottom: 14px;
}

.zo-game-root--turkish-word-builder .zo-twb-letter {
	width: 42px;
	height: 42px;
	border-radius: 10px;
	border: 2px solid #222;
	background: #e3f2fd;
	cursor: pointer;
	font-size: 18px;
	font-weight: 700;
}

.zo-game-root--turkish-word-builder .zo-twb-letter.used {
	background: #ccc;
	cursor: default;
}

.zo-game-root--turkish-word-builder .zo-twb-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--turkish-word-builder .zo-twb-btn {
	border: 2px solid #222;
	background: #222;
	color: #fff;
	border-radius: 999px;
	padding: 8px 14px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--turkish-word-builder .zo-twb-btn:hover {
	background: #000;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--turkish-word-builder');

	const WORDS = [
		'elma','kitap','araba','kalem','okul','masa','kedi','köpek','yol','su'
	];

	games.forEach(function (game) {
		const wordEl = game.querySelector('.zo-twb-word');
		const lettersEl = game.querySelector('.zo-twb-letters');
		const statusEl = game.querySelector('.zo-twb-status');
		const scoreEl = game.querySelector('.zo-twb-score');
		const roundEl = game.querySelector('.zo-twb-round');
		const restartBtn = game.querySelector('.zo-twb-restart');
		const clearBtn = game.querySelector('.zo-twb-clear');

		let currentWord = '';
		let display = [];
		let letters = [];
		let score = 0;
		let round = 1;

		function shuffle(array) {
			for (let i = array.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = array[i];
				array[i] = array[j];
				array[j] = temp;
			}
			return array;
		}

		function updateDisplay() {
			wordEl.textContent = display.join(' ');
		}

		function newRound() {
			currentWord = WORDS[Math.floor(Math.random() * WORDS.length)];
			display = new Array(currentWord.length).fill('_');
			letters = shuffle(currentWord.split(''));

			lettersEl.innerHTML = '';

			letters.forEach(function (letter, index) {
				const btn = document.createElement('button');
				btn.className = 'zo-twb-letter';
				btn.textContent = letter;

				btn.addEventListener('click', function () {
					if (btn.classList.contains('used')) return;

					const pos = display.indexOf('_');
					if (pos !== -1) {
						display[pos] = letter;
						btn.classList.add('used');
						updateDisplay();

						if (!display.includes('_')) {
							if (display.join('') === currentWord) {
								score++;
								statusEl.textContent = 'Correct!';
							} else {
								statusEl.textContent = 'Wrong order!';
							}
							scoreEl.textContent = score;
							setTimeout(function () {
								round++;
								roundEl.textContent = round;
								newRound();
							}, 800);
						}
					}
				});

				lettersEl.appendChild(btn);
			});

			updateDisplay();
			statusEl.textContent = 'Build the word';
		}

		restartBtn.addEventListener('click', function () {
			score = 0;
			round = 1;
			scoreEl.textContent = score;
			roundEl.textContent = round;
			newRound();
		});

		clearBtn.addEventListener('click', function () {
			display = new Array(currentWord.length).fill('_');
			updateDisplay();
			game.querySelectorAll('.zo-twb-letter').forEach(function (b) {
				b.classList.remove('used');
			});
		});

		newRound();
	});
});
JS;

if (!function_exists('zo_game_turkish_word_builder_render')) {
	function zo_game_turkish_word_builder_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-turkish-word-builder-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--turkish-word-builder" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-twb-card">
				<div class="zo-twb-title">Türkçe Kelime Kur</div>
				<div class="zo-twb-subtitle">Harfleri doğru sıraya koy</div>

				<div class="zo-twb-stats">
					<div class="zo-twb-stat">Score: <span class="zo-twb-score">0</span></div>
					<div class="zo-twb-stat">Round: <span class="zo-twb-round">1</span></div>
				</div>

				<div class="zo-twb-status">Build the word</div>
				<div class="zo-twb-word"></div>
				<div class="zo-twb-letters"></div>

				<div class="zo-twb-actions">
					<button class="zo-twb-btn zo-twb-clear">Clear</button>
					<button class="zo-twb-btn zo-twb-restart">Restart</button>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'turkish-word-builder',
	'name'            => 'Türkçe Kelime Kur',
	'author'          => 'Arslan',
	'description'     => 'A simple Turkish word building game.',
	'render_callback' => 'zo_game_turkish_word_builder_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);