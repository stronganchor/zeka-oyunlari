<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--falling-letters-catch .flc-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	text-align: center;
}

.zo-game-root--falling-letters-catch .flc-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	color: #1f2933;
}

.zo-game-root--falling-letters-catch .flc-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	color: #52606d;
}

.zo-game-root--falling-letters-catch .flc-topbar {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--falling-letters-catch .flc-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
}

.zo-game-root--falling-letters-catch .flc-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--falling-letters-catch .flc-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--falling-letters-catch .flc-target-wrap {
	background: #f8fbff;
	border: 2px dashed #9fb3c8;
	border-radius: 18px;
	padding: 14px;
	margin-bottom: 14px;
}

.zo-game-root--falling-letters-catch .flc-target-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #7b8794;
	margin-bottom: 6px;
	text-transform: uppercase;
	letter-spacing: 0.04em;
}

.zo-game-root--falling-letters-catch .flc-target {
	font-size: 34px;
	font-weight: 700;
	line-height: 1.2;
	color: #7c3aed;
	word-break: break-word;
}

.zo-game-root--falling-letters-catch .flc-status {
	min-height: 28px;
	margin-bottom: 14px;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--falling-letters-catch .flc-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--falling-letters-catch .flc-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--falling-letters-catch .flc-field {
	position: relative;
	height: 380px;
	border-radius: 18px;
	border: 3px solid #bcccdc;
	background: linear-gradient(to bottom, #eff6ff 0%, #dbeafe 100%);
	overflow: hidden;
	margin-bottom: 16px;
	touch-action: none;
}

.zo-game-root--falling-letters-catch .flc-letter {
	position: absolute;
	width: 42px;
	height: 42px;
	border-radius: 12px;
	background: #2563eb;
	color: #ffffff;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 24px;
	font-weight: 700;
	user-select: none;
	box-shadow: 0 6px 12px rgba(37, 99, 235, 0.22);
}

.zo-game-root--falling-letters-catch .flc-letter.is-target {
	background: #0b6e4f;
}

.zo-game-root--falling-letters-catch .flc-letter.is-wrong {
	background: #ef4444;
}

.zo-game-root--falling-letters-catch .flc-basket {
	position: absolute;
	bottom: 12px;
	left: 50%;
	width: 96px;
	height: 26px;
	margin-left: -48px;
	border-radius: 14px 14px 18px 18px;
	background: #f59e0b;
	border: 3px solid #b45309;
	box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
}

.zo-game-root--falling-letters-catch .flc-basket::before {
	content: '';
	position: absolute;
	left: 12px;
	right: 12px;
	top: -10px;
	height: 10px;
	border: 3px solid #b45309;
	border-bottom: 0;
	border-radius: 12px 12px 0 0;
}

.zo-game-root--falling-letters-catch .flc-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--falling-letters-catch .flc-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--falling-letters-catch .flc-btn:hover,
.zo-game-root--falling-letters-catch .flc-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--falling-letters-catch .flc-btn--start {
	background: #2563eb;
	color: #ffffff;
}

.zo-game-root--falling-letters-catch .flc-btn--restart {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--falling-letters-catch .flc-progress {
	font-size: 14px;
	color: #52606d;
}

@media (max-width: 600px) {
	.zo-game-root--falling-letters-catch .flc-topbar {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--falling-letters-catch .flc-title {
		font-size: 24px;
	}

	.zo-game-root--falling-letters-catch .flc-target {
		font-size: 28px;
	}

	.zo-game-root--falling-letters-catch .flc-field {
		height: 340px;
	}

	.zo-game-root--falling-letters-catch .flc-letter {
		width: 38px;
		height: 38px;
		font-size: 22px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--falling-letters-catch');

	games.forEach(function (game) {
		const field = game.querySelector('.flc-field');
		const basket = game.querySelector('.flc-basket');
		const scoreEl = game.querySelector('.flc-score');
		const livesEl = game.querySelector('.flc-lives');
		const roundEl = game.querySelector('.flc-round');
		const caughtEl = game.querySelector('.flc-caught');
		const targetEl = game.querySelector('.flc-target');
		const statusEl = game.querySelector('.flc-status');
		const progressEl = game.querySelector('.flc-progress');
		const startBtn = game.querySelector('.flc-btn--start');
		const restartBtn = game.querySelector('.flc-btn--restart');

		const words = ['KEDİ', 'ELMA', 'OKUL', 'ARABA', 'KAPI', 'BALIK', 'KUŞ', 'AĞAÇ', 'ÇİÇEK', 'GÜNEŞ'];
		let round = 1;
		let score = 0;
		let lives = 3;
		let targetWord = '';
		let targetIndex = 0;
		let spawnTimer = null;
		let gameTimer = null;
		let running = false;
		let basketX = 0;
		let fieldWidth = 0;
		let activeLetters = [];
		let caughtThisRound = '';
		let roundFinished = false;

		function randomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

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
			roundEl.textContent = String(round);
			caughtEl.textContent = caughtThisRound || '-';
			progressEl.textContent = 'Catch letters in order to spell the word';
		}

		function refreshFieldMeasurements() {
			fieldWidth = field.clientWidth;
		}

		function setBasketPosition(x) {
			refreshFieldMeasurements();
			const basketWidth = basket.offsetWidth;
			const minX = 0;
			const maxX = Math.max(0, fieldWidth - basketWidth);
			basketX = Math.max(minX, Math.min(maxX, x));
			basket.style.left = basketX + 'px';
			basket.style.marginLeft = '0';
		}

		function centerBasket() {
			refreshFieldMeasurements();
			setBasketPosition((fieldWidth - basket.offsetWidth) / 2);
		}

		function clearLetters() {
			activeLetters.forEach(function (item) {
				if (item.el && item.el.parentNode) {
					item.el.parentNode.removeChild(item.el);
				}
			});
			activeLetters = [];
		}

		function stopTimers() {
			if (spawnTimer) {
				clearInterval(spawnTimer);
				spawnTimer = null;
			}
			if (gameTimer) {
				cancelAnimationFrame(gameTimer);
				gameTimer = null;
			}
		}

		function buildSpawnLetter() {
			const shouldSpawnTarget = Math.random() < 0.45;
			const alphabet = ['A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L', 'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'];
			let letter = '';
			let isTarget = false;

			if (shouldSpawnTarget && targetIndex < targetWord.length) {
				letter = targetWord.charAt(targetIndex);
				isTarget = true;
			} else {
				letter = alphabet[randomInt(0, alphabet.length - 1)];
				if (targetIndex < targetWord.length && letter === targetWord.charAt(targetIndex)) {
					letter = alphabet[(alphabet.indexOf(letter) + 3) % alphabet.length];
				}
			}

			return {
				letter: letter,
				isTarget: isTarget
			};
		}

		function spawnLetter() {
			if (!running || roundFinished) {
				return;
			}

			refreshFieldMeasurements();

			const data = buildSpawnLetter();
			const el = document.createElement('div');
			el.className = 'flc-letter';
			el.textContent = data.letter;

			if (data.isTarget) {
				el.classList.add('is-target');
			}

			field.appendChild(el);

			const maxLeft = Math.max(0, field.clientWidth - el.offsetWidth);
			const x = randomInt(0, maxLeft);
			const speed = randomInt(2, 4) + (round * 0.2);

			el.style.left = x + 'px';
			el.style.top = '-46px';

			activeLetters.push({
				el: el,
				x: x,
				y: -46,
				speed: speed,
				letter: data.letter,
				isTarget: data.isTarget
			});
		}

		function removeLetterAt(index) {
			if (activeLetters[index] && activeLetters[index].el && activeLetters[index].el.parentNode) {
				activeLetters[index].el.parentNode.removeChild(activeLetters[index].el);
			}
			activeLetters.splice(index, 1);
		}

		function finishRound(winRound) {
			roundFinished = true;
			running = false;
			stopTimers();
			clearLetters();

			if (winRound) {
				score += 1;
				setStatus('Great job. You spelled ' + targetWord + '.', 'good');
				updateStats();

				window.setTimeout(function () {
					round += 1;
					beginRound();
				}, 900);
			} else {
				updateStats();

				if (lives <= 0) {
					targetEl.textContent = 'Game Over';
					setStatus('You ran out of lives. Final score: ' + score, 'bad');
					progressEl.textContent = 'Press Restart to play again';
				} else {
					setStatus('Try the next word.', 'bad');
					window.setTimeout(function () {
						round += 1;
						beginRound();
					}, 900);
				}
			}
		}

		function handleCatch(item) {
			const nextLetter = targetWord.charAt(targetIndex);

			if (item.letter === nextLetter) {
				caughtThisRound += item.letter;
				targetIndex += 1;
				setStatus('Nice. Keep going.', 'good');
				updateStats();

				if (targetIndex >= targetWord.length) {
					finishRound(true);
				}
			} else {
				lives -= 1;
				setStatus('Wrong letter. You needed ' + nextLetter + '.', 'bad');
				updateStats();

				if (lives <= 0) {
					finishRound(false);
				}
			}
		}

		function tick() {
			if (!running) {
				return;
			}

			const basketTop = field.clientHeight - basket.offsetHeight - 12;
			const basketLeft = basketX;
			const basketRight = basketX + basket.offsetWidth;

			for (let i = activeLetters.length - 1; i >= 0; i--) {
				const item = activeLetters[i];
				item.y += item.speed;
				item.el.style.top = item.y + 'px';

				const letterLeft = item.x;
				const letterRight = item.x + item.el.offsetWidth;
				const letterBottom = item.y + item.el.offsetHeight;

				const overlapsHorizontally = letterRight >= basketLeft && letterLeft <= basketRight;
				const reachesBasket = letterBottom >= basketTop && item.y <= basketTop + basket.offsetHeight;

				if (overlapsHorizontally && reachesBasket) {
					handleCatch(item);
					removeLetterAt(i);
					continue;
				}

				if (item.y > field.clientHeight + 10) {
					removeLetterAt(i);
				}
			}

			gameTimer = requestAnimationFrame(tick);
		}

		function beginRound() {
			stopTimers();
			clearLetters();
			roundFinished = false;

			if (lives <= 0) {
				running = false;
				targetEl.textContent = 'Game Over';
				setStatus('You ran out of lives. Final score: ' + score, 'bad');
				progressEl.textContent = 'Press Restart to play again';
				return;
			}

			if (round > words.length) {
				running = false;
				targetEl.textContent = 'Finished';
				setStatus('Amazing. Final score: ' + score + ' / ' + words.length, 'good');
				progressEl.textContent = 'Press Restart to play again';
				updateStats();
				return;
			}

			targetWord = words[round - 1];
			targetIndex = 0;
			caughtThisRound = '';
			targetEl.textContent = targetWord;
			updateStats();
			centerBasket();
			setStatus('Catch these letters in order: ' + targetWord, '');
		}

		function startRound() {
			if (running || roundFinished || lives <= 0 || round > words.length) {
				return;
			}

			running = true;
			setStatus('Move the basket and catch the right letters.', '');
			spawnLetter();
			spawnTimer = setInterval(spawnLetter, Math.max(650, 1150 - (round * 40)));
			gameTimer = requestAnimationFrame(tick);
		}

		function restartGame() {
			stopTimers();
			clearLetters();
			round = 1;
			score = 0;
			lives = 3;
			targetWord = '';
			targetIndex = 0;
			caughtThisRound = '';
			running = false;
			roundFinished = false;
			beginRound();
		}

		function moveBasketByClientX(clientX) {
			const rect = field.getBoundingClientRect();
			const basketWidth = basket.offsetWidth;
			const x = clientX - rect.left - (basketWidth / 2);
			setBasketPosition(x);
		}

		field.addEventListener('mousemove', function (event) {
			moveBasketByClientX(event.clientX);
		});

		field.addEventListener('touchmove', function (event) {
			if (event.touches && event.touches[0]) {
				moveBasketByClientX(event.touches[0].clientX);
			}
		}, { passive: true });

		field.addEventListener('click', function (event) {
			moveBasketByClientX(event.clientX);
		});

		startBtn.addEventListener('click', startRound);
		restartBtn.addEventListener('click', restartGame);

		window.addEventListener('resize', function () {
			centerBasket();
		});

		restartGame();
	});
});
JS;

if (!function_exists('zo_game_falling_letters_catch_render')) {
	function zo_game_falling_letters_catch_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-falling-letters-catch-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--falling-letters-catch" id="<?php echo esc_attr($instance_id); ?>">
			<div class="flc-card">
				<h2 class="flc-title">Falling Letters Catch</h2>
				<p class="flc-instructions">Press Start. Move the basket to catch letters. Catch the letters in the correct order to spell the target word. Wrong letters cost a life.</p>

				<div class="flc-topbar">
					<div class="flc-stat">
						<span class="flc-stat-label">Score</span>
						<span class="flc-stat-value flc-score">0</span>
					</div>
					<div class="flc-stat">
						<span class="flc-stat-label">Lives</span>
						<span class="flc-stat-value flc-lives">3</span>
					</div>
					<div class="flc-stat">
						<span class="flc-stat-label">Round</span>
						<span class="flc-stat-value flc-round">1</span>
					</div>
					<div class="flc-stat">
						<span class="flc-stat-label">Caught</span>
						<span class="flc-stat-value flc-caught">-</span>
					</div>
				</div>

				<div class="flc-target-wrap">
					<span class="flc-target-label">Catch this word</span>
					<div class="flc-target">KEDİ</div>
				</div>

				<div class="flc-status" aria-live="polite">Catch these letters in order.</div>

				<div class="flc-field">
					<div class="flc-basket"></div>
				</div>

				<div class="flc-actions">
					<button type="button" class="flc-btn flc-btn--start">Start</button>
					<button type="button" class="flc-btn flc-btn--restart">Restart</button>
				</div>

				<div class="flc-progress">Catch letters in order to spell the word</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'falling-letters-catch',
	'name'            => 'Falling Letters Catch',
	'author'          => 'Arslan',
	'description'     => 'Catch falling letters in the correct order to spell the target word.',
	'render_callback' => 'zo_game_falling_letters_catch_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);