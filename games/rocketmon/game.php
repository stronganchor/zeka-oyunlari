<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root.zo-game-root--rocket-battle-heal {
	background: linear-gradient(180deg, #0d1324 0%, #16203a 100%);
	color: #eef4ff;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
}

.zo-game-root--rocket-battle-heal * {
	box-sizing: border-box;
}

.zo-game-root--rocket-battle-heal .rbh-title {
	font-size: 28px;
	font-weight: 700;
	text-align: center;
	margin: 0 0 10px;
	color: #86d7ff;
}

.zo-game-root--rocket-battle-heal .rbh-instructions {
	text-align: center;
	font-size: 15px;
	color: #c4d1ea;
	margin: 0 0 16px;
	line-height: 1.5;
}

.zo-game-root--rocket-battle-heal .rbh-board {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 14px;
	margin-bottom: 14px;
}

.zo-game-root--rocket-battle-heal .rbh-card {
	background: #1b2744;
	border: 1px solid #31446f;
	border-radius: 16px;
	padding: 14px;
	min-height: 230px;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
}

.zo-game-root--rocket-battle-heal .rbh-label {
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 0.06em;
	color: #9db0d4;
	margin-bottom: 6px;
}

.zo-game-root--rocket-battle-heal .rbh-name {
	font-size: 26px;
	font-weight: 700;
	margin-bottom: 10px;
}

.zo-game-root--rocket-battle-heal .rbh-level {
	font-size: 14px;
	color: #c4d1ea;
	margin-bottom: 12px;
}

.zo-game-root--rocket-battle-heal .rbh-hp-bar {
	width: 100%;
	height: 18px;
	background: #2a3554;
	border: 1px solid #3b4b73;
	border-radius: 999px;
	overflow: hidden;
}

.zo-game-root--rocket-battle-heal .rbh-hp-fill {
	height: 100%;
	width: 100%;
	background: #58d68d;
	transition: width 0.25s ease;
}

.zo-game-root--rocket-battle-heal .rbh-hp-text {
	font-size: 14px;
	margin-top: 7px;
	color: #dbe6fb;
}

.zo-game-root--rocket-battle-heal .rbh-rocket {
	position: relative;
	width: 82px;
	height: 150px;
	margin: 18px auto 8px;
}

.zo-game-root--rocket-battle-heal .rbh-rocket--enemy {
	transform: scaleX(-1);
}

.zo-game-root--rocket-battle-heal .rbh-nose {
	position: absolute;
	left: 24px;
	top: 8px;
	width: 0;
	height: 0;
	border-left: 17px solid transparent;
	border-right: 17px solid transparent;
	border-bottom: 30px solid #f1f5ff;
}

.zo-game-root--rocket-battle-heal .rbh-body {
	position: absolute;
	left: 26px;
	top: 34px;
	width: 30px;
	height: 92px;
	background: #b8d5ff;
	border-radius: 16px;
	border: 2px solid rgba(255,255,255,0.3);
}

.zo-game-root--rocket-battle-heal .rbh-player .rbh-body {
	background: #c7ffd5;
}

.zo-game-root--rocket-battle-heal .rbh-fin-left,
.zo-game-root--rocket-battle-heal .rbh-fin-right {
	position: absolute;
	top: 76px;
	width: 0;
	height: 0;
	border-top: 17px solid transparent;
	border-bottom: 17px solid transparent;
}

.zo-game-root--rocket-battle-heal .rbh-fin-left {
	left: 8px;
	border-right: 18px solid #df5959;
}

.zo-game-root--rocket-battle-heal .rbh-fin-right {
	right: 8px;
	border-left: 18px solid #df5959;
}

.zo-game-root--rocket-battle-heal .rbh-window {
	position: absolute;
	left: 31px;
	top: 66px;
	width: 20px;
	height: 20px;
	border-radius: 50%;
	background: #4f78af;
	border: 2px solid rgba(255,255,255,0.45);
}

.zo-game-root--rocket-battle-heal .rbh-flame {
	position: absolute;
	left: 29px;
	bottom: 0;
	width: 24px;
	height: 26px;
	background: linear-gradient(180deg, #ffe183 0%, #ff9f54 55%, #ff6565 100%);
	clip-path: polygon(50% 100%, 0 35%, 22% 0, 50% 26%, 78% 0, 100% 35%);
	animation: rbh-flame 0.45s infinite alternate;
}

@keyframes rbh-flame {
	from { transform: scaleY(1); }
	to { transform: scaleY(1.14); }
}

.zo-game-root--rocket-battle-heal .rbh-log,
.zo-game-root--rocket-battle-heal .rbh-actions {
	background: #1b2744;
	border: 1px solid #31446f;
	border-radius: 16px;
	padding: 14px;
	margin-bottom: 14px;
}

.zo-game-root--rocket-battle-heal .rbh-log-title,
.zo-game-root--rocket-battle-heal .rbh-actions-title {
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 0.06em;
	color: #9db0d4;
	margin-bottom: 8px;
}

.zo-game-root--rocket-battle-heal .rbh-log-text {
	min-height: 54px;
	font-size: 18px;
	line-height: 1.45;
}

.zo-game-root--rocket-battle-heal .rbh-buttons {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--rocket-battle-heal .rbh-btn {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	min-height: 50px;
	padding: 10px 12px;
	border-radius: 12px;
	border: 1px solid #4161a6;
	background: #1a315d;
	color: #eef4ff;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.12s ease, background 0.12s ease, border-color 0.12s ease;
}

.zo-game-root--rocket-battle-heal .rbh-btn:hover,
.zo-game-root--rocket-battle-heal .rbh-btn:focus {
	background: #24437e;
	border-color: #5e85de;
	transform: translateY(-1px);
	outline: none;
}

.zo-game-root--rocket-battle-heal .rbh-btn[disabled] {
	opacity: 0.45;
	cursor: default;
	transform: none;
}

.zo-game-root--rocket-battle-heal .rbh-btn--heal {
	background: #1e4a34;
	border-color: #4aaa75;
}

.zo-game-root--rocket-battle-heal .rbh-btn--heal:hover,
.zo-game-root--rocket-battle-heal .rbh-btn--heal:focus {
	background: #276545;
	border-color: #66d494;
}

.zo-game-root--rocket-battle-heal .rbh-btn--restart {
	background: #5a3a15;
	border-color: #d09b42;
}

.zo-game-root--rocket-battle-heal .rbh-btn--restart:hover,
.zo-game-root--rocket-battle-heal .rbh-btn--restart:focus {
	background: #754a19;
	border-color: #efb85c;
}

.zo-game-root--rocket-battle-heal .rbh-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-top: 8px;
}

.zo-game-root--rocket-battle-heal .rbh-pill {
	padding: 7px 10px;
	border-radius: 999px;
	background: #0f1930;
	border: 1px solid #30446f;
	font-size: 13px;
	color: #dbe6fb;
}

@media (max-width: 640px) {
	.zo-game-root--rocket-battle-heal .rbh-board {
		grid-template-columns: 1fr;
	}

	.zo-game-root--rocket-battle-heal .rbh-buttons {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--rocket-battle-heal');

	games.forEach(function (game) {
		const els = {
			playerName: game.querySelector('[data-role="player-name"]'),
			playerLevel: game.querySelector('[data-role="player-level"]'),
			playerHpFill: game.querySelector('[data-role="player-hp-fill"]'),
			playerHpText: game.querySelector('[data-role="player-hp-text"]'),
			enemyName: game.querySelector('[data-role="enemy-name"]'),
			enemyLevel: game.querySelector('[data-role="enemy-level"]'),
			enemyHpFill: game.querySelector('[data-role="enemy-hp-fill"]'),
			enemyHpText: game.querySelector('[data-role="enemy-hp-text"]'),
			logText: game.querySelector('[data-role="log-text"]'),
			buttons: game.querySelector('[data-role="buttons"]'),
			stats: game.querySelector('[data-role="stats"]')
		};

		const rocketPool = [
			{ name: 'Sparrow Mk1', level: 5, maxHp: 75, attack: 18, heal: 16 },
			{ name: 'Meteor Dash', level: 6, maxHp: 82, attack: 20, heal: 14 },
			{ name: 'Nova Wing', level: 7, maxHp: 88, attack: 22, heal: 15 },
			{ name: 'Viper Jet', level: 8, maxHp: 96, attack: 24, heal: 12 }
		];

		function cloneRocket(rocket) {
			return {
				name: rocket.name,
				level: rocket.level,
				maxHp: rocket.maxHp,
				hp: rocket.maxHp,
				attack: rocket.attack,
				heal: rocket.heal
			};
		}

		function randomRocket() {
			const pick = rocketPool[Math.floor(Math.random() * rocketPool.length)];
			return cloneRocket(pick);
		}

		const state = {
			player: cloneRocket(rocketPool[0]),
			enemy: randomRocket(),
			healsLeft: 3,
			gameOver: false,
			message: 'A wild rocket appeared. Choose Attack or Heal.'
		};

		function hpColor(ratio) {
			if (ratio > 0.5) {
				return '#58d68d';
			}
			if (ratio > 0.2) {
				return '#f3cf63';
			}
			return '#f36f6f';
		}

		function renderHp(fillEl, textEl, hp, maxHp) {
			const ratio = maxHp > 0 ? hp / maxHp : 0;
			fillEl.style.width = Math.max(0, Math.min(1, ratio)) * 100 + '%';
			fillEl.style.background = hpColor(ratio);
			textEl.textContent = 'HP: ' + hp + ' / ' + maxHp;
		}

		function setMessage(text) {
			state.message = text;
		}

		function damage(attacker, defender) {
			const variance = 0.85 + Math.random() * 0.3;
			const amount = Math.max(1, Math.floor(attacker.attack * variance));
			defender.hp = Math.max(0, defender.hp - amount);
			return amount;
		}

		function healRocket(target) {
			const variance = 0.9 + Math.random() * 0.25;
			const amount = Math.max(1, Math.floor(target.heal * variance));
			const before = target.hp;
			target.hp = Math.min(target.maxHp, target.hp + amount);
			return target.hp - before;
		}

		function enemyTurn() {
			if (state.gameOver) {
				return '';
			}

			if (state.enemy.hp <= Math.floor(state.enemy.maxHp * 0.35) && Math.random() < 0.4) {
				const healed = healRocket(state.enemy);
				return state.enemy.name + ' healed ' + healed + ' HP.';
			}

			const dealt = damage(state.enemy, state.player);
			return state.enemy.name + ' attacked and dealt ' + dealt + ' damage.';
		}

		function endCheck() {
			if (state.enemy.hp <= 0) {
				state.gameOver = true;
				setMessage('You won. Enemy rocket was defeated.');
				return true;
			}

			if (state.player.hp <= 0) {
				state.gameOver = true;
				setMessage('You lost. Your rocket was defeated.');
				return true;
			}

			return false;
		}

		function doAttack() {
			if (state.gameOver) {
				return;
			}

			const dealt = damage(state.player, state.enemy);
			let log = state.player.name + ' attacked and dealt ' + dealt + ' damage.';

			if (!endCheck()) {
				log += ' ' + enemyTurn();
				endCheck();
			}

			if (!state.gameOver) {
				setMessage(log);
			}

			render();
		}

		function doHeal() {
			if (state.gameOver) {
				return;
			}

			if (state.healsLeft <= 0) {
				setMessage('No heals left.');
				render();
				return;
			}

			state.healsLeft -= 1;
			const healed = healRocket(state.player);
			let log = state.player.name + ' healed ' + healed + ' HP.';

			if (!endCheck()) {
				log += ' ' + enemyTurn();
				endCheck();
			}

			if (!state.gameOver) {
				setMessage(log);
			}

			render();
		}

		function restartGame() {
			state.player = cloneRocket(rocketPool[0]);
			state.enemy = randomRocket();
			state.healsLeft = 3;
			state.gameOver = false;
			state.message = 'A wild rocket appeared. Choose Attack or Heal.';
			render();
		}

		function makeButton(label, className, handler, disabled) {
			const btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'rbh-btn' + (className ? ' ' + className : '');
			btn.textContent = label;
			btn.disabled = !!disabled;
			btn.addEventListener('click', handler);
			return btn;
		}

		function renderButtons() {
			els.buttons.innerHTML = '';

			els.buttons.appendChild(makeButton('Attack', '', doAttack, state.gameOver));
			els.buttons.appendChild(makeButton('Heal', 'rbh-btn--heal', doHeal, state.gameOver || state.healsLeft <= 0));
			els.buttons.appendChild(makeButton('Restart', 'rbh-btn--restart', restartGame, false));
		}

		function renderStats() {
			els.stats.innerHTML = '';

			const pills = [
				'Player Attack: ' + state.player.attack,
				'Player Heal Power: ' + state.player.heal,
				'Heals Left: ' + state.healsLeft
			];

			pills.forEach(function (text) {
				const pill = document.createElement('span');
				pill.className = 'rbh-pill';
				pill.textContent = text;
				els.stats.appendChild(pill);
			});
		}

		function render() {
			els.playerName.textContent = state.player.name;
			els.playerLevel.textContent = 'Your Rocket • Lv' + state.player.level;
			els.enemyName.textContent = state.enemy.name;
			els.enemyLevel.textContent = 'Enemy Rocket • Lv' + state.enemy.level;

			renderHp(els.playerHpFill, els.playerHpText, state.player.hp, state.player.maxHp);
			renderHp(els.enemyHpFill, els.enemyHpText, state.enemy.hp, state.enemy.maxHp);

			els.logText.textContent = state.message;

			renderButtons();
			renderStats();
		}

		render();
	});
});
JS;

if (!function_exists('zo_game_rocket_battle_heal_render')) {
	function zo_game_rocket_battle_heal_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-rocket-battle-heal-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--rocket-battle-heal" id="<?php echo esc_attr($instance_id); ?>">
			<div class="rbh-title">Rocket Battle</div>
			<div class="rbh-instructions">Attack the enemy rocket. Heal yourself when needed. Defeat the enemy before your HP reaches zero.</div>

			<div class="rbh-board">
				<div class="rbh-card rbh-enemy">
					<div>
						<div class="rbh-label">Enemy</div>
						<div class="rbh-name" data-role="enemy-name">Enemy Rocket</div>
						<div class="rbh-level" data-role="enemy-level">Enemy Rocket • Lv1</div>
						<div class="rbh-hp-bar">
							<div class="rbh-hp-fill" data-role="enemy-hp-fill"></div>
						</div>
						<div class="rbh-hp-text" data-role="enemy-hp-text">HP: 0 / 0</div>
					</div>

					<div class="rbh-rocket rbh-rocket--enemy" aria-hidden="true">
						<div class="rbh-nose"></div>
						<div class="rbh-body"></div>
						<div class="rbh-fin-left"></div>
						<div class="rbh-fin-right"></div>
						<div class="rbh-window"></div>
						<div class="rbh-flame"></div>
					</div>
				</div>

				<div class="rbh-card rbh-player">
					<div>
						<div class="rbh-label">Player</div>
						<div class="rbh-name" data-role="player-name">Your Rocket</div>
						<div class="rbh-level" data-role="player-level">Your Rocket • Lv1</div>
						<div class="rbh-hp-bar">
							<div class="rbh-hp-fill" data-role="player-hp-fill"></div>
						</div>
						<div class="rbh-hp-text" data-role="player-hp-text">HP: 0 / 0</div>
					</div>

					<div class="rbh-rocket" aria-hidden="true">
						<div class="rbh-nose"></div>
						<div class="rbh-body"></div>
						<div class="rbh-fin-left"></div>
						<div class="rbh-fin-right"></div>
						<div class="rbh-window"></div>
						<div class="rbh-flame"></div>
					</div>
				</div>
			</div>

			<div class="rbh-log">
				<div class="rbh-log-title">Battle Log</div>
				<div class="rbh-log-text" data-role="log-text">A wild rocket appeared. Choose Attack or Heal.</div>
			</div>

			<div class="rbh-actions">
				<div class="rbh-actions-title">Actions</div>
				<div class="rbh-buttons" data-role="buttons"></div>
				<div class="rbh-stats" data-role="stats"></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'rocket-battle-heal',
	'name'            => 'Rocket Battle',
	'author'          => 'Arslan',
	'description'     => 'A simple rocket battle game where the player can attack and heal.',
	'render_callback' => 'zo_game_rocket_battle_heal_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);