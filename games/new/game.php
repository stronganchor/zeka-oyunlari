<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 560px;
	margin: 0 auto;
	font-family: inherit;
}

.zo-game-root.zo-game-root--angle-match {
	background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
	border: 2px solid #dbe7f3;
	border-radius: 20px;
	padding: 16px;
	box-shadow: 0 10px 26px rgba(0, 0, 0, 0.06);
}

.zo-game-root--angle-match .am-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
	color: #1e3a5f;
}

.zo-game-root--angle-match .am-subtitle {
	margin: 0 0 14px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #52667a;
}

.zo-game-root--angle-match .am-panel {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 8px;
	margin-bottom: 12px;
}

.zo-game-root--angle-match .am-stat {
	background: #ffffff;
	border: 2px solid #dbe7f3;
	border-radius: 14px;
	padding: 10px 8px;
	text-align: center;
}

.zo-game-root--angle-match .am-stat-label {
	display: block;
	font-size: 12px;
	color: #60758a;
	margin-bottom: 4px;
}

.zo-game-root--angle-match .am-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #17324d;
}

.zo-game-root--angle-match .am-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-game-root--angle-match .am-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	background: #1976d2;
	color: #ffffff;
	transition: transform 0.08s ease, opacity 0.12s ease;
}

.zo-game-root--angle-match .am-btn:hover,
.zo-game-root--angle-match .am-btn:focus {
	opacity: 0.92;
}

.zo-game-root--angle-match .am-btn:active {
	transform: scale(0.98);
}

.zo-game-root--angle-match .am-btn--secondary {
	background: #546e7a;
}

.zo-game-root--angle-match .am-btn--mode {
	background: #00897b;
}

.zo-game-root--angle-match .am-btn--mode.is-active {
	box-shadow: inset 0 0 0 3px rgba(255, 255, 255, 0.65);
}

.zo-game-root--angle-match .am-status {
	min-height: 24px;
	margin: 0 0 12px;
	font-size: 15px;
	font-weight: 700;
	text-align: center;
	color: #17324d;
}

.zo-game-root--angle-match .am-stage {
	background: linear-gradient(180deg, #f4f9ff 0%, #eef6ff 100%);
	border: 2px solid #dbe7f3;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--angle-match .am-dials {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 14px;
	align-items: start;
}

.zo-game-root--angle-match .am-dial-box {
	background: #ffffff;
	border: 2px solid #dbe7f3;
	border-radius: 16px;
	padding: 12px;
	text-align: center;
}

.zo-game-root--angle-match .am-dial-title {
	margin: 0 0 8px;
	font-size: 15px;
	font-weight: 700;
	color: #1e3a5f;
}

.zo-game-root--angle-match .am-dial-wrap {
	display: flex;
	justify-content: center;
	align-items: center;
}

.zo-game-root--angle-match .am-dial {
	position: relative;
	width: 220px;
	height: 220px;
	border-radius: 50%;
	background: radial-gradient(circle at 50% 45%, #ffffff 0%, #f7fbff 62%, #e6f0fa 100%);
	border: 4px solid #cddded;
	box-shadow: inset 0 0 0 10px rgba(255, 255, 255, 0.85);
	touch-action: none;
	user-select: none;
}

.zo-game-root--angle-match .am-target-line,
.zo-game-root--angle-match .am-player-line {
	position: absolute;
	left: 50%;
	top: 50%;
	width: 4px;
	height: 88px;
	transform-origin: center bottom;
	border-radius: 999px;
	margin-left: -2px;
	margin-top: -88px;
}

.zo-game-root--angle-match .am-target-line {
	background: #ef5350;
	box-shadow: 0 0 0 4px rgba(239, 83, 80, 0.12);
}

.zo-game-root--angle-match .am-player-line {
	background: #1e88e5;
	box-shadow: 0 0 0 4px rgba(30, 136, 229, 0.12);
}

.zo-game-root--angle-match .am-center-dot {
	position: absolute;
	left: 50%;
	top: 50%;
	width: 18px;
	height: 18px;
	margin-left: -9px;
	margin-top: -9px;
	border-radius: 50%;
	background: #17324d;
	box-shadow: 0 0 0 5px rgba(23, 50, 77, 0.10);
}

.zo-game-root--angle-match .am-tick {
	position: absolute;
	left: 50%;
	top: 50%;
	width: 3px;
	height: 16px;
	margin-left: -1.5px;
	margin-top: -106px;
	transform-origin: center 106px;
	border-radius: 999px;
	background: rgba(70, 98, 126, 0.35);
}

.zo-game-root--angle-match .am-tick.is-major {
	height: 24px;
	margin-top: -114px;
	background: rgba(70, 98, 126, 0.65);
}

.zo-game-root--angle-match .am-angle-readout {
	margin-top: 10px;
	font-size: 14px;
	font-weight: 700;
	color: #38546f;
}

.zo-game-root--angle-match .am-difference {
	margin-top: 6px;
	font-size: 13px;
	color: #60758a;
}

.zo-game-root--angle-match .am-slider-box {
	margin-top: 14px;
	background: #ffffff;
	border: 2px solid #dbe7f3;
	border-radius: 16px;
	padding: 12px;
}

.zo-game-root--angle-match .am-slider-row {
	display: flex;
	align-items: center;
	gap: 10px;
}

.zo-game-root--angle-match .am-slider-label {
	font-size: 14px;
	font-weight: 700;
	color: #1e3a5f;
	white-space: nowrap;
}

.zo-game-root--angle-match .am-slider {
	flex: 1 1 auto;
}

.zo-game-root--angle-match .am-slider-value {
	min-width: 56px;
	text-align: right;
	font-size: 14px;
	font-weight: 700;
	color: #17324d;
}

.zo-game-root--angle-match .am-help {
	margin-top: 12px;
	font-size: 12px;
	line-height: 1.5;
	color: #60758a;
	text-align: center;
}

.zo-game-root--angle-match .am-success {
	color: #2e7d32;
}

.zo-game-root--angle-match .am-warning {
	color: #ef6c00;
}

@media (max-width: 640px) {
	.zo-game-root--angle-match .am-panel {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.zo-game-root--angle-match .am-dials {
		grid-template-columns: 1fr;
	}

	.zo-game-root--angle-match .am-dial {
		width: 200px;
		height: 200px;
	}

	.zo-game-root--angle-match .am-target-line,
	.zo-game-root--angle-match .am-player-line {
		height: 78px;
		margin-top: -78px;
	}

	.zo-game-root--angle-match .am-tick {
		margin-top: -96px;
		transform-origin: center 96px;
	}

	.zo-game-root--angle-match .am-tick.is-major {
		margin-top: -104px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--angle-match');

	games.forEach(function (game) {
		const scoreEl = game.querySelector('.am-score');
		const roundEl = game.querySelector('.am-round');
		const streakEl = game.querySelector('.am-streak');
		const bestEl = game.querySelector('.am-best');
		const statusEl = game.querySelector('.am-status');
		const startBtn = game.querySelector('.am-start');
		const nextBtn = game.querySelector('.am-next');
		const resetBtn = game.querySelector('.am-reset');
		const modeButtons = game.querySelectorAll('.am-btn--mode');
		const playerDial = game.querySelector('.am-player-dial');
		const targetDial = game.querySelector('.am-target-dial');
		const targetLine = game.querySelector('.am-target-line');
		const playerLine = game.querySelector('.am-player-line');
		const targetReadout = game.querySelector('.am-target-readout');
		const playerReadout = game.querySelector('.am-player-readout');
		const differenceReadout = game.querySelector('.am-difference-readout');
		const slider = game.querySelector('.am-slider');
		const sliderValue = game.querySelector('.am-slider-value');

		const state = {
			running: false,
			score: 0,
			round: 0,
			streak: 0,
			best: 0,
			targetAngle: 0,
			playerAngle: 0,
			tolerance: 12,
			mode: 'easy',
			dragging: false,
			pointerId: null
		};

		function createTicks(dial) {
			for (let i = 0; i < 24; i++) {
				const tick = document.createElement('span');
				tick.className = 'am-tick' + (i % 3 === 0 ? ' is-major' : '');
				tick.style.transform = 'rotate(' + (i * 15) + 'deg)';
				dial.appendChild(tick);
			}

			const center = document.createElement('span');
			center.className = 'am-center-dot';
			dial.appendChild(center);
		}

		createTicks(targetDial);
		createTicks(playerDial);

		function normalizeAngle(angle) {
			let value = angle % 360;
			if (value < 0) {
				value += 360;
			}
			return value;
		}

		function shortestAngleDiff(a, b) {
			const diff = Math.abs(normalizeAngle(a) - normalizeAngle(b));
			return Math.min(diff, 360 - diff);
		}

		function setStatus(message, className) {
			statusEl.textContent = message;
			statusEl.classList.remove('am-success', 'am-warning');

			if (className) {
				statusEl.classList.add(className);
			}
		}

		function updateModeButtons() {
			modeButtons.forEach(function (btn) {
				btn.classList.toggle('is-active', btn.getAttribute('data-mode') === state.mode);
			});
		}

		function getModeConfig() {
			if (state.mode === 'hard') {
				return { tolerance: 6, points: 3 };
			}
			if (state.mode === 'medium') {
				return { tolerance: 9, points: 2 };
			}
			return { tolerance: 12, points: 1 };
		}

		function updateStats() {
			scoreEl.textContent = String(state.score);
			roundEl.textContent = String(state.round);
			streakEl.textContent = String(state.streak);
			bestEl.textContent = String(state.best);
		}

		function renderAngles() {
			targetLine.style.transform = 'rotate(' + state.targetAngle + 'deg)';
			playerLine.style.transform = 'rotate(' + state.playerAngle + 'deg)';
			targetReadout.textContent = Math.round(state.targetAngle) + '°';
			playerReadout.textContent = Math.round(state.playerAngle) + '°';
			differenceReadout.textContent = Math.round(shortestAngleDiff(state.targetAngle, state.playerAngle)) + '° off';
			slider.value = String(Math.round(state.playerAngle));
			sliderValue.textContent = Math.round(state.playerAngle) + '°';
		}

		function randomTargetAngle() {
			let angle = Math.floor(Math.random() * 360);
			if (angle % 15 === 0) {
				angle += 7;
			}
			return normalizeAngle(angle);
		}

		function startRound() {
			state.running = true;
			state.round += 1;
			state.targetAngle = randomTargetAngle();
			state.playerAngle = 0;
			state.tolerance = getModeConfig().tolerance;
			renderAngles();
			updateStats();
			setStatus('Match the blue pointer to the red pointer. Then press Check Angle.');
			nextBtn.disabled = false;
		}

		function resetGame() {
			state.running = false;
			state.score = 0;
			state.round = 0;
			state.streak = 0;
			state.targetAngle = 0;
			state.playerAngle = 0;
			state.tolerance = getModeConfig().tolerance;
			renderAngles();
			updateStats();
			setStatus('Press Start Game to begin.');
			nextBtn.disabled = true;
		}

		function finishRound() {
			if (!state.running) {
				return;
			}

			const diff = shortestAngleDiff(state.targetAngle, state.playerAngle);
			const modeConfig = getModeConfig();

			if (diff <= state.tolerance) {
				state.score += modeConfig.points;
				state.streak += 1;
				if (state.score > state.best) {
					state.best = state.score;
				}
				setStatus('Great match. You were only ' + Math.round(diff) + '° off.', 'am-success');
			} else {
				state.streak = 0;
				setStatus('Not quite. You were ' + Math.round(diff) + '° off.', 'am-warning');
			}

			state.running = false;
			updateStats();
		}

		function angleFromEvent(event, dial) {
			const rect = dial.getBoundingClientRect();
			const cx = rect.left + (rect.width / 2);
			const cy = rect.top + (rect.height / 2);
			const dx = event.clientX - cx;
			const dy = event.clientY - cy;
			const radians = Math.atan2(dy, dx);
			return normalizeAngle((radians * (180 / Math.PI)) + 90);
		}

		function setPlayerAngle(angle) {
			state.playerAngle = normalizeAngle(angle);
			renderAngles();
		}

		playerDial.addEventListener('pointerdown', function (event) {
			event.preventDefault();
			state.dragging = true;
			state.pointerId = event.pointerId;
			playerDial.setPointerCapture(event.pointerId);
			setPlayerAngle(angleFromEvent(event, playerDial));
		});

		playerDial.addEventListener('pointermove', function (event) {
			if (!state.dragging || state.pointerId !== event.pointerId) {
				return;
			}
			setPlayerAngle(angleFromEvent(event, playerDial));
		});

		playerDial.addEventListener('pointerup', function (event) {
			if (state.pointerId === event.pointerId) {
				state.dragging = false;
				state.pointerId = null;
			}
		});

		playerDial.addEventListener('pointercancel', function (event) {
			if (state.pointerId === event.pointerId) {
				state.dragging = false;
				state.pointerId = null;
			}
		});

		slider.addEventListener('input', function () {
			setPlayerAngle(parseInt(slider.value, 10) || 0);
		});

		startBtn.addEventListener('click', function () {
			state.score = 0;
			state.round = 0;
			state.streak = 0;
			updateStats();
			startRound();
		});

		nextBtn.addEventListener('click', function () {
			if (state.running) {
				finishRound();
			} else {
				startRound();
			}
		});

		resetBtn.addEventListener('click', function () {
			resetGame();
		});

		modeButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				state.mode = btn.getAttribute('data-mode') || 'easy';
				state.tolerance = getModeConfig().tolerance;
				updateModeButtons();
				renderAngles();
				if (!state.running) {
					setStatus('Mode changed. Press Start Game or Next Round.');
				}
			});
		});

		updateModeButtons();
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_angle_match_render')) {
	function zo_game_angle_match_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-angle-match-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--angle-match" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="am-title">Angle Match</h2>
			<p class="am-subtitle">Turn the blue pointer until it matches the red pointer. Drag the dial or use the slider. Then press Check Angle.</p>

			<div class="am-panel">
				<div class="am-stat">
					<span class="am-stat-label">Score</span>
					<span class="am-stat-value am-score">0</span>
				</div>
				<div class="am-stat">
					<span class="am-stat-label">Round</span>
					<span class="am-stat-value am-round">0</span>
				</div>
				<div class="am-stat">
					<span class="am-stat-label">Streak</span>
					<span class="am-stat-value am-streak">0</span>
				</div>
				<div class="am-stat">
					<span class="am-stat-label">Best</span>
					<span class="am-stat-value am-best">0</span>
				</div>
			</div>

			<div class="am-controls">
				<button type="button" class="am-btn am-btn--mode" data-mode="easy">Easy</button>
				<button type="button" class="am-btn am-btn--mode" data-mode="medium">Medium</button>
				<button type="button" class="am-btn am-btn--mode" data-mode="hard">Hard</button>
			</div>

			<div class="am-controls">
				<button type="button" class="am-btn am-start">Start Game</button>
				<button type="button" class="am-btn am-next">Check Angle</button>
				<button type="button" class="am-btn am-btn--secondary am-reset">Reset</button>
			</div>

			<p class="am-status">Press Start Game to begin.</p>

			<div class="am-stage">
				<div class="am-dials">
					<div class="am-dial-box">
						<h3 class="am-dial-title">Target Angle</h3>
						<div class="am-dial-wrap">
							<div class="am-dial am-target-dial" aria-hidden="true">
								<span class="am-target-line"></span>
							</div>
						</div>
						<div class="am-angle-readout">Red: <span class="am-target-readout">0°</span></div>
					</div>

					<div class="am-dial-box">
						<h3 class="am-dial-title">Your Angle</h3>
						<div class="am-dial-wrap">
							<div class="am-dial am-player-dial" tabindex="0" aria-label="Rotate the blue pointer">
								<span class="am-player-line"></span>
							</div>
						</div>
						<div class="am-angle-readout">Blue: <span class="am-player-readout">0°</span></div>
						<div class="am-difference">Difference: <span class="am-difference-readout">0° off</span></div>
					</div>
				</div>

				<div class="am-slider-box">
					<div class="am-slider-row">
						<span class="am-slider-label">Fine Tune</span>
						<input type="range" class="am-slider" min="0" max="359" step="1" value="0">
						<span class="am-slider-value">0°</span>
					</div>
				</div>

				<p class="am-help">Easy gives 1 point with a 12° margin. Medium gives 2 points with a 9° margin. Hard gives 3 points with a 6° margin.</p>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'angle-match',
	'name'            => 'Angle Match',
	'author'          => 'Asker',
	'description'     => 'A simple game where players rotate a pointer to match the target angle.',
	'render_callback' => 'zo_game_angle_match_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);