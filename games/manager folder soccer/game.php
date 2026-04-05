<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--mini-manager {
	max-width: 760px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
	color: #1f2a1f;
}

.zo-game-root--mini-manager * {
	box-sizing: border-box;
}

.zo-mini-manager-wrap {
	background: #f4f7f2;
	border: 2px solid #d7e0d0;
	border-radius: 18px;
	padding: 14px;
}

.zo-mini-manager-top {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-mini-manager-panel {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 12px;
	padding: 10px 12px;
	min-width: 120px;
	text-align: center;
}

.zo-mini-manager-panel strong {
	display: block;
	font-size: 20px;
	color: #1d2a1d;
}

.zo-mini-manager-panel span {
	display: block;
	font-size: 13px;
	color: #445244;
	margin-top: 4px;
}

.zo-mini-manager-sections {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 12px;
	margin-bottom: 12px;
}

.zo-mini-manager-card {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 14px;
	padding: 12px;
}

.zo-mini-manager-card h3 {
	margin: 0 0 10px;
	font-size: 18px;
}

.zo-mini-manager-row {
	display: grid;
	grid-template-columns: 120px 1fr 44px;
	align-items: center;
	gap: 8px;
	margin-bottom: 10px;
	font-size: 14px;
}

.zo-mini-manager-row:last-child {
	margin-bottom: 0;
}

.zo-mini-manager-row input[type="range"] {
	width: 100%;
}

.zo-mini-manager-value {
	font-weight: 700;
	text-align: center;
}

.zo-mini-manager-formations {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-bottom: 10px;
}

.zo-mini-manager-btn {
	border: none;
	border-radius: 10px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	background: #1d2a1d;
	color: #fff;
}

.zo-mini-manager-btn:hover {
	opacity: 0.92;
}

.zo-mini-manager-btn.is-active {
	background: #1565c0;
}

.zo-mini-manager-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-mini-manager-field-card {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 14px;
	padding: 12px;
	margin-bottom: 12px;
}

.zo-mini-manager-field {
	position: relative;
	width: 100%;
	height: 420px;
	border-radius: 16px;
	overflow: hidden;
	border: 4px solid #fff;
	background:
		linear-gradient(
			to bottom,
			#3aa655 0%,
			#3aa655 10%,
			#349a4f 10%,
			#349a4f 20%,
			#3aa655 20%,
			#3aa655 30%,
			#349a4f 30%,
			#349a4f 40%,
			#3aa655 40%,
			#3aa655 50%,
			#349a4f 50%,
			#349a4f 60%,
			#3aa655 60%,
			#3aa655 70%,
			#349a4f 70%,
			#349a4f 80%,
			#3aa655 80%,
			#3aa655 90%,
			#349a4f 90%,
			#349a4f 100%
		);
}

.zo-mini-manager-line-mid,
.zo-mini-manager-circle,
.zo-mini-manager-dot,
.zo-mini-manager-box-left,
.zo-mini-manager-box-right,
.zo-mini-manager-goal-left,
.zo-mini-manager-goal-right {
	position: absolute;
	pointer-events: none;
}

.zo-mini-manager-line-mid {
	left: 50%;
	top: 0;
	width: 4px;
	height: 100%;
	margin-left: -2px;
	background: rgba(255,255,255,0.95);
}

.zo-mini-manager-circle {
	left: 50%;
	top: 50%;
	width: 110px;
	height: 110px;
	margin-left: -55px;
	margin-top: -55px;
	border: 4px solid rgba(255,255,255,0.95);
	border-radius: 50%;
}

.zo-mini-manager-dot {
	width: 10px;
	height: 10px;
	background: rgba(255,255,255,0.95);
	border-radius: 50%;
	left: 50%;
	top: 50%;
	margin-left: -5px;
	margin-top: -5px;
}

.zo-mini-manager-box-left,
.zo-mini-manager-box-right {
	top: 120px;
	width: 90px;
	height: 180px;
	border: 4px solid rgba(255,255,255,0.95);
}

.zo-mini-manager-box-left {
	left: 0;
	border-left: none;
	border-radius: 0 10px 10px 0;
}

.zo-mini-manager-box-right {
	right: 0;
	border-right: none;
	border-radius: 10px 0 0 10px;
}

.zo-mini-manager-goal-left,
.zo-mini-manager-goal-right {
	top: 160px;
	width: 16px;
	height: 100px;
	background: rgba(255,255,255,0.95);
}

.zo-mini-manager-goal-left {
	left: 0;
	border-radius: 0 6px 6px 0;
}

.zo-mini-manager-goal-right {
	right: 0;
	border-radius: 6px 0 0 6px;
}

.zo-mini-manager-player {
	position: absolute;
	width: 24px;
	height: 24px;
	margin-left: -12px;
	margin-top: -12px;
	border-radius: 50%;
	border: 2px solid rgba(255,255,255,0.95);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 9px;
	font-weight: 700;
	color: #fff;
}

.zo-mini-manager-player--blue {
	background: #1e88e5;
}

.zo-mini-manager-player--red {
	background: #e53935;
}

.zo-mini-manager-status {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 14px;
	padding: 12px;
	text-align: center;
	font-size: 15px;
	line-height: 1.45;
}

.zo-mini-manager-log {
	margin-top: 10px;
	padding-top: 10px;
	border-top: 1px solid #dfe7d8;
	font-size: 14px;
	color: #445244;
	min-height: 22px;
}

.zo-mini-manager-help {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 14px;
	padding: 12px;
	font-size: 14px;
	line-height: 1.5;
	margin-top: 12px;
}

@media (max-width: 700px) {
	.zo-mini-manager-sections {
		grid-template-columns: 1fr;
	}

	.zo-mini-manager-field {
		height: 340px;
	}

	.zo-mini-manager-row {
		grid-template-columns: 105px 1fr 40px;
		font-size: 13px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--mini-manager');

	games.forEach(function (game) {
		const field = game.querySelector('.zo-mini-manager-field');
		const formationButtons = game.querySelectorAll('.zo-mini-manager-formation');
		const simulateBtn = game.querySelector('.zo-mini-manager-simulate');
		const resetBtn = game.querySelector('.zo-mini-manager-reset');

		const attackInput = game.querySelector('.zo-mini-manager-attack');
		const midfieldInput = game.querySelector('.zo-mini-manager-midfield');
		const defenseInput = game.querySelector('.zo-mini-manager-defense');
		const energyInput = game.querySelector('.zo-mini-manager-energy');

		const attackValue = game.querySelector('.zo-mini-manager-attack-value');
		const midfieldValue = game.querySelector('.zo-mini-manager-midfield-value');
		const defenseValue = game.querySelector('.zo-mini-manager-defense-value');
		const energyValue = game.querySelector('.zo-mini-manager-energy-value');

		const scoreBlue = game.querySelector('.zo-mini-manager-score-blue');
		const scoreRed = game.querySelector('.zo-mini-manager-score-red');
		const winsValue = game.querySelector('.zo-mini-manager-wins');
		const coinsValue = game.querySelector('.zo-mini-manager-coins');
		const ratingValue = game.querySelector('.zo-mini-manager-rating');
		const statusText = game.querySelector('.zo-mini-manager-status-text');
		const logText = game.querySelector('.zo-mini-manager-log');

		let formation = '4-4-2';
		let wins = 0;
		let coins = 0;
		let teamRating = 60;
		let playerNodes = [];
		let lastBlue = 0;
		let lastRed = 0;

		const blueFormationMap = {
			'4-4-2': [
				{ x: 8, y: 50, t: 'GK' },
				{ x: 20, y: 18, t: 'D' },
				{ x: 20, y: 38, t: 'D' },
				{ x: 20, y: 62, t: 'D' },
				{ x: 20, y: 82, t: 'D' },
				{ x: 40, y: 18, t: 'M' },
				{ x: 40, y: 38, t: 'M' },
				{ x: 40, y: 62, t: 'M' },
				{ x: 40, y: 82, t: 'M' },
				{ x: 62, y: 36, t: 'F' },
				{ x: 62, y: 64, t: 'F' }
			],
			'4-3-3': [
				{ x: 8, y: 50, t: 'GK' },
				{ x: 20, y: 18, t: 'D' },
				{ x: 20, y: 38, t: 'D' },
				{ x: 20, y: 62, t: 'D' },
				{ x: 20, y: 82, t: 'D' },
				{ x: 40, y: 28, t: 'M' },
				{ x: 40, y: 50, t: 'M' },
				{ x: 40, y: 72, t: 'M' },
				{ x: 64, y: 20, t: 'F' },
				{ x: 68, y: 50, t: 'F' },
				{ x: 64, y: 80, t: 'F' }
			],
			'5-3-2': [
				{ x: 8, y: 50, t: 'GK' },
				{ x: 18, y: 12, t: 'D' },
				{ x: 20, y: 30, t: 'D' },
				{ x: 20, y: 50, t: 'D' },
				{ x: 20, y: 70, t: 'D' },
				{ x: 18, y: 88, t: 'D' },
				{ x: 42, y: 26, t: 'M' },
				{ x: 42, y: 50, t: 'M' },
				{ x: 42, y: 74, t: 'M' },
				{ x: 64, y: 38, t: 'F' },
				{ x: 64, y: 62, t: 'F' }
			]
		};

		const enemyFormation = [
			{ x: 92, y: 50, t: 'GK' },
			{ x: 80, y: 18, t: 'D' },
			{ x: 80, y: 38, t: 'D' },
			{ x: 80, y: 62, t: 'D' },
			{ x: 80, y: 82, t: 'D' },
			{ x: 60, y: 18, t: 'M' },
			{ x: 60, y: 38, t: 'M' },
			{ x: 60, y: 62, t: 'M' },
			{ x: 60, y: 82, t: 'M' },
			{ x: 38, y: 36, t: 'F' },
			{ x: 38, y: 64, t: 'F' }
		];

		function randomBetween(min, max) {
			return Math.random() * (max - min) + min;
		}

		function updateSliderValues() {
			attackValue.textContent = attackInput.value;
			midfieldValue.textContent = midfieldInput.value;
			defenseValue.textContent = defenseInput.value;
			energyValue.textContent = energyInput.value;
		}

		function updatePanels() {
			scoreBlue.textContent = String(lastBlue);
			scoreRed.textContent = String(lastRed);
			winsValue.textContent = String(wins);
			coinsValue.textContent = String(coins);
			ratingValue.textContent = String(teamRating);
		}

		function clearPlayers() {
			playerNodes.forEach(function (node) {
				node.remove();
			});
			playerNodes = [];
		}

		function addPlayer(x, y, label, team) {
			const node = document.createElement('div');
			node.className = 'zo-mini-manager-player zo-mini-manager-player--' + team;
			node.style.left = x + '%';
			node.style.top = y + '%';
			node.textContent = label;
			field.appendChild(node);
			playerNodes.push(node);
		}

		function renderFormation() {
			clearPlayers();

			blueFormationMap[formation].forEach(function (player) {
				addPlayer(player.x, player.y, player.t, 'blue');
			});

			enemyFormation.forEach(function (player) {
				addPlayer(player.x, player.y, player.t, 'red');
			});

			formationButtons.forEach(function (button) {
				button.classList.toggle('is-active', button.getAttribute('data-formation') === formation);
			});
		}

		function getFormationBonus() {
			if (formation === '4-3-3') {
				return { attack: 8, midfield: 2, defense: -2 };
			}
			if (formation === '5-3-2') {
				return { attack: -1, midfield: 1, defense: 9 };
			}
			return { attack: 3, midfield: 3, defense: 3 };
		}

		function simulateMatch() {
			const attack = parseInt(attackInput.value, 10);
			const midfield = parseInt(midfieldInput.value, 10);
			const defense = parseInt(defenseInput.value, 10);
			const energy = parseInt(energyInput.value, 10);

			const formationBonus = getFormationBonus();

			const blueAttack = attack + formationBonus.attack + Math.round(energy * 0.18);
			const blueMid = midfield + formationBonus.midfield + Math.round(energy * 0.12);
			const blueDef = defense + formationBonus.defense + Math.round(energy * 0.10);

			const enemyAttack = 58 + randomBetween(-8, 8);
			const enemyMid = 58 + randomBetween(-8, 8);
			const enemyDef = 58 + randomBetween(-8, 8);

			const blueChance = (blueAttack * 0.42) + (blueMid * 0.33) - (enemyDef * 0.22) + randomBetween(-8, 8);
			const redChance = (enemyAttack * 0.40) + (enemyMid * 0.30) - (blueDef * 0.24) + randomBetween(-8, 8);

			let blueGoals = Math.max(0, Math.round((blueChance - 30) / 22));
			let redGoals = Math.max(0, Math.round((redChance - 30) / 22));

			blueGoals = Math.min(6, blueGoals);
			redGoals = Math.min(6, redGoals);

			lastBlue = blueGoals;
			lastRed = redGoals;

			let log = '';

			if (blueGoals > redGoals) {
				wins += 1;
				coins += 12;
				teamRating = Math.min(99, teamRating + 2);
				statusText.textContent = 'You win the match.';
				log = 'Strong tactics. Your team created more chances and finished better.';
			} else if (blueGoals < redGoals) {
				coins += 4;
				teamRating = Math.max(40, teamRating - 1);
				statusText.textContent = 'You lose the match.';
				log = 'The other team found more space. Try changing formation or balance.';
			} else {
				coins += 7;
				teamRating = Math.min(99, teamRating + 1);
				statusText.textContent = 'The match ends in a draw.';
				log = 'Balanced game. A small tactical change could decide the next one.';
			}

			if (formation === '4-3-3' && blueGoals >= 3) {
				log = 'Your 4-3-3 attack worked very well and overwhelmed the defense.';
			} else if (formation === '5-3-2' && redGoals <= 1) {
				log = 'Your 5-3-2 shape kept things tight at the back.';
			} else if (formation === '4-4-2' && blueGoals === redGoals) {
				log = 'Your 4-4-2 gave a stable and balanced performance.';
			}

			logText.textContent = log;
			updatePanels();
		}

		function resetManager() {
			formation = '4-4-2';
			attackInput.value = '60';
			midfieldInput.value = '60';
			defenseInput.value = '60';
			energyInput.value = '60';
			lastBlue = 0;
			lastRed = 0;
			wins = 0;
			coins = 0;
			teamRating = 60;
			statusText.textContent = 'Set your tactics and simulate a match.';
			logText.textContent = 'Your team is ready.';
			updateSliderValues();
			updatePanels();
			renderFormation();
		}

		formationButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				formation = button.getAttribute('data-formation');
				renderFormation();
			});
		});

		[attackInput, midfieldInput, defenseInput, energyInput].forEach(function (input) {
			input.addEventListener('input', updateSliderValues);
		});

		simulateBtn.addEventListener('click', simulateMatch);
		resetBtn.addEventListener('click', resetManager);

		updateSliderValues();
		updatePanels();
		renderFormation();
	});
});
JS;

if (!function_exists('zo_game_mini_manager_render')) {
	function zo_game_mini_manager_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mini-manager-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mini-manager" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-mini-manager-wrap">
				<div class="zo-mini-manager-top">
					<div class="zo-mini-manager-panel">
						<strong class="zo-mini-manager-score-blue">0</strong>
						<span>Your Goals</span>
					</div>
					<div class="zo-mini-manager-panel">
						<strong class="zo-mini-manager-score-red">0</strong>
						<span>Enemy Goals</span>
					</div>
					<div class="zo-mini-manager-panel">
						<strong class="zo-mini-manager-wins">0</strong>
						<span>Wins</span>
					</div>
					<div class="zo-mini-manager-panel">
						<strong class="zo-mini-manager-coins">0</strong>
						<span>Coins</span>
					</div>
					<div class="zo-mini-manager-panel">
						<strong class="zo-mini-manager-rating">60</strong>
						<span>Team Rating</span>
					</div>
				</div>

				<div class="zo-mini-manager-sections">
					<div class="zo-mini-manager-card">
						<h3>Formation</h3>
						<div class="zo-mini-manager-formations">
							<button type="button" class="zo-mini-manager-btn zo-mini-manager-formation is-active" data-formation="4-4-2">4-4-2</button>
							<button type="button" class="zo-mini-manager-btn zo-mini-manager-formation" data-formation="4-3-3">4-3-3</button>
							<button type="button" class="zo-mini-manager-btn zo-mini-manager-formation" data-formation="5-3-2">5-3-2</button>
						</div>
						<div class="zo-mini-manager-help" style="margin-top:0;">
							Choose a formation, set your team strengths, then simulate the match.
						</div>
					</div>

					<div class="zo-mini-manager-card">
						<h3>Tactics</h3>

						<div class="zo-mini-manager-row">
							<label for="<?php echo esc_attr($instance_id); ?>-attack">Attack</label>
							<input id="<?php echo esc_attr($instance_id); ?>-attack" class="zo-mini-manager-attack" type="range" min="30" max="99" value="60">
							<div class="zo-mini-manager-value zo-mini-manager-attack-value">60</div>
						</div>

						<div class="zo-mini-manager-row">
							<label for="<?php echo esc_attr($instance_id); ?>-midfield">Midfield</label>
							<input id="<?php echo esc_attr($instance_id); ?>-midfield" class="zo-mini-manager-midfield" type="range" min="30" max="99" value="60">
							<div class="zo-mini-manager-value zo-mini-manager-midfield-value">60</div>
						</div>

						<div class="zo-mini-manager-row">
							<label for="<?php echo esc_attr($instance_id); ?>-defense">Defense</label>
							<input id="<?php echo esc_attr($instance_id); ?>-defense" class="zo-mini-manager-defense" type="range" min="30" max="99" value="60">
							<div class="zo-mini-manager-value zo-mini-manager-defense-value">60</div>
						</div>

						<div class="zo-mini-manager-row">
							<label for="<?php echo esc_attr($instance_id); ?>-energy">Energy</label>
							<input id="<?php echo esc_attr($instance_id); ?>-energy" class="zo-mini-manager-energy" type="range" min="30" max="99" value="60">
							<div class="zo-mini-manager-value zo-mini-manager-energy-value">60</div>
						</div>
					</div>
				</div>

				<div class="zo-mini-manager-actions">
					<button type="button" class="zo-mini-manager-btn zo-mini-manager-simulate">Simulate Match</button>
					<button type="button" class="zo-mini-manager-btn zo-mini-manager-reset">Reset Team</button>
				</div>

				<div class="zo-mini-manager-field-card">
					<div class="zo-mini-manager-field">
						<div class="zo-mini-manager-line-mid"></div>
						<div class="zo-mini-manager-circle"></div>
						<div class="zo-mini-manager-dot"></div>
						<div class="zo-mini-manager-box-left"></div>
						<div class="zo-mini-manager-box-right"></div>
						<div class="zo-mini-manager-goal-left"></div>
						<div class="zo-mini-manager-goal-right"></div>
					</div>
				</div>

				<div class="zo-mini-manager-status">
					<div class="zo-mini-manager-status-text">Set your tactics and simulate a match.</div>
					<div class="zo-mini-manager-log">Your team is ready.</div>
				</div>

				<div class="zo-mini-manager-help">
					This is a simple soccer manager game. You do not control the players directly. You choose the formation and team strengths, then watch the result of the match.
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'mini-manager',
	'name'            => 'Mini Manager',
	'author'          => 'Asker',
	'description'     => 'Choose your formation and tactics, then simulate a simple soccer match.',
	'render_callback' => 'zo_game_mini_manager_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);