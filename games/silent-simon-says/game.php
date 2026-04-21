<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--silent-simon-says {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #f8fafc;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-ss-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-ss-command {
	text-align: center;
	font-size: 18px;
	font-weight: 700;
	min-height: 36px;
	padding: 8px;
	background: #f1f5f9;
	border-radius: 10px;
}

.zo-ss-actions {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 8px;
	margin-top: 12px;
}

.zo-ss-btn {
	border: 0;
	border-radius: 10px;
	padding: 12px;
	font-weight: 700;
	color: #fff;
	background: #1e3a8a;
	cursor: pointer;
}

.zo-ss-hud {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 8px;
	margin-top: 12px;
	text-align: center;
}

.zo-ss-start,
.zo-ss-stat {
	border-radius: 10px;
	padding: 10px;
}

.zo-ss-start {
	background: #2563eb;
	color: #fff;
	border: 0;
	font-weight: 700;
}

.zo-ss-stat {
	background: #eef2ff;
}

.zo-ss-status {
	margin-top: 10px;
	min-height: 26px;
	text-align: center;
	font-weight: 700;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--silent-simon-says')) {
			return;
		}

		const commandText = game.querySelector('.zo-ss-command');
		const statusText = game.querySelector('.zo-ss-status');
		const startBtn = game.querySelector('.zo-ss-start');
		const scoreEl = game.querySelector('.zo-ss-score');
		const livesEl = game.querySelector('.zo-ss-lives');
		const roundEl = game.querySelector('.zo-ss-round');
		const actionButtons = game.querySelectorAll('.zo-ss-btn[data-action]');

		const actions = [
			{ action: 'clap', opposite: 'point' },
			{ action: 'point', opposite: 'wave' },
			{ action: 'wave', opposite: 'clap' },
			{ action: 'jump', opposite: 'duck' },
			{ action: 'duck', opposite: 'jump' },
			{ action: 'spin', opposite: 'still' },
			{ action: 'still', opposite: 'spin' },
		];

		let score = 0;
		let lives = 3;
		let round = 1;
		let current = '';
		let running = false;
		let responseOpen = false;
		let roundTimer = null;

		function getAction(actionId) {
			const found = actions.find(function (item) {
				return item.action === actionId;
			});
			return found || { action: actionId, opposite: '' };
		}

		function updateHud() {
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			roundEl.textContent = String(round);
		}

		function stopRound() {
			running = false;
			responseOpen = false;
			if (roundTimer) {
				clearTimeout(roundTimer);
				roundTimer = null;
			}
			actionButtons.forEach(function (button) {
				button.disabled = true;
			});
		}

		function newRound() {
			if (lives <= 0) {
				stopRound();
				statusText.textContent = 'You are out of lives. Press Start.';
				return;
			}
			const prompt = actions[Math.floor(Math.random() * actions.length)];
			current = prompt.action;
			round += 1;
			updateHud();
			commandText.textContent = 'Leader says: ' + prompt.action;
			responseOpen = false;
			statusText.textContent = 'Get ready...';
			actionButtons.forEach(function (button) {
				button.disabled = true;
			});
			roundTimer = setTimeout(function () {
				commandText.textContent = 'Pick the OPPOSITE.';
				statusText.textContent = 'Choose a move.';
				responseOpen = true;
				actionButtons.forEach(function (button) {
					button.disabled = false;
				});
			}, 900);
		}

		function handleChoose(choice) {
			if (!running || !responseOpen) {
				return;
			}
			responseOpen = false;
			actionButtons.forEach(function (button) {
				button.disabled = true;
			});
			const expected = getAction(current).opposite;
			if (choice === expected) {
				score += 1;
				statusText.textContent = 'Correct!';
			} else {
				lives -= 1;
				statusText.textContent = 'Wrong. Opposite was "' + expected + '".';
				if (lives <= 0) {
					updateHud();
					stopRound();
					statusText.textContent = 'Game over. Press Start.';
					return;
				}
			}
			updateHud();
			roundTimer = setTimeout(function () {
				newRound();
			}, 800);
		}

		startBtn.addEventListener('click', function () {
			score = 0;
			lives = 3;
			round = 1;
			updateHud();
			running = true;
			newRound();
		});

		actionButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				handleChoose(button.dataset.action);
			});
		});

		updateHud();
		statusText.textContent = 'Press Start.';
		commandText.textContent = 'Ready.';
		actionButtons.forEach(function (button) {
			button.disabled = true;
		});
	});
});
JS;

if (!function_exists('zo_game_silent_simon_says_render')) {
	function zo_game_silent_simon_says_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-silent-simon-says-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--silent-simon-says" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-ss-title">Silent Simon Says</h2>
			<div class="zo-ss-command">Ready.</div>
			<div class="zo-ss-actions">
				<button type="button" class="zo-ss-btn" data-action="clap">Clap</button>
				<button type="button" class="zo-ss-btn" data-action="point">Point</button>
				<button type="button" class="zo-ss-btn" data-action="wave">Wave</button>
				<button type="button" class="zo-ss-btn" data-action="jump">Jump</button>
				<button type="button" class="zo-ss-btn" data-action="duck">Duck</button>
				<button type="button" class="zo-ss-btn" data-action="spin">Spin</button>
				<button type="button" class="zo-ss-btn" data-action="still">Still</button>
			</div>
			<div class="zo-ss-hud">
				<div class="zo-ss-stat">Score <span class="zo-ss-score">0</span></div>
				<div class="zo-ss-stat">Lives <span class="zo-ss-lives">3</span></div>
				<div class="zo-ss-stat">Round <span class="zo-ss-round">1</span></div>
				<button type="button" class="zo-ss-start">Start</button>
			</div>
			<div class="zo-ss-status">Press Start.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'silent-simon-says',
	'name'            => 'Silent Simon Says',
	'author'          => 'Asker',
	'description'     => 'Follow only the opposite action for each command.',
	'render_callback' => 'zo_game_silent_simon_says_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
