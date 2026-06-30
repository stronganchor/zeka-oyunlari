<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--robot-designer {
	max-width: 720px;
	margin: 0 auto;
	padding: 20px;
	background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
	border-radius: 18px;
	color: #ffffff;
	box-sizing: border-box;
	font-family: inherit;
}

.zo-game-root--robot-designer * {
	box-sizing: border-box;
}

.zo-game-root--robot-designer h2 {
	margin: 0 0 10px;
	font-size: 26px;
}

.zo-game-root--robot-designer p {
	margin: 0 0 12px;
	font-size: 14px;
	color: #cbd5e1;
}

.zo-game-root--robot-designer .zo-rd-mission {
	background: rgba(255,255,255,0.08);
	padding: 12px 14px;
	border-radius: 14px;
	margin-bottom: 14px;
	font-weight: 600;
}

.zo-game-root--robot-designer .zo-rd-stats {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 8px;
	margin-bottom: 14px;
	font-size: 13px;
}

.zo-game-root--robot-designer .zo-rd-stat {
	background: rgba(255,255,255,0.08);
	border-radius: 10px;
	padding: 8px;
	text-align: center;
}

.zo-game-root--robot-designer .zo-rd-sections {
	display: grid;
	gap: 14px;
	margin-bottom: 14px;
}

.zo-game-root--robot-designer .zo-rd-section {
	background: rgba(255,255,255,0.06);
	border-radius: 14px;
	padding: 10px;
}

.zo-game-root--robot-designer .zo-rd-section h3 {
	margin: 0 0 8px;
	font-size: 14px;
}

.zo-game-root--robot-designer .zo-rd-options {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-game-root--robot-designer .zo-rd-option {
	border: none;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 13px;
	font-weight: 700;
	cursor: pointer;
	background: #38bdf8;
	color: #0f172a;
}

.zo-game-root--robot-designer .zo-rd-option.selected {
	background: #22c55e;
}

.zo-game-root--robot-designer .zo-rd-controls {
	display: flex;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--robot-designer .zo-rd-btn {
	border: none;
	border-radius: 999px;
	padding: 10px 16px;
	font-weight: 700;
	cursor: pointer;
	background: #facc15;
	color: #111827;
}

.zo-game-root--robot-designer .zo-rd-btn-secondary {
	background: #e5e7eb;
}

.zo-game-root--robot-designer .zo-rd-status {
	min-height: 24px;
	margin-top: 10px;
	font-weight: 600;
	color: #facc15;
}

@media (max-width: 600px) {
	.zo-game-root--robot-designer .zo-rd-stats {
		grid-template-columns: repeat(2, 1fr);
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--robot-designer');

	games.forEach(function (game) {

		const missionEl = game.querySelector('.zo-rd-mission-text');
		const statsEls = {
			power: game.querySelector('.zo-rd-power'),
			speed: game.querySelector('.zo-rd-speed'),
			defense: game.querySelector('.zo-rd-defense'),
			intel: game.querySelector('.zo-rd-intel')
		};
		const testBtn = game.querySelector('.zo-rd-test');
		const newMissionBtn = game.querySelector('.zo-rd-new');
		const statusEl = game.querySelector('.zo-rd-status');

		const missions = [
			{
				text: 'Rescue mission in a collapsed building.',
				requirements: { power: 6, speed: 4, defense: 7, intel: 5 }
			},
			{
				text: 'Race across rough desert terrain.',
				requirements: { power: 5, speed: 8, defense: 4, intel: 4 }
			},
			{
				text: 'Analyze a research facility safety map.',
				requirements: { power: 3, speed: 4, defense: 4, intel: 9 }
			},
			{
				text: 'Defend the city from attacking drones.',
				requirements: { power: 8, speed: 6, defense: 8, intel: 6 }
			}
		];

		const parts = {
			body: [
				{ name: 'Light Frame', power: 2, speed: 3, defense: 2, intel: 1 },
				{ name: 'Balanced Frame', power: 4, speed: 4, defense: 4, intel: 3 },
				{ name: 'Heavy Armor', power: 6, speed: 2, defense: 7, intel: 2 }
			],
			legs: [
				{ name: 'Wheels', power: 2, speed: 6, defense: 2, intel: 1 },
				{ name: 'Hydraulic Legs', power: 4, speed: 4, defense: 3, intel: 1 },
				{ name: 'Tracked Base', power: 5, speed: 3, defense: 5, intel: 1 }
			],
			weapon: [
				{ name: 'Energy Blaster', power: 6, speed: 2, defense: 1, intel: 2 },
				{ name: 'Shield System', power: 2, speed: 1, defense: 6, intel: 2 },
				{ name: 'Research Scanner', power: 1, speed: 2, defense: 1, intel: 7 }
			]
		};

		let currentMission = null;
		let selected = { body: 0, legs: 0, weapon: 0 };

		function randomMission() {
			currentMission = missions[Math.floor(Math.random() * missions.length)];
			missionEl.textContent = currentMission.text;
			statusEl.textContent = 'Choose parts wisely.';
		}

		function calculateStats() {
			const total = { power: 0, speed: 0, defense: 0, intel: 0 };
			Object.keys(parts).forEach(function (section) {
				const part = parts[section][selected[section]];
				total.power += part.power;
				total.speed += part.speed;
				total.defense += part.defense;
				total.intel += part.intel;
			});
			return total;
		}

		function updateStatsDisplay() {
			const total = calculateStats();
			statsEls.power.textContent = total.power;
			statsEls.speed.textContent = total.speed;
			statsEls.defense.textContent = total.defense;
			statsEls.intel.textContent = total.intel;
		}

		function renderOptions() {
			Object.keys(parts).forEach(function (section) {
				const container = game.querySelector('.zo-rd-options-' + section);
				container.innerHTML = '';

				parts[section].forEach(function (part, index) {
					const btn = document.createElement('button');
					btn.type = 'button';
					btn.className = 'zo-rd-option';
					btn.textContent = part.name;

					if (selected[section] === index) {
						btn.classList.add('selected');
					}

					btn.addEventListener('click', function () {
						selected[section] = index;
						renderOptions();
						updateStatsDisplay();
					});

					container.appendChild(btn);
				});
			});
		}

		function testRobot() {
			const total = calculateStats();
			const req = currentMission.requirements;

			let success = true;
			Object.keys(req).forEach(function (key) {
				if (total[key] < req[key]) {
					success = false;
				}
			});

			if (success) {
				statusEl.textContent = 'Mission success. Robot performed well.';
			} else {
				statusEl.textContent = 'Mission failed. Adjust your design.';
			}
		}

		testBtn.addEventListener('click', function () {
			testRobot();
		});

		newMissionBtn.addEventListener('click', function () {
			randomMission();
		});

		randomMission();
		renderOptions();
		updateStatsDisplay();
	});
});
JS;

if (!function_exists('zo_game_robot_designer_render')) {
	function zo_game_robot_designer_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-robot-designer-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--robot-designer" id="<?php echo esc_attr($instance_id); ?>">
			<h2>Robot Designer</h2>
			<p>Select robot parts and try to complete the mission.</p>

			<div class="zo-rd-mission">
				Mission: <span class="zo-rd-mission-text"></span>
			</div>

			<div class="zo-rd-stats">
				<div class="zo-rd-stat">Power: <strong class="zo-rd-power">0</strong></div>
				<div class="zo-rd-stat">Speed: <strong class="zo-rd-speed">0</strong></div>
				<div class="zo-rd-stat">Defense: <strong class="zo-rd-defense">0</strong></div>
				<div class="zo-rd-stat">Intel: <strong class="zo-rd-intel">0</strong></div>
			</div>

			<div class="zo-rd-sections">
				<div class="zo-rd-section">
					<h3>Body</h3>
					<div class="zo-rd-options zo-rd-options-body"></div>
				</div>
				<div class="zo-rd-section">
					<h3>Movement</h3>
					<div class="zo-rd-options zo-rd-options-legs"></div>
				</div>
				<div class="zo-rd-section">
					<h3>Special System</h3>
					<div class="zo-rd-options zo-rd-options-weapon"></div>
				</div>
			</div>

			<div class="zo-rd-controls">
				<button type="button" class="zo-rd-btn zo-rd-test">Test Mission</button>
				<button type="button" class="zo-rd-btn zo-rd-btn-secondary zo-rd-new">New Mission</button>
			</div>

			<div class="zo-rd-status"></div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'robot-designer',
	'name'            => 'Robot Designer',
	'author'          => 'Asker',
	'description'     => 'Build a robot and match its stats to different missions.',
	'render_callback' => 'zo_game_robot_designer_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
