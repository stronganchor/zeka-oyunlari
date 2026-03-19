<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 960px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root.zo-game-root--rocketmon-browser {
	background: linear-gradient(180deg, #0a0f1d 0%, #111a31 100%);
	color: #f0f0f0;
	border-radius: 18px;
	padding: 16px;
	box-sizing: border-box;
}

.zo-game-root--rocketmon-browser * {
	box-sizing: border-box;
}

.zo-game-root--rocketmon-browser .rb-title {
	text-align: center;
	font-size: 28px;
	font-weight: 700;
	margin: 0 0 14px;
	color: #7ddcff;
}

.zo-game-root--rocketmon-browser .rb-subtitle {
	text-align: center;
	font-size: 14px;
	color: #b7c0d3;
	margin: 0 0 16px;
}

.zo-game-root--rocketmon-browser .rb-arena,
.zo-game-root--rocketmon-browser .rb-player,
.zo-game-root--rocketmon-browser .rb-message,
.zo-game-root--rocketmon-browser .rb-actions {
	background: #182239;
	border: 1px solid #2a385b;
	border-radius: 16px;
	padding: 14px;
	margin-bottom: 14px;
}

.zo-game-root--rocketmon-browser .rb-arena {
	min-height: 220px;
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 12px;
}

.zo-game-root--rocketmon-browser .rb-side {
	flex: 1 1 50%;
}

.zo-game-root--rocketmon-browser .rb-side--enemy {
	text-align: left;
}

.zo-game-root--rocketmon-browser .rb-side--player {
	text-align: right;
}

.zo-game-root--rocketmon-browser .rb-name {
	font-size: 26px;
	font-weight: 700;
	margin-bottom: 4px;
}

.zo-game-root--rocketmon-browser .rb-level {
	font-size: 14px;
	color: #b7c0d3;
	margin-bottom: 10px;
}

.zo-game-root--rocketmon-browser .rb-hp-wrap {
	max-width: 320px;
}

.zo-game-root--rocketmon-browser .rb-side--player .rb-hp-wrap {
	margin-left: auto;
}

.zo-game-root--rocketmon-browser .rb-hp-bar {
	width: 100%;
	height: 16px;
	background: #2d3753;
	border-radius: 999px;
	overflow: hidden;
	border: 1px solid #3b4a72;
}

.zo-game-root--rocketmon-browser .rb-hp-fill {
	height: 100%;
	width: 100%;
	background: #58d68d;
	transition: width 0.25s ease;
}

.zo-game-root--rocketmon-browser .rb-hp-text {
	font-size: 13px;
	color: #c8d0df;
	margin-top: 6px;
}

.zo-game-root--rocketmon-browser .rb-rocket-zone {
	flex: 0 0 250px;
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 180px;
}

.zo-game-root--rocketmon-browser .rb-rocket {
	position: relative;
	width: 72px;
	height: 150px;
}

.zo-game-root--rocketmon-browser .rb-rocket--enemy {
	transform: scaleX(-1);
}

.zo-game-root--rocketmon-browser .rb-body {
	position: absolute;
	left: 22px;
	top: 34px;
	width: 28px;
	height: 90px;
	background: #b9d6ff;
	border-radius: 14px;
	border: 2px solid rgba(255,255,255,0.35);
}

.zo-game-root--rocketmon-browser .rb-nose {
	position: absolute;
	left: 20px;
	top: 10px;
	width: 0;
	height: 0;
	border-left: 16px solid transparent;
	border-right: 16px solid transparent;
	border-bottom: 28px solid #eef3ff;
}

.zo-game-root--rocketmon-browser .rb-fin-left,
.zo-game-root--rocketmon-browser .rb-fin-right {
	position: absolute;
	top: 74px;
	width: 0;
	height: 0;
	border-top: 16px solid transparent;
	border-bottom: 16px solid transparent;
}

.zo-game-root--rocketmon-browser .rb-fin-left {
	left: 7px;
	border-right: 18px solid #d94f4f;
}

.zo-game-root--rocketmon-browser .rb-fin-right {
	right: 7px;
	border-left: 18px solid #d94f4f;
}

.zo-game-root--rocketmon-browser .rb-window {
	position: absolute;
	left: 27px;
	top: 65px;
	width: 18px;
	height: 18px;
	border-radius: 50%;
	background: #4e6fa1;
	border: 2px solid rgba(255,255,255,0.45);
}

.zo-game-root--rocketmon-browser .rb-flame {
	position: absolute;
	left: 26px;
	bottom: 4px;
	width: 20px;
	height: 24px;
	background: linear-gradient(180deg, #ffd97b 0%, #ff964f 55%, #ff5d5d 100%);
	clip-path: polygon(50% 100%, 0 35%, 25% 0, 50% 22%, 75% 0, 100% 35%);
	animation: rb-flame 0.4s infinite alternate;
}

@keyframes rb-flame {
	from { transform: scaleY(1); opacity: 0.9; }
	to { transform: scaleY(1.15); opacity: 1; }
}

.zo-game-root--rocketmon-browser .rb-message {
	min-height: 94px;
}

.zo-game-root--rocketmon-browser .rb-message-title {
	font-size: 13px;
	color: #9fb0cc;
	margin-bottom: 8px;
	text-transform: uppercase;
	letter-spacing: 0.06em;
}

.zo-game-root--rocketmon-browser .rb-message-text {
	font-size: 18px;
	line-height: 1.45;
	min-height: 52px;
}

.zo-game-root--rocketmon-browser .rb-actions-title {
	font-size: 13px;
	color: #9fb0cc;
	margin-bottom: 10px;
	text-transform: uppercase;
	letter-spacing: 0.06em;
}

.zo-game-root--rocketmon-browser .rb-grid {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--rocketmon-browser .rb-btn {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	min-height: 48px;
	padding: 10px 12px;
	border: 1px solid #34508d;
	border-radius: 12px;
	background: #162849;
	color: #eff5ff;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.12s ease, background 0.12s ease, border-color 0.12s ease;
}

.zo-game-root--rocketmon-browser .rb-btn:hover,
.zo-game-root--rocketmon-browser .rb-btn:focus {
	background: #1f3764;
	border-color: #4b73c9;
	transform: translateY(-1px);
	outline: none;
}

.zo-game-root--rocketmon-browser .rb-btn[disabled] {
	opacity: 0.45;
	cursor: default;
	transform: none;
}

.zo-game-root--rocketmon-browser .rb-btn--good {
	background: #173d2a;
	border-color: #2f8c5a;
}

.zo-game-root--rocketmon-browser .rb-btn--good:hover,
.zo-game-root--rocketmon-browser .rb-btn--good:focus {
	background: #1d5237;
	border-color: #46b679;
}

.zo-game-root--rocketmon-browser .rb-btn--warn {
	background: #493710;
	border-color: #a07a1a;
}

.zo-game-root--rocketmon-browser .rb-btn--warn:hover,
.zo-game-root--rocketmon-browser .rb-btn--warn:focus {
	background: #5f4712;
	border-color: #c79a22;
}

.zo-game-root--rocketmon-browser .rb-btn--bad {
	background: #431b1b;
	border-color: #9f4040;
}

.zo-game-root--rocketmon-browser .rb-btn--bad:hover,
.zo-game-root--rocketmon-browser .rb-btn--bad:focus {
	background: #592424;
	border-color: #c75a5a;
}

.zo-game-root--rocketmon-browser .rb-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	margin-top: 8px;
	font-size: 13px;
	color: #c8d0df;
}

.zo-game-root--rocketmon-browser .rb-pill {
	padding: 6px 10px;
	border-radius: 999px;
	background: #10192d;
	border: 1px solid #2f4068;
}

.zo-game-root--rocketmon-browser .rb-hangar {
	margin-top: 8px;
	font-size: 14px;
	color: #c8d0df;
}

.zo-game-root--rocketmon-browser .rb-hangar-list {
	margin-top: 8px;
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-game-root--rocketmon-browser .rb-hangar-item {
	padding: 7px 10px;
	border-radius: 999px;
	background: #10192d;
	border: 1px solid #2f4068;
	font-size: 13px;
}

.zo-game-root--rocketmon-browser .rb-hidden {
	display: none !important;
}

@media (max-width: 700px) {
	.zo-game-root--rocketmon-browser .rb-arena {
		flex-direction: column;
	}

	.zo-game-root--rocketmon-browser .rb-side,
	.zo-game-root--rocketmon-browser .rb-side--enemy,
	.zo-game-root--rocketmon-browser .rb-side--player {
		text-align: center;
	}

	.zo-game-root--rocketmon-browser .rb-hp-wrap,
	.zo-game-root--rocketmon-browser .rb-side--player .rb-hp-wrap {
		margin: 0 auto;
	}

	.zo-game-root--rocketmon-browser .rb-grid {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--rocketmon-browser');

	games.forEach(function (game) {
		const rocketPool = [
			{
				name: 'Sparrow Mk1',
				level: 5,
				maxHp: 60,
				attack: 18,
				defense: 14,
				speed: 16,
				catchRate: 0.65,
				moves: ['Thruster Burn', 'Guided Strike', 'Flare Shield']
			},
			{
				name: 'Viper X',
				level: 7,
				maxHp: 74,
				attack: 22,
				defense: 16,
				speed: 20,
				catchRate: 0.45,
				moves: ['Thruster Burn', 'Guided Strike', 'Overload']
			},
			{
				name: 'Atlas-9',
				level: 6,
				maxHp: 80,
				attack: 17,
				defense: 20,
				speed: 12,
				catchRate: 0.55,
				moves: ['Thruster Burn', 'Flare Shield', 'Overload']
			},
			{
				name: 'Comet SR',
				level: 8,
				maxHp: 68,
				attack: 24,
				defense: 14,
				speed: 24,
				catchRate: 0.40,
				moves: ['Guided Strike', 'Flare Shield', 'Overload']
			}
		];

		const moves = {
			'Thruster Burn': {
				name: 'Thruster Burn',
				power: 20,
				accuracy: 1,
				kind: 'damage',
				selfDamage: 0,
				buffDef: 0
			},
			'Guided Strike': {
				name: 'Guided Strike',
				power: 35,
				accuracy: 0.8,
				kind: 'damage',
				selfDamage: 0,
				buffDef: 0
			},
			'Flare Shield': {
				name: 'Flare Shield',
				power: 0,
				accuracy: 1,
				kind: 'buff',
				selfDamage: 0,
				buffDef: 0.25
			},
			'Overload': {
				name: 'Overload',
				power: 50,
				accuracy: 0.7,
				kind: 'damage',
				selfDamage: 10,
				buffDef: 0
			}
		};

		function cloneRocket(data) {
			return {
				name: data.name,
				level: data.level,
				maxHp: data.maxHp,
				hp: data.maxHp,
				attack: data.attack,
				defense: data.defense,
				speed: data.speed,
				catchRate: data.catchRate,
				moves: data.moves.slice(),
				alive: true,
				baseDefense: data.defense
			};
		}

		function randomRocket() {
			const pick = rocketPool[Math.floor(Math.random() * rocketPool.length)];
			return cloneRocket(pick);
		}

		function hpColor(ratio) {
			if (ratio > 0.5) {
				return '#58d68d';
			}
			if (ratio > 0.2) {
				return '#fad460';
			}
			return '#f86868';
		}

		const els = {
			enemyName: game.querySelector('[data-role="enemy-name"]'),
			enemyLevel: game.querySelector('[data-role="enemy-level"]'),
			enemyHpFill: game.querySelector('[data-role="enemy-hp-fill"]'),
			enemyHpText: game.querySelector('[data-role="enemy-hp-text"]'),
			playerName: game.querySelector('[data-role="player-name"]'),
			playerLevel: game.querySelector('[data-role="player-level"]'),
			playerHpFill: game.querySelector('[data-role="player-hp-fill"]'),
			playerHpText: game.querySelector('[data-role="player-hp-text"]'),
			messageText: game.querySelector('[data-role="message-text"]'),
			actionTitle: game.querySelector('[data-role="action-title"]'),
			actionGrid: game.querySelector('[data-role="action-grid"]'),
			stats: game.querySelector('[data-role="stats"]'),
			hangarList: game.querySelector('[data-role="hangar-list"]')
		};

		const state = {
			party: [cloneRocket(rocketPool[0])],
			activeIndex: 0,
			enemy: randomRocket(),
			inventory: {
				repairKit: 3,
				magnetClamp: 1
			},
			mode: 'menu',
			message: 'A wild enemy rocket appeared.',
			battleEnded: false,
			capturedThisBattle: false
		};

		function activeRocket() {
			return state.party[state.activeIndex];
		}

		function aliveParty() {
			return state.party.filter(function (r) {
				return r.alive;
			});
		}

		function resetBattle() {
			state.party.forEach(function (r) {
				r.alive = true;
				r.hp = r.maxHp;
				r.defense = r.baseDefense;
			});
			state.activeIndex = 0;
			state.enemy = randomRocket();
			state.mode = 'menu';
			state.message = 'A wild enemy rocket appeared.';
			state.battleEnded = false;
			state.capturedThisBattle = false;
			render();
		}

		function setMessage(text) {
			state.message = text;
		}

		function damageCalc(attacker, defender, move) {
			const ratio = attacker.attack / Math.max(1, defender.defense);
			const randomFactor = 0.85 + (Math.random() * 0.15);
			return Math.max(1, Math.floor(move.power * ratio * randomFactor));
		}

		function applyDamage(target, dmg) {
			target.hp = Math.max(0, target.hp - dmg);
			target.alive = target.hp > 0;
		}

		function healRocket(target, amount) {
			target.hp = Math.min(target.maxHp, target.hp + amount);
			target.alive = target.hp > 0;
		}

		function enemyMove() {
			const pool = state.enemy.moves;
			const moveName = pool[Math.floor(Math.random() * pool.length)];
			return moves[moveName];
		}

		function useMove(attacker, defender, move) {
			if (move.kind === 'buff') {
				const gain = Math.max(0.05, move.buffDef);
				defender.defense = Math.floor(defender.defense * (1 + gain));
				return attacker.name + ' used ' + move.name + '. ' + defender.name + '\'s defense rose.';
			}

			if (Math.random() > move.accuracy) {
				return attacker.name + '\'s ' + move.name + ' missed.';
			}

			const dmg = damageCalc(attacker, defender, move);
			applyDamage(defender, dmg);

			let text = attacker.name + ' used ' + move.name + '. ' + defender.name + ' took ' + dmg + ' damage.';
			if (move.selfDamage > 0 && attacker.alive) {
				applyDamage(attacker, move.selfDamage);
				text += ' ' + attacker.name + ' took ' + move.selfDamage + ' recoil damage.';
			}
			return text;
		}

		function finishBattle(winText) {
			state.battleEnded = true;
			state.mode = 'end';
			setMessage(winText);
			render();
		}

		function afterKnockoutCheck() {
			const player = activeRocket();

			if (!state.enemy.alive) {
				finishBattle('Enemy ' + state.enemy.name + ' was disabled. You win.');
				return true;
			}

			if (!player.alive) {
				const alternatives = state.party.filter(function (r, idx) {
					return r.alive && idx !== state.activeIndex;
				});

				if (alternatives.length > 0) {
					state.mode = 'switch';
					setMessage(player.name + ' was disabled. Choose another rocket.');
					render();
					return true;
				}

				finishBattle('All your rockets are disabled. Battle ended.');
				return true;
			}

			return false;
		}

		function resolveTurn(playerMove) {
			if (state.battleEnded) {
				return;
			}

			const player = activeRocket();
			const enemy = state.enemy;
			const foeMove = enemyMove();
			let logs = [];

			const playerFirst = player.speed >= enemy.speed;

			if (playerFirst) {
				logs.push(useMove(player, enemy, playerMove));
				if (!afterKnockoutCheck()) {
					logs.push(useMove(enemy, player, foeMove));
					afterKnockoutCheck();
				}
			} else {
				logs.push(useMove(enemy, player, foeMove));
				if (!afterKnockoutCheck()) {
					logs.push(useMove(player, enemy, playerMove));
					afterKnockoutCheck();
				}
			}

			if (!state.battleEnded && state.mode !== 'switch') {
				state.mode = 'menu';
			}

			setMessage(logs.filter(Boolean).join(' '));
			render();
		}

		function attemptDock() {
			if (state.battleEnded) {
				return;
			}

			const enemy = state.enemy;
			const hpRatio = enemy.hp / enemy.maxHp;
			let chance = enemy.catchRate * (1.2 - hpRatio);

			if (state.inventory.magnetClamp > 0) {
				chance += 0.15;
				state.inventory.magnetClamp -= 1;
			}

			chance = Math.max(0.05, Math.min(0.95, chance));

			if (Math.random() < chance) {
				state.party.push(enemy);
				state.capturedThisBattle = true;
				finishBattle('Success. You captured ' + enemy.name + ' and added it to your hangar.');
				return;
			}

			const enemyAttackText = useMove(state.enemy, activeRocket(), enemyMove());
			afterKnockoutCheck();

			if (!state.battleEnded && state.mode !== 'switch') {
				state.mode = 'menu';
			}

			setMessage('Docking clamps failed. ' + enemyAttackText);
			render();
		}

		function useRepairKit() {
			if (state.battleEnded) {
				return;
			}

			if (state.inventory.repairKit <= 0) {
				setMessage('No Repair Kits left.');
				render();
				return;
			}

			state.inventory.repairKit -= 1;
			healRocket(activeRocket(), 30);

			const enemyAttackText = useMove(state.enemy, activeRocket(), enemyMove());
			afterKnockoutCheck();

			if (!state.battleEnded && state.mode !== 'switch') {
				state.mode = 'menu';
			}

			setMessage('Used Repair Kit. ' + activeRocket().name + ' restored 30 HP. ' + enemyAttackText);
			render();
		}

		function attemptRun() {
			if (state.battleEnded) {
				return;
			}

			const player = activeRocket();
			const enemy = state.enemy;
			const chance = 0.5 + ((player.speed - enemy.speed) / 100);

			if (Math.random() < chance) {
				finishBattle('You escaped safely. Press Play Again for a new battle.');
				return;
			}

			const enemyAttackText = useMove(state.enemy, activeRocket(), enemyMove());
			afterKnockoutCheck();

			if (!state.battleEnded && state.mode !== 'switch') {
				state.mode = 'menu';
			}

			setMessage('Could not escape. ' + enemyAttackText);
			render();
		}

		function switchRocket(index) {
			const options = state.party
				.map(function (rocket, idx) {
					return { rocket: rocket, idx: idx };
				})
				.filter(function (entry) {
					return entry.rocket.alive && entry.idx !== state.activeIndex;
				});

			if (!options[index]) {
				return;
			}

			state.activeIndex = options[index].idx;

			const enemyAttackText = useMove(state.enemy, activeRocket(), enemyMove());
			afterKnockoutCheck();

			if (!state.battleEnded && state.mode !== 'switch') {
				state.mode = 'menu';
			}

			setMessage('Go, ' + activeRocket().name + '. ' + enemyAttackText);
			render();
		}

		function renderHp(fillEl, textEl, hp, maxHp) {
			const ratio = maxHp > 0 ? hp / maxHp : 0;
			fillEl.style.width = Math.max(0, Math.min(1, ratio)) * 100 + '%';
			fillEl.style.background = hpColor(ratio);
			textEl.textContent = 'HP: ' + hp + ' / ' + maxHp;
		}

		function makeButton(label, className, onClick, disabled) {
			const btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'rb-btn' + (className ? ' ' + className : '');
			btn.textContent = label;
			btn.disabled = !!disabled;
			btn.addEventListener('click', onClick);
			return btn;
		}

		function renderActions() {
			els.actionGrid.innerHTML = '';

			if (state.mode === 'menu') {
				els.actionTitle.textContent = 'Choose Action';

				els.actionGrid.appendChild(makeButton('Fight', '', function () {
					state.mode = 'fight';
					render();
				}));

				els.actionGrid.appendChild(makeButton('Items', '', function () {
					state.mode = 'items';
					render();
				}));

				els.actionGrid.appendChild(makeButton('Dock', 'rb-btn--warn', function () {
					attemptDock();
				}, false));

				els.actionGrid.appendChild(makeButton('Run', 'rb-btn--bad', function () {
					attemptRun();
				}));
				return;
			}

			if (state.mode === 'fight') {
				els.actionTitle.textContent = 'Choose Move';

				activeRocket().moves.forEach(function (moveName) {
					els.actionGrid.appendChild(makeButton(moveName, '', function () {
						resolveTurn(moves[moveName]);
					}));
				});

				els.actionGrid.appendChild(makeButton('Back', 'rb-btn--bad', function () {
					state.mode = 'menu';
					render();
				}));
				return;
			}

			if (state.mode === 'items') {
				els.actionTitle.textContent = 'Items';

				els.actionGrid.appendChild(makeButton(
					'Repair Kit (+30) x' + state.inventory.repairKit,
					'rb-btn--good',
					function () {
						useRepairKit();
					},
					state.inventory.repairKit <= 0
				));

				els.actionGrid.appendChild(makeButton('Back', 'rb-btn--bad', function () {
					state.mode = 'menu';
					render();
				}));
				return;
			}

			if (state.mode === 'switch') {
				els.actionTitle.textContent = 'Switch Rocket';

				const options = state.party
					.map(function (rocket, idx) {
						return { rocket: rocket, idx: idx };
					})
					.filter(function (entry) {
						return entry.rocket.alive && entry.idx !== state.activeIndex;
					});

				if (options.length === 0) {
					els.actionGrid.appendChild(makeButton('Back', 'rb-btn--bad', function () {
						state.mode = 'menu';
						render();
					}));
					return;
				}

				options.forEach(function (entry, idx) {
					els.actionGrid.appendChild(makeButton(entry.rocket.name + ' (Lv' + entry.rocket.level + ')', '', function () {
						switchRocket(idx);
					}));
				});
				return;
			}

			if (state.mode === 'end') {
				els.actionTitle.textContent = 'Battle Over';
				els.actionGrid.appendChild(makeButton('Play Again', 'rb-btn--good', function () {
					resetBattle();
				}));
			}
		}

		function renderStats() {
			els.stats.innerHTML = '';

			const pills = [
				'Repair Kits: ' + state.inventory.repairKit,
				'Magnet Clamps: ' + state.inventory.magnetClamp,
				'Hangar Size: ' + state.party.length
			];

			pills.forEach(function (text) {
				const span = document.createElement('span');
				span.className = 'rb-pill';
				span.textContent = text;
				els.stats.appendChild(span);
			});
		}

		function renderHangar() {
			els.hangarList.innerHTML = '';

			state.party.forEach(function (rocket, idx) {
				const item = document.createElement('span');
				item.className = 'rb-hangar-item';
				let text = rocket.name + ' Lv' + rocket.level;
				if (idx === state.activeIndex) {
					text += ' • Active';
				}
				if (!rocket.alive) {
					text += ' • Disabled';
				}
				item.textContent = text;
				els.hangarList.appendChild(item);
			});
		}

		function render() {
			const player = activeRocket();
			const enemy = state.enemy;

			els.enemyName.textContent = enemy.name;
			els.enemyLevel.textContent = 'Enemy Rocket • Lv' + enemy.level;
			els.playerName.textContent = player.name;
			els.playerLevel.textContent = 'Your Rocket • Lv' + player.level;

			renderHp(els.enemyHpFill, els.enemyHpText, enemy.hp, enemy.maxHp);
			renderHp(els.playerHpFill, els.playerHpText, player.hp, player.maxHp);

			els.messageText.textContent = state.message;

			renderActions();
			renderStats();
			renderHangar();
		}

		game.addEventListener('click', function (e) {
			const switchBtn = e.target.closest('[data-action="open-switch"]');
			if (switchBtn) {
				state.mode = 'switch';
				render();
			}
		});

		render();
	});
});
JS;

if (!function_exists('zo_game_rocketmon_browser_render')) {
	function zo_game_rocketmon_browser_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-rocketmon-browser-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--rocketmon-browser" id="<?php echo esc_attr($instance_id); ?>">
			<div class="rb-title">Rocketmon Browser Battle</div>
			<div class="rb-subtitle">Fight, repair, dock enemy rockets, switch your active rocket, or run away. Works on desktop and mobile.</div>

			<div class="rb-arena">
				<div class="rb-side rb-side--enemy">
					<div class="rb-name" data-role="enemy-name">Enemy Rocket</div>
					<div class="rb-level" data-role="enemy-level">Enemy Rocket • Lv1</div>
					<div class="rb-hp-wrap">
						<div class="rb-hp-bar">
							<div class="rb-hp-fill" data-role="enemy-hp-fill"></div>
						</div>
						<div class="rb-hp-text" data-role="enemy-hp-text">HP: 0 / 0</div>
					</div>
				</div>

				<div class="rb-rocket-zone" aria-hidden="true">
					<div class="rb-rocket rb-rocket--enemy">
						<div class="rb-nose"></div>
						<div class="rb-body"></div>
						<div class="rb-fin-left"></div>
						<div class="rb-fin-right"></div>
						<div class="rb-window"></div>
						<div class="rb-flame"></div>
					</div>
				</div>
			</div>

			<div class="rb-player">
				<div class="rb-arena" style="margin:0; background:transparent; border:none; padding:0; min-height:auto;">
					<div class="rb-rocket-zone" aria-hidden="true">
						<div class="rb-rocket">
							<div class="rb-nose"></div>
							<div class="rb-body" style="background:#c8ffd6;"></div>
							<div class="rb-fin-left"></div>
							<div class="rb-fin-right"></div>
							<div class="rb-window"></div>
							<div class="rb-flame"></div>
						</div>
					</div>

					<div class="rb-side rb-side--player">
						<div class="rb-name" data-role="player-name">Your Rocket</div>
						<div class="rb-level" data-role="player-level">Your Rocket • Lv1</div>
						<div class="rb-hp-wrap">
							<div class="rb-hp-bar">
								<div class="rb-hp-fill" data-role="player-hp-fill"></div>
							</div>
							<div class="rb-hp-text" data-role="player-hp-text">HP: 0 / 0</div>
						</div>
						<div class="rb-hangar">
							<button type="button" class="rb-btn" data-action="open-switch" style="margin-top:12px; max-width:220px; margin-left:auto;">Switch Rocket</button>
						</div>
					</div>
				</div>

				<div class="rb-stats" data-role="stats"></div>

				<div class="rb-hangar">
					<strong>Hangar</strong>
					<div class="rb-hangar-list" data-role="hangar-list"></div>
				</div>
			</div>

			<div class="rb-message">
				<div class="rb-message-title">Battle Log</div>
				<div class="rb-message-text" data-role="message-text">A wild enemy rocket appeared.</div>
			</div>

			<div class="rb-actions">
				<div class="rb-actions-title" data-role="action-title">Choose Action</div>
				<div class="rb-grid" data-role="action-grid"></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'rocketmon-browser',
	'name'            => 'Rocketmon Browser Battle',
	'author'          => 'Arslan',
	'description'     => 'A turn-based rocket battle game inspired by the uploaded Python Rocketmon concept.',
	'render_callback' => 'zo_game_rocketmon_browser_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);