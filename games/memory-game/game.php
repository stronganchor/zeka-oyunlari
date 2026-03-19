<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--memory-match-animals {
	max-width: 760px;
	margin: 0 auto;
	padding: 18px;
	border-radius: 18px;
	border: 2px solid #d9e2ec;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--memory-match-animals .zo-mma-header {
	text-align: center;
	margin-bottom: 16px;
}

.zo-game-root--memory-match-animals .zo-mma-title {
	margin: 0 0 8px;
	font-size: 30px;
	line-height: 1.2;
	color: #1f2937;
}

.zo-game-root--memory-match-animals .zo-mma-instructions {
	margin: 0;
	font-size: 15px;
	line-height: 1.5;
	color: #4b5563;
}

.zo-game-root--memory-match-animals .zo-mma-toolbar {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
	align-items: stretch;
}

.zo-game-root--memory-match-animals .zo-mma-stat,
.zo-game-root--memory-match-animals .zo-mma-button {
	border-radius: 14px;
	padding: 12px 14px;
	box-sizing: border-box;
}

.zo-game-root--memory-match-animals .zo-mma-stat {
	background: #f4f7fb;
	border: 2px solid #d7e0ea;
	text-align: center;
}

.zo-game-root--memory-match-animals .zo-mma-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--memory-match-animals .zo-mma-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	color: #111827;
	line-height: 1.1;
}

.zo-game-root--memory-match-animals .zo-mma-button {
	border: 0;
	background: #2997aa;
	color: #ffffff;
	font-size: 17px;
	font-weight: 700;
	cursor: pointer;
	width: 100%;
}

.zo-game-root--memory-match-animals .zo-mma-grid {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--memory-match-animals .zo-mma-card {
	appearance: none;
	-webkit-appearance: none;
	border: 2px solid #cbd5e1;
	border-radius: 16px;
	background: #aab3bf;
	color: #111827;
	min-height: 110px;
	padding: 8px;
	font-size: 18px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
	transition: transform 0.15s ease, background-color 0.15s ease, border-color 0.15s ease;
	display: flex;
	align-items: center;
	justify-content: center;
	text-align: center;
	line-height: 1.2;
}

.zo-game-root--memory-match-animals .zo-mma-card:hover,
.zo-game-root--memory-match-animals .zo-mma-card:focus {
	transform: translateY(-1px);
	outline: none;
}

.zo-game-root--memory-match-animals .zo-mma-card.is-hidden {
	background: #aab3bf;
	border-color: #97a2b1;
	color: #111827;
	font-size: 42px;
}

.zo-game-root--memory-match-animals .zo-mma-card.is-open {
	background: #ffffff;
	border-color: #2997aa;
	color: #111827;
	font-size: 17px;
}

.zo-game-root--memory-match-animals .zo-mma-card.is-matched {
	background: #d9f7df;
	border-color: #78c28b;
	color: #14532d;
	font-size: 17px;
	cursor: default;
}

.zo-game-root--memory-match-animals .zo-mma-status {
	margin-top: 14px;
	min-height: 24px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--memory-match-animals .zo-mma-status.is-win {
	color: #166534;
}

@media (max-width: 640px) {
	.zo-game-root.zo-game-root--memory-match-animals {
		padding: 14px;
	}

	.zo-game-root--memory-match-animals .zo-mma-title {
		font-size: 25px;
	}

	.zo-game-root--memory-match-animals .zo-mma-toolbar {
		grid-template-columns: 1fr;
	}

	.zo-game-root--memory-match-animals .zo-mma-grid {
		grid-template-columns: repeat(4, minmax(0, 1fr));
		gap: 8px;
	}

	.zo-game-root--memory-match-animals .zo-mma-card {
		min-height: 78px;
		padding: 6px;
	}

	.zo-game-root--memory-match-animals .zo-mma-card.is-hidden {
		font-size: 34px;
	}

	.zo-game-root--memory-match-animals .zo-mma-card.is-open,
	.zo-game-root--memory-match-animals .zo-mma-card.is-matched {
		font-size: 13px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--memory-match-animals');

	games.forEach(function (game) {
		const attemptsEl = game.querySelector('.zo-mma-attempts');
		const timeEl = game.querySelector('.zo-mma-time');
		const statusEl = game.querySelector('.zo-mma-status');
		const newGameButton = game.querySelector('.zo-mma-button');
		const grid = game.querySelector('.zo-mma-grid');

		const animals = [
			'Cat', 'Dog', 'Lion', 'Elephant',
			'Tiger', 'Giraffe', 'Koala', 'Panda',
			'Zebra', 'Fox', 'Bear', 'Frog',
			'Otter', 'Rhino', 'Hippo', 'Wolf'
		];

		let deck = [];
		let openCards = [];
		let matchedCount = 0;
		let attempts = 0;
		let startTime = 0;
		let timerId = null;
		let lockBoard = false;

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

		function updateAttempts() {
			attemptsEl.textContent = String(attempts);
		}

		function updateTime() {
			const elapsed = Math.floor((Date.now() - startTime) / 1000);
			timeEl.textContent = elapsed + 's';
		}

		function stopTimer() {
			if (timerId) {
				clearInterval(timerId);
				timerId = null;
			}
		}

		function startTimer() {
			stopTimer();
			startTime = Date.now();
			updateTime();
			timerId = setInterval(updateTime, 1000);
		}

		function setStatus(message, isWin) {
			statusEl.textContent = message;
			if (isWin) {
				statusEl.classList.add('is-win');
			} else {
				statusEl.classList.remove('is-win');
			}
		}

		function createCard(cardData, index) {
			const button = document.createElement('button');
			button.type = 'button';
			button.className = 'zo-mma-card is-hidden';
			button.setAttribute('data-animal', cardData.name);
			button.setAttribute('data-index', String(index));
			button.setAttribute('aria-label', 'Hidden card');
			button.textContent = '?';

			button.addEventListener('click', function () {
				if (lockBoard) {
					return;
				}

				if (button.classList.contains('is-matched') || button.classList.contains('is-open')) {
					return;
				}

				revealCard(button);

				openCards.push(button);

				if (openCards.length === 2) {
					lockBoard = true;
					attempts += 1;
					updateAttempts();

					const first = openCards[0];
					const second = openCards[1];

					if (first.getAttribute('data-animal') === second.getAttribute('data-animal')) {
						first.classList.remove('is-open');
						second.classList.remove('is-open');
						first.classList.add('is-matched');
						second.classList.add('is-matched');
						first.disabled = true;
						second.disabled = true;
						matchedCount += 2;
						openCards = [];
						lockBoard = false;
						setStatus('Great job. You found a match.', false);

						if (matchedCount === deck.length) {
							stopTimer();
							const finalTime = Math.floor((Date.now() - startTime) / 1000);
							setStatus('You matched all pairs in ' + attempts + ' attempts over ' + finalTime + ' seconds.', true);
						}
					} else {
						setStatus('Not a match. Try again.', false);
						setTimeout(function () {
							hideCard(first);
							hideCard(second);
							openCards = [];
							lockBoard = false;
						}, 650);
					}
				}
			});

			return button;
		}

		function revealCard(button) {
			button.classList.remove('is-hidden');
			button.classList.add('is-open');
			button.textContent = button.getAttribute('data-animal');
			button.setAttribute('aria-label', button.getAttribute('data-animal'));
		}

		function hideCard(button) {
			button.classList.remove('is-open');
			button.classList.add('is-hidden');
			button.textContent = '?';
			button.setAttribute('aria-label', 'Hidden card');
		}

		function newGame() {
			const selected = shuffle(animals).slice(0, 8);
			deck = shuffle(selected.concat(selected).map(function (name) {
				return { name: name };
			}));

			openCards = [];
			matchedCount = 0;
			attempts = 0;
			lockBoard = false;
			updateAttempts();
			grid.innerHTML = '';
			setStatus('Find all the matching animal pairs.', false);

			deck.forEach(function (cardData, index) {
				grid.appendChild(createCard(cardData, index));
			});

			startTimer();
		}

		newGameButton.addEventListener('click', newGame);
		newGame();
	});
});
JS;

if (!function_exists('zo_game_memory_match_animals_render')) {
	function zo_game_memory_match_animals_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-memory-match-animals-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--memory-match-animals" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-mma-header">
				<h2 class="zo-mma-title">Memory Match Animals</h2>
				<p class="zo-mma-instructions">Tap two cards to find matching animal pairs. Match all the cards to win.</p>
			</div>

			<div class="zo-mma-toolbar">
				<div class="zo-mma-stat">
					<span class="zo-mma-stat-label">Attempts</span>
					<span class="zo-mma-stat-value zo-mma-attempts">0</span>
				</div>

				<div class="zo-mma-stat">
					<span class="zo-mma-stat-label">Time</span>
					<span class="zo-mma-stat-value zo-mma-time">0s</span>
				</div>

				<div>
					<button type="button" class="zo-mma-button">New Game</button>
				</div>
			</div>

			<div class="zo-mma-grid" aria-live="polite"></div>
			<div class="zo-mma-status">Find all the matching animal pairs.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'memory-match-animals',
	'name'            => 'Memory Match Animals',
	'author'          => 'Asker',
	'description'     => 'A memory matching card game for kids with animal pairs, attempts, timer, and restart.',
	'render_callback' => 'zo_game_memory_match_animals_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);