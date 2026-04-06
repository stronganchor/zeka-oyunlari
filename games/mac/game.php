<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	padding: 16px;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	text-align: center;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--team-battle .zo-team-battle-card {
	background: #f8f9fb;
	border: 2px solid #d8dde6;
	border-radius: 18px;
	padding: 16px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.zo-game-root--team-battle .zo-team-battle-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-game-root--team-battle .zo-team-battle-help {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
	color: #333;
}

.zo-game-root--team-battle .zo-team-battle-topbar {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--team-battle .zo-team-battle-stat {
	background: #ffffff;
	border: 2px solid #e2e6ee;
	border-radius: 12px;
	padding: 10px 14px;
	min-width: 120px;
	font-weight: bold;
	font-size: 16px;
}

.zo-game-root--team-battle .zo-team-battle-field {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 12px;
	margin-bottom: 14px;
}

.zo-game-root--team-battle .zo-team-battle-side {
	background: #ffffff;
	border: 2px solid #dbe2ea;
	border-radius: 16px;
	padding: 14px;
}

.zo-game-root--team-battle .zo-team-battle-side-title {
	margin: 0 0 10px;
	font-size: 22px;
}

.zo-game-root--team-battle .zo-team-battle-health-wrap {
	margin-bottom: 14px;
}

.zo-game-root--team-battle .zo-team-battle-health-label {
	display: block;
	margin-bottom: 6px;
	font-weight: bold;
	font-size: 15px;
}

.zo-game-root--team-battle .zo-team-battle-health-bar {
	width: 100%;
	height: 22px;
	background: #e8edf3;
	border-radius: 999px;
	overflow: hidden;
	border: 2px solid #d7dde6;
}

.zo-game-root--team-battle .zo-team-battle-health-fill {
	height: 100%;
	width: 100%;
	border-radius: 999px;
	transition: width 0.25s ease;
}

.zo-game-root--team-battle .zo-team-battle-health-fill--player {
	background: linear-gradient(90deg, #34c759 0%, #5ddc7d 100%);
}

.zo-game-root--team-battle .zo-team-battle-health-fill--ai {
	background: linear-gradient(90deg, #ff6b6b 0%, #ff8f70 100%);
}

.zo-game-root--team-battle .zo-team-battle-characters {
	display: flex;
	justify-content: center;
	gap: 10px;
	flex-wrap: wrap;
}

.zo-game-root--team-battle .zo-team-battle-unit {
	width: 78px;
	min-height: 92px;
	background: #f6f8fb;
	border: 2px solid #dce3ea;
	border-radius: 14px;
	padding: 8px 4px;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	gap: 6px;
	transition: transform 0.12s ease, opacity 0.12s ease;
}

.zo-game-root--team-battle .zo-team-battle-unit.is-hit {
	transform: scale(0.92);
}

.zo-game-root--team-battle .zo-team-battle-unit.is-out {
	opacity: 0.35;
	filter: grayscale(1);
}

.zo-game-root--team-battle .zo-team-battle-unit-icon {
	font-size: 34px;
	line-height: 1;
}

.zo-game-root--team-battle .zo-team-battle-unit-name {
	font-size: 12px;
	font-weight: bold;
	line-height: 1.2;
}

.zo-game-root--team-battle .zo-team-battle-unit-hp {
	font-size: 12px;
	font-weight: bold;
	color: #333;
}

.zo-game-root--team-battle .zo-team-battle-actions {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--team-battle .zo-team-battle-btn {
	border: none;
	border-radius: 12px;
	padding: 14px 10px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	color: #fff;
	background: #4a78ff;
}

.zo-game-root--team-battle .zo-team-battle-btn:disabled {
	opacity: 0.55;
	cursor: default;
}

.zo-game-root--team-battle .zo-team-battle-btn--attack {
	background: #ff7043;
}

.zo-game-root--team-battle .zo-team-battle-btn--heal {
	background: #34a853;
}

.zo-game-root--team-battle .zo-team-battle-btn--shield {
	background: #5c6bc0;
}

.zo-game-root--team-battle .zo-team-battle-bottom {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-game-root--team-battle .zo-team-battle-btn--restart {
	background: #222;
}

.zo-game-root--team-battle .zo-team-battle-message {
	min-height: 52px;
	padding: 12px;
	background: #ffffff;
	border: 2px solid #dde3ea;
	border-radius: 14px;
	font-size: 16px;
	font-weight: bold;
	line-height: 1.4;
	color: #222;
}

@media (max-width: 640px) {
	.zo-game-root--team-battle .zo-team-battle-field {
		grid-template-columns: 1fr;
	}

	.zo-game-root--team-battle .zo-team-battle-actions {
		grid-template-columns: 1fr;
	}

	.zo-game-root--team-battle .zo-team-battle-unit {
		width: 72px;
		min-height: 88px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--team-battle');

	games.forEach(function (game) {
		const playerTotalEl = game.querySelector('.zo-team-battle-player-total');
		const aiTotalEl = game.querySelector('.zo-team-battle-ai-total');
		const roundEl = game.querySelector('.zo-team-battle-round');
		const messageEl = game.querySelector('.zo-team-battle-message');

		const playerBar = game.querySelector('.zo-team-battle-health-fill--player');
		const aiBar = game.querySelector('.zo-team-battle-health-fill--ai');

		const playerUnitsWrap = game.querySelector('.zo-team-battle-player-units');
		const aiUnitsWrap = game.querySelector('.zo-team-battle-ai-units');

		const attackBtn = game.querySelector('.zo-team-battle-btn--attack');
		const healBtn = game.querySelector('.zo-team-battle-btn--heal');
		const shieldBtn = game.querySelector('.zo-team-battle-btn--shield');
		const restartBtn = game.querySelector('.zo-team-battle-btn--restart');

		const playerTemplates = [
			{ name: 'Knight', icon: '🛡️', hp: 40 },
			{ name: 'Archer', icon: '🏹', hp: 30 },
			{ name: 'Wizard', icon: '🪄', hp: 30 }
		];

		const aiTemplates = [
			{ name: 'Bot Tank', icon: '🤖', hp: 40 },
			{ name: 'Bot Blaster', icon: '⚙️', hp: 30 },
			{ name: 'Bot Mage', icon: '💠', hp: 30 }
		];

		let playerTeam = [];
		let aiTeam = [];
		let playerShield = false;
		let aiShield = false;
		let round = 1;
		let gameOver = false;

		function cloneTeam(list) {
			return list.map(function (unit, index) {
				return {
					id: index + 1,
					name: unit.name,
					icon: unit.icon,
					maxHp: unit.hp,
					hp: unit.hp
				};
			});
		}

		function totalHp(team) {
			return team.reduce(function (sum, unit) {
				return sum + Math.max(0, unit.hp);
			}, 0);
		}

		function maxTotalHp(team) {
			return team.reduce(function (sum, unit) {
				return sum + unit.maxHp;
			}, 0);
		}

		function livingUnits(team) {
			return team.filter(function (unit) {
				return unit.hp > 0;
			});
		}

		function getRandomLivingUnit(team) {
			const alive = livingUnits(team);
			if (!alive.length) {
				return null;
			}
			return alive[Math.floor(Math.random() * alive.length)];
		}

		function renderUnits(container, team, side) {
			container.innerHTML = '';

			team.forEach(function (unit) {
				const unitEl = document.createElement('div');
				unitEl.className = 'zo-team-battle-unit';
				unitEl.setAttribute('data-side', side);
				unitEl.setAttribute('data-unit-id', String(unit.id));

				if (unit.hp <= 0) {
					unitEl.classList.add('is-out');
				}

				unitEl.innerHTML =
					'<div class="zo-team-battle-unit-icon">' + unit.icon + '</div>' +
					'<div class="zo-team-battle-unit-name">' + unit.name + '</div>' +
					'<div class="zo-team-battle-unit-hp">HP: ' + Math.max(0, unit.hp) + '</div>';

				container.appendChild(unitEl);
			});
		}

		function flashUnit(side, unitId) {
			const unitEl = game.querySelector('.zo-team-battle-unit[data-side="' + side + '"][data-unit-id="' + unitId + '"]');
			if (!unitEl) {
				return;
			}
			unitEl.classList.add('is-hit');
			window.setTimeout(function () {
				unitEl.classList.remove('is-hit');
			}, 180);
		}

		function updateBars() {
			const playerPct = Math.max(0, (totalHp(playerTeam) / maxTotalHp(playerTeam)) * 100);
			const aiPct = Math.max(0, (totalHp(aiTeam) / maxTotalHp(aiTeam)) * 100);

			playerBar.style.width = playerPct + '%';
			aiBar.style.width = aiPct + '%';
		}

		function updateHud() {
			playerTotalEl.textContent = String(totalHp(playerTeam));
			aiTotalEl.textContent = String(totalHp(aiTeam));
			roundEl.textContent = String(round);
			updateBars();
			renderUnits(playerUnitsWrap, playerTeam, 'player');
			renderUnits(aiUnitsWrap, aiTeam, 'ai');
		}

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function disableActions(disabled) {
			attackBtn.disabled = disabled;
			healBtn.disabled = disabled;
			shieldBtn.disabled = disabled;
		}

		function applyDamage(team, amount, side, shielded) {
			const target = getRandomLivingUnit(team);

			if (!target) {
				return null;
			}

			let damage = amount;

			if (shielded) {
				damage = Math.max(1, damage - 6);
			}

			target.hp = Math.max(0, target.hp - damage);
			flashUnit(side, target.id);

			return {
				target: target,
				damage: damage
			};
		}

		function applyHeal(team, amount) {
			const target = getRandomLivingUnit(team);

			if (!target) {
				return null;
			}

			const oldHp = target.hp;
			target.hp = Math.min(target.maxHp, target.hp + amount);

			return {
				target: target,
				heal: target.hp - oldHp
			};
		}

		function checkWinner() {
			if (totalHp(playerTeam) <= 0) {
				gameOver = true;
				disableActions(true);
				setMessage('The AI team wins.');
				return true;
			}

			if (totalHp(aiTeam) <= 0) {
				gameOver = true;
				disableActions(true);
				setMessage('Your team wins.');
				return true;
			}

			return false;
		}

		function aiTurn() {
			if (gameOver) {
				return;
			}

			const aliveAi = livingUnits(aiTeam).length;
			const alivePlayer = livingUnits(playerTeam).length;

			let choice = 'attack';

			if (totalHp(aiTeam) <= 35 && Math.random() < 0.35) {
				choice = 'heal';
			} else if (aliveAi < alivePlayer && Math.random() < 0.3) {
				choice = 'shield';
			} else if (Math.random() < 0.15) {
				choice = 'shield';
			}

			let text = '';

			if (choice === 'attack') {
				const result = applyDamage(playerTeam, 12 + Math.floor(Math.random() * 7), 'player', playerShield);
				playerShield = false;

				if (result) {
					text = 'AI attacks ' + result.target.name + ' for ' + result.damage + ' damage.';
				}
			} else if (choice === 'heal') {
				const heal = applyHeal(aiTeam, 8 + Math.floor(Math.random() * 5));
				playerShield = false;

				if (heal) {
					text = 'AI heals ' + heal.target.name + ' for ' + heal.heal + ' HP.';
				} else {
					text = 'AI tried to heal.';
				}
			} else {
				aiShield = true;
				playerShield = false;
				text = 'AI puts up a shield for the next hit.';
			}

			updateHud();

			if (checkWinner()) {
				return;
			}

			setMessage(text);
			round++;
			updateHud();
		}

		function playerAction(type) {
			if (gameOver) {
				return;
			}

			disableActions(true);

			let text = '';

			if (type === 'attack') {
				const result = applyDamage(aiTeam, 12 + Math.floor(Math.random() * 7), 'ai', aiShield);
				aiShield = false;

				if (result) {
					text = 'Your team attacks ' + result.target.name + ' for ' + result.damage + ' damage.';
				}
			} else if (type === 'heal') {
				const heal = applyHeal(playerTeam, 8 + Math.floor(Math.random() * 5));
				aiShield = false;

				if (heal) {
					text = 'Your team heals ' + heal.target.name + ' for ' + heal.heal + ' HP.';
				} else {
					text = 'Your team tried to heal.';
				}
			} else if (type === 'shield') {
				playerShield = true;
				aiShield = false;
				text = 'Your team is shielded for the next AI attack.';
			}

			updateHud();

			if (checkWinner()) {
				return;
			}

			setMessage(text + ' AI is thinking...');

			window.setTimeout(function () {
				aiTurn();
				if (!gameOver) {
					disableActions(false);
				}
			}, 700);
		}

		function startGame() {
			playerTeam = cloneTeam(playerTemplates);
			aiTeam = cloneTeam(aiTemplates);
			playerShield = false;
			aiShield = false;
			round = 1;
			gameOver = false;

			disableActions(false);
			updateHud();
			setMessage('Battle start. Pick an action.');
		}

		attackBtn.addEventListener('click', function () {
			playerAction('attack');
		});

		healBtn.addEventListener('click', function () {
			playerAction('heal');
		});

		shieldBtn.addEventListener('click', function () {
			playerAction('shield');
		});

		restartBtn.addEventListener('click', function () {
			startGame();
		});

		startGame();
	});
});
JS;

if (!function_exists('zo_game_team_battle_render')) {
	function zo_game_team_battle_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-team-battle-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--team-battle" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-team-battle-card">
				<h2 class="zo-team-battle-title">Team Battle vs AI</h2>
				<p class="zo-team-battle-help">You control one team. The other team is AI. Attack, heal, or shield and defeat the AI team.</p>

				<div class="zo-team-battle-topbar">
					<div class="zo-team-battle-stat">Your Team HP: <span class="zo-team-battle-player-total">100</span></div>
					<div class="zo-team-battle-stat">AI Team HP: <span class="zo-team-battle-ai-total">100</span></div>
					<div class="zo-team-battle-stat">Round: <span class="zo-team-battle-round">1</span></div>
				</div>

				<div class="zo-team-battle-field">
					<div class="zo-team-battle-side">
						<h3 class="zo-team-battle-side-title">Your Team</h3>
						<div class="zo-team-battle-health-wrap">
							<span class="zo-team-battle-health-label">Health</span>
							<div class="zo-team-battle-health-bar">
								<div class="zo-team-battle-health-fill zo-team-battle-health-fill--player"></div>
							</div>
						</div>
						<div class="zo-team-battle-characters zo-team-battle-player-units"></div>
					</div>

					<div class="zo-team-battle-side">
						<h3 class="zo-team-battle-side-title">AI Team</h3>
						<div class="zo-team-battle-health-wrap">
							<span class="zo-team-battle-health-label">Health</span>
							<div class="zo-team-battle-health-bar">
								<div class="zo-team-battle-health-fill zo-team-battle-health-fill--ai"></div>
							</div>
						</div>
						<div class="zo-team-battle-characters zo-team-battle-ai-units"></div>
					</div>
				</div>

				<div class="zo-team-battle-actions">
					<button type="button" class="zo-team-battle-btn zo-team-battle-btn--attack">Attack</button>
					<button type="button" class="zo-team-battle-btn zo-team-battle-btn--heal">Heal</button>
					<button type="button" class="zo-team-battle-btn zo-team-battle-btn--shield">Shield</button>
				</div>

				<div class="zo-team-battle-bottom">
					<button type="button" class="zo-team-battle-btn zo-team-battle-btn--restart">Restart</button>
				</div>

				<div class="zo-team-battle-message">Battle start. Pick an action.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'team-battle',
	'name'            => 'Team Battle vs AI',
	'author'          => 'Arslan',
	'description'     => 'A simple team battle game where you control one team and fight an AI team.',
	'render_callback' => 'zo_game_team_battle_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);