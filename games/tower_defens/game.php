<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 980px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-game-root--tower-defense-paths .tdp-card {
	background: #ffffff;
	border: 2px solid #d9e2ec;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
}

.zo-game-root--tower-defense-paths .tdp-title {
	margin: 0 0 10px;
	font-size: 28px;
	line-height: 1.2;
	text-align: center;
	color: #1f2933;
}

.zo-game-root--tower-defense-paths .tdp-instructions {
	margin: 0 0 16px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #52606d;
}

.zo-game-root--tower-defense-paths .tdp-topbar {
	display: grid;
	grid-template-columns: repeat(6, 1fr);
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--tower-defense-paths .tdp-stat {
	background: #f0f4f8;
	border-radius: 12px;
	padding: 12px 10px;
	text-align: center;
}

.zo-game-root--tower-defense-paths .tdp-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.04em;
	color: #7b8794;
	margin-bottom: 4px;
}

.zo-game-root--tower-defense-paths .tdp-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #102a43;
}

.zo-game-root--tower-defense-paths .tdp-status {
	min-height: 28px;
	margin-bottom: 14px;
	font-size: 16px;
	font-weight: 700;
	text-align: center;
	color: #102a43;
}

.zo-game-root--tower-defense-paths .tdp-status.is-good {
	color: #0b6e4f;
}

.zo-game-root--tower-defense-paths .tdp-status.is-bad {
	color: #c81e1e;
}

.zo-game-root--tower-defense-paths .tdp-board-wrap {
	background: #f8fbff;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	padding: 14px;
	margin-bottom: 16px;
	overflow-x: auto;
}

.zo-game-root--tower-defense-paths .tdp-board {
	display: grid;
	grid-template-columns: repeat(12, 52px);
	grid-template-rows: repeat(8, 52px);
	gap: 4px;
	justify-content: center;
	min-width: max-content;
}

.zo-game-root--tower-defense-paths .tdp-cell {
	position: relative;
	width: 52px;
	height: 52px;
	border-radius: 10px;
	background: #86c56d;
	border: 2px solid rgba(0, 0, 0, 0.08);
	cursor: pointer;
	overflow: hidden;
}

.zo-game-root--tower-defense-paths .tdp-cell:hover,
.zo-game-root--tower-defense-paths .tdp-cell:focus {
	outline: none;
	transform: translateY(-1px);
}

.zo-game-root--tower-defense-paths .tdp-cell--path {
	background: #b9783f;
}

.zo-game-root--tower-defense-paths .tdp-cell--hill {
	background: #6fa95f;
	box-shadow: inset 0 0 0 3px rgba(255, 214, 79, 0.45);
}

.zo-game-root--tower-defense-paths .tdp-cell--blocked {
	background: #6b4a30;
}

.zo-game-root--tower-defense-paths .tdp-cell--selected {
	box-shadow: inset 0 0 0 3px #7c3aed;
}

.zo-game-root--tower-defense-paths .tdp-tower {
	position: absolute;
	inset: 7px;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 11px;
	font-weight: 700;
	color: #ffffff;
	border: 2px solid rgba(20, 20, 20, 0.45);
}

.zo-game-root--tower-defense-paths .tdp-tower--basic {
	background: #2563eb;
}

.zo-game-root--tower-defense-paths .tdp-tower--sniper {
	background: #3250b5;
}

.zo-game-root--tower-defense-paths .tdp-tower--freeze {
	background: #67c5e8;
	color: #0f172a;
}

.zo-game-root--tower-defense-paths .tdp-tower--poison {
	background: #6dbb45;
}

.zo-game-root--tower-defense-paths .tdp-tower--bank {
	background: #f59e0b;
}

.zo-game-root--tower-defense-paths .tdp-enemy {
	position: absolute;
	width: 24px;
	height: 24px;
	border-radius: 50%;
	border: 2px solid rgba(20, 20, 20, 0.35);
	top: 14px;
	left: 14px;
}

.zo-game-root--tower-defense-paths .tdp-enemy--normal {
	background: #ef4444;
}

.zo-game-root--tower-defense-paths .tdp-enemy--fast {
	background: #f59e0b;
}

.zo-game-root--tower-defense-paths .tdp-enemy--tank {
	background: #8b5cf6;
}

.zo-game-root--tower-defense-paths .tdp-enemy--healer {
	background: #22c55e;
}

.zo-game-root--tower-defense-paths .tdp-enemy--splitter {
	background: #ec4899;
}

.zo-game-root--tower-defense-paths .tdp-enemy-hp {
	position: absolute;
	left: 5px;
	right: 5px;
	bottom: 5px;
	height: 5px;
	border-radius: 999px;
	background: rgba(255, 255, 255, 0.45);
	overflow: hidden;
}

.zo-game-root--tower-defense-paths .tdp-enemy-hp-fill {
	height: 100%;
	background: #16a34a;
}

.zo-game-root--tower-defense-paths .tdp-controls {
	display: grid;
	grid-template-columns: 1.2fr 1fr;
	gap: 14px;
	margin-bottom: 14px;
}

.zo-game-root--tower-defense-paths .tdp-panel {
	background: #f8fbff;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--tower-defense-paths .tdp-panel-title {
	margin: 0 0 10px;
	font-size: 18px;
	font-weight: 700;
	text-align: center;
	color: #102a43;
}

.zo-game-root--tower-defense-paths .tdp-tower-buttons {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
}

.zo-game-root--tower-defense-paths .tdp-btn,
.zo-game-root--tower-defense-paths .tdp-tower-btn {
	border: 0;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--tower-defense-paths .tdp-btn:hover,
.zo-game-root--tower-defense-paths .tdp-btn:focus,
.zo-game-root--tower-defense-paths .tdp-tower-btn:hover,
.zo-game-root--tower-defense-paths .tdp-tower-btn:focus {
	transform: translateY(-1px);
}

.zo-game-root--tower-defense-paths .tdp-tower-btn {
	background: #e0ecff;
	color: #102a43;
	border: 2px solid #bfd0f3;
	text-align: center;
}

.zo-game-root--tower-defense-paths .tdp-tower-btn.is-active {
	background: #2563eb;
	border-color: #1d4ed8;
	color: #ffffff;
}

.zo-game-root--tower-defense-paths .tdp-actions {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 10px;
}

.zo-game-root--tower-defense-paths .tdp-btn--toggle-top,
.zo-game-root--tower-defense-paths .tdp-btn--toggle-bottom {
	background: #7c3aed;
	color: #ffffff;
}

.zo-game-root--tower-defense-paths .tdp-btn--restart,
.zo-game-root--tower-defense-paths .tdp-btn--wave,
.zo-game-root--tower-defense-paths .tdp-btn--work {
	background: #0b6e4f;
	color: #ffffff;
}

.zo-game-root--tower-defense-paths .tdp-progress {
	text-align: center;
	font-size: 14px;
	color: #52606d;
}

@media (max-width: 760px) {
	.zo-game-root--tower-defense-paths .tdp-topbar {
		grid-template-columns: repeat(2, 1fr);
	}

	.zo-game-root--tower-defense-paths .tdp-controls {
		grid-template-columns: 1fr;
	}

	.zo-game-root--tower-defense-paths .tdp-title {
		font-size: 24px;
	}

	.zo-game-root--tower-defense-paths .tdp-tower-buttons {
		grid-template-columns: repeat(2, 1fr);
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--tower-defense-paths');

	games.forEach(function (game) {
		const moneyEl = game.querySelector('.tdp-money');
		const livesEl = game.querySelector('.tdp-lives');
		const waveEl = game.querySelector('.tdp-wave');
		const scoreEl = game.querySelector('.tdp-score');
		const towersEl = game.querySelector('.tdp-towers');
		const incomeEl = game.querySelector('.tdp-income');
		const statusEl = game.querySelector('.tdp-status');
		const boardEl = game.querySelector('.tdp-board');
		const progressEl = game.querySelector('.tdp-progress');
		const towerButtons = game.querySelectorAll('.tdp-tower-btn');
		const toggleTopBtn = game.querySelector('.tdp-btn--toggle-top');
		const toggleBottomBtn = game.querySelector('.tdp-btn--toggle-bottom');
		const restartBtn = game.querySelector('.tdp-btn--restart');
		const waveBtn = game.querySelector('.tdp-btn--wave');
		const workBtn = game.querySelector('.tdp-btn--work');

		const width = 12;
		const height = 8;

		const topPath = [
			[0, 5], [1, 5], [2, 5], [2, 4], [2, 3], [3, 3], [4, 3], [5, 3], [5, 2], [6, 2], [7, 2], [8, 2], [9, 2], [9, 1], [10, 1], [11, 1]
		];

		const bottomPath = [
			[0, 5], [1, 5], [2, 5], [2, 6], [3, 6], [4, 6], [5, 6], [5, 5], [6, 5], [7, 5], [8, 5], [8, 4], [9, 4], [10, 4], [10, 3], [11, 1]
		];

		const hillCells = {
			'4,2': 1.35,
			'7,3': 1.4,
			'8,5': 1.3,
			'10,2': 1.35
		};

		const towerTypes = {
			basic: { name: 'Basic', cost: 50, range: 2.2, fireDelay: 2, damage: 20, className: 'basic', income: 0 },
			sniper: { name: 'Sniper', cost: 120, range: 4.8, fireDelay: 4, damage: 38, className: 'sniper', income: 0 },
			freeze: { name: 'Freeze', cost: 90, range: 2.4, fireDelay: 3, damage: 8, className: 'freeze', income: 0 },
			poison: { name: 'Poison', cost: 110, range: 2.6, fireDelay: 3, damage: 7, className: 'poison', income: 0 },
			bank: { name: 'Bank', cost: 80, range: 0, fireDelay: 0, damage: 0, className: 'bank', income: 8 }
		};

		const enemyTypes = {
			normal: { hp: 45, speed: 1, reward: 8, className: 'normal' },
			fast: { hp: 30, speed: 1.7, reward: 9, className: 'fast' },
			tank: { hp: 110, speed: 0.75, reward: 14, className: 'tank' },
			healer: { hp: 60, speed: 1, reward: 12, className: 'healer' },
			splitter: { hp: 55, speed: 1.05, reward: 11, className: 'splitter' }
		};

		let selectedTowerType = 'basic';
		let money = 800;
		let lives = 20;
		let wave = 1;
		let score = 0;
		let topBlocked = false;
		let bottomBlocked = false;
		let towers = [];
		let enemies = [];
		let boardCells = [];
		let tick = 0;
		let spawnQueue = 0;
		let spawnDelay = 12;
		let gameLoop = null;
		let ended = false;
		let workCooldown = 0;

		function key(x, y) {
			return x + ',' + y;
		}

		function setStatus(message, type) {
			statusEl.textContent = message;
			statusEl.classList.remove('is-good', 'is-bad');
			if (type === 'good') {
				statusEl.classList.add('is-good');
			} else if (type === 'bad') {
				statusEl.classList.add('is-bad');
			}
		}

		function getPassiveIncome() {
			let income = 0;
			towers.forEach(function (tower) {
				if (tower.type === 'bank') {
					income += tower.income;
				}
			});
			return income;
		}

		function updateStats() {
			moneyEl.textContent = String(money);
			livesEl.textContent = String(lives);
			waveEl.textContent = String(wave);
			scoreEl.textContent = String(score);
			towersEl.textContent = String(towers.length);
			incomeEl.textContent = String(getPassiveIncome());
			progressEl.textContent = 'Build Bank towers or press Work for extra money.';
		}

		function isTopPathCell(x, y) {
			return topPath.some(function (point) {
				return point[0] === x && point[1] === y;
			});
		}

		function isBottomPathCell(x, y) {
			return bottomPath.some(function (point) {
				return point[0] === x && point[1] === y;
			});
		}

		function getOpenPaths() {
			const openPaths = [];
			if (!topBlocked) {
				openPaths.push({ name: 'top', points: topPath });
			}
			if (!bottomBlocked) {
				openPaths.push({ name: 'bottom', points: bottomPath });
			}
			if (!openPaths.length) {
				bottomBlocked = false;
				openPaths.push({ name: 'bottom', points: bottomPath });
			}
			return openPaths;
		}

		function buildBoard() {
			boardEl.innerHTML = '';
			boardCells = [];

			for (let y = 0; y < height; y++) {
				for (let x = 0; x < width; x++) {
					const cell = document.createElement('button');
					cell.type = 'button';
					cell.className = 'tdp-cell';
					cell.setAttribute('data-x', String(x));
					cell.setAttribute('data-y', String(y));

					cell.addEventListener('click', function () {
						handleCellClick(x, y);
					});

					boardEl.appendChild(cell);
					boardCells.push({
						x: x,
						y: y,
						el: cell
					});
				}
			}
		}

		function towerAt(x, y) {
			return towers.find(function (tower) {
				return tower.x === x && tower.y === y;
			});
		}

		function isPathCell(x, y) {
			const topHere = isTopPathCell(x, y);
			const bottomHere = isBottomPathCell(x, y);
			if (topHere && !topBlocked) {
				return true;
			}
			if (bottomHere && !bottomBlocked) {
				return true;
			}
			return false;
		}

		function renderBoard() {
			boardCells.forEach(function (cellObj) {
				const cell = cellObj.el;
				const x = cellObj.x;
				const y = cellObj.y;
				cell.className = 'tdp-cell';
				cell.innerHTML = '';

				if (hillCells[key(x, y)]) {
					cell.classList.add('tdp-cell--hill');
				}

				if (isTopPathCell(x, y) && topBlocked) {
					cell.classList.add('tdp-cell--blocked');
				} else if (isBottomPathCell(x, y) && bottomBlocked) {
					cell.classList.add('tdp-cell--blocked');
				} else if (isPathCell(x, y)) {
					cell.classList.add('tdp-cell--path');
				}

				const tower = towerAt(x, y);
				if (tower) {
					const towerEl = document.createElement('div');
					towerEl.className = 'tdp-tower tdp-tower--' + tower.type;
					towerEl.textContent = tower.label;
					cell.appendChild(towerEl);
				}

				const enemiesHere = enemies.filter(function (enemy) {
					return Math.round(enemy.displayX) === x && Math.round(enemy.displayY) === y;
				});

				if (enemiesHere.length) {
					const enemy = enemiesHere[0];
					const enemyEl = document.createElement('div');
					enemyEl.className = 'tdp-enemy tdp-enemy--' + enemy.type;

					const hpOuter = document.createElement('div');
					hpOuter.className = 'tdp-enemy-hp';

					const hpFill = document.createElement('div');
					hpFill.className = 'tdp-enemy-hp-fill';
					hpFill.style.width = Math.max(0, Math.round((enemy.hp / enemy.maxHp) * 100)) + '%';

					hpOuter.appendChild(hpFill);
					cell.appendChild(enemyEl);
					cell.appendChild(hpOuter);
				}
			});
		}

		function renderTowerSelection() {
			towerButtons.forEach(function (button) {
				const type = button.getAttribute('data-type');
				button.classList.toggle('is-active', type === selectedTowerType);
			});
		}

		function chooseEnemyType() {
			const r = Math.random();

			if (wave < 3) {
				if (r < 0.72) return 'normal';
				if (r < 0.9) return 'fast';
				return 'tank';
			}

			if (wave < 6) {
				if (r < 0.45) return 'normal';
				if (r < 0.68) return 'fast';
				if (r < 0.84) return 'tank';
				if (r < 0.92) return 'healer';
				return 'splitter';
			}

			if (r < 0.18) return 'normal';
			if (r < 0.38) return 'fast';
			if (r < 0.58) return 'tank';
			if (r < 0.78) return 'healer';
			return 'splitter';
		}

		function spawnEnemy(type) {
			const openPaths = getOpenPaths();
			const choice = openPaths[Math.floor(Math.random() * openPaths.length)];
			const data = enemyTypes[type];

			enemies.push({
				type: type,
				pathName: choice.name,
				path: choice.points,
				step: 0,
				progress: 0,
				displayX: choice.points[0][0],
				displayY: choice.points[0][1],
				hp: data.hp + ((wave - 1) * 10),
				maxHp: data.hp + ((wave - 1) * 10),
				speed: data.speed,
				reward: data.reward,
				slowTicks: 0,
				poisonTicks: 0,
				poisonDamage: 0,
				healTicks: 0,
				splitDone: false
			});
		}

		function handleCellClick(x, y) {
			if (ended) {
				return;
			}

			if (isPathCell(x, y)) {
				setStatus('You cannot build on the path.', 'bad');
				return;
			}

			if (towerAt(x, y)) {
				setStatus('There is already a tower here.', 'bad');
				return;
			}

			const cost = towerTypes[selectedTowerType].cost;

			if (money < cost) {
				setStatus('Not enough money for that tower.', 'bad');
				return;
			}

			const bonus = hillCells[key(x, y)] || 1;
			const towerData = towerTypes[selectedTowerType];

			towers.push({
				x: x,
				y: y,
				type: selectedTowerType,
				label: towerData.name.charAt(0),
				range: towerData.range * bonus,
				damage: towerData.damage,
				fireDelay: towerData.fireDelay,
				cooldown: 0,
				income: towerData.income || 0
			});

			money -= cost;
			updateStats();
			renderBoard();

			if (selectedTowerType === 'bank') {
				setStatus('Bank tower placed. It will make money over time.', 'good');
			} else {
				setStatus(towerData.name + ' tower placed.', 'good');
			}
		}

		function getEnemyDistance(tower, enemy) {
			return Math.hypot(enemy.displayX - tower.x, enemy.displayY - tower.y);
		}

		function applyTowerAttack(tower, enemy) {
			if (tower.type === 'freeze') {
				enemy.hp -= tower.damage;
				enemy.slowTicks = Math.max(enemy.slowTicks, 5);
			} else if (tower.type === 'poison') {
				enemy.hp -= tower.damage;
				enemy.poisonTicks = Math.max(enemy.poisonTicks, 8);
				enemy.poisonDamage = Math.max(enemy.poisonDamage, 4);
			} else {
				enemy.hp -= tower.damage;
			}

			if (enemy.hp <= 0) {
				handleEnemyDeath(enemy);
			}
		}

		function handleEnemyDeath(enemy) {
			if (enemy.type === 'splitter' && !enemy.splitDone) {
				enemy.splitDone = true;
				for (let i = 0; i < 2; i++) {
					enemies.push({
						type: 'fast',
						pathName: enemy.pathName,
						path: enemy.path,
						step: enemy.step,
						progress: enemy.progress,
						displayX: enemy.displayX,
						displayY: enemy.displayY,
						hp: 18,
						maxHp: 18,
						speed: 1.9,
						reward: 3,
						slowTicks: 0,
						poisonTicks: 0,
						poisonDamage: 0,
						healTicks: 0,
						splitDone: true
					});
				}
			}

			const index = enemies.indexOf(enemy);
			if (index !== -1) {
				enemies.splice(index, 1);
				money += enemy.reward;
				score += 1;
			}
		}

		function payBanks() {
			const passiveIncome = getPassiveIncome();
			if (passiveIncome > 0 && tick % 10 === 0) {
				money += passiveIncome;
				setStatus('Your Bank towers made +' + passiveIncome + ' money.', 'good');
			}
		}

		function updateTowers() {
			towers.forEach(function (tower) {
				if (tower.type === 'bank') {
					return;
				}

				if (tower.cooldown > 0) {
					tower.cooldown -= 1;
					return;
				}

				let target = null;
				let bestStep = -1;

				enemies.forEach(function (enemy) {
					const dist = getEnemyDistance(tower, enemy);
					if (dist <= tower.range) {
						if (enemy.step > bestStep) {
							bestStep = enemy.step;
							target = enemy;
						}
					}
				});

				if (target) {
					applyTowerAttack(tower, target);
					tower.cooldown = tower.fireDelay;
				}
			});
		}

		function updateHealers() {
			enemies.forEach(function (enemy) {
				if (enemy.type !== 'healer') {
					return;
				}

				enemy.healTicks += 1;

				if (enemy.healTicks < 6) {
					return;
				}

				enemy.healTicks = 0;

				enemies.forEach(function (other) {
					if (other === enemy) {
						return;
					}

					const dist = Math.hypot(other.displayX - enemy.displayX, other.displayY - enemy.displayY);
					if (dist <= 1.6) {
						other.hp = Math.min(other.maxHp, other.hp + 8);
					}
				});
			});
		}

		function updatePoison() {
			enemies.slice().forEach(function (enemy) {
				if (enemy.poisonTicks > 0) {
					enemy.poisonTicks -= 1;
					enemy.hp -= enemy.poisonDamage;

					if (enemy.hp <= 0) {
						handleEnemyDeath(enemy);
					}
				}
			});
		}

		function moveEnemy(enemy) {
			const path = enemy.path;

			if (enemy.step >= path.length - 1) {
				lives -= 1;
				return false;
			}

			const speedMod = enemy.slowTicks > 0 ? 0.45 : 1;
			const moveAmount = 0.35 * enemy.speed * speedMod;

			enemy.progress += moveAmount;

			if (enemy.progress >= 1) {
				enemy.progress = 0;
				enemy.step += 1;
				if (enemy.step >= path.length - 1) {
					lives -= 1;
					return false;
				}
			}

			const from = path[enemy.step];
			const to = path[Math.min(enemy.step + 1, path.length - 1)];
			enemy.displayX = from[0] + ((to[0] - from[0]) * enemy.progress);
			enemy.displayY = from[1] + ((to[1] - from[1]) * enemy.progress);

			if (enemy.slowTicks > 0) {
				enemy.slowTicks -= 1;
			}

			return true;
		}

		function updateEnemies() {
			enemies.slice().forEach(function (enemy) {
				const alive = moveEnemy(enemy);
				if (!alive) {
					const index = enemies.indexOf(enemy);
					if (index !== -1) {
						enemies.splice(index, 1);
					}
				}
			});
		}

		function startWave() {
			if (ended) {
				return;
			}

			spawnQueue += 10 + (wave * 3);
			setStatus('New wave started.', 'good');
		}

		function maybeSpawn() {
			if (spawnQueue <= 0) {
				return;
			}

			if (tick % spawnDelay !== 0) {
				return;
			}

			spawnEnemy(chooseEnemyType());
			spawnQueue -= 1;
		}

		function updateWave() {
			if (score > 0 && score % 12 === 0) {
				wave = Math.max(wave, 1 + Math.floor(score / 12));
			}
		}

		function endGame() {
			ended = true;
			if (gameLoop) {
				clearInterval(gameLoop);
				gameLoop = null;
			}
			setStatus('Game Over. Press Restart.', 'bad');
			updateStats();
		}

		function doWork() {
			if (ended) {
				return;
			}

			if (workCooldown > 0) {
				setStatus('Work is cooling down. Wait a little.', 'bad');
				return;
			}

			const earned = 25 + (wave * 2);
			money += earned;
			workCooldown = 12;
			updateStats();
			setStatus('You worked and earned +' + earned + ' money.', 'good');
		}

		function tickGame() {
			if (ended) {
				return;
			}

			tick += 1;

			if (workCooldown > 0) {
				workCooldown -= 1;
			}

			maybeSpawn();
			payBanks();
			updatePoison();
			updateHealers();
			updateTowers();
			updateEnemies();
			updateWave();
			renderBoard();
			updateStats();

			if (lives <= 0) {
				endGame();
			}
		}

		function resetGame() {
			money = 800;
			lives = 40;
			wave = 1;
			score = 0;
			topBlocked = false;
			bottomBlocked = false;
			towers = [];
			enemies = [];
			tick = 0;
			spawnQueue = 16;
			ended = false;
			workCooldown = 0;

			if (gameLoop) {
				clearInterval(gameLoop);
				gameLoop = null;
			}

			updateStats();
			renderTowerSelection();
			renderBoard();
			setStatus('Place towers, build Banks, or press Work for money.', '');
			gameLoop = setInterval(tickGame, 350);
		}

		towerButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				selectedTowerType = button.getAttribute('data-type');
				renderTowerSelection();
				setStatus('Selected ' + towerTypes[selectedTowerType].name + ' tower.', '');
			});
		});

		toggleTopBtn.addEventListener('click', function () {
			if (topBlocked) {
				topBlocked = false;
				renderBoard();
				setStatus('Top path opened.', '');
				return;
			}

			if (bottomBlocked) {
				setStatus('At least one path must stay open.', 'bad');
				return;
			}

			topBlocked = true;
			renderBoard();
			setStatus('Top path blocked.', 'good');
		});

		toggleBottomBtn.addEventListener('click', function () {
			if (bottomBlocked) {
				bottomBlocked = false;
				renderBoard();
				setStatus('Bottom path opened.', '');
				return;
			}

			if (topBlocked) {
				setStatus('At least one path must stay open.', 'bad');
				return;
			}

			bottomBlocked = true;
			renderBoard();
			setStatus('Bottom path blocked.', 'good');
		});

		waveBtn.addEventListener('click', startWave);
		restartBtn.addEventListener('click', resetGame);
		workBtn.addEventListener('click', doWork);

		buildBoard();
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_tower_defense_paths_render')) {
	function zo_game_tower_defense_paths_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-tower-defense-paths-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--tower-defense-paths" id="<?php echo esc_attr($instance_id); ?>">
			<div class="tdp-card">
				<h2 class="tdp-title">Tower Defense Paths</h2>
				<p class="tdp-instructions">Place towers on grass. Build Bank towers for passive income, or press Work to earn money manually.</p>

				<div class="tdp-topbar">
					<div class="tdp-stat">
						<span class="tdp-stat-label">Money</span>
						<span class="tdp-stat-value tdp-money">0</span>
					</div>
					<div class="tdp-stat">
						<span class="tdp-stat-label">Lives</span>
						<span class="tdp-stat-value tdp-lives">0</span>
					</div>
					<div class="tdp-stat">
						<span class="tdp-stat-label">Wave</span>
						<span class="tdp-stat-value tdp-wave">1</span>
					</div>
					<div class="tdp-stat">
						<span class="tdp-stat-label">Score</span>
						<span class="tdp-stat-value tdp-score">0</span>
					</div>
					<div class="tdp-stat">
						<span class="tdp-stat-label">Towers</span>
						<span class="tdp-stat-value tdp-towers">0</span>
					</div>
					<div class="tdp-stat">
						<span class="tdp-stat-label">Income</span>
						<span class="tdp-stat-value tdp-income">0</span>
					</div>
				</div>

				<div class="tdp-status" aria-live="polite">Place towers, build Banks, or press Work for money.</div>

				<div class="tdp-board-wrap">
					<div class="tdp-board"></div>
				</div>

				<div class="tdp-controls">
					<div class="tdp-panel">
						<h3 class="tdp-panel-title">Towers</h3>
						<div class="tdp-tower-buttons">
							<button type="button" class="tdp-tower-btn is-active" data-type="basic">Basic<br>$50</button>
							<button type="button" class="tdp-tower-btn" data-type="sniper">Sniper<br>$120</button>
							<button type="button" class="tdp-tower-btn" data-type="freeze">Freeze<br>$90</button>
							<button type="button" class="tdp-tower-btn" data-type="poison">Poison<br>$110</button>
							<button type="button" class="tdp-tower-btn" data-type="bank">Bank<br>$80</button>
						</div>
					</div>

					<div class="tdp-panel">
						<h3 class="tdp-panel-title">Actions</h3>
						<div class="tdp-actions">
							<button type="button" class="tdp-btn tdp-btn--toggle-top">Toggle Top Path</button>
							<button type="button" class="tdp-btn tdp-btn--toggle-bottom">Toggle Bottom Path</button>
							<button type="button" class="tdp-btn tdp-btn--wave">More Enemies</button>
							<button type="button" class="tdp-btn tdp-btn--work">Work For Money</button>
							<button type="button" class="tdp-btn tdp-btn--restart">Restart</button>
						</div>
					</div>
				</div>

				<div class="tdp-progress">Build Bank towers or press Work for extra money.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'tower-defense-paths',
	'name'            => 'Tower Defense Paths',
	'author'          => 'Arslan',
	'description'     => 'A browser tower defense game with two routes, tower types, status effects, route blocking, and extra money actions.',
	'render_callback' => 'zo_game_tower_defense_paths_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);