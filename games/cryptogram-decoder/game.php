<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 520px;
	margin: 0 auto;
	padding: 1rem;
	border: 2px solid #3a4a76;
	border-radius: 14px;
	background: #f9fbff;
	font-family: Arial, sans-serif;
	color: #1f2c4d;
}

.zo-game-root__title {
	font-size: 1.4rem;
	font-weight: bold;
	margin-bottom: 0.75rem;
}

.zo-game-root__instructions,
.zo-game-root__status {
	font-size: 0.95rem;
	margin-bottom: 0.8rem;
}

.zo-game-root__cipher,
.zo-game-root__answer {
	width: 100%;
	box-sizing: border-box;
	padding: 0.75rem;
	border-radius: 10px;
	border: 1px solid #97a3c6;
	background: #eef2ff;
	font-size: 0.95rem;
	margin-bottom: 0.8rem;
}

.zo-game-root__answer {
	min-height: 120px;
	resize: vertical;
}

.zo-game-root__controls {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 0.75rem;
}

.zo-game-root__button {
	appearance: none;
	border: none;
	border-radius: 10px;
	padding: 0.9rem 1rem;
	font-size: 0.95rem;
	font-weight: 600;
	cursor: pointer;
	color: #fff;
	background: #3a4a76;
	transition: background 0.2s ease;
}

.zo-game-root__button:hover {
	background: #283861;
}

.zo-game-root__small {
	font-size: 0.85rem;
	color: #5a6586;
	margin-top: -0.4rem;
}

.zo-game-root__result {
	margin-top: 0.9rem;
	padding: 0.9rem;
	border-radius: 10px;
	font-weight: 600;
}

.zo-game-root__result--success {
	background: #d0f0d9;
	color: #205d34;
}

.zo-game-root__result--error {
	background: #ffe3dd;
	color: #8a2a23;
}

@media (max-width: 520px) {
	.zo-game-root {
		padding: 0.9rem;
	}

	.zo-game-root__controls {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--cryptogram-decoder');

	function shuffleArray(array) {
		for (let i = array.length - 1; i > 0; i--) {
			const j = Math.floor(Math.random() * (i + 1));
			[array[i], array[j]] = [array[j], array[i]];
		}
		return array;
	}

	function createCipher(plain) {
		const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
		const shuffled = shuffleArray(letters.slice());
		const mapping = {};
		letters.forEach(function (letter, index) {
			mapping[letter] = shuffled[index];
		});

		const cipherText = plain.split('').map(function (char) {
			const upper = char.toUpperCase();
			return mapping[upper] || char;
		}).join('');

		return {
			cipher: cipherText,
			mapping: mapping,
		};
	}

	function normalizeText(text) {
		return text.replace(/\s+/g, ' ').trim();
	}

	games.forEach(function (game) {
		const phraseList = [
			'BRAIN TEASERS MAKE ME SMILE',
			'SECRET CODE SOLVES THE PUZZLE',
			'FIND THE LETTERS AND DECODE',
			'KEEP CALM AND GUESS THE WORD',
			'GAME TIME IS GREAT FOR THINKING'
		];

		const phrase = phraseList[Math.floor(Math.random() * phraseList.length)];
		const cipherData = createCipher(phrase);

		const cipherElement = game.querySelector('.zo-game-root__cipher');
		const answerElement = game.querySelector('.zo-game-root__answer');
		const statusElement = game.querySelector('.zo-game-root__status');
		const resultElement = game.querySelector('.zo-game-root__result');
		const submitButton = game.querySelector('.zo-game-root__submit');
		const revealButton = game.querySelector('.zo-game-root__reveal');
		const restartButton = game.querySelector('.zo-game-root__restart');

		cipherElement.textContent = cipherData.cipher;
		statusElement.textContent = 'Decode the message by replacing each cipher letter with the correct plain letter.';
		resultElement.textContent = '';
		resultElement.className = 'zo-game-root__result';

		submitButton.addEventListener('click', function () {
			const guess = normalizeText(answerElement.value.toUpperCase());
			const target = normalizeText(phrase.toUpperCase());

			if (!guess) {
				resultElement.textContent = 'Write your decoded phrase first.';
				resultElement.className = 'zo-game-root__result zo-game-root__result--error';
				return;
			}

			if (guess === target) {
				resultElement.textContent = 'Correct! You cracked the cryptogram. Great job!';
				resultElement.className = 'zo-game-root__result zo-game-root__result--success';
			} else {
				resultElement.textContent = 'Not quite yet. Check your letters and try again.';
				resultElement.className = 'zo-game-root__result zo-game-root__result--error';
			}
		});

		revealButton.addEventListener('click', function () {
			answerElement.value = phrase;
			resultElement.textContent = 'Here is the decoded phrase.';
			resultElement.className = 'zo-game-root__result zo-game-root__result--success';
		});

		restartButton.addEventListener('click', function () {
			const newPhrase = phraseList[Math.floor(Math.random() * phraseList.length)];
			const newCipher = createCipher(newPhrase);
			cipherElement.textContent = newCipher.cipher;
			answerElement.value = '';
			statusElement.textContent = 'Decode the message by replacing each cipher letter with the correct plain letter.';
			resultElement.textContent = '';
			resultElement.className = 'zo-game-root__result';
			return;
		});
	});
});
JS;

if (!function_exists('zo_game_cryptogram_decoder_render')) {
	function zo_game_cryptogram_decoder_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-cryptogram-decoder-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--cryptogram-decoder" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-game-root__title">Cryptogram Decoder</div>
			<div class="zo-game-root__instructions">A secret phrase is shown using a letter substitution cipher. Decode it and type the original message.</div>
			<pre class="zo-game-root__cipher" aria-label="Cipher text"></pre>
			<textarea class="zo-game-root__answer" placeholder="Type your decoded phrase here"></textarea>
			<div class="zo-game-root__small">Use the exact letters and spacing of the hidden message.</div>
			<div class="zo-game-root__controls">
				<button type="button" class="zo-game-root__button zo-game-root__submit">Check Answer</button>
				<button type="button" class="zo-game-root__button zo-game-root__reveal">Reveal Answer</button>
			</div>
			<div class="zo-game-root__controls" style="margin-top: 0.5rem;">
				<button type="button" class="zo-game-root__button zo-game-root__restart">New Puzzle</button>
			</div>
			<div class="zo-game-root__status"></div>
			<div class="zo-game-root__result"></div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'cryptogram-decoder',
	'name'            => 'Cryptogram Decoder',
	'author'          => 'Asker',
	'description'     => 'Decode a secret phrase using letter substitution and solve the cryptogram.',
	'render_callback' => 'zo_game_cryptogram_decoder_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
