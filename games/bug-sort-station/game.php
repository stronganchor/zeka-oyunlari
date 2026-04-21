<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--bug-sort-station {
	max-width: 600px;
	margin: 0 auto;
	padding: 14px;
	box-sizing: border-box;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #f8fbff;
	font-family: Arial, sans-serif;
}

.zo-bs-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-bs-zone {
	border: 2px dashed #cbd5e1;
	border-radius: 12px;
	padding: 12px;
	background: #ffffff;
	text-align: center;
	min-height: 80px;
}

.zo-bs-bug {
	font-size: 32px;
	margin: 6px 0 4px;
	font-weight: 700;
}

.zo-bs-bins {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 8px;
	margin-top: 12px;
}

.zo-bs-bin {
	border: 0;
	border-radius: 10px;
	padding: 10px;
	cursor: pointer;
	background: #0f172a;
	color: #fff;
	font-weight: 700;
}

.zo-bs-bin[data-bin="fruit"] {
	background: #f59e0b;
}

.zo-bs-bin[data-bin="trash"] {
	background: #ef4444;
}

.zo-bs-bin[data-bin="compost"] {
	background: #16a34a;
}

.zo-bs-bin[data-bin="water"] {
	background: #2563eb;
}

.zo-bs-hud {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 8px;
	margin-top: 10px;
	text-align: center;
}

.zo-bs-start {
	grid-column: span 2;
	background: #1d4ed8;
	color: #fff;
	border: 0;
	border-radius: 10px;
	padding: 10px;
	font-weight: 700;
}

.zo-bs-stat,
.zo-bs-result {
	padding: 10px;
	border-radius: 10px;
	background: #eef2ff;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--bug-sort-station')) {
			return;
		}

		const bugName = game.querySelector('.zo-bs-bug-name');
		const bugText = game.querySelector('.zo-bs-bug');
		const result = game.querySelector('.zo-bs-result');
		const timerEl = game.querySelector('.zo-bs-timer');
		const scoreEl = game.querySelector('.zo-bs-score');
		const livesEl = game.querySelector('.zo-bs-lives');
		const startBtn = game.querySelector('.zo-bs-start');
		const bins = game.querySelectorAll('.zo-bs-bin');

		const bugs = [
			{ name: 'Ant', type: 'fruit' },
			{ name: 'Termite', type: 'wood' },
			{ name: 'Worm', type: 'compost' },
			{ name: 'Midge', type: 'water' },
			{ name: 'Beetle', type: 'trash' },
			{ name: 'Spider', type: 'water' },
			{ name: 'Fly', type: 'trash' },
			{ name: 'Moth', type: 'fruit' },
		];

		const bugToBin = {
			fruit: 'fruit',
			wood: 'trash',
			compost: 'compost',
			water: 'water',
			trash: 'trash',
		};

		let running = false;
		let score = 0;
		let lives = 3;
		let timeLeft = 30;
		let currentBug = null;
		let activeTimeout = null;
		let spawnInterval = null;
		let timerInterval = null;

		function updateHud() {
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			timerEl.textContent = String(timeLeft) + 's';
		}

		function stopGame() {
			running = false;
			if (activeTimeout) {
				clearTimeout(activeTimeout);
				activeTimeout = null;
			}
			if (spawnInterval) {
				clearTimeout(spawnInterval);
				spawnInterval = null;
			}
			if (timerInterval) {
				clearInterval(timerInterval);
				timerInterval = null;
			}
		}

		function loseLife(message) {
			lives -= 1;
			updateHud();
			result.textContent = message;
			currentBug = null;
			if (lives <= 0) {
				stopGame();
				result.textContent = 'You lost all lives. Press Start.';
			}
		}

		function spawnBug() {
			if (!running) {
				return;
			}

			const idx = Math.floor(Math.random() * bugs.length);
			currentBug = bugs[idx];
			bugName.textContent = currentBug.name;
			bugText.textContent = currentBug.type.charAt(0).toUpperCase() + currentBug.type.slice(1) + ' Bin';
			result.textContent = 'Classify the bug.';
			activeTimeout = setTimeout(function () {
				if (!running || !currentBug) {
					return;
				}
				loseLife('Bug reached the station floor.');
				currentBug = null;
				spawnBug();
			}, 1400);
		}

		function scheduleNextBug() {
			if (!running) {
				return;
			}
			spawnInterval = setTimeout(function () {
				spawnBug();
			}, 200);
		}

		function startRound() {
			stopGame();
			running = true;
			score = 0;
			lives = 3;
			timeLeft = 30;
			currentBug = null;
			updateHud();
			result.textContent = 'Classify the bugs before time runs out.';
			timerInterval = setInterval(function () {
				timeLeft -= 1;
				updateHud();
				if (timeLeft <= 0) {
					stopGame();
					result.textContent = 'Time finished. Score: ' + score;
				}
			}, 1000);

			spawnBug();
			scheduleNextBug();
		}

		function classify(targetBin) {
			if (!running || !currentBug) {
				return;
			}
			const expected = bugToBin[currentBug.type] || currentBug.type;
			if (targetBin === expected) {
				score += 1;
				result.textContent = 'Correct bin.';
				updateHud();
			} else {
				loseLife('Wrong bin.');
			}
			if (activeTimeout) {
				clearTimeout(activeTimeout);
				activeTimeout = null;
			}
			currentBug = null;
			bugName.textContent = '';
			bugText.textContent = '';
			if (running) {
				scheduleNextBug();
			}
		}

		bins.forEach(function (bin) {
			bin.addEventListener('click', function () {
				classify(bin.dataset.bin);
			});
		});

		startBtn.addEventListener('click', function () {
			startRound();
		});

		bugName.textContent = '';
		bugText.textContent = '';
		updateHud();
		result.textContent = 'Press Start.';
	});
});
JS;

if (!function_exists('zo_game_bug_sort_station_render')) {
	function zo_game_bug_sort_station_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-bug-sort-station-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--bug-sort-station" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-bs-title">Bug Sort Station</h2>
			<div class="zo-bs-zone">
				<div class="zo-bs-bug-name"></div>
				<div class="zo-bs-bug"></div>
				<div class="zo-bs-result">Press Start.</div>
			</div>
			<div class="zo-bs-hud">
				<div class="zo-bs-stat">Score <span class="zo-bs-score">0</span></div>
				<div class="zo-bs-stat">Lives <span class="zo-bs-lives">3</span></div>
				<div class="zo-bs-stat">Time <span class="zo-bs-timer">30s</span></div>
				<button type="button" class="zo-bs-start">Start</button>
			</div>
			<div class="zo-bs-bins">
				<button type="button" class="zo-bs-bin" data-bin="fruit">Fruit Bin</button>
				<button type="button" class="zo-bs-bin" data-bin="trash">Trash Bin</button>
				<button type="button" class="zo-bs-bin" data-bin="compost">Compost Bin</button>
				<button type="button" class="zo-bs-bin" data-bin="water">Water Tank</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'bug-sort-station',
	'name'            => 'Bug Sort Station',
	'author'          => 'Asker',
	'description'     => 'Classify arriving bugs by using the correct station before they escape.',
	'render_callback' => 'zo_game_bug_sort_station_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
