<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--duck-box-hunt * {
	box-sizing: border-box;
}

.zo-game-root--duck-box-hunt {
	max-width: 980px;
	margin: 0 auto;
	padding: 18px;
	font-family: Arial, sans-serif;
	color: #16324f;
}

.zo-game-root--duck-box-hunt .zo-dbh-shell {
	background: linear-gradient(180deg, #f6fbff 0%, #dff1ff 100%);
	border: 3px solid #16324f;
	border-radius: 28px;
	padding: 22px;
	box-shadow: 0 18px 38px rgba(22, 50, 79, 0.14);
}

.zo-game-root--duck-box-hunt .zo-dbh-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 34px;
	line-height: 1.15;
}

.zo-game-root--duck-box-hunt .zo-dbh-subtitle {
	margin: 0 auto 18px;
	max-width: 760px;
	text-align: center;
	font-size: 16px;
	line-height: 1.55;
	color: #35516f;
}

.zo-game-root--duck-box-hunt .zo-dbh-topbar {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 18px;
}

.zo-game-root--duck-box-hunt .zo-dbh-stat {
	background: rgba(255, 255, 255, 0.82);
	border: 2px solid #9cc7e8;
	border-radius: 18px;
	padding: 12px 14px;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--duck-box-hunt .zo-dbh-status {
	margin-bottom: 18px;
	min-height: 56px;
	padding: 14px 16px;
	background: #ffffff;
	border: 2px solid #9cc7e8;
	border-radius: 18px;
	font-size: 16px;
	font-weight: 700;
	line-height: 1.45;
	text-align: center;
}

.zo-game-root--duck-box-hunt .zo-dbh-board {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 14px;
	margin-bottom: 18px;
}

.zo-game-root--duck-box-hunt .zo-dbh-box {
	appearance: none;
	position: relative;
	border: 0;
	border-radius: 24px;
	background: transparent;
	padding: 0;
	cursor: pointer;
}

.zo-game-root--duck-box-hunt .zo-dbh-box:focus {
	outline: 3px solid #ffb703;
	outline-offset: 3px;
}

.zo-game-root--duck-box-hunt .zo-dbh-box-face {
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 220px;
	padding: 12px;
	border-radius: 24px;
	border: 3px solid #7b4b1f;
	background: linear-gradient(180deg, #c98b4c 0%, #93591d 100%);
	box-shadow: inset 0 10px 0 rgba(255, 255, 255, 0.15), 0 10px 18px rgba(70, 41, 10, 0.2);
	color: #fff8ef;
	font-size: 22px;
	font-weight: 800;
	text-align: center;
	transition: transform 0.16s ease, box-shadow 0.16s ease;
}

.zo-game-root--duck-box-hunt .zo-dbh-box:hover .zo-dbh-box-face,
.zo-game-root--duck-box-hunt .zo-dbh-box:focus .zo-dbh-box-face {
	transform: translateY(-4px);
	box-shadow: inset 0 10px 0 rgba(255, 255, 255, 0.15), 0 16px 26px rgba(70, 41, 10, 0.26);
}

.zo-game-root--duck-box-hunt .zo-dbh-box.is-duck .zo-dbh-box-face {
	background: linear-gradient(180deg, #ffe08a 0%, #ffbf3c 100%);
	border-color: #a96500;
	color: #5b3600;
}

.zo-game-root--duck-box-hunt .zo-dbh-box.is-empty .zo-dbh-box-face {
	background: linear-gradient(180deg, #d7e8f6 0%, #a8c7df 100%);
	border-color: #5a87ab;
	color: #21496b;
}

.zo-game-root--duck-box-hunt .zo-dbh-box-label {
	position: absolute;
	top: 12px;
	left: 12px;
	padding: 6px 10px;
	border-radius: 999px;
	background: rgba(255, 255, 255, 0.2);
	font-size: 12px;
	font-weight: 800;
	letter-spacing: 0.04em;
	text-transform: uppercase;
}

.zo-game-root--duck-box-hunt .zo-dbh-box-art {
	font-size: 58px;
	line-height: 1;
}

.zo-game-root--duck-box-hunt .zo-dbh-box-text {
	display: block;
	margin-top: 10px;
	font-size: 18px;
}

.zo-game-root--duck-box-hunt .zo-dbh-actions {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 16px;
}

.zo-game-root--duck-box-hunt .zo-dbh-btn {
	appearance: none;
	border: 2px solid #16324f;
	background: #16324f;
	color: #ffffff;
	border-radius: 999px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 800;
	cursor: pointer;
}

.zo-game-root--duck-box-hunt .zo-dbh-btn--light {
	background: #ffffff;
	color: #16324f;
}

.zo-game-root--duck-box-hunt .zo-dbh-help {
	margin: 0;
	text-align: center;
	font-size: 14px;
	line-height: 1.5;
	color: #46627e;
}

@media (max-width: 900px) {
	.zo-game-root--duck-box-hunt .zo-dbh-topbar {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--duck-box-hunt .zo-dbh-board {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}
}

@media (max-width: 560px) {
	.zo-game-root--duck-box-hunt {
		padding: 10px;
	}

	.zo-game-root--duck-box-hunt .zo-dbh-shell {
		padding: 14px;
	}

	.zo-game-root--duck-box-hunt .zo-dbh-title {
		font-size: 28px;
	}

	.zo-game-root--duck-box-hunt .zo-dbh-topbar,
	.zo-game-root--duck-box-hunt .zo-dbh-board {
		grid-template-columns: 1fr;
	}

	.zo-game-root--duck-box-hunt .zo-dbh-box-face {
		min-height: 170px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--duck-box-hunt');

	games.forEach(function (game) {
		const boxes = Array.prototype.slice.call(game.querySelectorAll('.zo-dbh-box'));
		const statusEl = game.querySelector('[data-role="status"]');
		const roundEl = game.querySelector('[data-role="round"]');
		const foundEl = game.querySelector('[data-role="found"]');
		const coinsEl = game.querySelector('[data-role="coins"]');
		const missesEl = game.querySelector('[data-role="misses"]');
		const bestEl = game.querySelector('[data-role="best"]');
		const restartBtn = game.querySelector('[data-role="restart"]');
		const revealBtn = game.querySelector('[data-role="reveal"]');

		let round = 1;
		let ducksFound = 0;
		let coins = 0;
		let misses = 0;
		let bestStreak = 0;
		let streak = 0;
		let duckIndex = 0;
		let locked = false;
		const duckTarget = 30;

		function randomDuckIndex() {
			return Math.floor(Math.random() * boxes.length);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function updateStats() {
			roundEl.textContent = String(round);
			foundEl.textContent = String(ducksFound) + ' / ' + String(duckTarget);
			coinsEl.textContent = String(coins);
			missesEl.textContent = String(misses);
			bestEl.textContent = String(bestStreak);
		}

		function closeBoxes() {
			boxes.forEach(function (box, index) {
				box.disabled = false;
				box.classList.remove('is-duck');
				box.classList.remove('is-empty');
				box.setAttribute('aria-label', 'Box ' + (index + 1));

				const art = box.querySelector('.zo-dbh-box-art');
				const text = box.querySelector('.zo-dbh-box-text');

				art.textContent = '📦';
				text.textContent = 'Box ' + (index + 1);
			});
		}

		function openBox(index, hasDuck) {
			const box = boxes[index];
			const art = box.querySelector('.zo-dbh-box-art');
			const text = box.querySelector('.zo-dbh-box-text');

			box.disabled = true;

			if (hasDuck) {
				box.classList.add('is-duck');
				art.textContent = '🦆';
				text.textContent = 'Duck found';
			} else {
				box.classList.add('is-empty');
				art.textContent = '❌';
				text.textContent = 'No duck';
			}
		}

		function revealDuck() {
			boxes.forEach(function (box, index) {
				openBox(index, index === duckIndex);
				if (index !== duckIndex) {
					box.disabled = true;
				}
			});
		}

		function startRound() {
			locked = false;
			duckIndex = randomDuckIndex();
			closeBoxes();
			updateStats();
			setStatus('Round ' + round + ': one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.');
		}

		function finishGame() {
			locked = true;
			revealDuck();
			setStatus('You found all 30 ducks and earned ' + coins + ' coins. Press Play Again for a new run.');
		}

		boxes.forEach(function (box, index) {
			box.addEventListener('click', function () {
				if (locked) {
					return;
				}

				locked = true;

				if (index === duckIndex) {
					ducksFound += 1;
					streak += 1;
					bestStreak = Math.max(bestStreak, streak);
					coins += 5;
					openBox(index, true);
					updateStats();

					if (ducksFound >= duckTarget) {
						finishGame();
						return;
					}

					setStatus('Nice job. You found the duck and got 5 coins. Next duck coming up...');

					setTimeout(function () {
						round += 1;
						startRound();
					}, 950);
				} else {
					misses += 1;
					streak = 0;
					openBox(index, false);
					revealDuck();
					updateStats();
					setStatus('The duck was under box ' + (duckIndex + 1) + '. No coins this round. Try the next one.');

					setTimeout(function () {
						round += 1;
						startRound();
					}, 1200);
				}
			});
		});

		restartBtn.addEventListener('click', function () {
			round = 1;
			ducksFound = 0;
			coins = 0;
			misses = 0;
			bestStreak = 0;
			streak = 0;
			startRound();
		});

		revealBtn.addEventListener('click', function () {
			if (locked) {
				return;
			}

			locked = true;
			streak = 0;
			revealDuck();
			setStatus('Duck revealed under box ' + (duckIndex + 1) + '. Press Play Again to restart, or wait for the next round.');

			setTimeout(function () {
				round += 1;
				startRound();
			}, 1200);
		});

		startRound();
	});
});
JS;

if (!function_exists('zo_game_duck_box_hunt_render')) {
	function zo_game_duck_box_hunt_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-duck-box-hunt-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--duck-box-hunt" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-dbh-shell">
				<h2 class="zo-dbh-title">Duck Box Hunt</h2>
				<p class="zo-dbh-subtitle">A new game inspired by the fast reward feeling of Fight O. Check 5 boxes, find the hidden duck, and earn 5 coins for every correct pick until you discover all 30 ducks.</p>

				<div class="zo-dbh-topbar">
					<div class="zo-dbh-stat">Round<br><span data-role="round">1</span></div>
					<div class="zo-dbh-stat">Ducks Found<br><span data-role="found">0 / 30</span></div>
					<div class="zo-dbh-stat">Coins<br><span data-role="coins">0</span></div>
					<div class="zo-dbh-stat">Misses<br><span data-role="misses">0</span></div>
					<div class="zo-dbh-stat">Best Streak<br><span data-role="best">0</span></div>
				</div>

				<div class="zo-dbh-status" data-role="status" aria-live="polite">Round 1: one duck is hiding under 1 of these 5 boxes. Find 30 ducks to finish the game.</div>

				<div class="zo-dbh-board">
					<button type="button" class="zo-dbh-box" aria-label="Box 1">
						<span class="zo-dbh-box-face">
							<span class="zo-dbh-box-label">Pick 1</span>
							<span>
								<span class="zo-dbh-box-art">📦</span>
								<span class="zo-dbh-box-text">Box 1</span>
							</span>
						</span>
					</button>
					<button type="button" class="zo-dbh-box" aria-label="Box 2">
						<span class="zo-dbh-box-face">
							<span class="zo-dbh-box-label">Pick 2</span>
							<span>
								<span class="zo-dbh-box-art">📦</span>
								<span class="zo-dbh-box-text">Box 2</span>
							</span>
						</span>
					</button>
					<button type="button" class="zo-dbh-box" aria-label="Box 3">
						<span class="zo-dbh-box-face">
							<span class="zo-dbh-box-label">Pick 3</span>
							<span>
								<span class="zo-dbh-box-art">📦</span>
								<span class="zo-dbh-box-text">Box 3</span>
							</span>
						</span>
					</button>
					<button type="button" class="zo-dbh-box" aria-label="Box 4">
						<span class="zo-dbh-box-face">
							<span class="zo-dbh-box-label">Pick 4</span>
							<span>
								<span class="zo-dbh-box-art">📦</span>
								<span class="zo-dbh-box-text">Box 4</span>
							</span>
						</span>
					</button>
					<button type="button" class="zo-dbh-box" aria-label="Box 5">
						<span class="zo-dbh-box-face">
							<span class="zo-dbh-box-label">Pick 5</span>
							<span>
								<span class="zo-dbh-box-art">📦</span>
								<span class="zo-dbh-box-text">Box 5</span>
							</span>
						</span>
					</button>
				</div>

				<div class="zo-dbh-actions">
					<button type="button" class="zo-dbh-btn" data-role="restart">Play Again</button>
					<button type="button" class="zo-dbh-btn zo-dbh-btn--light" data-role="reveal">Reveal Duck</button>
				</div>

				<p class="zo-dbh-help">There are 5 boxes to check each round. The duck moves every round, and each correct find gives 5 coins.</p>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'duck-box-hunt',
	'name'            => 'Duck Box Hunt',
	'author'          => 'Arslan',
	'description'     => 'A standalone five-box duck hunt game where players earn coins by finding the hidden duck across 30 rounds.',
	'render_callback' => 'zo_game_duck_box_hunt_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
