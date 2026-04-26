<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--jungle-drum-guardians {
	--zdg-ink: #10261c;
	--zdg-soft: #335a45;
	--zdg-leaf: #166534;
	max-width: 980px;
	margin: 0 auto;
	padding: 20px;
	border-radius: 24px;
	border: 2px solid rgba(22, 101, 52, 0.18);
	background:
		radial-gradient(circle at top left, rgba(132, 204, 22, 0.18), transparent 28%),
		linear-gradient(180deg, #ecfccb 0%, #d9f99d 100%);
	box-sizing: border-box;
	font-family: "Trebuchet MS", Verdana, sans-serif;
	color: var(--zdg-ink);
}

.zo-game-root--jungle-drum-guardians .zo-zdg-title {
	margin: 0 0 8px;
	font-size: 34px;
	text-align: center;
	color: #14532d;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-desc {
	margin: 0 0 18px;
	text-align: center;
	line-height: 1.55;
	color: var(--zdg-soft);
}

.zo-game-root--jungle-drum-guardians .zo-zdg-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-stat,
.zo-game-root--jungle-drum-guardians .zo-zdg-panel {
	padding: 12px;
	border-radius: 16px;
	background: rgba(255, 255, 255, 0.7);
	border: 1px solid rgba(22, 101, 52, 0.12);
}

.zo-game-root--jungle-drum-guardians .zo-zdg-stat-label {
	display: block;
	margin-bottom: 4px;
	font-size: 12px;
	text-transform: uppercase;
	letter-spacing: 0.08em;
	color: #15803d;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-main {
	display: grid;
	grid-template-columns: 1.1fr 0.9fr;
	gap: 14px;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-board {
	display: grid;
	grid-template-columns: repeat(7, minmax(0, 1fr));
	gap: 6px;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-cell {
	position: relative;
	aspect-ratio: 1;
	border-radius: 12px;
	background: rgba(20, 83, 45, 0.08);
	border: 1px solid rgba(22, 101, 52, 0.12);
}

.zo-game-root--jungle-drum-guardians .zo-zdg-cell.is-sight {
	box-shadow: inset 0 0 0 999px rgba(239, 68, 68, 0.18);
}

.zo-game-root--jungle-drum-guardians .zo-zdg-cell.is-player::after {
	content: "";
	position: absolute;
	inset: 24%;
	border-radius: 999px;
	background: #166534;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-cell.is-goal::before {
	content: "";
	position: absolute;
	inset: 28%;
	border-radius: 999px;
	background: #eab308;
	box-shadow: 0 0 18px rgba(234, 179, 8, 0.55);
}

.zo-game-root--jungle-drum-guardians .zo-zdg-cell.is-guardian::after {
	content: "O";
	position: absolute;
	right: 8px;
	top: 50%;
	transform: translateY(-50%);
	font-size: 14px;
	font-weight: 700;
	color: #7f1d1d;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-subtitle {
	margin: 0 0 10px;
	font-size: 18px;
	color: #14532d;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-actions {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
	margin-top: 10px;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-button {
	border: 0;
	border-radius: 14px;
	padding: 12px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	background: #166534;
	color: #ffffff;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-button--power {
	background: #ca8a04;
	color: #2b1a00;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-button--reset {
	background: #ffffff;
	color: #14532d;
	border: 1px solid rgba(22, 101, 52, 0.16);
}

.zo-game-root--jungle-drum-guardians .zo-zdg-button:disabled {
	opacity: 0.5;
	cursor: default;
}

.zo-game-root--jungle-drum-guardians .zo-zdg-status,
.zo-game-root--jungle-drum-guardians .zo-zdg-help {
	line-height: 1.55;
	color: var(--zdg-soft);
}

@media (max-width: 860px) {
	.zo-game-root--jungle-drum-guardians {
		padding: 14px;
	}

	.zo-game-root--jungle-drum-guardians .zo-zdg-top {
		grid-template-columns: 1fr 1fr;
	}

	.zo-game-root--jungle-drum-guardians .zo-zdg-main {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--jungle-drum-guardians');

	roots.forEach(function (root) {
		const boardEl = root.querySelector('.zo-zdg-board');
		const depthEl = root.querySelector('.zo-zdg-depth');
		const drumEl = root.querySelector('.zo-zdg-drum');
		const birdsEl = root.querySelector('.zo-zdg-birds');
		const shadowEl = root.querySelector('.zo-zdg-shadow');
		const statusEl = root.querySelector('.zo-zdg-status');

		const buttons = {
			up: root.querySelector('.zo-zdg-button--up'),
			down: root.querySelector('.zo-zdg-button--down'),
			advance: root.querySelector('.zo-zdg-button--advance'),
			drum: root.querySelector('.zo-zdg-button--drum'),
			birds: root.querySelector('.zo-zdg-button--birds'),
			shadow: root.querySelector('.zo-zdg-button--shadow'),
			reset: root.querySelector('.zo-zdg-button--reset')
		};

		const lanes = 4;
		const columns = 7;
		const dangerPattern = [1, 2, 0, 3, 1, 3, 2, 0];
		const goal = { lane: 2, column: 6 };

		let state = null;

		function currentSightLane() {
			return dangerPattern[state.turn % dangerPattern.length];
		}

		function render() {
			const sightLane = currentSightLane();
			boardEl.innerHTML = '';

			for (let lane = 0; lane < lanes; lane += 1) {
				for (let column = 0; column < columns; column += 1) {
					const cell = document.createElement('div');
					cell.className = 'zo-zdg-cell';

					if (lane === sightLane) {
						cell.classList.add('is-sight');
					}
					if (column === columns - 1 && lane === sightLane) {
						cell.classList.add('is-guardian');
					}
					if (lane === goal.lane && column === goal.column) {
						cell.classList.add('is-goal');
					}
					if (lane === state.playerLane && column === state.playerColumn) {
						cell.classList.add('is-player');
					}

					boardEl.appendChild(cell);
				}
			}

			depthEl.textContent = String(state.playerColumn) + ' / ' + String(goal.column);
			drumEl.textContent = String(state.drum);
			birdsEl.textContent = String(state.birds);
			shadowEl.textContent = String(state.shadow);
			statusEl.textContent = state.message;

			buttons.drum.disabled = state.gameOver || state.drum <= 0;
			buttons.birds.disabled = state.gameOver || state.birds <= 0;
			buttons.shadow.disabled = state.gameOver || state.shadow <= 0;
			buttons.up.disabled = state.gameOver;
			buttons.down.disabled = state.gameOver;
			buttons.advance.disabled = state.gameOver;
		}

		function startState() {
			state = {
				playerLane: 1,
				playerColumn: 0,
				drum: 3,
				birds: 3,
				shadow: 3,
				turn: 0,
				gameOver: false,
				message: 'Each action moves you one step deeper into the jungle. Stay out of the watched lane.'
			};
			render();
		}

		function resolveTurn(nextLane, nextColumn, manipulatedLane, hiddenThisTurn, actionText) {
			state.playerLane = Math.max(0, Math.min(lanes - 1, nextLane));
			state.playerColumn = Math.min(columns - 1, nextColumn);

			if (!hiddenThisTurn && state.playerLane === manipulatedLane) {
				state.gameOver = true;
				state.message = actionText + ' A guardian locks onto your trail.';
				render();
				return;
			}

			if (state.playerLane === goal.lane && state.playerColumn === goal.column) {
				state.gameOver = true;
				state.message = actionText + ' The relic is yours and the guardians are behind you.';
				render();
				return;
			}

			state.turn += 1;
			state.message = actionText + ' The guardians shift again.';
			render();
		}

		function act(type) {
			if (state.gameOver) {
				return;
			}

			let lane = state.playerLane;
			let column = state.playerColumn + 1;
			let sightLane = currentSightLane();
			let hidden = false;
			let actionText = 'You move through the ferns.';

			if (type === 'up') {
				lane -= 1;
				actionText = 'You slip to a higher path.';
			} else if (type === 'down') {
				lane += 1;
				actionText = 'You drop to a lower path.';
			} else if (type === 'advance') {
				actionText = 'You rush forward while the jungle stays silent.';
			} else if (type === 'drum') {
				if (state.drum <= 0) {
					return;
				}
				state.drum -= 1;
				sightLane = Math.max(0, sightLane - 1);
				actionText = 'A drumbeat pulls the stone gaze upward.';
			} else if (type === 'birds') {
				if (state.birds <= 0) {
					return;
				}
				state.birds -= 1;
				sightLane = Math.min(lanes - 1, sightLane + 1);
				actionText = 'Birds explode from the canopy and drag the guardians lower.';
			} else if (type === 'shadow') {
				if (state.shadow <= 0) {
					return;
				}
				state.shadow -= 1;
				hidden = true;
				actionText = 'Moving shadows hide your silhouette for a heartbeat.';
			}

			resolveTurn(lane, column, sightLane, hidden, actionText);
		}

		buttons.up.addEventListener('click', function () {
			act('up');
		});
		buttons.down.addEventListener('click', function () {
			act('down');
		});
		buttons.advance.addEventListener('click', function () {
			act('advance');
		});
		buttons.drum.addEventListener('click', function () {
			act('drum');
		});
		buttons.birds.addEventListener('click', function () {
			act('birds');
		});
		buttons.shadow.addEventListener('click', function () {
			act('shadow');
		});
		buttons.reset.addEventListener('click', startState);

		startState();
	});
});
JS;

if (!function_exists('zo_game_jungle_drum_guardians_render')) {
	function zo_game_jungle_drum_guardians_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-jungle-drum-guardians-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--jungle-drum-guardians" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-zdg-title">Jungle Drum Guardians</h2>
			<p class="zo-zdg-desc">Ancient stone guardians watch one lane at a time. Use drums, birds, and moving shadows to shift their gaze long enough to reach the glowing relic.</p>

			<div class="zo-zdg-top">
				<div class="zo-zdg-stat">
					<span class="zo-zdg-stat-label">Depth</span>
					<span class="zo-zdg-stat-value zo-zdg-depth">0 / 6</span>
				</div>
				<div class="zo-zdg-stat">
					<span class="zo-zdg-stat-label">Drums</span>
					<span class="zo-zdg-stat-value zo-zdg-drum">3</span>
				</div>
				<div class="zo-zdg-stat">
					<span class="zo-zdg-stat-label">Birds</span>
					<span class="zo-zdg-stat-value zo-zdg-birds">3</span>
				</div>
				<div class="zo-zdg-stat">
					<span class="zo-zdg-stat-label">Shadows</span>
					<span class="zo-zdg-stat-value zo-zdg-shadow">3</span>
				</div>
			</div>

			<div class="zo-zdg-main">
				<div class="zo-zdg-panel">
					<h3 class="zo-zdg-subtitle">Guardian Paths</h3>
					<div class="zo-zdg-board"></div>
				</div>

				<div class="zo-zdg-panel">
					<h3 class="zo-zdg-subtitle">Actions</h3>
					<p class="zo-zdg-status" aria-live="polite"></p>

					<div class="zo-zdg-actions">
						<button type="button" class="zo-zdg-button zo-zdg-button--up">Move Up</button>
						<button type="button" class="zo-zdg-button zo-zdg-button--advance">Advance</button>
						<button type="button" class="zo-zdg-button zo-zdg-button--down">Move Down</button>
					</div>

					<div class="zo-zdg-actions">
						<button type="button" class="zo-zdg-button zo-zdg-button--power zo-zdg-button--drum">Drum</button>
						<button type="button" class="zo-zdg-button zo-zdg-button--power zo-zdg-button--birds">Birds</button>
						<button type="button" class="zo-zdg-button zo-zdg-button--power zo-zdg-button--shadow">Shadow</button>
					</div>

					<div class="zo-zdg-actions">
						<button type="button" class="zo-zdg-button zo-zdg-button--reset">Reset Run</button>
					</div>

					<p class="zo-zdg-help">Every action moves you one column to the right. Red lanes are being watched on the current turn, unless you bend that gaze with a distraction.</p>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'jungle-drum-guardians',
	'name' => 'Jungle Drum Guardians',
	'author' => 'asker',
	'description' => 'A jungle stealth game where you distract ancient stone guardians with drums, birds, and moving shadows.',
	'render_callback' => 'zo_game_jungle_drum_guardians_render',
	'inline_style' => $css,
	'inline_script' => $js,
);
