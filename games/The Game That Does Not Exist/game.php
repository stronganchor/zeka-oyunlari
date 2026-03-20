<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 560px;
	margin: 0 auto;
	text-align: center;
	font-family: Arial, sans-serif;
}

.zo-game-root--game-does-not-exist .zo-gdne-card {
	background: #ffffff;
	border: 3px solid #222;
	border-radius: 18px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--game-does-not-exist .zo-gdne-title {
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 10px;
	color: #222;
}

.zo-game-root--game-does-not-exist .zo-gdne-subtitle {
	font-size: 16px;
	line-height: 1.5;
	margin: 0 0 16px;
	color: #444;
}

.zo-game-root--game-does-not-exist .zo-gdne-status {
	min-height: 28px;
	font-size: 18px;
	font-weight: 700;
	margin: 12px 0 16px;
	color: #0b5;
}

.zo-game-root--game-does-not-exist .zo-gdne-stats {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--game-does-not-exist .zo-gdne-stat {
	background: #f4f4f4;
	border: 2px solid #ddd;
	border-radius: 999px;
	padding: 8px 14px;
	font-size: 14px;
	font-weight: 700;
	color: #333;
}

.zo-game-root--game-does-not-exist .zo-gdne-board {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--game-does-not-exist .zo-gdne-door {
	appearance: none;
	border: 3px solid #222;
	background: linear-gradient(180deg, #5ea8ff 0%, #2d73d6 100%);
	color: #fff;
	border-radius: 16px;
	min-height: 110px;
	font-size: 18px;
	font-weight: 700;
	cursor: pointer;
	padding: 10px;
	transition: transform 0.12s ease, opacity 0.12s ease;
}

.zo-game-root--game-does-not-exist .zo-gdne-door:hover,
.zo-game-root--game-does-not-exist .zo-gdne-door:focus {
	transform: translateY(-2px);
	outline: none;
}

.zo-game-root--game-does-not-exist .zo-gdne-door.is-found {
	background: linear-gradient(180deg, #50d88a 0%, #1fa95a 100%);
}

.zo-game-root--game-does-not-exist .zo-gdne-door.is-miss {
	background: linear-gradient(180deg, #ffb14a 0%, #e57b11 100%);
}

.zo-game-root--game-does-not-exist .zo-gdne-actions {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--game-does-not-exist .zo-gdne-btn {
	appearance: none;
	border: 2px solid #222;
	background: #222;
	color: #fff;
	border-radius: 999px;
	padding: 10px 16px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--game-does-not-exist .zo-gdne-btn:hover,
.zo-game-root--game-does-not-exist .zo-gdne-btn:focus {
	background: #000;
	outline: none;
}

.zo-game-root--game-does-not-exist .zo-gdne-help {
	margin-top: 14px;
	font-size: 14px;
	color: #555;
	line-height: 1.5;
}

@media (max-width: 480px) {
	.zo-game-root--game-does-not-exist .zo-gdne-board {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--game-does-not-exist .zo-gdne-door {
		min-height: 95px;
		font-size: 16px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--game-does-not-exist');

	games.forEach(function (game) {
		const doors = Array.prototype.slice.call(game.querySelectorAll('.zo-gdne-door'));
		const statusEl = game.querySelector('.zo-gdne-status');
		const roundEl = game.querySelector('.zo-gdne-round-value');
		const scoreEl = game.querySelector('.zo-gdne-score-value');
		const livesEl = game.querySelector('.zo-gdne-lives-value');
		const restartBtn = game.querySelector('.zo-gdne-restart');
		const hintBtn = game.querySelector('.zo-gdne-hint');

		let round = 1;
		let score = 0;
		let lives = 3;
		let winningIndex = 0;
		let locked = false;

		function shuffleGoal() {
			winningIndex = Math.floor(Math.random() * doors.length);
		}

		function resetDoorLabels() {
			doors.forEach(function (door, index) {
				door.disabled = false;
				door.classList.remove('is-found');
				door.classList.remove('is-miss');
				door.textContent = 'Door ' + (index + 1);
				door.setAttribute('aria-label', 'Door ' + (index + 1));
			});
		}

		function updateStats() {
			roundEl.textContent = String(round);
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function startRound() {
			locked = false;
			resetDoorLabels();
			shuffleGoal();
			updateStats();
			setStatus('Find the missing game.');
		}

		function endGame(win) {
			locked = true;

			doors.forEach(function (door, index) {
				door.disabled = true;
				if (index === winningIndex) {
					door.classList.add('is-found');
					door.textContent = 'FOUND';
				}
			});

			if (win) {
				setStatus('You won. The missing game exists now.');
			} else {
				setStatus('Game over. The missing game got away.');
			}
		}

		doors.forEach(function (door, index) {
			door.addEventListener('click', function () {
				if (locked) {
					return;
				}

				if (index === winningIndex) {
					door.classList.add('is-found');
					door.textContent = 'FOUND';
					score += 1;
					locked = true;
					updateStats();

					if (score >= 5) {
						endGame(true);
						return;
					}

					setStatus('You found it. Next round...');
					setTimeout(function () {
						round += 1;
						startRound();
					}, 900);
				} else {
					door.classList.add('is-miss');
					door.textContent = 'EMPTY';
					door.disabled = true;
					lives -= 1;
					updateStats();

					if (lives <= 0) {
						endGame(false);
					} else {
						setStatus('No game there. Try again.');
					}
				}
			});
		});

		restartBtn.addEventListener('click', function () {
			round = 1;
			score = 0;
			lives = 3;
			startRound();
		});

		hintBtn.addEventListener('click', function () {
			if (locked) {
				return;
			}

			setStatus('Hint: the missing game moved behind one random door.');
			resetDoorLabels();
			shuffleGoal();
		});

		startRound();
	});
});
JS;

if (!function_exists('zo_game_game_does_not_exist_render')) {
	function zo_game_game_does_not_exist_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-game-does-not-exist-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--game-does-not-exist" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-gdne-card">
				<h2 class="zo-gdne-title">The Game That Does Not Exist</h2>
				<p class="zo-gdne-subtitle">A silly hide-and-seek game. Tap doors and try to find the missing game 5 times before you lose all 3 lives.</p>

				<div class="zo-gdne-stats">
					<div class="zo-gdne-stat">Round: <span class="zo-gdne-round-value">1</span></div>
					<div class="zo-gdne-stat">Score: <span class="zo-gdne-score-value">0</span></div>
					<div class="zo-gdne-stat">Lives: <span class="zo-gdne-lives-value">3</span></div>
				</div>

				<div class="zo-gdne-status" aria-live="polite">Find the missing game.</div>

				<div class="zo-gdne-board">
					<button type="button" class="zo-gdne-door">Door 1</button>
					<button type="button" class="zo-gdne-door">Door 2</button>
					<button type="button" class="zo-gdne-door">Door 3</button>
					<button type="button" class="zo-gdne-door">Door 4</button>
					<button type="button" class="zo-gdne-door">Door 5</button>
					<button type="button" class="zo-gdne-door">Door 6</button>
				</div>

				<div class="zo-gdne-actions">
					<button type="button" class="zo-gdne-btn zo-gdne-restart">Restart</button>
					<button type="button" class="zo-gdne-btn zo-gdne-hint">Shuffle Doors</button>
				</div>

				<div class="zo-gdne-help">Pick one door at a time. Empty doors cost a life. Found doors give a point.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'game-does-not-exist',
	'name'            => 'The Game That Does Not Exist',
	'author'          => 'Asker',
	'description'     => 'A funny hide-and-seek door game where players hunt for a missing game.',
	'render_callback' => 'zo_game_game_does_not_exist_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);