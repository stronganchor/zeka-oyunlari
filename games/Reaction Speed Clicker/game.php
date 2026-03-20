<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 720px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--reaction-speed-clicker .rsc-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	text-align: center;
}

.zo-game-root--reaction-speed-clicker .rsc-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	color: #1f2933;
}

.zo-game-root--reaction-speed-clicker .rsc-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	color: #52606d;
}

.zo-game-root--reaction-speed-clicker .rsc-stats {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
	margin-bottom: 18px;
}

.zo-game-root--reaction-speed-clicker .rsc-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
}

.zo-game-root--reaction-speed-clicker .rsc-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--reaction-speed-clicker .rsc-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--reaction-speed-clicker .rsc-status {
	min-height: 28px;
	margin-bottom: 14px;
	font-size: 16px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--reaction-speed-clicker .rsc-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--reaction-speed-clicker .rsc-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--reaction-speed-clicker .rsc-play-area {
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 280px;
	border-radius: 20px;
	border: 3px solid #bcccdc;
	background: #e9f2ff;
	margin-bottom: 18px;
	padding: 20px;
	cursor: pointer;
	user-select: none;
	transition: background 0.15s ease, transform 0.15s ease;
}

.zo-game-root--reaction-speed-clicker .rsc-play-area:hover,
.zo-game-root--reaction-speed-clicker .rsc-play-area:focus {
	transform: translateY(-1px);
}

.zo-game-root--reaction-speed-clicker .rsc-play-area.is-waiting {
	background: #fde68a;
}

.zo-game-root--reaction-speed-clicker .rsc-play-area.is-ready {
	background: #86efac;
}

.zo-game-root--reaction-speed-clicker .rsc-play-area.is-too-soon {
	background: #fca5a5;
}

.zo-game-root--reaction-speed-clicker .rsc-play-text {
	font-size: 30px;
	font-weight: 700;
	line-height: 1.25;
	color: #102a43;
}

.zo-game-root--reaction-speed-clicker .rsc-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
}

.zo-game-root--reaction-speed-clicker .rsc-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--reaction-speed-clicker .rsc-btn:hover,
.zo-game-root--reaction-speed-clicker .rsc-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--reaction-speed-clicker .rsc-btn--start {
	background: #2563eb;
	color: #ffffff;
}

.zo-game-root--reaction-speed-clicker .rsc-btn--reset {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--reaction-speed-clicker .rsc-footnote {
	margin-top: 14px;
	font-size: 13px;
	color: #7b8794;
}

@media (max-width: 600px) {
	.zo-game-root--reaction-speed-clicker .rsc-stats {
		grid-template-columns: 1fr;
	}

	.zo-game-root--reaction-speed-clicker .rsc-title {
		font-size: 24px;
	}

	.zo-game-root--reaction-speed-clicker .rsc-play-area {
		min-height: 220px;
	}

	.zo-game-root--reaction-speed-clicker .rsc-play-text {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--reaction-speed-clicker');

	games.forEach(function (game) {
		const playArea = game.querySelector('.rsc-play-area');
		const playText = game.querySelector('.rsc-play-text');
		const statusEl = game.querySelector('.rsc-status');
		const currentEl = game.querySelector('.rsc-current');
		const bestEl = game.querySelector('.rsc-best');
		const roundEl = game.querySelector('.rsc-round');
		const startBtn = game.querySelector('.rsc-btn--start');
		const resetBtn = game.querySelector('.rsc-btn--reset');

		let state = 'idle';
		let round = 0;
		let bestTime = null;
		let currentTime = 0;
		let startTime = 0;
		let timeoutId = null;

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
			currentEl.textContent = currentTime ? currentTime + ' ms' : '-';
			bestEl.textContent = bestTime !== null ? bestTime + ' ms' : '-';
			roundEl.textContent = String(round);
		}

		function clearPlayClasses() {
			playArea.classList.remove('is-waiting', 'is-ready', 'is-too-soon');
		}

		function setIdleView() {
			clearPlayClasses();
			playText.textContent = 'Tap Start';
			setStatus('Press Start, then wait for green.', '');
		}

		function beginRound() {
			if (timeoutId) {
				clearTimeout(timeoutId);
				timeoutId = null;
			}

			state = 'waiting';
			clearPlayClasses();
			playArea.classList.add('is-waiting');
			playText.textContent = 'Wait...';
			setStatus('Do not click yet.', '');

			const delay = Math.floor(Math.random() * 2500) + 1200;

			timeoutId = window.setTimeout(function () {
				state = 'ready';
				startTime = Date.now();
				clearPlayClasses();
				playArea.classList.add('is-ready');
				playText.textContent = 'CLICK NOW';
				setStatus('Click as fast as you can.', 'good');
				timeoutId = null;
			}, delay);
		}

		function handlePlayClick() {
			if (state === 'idle') {
				return;
			}

			if (state === 'waiting') {
				if (timeoutId) {
					clearTimeout(timeoutId);
					timeoutId = null;
				}

				state = 'idle';
				clearPlayClasses();
				playArea.classList.add('is-too-soon');
				playText.textContent = 'Too Soon';
				setStatus('You clicked too early. Try again.', 'bad');
				currentTime = 0;
				updateStats();

				window.setTimeout(function () {
					if (state === 'idle') {
						setIdleView();
					}
				}, 900);

				return;
			}

			if (state === 'ready') {
				const reaction = Date.now() - startTime;
				currentTime = reaction;
				round += 1;

				if (bestTime === null || reaction < bestTime) {
					bestTime = reaction;
				}

				state = 'idle';
				clearPlayClasses();
				playText.textContent = reaction + ' ms';
				setStatus('Nice. Press Start for another round.', 'good');
				updateStats();
			}
		}

		function resetGame() {
			if (timeoutId) {
				clearTimeout(timeoutId);
				timeoutId = null;
			}

			state = 'idle';
			round = 0;
			bestTime = null;
			currentTime = 0;
			updateStats();
			setIdleView();
		}

		startBtn.addEventListener('click', beginRound);
		resetBtn.addEventListener('click', resetGame);
		playArea.addEventListener('click', handlePlayClick);
		playArea.setAttribute('tabindex', '0');
		playArea.addEventListener('keydown', function (event) {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				handlePlayClick();
			}
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_reaction_speed_clicker_render')) {
	function zo_game_reaction_speed_clicker_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-reaction-speed-clicker-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--reaction-speed-clicker" id="<?php echo esc_attr($instance_id); ?>">
			<div class="rsc-card">
				<h2 class="rsc-title">Reaction Speed Clicker</h2>
				<p class="rsc-instructions">Press Start. Wait until the big box turns green. Then click as fast as you can. If you click too early, that round fails.</p>

				<div class="rsc-stats">
					<div class="rsc-stat">
						<span class="rsc-stat-label">Current</span>
						<span class="rsc-stat-value rsc-current">-</span>
					</div>
					<div class="rsc-stat">
						<span class="rsc-stat-label">Best</span>
						<span class="rsc-stat-value rsc-best">-</span>
					</div>
					<div class="rsc-stat">
						<span class="rsc-stat-label">Rounds</span>
						<span class="rsc-stat-value rsc-round">0</span>
					</div>
				</div>

				<div class="rsc-status" aria-live="polite">Press Start, then wait for green.</div>

				<div class="rsc-play-area" role="button" aria-label="Reaction play area">
					<div class="rsc-play-text">Tap Start</div>
				</div>

				<div class="rsc-actions">
					<button type="button" class="rsc-btn rsc-btn--start">Start</button>
					<button type="button" class="rsc-btn rsc-btn--reset">Reset</button>
				</div>

				<div class="rsc-footnote">Fast reactions are usually lower milliseconds.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'reaction-speed-clicker',
	'name'            => 'Reaction Speed Clicker',
	'author'          => 'Arslan',
	'description'     => 'Test how fast you can click when the box turns green.',
	'render_callback' => 'zo_game_reaction_speed_clicker_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);