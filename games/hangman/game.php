<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--adam-asmaca {
	max-width: 720px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--adam-asmaca .zo-aa-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}

.zo-game-root--adam-asmaca .zo-aa-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--adam-asmaca .zo-aa-top {
	display: grid;
	grid-template-columns: 260px 1fr;
	gap: 18px;
	align-items: start;
	margin-bottom: 16px;
}

.zo-game-root--adam-asmaca .zo-aa-canvas-wrap {
	display: flex;
	justify-content: center;
}

.zo-game-root--adam-asmaca .zo-aa-canvas {
	width: 260px;
	height: 260px;
	background: #fafafa;
	border: 1px solid #d1d5db;
	border-radius: 12px;
}

.zo-game-root--adam-asmaca .zo-aa-side {
	display: grid;
	grid-template-columns: 1fr;
	gap: 12px;
}

.zo-game-root--adam-asmaca .zo-aa-word {
	font-family: Consolas, monospace;
	font-size: 32px;
	font-weight: 700;
	letter-spacing: 4px;
	text-align: center;
	padding: 16px 12px;
	border: 2px dashed #c8d4e0;
	border-radius: 14px;
	background: #f8fbff;
	color: #111827;
	word-break: break-word;
	min-height: 74px;
	box-sizing: border-box;
}

.zo-game-root--adam-asmaca .zo-aa-input-row {
	display: grid;
	grid-template-columns: minmax(0, 100px) 1fr 1fr 1fr;
	gap: 8px;
}

.zo-game-root--adam-asmaca .zo-aa-input {
	width: 100%;
	padding: 12px;
	border: 2px solid #c8d4e0;
	border-radius: 12px;
	font-size: 18px;
	text-align: center;
	background: #f8fbff;
	color: #111827;
	box-sizing: border-box;
}

.zo-game-root--adam-asmaca .zo-aa-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--adam-asmaca .zo-aa-button--guess {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--adam-asmaca .zo-aa-button--hint {
	background: #8b5cf6;
	color: #ffffff;
}

.zo-game-root--adam-asmaca .zo-aa-button--restart {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--adam-asmaca .zo-aa-message {
	min-height: 24px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--adam-asmaca .zo-aa-message.is-good {
	color: #15803d;
}

.zo-game-root--adam-asmaca .zo-aa-message.is-bad {
	color: #dc2626;
}

.zo-game-root--adam-asmaca .zo-aa-message.is-warn {
	color: #d97706;
}

.zo-game-root--adam-asmaca .zo-aa-message.is-info {
	color: #2563eb;
}

.zo-game-root--adam-asmaca .zo-aa-message.is-hint {
	color: #7c3aed;
}

.zo-game-root--adam-asmaca .zo-aa-stats {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--adam-asmaca .zo-aa-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
}

.zo-game-root--adam-asmaca .zo-aa-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--adam-asmaca .zo-aa-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--adam-asmaca .zo-aa-guessed {
	padding: 12px;
	border-radius: 14px;
	background: #f8fafc;
	border: 2px solid #dbe4ee;
	font-size: 15px;
	line-height: 1.5;
	color: #1f2937;
	text-align: center;
	word-break: break-word;
}

.zo-game-root--adam-asmaca .zo-aa-keyboard {
	display: grid;
	gap: 8px;
	margin-top: 16px;
}

.zo-game-root--adam-asmaca .zo-aa-kb-row {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 6px;
}

.zo-game-root--adam-asmaca .zo-aa-key {
	min-width: 44px;
	padding: 10px 8px;
	border: 2px solid #cbd5e1;
	border-radius: 10px;
	background: #ffffff;
	color: #111827;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--adam-asmaca .zo-aa-key:disabled {
	background: #e5e7eb;
	color: #6b7280;
	cursor: default;
}

@media (max-width: 700px) {
	.zo-game-root.zo-game-root--adam-asmaca {
		padding: 16px;
	}

	.zo-game-root--adam-asmaca .zo-aa-title {
		font-size: 25px;
	}

	.zo-game-root--adam-asmaca .zo-aa-top {
		grid-template-columns: 1fr;
	}

	.zo-game-root--adam-asmaca .zo-aa-canvas {
		width: 240px;
		height: 240px;
	}

	.zo-game-root--adam-asmaca .zo-aa-input-row,
	.zo-game-root--adam-asmaca .zo-aa-stats {
		grid-template-columns: 1fr;
	}

	.zo-game-root--adam-asmaca .zo-aa-word {
		font-size: 26px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--adam-asmaca');

	games.forEach(function (game) {
		const words = [
			'python', 'anahtar', 'lezzetli', 'asker', 'rastgele',  'yakala',
			'ingilizce', 'pencere', 'kitap', 'doğru', 'kazan', 'pokemon',
			'test', 'dosya', 'harf', 'adama asmaca', 'fil', 'komik',
			'made', 'bilgisayar', 'girdi', 'defter', 'harika', 'minecraft', 'maden',
			'klavye', 'televizyon', 'adam', 'oyuncak', 'okul', 'masa', 'kalem'
		];

		const maxAttempts = 10;
		const canvas = game.querySelector('.zo-aa-canvas');
		const ctx = canvas.getContext('2d');
		const wordEl = game.querySelector('.zo-aa-word');
		const inputEl = game.querySelector('.zo-aa-input');
		const guessButton = game.querySelector('.zo-aa-button--guess');
		const hintButton = game.querySelector('.zo-aa-button--hint');
		const restartButton = game.querySelector('.zo-aa-button--restart');
		const messageEl = game.querySelector('.zo-aa-message');
		const attemptsEl = game.querySelector('.zo-aa-attempts');
		const winsEl = game.querySelector('.zo-aa-wins');
		const lossesEl = game.querySelector('.zo-aa-losses');
		const remainingEl = game.querySelector('.zo-aa-remaining');
		const guessedEl = game.querySelector('.zo-aa-guessed-text');
		const keyboardButtons = Array.prototype.slice.call(game.querySelectorAll('.zo-aa-key'));

		let word = '';
		let guessedLetters = new Set();
		let attempts = maxAttempts;
		let wins = 0;
		let losses = 0;
		let roundActive = true;

		function randomWord() {
			return words[Math.floor(Math.random() * words.length)];
		}

		function displayWord() {
			return word.split('').map(function (letter) {
				return guessedLetters.has(letter) ? letter.toUpperCase() : '_';
			}).join(' ');
		}

		function unrevealedCount() {
			const uniqueLetters = Array.from(new Set(word.split('')));
			return uniqueLetters.filter(function (letter) {
				return !guessedLetters.has(letter);
			}).length;
		}

		function setMessage(text, type) {
			messageEl.textContent = text;
			messageEl.className = 'zo-aa-message';
			if (type) {
				messageEl.classList.add(type);
			}
		}

		function updateKeyboardState(enabled) {
			keyboardButtons.forEach(function (button) {
				button.disabled = !enabled;
			});

			if (enabled) {
				guessedLetters.forEach(function (letter) {
					const btn = game.querySelector('.zo-aa-key[data-letter="' + letter + '"]');
					if (btn) {
						btn.disabled = true;
					}
				});
			}
		}

		function updateUI() {
			wordEl.textContent = displayWord();
			attemptsEl.textContent = String(attempts);
			winsEl.textContent = String(wins);
			lossesEl.textContent = String(losses);
			remainingEl.textContent = String(unrevealedCount());
			guessedEl.textContent = guessedLetters.size ? Array.from(guessedLetters).sort().join(' ') : '—';

			if (unrevealedCount() <= 1 || attempts <= 0 || !roundActive) {
				hintButton.disabled = true;
			} else {
				hintButton.disabled = false;
			}
		}

		function drawGallows() {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			ctx.lineWidth = 3;
			ctx.strokeStyle = '#111827';
			ctx.beginPath();
			ctx.moveTo(20, 235);
			ctx.lineTo(240, 235);
			ctx.moveTo(60, 235);
			ctx.lineTo(60, 25);
			ctx.lineTo(170, 25);
			ctx.lineTo(170, 55);
			ctx.stroke();
		}

		function drawPart(step) {
			ctx.lineWidth = step >= 7 ? 2 : 3;
			ctx.strokeStyle = '#111827';
			ctx.beginPath();

			if (step === 1) {
				ctx.arc(170, 70, 15, 0, Math.PI * 2);
			} else if (step === 2) {
				ctx.moveTo(170, 85);
				ctx.lineTo(170, 145);
			} else if (step === 3) {
				ctx.moveTo(170, 100);
				ctx.lineTo(145, 120);
			} else if (step === 4) {
				ctx.moveTo(170, 100);
				ctx.lineTo(195, 120);
			} else if (step === 5) {
				ctx.moveTo(170, 145);
				ctx.lineTo(155, 180);
			} else if (step === 6) {
				ctx.moveTo(170, 145);
				ctx.lineTo(185, 180);
			} else if (step === 7) {
				ctx.moveTo(162, 66);
				ctx.lineTo(166, 70);
			} else if (step === 8) {
				ctx.moveTo(174, 66);
				ctx.lineTo(178, 70);
			} else if (step === 9) {
				ctx.moveTo(162, 78);
				ctx.lineTo(178, 78);
			} else if (step === 10) {
				ctx.moveTo(168, 55);
				ctx.lineTo(172, 55);
			}

			ctx.stroke();
		}

		function redrawFigure() {
			drawGallows();
			const wrongGuesses = maxAttempts - attempts;
			for (let i = 1; i <= wrongGuesses; i++) {
				drawPart(i);
			}
		}

		function endGame(win) {
			roundActive = false;

			if (win) {
				wins += 1;
				setMessage('Kazandın. Kelime: ' + word.toUpperCase(), 'is-info');
			} else {
				losses += 1;
				wordEl.textContent = word.toUpperCase().split('').join(' ');
				setMessage('Oyun bitti. Kelime: ' + word.toUpperCase(), 'is-bad');
			}

			inputEl.disabled = true;
			guessButton.disabled = true;
			updateKeyboardState(false);
			updateUI();
		}

		function handleNewGuess(letter) {
			if (!roundActive) {
				return;
			}

			if (guessedLetters.has(letter)) {
				setMessage('Bu harfi zaten denedin.', 'is-warn');
				return;
			}

			guessedLetters.add(letter);

			const keyButton = game.querySelector('.zo-aa-key[data-letter="' + letter + '"]');
			if (keyButton) {
				keyButton.disabled = true;
			}

			if (word.indexOf(letter) !== -1) {
				setMessage('Doğru tahmin.', 'is-good');
				updateUI();

				const allFound = word.split('').every(function (ch) {
					return guessedLetters.has(ch);
				});

				if (allFound) {
					endGame(true);
				}
			} else {
				attempts -= 1;
				setMessage('Yanlış tahmin.', 'is-bad');
				redrawFigure();
				updateUI();

				if (attempts === 0) {
					endGame(false);
				}
			}
		}

		function guessLetter(letterFromButton) {
			let letter = '';

			if (letterFromButton) {
				letter = letterFromButton;
				inputEl.value = '';
			} else {
				letter = inputEl.value.toLowerCase().trim();
				inputEl.value = '';
			}

			if (!/^[a-z]$/.test(letter)) {
				setMessage('Tek bir harf gir.', 'is-bad');
				return;
			}

			handleNewGuess(letter);
		}

		function useHint() {
			const remaining = Array.from(new Set(word.split(''))).filter(function (ch) {
				return !guessedLetters.has(ch);
			});

			if (!remaining.length) {
				setMessage('İpucuna gerek yok.', 'is-info');
				updateUI();
				return;
			}

			if (attempts <= 0 || !roundActive) {
				setMessage('İpucu kullanılamaz.', 'is-bad');
				updateUI();
				return;
			}

			const reveal = remaining[Math.floor(Math.random() * remaining.length)];
			attempts -= 1;
			guessedLetters.add(reveal);

			const keyButton = game.querySelector('.zo-aa-key[data-letter="' + reveal + '"]');
			if (keyButton) {
				keyButton.disabled = true;
			}

			setMessage('İpucu kullanıldı. Açılan harf: ' + reveal.toUpperCase() + ' (-1)', 'is-hint');
			redrawFigure();
			updateUI();

			const allFound = word.split('').every(function (ch) {
				return guessedLetters.has(ch);
			});

			if (allFound) {
				endGame(true);
			} else if (attempts === 0) {
				endGame(false);
			}
		}

		function resetGame() {
			word = randomWord();
			guessedLetters = new Set();
			attempts = maxAttempts;
			roundActive = true;

			inputEl.disabled = false;
			guessButton.disabled = false;
			inputEl.value = '';
			updateKeyboardState(true);
			drawGallows();
			setMessage('', '');
			updateUI();
			inputEl.focus();
		}

		guessButton.addEventListener('click', function () {
			guessLetter('');
		});

		hintButton.addEventListener('click', useHint);
		restartButton.addEventListener('click', resetGame);

		inputEl.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				guessLetter('');
			}
		});

		keyboardButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				guessLetter(button.getAttribute('data-letter'));
			});
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_adam_asmaca_render')) {
	function zo_game_adam_asmaca_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-adam-asmaca-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--adam-asmaca" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-aa-title">Adam Asmaca</h2>
			<p class="zo-aa-desc">Bir harf tahmin et. Yanlış tahminlerde çizim tamamlanır. Kelimeyi bitir ve kazan.</p>

			<div class="zo-aa-top">
				<div class="zo-aa-canvas-wrap">
					<canvas class="zo-aa-canvas" width="260" height="260"></canvas>
				</div>

				<div class="zo-aa-side">
					<div class="zo-aa-word">_ _ _ _</div>

					<div class="zo-aa-input-row">
						<input type="text" maxlength="1" class="zo-aa-input" placeholder="Harf" />
						<button type="button" class="zo-aa-button zo-aa-button--guess">Tahmin</button>
						<button type="button" class="zo-aa-button zo-aa-button--hint">İpucu (-1)</button>
						<button type="button" class="zo-aa-button zo-aa-button--restart">Tekrar</button>
					</div>

					<div class="zo-aa-message" aria-live="polite"></div>

					<div class="zo-aa-stats">
						<div class="zo-aa-stat">
							<span class="zo-aa-stat-label">Hak</span>
							<span class="zo-aa-stat-value zo-aa-attempts">10</span>
						</div>
						<div class="zo-aa-stat">
							<span class="zo-aa-stat-label">Kazanç</span>
							<span class="zo-aa-stat-value zo-aa-wins">0</span>
						</div>
						<div class="zo-aa-stat">
							<span class="zo-aa-stat-label">Kayıp</span>
							<span class="zo-aa-stat-value zo-aa-losses">0</span>
						</div>
						<div class="zo-aa-stat">
							<span class="zo-aa-stat-label">Kalan Harf</span>
							<span class="zo-aa-stat-value zo-aa-remaining">0</span>
						</div>
					</div>

					<div class="zo-aa-guessed">
						Denenen harfler: <strong class="zo-aa-guessed-text">—</strong>
					</div>
				</div>
			</div>

			<div class="zo-aa-keyboard">
				<div class="zo-aa-kb-row">
					<button type="button" class="zo-aa-key" data-letter="q">Q</button>
					<button type="button" class="zo-aa-key" data-letter="w">W</button>
					<button type="button" class="zo-aa-key" data-letter="e">E</button>
					<button type="button" class="zo-aa-key" data-letter="r">R</button>
					<button type="button" class="zo-aa-key" data-letter="t">T</button>
					<button type="button" class="zo-aa-key" data-letter="y">Y</button>
					<button type="button" class="zo-aa-key" data-letter="u">U</button>
					<button type="button" class="zo-aa-key" data-letter="i">I</button>
					<button type="button" class="zo-aa-key" data-letter="o">O</button>
					<button type="button" class="zo-aa-key" data-letter="p">P</button>
				</div>
				<div class="zo-aa-kb-row">
					<button type="button" class="zo-aa-key" data-letter="a">A</button>
					<button type="button" class="zo-aa-key" data-letter="s">S</button>
					<button type="button" class="zo-aa-key" data-letter="d">D</button>
					<button type="button" class="zo-aa-key" data-letter="f">F</button>
					<button type="button" class="zo-aa-key" data-letter="g">G</button>
					<button type="button" class="zo-aa-key" data-letter="h">H</button>
					<button type="button" class="zo-aa-key" data-letter="j">J</button>
					<button type="button" class="zo-aa-key" data-letter="k">K</button>
					<button type="button" class="zo-aa-key" data-letter="l">L</button>
				</div>
				<div class="zo-aa-kb-row">
					<button type="button" class="zo-aa-key" data-letter="z">Z</button>
					<button type="button" class="zo-aa-key" data-letter="x">X</button>
					<button type="button" class="zo-aa-key" data-letter="c">C</button>
					<button type="button" class="zo-aa-key" data-letter="v">V</button>
					<button type="button" class="zo-aa-key" data-letter="b">B</button>
					<button type="button" class="zo-aa-key" data-letter="n">N</button>
					<button type="button" class="zo-aa-key" data-letter="m">M</button>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'adam-asmaca',
	'name'            => 'Adam Asmaca',
	'author'          => 'Asker',
	'description'     => 'Çocuklar için ipuçlu, puan takipli ve tekrar oynanabilir bir Adam Asmaca oyunu.',
	'render_callback' => 'zo_game_adam_asmaca_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);