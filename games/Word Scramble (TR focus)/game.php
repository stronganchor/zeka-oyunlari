<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--kelime-karistirma {
	max-width: 760px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--kelime-karistirma .zo-kk-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}

.zo-game-root--kelime-karistirma .zo-kk-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--kelime-karistirma .zo-kk-top {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--kelime-karistirma .zo-kk-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
}

.zo-game-root--kelime-karistirma .zo-kk-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--kelime-karistirma .zo-kk-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--kelime-karistirma .zo-kk-card {
	border: 2px dashed #c8d4e0;
	border-radius: 16px;
	padding: 18px;
	background: #f8fbff;
	text-align: center;
	margin-bottom: 14px;
}

.zo-game-root--kelime-karistirma .zo-kk-label {
	display: block;
	font-size: 14px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 8px;
}

.zo-game-root--kelime-karistirma .zo-kk-scrambled {
	font-size: 36px;
	font-weight: 700;
	letter-spacing: 3px;
	line-height: 1.2;
	color: #111827;
	word-break: break-word;
	min-height: 44px;
}

.zo-game-root--kelime-karistirma .zo-kk-hint {
	margin-top: 12px;
	font-size: 16px;
	font-weight: 700;
	color: #7c3aed;
	min-height: 22px;
}

.zo-game-root--kelime-karistirma .zo-kk-input-row {
	display: grid;
	grid-template-columns: minmax(0, 1fr) repeat(3, auto);
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--kelime-karistirma .zo-kk-input {
	width: 100%;
	padding: 13px 14px;
	border: 2px solid #c8d4e0;
	border-radius: 12px;
	font-size: 18px;
	background: #ffffff;
	color: #111827;
	box-sizing: border-box;
}

.zo-game-root--kelime-karistirma .zo-kk-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
	white-space: nowrap;
}

.zo-game-root--kelime-karistirma .zo-kk-button--guess {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--kelime-karistirma .zo-kk-button--hint {
	background: #8b5cf6;
	color: #ffffff;
}

.zo-game-root--kelime-karistirma .zo-kk-button--next {
	background: #10b981;
	color: #ffffff;
}

.zo-game-root--kelime-karistirma .zo-kk-button--restart {
	background: #e5e7eb;
	color: #111827;
	width: 100%;
}

.zo-game-root--kelime-karistirma .zo-kk-message {
	min-height: 24px;
	margin-bottom: 14px;
	text-align: center;
	font-size: 16px;
	font-weight: 700;
}

.zo-game-root--kelime-karistirma .zo-kk-message.is-good {
	color: #15803d;
}

.zo-game-root--kelime-karistirma .zo-kk-message.is-bad {
	color: #dc2626;
}

.zo-game-root--kelime-karistirma .zo-kk-message.is-info {
	color: #2563eb;
}

.zo-game-root--kelime-karistirma .zo-kk-message.is-warn {
	color: #d97706;
}

.zo-game-root--kelime-karistirma .zo-kk-bottom {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
}

@media (max-width: 700px) {
	.zo-game-root.zo-game-root--kelime-karistirma {
		padding: 16px;
	}

	.zo-game-root--kelime-karistirma .zo-kk-title {
		font-size: 25px;
	}

	.zo-game-root--kelime-karistirma .zo-kk-top,
	.zo-game-root--kelime-karistirma .zo-kk-input-row {
		grid-template-columns: 1fr;
	}

	.zo-game-root--kelime-karistirma .zo-kk-scrambled {
		font-size: 28px;
		letter-spacing: 2px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--kelime-karistirma');

	games.forEach(function (game) {
		const words = [
			{ word: 'kitap', hint: 'Okumak için kullanılır.' },
			{ word: 'kalem', hint: 'Yazı yazmaya yarar.' },
			{ word: 'masa', hint: 'Üstünde bir şeyler durur.' },
			{ word: 'sandalye', hint: 'Üzerine oturulur.' },
			{ word: 'elma', hint: 'Kırmızı veya yeşil olabilir.' },
			{ word: 'armut', hint: 'Meyvedir.' },
			{ word: 'muz', hint: 'Sarı meyvedir.' },
			{ word: 'kiraz', hint: 'Küçük kırmızı meyvedir.' },
			{ word: 'karpuz', hint: 'Yaz meyvesidir.' },
			{ word: 'portakal', hint: 'Turuncu renkli bir meyvedir.' },
			{ word: 'okul', hint: 'Ders yapılan yer.' },
			{ word: 'defter', hint: 'Yazı yazmak için kullanılır.' },
			{ word: 'silgi', hint: 'Yanlış yazıyı düzeltir.' },
			{ word: 'oyuncak', hint: 'Çocuklar bununla oynar.' },
			{ word: 'araba', hint: 'Yolda gider.' },
			{ word: 'bisiklet', hint: 'Pedalı vardır.' },
			{ word: 'tren', hint: 'Rayda gider.' },
			{ word: 'uçak', hint: 'Gökyüzünde uçar.' },
			{ word: 'kedi', hint: 'Miyav der.' },
			{ word: 'köpek', hint: 'Hav hav der.' },
			{ word: 'kuş', hint: 'Kanadı vardır.' },
			{ word: 'balık', hint: 'Suda yaşar.' },
			{ word: 'çiçek', hint: 'Bahçede büyür.' },
			{ word: 'güneş', hint: 'Gökyüzünde parlar.' },
			{ word: 'yağmur', hint: 'Buluttan düşer.' },
			{ word: 'bulut', hint: 'Gökyüzünde gezer.' },
			{ word: 'deniz', hint: 'Büyük su alanıdır.' },
			{ word: 'orman', hint: 'Çok ağaçlı yerdir.' },
			{ word: 'bardak', hint: 'Su içmek için kullanılır.' },
			{ word: 'tabak', hint: 'Yemek bunun üstüne konur.' }
		];

		const scrambledEl = game.querySelector('.zo-kk-scrambled');
		const hintEl = game.querySelector('.zo-kk-hint');
		const inputEl = game.querySelector('.zo-kk-input');
		const messageEl = game.querySelector('.zo-kk-message');
		const scoreEl = game.querySelector('.zo-kk-score');
		const roundEl = game.querySelector('.zo-kk-round');
		const solvedEl = game.querySelector('.zo-kk-solved');
		const guessButton = game.querySelector('.zo-kk-button--guess');
		const hintButton = game.querySelector('.zo-kk-button--hint');
		const nextButton = game.querySelector('.zo-kk-button--next');
		const restartButton = game.querySelector('.zo-kk-button--restart');

		let score = 0;
		let round = 0;
		let solved = 0;
		let current = null;
		let currentScrambled = '';
		let hintUsed = false;
		let answered = false;
		let order = [];

		function shuffle(array) {
			const copy = array.slice();
			for (let i = copy.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				const temp = copy[i];
				copy[i] = copy[j];
				copy[j] = temp;
			}
			return copy;
		}

		function scrambleWord(word) {
			let result = word;
			let tries = 0;

			while (result === word && tries < 20) {
				result = shuffle(word.split('')).join('');
				tries += 1;
			}

			return result;
		}

		function setMessage(text, type) {
			messageEl.textContent = text;
			messageEl.className = 'zo-kk-message';
			if (type) {
				messageEl.classList.add(type);
			}
		}

		function normalizeText(text) {
			return text
				.toLocaleLowerCase('tr-TR')
				.replace(/\s+/g, '')
				.trim();
		}

		function updateStats() {
			scoreEl.textContent = String(score);
			roundEl.textContent = String(round);
			solvedEl.textContent = String(solved);
		}

		function loadNextWord() {
			if (!order.length) {
				order = shuffle(words);
			}

			current = order.pop();
			currentScrambled = scrambleWord(current.word);
			hintUsed = false;
			answered = false;
			round += 1;

			scrambledEl.textContent = currentScrambled.toLocaleUpperCase('tr-TR');
			hintEl.textContent = '';
			inputEl.value = '';
			inputEl.disabled = false;
			guessButton.disabled = false;
			hintButton.disabled = false;
			nextButton.disabled = true;

			setMessage('Karışık kelimeyi bul.', 'is-info');
			updateStats();
			inputEl.focus();
		}

		function guessWord() {
			if (!current || answered) {
				return;
			}

			const guess = normalizeText(inputEl.value);
			const answer = normalizeText(current.word);

			if (!guess) {
				setMessage('Bir tahmin yaz.', 'is-warn');
				return;
			}

			if (guess === answer) {
				answered = true;
				solved += 1;
				score += hintUsed ? 1 : 2;

				setMessage('Doğru bildin: ' + current.word.toLocaleUpperCase('tr-TR'), 'is-good');
				scrambledEl.textContent = current.word.toLocaleUpperCase('tr-TR');
				inputEl.disabled = true;
				guessButton.disabled = true;
				hintButton.disabled = true;
				nextButton.disabled = false;
				updateStats();
			} else {
				setMessage('Yanlış tahmin. Tekrar dene.', 'is-bad');
			}
		}

		function showHint() {
			if (!current || answered || hintUsed) {
				return;
			}

			hintUsed = true;
			hintEl.textContent = 'İpucu: ' + current.hint;
			setMessage('İpucu açıldı. Bu tur 1 puan değerinde.', 'is-warn');
		}

		function restartGame() {
			score = 0;
			round = 0;
			solved = 0;
			order = shuffle(words);
			updateStats();
			loadNextWord();
		}

		guessButton.addEventListener('click', guessWord);
		hintButton.addEventListener('click', showHint);
		nextButton.addEventListener('click', loadNextWord);
		restartButton.addEventListener('click', restartGame);

		inputEl.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				guessWord();
			}
		});

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_kelime_karistirma_render')) {
	function zo_game_kelime_karistirma_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-kelime-karistirma-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--kelime-karistirma" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-kk-title">Kelime Karıştırma</h2>
			<p class="zo-kk-desc">Karışmış harflere bak. Doğru Türkçe kelimeyi tahmin et. İpucu kullanırsan daha az puan alırsın.</p>

			<div class="zo-kk-top">
				<div class="zo-kk-stat">
					<span class="zo-kk-stat-label">Puan</span>
					<span class="zo-kk-stat-value zo-kk-score">0</span>
				</div>
				<div class="zo-kk-stat">
					<span class="zo-kk-stat-label">Tur</span>
					<span class="zo-kk-stat-value zo-kk-round">0</span>
				</div>
				<div class="zo-kk-stat">
					<span class="zo-kk-stat-label">Doğru</span>
					<span class="zo-kk-stat-value zo-kk-solved">0</span>
				</div>
			</div>

			<div class="zo-kk-card">
				<span class="zo-kk-label">Karışık Kelime</span>
				<div class="zo-kk-scrambled">-</div>
				<div class="zo-kk-hint"></div>
			</div>

			<div class="zo-kk-input-row">
				<input type="text" class="zo-kk-input" placeholder="Tahminini yaz" />
				<button type="button" class="zo-kk-button zo-kk-button--guess">Tahmin Et</button>
				<button type="button" class="zo-kk-button zo-kk-button--hint">İpucu</button>
				<button type="button" class="zo-kk-button zo-kk-button--next" disabled>Sonraki</button>
			</div>

			<div class="zo-kk-message" aria-live="polite"></div>

			<div class="zo-kk-bottom">
				<button type="button" class="zo-kk-button zo-kk-button--restart">Baştan Başla</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'kelime-karistirma',
	'name'            => 'Kelime Karıştırma',
	'author'          => 'Asker',
	'description'     => 'Çocuklar için Türkçe kelime tahmin etme oyunu. Karışık harfleri çöz, ipucu kullan, puan topla.',
	'render_callback' => 'zo_game_kelime_karistirma_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);