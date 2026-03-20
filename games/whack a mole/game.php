<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	text-align: center;
}

.zo-game-root--whack-a-mole {
	font-family: Arial, sans-serif;
	background: linear-gradient(180deg, #dff3ff 0%, #eff9ff 100%);
	color: #1d2a1d;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
	border: 2px solid #b9dff0;
}

.zo-game-root--whack-a-mole * {
	box-sizing: border-box;
}

.zo-game-root--whack-a-mole .wam-title {
	font-size: 30px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #216b2f;
}

.zo-game-root--whack-a-mole .wam-instructions {
	font-size: 15px;
	line-height: 1.5;
	color: #3f5540;
	margin-bottom: 14px;
}

.zo-game-root--whack-a-mole .wam-topbar {
	display: flex;
	justify-content: center;
	gap: 12px;
	flex-wrap: wrap;
	margin-bottom: 14px;
}

.zo-game-root--whack-a-mole .wam-stat {
	background: #ffffff;
	border: 1px solid #bfd6e2;
	border-radius: 999px;
	padding: 10px 16px;
	font-size: 16px;
	font-weight: 700;
	min-width: 130px;
}

.zo-game-root--whack-a-mole .wam-board-wrap {
	position: relative;
	width: 100%;
	max-width: 640px;
	margin: 0 auto 14px;
}

.zo-game-root--whack-a-mole .wam-board {
	position: relative;
	width: 100%;
	aspect-ratio: 5 / 6;
	background: linear-gradient(180deg, #9be0ff 0%, #9be0ff 16%, #7ec850 16%, #7ec850 100%);
	border: 3px solid #8fc6d9;
	border-radius: 18px;
	overflow: hidden;
	touch-action: manipulation;
	user-select: none;
}

.zo-game-root--whack-a-mole .wam-hole {
	position: absolute;
	width: 18%;
	height: 10%;
	background: #4b2e19;
	border: 2px solid #111;
	border-radius: 50%;
	transform: translate(-50%, -50%);
}

.zo-game-root--whack-a-mole .wam-mole {
	position: absolute;
	width: 12.6%;
	height: 12%;
	transform: translate(-50%, -50%);
	cursor: pointer;
}

.zo-game-root--whack-a-mole .wam-mole[hidden] {
	display: none;
}

.zo-game-root--whack-a-mole .wam-mole-head {
	position: absolute;
	left: 50%;
	top: 44%;
	width: 100%;
	height: 100%;
	transform: translate(-50%, -50%);
	background: #8b5a2b;
	border: 2px solid #111;
	border-radius: 50%;
}

.zo-game-root--whack-a-mole .wam-eye {
	position: absolute;
	top: 28%;
	width: 16%;
	height: 16%;
	background: #fff;
	border: 1px solid #111;
	border-radius: 50%;
}

.zo-game-root--whack-a-mole .wam-eye::after {
	content: '';
	position: absolute;
	left: 35%;
	top: 35%;
	width: 30%;
	height: 30%;
	background: #111;
	border-radius: 50%;
}

.zo-game-root--whack-a-mole .wam-eye--left {
	left: 24%;
}

.zo-game-root--whack-a-mole .wam-eye--right {
	right: 24%;
}

.zo-game-root--whack-a-mole .wam-nose {
	position: absolute;
	left: 50%;
	top: 54%;
	width: 28%;
	height: 18%;
	transform: translate(-50%, -50%);
	background: pink;
	border: 1px solid #111;
	border-radius: 50%;
}

.zo-game-root--whack-a-mole .wam-tooth {
	position: absolute;
	top: 66%;
	width: 10%;
	height: 16%;
	background: #fff;
	border: 1px solid #111;
}

.zo-game-root--whack-a-mole .wam-tooth--left {
	left: 43%;
}

.zo-game-root--whack-a-mole .wam-tooth--right {
	left: 53%;
}

.zo-game-root--whack-a-mole .wam-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 20px;
	background: rgba(20, 30, 20, 0.35);
}

.zo-game-root--whack-a-mole .wam-overlay[hidden] {
	display: none;
}

.zo-game-root--whack-a-mole .wam-panel {
	background: rgba(255,255,255,0.96);
	border: 2px solid #222;
	border-radius: 18px;
	padding: 22px;
	max-width: 420px;
	width: 100%;
}

.zo-game-root--whack-a-mole .wam-panel-title {
	font-size: 32px;
	font-weight: 700;
	margin-bottom: 10px;
	color: #d93030;
}

.zo-game-root--whack-a-mole .wam-panel-text {
	font-size: 17px;
	line-height: 1.5;
	color: #222;
	margin-bottom: 14px;
}

.zo-game-root--whack-a-mole .wam-btn-row {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--whack-a-mole .wam-btn {
	appearance: none;
	border: 1px solid #5578d8;
	background: #2c4f9e;
	color: #fff;
	border-radius: 12px;
	padding: 12px 18px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	min-width: 150px;
}

.zo-game-root--whack-a-mole .wam-btn:hover,
.zo-game-root--whack-a-mole .wam-btn:focus {
	background: #3a63c2;
	outline: none;
}

.zo-game-root--whack-a-mole .wam-controls {
	font-size: 14px;
	color: #445444;
	line-height: 1.5;
}

@media (max-width: 640px) {
	.zo-game-root--whack-a-mole .wam-title {
		font-size: 26px;
	}

	.zo-game-root--whack-a-mole .wam-panel-title {
		font-size: 28px;
	}

	.zo-game-root--whack-a-mole .wam-btn {
		width: 100%;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--whack-a-mole');

	games.forEach(function (game) {
		const GAME_TIME = 30;
		const MOLE_MOVE_MS = 700;

		const holePositions = [
			{ x: 15.625, y: 28.3333333333 },
			{ x: 39.0625, y: 28.3333333333 },
			{ x: 62.5, y: 28.3333333333 },
			{ x: 15.625, y: 53.3333333333 },
			{ x: 39.0625, y: 53.3333333333 },
			{ x: 62.5, y: 53.3333333333 },
			{ x: 15.625, y: 78.3333333333 },
			{ x: 39.0625, y: 78.3333333333 },
			{ x: 62.5, y: 78.3333333333 }
		];

		const board = game.querySelector('[data-role="board"]');
		const scoreEl = game.querySelector('[data-role="score"]');
		const timeEl = game.querySelector('[data-role="time"]');
		const moleEl = game.querySelector('[data-role="mole"]');
		const overlay = game.querySelector('[data-role="overlay"]');
		const overlayTitle = game.querySelector('[data-role="overlay-title"]');
		const overlayText = game.querySelector('[data-role="overlay-text"]');
		const startBtn = game.querySelector('[data-role="start-btn"]');
		const restartBtn = game.querySelector('[data-role="restart-btn"]');

		const state = {
			score: 0,
			timeLeft: GAME_TIME,
			gameOver: false,
			running: false,
			currentHoleIndex: null,
			moleTimerId: null,
			countdownTimerId: null
		};

		function randomHoleIndex() {
			return Math.floor(Math.random() * holePositions.length);
		}

		function setMolePosition(index) {
			const pos = holePositions[index];
			moleEl.style.left = pos.x + '%';
			moleEl.style.top = pos.y + '%';
			moleEl.hidden = false;
			state.currentHoleIndex = index;
		}

		function moveMole() {
			if (state.gameOver || !state.running) {
				return;
			}

			let nextIndex = randomHoleIndex();

			if (holePositions.length > 1 && nextIndex === state.currentHoleIndex) {
				nextIndex = (nextIndex + 1) % holePositions.length;
			}

			setMolePosition(nextIndex);

			state.moleTimerId = window.setTimeout(moveMole, MOLE_MOVE_MS);
		}

		function updateHud() {
			scoreEl.textContent = String(state.score);
			timeEl.textContent = String(state.timeLeft);
		}

		function showOverlay(title, text, showStart) {
			overlayTitle.textContent = title;
			overlayText.textContent = text;
			startBtn.hidden = !showStart;
			restartBtn.hidden = false;
			overlay.hidden = false;
		}

		function hideOverlay() {
			overlay.hidden = true;
		}

		function clearTimers() {
			if (state.moleTimerId !== null) {
				window.clearTimeout(state.moleTimerId);
				state.moleTimerId = null;
			}
			if (state.countdownTimerId !== null) {
				window.clearTimeout(state.countdownTimerId);
				state.countdownTimerId = null;
			}
		}

		function endGame() {
			state.gameOver = true;
			state.running = false;
			clearTimers();
			moleEl.hidden = true;
			state.currentHoleIndex = null;
			showOverlay('Game Over', 'Final Score: ' + state.score, false);
			updateHud();
		}

		function tickTimer() {
			if (state.gameOver || !state.running) {
				return;
			}

			if (state.timeLeft > 0) {
				state.timeLeft -= 1;
				updateHud();

				if (state.timeLeft <= 0) {
					endGame();
					return;
				}

				state.countdownTimerId = window.setTimeout(tickTimer, 1000);
			}
		}

		function startGame() {
			clearTimers();
			state.score = 0;
			state.timeLeft = GAME_TIME;
			state.gameOver = false;
			state.running = true;
			state.currentHoleIndex = null;
			updateHud();
			hideOverlay();
			moveMole();
			state.countdownTimerId = window.setTimeout(tickTimer, 1000);
		}

		function whackMole() {
			if (state.gameOver || !state.running || state.currentHoleIndex === null) {
				return;
			}

			state.score += 1;
			updateHud();

			let nextIndex = randomHoleIndex();
			if (holePositions.length > 1 && nextIndex === state.currentHoleIndex) {
				nextIndex = (nextIndex + 1) % holePositions.length;
			}
			setMolePosition(nextIndex);
		}

		moleEl.addEventListener('click', function (e) {
			e.preventDefault();
			e.stopPropagation();
			whackMole();
		});

		moleEl.addEventListener('pointerdown', function (e) {
			e.preventDefault();
			e.stopPropagation();
			whackMole();
		});

		startBtn.addEventListener('click', function () {
			startGame();
			game.focus();
		});

		restartBtn.addEventListener('click', function () {
			startGame();
			game.focus();
		});

		game.addEventListener('keydown', function (e) {
			if (e.key === 'r' || e.key === 'R') {
				startGame();
				e.preventDefault();
			}
			if ((e.key === ' ' || e.key === 'Enter') && !state.running) {
				startGame();
				e.preventDefault();
			}
		});

		board.addEventListener('click', function () {
			game.focus();
		});

		holePositions.forEach(function (pos) {
			const hole = document.createElement('div');
			hole.className = 'wam-hole';
			hole.style.left = pos.x + '%';
			hole.style.top = pos.y + '%';
			board.appendChild(hole);
		});

		updateHud();
		moleEl.hidden = true;
		showOverlay('Whack-a-Mole', 'Click the mole to score. You have 30 seconds.', true);
	});
});
JS;

if (!function_exists('zo_game_whack_a_mole_render')) {
	function zo_game_whack_a_mole_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-whack-a-mole-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--whack-a-mole" id="<?php echo esc_attr($instance_id); ?>" tabindex="0">
			<div class="wam-title">Whack-a-Mole</div>
			<div class="wam-instructions">Click the mole to score points. You have 30 seconds. Press R to restart.</div>

			<div class="wam-topbar">
				<div class="wam-stat">Score: <span data-role="score">0</span></div>
				<div class="wam-stat">Time: <span data-role="time">30</span></div>
			</div>

			<div class="wam-board-wrap">
				<div class="wam-board" data-role="board">
					<div class="wam-mole" data-role="mole" hidden>
						<div class="wam-mole-head"></div>
						<div class="wam-eye wam-eye--left"></div>
						<div class="wam-eye wam-eye--right"></div>
						<div class="wam-nose"></div>
						<div class="wam-tooth wam-tooth--left"></div>
						<div class="wam-tooth wam-tooth--right"></div>
					</div>

					<div class="wam-overlay" data-role="overlay">
						<div class="wam-panel">
							<div class="wam-panel-title" data-role="overlay-title">Whack-a-Mole</div>
							<div class="wam-panel-text" data-role="overlay-text">Click the mole to score. You have 30 seconds.</div>
							<div class="wam-btn-row">
								<button type="button" class="wam-btn" data-role="start-btn">Start</button>
								<button type="button" class="wam-btn" data-role="restart-btn">Restart</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="wam-controls">Mouse or touch: whack the mole. Keyboard: R = restart.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'whack-a-mole',
	'name'            => 'Whack-a-Mole',
	'author'          => 'Arslan',
	'description'     => 'A browser-based whack-a-mole game with score, timer, restart, and touch support.',
	'render_callback' => 'zo_game_whack_a_mole_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);