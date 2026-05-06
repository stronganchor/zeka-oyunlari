<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--mini-manager-pro {
	max-width: 1180px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
	color: #1f2a1f;
}

.zo-game-root--mini-manager-pro * {
	box-sizing: border-box;
}

.zo-mm-wrap {
	background: #f4f7f2;
	border: 2px solid #d7e0d0;
	border-radius: 18px;
	padding: 14px;
}

.zo-mm-topbar,
.zo-mm-subbar,
.zo-mm-action-row,
.zo-mm-market-actions,
.zo-mm-squad-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
	margin-bottom: 12px;
}

.zo-mm-panel,
.zo-mm-card,
.zo-mm-status,
.zo-mm-table-card,
.zo-mm-commentary,
.zo-mm-help,
.zo-mm-market,
.zo-mm-squad,
.zo-mm-results,
.zo-mm-finance {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 14px;
	padding: 12px;
}

.zo-mm-panel {
	min-width: 120px;
	text-align: center;
}

.zo-mm-panel strong {
	display: block;
	font-size: 20px;
	color: #1d2a1d;
}

.zo-mm-panel span {
	display: block;
	font-size: 13px;
	margin-top: 4px;
	color: #445244;
}

.zo-mm-layout {
	display: grid;
	grid-template-columns: 1.1fr 0.9fr;
	gap: 12px;
	margin-bottom: 12px;
}

.zo-mm-left,
.zo-mm-right {
	display: flex;
	flex-direction: column;
	gap: 12px;
}

.zo-mm-grid-2 {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 12px;
}

.zo-mm-card h3,
.zo-mm-table-card h3,
.zo-mm-market h3,
.zo-mm-squad h3,
.zo-mm-results h3,
.zo-mm-commentary h3,
.zo-mm-finance h3,
.zo-mm-status h3,
.zo-mm-help h3 {
	margin: 0 0 10px;
	font-size: 18px;
	color: #1d2a1d;
}

.zo-mm-btn {
	border: none;
	border-radius: 10px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
	background: #1d2a1d;
	color: #fff;
}

.zo-mm-btn:hover {
	opacity: 0.92;
}

.zo-mm-btn[disabled] {
	opacity: 0.45;
	cursor: default;
}

.zo-mm-btn.is-active {
	background: #1565c0;
}

.zo-mm-pill-row {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-mm-pill {
	padding: 8px 12px;
	border-radius: 999px;
	border: 2px solid #dfe7d8;
	background: #fff;
	font-size: 13px;
	font-weight: 700;
	cursor: pointer;
}

.zo-mm-pill.is-active {
	background: #1565c0;
	border-color: #1565c0;
	color: #fff;
}

.zo-mm-field-wrap {
	background: #fff;
	border: 2px solid #dfe7d8;
	border-radius: 14px;
	padding: 12px;
}

.zo-mm-field {
	position: relative;
	width: 100%;
	height: 430px;
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

.zo-mm-line-mid,
.zo-mm-circle,
.zo-mm-dot,
.zo-mm-box-left,
.zo-mm-box-right,
.zo-mm-goal-left,
.zo-mm-goal-right {
	position: absolute;
	pointer-events: none;
}

.zo-mm-line-mid {
	left: 50%;
	top: 0;
	width: 4px;
	height: 100%;
	margin-left: -2px;
	background: rgba(255,255,255,0.95);
}

.zo-mm-circle {
	left: 50%;
	top: 50%;
	width: 120px;
	height: 120px;
	margin-left: -60px;
	margin-top: -60px;
	border: 4px solid rgba(255,255,255,0.95);
	border-radius: 50%;
}

.zo-mm-dot {
	width: 10px;
	height: 10px;
	background: rgba(255,255,255,0.95);
	border-radius: 50%;
	left: 50%;
	top: 50%;
	margin-left: -5px;
	margin-top: -5px;
}

.zo-mm-box-left,
.zo-mm-box-right {
	top: 125px;
	width: 95px;
	height: 180px;
	border: 4px solid rgba(255,255,255,0.95);
}

.zo-mm-box-left {
	left: 0;
	border-left: none;
	border-radius: 0 10px 10px 0;
}

.zo-mm-box-right {
	right: 0;
	border-right: none;
	border-radius: 10px 0 0 10px;
}

.zo-mm-goal-left,
.zo-mm-goal-right {
	top: 165px;
	width: 16px;
	height: 100px;
	background: rgba(255,255,255,0.95);
}

.zo-mm-goal-left {
	left: 0;
	border-radius: 0 6px 6px 0;
}

.zo-mm-goal-right {
	right: 0;
	border-radius: 6px 0 0 6px;
}

.zo-mm-player {
	position: absolute;
	width: 28px;
	height: 28px;
	margin-left: -14px;
	margin-top: -14px;
	border-radius: 50%;
	border: 2px solid rgba(255,255,255,0.95);
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 9px;
	font-weight: 700;
	color: #fff;
}

.zo-mm-player--blue {
	background: #1e88e5;
}

.zo-mm-player--red {
	background: #e53935;
}

.zo-mm-row {
	display: grid;
	grid-template-columns: 130px 1fr 44px;
	align-items: center;
	gap: 8px;
	margin-bottom: 10px;
	font-size: 14px;
}

.zo-mm-row:last-child {
	margin-bottom: 0;
}

.zo-mm-row input[type="range"] {
	width: 100%;
}

.zo-mm-value {
	font-weight: 700;
	text-align: center;
}

.zo-mm-select {
	width: 100%;
	padding: 10px 12px;
	border-radius: 10px;
	border: 2px solid #dfe7d8;
	font-size: 14px;
	background: #fff;
}

.zo-mm-tables {
	width: 100%;
	border-collapse: collapse;
	font-size: 13px;
}

.zo-mm-tables th,
.zo-mm-tables td {
	border-bottom: 1px solid #e7ede2;
	padding: 8px 6px;
	text-align: left;
}

.zo-mm-tables th {
	font-size: 12px;
	color: #526152;
}

.zo-mm-tables tr:last-child td {
	border-bottom: none;
}

.zo-mm-scroll {
	max-height: 250px;
	overflow: auto;
}

.zo-mm-commentary-log,
.zo-mm-results-log {
	max-height: 260px;
	overflow: auto;
	border-top: 1px solid #e7ede2;
	padding-top: 8px;
}

.zo-mm-line {
	padding: 6px 0;
	border-bottom: 1px solid #edf2e8;
	font-size: 13px;
}

.zo-mm-line:last-child {
	border-bottom: none;
}

.zo-mm-market-player,
.zo-mm-squad-player {
	display: grid;
	grid-template-columns: 1.4fr 0.8fr 0.8fr 0.8fr 0.8fr auto;
	gap: 8px;
	align-items: center;
	padding: 8px 0;
	border-bottom: 1px solid #edf2e8;
	font-size: 13px;
}

.zo-mm-market-player:last-child,
.zo-mm-squad-player:last-child {
	border-bottom: none;
}

.zo-mm-tag {
	display: inline-block;
	padding: 3px 7px;
	border-radius: 999px;
	font-size: 11px;
	font-weight: 700;
	background: #e8f1ff;
	color: #1565c0;
}

.zo-mm-tag--bad {
	background: #fff1f1;
	color: #b3261e;
}

.zo-mm-tag--good {
	background: #eef9ec;
	color: #2e7d32;
}

.zo-mm-kpi-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 10px;
}

.zo-mm-kpi {
	background: #f8faf7;
	border: 2px solid #dfe7d8;
	border-radius: 12px;
	padding: 10px;
	text-align: center;
}

.zo-mm-kpi strong {
	display: block;
	font-size: 18px;
}

.zo-mm-kpi span {
	display: block;
	font-size: 12px;
	margin-top: 4px;
	color: #526152;
}

.zo-mm-note {
	font-size: 13px;
	color: #526152;
	margin-top: 8px;
}

@media (max-width: 980px) {
	.zo-mm-layout {
		grid-template-columns: 1fr;
	}

	.zo-mm-grid-2,
	.zo-mm-kpi-grid {
		grid-template-columns: 1fr 1fr;
	}
}

@media (max-width: 640px) {
	.zo-mm-field {
		height: 330px;
	}

	.zo-mm-grid-2,
	.zo-mm-kpi-grid {
		grid-template-columns: 1fr;
	}

	.zo-mm-row {
		grid-template-columns: 105px 1fr 40px;
		font-size: 13px;
	}

	.zo-mm-market-player,
	.zo-mm-squad-player {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--mini-manager-pro');

	games.forEach(function (game) {
		const field = game.querySelector('.zo-mm-field');
		const formationButtons = Array.from(game.querySelectorAll('.zo-mm-formation'));
		const mentalityButtons = Array.from(game.querySelectorAll('.zo-mm-mentality'));
		const styleButtons = Array.from(game.querySelectorAll('.zo-mm-style'));
		const widthButtons = Array.from(game.querySelectorAll('.zo-mm-width'));
		const pressButtons = Array.from(game.querySelectorAll('.zo-mm-press'));
		const markingButtons = Array.from(game.querySelectorAll('.zo-mm-marking'));
		const simulateBtn = game.querySelector('.zo-mm-simulate');
		const nextMatchBtn = game.querySelector('.zo-mm-next-match');
		const resetSeasonBtn = game.querySelector('.zo-mm-reset-season');
		const buyScoutBtn = game.querySelector('.zo-mm-buy-scout');
		const buyTrainingBtn = game.querySelector('.zo-mm-buy-training');
		const buyStadiumBtn = game.querySelector('.zo-mm-buy-stadium');
		const healAllBtn = game.querySelector('.zo-mm-heal-all');
		const youthBtn = game.querySelector('.zo-mm-youth');

		const attackInput = game.querySelector('.zo-mm-attack');
		const midfieldInput = game.querySelector('.zo-mm-midfield');
		const defenseInput = game.querySelector('.zo-mm-defense');
		const energyInput = game.querySelector('.zo-mm-energy');

		const attackValue = game.querySelector('.zo-mm-attack-value');
		const midfieldValue = game.querySelector('.zo-mm-midfield-value');
		const defenseValue = game.querySelector('.zo-mm-defense-value');
		const energyValue = game.querySelector('.zo-mm-energy-value');

		const scoreBlue = game.querySelector('.zo-mm-score-blue');
		const scoreRed = game.querySelector('.zo-mm-score-red');
		const winsValue = game.querySelector('.zo-mm-wins');
		const coinsValue = game.querySelector('.zo-mm-coins');
		const ratingValue = game.querySelector('.zo-mm-rating');
		const budgetValue = game.querySelector('.zo-mm-budget');
		const reputationValue = game.querySelector('.zo-mm-reputation');
		const weekValue = game.querySelector('.zo-mm-week');
		const divisionValue = game.querySelector('.zo-mm-division');
		const seasonPointsValue = game.querySelector('.zo-mm-season-points');
		const sponsorValue = game.querySelector('.zo-mm-sponsor');
		const homeAwayValue = game.querySelector('.zo-mm-homeaway');
		const weatherValue = game.querySelector('.zo-mm-weather');
		const statusText = game.querySelector('.zo-mm-status-text');
		const quickSummary = game.querySelector('.zo-mm-quick-summary');

		const statPossession = game.querySelector('.zo-mm-stat-possession');
		const statShots = game.querySelector('.zo-mm-stat-shots');
		const statOnTarget = game.querySelector('.zo-mm-stat-ontarget');
		const statCorners = game.querySelector('.zo-mm-stat-corners');
		const statCards = game.querySelector('.zo-mm-stat-cards');
		const statFouls = game.querySelector('.zo-mm-stat-fouls');
		const statMomentum = game.querySelector('.zo-mm-stat-momentum');
		const statClean = game.querySelector('.zo-mm-stat-clean');

		const commentaryLog = game.querySelector('.zo-mm-commentary-log');
		const resultsLog = game.querySelector('.zo-mm-results-log');
		const tableBody = game.querySelector('.zo-mm-league-body');
		const marketBody = game.querySelector('.zo-mm-market-body');
		const squadBody = game.querySelector('.zo-mm-squad-body');
		const financeBody = game.querySelector('.zo-mm-finance-body');

		let playerNodes = [];
		let team = null;
		let season = null;
		let market = [];
		let financeLog = [];
		let lastStats = null;

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

		const opponentFormation = [
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

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function rand(min, max) {
			return Math.random() * (max - min) + min;
		}

		function randInt(min, max) {
			return Math.floor(rand(min, max + 1));
		}

		function pick(arr) {
			return arr[Math.floor(Math.random() * arr.length)];
		}

		function slugify(str) {
			return str.toLowerCase().replace(/[^a-z0-9]+/g, '-');
		}

		function setButtonGroup(buttons, value, attr) {
			buttons.forEach(function (button) {
				button.classList.toggle('is-active', button.getAttribute(attr) === value);
			});
		}

		function addFinance(type, amount, note) {
			financeLog.unshift({
				type: type,
				amount: amount,
				note: note
			});
			financeLog = financeLog.slice(0, 24);
		}

		function makePlayer(name, pos, ovr, price) {
			return {
				id: slugify(name + '-' + pos + '-' + Math.floor(Math.random() * 100000)),
				name: name,
				pos: pos,
				ovr: ovr,
				price: price,
				wage: Math.max(1, Math.round(ovr / 8)),
				morale: randInt(58, 86),
				energy: randInt(62, 94),
				injured: false,
				suspended: false,
				role: pos === 'F' ? 'Scorer' : (pos === 'M' ? 'Playmaker' : (pos === 'D' ? 'Stopper' : 'Keeper'))
			};
		}

		function seededSquad() {
			return [
				makePlayer('Miran Kaya', 'GK', 60, 14),
				makePlayer('Eren Demir', 'D', 61, 16),
				makePlayer('Baran Aslan', 'D', 62, 18),
				makePlayer('Emir Kaplan', 'D', 59, 12),
				makePlayer('Yusuf Acar', 'D', 58, 11),
				makePlayer('Deniz Yalcin', 'D', 57, 10),
				makePlayer('Arda Sahin', 'M', 63, 20),
				makePlayer('Kerem Usta', 'M', 61, 15),
				makePlayer('Talha Cicek', 'M', 60, 14),
				makePlayer('Mete Can', 'M', 58, 10),
				makePlayer('Omer Gunes', 'F', 64, 23),
				makePlayer('Kaan Kurt', 'F', 62, 18),
				makePlayer('Ali Vural', 'F', 59, 12),
				makePlayer('Samet Tunc', 'M', 56, 9),
				makePlayer('Umut Boz', 'D', 55, 8),
				makePlayer('Riza Cakir', 'GK', 54, 7)
			];
		}

		function makeMarketPool() {
			const names = ['Can', 'Mert', 'Taha', 'Ilyas', 'Furkan', 'Burak', 'Onur', 'Berk', 'Tolga', 'Emre', 'Sinan', 'Recep', 'Hakan', 'Batuhan', 'Cenk', 'Akin'];
			const surnames = ['Kaya', 'Demir', 'Aslan', 'Celik', 'Tas', 'Aydin', 'Sari', 'Kurt', 'Yildiz', 'Kilic', 'Arslan', 'Koc', 'Yaman', 'Acar'];
			const positions = ['GK', 'D', 'M', 'F'];
			const list = [];
			for (let i = 0; i < 16; i++) {
				const ovr = randInt(52, 76);
				list.push(makePlayer(pick(names) + ' ' + pick(surnames), pick(positions), ovr, Math.max(6, Math.round(ovr / 3))));
			}
			return list;
		}

		function initState() {
			team = {
				name: 'Blue Town FC',
				formation: '4-4-2',
				mentality: 'balanced',
				style: 'short',
				width: 'balanced',
				press: 'medium',
				marking: 'zonal',
				attack: 60,
				midfield: 60,
				defense: 60,
				energy: 60,
				budget: 60,
				coins: 0,
				reputation: 1,
				division: 1,
				wins: 0,
				points: 0,
				sponsor: 10,
				scoutLevel: 0,
				trainingLevel: 0,
				stadiumLevel: 0,
				youthLevel: 0,
				squad: seededSquad(),
				captainId: null
			};

			team.captainId = team.squad[6].id;

			season = {
				week: 1,
				totalWeeks: 14,
				home: true,
				weather: 'Clear',
				fixturesDone: 0,
				results: [],
				teams: [
					{ name: 'Blue Town FC', pts: 0, gf: 0, ga: 0, w: 0, d: 0, l: 0 },
					{ name: 'River Adana', pts: 0, gf: 0, ga: 0, w: 0, d: 0, l: 0 },
					{ name: 'Toros SK', pts: 0, gf: 0, ga: 0, w: 0, d: 0, l: 0 },
					{ name: 'Cukurova Stars', pts: 0, gf: 0, ga: 0, w: 0, d: 0, l: 0 },
					{ name: 'Yuregir Club', pts: 0, gf: 0, ga: 0, w: 0, d: 0, l: 0 },
					{ name: 'Delta Spor', pts: 0, gf: 0, ga: 0, w: 0, d: 0, l: 0 },
					{ name: 'Anatolia 23', pts: 0, gf: 0, ga: 0, w: 0, d: 0, l: 0 },
					{ name: 'Orange Garden', pts: 0, gf: 0, ga: 0, w: 0, d: 0, l: 0 }
				]
			};

			market = makeMarketPool();
			financeLog = [];
			lastStats = null;
			addFinance('Income', 20, 'Starting sponsor money');
		}

		function updateInputsFromTeam() {
			attackInput.value = String(team.attack);
			midfieldInput.value = String(team.midfield);
			defenseInput.value = String(team.defense);
			energyInput.value = String(team.energy);
			attackValue.textContent = String(team.attack);
			midfieldValue.textContent = String(team.midfield);
			defenseValue.textContent = String(team.defense);
			energyValue.textContent = String(team.energy);
		}

		function syncTeamFromInputs() {
			team.attack = parseInt(attackInput.value, 10);
			team.midfield = parseInt(midfieldInput.value, 10);
			team.defense = parseInt(defenseInput.value, 10);
			team.energy = parseInt(energyInput.value, 10);
			updateInputsFromTeam();
		}

		function renderTopPanels() {
			const lastBlue = lastStats ? lastStats.blueGoals : 0;
			const lastRed = lastStats ? lastStats.redGoals : 0;
			scoreBlue.textContent = String(lastBlue);
			scoreRed.textContent = String(lastRed);
			winsValue.textContent = String(team.wins);
			coinsValue.textContent = String(team.coins);
			ratingValue.textContent = String(getTeamOverall());
			budgetValue.textContent = '$' + team.budget + 'm';
			reputationValue.textContent = String(team.reputation);
			weekValue.textContent = String(season.week) + '/' + String(season.totalWeeks);
			divisionValue.textContent = 'Div ' + String(team.division);
			seasonPointsValue.textContent = String(team.points);
			sponsorValue.textContent = '$' + String(team.sponsor) + 'm';
			homeAwayValue.textContent = season.home ? 'Home' : 'Away';
			weatherValue.textContent = season.weather;
			setButtonGroup(formationButtons, team.formation, 'data-formation');
			setButtonGroup(mentalityButtons, team.mentality, 'data-mentality');
			setButtonGroup(styleButtons, team.style, 'data-style');
			setButtonGroup(widthButtons, team.width, 'data-width');
			setButtonGroup(pressButtons, team.press, 'data-press');
			setButtonGroup(markingButtons, team.marking, 'data-marking');
		}

		function clearPlayers() {
			playerNodes.forEach(function (node) {
				node.remove();
			});
			playerNodes = [];
		}

		function addPlayer(x, y, label, teamSide) {
			const node = document.createElement('div');
			node.className = 'zo-mm-player zo-mm-player--' + teamSide;
			node.style.left = x + '%';
			node.style.top = y + '%';
			node.textContent = label;
			field.appendChild(node);
			playerNodes.push(node);
		}

		function renderFormation() {
			clearPlayers();
			blueFormationMap[team.formation].forEach(function (player) {
				addPlayer(player.x, player.y, player.t, 'blue');
			});
			opponentFormation.forEach(function (player) {
				addPlayer(player.x, player.y, player.t, 'red');
			});
		}

		function getSquadAverageByPos(pos) {
			const available = team.squad.filter(function (player) {
				return player.pos === pos && !player.injured && !player.suspended;
			});
			if (!available.length) {
				return 45;
			}
			const total = available.reduce(function (sum, player) {
				return sum + player.ovr + (player.morale - 50) * 0.10 + (player.energy - 50) * 0.08;
			}, 0);
			return total / available.length;
		}

		function getTeamOverall() {
			const gk = getSquadAverageByPos('GK');
			const d = getSquadAverageByPos('D');
			const m = getSquadAverageByPos('M');
			const f = getSquadAverageByPos('F');
			return Math.round((gk * 0.12) + (d * 0.28) + (m * 0.30) + (f * 0.30) + (team.trainingLevel * 1.5));
		}

		function getFormationBonus() {
			if (team.formation === '4-3-3') {
				return { attack: 8, midfield: 2, defense: -2 };
			}
			if (team.formation === '5-3-2') {
				return { attack: -1, midfield: 1, defense: 9 };
			}
			return { attack: 3, midfield: 3, defense: 3 };
		}

		function getTacticBonus() {
			let attack = 0;
			let midfield = 0;
			let defense = 0;

			if (team.mentality === 'attacking') {
				attack += 8;
				defense -= 3;
			}
			if (team.mentality === 'defensive') {
				defense += 8;
				attack -= 3;
			}

			if (team.style === 'short') {
				midfield += 6;
			}
			if (team.style === 'long') {
				attack += 5;
				midfield -= 2;
			}
			if (team.style === 'counter') {
				attack += 6;
				defense += 2;
			}

			if (team.width === 'wide') {
				attack += 3;
			}
			if (team.width === 'narrow') {
				midfield += 3;
			}

			if (team.press === 'high') {
				attack += 4;
				energy -= 0;
				defense += 1;
			}
			if (team.press === 'low') {
				defense += 4;
			}

			if (team.marking === 'man') {
				defense += 3;
			}
			if (team.marking === 'zonal') {
				midfield += 2;
			}

			return { attack: attack, midfield: midfield, defense: defense };
		}

		function chooseOpponentName() {
			const names = season.teams.map(function (t) { return t.name; }).filter(function (name) {
				return name !== team.name;
			});
			return pick(names);
		}

		function chooseWeather() {
			return pick(['Clear', 'Rain', 'Windy', 'Hot', 'Cold']);
		}

		function getWeatherModifiers(weather) {
			if (weather === 'Rain') {
				return { attack: -2, midfield: -1, defense: 2 };
			}
			if (weather === 'Windy') {
				return { attack: -1, midfield: -2, defense: 1 };
			}
			if (weather === 'Hot') {
				return { attack: -1, midfield: -1, defense: -1 };
			}
			if (weather === 'Cold') {
				return { attack: 0, midfield: 1, defense: 1 };
			}
			return { attack: 0, midfield: 0, defense: 0 };
		}

		function renderCommentary(lines) {
			commentaryLog.innerHTML = '';
			lines.forEach(function (line) {
				const div = document.createElement('div');
				div.className = 'zo-mm-line';
				div.textContent = line;
				commentaryLog.appendChild(div);
			});
		}

		function renderResults() {
			resultsLog.innerHTML = '';
			season.results.slice().reverse().forEach(function (line) {
				const div = document.createElement('div');
				div.className = 'zo-mm-line';
				div.textContent = line;
				resultsLog.appendChild(div);
			});
		}

		function sortTable() {
			season.teams.sort(function (a, b) {
				const gdA = a.gf - a.ga;
				const gdB = b.gf - b.ga;
				if (b.pts !== a.pts) return b.pts - a.pts;
				if (gdB !== gdA) return gdB - gdA;
				if (b.gf !== a.gf) return b.gf - a.gf;
				return a.name.localeCompare(b.name);
			});
		}

		function appendCell(row, value) {
			const cell = document.createElement('td');
			cell.textContent = String(value);
			row.appendChild(cell);
		}

		function appendDiv(parent, value) {
			const div = document.createElement('div');
			div.textContent = String(value);
			parent.appendChild(div);
			return div;
		}

		function appendTag(parent, text, className) {
			const tag = document.createElement('span');
			tag.className = className || 'zo-mm-tag';
			tag.textContent = text;
			parent.appendChild(tag);
		}

		function renderLeagueTable() {
			sortTable();
			tableBody.innerHTML = '';
			season.teams.forEach(function (club, index) {
				const tr = document.createElement('tr');
				[index + 1, club.name, club.pts, club.w, club.d, club.l, club.gf, club.ga].forEach(function (value) {
					appendCell(tr, value);
				});
				tableBody.appendChild(tr);
			});
		}

		function renderFinance() {
			financeBody.innerHTML = '';
			financeLog.forEach(function (item) {
				const tr = document.createElement('tr');
				appendCell(tr, item.type);
				appendCell(tr, item.amount >= 0 ? '+$' + item.amount + 'm' : '-$' + Math.abs(item.amount) + 'm');
				appendCell(tr, item.note);
				financeBody.appendChild(tr);
			});
		}

		function renderMarket() {
			marketBody.innerHTML = '';
			market.forEach(function (player) {
				const row = document.createElement('div');
				row.className = 'zo-mm-market-player';

				const info = document.createElement('div');
				const name = document.createElement('strong');
				name.textContent = player.name;
				const role = document.createElement('div');
				role.className = 'zo-mm-note';
				role.textContent = player.role;
				info.appendChild(name);
				info.appendChild(role);

				const actionWrap = document.createElement('div');
				const buyButton = document.createElement('button');
				buyButton.type = 'button';
				buyButton.className = 'zo-mm-btn zo-mm-buy-player';
				buyButton.dataset.id = player.id;
				buyButton.disabled = team.budget < player.price;
				buyButton.textContent = 'Buy';
				actionWrap.appendChild(buyButton);

				row.appendChild(info);
				appendDiv(row, player.pos);
				appendDiv(row, player.ovr);
				appendDiv(row, '$' + player.price + 'm');
				appendDiv(row, '$' + player.wage + 'm');
				row.appendChild(actionWrap);
				marketBody.appendChild(row);
			});

			marketBody.querySelectorAll('.zo-mm-buy-player').forEach(function (button) {
				button.addEventListener('click', function () {
					const id = button.getAttribute('data-id');
					const player = market.find(function (p) { return p.id === id; });
					if (!player || team.budget < player.price) {
						return;
					}
					team.budget -= player.price;
					team.squad.push(player);
					market = market.filter(function (p) { return p.id !== id; });
					addFinance('Expense', -player.price, 'Bought ' + player.name);
					statusText.textContent = player.name + ' joined your squad.';
					renderAll();
				});
			});
		}

		function getCaptain() {
			return team.squad.find(function (p) { return p.id === team.captainId; }) || team.squad[0] || null;
		}

		function renderSquad() {
			squadBody.innerHTML = '';
			team.squad.forEach(function (player) {
				const row = document.createElement('div');
				row.className = 'zo-mm-squad-player';

				const info = document.createElement('div');
				const name = document.createElement('strong');
				name.textContent = player.name;
				const note = document.createElement('div');
				note.className = 'zo-mm-note';
				if (player.id === team.captainId) {
					appendTag(note, 'Captain');
				}
				if (player.injured) {
					appendTag(note, 'Injured', 'zo-mm-tag zo-mm-tag--bad');
				}
				if (player.suspended) {
					appendTag(note, 'Suspended', 'zo-mm-tag zo-mm-tag--bad');
				}
				if (player.morale >= 75) {
					appendTag(note, 'Happy', 'zo-mm-tag zo-mm-tag--good');
				} else if (player.morale <= 52) {
					appendTag(note, 'Low morale', 'zo-mm-tag zo-mm-tag--bad');
				}
				info.appendChild(name);
				info.appendChild(note);

				const actionWrap = document.createElement('div');
				const captainButton = document.createElement('button');
				captainButton.type = 'button';
				captainButton.className = 'zo-mm-btn zo-mm-captain';
				captainButton.dataset.id = player.id;
				captainButton.textContent = 'Captain';
				const sellButton = document.createElement('button');
				sellButton.type = 'button';
				sellButton.className = 'zo-mm-btn zo-mm-sell';
				sellButton.dataset.id = player.id;
				sellButton.textContent = 'Sell';
				actionWrap.appendChild(captainButton);
				actionWrap.appendChild(document.createTextNode(' '));
				actionWrap.appendChild(sellButton);

				row.appendChild(info);
				appendDiv(row, player.pos);
				appendDiv(row, player.ovr);
				appendDiv(row, 'M ' + player.morale);
				appendDiv(row, 'E ' + player.energy);
				row.appendChild(actionWrap);
				squadBody.appendChild(row);
			});

			squadBody.querySelectorAll('.zo-mm-captain').forEach(function (button) {
				button.addEventListener('click', function () {
					team.captainId = button.getAttribute('data-id');
					statusText.textContent = 'Captain changed.';
					renderSquad();
				});
			});

			squadBody.querySelectorAll('.zo-mm-sell').forEach(function (button) {
				button.addEventListener('click', function () {
					const id = button.getAttribute('data-id');
					if (team.squad.length <= 11) {
						statusText.textContent = 'You need enough players before selling.';
						return;
					}
					const player = team.squad.find(function (p) { return p.id === id; });
					if (!player) {
						return;
					}
					const value = Math.max(3, Math.round(player.price * 0.7));
					team.budget += value;
					team.squad = team.squad.filter(function (p) { return p.id !== id; });
					if (team.captainId === id && team.squad.length) {
						team.captainId = team.squad[0].id;
					}
					addFinance('Income', value, 'Sold ' + player.name);
					statusText.textContent = player.name + ' was sold.';
					renderAll();
				});
			});
		}

		function applySeasonResult(teamName, gf, ga) {
			const club = season.teams.find(function (t) { return t.name === teamName; });
			if (!club) {
				return;
			}
			club.gf += gf;
			club.ga += ga;
			if (gf > ga) {
				club.w += 1;
				club.pts += 3;
			} else if (gf < ga) {
				club.l += 1;
			} else {
				club.d += 1;
				club.pts += 1;
			}
		}

		function maybeInjureOrSuspend(matchCommentary) {
			const active = team.squad.filter(function (p) { return !p.injured && !p.suspended; });
			if (active.length && Math.random() < 0.12) {
				const player = pick(active);
				player.injured = true;
				matchCommentary.push('74\' - Injury concern: ' + player.name + ' will miss the next match.');
			}
			if (active.length && Math.random() < 0.10) {
				const player = pick(active);
				player.suspended = true;
				matchCommentary.push('81\' - Red card risk confirmed. ' + player.name + ' is suspended for the next match.');
			}
		}

		function ageSquadAfterMatch() {
			team.squad.forEach(function (player) {
				player.energy = clamp(player.energy - randInt(4, 10) + team.trainingLevel, 35, 99);
				player.morale = clamp(player.morale + randInt(-4, 4), 35, 99);
			});
		}

		function healAndRecoverForNextWeek() {
			team.squad.forEach(function (player) {
				player.energy = clamp(player.energy + randInt(5, 12) + team.trainingLevel, 35, 99);
				if (player.injured && Math.random() < 0.55) {
					player.injured = false;
				}
				if (player.suspended) {
					player.suspended = false;
				}
			});
		}

		function makeMinuteCommentary(opponentName, stats) {
			const lines = [];
			const captain = getCaptain();
			lines.push('Kickoff - ' + team.name + ' vs ' + opponentName + '.');
			lines.push('5\' - ' + (season.home ? 'Home crowd' : 'Away support') + ' reacts to the opening exchanges.');
			if (stats.possession > 53) {
				lines.push('12\' - Your team controls possession through the middle.');
			} else {
				lines.push('12\' - ' + opponentName + ' begins with more of the ball.');
			}
			if (team.style === 'counter') {
				lines.push('21\' - Fast counterattack nearly opens the scoring.');
			}
			if (team.press === 'high') {
				lines.push('29\' - High pressing forces a dangerous turnover.');
			}
			lines.push('45\' - Halftime score: ' + stats.halfBlue + '-' + stats.halfRed + '.');
			if (team.width === 'wide') {
				lines.push('57\' - Wide play stretches the defense and creates crossing space.');
			}
			if (stats.corners >= 4) {
				lines.push('63\' - Set pieces are becoming important in this match.');
			}
			if (captain) {
				lines.push('70\' - ' + captain.name + ' tries to lift the team as captain.');
			}
			lines.push('90\' - Full time: ' + stats.blueGoals + '-' + stats.redGoals + '.');
			return lines;
		}

		function simulateMatch() {
			syncTeamFromInputs();
			const opponentName = chooseOpponentName();
			season.weather = chooseWeather();
			const formBonus = getFormationBonus();
			const tacticBonus = getTacticBonus();
			const weatherBonus = getWeatherModifiers(season.weather);
			const squadAttack = getSquadAverageByPos('F');
			const squadMid = getSquadAverageByPos('M');
			const squadDef = getSquadAverageByPos('D');
			const squadGk = getSquadAverageByPos('GK');
			const homeBonus = season.home ? 4 : -2;
			const reputationBonus = team.reputation * 1.2;
			const scoutBonus = team.scoutLevel * 1.2;
			const stadiumBonus = season.home ? team.stadiumLevel * 1.3 : 0;

			const blueAttack = team.attack + formBonus.attack + tacticBonus.attack + weatherBonus.attack + (squadAttack - 55) * 0.55 + homeBonus + reputationBonus;
			const blueMid = team.midfield + formBonus.midfield + tacticBonus.midfield + weatherBonus.midfield + (squadMid - 55) * 0.55 + scoutBonus;
			const blueDef = team.defense + formBonus.defense + tacticBonus.defense + weatherBonus.defense + (squadDef - 55) * 0.55 + (squadGk - 55) * 0.18 + stadiumBonus;

			const opponentBase = 54 + (season.week * 0.9) + ((team.division - 1) * 4.5);
			const redAttack = opponentBase + rand(-6, 9);
			const redMid = opponentBase + rand(-6, 9);
			const redDef = opponentBase + rand(-6, 9);

			const possession = clamp(Math.round(50 + (blueMid - redMid) * 0.55 + rand(-7, 7)), 31, 69);
			const blueShots = clamp(Math.round(5 + (blueAttack - redDef) * 0.12 + possession * 0.08 + rand(-2, 3)), 2, 18);
			const redShots = clamp(Math.round(5 + (redAttack - blueDef) * 0.12 + (100 - possession) * 0.08 + rand(-2, 3)), 2, 18);
			const blueOnTarget = clamp(Math.round(blueShots * (0.34 + (team.attack + team.trainingLevel) / 260)), 1, blueShots);
			const redOnTarget = clamp(Math.round(redShots * (0.32 + opponentBase / 260)), 1, redShots);
			const blueCorners = clamp(Math.round(blueShots * 0.35 + rand(0, 2)), 0, 9);
			const redCorners = clamp(Math.round(redShots * 0.35 + rand(0, 2)), 0, 9);
			const blueFouls = clamp(Math.round(8 + rand(-3, 4) + (team.press === 'high' ? 2 : 0)), 4, 18);
			const redFouls = clamp(Math.round(8 + rand(-3, 4)), 4, 18);
			const blueCards = clamp(Math.round(blueFouls / 6 + rand(-1, 1)), 0, 4);
			const redCards = clamp(Math.round(redFouls / 6 + rand(-1, 1)), 0, 4);

			let blueGoals = clamp(Math.round(blueOnTarget * (0.19 + (team.attack + squadAttack - 100) / 420) + rand(-1, 1)), 0, 6);
			let redGoals = clamp(Math.round(redOnTarget * (0.18 + (redAttack - blueDef) / 430) + rand(-1, 1)), 0, 6);

			const halfBlue = Math.min(blueGoals, Math.round(blueGoals * rand(0.3, 0.7)));
			const halfRed = Math.min(redGoals, Math.round(redGoals * rand(0.3, 0.7)));
			const cleanSheet = redGoals === 0 ? 'Yes' : 'No';
			const momentum = blueGoals > redGoals ? 'Blue Town' : (blueGoals < redGoals ? opponentName : 'Balanced');

			const commentary = makeMinuteCommentary(opponentName, {
				possession: possession,
				blueGoals: blueGoals,
				redGoals: redGoals,
				halfBlue: halfBlue,
				halfRed: halfRed,
				corners: blueCorners
			});

			maybeInjureOrSuspend(commentary);
			ageSquadAfterMatch();

			const resultLine = 'Week ' + season.week + ': ' + team.name + ' ' + blueGoals + '-' + redGoals + ' ' + opponentName;
			season.results.push(resultLine);
			season.results = season.results.slice(-20);

			applySeasonResult(team.name, blueGoals, redGoals);
			applySeasonResult(opponentName, redGoals, blueGoals);

			if (blueGoals > redGoals) {
				team.wins += 1;
				team.points += 3;
				team.coins += 12 + team.stadiumLevel;
				team.budget += 6 + team.sponsor;
				team.reputation = clamp(team.reputation + 1, 1, 99);
				statusText.textContent = 'You win the match.';
				addFinance('Income', 6 + team.sponsor, 'Match win and sponsor bonus');
			} else if (blueGoals < redGoals) {
				team.coins += 4;
				team.budget += 2 + Math.floor(team.sponsor / 2);
				team.reputation = clamp(team.reputation - 1, 1, 99);
				statusText.textContent = 'You lose the match.';
				addFinance('Income', 2 + Math.floor(team.sponsor / 2), 'Participation and sponsor payout');
			} else {
				team.points += 1;
				team.coins += 7;
				team.budget += 4 + Math.floor(team.sponsor * 0.7);
				team.reputation = clamp(team.reputation + 0, 1, 99);
				statusText.textContent = 'The match ends in a draw.';
				addFinance('Income', 4 + Math.floor(team.sponsor * 0.7), 'Draw and sponsor payout');
			}

			const wageBill = team.squad.reduce(function (sum, player) { return sum + player.wage; }, 0);
			team.budget = Math.max(0, team.budget - wageBill);
			addFinance('Expense', -wageBill, 'Weekly wages');

			quickSummary.textContent = resultLine;
			lastStats = {
				blueGoals: blueGoals,
				redGoals: redGoals,
				possession: possession + '%',
				shots: blueShots + ' - ' + redShots,
				onTarget: blueOnTarget + ' - ' + redOnTarget,
				corners: blueCorners + ' - ' + redCorners,
				cards: blueCards + ' - ' + redCards,
				fouls: blueFouls + ' - ' + redFouls,
				momentum: momentum,
				cleanSheet: cleanSheet
			};

			statPossession.textContent = lastStats.possession;
			statShots.textContent = lastStats.shots;
			statOnTarget.textContent = lastStats.onTarget;
			statCorners.textContent = lastStats.corners;
			statCards.textContent = lastStats.cards;
			statFouls.textContent = lastStats.fouls;
			statMomentum.textContent = lastStats.momentum;
			statClean.textContent = lastStats.cleanSheet;

			renderCommentary(commentary);
			renderResults();
			renderLeagueTable();
			renderFinance();
			renderSquad();
			renderTopPanels();
		}

		function nextWeek() {
			if (season.week >= season.totalWeeks) {
				finishSeason();
				return;
			}
			season.week += 1;
			season.home = !season.home;
			season.weather = chooseWeather();
			healAndRecoverForNextWeek();
			statusText.textContent = 'Week ' + season.week + ' is ready.';
			renderAll();
		}

		function finishSeason() {
			sortTable();
			const index = season.teams.findIndex(function (club) { return club.name === team.name; });
			let message = 'Season finished.';
			if (index === 0) {
				team.division += 1;
				team.budget += 20;
				team.coins += 30;
				message = 'You won the league and earned promotion.';
				addFinance('Income', 20, 'Promotion prize money');
			} else if (index <= 2) {
				team.budget += 10;
				team.coins += 18;
				message = 'Strong season finish.';
				addFinance('Income', 10, 'League position bonus');
			} else if (index >= season.teams.length - 2 && team.division > 1) {
				team.division -= 1;
				message = 'Relegation. Rebuild and try again.';
			}
			statusText.textContent = message;
			season.week = season.totalWeeks;
			renderAll();
		}

		function resetSeason() {
			const currentDivision = team.division;
			const currentBudget = team.budget;
			const currentCoins = team.coins;
			const currentRep = team.reputation;
			const currentWins = team.wins;
			const currentSquad = team.squad;
			const currentCaptain = team.captainId;
			const currentStaff = {
				scoutLevel: team.scoutLevel,
				trainingLevel: team.trainingLevel,
				stadiumLevel: team.stadiumLevel,
				youthLevel: team.youthLevel,
				sponsor: team.sponsor
			};

			initState();
			team.division = currentDivision;
			team.budget = currentBudget;
			team.coins = currentCoins;
			team.reputation = currentRep;
			team.wins = currentWins;
			team.squad = currentSquad;
			team.captainId = currentCaptain;
			team.scoutLevel = currentStaff.scoutLevel;
			team.trainingLevel = currentStaff.trainingLevel;
			team.stadiumLevel = currentStaff.stadiumLevel;
			team.youthLevel = currentStaff.youthLevel;
			team.sponsor = currentStaff.sponsor;
			statusText.textContent = 'New season started.';
			renderAll();
		}

		function buyUpgrade(type) {
			if (type === 'scout') {
				const cost = 8 + (team.scoutLevel * 6);
				if (team.coins < cost) return;
				team.coins -= cost;
				team.scoutLevel += 1;
				market = market.concat(makeMarketPool().slice(0, 3).map(function (p) {
					p.ovr = clamp(p.ovr + team.scoutLevel * 2, 50, 85);
					p.price = Math.max(6, Math.round(p.ovr / 3));
					return p;
				}));
				statusText.textContent = 'Scout network improved.';
				return;
			}
			if (type === 'training') {
				const cost = 10 + (team.trainingLevel * 7);
				if (team.coins < cost) return;
				team.coins -= cost;
				team.trainingLevel += 1;
				team.squad.forEach(function (player) {
					player.ovr = clamp(player.ovr + 1, 40, 99);
					player.energy = clamp(player.energy + 4, 35, 99);
				});
				statusText.textContent = 'Training improved the squad.';
				return;
			}
			if (type === 'stadium') {
				const cost = 12 + (team.stadiumLevel * 8);
				if (team.coins < cost) return;
				team.coins -= cost;
				team.stadiumLevel += 1;
				team.sponsor += 2;
				statusText.textContent = 'Stadium upgraded. Better home income.';
				return;
			}
		}

		function healAll() {
			const cost = 8;
			if (team.coins < cost) {
				return;
			}
			team.coins -= cost;
			team.squad.forEach(function (player) {
				player.energy = clamp(player.energy + 18, 35, 99);
				player.injured = false;
				player.suspended = false;
			});
			statusText.textContent = 'Medical staff refreshed the squad.';
			renderAll();
		}

		function addYouthPlayer() {
			const cost = 10 + (team.youthLevel * 3);
			if (team.coins < cost) {
				return;
			}
			team.coins -= cost;
			team.youthLevel += 1;
			const positions = ['D', 'M', 'F'];
			const player = makePlayer('Youth Prospect ' + String(team.youthLevel), pick(positions), randInt(56, 70 + team.youthLevel), randInt(8, 18));
			team.squad.push(player);
			statusText.textContent = player.name + ' joined from the academy.';
			renderAll();
		}

		function renderAll() {
			updateInputsFromTeam();
			renderTopPanels();
			renderFormation();
			renderLeagueTable();
			renderCommentary(lastStats ? [quickSummary.textContent].concat(Array.from(commentaryLog.children).map(function (n) { return n.textContent; }).slice(0, 8)) : ['No match simulated yet.']);
			renderResults();
			renderMarket();
			renderSquad();
			renderFinance();
			buyScoutBtn.textContent = 'Scout Upgrade (' + (8 + team.scoutLevel * 6) + ' coins)';
			buyTrainingBtn.textContent = 'Training Upgrade (' + (10 + team.trainingLevel * 7) + ' coins)';
			buyStadiumBtn.textContent = 'Stadium Upgrade (' + (12 + team.stadiumLevel * 8) + ' coins)';
			healAllBtn.textContent = 'Recover Squad (8 coins)';
			youthBtn.textContent = 'Youth Academy (' + (10 + team.youthLevel * 3) + ' coins)';
		}

		formationButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				team.formation = button.getAttribute('data-formation');
				renderAll();
			});
		});

		mentalityButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				team.mentality = button.getAttribute('data-mentality');
				renderAll();
			});
		});

		styleButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				team.style = button.getAttribute('data-style');
				renderAll();
			});
		});

		widthButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				team.width = button.getAttribute('data-width');
				renderAll();
			});
		});

		pressButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				team.press = button.getAttribute('data-press');
				renderAll();
			});
		});

		markingButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				team.marking = button.getAttribute('data-marking');
				renderAll();
			});
		});

		[attackInput, midfieldInput, defenseInput, energyInput].forEach(function (input) {
			input.addEventListener('input', function () {
				syncTeamFromInputs();
				renderTopPanels();
			});
		});

		simulateBtn.addEventListener('click', function () {
			simulateMatch();
		});

		nextMatchBtn.addEventListener('click', function () {
			nextWeek();
		});

		resetSeasonBtn.addEventListener('click', function () {
			resetSeason();
		});

		buyScoutBtn.addEventListener('click', function () {
			buyUpgrade('scout');
			renderAll();
		});

		buyTrainingBtn.addEventListener('click', function () {
			buyUpgrade('training');
			renderAll();
		});

		buyStadiumBtn.addEventListener('click', function () {
			buyUpgrade('stadium');
			renderAll();
		});

		healAllBtn.addEventListener('click', function () {
			healAll();
		});

		youthBtn.addEventListener('click', function () {
			addYouthPlayer();
		});

		initState();
		updateInputsFromTeam();
		quickSummary.textContent = 'No match played yet.';
		statPossession.textContent = '-';
		statShots.textContent = '-';
		statOnTarget.textContent = '-';
		statCorners.textContent = '-';
		statCards.textContent = '-';
		statFouls.textContent = '-';
		statMomentum.textContent = '-';
		statClean.textContent = '-';
		renderCommentary(['No match simulated yet.']);
		renderAll();
	});
});
JS;

if (!function_exists('zo_game_mini_manager_pro_render')) {
	function zo_game_mini_manager_pro_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mini-manager-pro-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mini-manager-pro" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-mm-wrap">
				<div class="zo-mm-topbar">
					<div class="zo-mm-panel"><strong class="zo-mm-score-blue">0</strong><span>Your Goals</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-score-red">0</strong><span>Enemy Goals</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-wins">0</strong><span>Wins</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-coins">0</strong><span>Coins</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-rating">60</strong><span>Team Rating</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-budget">$60m</strong><span>Budget</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-reputation">1</strong><span>Reputation</span></div>
				</div>

				<div class="zo-mm-subbar">
					<div class="zo-mm-panel"><strong class="zo-mm-week">1/14</strong><span>Week</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-division">Div 1</strong><span>League</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-season-points">0</strong><span>Season Points</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-sponsor">$10m</strong><span>Sponsor</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-homeaway">Home</strong><span>Match Type</span></div>
					<div class="zo-mm-panel"><strong class="zo-mm-weather">Clear</strong><span>Weather</span></div>
				</div>

				<div class="zo-mm-layout">
					<div class="zo-mm-left">
						<div class="zo-mm-grid-2">
							<div class="zo-mm-card">
								<h3>Formation</h3>
								<div class="zo-mm-pill-row">
									<button type="button" class="zo-mm-pill zo-mm-formation is-active" data-formation="4-4-2">4-4-2</button>
									<button type="button" class="zo-mm-pill zo-mm-formation" data-formation="4-3-3">4-3-3</button>
									<button type="button" class="zo-mm-pill zo-mm-formation" data-formation="5-3-2">5-3-2</button>
								</div>
								<div class="zo-mm-note">Choose your shape for the season and each match.</div>
							</div>

							<div class="zo-mm-card">
								<h3>Mentality</h3>
								<div class="zo-mm-pill-row">
									<button type="button" class="zo-mm-pill zo-mm-mentality is-active" data-mentality="balanced">Balanced</button>
									<button type="button" class="zo-mm-pill zo-mm-mentality" data-mentality="attacking">Attacking</button>
									<button type="button" class="zo-mm-pill zo-mm-mentality" data-mentality="defensive">Defensive</button>
								</div>
							</div>
						</div>

						<div class="zo-mm-grid-2">
							<div class="zo-mm-card">
								<h3>Style</h3>
								<div class="zo-mm-pill-row">
									<button type="button" class="zo-mm-pill zo-mm-style is-active" data-style="short">Short Pass</button>
									<button type="button" class="zo-mm-pill zo-mm-style" data-style="long">Long Ball</button>
									<button type="button" class="zo-mm-pill zo-mm-style" data-style="counter">Counter</button>
								</div>
							</div>

							<div class="zo-mm-card">
								<h3>Width</h3>
								<div class="zo-mm-pill-row">
									<button type="button" class="zo-mm-pill zo-mm-width is-active" data-width="balanced">Balanced</button>
									<button type="button" class="zo-mm-pill zo-mm-width" data-width="wide">Wide</button>
									<button type="button" class="zo-mm-pill zo-mm-width" data-width="narrow">Narrow</button>
								</div>
							</div>
						</div>

						<div class="zo-mm-grid-2">
							<div class="zo-mm-card">
								<h3>Press</h3>
								<div class="zo-mm-pill-row">
									<button type="button" class="zo-mm-pill zo-mm-press" data-press="low">Low</button>
									<button type="button" class="zo-mm-pill zo-mm-press is-active" data-press="medium">Medium</button>
									<button type="button" class="zo-mm-pill zo-mm-press" data-press="high">High</button>
								</div>
							</div>

							<div class="zo-mm-card">
								<h3>Marking</h3>
								<div class="zo-mm-pill-row">
									<button type="button" class="zo-mm-pill zo-mm-marking is-active" data-marking="zonal">Zonal</button>
									<button type="button" class="zo-mm-pill zo-mm-marking" data-marking="man">Man</button>
								</div>
							</div>
						</div>

						<div class="zo-mm-card">
							<h3>Tactics Sliders</h3>
							<div class="zo-mm-row">
								<label for="<?php echo esc_attr($instance_id); ?>-attack">Attack</label>
								<input id="<?php echo esc_attr($instance_id); ?>-attack" class="zo-mm-attack" type="range" min="30" max="99" value="60">
								<div class="zo-mm-value zo-mm-attack-value">60</div>
							</div>
							<div class="zo-mm-row">
								<label for="<?php echo esc_attr($instance_id); ?>-midfield">Midfield</label>
								<input id="<?php echo esc_attr($instance_id); ?>-midfield" class="zo-mm-midfield" type="range" min="30" max="99" value="60">
								<div class="zo-mm-value zo-mm-midfield-value">60</div>
							</div>
							<div class="zo-mm-row">
								<label for="<?php echo esc_attr($instance_id); ?>-defense">Defense</label>
								<input id="<?php echo esc_attr($instance_id); ?>-defense" class="zo-mm-defense" type="range" min="30" max="99" value="60">
								<div class="zo-mm-value zo-mm-defense-value">60</div>
							</div>
							<div class="zo-mm-row">
								<label for="<?php echo esc_attr($instance_id); ?>-energy">Energy</label>
								<input id="<?php echo esc_attr($instance_id); ?>-energy" class="zo-mm-energy" type="range" min="30" max="99" value="60">
								<div class="zo-mm-value zo-mm-energy-value">60</div>
							</div>
						</div>

						<div class="zo-mm-field-wrap">
							<div class="zo-mm-field">
								<div class="zo-mm-line-mid"></div>
								<div class="zo-mm-circle"></div>
								<div class="zo-mm-dot"></div>
								<div class="zo-mm-box-left"></div>
								<div class="zo-mm-box-right"></div>
								<div class="zo-mm-goal-left"></div>
								<div class="zo-mm-goal-right"></div>
							</div>
						</div>
					</div>

					<div class="zo-mm-right">
						<div class="zo-mm-status">
							<h3>Match Status</h3>
							<div class="zo-mm-status-text">Set your tactics and simulate a match.</div>
							<div class="zo-mm-note zo-mm-quick-summary">No match played yet.</div>
						</div>

						<div class="zo-mm-action-row">
							<button type="button" class="zo-mm-btn zo-mm-simulate">Simulate Match</button>
							<button type="button" class="zo-mm-btn zo-mm-next-match">Next Week</button>
							<button type="button" class="zo-mm-btn zo-mm-reset-season">New Season</button>
						</div>

						<div class="zo-mm-finance">
							<h3>Staff and Club Upgrades</h3>
							<div class="zo-mm-market-actions">
								<button type="button" class="zo-mm-btn zo-mm-buy-scout">Scout Upgrade</button>
								<button type="button" class="zo-mm-btn zo-mm-buy-training">Training Upgrade</button>
								<button type="button" class="zo-mm-btn zo-mm-buy-stadium">Stadium Upgrade</button>
								<button type="button" class="zo-mm-btn zo-mm-heal-all">Recover Squad</button>
								<button type="button" class="zo-mm-btn zo-mm-youth">Youth Academy</button>
							</div>
							<div class="zo-mm-scroll">
								<table class="zo-mm-tables">
									<thead>
										<tr><th>Type</th><th>Amount</th><th>Note</th></tr>
									</thead>
									<tbody class="zo-mm-finance-body"></tbody>
								</table>
							</div>
						</div>

						<div class="zo-mm-status">
							<h3>Match Stats</h3>
							<div class="zo-mm-kpi-grid">
								<div class="zo-mm-kpi"><strong class="zo-mm-stat-possession">-</strong><span>Possession</span></div>
								<div class="zo-mm-kpi"><strong class="zo-mm-stat-shots">-</strong><span>Shots</span></div>
								<div class="zo-mm-kpi"><strong class="zo-mm-stat-ontarget">-</strong><span>On Target</span></div>
								<div class="zo-mm-kpi"><strong class="zo-mm-stat-corners">-</strong><span>Corners</span></div>
								<div class="zo-mm-kpi"><strong class="zo-mm-stat-cards">-</strong><span>Cards</span></div>
								<div class="zo-mm-kpi"><strong class="zo-mm-stat-fouls">-</strong><span>Fouls</span></div>
								<div class="zo-mm-kpi"><strong class="zo-mm-stat-momentum">-</strong><span>Momentum</span></div>
								<div class="zo-mm-kpi"><strong class="zo-mm-stat-clean">-</strong><span>Clean Sheet</span></div>
							</div>
						</div>
					</div>
				</div>

				<div class="zo-mm-grid-2">
					<div class="zo-mm-table-card">
						<h3>League Table</h3>
						<div class="zo-mm-scroll">
							<table class="zo-mm-tables">
								<thead>
									<tr><th>#</th><th>Club</th><th>Pts</th><th>W</th><th>D</th><th>L</th><th>GF</th><th>GA</th></tr>
								</thead>
								<tbody class="zo-mm-league-body"></tbody>
							</table>
						</div>
					</div>

					<div class="zo-mm-results">
						<h3>Recent Results</h3>
						<div class="zo-mm-results-log"></div>
					</div>
				</div>

				<div class="zo-mm-grid-2">
					<div class="zo-mm-market">
						<h3>Transfer Market</h3>
						<div class="zo-mm-scroll">
							<div class="zo-mm-market-body"></div>
						</div>
					</div>

					<div class="zo-mm-squad">
						<h3>Your Squad</h3>
						<div class="zo-mm-scroll">
							<div class="zo-mm-squad-body"></div>
						</div>
					</div>
				</div>

				<div class="zo-mm-commentary">
					<h3>Minute Commentary</h3>
					<div class="zo-mm-commentary-log"></div>
				</div>

				<div class="zo-mm-help">
					<h3>How to Play</h3>
					You manage the club. Pick a formation. Set mentality, passing style, width, pressing, and marking. Adjust attack, midfield, defense, and energy. Buy players, sell players, choose a captain, grow your staff, handle injuries, and try to win the season table. This version includes a season mode, league table, transfer market, budget, wages, youth academy, weather, home and away effects, morale, suspensions, commentary, and progression.
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
	'description'     => 'A bigger soccer manager game with seasons, transfers, league table, tactics, squad management, finances, and commentary.',
	'render_callback' => 'zo_game_mini_manager_pro_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
