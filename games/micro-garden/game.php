<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--micro-garden {
	max-width: 560px;
	margin: 0 auto;
	padding: 14px;
	border: 2px solid #d8e2ec;
	border-radius: 14px;
	background: #f8fbff;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-mg-title {
	text-align: center;
	margin: 0 0 10px;
}

.zo-mg-seq {
	font-weight: 700;
	text-align: center;
	min-height: 28px;
	font-size: 18px;
}

.zo-mg-tools,
.zo-mg-slots,
.zo-mg-hud,
.zo-mg-controls {
	display: grid;
	gap: 8px;
	margin-top: 10px;
}

.zo-mg-tools {
	grid-template-columns: repeat(3, 1fr);
}

.zo-mg-tool,
.zo-mg-slot,
.zo-mg-start,
.zo-mg-apply,
.zo-mg-clear,
.zo-mg-reset {
	border-radius: 10px;
	border: 0;
	padding: 10px;
	font-weight: 700;
	cursor: pointer;
}

.zo-mg-tool {
	color: #fff;
	background: #0f172a;
}

.zo-mg-tool[data-tool="water"] { background: #2563eb; }
.zo-mg-tool[data-tool="sun"] { background: #f59e0b; }
.zo-mg-tool[data-tool="compost"] { background: #16a34a; }

.zo-mg-slots {
	grid-template-columns: repeat(3, 1fr);
}

.zo-mg-slot {
	background: #e2e8f0;
	text-align: center;
}

.zo-mg-hud {
	grid-template-columns: repeat(2, 1fr);
}

.zo-mg-stat {
	background: #eef2ff;
	border-radius: 10px;
	padding: 10px;
	text-align: center;
}

.zo-mg-controls {
	grid-template-columns: repeat(3, 1fr);
}

.zo-mg-start,
.zo-mg-apply,
.zo-mg-clear,
.zo-mg-reset {
	background: #2563eb;
	color: #fff;
}

.zo-mg-status {
	min-height: 24px;
	text-align: center;
	font-weight: 700;
	margin-top: 10px;
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root');

	games.forEach(function (game) {
		if (!game.classList.contains('zo-game-root--micro-garden')) {
			return;
		}

		const message = game.querySelector('.zo-mg-seq');
		const status = game.querySelector('.zo-mg-status');
		const scoreEl = game.querySelector('.zo-mg-score');
		const livesEl = game.querySelector('.zo-mg-lives');
		const growthEl = game.querySelector('.zo-mg-growth');
		const toolButtons = game.querySelectorAll('.zo-mg-tool');
		const slotEls = game.querySelectorAll('.zo-mg-slot');
		const startBtn = game.querySelector('.zo-mg-start');
		const applyBtn = game.querySelector('.zo-mg-apply');
		const clearBtn = game.querySelector('.zo-mg-clear');
		const resetBtn = game.querySelector('.zo-mg-reset');

		let goal = [];
		let selected = [];
		let growth = 0;
		let score = 0;
		let lives = 3;
		const tools = ['water', 'sun', 'compost'];

		function updateHud() {
			scoreEl.textContent = String(score);
			livesEl.textContent = String(lives);
			growthEl.textContent = String(growth);
		}

		function randomTool() {
			return tools[Math.floor(Math.random() * tools.length)];
		}

		function newSequence() {
			goal = [];
			for (let i = 0; i < 3; i++) {
				goal.push(randomTool());
			}
			selected = [];
			renderSlots();
			message.textContent = 'Watch: ' + '???';
			toolButtons.forEach(function (button) {
				button.disabled = false;
			});
			applyBtn.disabled = true;
			showPlan();
		}

		function showPlan() {
			let index = 0;
			function step() {
				if (index >= goal.length) {
					message.textContent = 'Build the sequence.';
					return;
				}
				const current = goal[index];
				message.textContent = 'Use: ' + current.toUpperCase() + ' first';
				index += 1;
				setTimeout(step, 700);
			}
			step();
		}

		function renderSlots() {
			slotEls.forEach(function (slot, index) {
				slot.textContent = selected[index] ? selected[index] : '';
			});
		}

		function canApply() {
			return selected.length === 3 && selected.every(function (item, i) {
				return item === goal[i];
			});
		}

		function clearSelection() {
			selected = [];
			renderSlots();
			applyBtn.disabled = true;
		}

		toolButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				if (selected.length >= 3) {
					return;
				}
				const tool = button.dataset.tool;
				selected.push(tool);
				renderSlots();
				applyBtn.disabled = selected.length !== 3;
			});
		});

		applyBtn.addEventListener('click', function () {
			if (!canApply()) {
				lives -= 1;
				status.textContent = 'Wrong order.';
				if (lives <= 0) {
					status.textContent = 'Game over.';
					toolButtons.forEach(function (button) {
						button.disabled = true;
					});
				}
				updateHud();
				return;
			}
			score += 1;
			growth += 1;
			status.textContent = 'Great job! Plant grew.';
			updateHud();
			newSequence();
		});

		clearBtn.addEventListener('click', function () {
			clearSelection();
			status.textContent = 'Sequence cleared.';
		});

		resetBtn.addEventListener('click', function () {
			score = 0;
			lives = 3;
			growth = 0;
			updateHud();
			message.textContent = 'Press Start.';
			status.textContent = 'Press Start.';
			toolButtons.forEach(function (button) {
				button.disabled = true;
			});
			applyBtn.disabled = true;
			clearSelection();
		});

		startBtn.addEventListener('click', function () {
			score = 0;
			lives = 3;
			growth = 0;
			updateHud();
			newSequence();
		});

		updateHud();
		toolButtons.forEach(function (button) {
			button.disabled = true;
		});
		applyBtn.disabled = true;
		message.textContent = 'Press Start.';
		status.textContent = 'Press Start.';
	});
});
JS;

if (!function_exists('zo_game_micro_garden_render')) {
	function zo_game_micro_garden_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-micro-garden-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--micro-garden" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-mg-title">Micro Garden</h2>
			<div class="zo-mg-seq">Press Start.</div>
			<div class="zo-mg-tools">
				<button type="button" class="zo-mg-tool" data-tool="water">Water</button>
				<button type="button" class="zo-mg-tool" data-tool="sun">Sun</button>
				<button type="button" class="zo-mg-tool" data-tool="compost">Compost</button>
			</div>
			<div class="zo-mg-slots">
				<button type="button" class="zo-mg-slot" disabled></button>
				<button type="button" class="zo-mg-slot" disabled></button>
				<button type="button" class="zo-mg-slot" disabled></button>
			</div>
			<div class="zo-mg-hud">
				<div class="zo-mg-stat">Score: <span class="zo-mg-score">0</span></div>
				<div class="zo-mg-stat">Lives: <span class="zo-mg-lives">3</span></div>
				<div class="zo-mg-stat">Growth: <span class="zo-mg-growth">0</span></div>
			</div>
			<div class="zo-mg-controls">
				<button type="button" class="zo-mg-start">Start</button>
				<button type="button" class="zo-mg-apply">Apply</button>
				<button type="button" class="zo-mg-clear">Clear</button>
				<button type="button" class="zo-mg-reset">Reset</button>
			</div>
			<div class="zo-mg-status">Press Start.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'micro-garden',
	'name'            => 'Micro Garden',
	'author'          => 'Asker',
	'description'     => 'Read the sequence and apply Water, Sun, Compost in the right order to grow the plant.',
	'render_callback' => 'zo_game_micro_garden_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
