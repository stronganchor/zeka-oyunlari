<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--wit-bases * {
	box-sizing: border-box;
}

.zo-game-root--wit-bases {
	max-width: 1300px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--wit-bases .zo-wb-wrap {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 22px;
	padding: 18px;
	box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.zo-game-root--wit-bases .zo-wb-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 32px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--wit-bases .zo-wb-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--wit-bases .zo-wb-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 16px;
}

.zo-game-root--wit-bases .zo-wb-stats {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--wit-bases .zo-wb-stat {
	background: #f3f6fa;
	border: 1px solid #dbe3ea;
	border-radius: 12px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
}

.zo-game-root--wit-bases .zo-wb-controls {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: center;
}

.zo-game-root--wit-bases .zo-wb-btn,
.zo-game-root--wit-bases .zo-wb-select {
	padding: 10px 14px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	color: #1f2937;
	font: inherit;
	font-size: 15px;
	font-weight: 700;
}

.zo-game-root--wit-bases .zo-wb-btn {
	cursor: pointer;
}

.zo-game-root--wit-bases .zo-wb-btn--primary {
	background: #2563eb;
	border-color: #2563eb;
	color: #ffffff;
}

.zo-game-root--wit-bases .zo-wb-btn--danger {
	background: #ef4444;
	border-color: #ef4444;
	color: #ffffff;
}

.zo-game-root--wit-bases .zo-wb-layout {
	display: grid;
	grid-template-columns: 1fr 330px;
	gap: 16px;
}

.zo-game-root--wit-bases .zo-wb-board-wrap {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 12px;
}

.zo-game-root--wit-bases .zo-wb-canvas {
	display: block;
	width: 100%;
	height: auto;
	background: linear-gradient(180deg, #dbeafe 0%, #dcfce7 100%);
	border: 1px solid #cfd8e3;
	border-radius: 14px;
	cursor: pointer;
}

.zo-game-root--wit-bases .zo-wb-side {
	background: #f8fafc;
	border: 1px solid #dbe3ea;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--wit-bases .zo-wb-side h3 {
	margin: 0 0 10px;
	font-size: 18px;
	color: #0f172a;
}

.zo-game-root--wit-bases .zo-wb-side p,
.zo-game-root--wit-bases .zo-wb-side li {
	font-size: 14px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--wit-bases .zo-wb-side ul {
	margin: 0 0 14px;
	padding-left: 18px;
}

.zo-game-root--wit-bases .zo-wb-unit-grid {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--wit-bases .zo-wb-unit-btn {
	width: 100%;
	text-align: left;
	padding: 10px 12px;
	border-radius: 12px;
	border: 1px solid #cfd8e3;
	background: #ffffff;
	font: inherit;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--wit-bases .zo-wb-unit-btn.is-active {
	background: #eff6ff;
	border-color: #60a5fa;
}

.zo-game-root--wit-bases .zo-wb-message {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 12px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	color: #1d4ed8;
	min-height: 48px;
}

@media (max-width: 960px) {
	.zo-game-root--wit-bases .zo-wb-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 640px) {
	.zo-game-root--wit-bases {
		padding: 10px;
	}

	.zo-game-root--wit-bases .zo-wb-wrap {
		padding: 12px;
	}

	.zo-game-root--wit-bases .zo-wb-title {
		font-size: 26px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--wit-bases');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-wb-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = root.querySelector('.zo-wb-start');
		const restartButton = root.querySelector('.zo-wb-restart');
		const endTurnButton = root.querySelector('.zo-wb-end-turn');

		const turnEl = root.querySelector('.zo-wb-turn');
		const sideEl = root.querySelector('.zo-wb-side-name');
		const witsEl = root.querySelector('.zo-wb-wits');
		const blueBaseEl = root.querySelector('.zo-wb-blue-base');
		const redBaseEl = root.querySelector('.zo-wb-red-base');
		const selectedEl = root.querySelector('.zo-wb-selected');
		const winnerEl = root.querySelector('.zo-wb-winner');
		const messageEl = root.querySelector('.zo-wb-message');

		const unitButtons = root.querySelectorAll('.zo-wb-unit-btn');

		const HEX_SIZE = 32;
		const COLS = 12;
		const ROWS = 8;
		const ORIGIN_X = 90;
		const ORIGIN_Y = 90;

		const unitDefs = {
			scout: {
				key: 'scout',
				name: 'Scout',
				cost: 1,
				hp: 2,
				move: 3,
				damage: 1,
				range: 1,
				emoji: '🏃',
				fill: '#fde68a'
			},
			soldier: {
				key: 'soldier',
				name: 'Soldier',
				cost: 2,
				hp: 3,
				move: 2,
				damage: 1,
				range: 1,
				emoji: '⚔️',
				fill: '#bfdbfe'
			},
			sniper: {
				key: 'sniper',
				name: 'Sniper',
				cost: 3,
				hp: 2,
				move: 1,
				damage: 1,
				range: 3,
				emoji: '🎯',
				fill: '#ddd6fe'
			},
			heavy: {
				key: 'heavy',
				name: 'Heavy',
				cost: 4,
				hp: 5,
				move: 1,
				damage: 2,
				range: 1,
				emoji: '🛡️',
				fill: '#fecaca'
			}
		};

		const state = {
			started: false,
			gameOver: false,
			currentSide: 'blue',
			turnNumber: 1,
			wits: {
				blue: 5,
				red: 5
			},
			baseHp: {
				blue: 5,
				red: 5
			},
			selectedSpawn: 'scout',
			selectedUnitId: null,
			mode: 'spawn',
			winner: '-',
			units: [],
			nextUnitId: 1,
			spawnTiles: {
				blue: [{q: 1, r: 3}, {q: 1, r: 4}],
				red: [{q: 10, r: 3}, {q: 10, r: 4}]
			},
			baseTiles: {
				blue: {q: 0, r: 3},
				red: {q: 11, r: 4}
			},
			witTiles: [
				{q: 4, r: 2, owner: null},
				{q: 7, r: 5, owner: null}
			]
		};

		function setMessage(text) {
			messageEl.textContent = text;
		}

		function axialToPixel(q, r) {
			const x = ORIGIN_X + HEX_SIZE * Math.sqrt(3) * (q + r / 2);
			const y = ORIGIN_Y + HEX_SIZE * 1.5 * r;
			return {x: x, y: y};
		}

		function hexPolygon(x, y, size) {
			const points = [];
			for (let i = 0; i < 6; i++) {
				const angle = Math.PI / 180 * (60 * i - 30);
				points.push({
					x: x + size * Math.cos(angle),
					y: y + size * Math.sin(angle)
				});
			}
			return points;
		}

		function drawHex(x, y, size, fill, stroke, lineWidth) {
			const points = hexPolygon(x, y, size);
			ctx.beginPath();
			ctx.moveTo(points[0].x, points[0].y);
			for (let i = 1; i < points.length; i++) {
				ctx.lineTo(points[i].x, points[i].y);
			}
			ctx.closePath();
			ctx.fillStyle = fill;
			ctx.fill();
			ctx.strokeStyle = stroke;
			ctx.lineWidth = lineWidth;
			ctx.stroke();
		}

		function cubeDistance(aq, ar, bq, br) {
			const ax = aq;
			const az = ar;
			const ay = -ax - az;

			const bx = bq;
			const bz = br;
			const by = -bx - bz;

			return Math.max(Math.abs(ax - bx), Math.abs(ay - by), Math.abs(az - bz));
		}

		function getUnitAt(q, r) {
			for (let i = 0; i < state.units.length; i++) {
				const u = state.units[i];
				if (u.q === q && u.r === r && u.hp > 0) {
					return u;
				}
			}
			return null;
		}

		function getSelectedUnit() {
			if (!state.selectedUnitId) {
				return null;
			}
			for (let i = 0; i < state.units.length; i++) {
				if (state.units[i].id === state.selectedUnitId && state.units[i].hp > 0) {
					return state.units[i];
				}
			}
			return null;
		}

		function isSpawnTile(side, q, r) {
			return state.spawnTiles[side].some(function (tile) {
				return tile.q === q && tile.r === r;
			});
		}

		function isBaseTile(side, q, r) {
			return state.baseTiles[side].q === q && state.baseTiles[side].r === r;
		}

		function getWitTile(q, r) {
			for (let i = 0; i < state.witTiles.length; i++) {
				if (state.witTiles[i].q === q && state.witTiles[i].r === r) {
					return state.witTiles[i];
				}
			}
			return null;
		}

		function updateStats() {
			turnEl.textContent = String(state.turnNumber);
			sideEl.textContent = state.currentSide === 'blue' ? 'Blue' : 'Red';
			witsEl.textContent = String(state.wits[state.currentSide]);
			blueBaseEl.textContent = String(state.baseHp.blue);
			redBaseEl.textContent = String(state.baseHp.red);
			selectedEl.textContent = state.mode === 'spawn'
				? unitDefs[state.selectedSpawn].name
				: (getSelectedUnit() ? getSelectedUnit().name : 'None');
			winnerEl.textContent = state.winner;
		}

		function makeUnit(side, key, q, r) {
			const def = unitDefs[key];
			return {
				id: state.nextUnitId++,
				side: side,
				key: key,
				name: def.name,
				q: q,
				r: r,
				hp: def.hp,
				maxHp: def.hp,
				move: def.move,
				damage: def.damage,
				range: def.range,
				emoji: def.emoji,
				fill: def.fill,
				acted: false,
				moved: false
			};
		}

		function setActiveSpawnButton() {
			unitButtons.forEach(function (btn) {
				btn.classList.toggle('is-active', btn.getAttribute('data-unit') === state.selectedSpawn && state.mode === 'spawn');
			});
		}

		function resetGame() {
			state.started = false;
			state.gameOver = false;
			state.currentSide = 'blue';
			state.turnNumber = 1;
			state.wits.blue = 5;
			state.wits.red = 5;
			state.baseHp.blue = 5;
			state.baseHp.red = 5;
			state.selectedSpawn = 'scout';
			state.selectedUnitId = null;
			state.mode = 'spawn';
			state.winner = '-';
			state.units = [];
			state.nextUnitId = 1;
			state.witTiles = [
				{q: 4, r: 2, owner: null},
				{q: 7, r: 5, owner: null}
			];
			updateStats();
			setActiveSpawnButton();
			setMessage('Press Start. Blue goes first.');
			draw();
		}

		function startGame() {
			state.started = true;
			state.gameOver = false;
			setMessage('Blue turn. Spawn or select a unit.');
			updateStats();
			draw();
		}

		function endTurn() {
			if (!state.started || state.gameOver) {
				return;
			}

			state.selectedUnitId = null;
			state.mode = 'spawn';

			state.currentSide = state.currentSide === 'blue' ? 'red' : 'blue';
			if (state.currentSide === 'blue') {
				state.turnNumber += 1;
			}

			state.units.forEach(function (u) {
				if (u.side === state.currentSide) {
					u.acted = false;
					u.moved = false;
				}
			});

			let bonus = 0;
			state.witTiles.forEach(function (tile) {
				if (tile.owner === state.currentSide) {
					bonus += 1;
				}
			});

			state.wits[state.currentSide] += 5 + bonus;

			updateStats();
			setActiveSpawnButton();
			setMessage((state.currentSide === 'blue' ? 'Blue' : 'Red') + ' turn. You gained 5 + bonus wits.');
			draw();
		}

		function spawnUnitAt(q, r) {
			if (!isSpawnTile(state.currentSide, q, r)) {
				setMessage('You can only spawn on your spawn tiles.');
				return;
			}

			if (getUnitAt(q, r)) {
				setMessage('That spawn tile is occupied.');
				return;
			}

			const def = unitDefs[state.selectedSpawn];
			if (state.wits[state.currentSide] < def.cost) {
				setMessage('Not enough wits for ' + def.name + '.');
				return;
			}

			state.wits[state.currentSide] -= def.cost;
			state.units.push(makeUnit(state.currentSide, state.selectedSpawn, q, r));
			updateStats();
			setMessage(def.name + ' spawned.');
			draw();
		}

		function selectUnit(unit) {
			if (unit.side !== state.currentSide) {
				setMessage('That is not your unit.');
				return;
			}
			state.selectedUnitId = unit.id;
			state.mode = 'unit';
			updateStats();
			setMessage(unit.name + ' selected.');
			draw();
		}

		function moveOrAttackSelected(q, r) {
			const unit = getSelectedUnit();
			if (!unit) {
				setMessage('No unit selected.');
				return;
			}

			const distance = cubeDistance(unit.q, unit.r, q, r);
			const target = getUnitAt(q, r);
			const enemySide = state.currentSide === 'blue' ? 'red' : 'blue';

			if (target && target.side !== unit.side) {
				if (unit.acted) {
					setMessage('This unit already attacked.');
					return;
				}
				if (state.wits[state.currentSide] < 1) {
					setMessage('You need 1 wit to attack.');
					return;
				}
				if (distance > unit.range) {
					setMessage('Target is out of range.');
					return;
				}

				state.wits[state.currentSide] -= 1;
				target.hp -= unit.damage;
				unit.acted = true;

				if (target.hp <= 0) {
					const witTile = getWitTile(target.q, target.r);
					if (witTile) {
						witTile.owner = unit.side;
					}
				}

				if (isBaseTile(enemySide, q, r)) {
					state.baseHp[enemySide] -= unit.damage;
				}

				checkWin();
				updateStats();
				setMessage(unit.name + ' attacked.');
				draw();
				return;
			}

			if (!target) {
				if (unit.moved) {
					setMessage('This unit already moved.');
					return;
				}
				if (state.wits[state.currentSide] < 1) {
					setMessage('You need 1 wit to move.');
					return;
				}
				if (distance > unit.move) {
					setMessage('That move is too far.');
					return;
				}
				if (q < 0 || q >= COLS || r < 0 || r >= ROWS) {
					setMessage('Out of bounds.');
					return;
				}

				state.wits[state.currentSide] -= 1;
				unit.q = q;
				unit.r = r;
				unit.moved = true;

				const witTile = getWitTile(q, r);
				if (witTile) {
					witTile.owner = unit.side;
				}

				updateStats();
				setMessage(unit.name + ' moved.');
				draw();
				return;
			}

			setMessage('That tile is occupied.');
		}

		function checkWin() {
			if (state.baseHp.blue <= 0) {
				state.baseHp.blue = 0;
				state.gameOver = true;
				state.winner = 'Red';
				setMessage('Red wins.');
			}
			if (state.baseHp.red <= 0) {
				state.baseHp.red = 0;
				state.gameOver = true;
				state.winner = 'Blue';
				setMessage('Blue wins.');
			}
		}

		function drawBoard() {
			for (let r = 0; r < ROWS; r++) {
				for (let q = 0; q < COLS; q++) {
					const pos = axialToPixel(q, r);
					let fill = '#ffffff';
					let stroke = '#cbd5e1';

					if (isBaseTile('blue', q, r)) {
						fill = '#bfdbfe';
						stroke = '#2563eb';
					} else if (isBaseTile('red', q, r)) {
						fill = '#fecaca';
						stroke = '#dc2626';
					} else if (isSpawnTile('blue', q, r)) {
						fill = '#dbeafe';
						stroke = '#60a5fa';
					} else if (isSpawnTile('red', q, r)) {
						fill = '#fee2e2';
						stroke = '#f87171';
					}

					const witTile = getWitTile(q, r);
					if (witTile) {
						if (witTile.owner === 'blue') {
							fill = '#93c5fd';
						} else if (witTile.owner === 'red') {
							fill = '#fca5a5';
						} else {
							fill = '#fef3c7';
						}
						stroke = '#d97706';
					}

					drawHex(pos.x, pos.y, HEX_SIZE, fill, stroke, 2);

					if (witTile) {
						ctx.fillStyle = '#92400e';
						ctx.font = 'bold 14px Arial';
						ctx.textAlign = 'center';
						ctx.textBaseline = 'middle';
						ctx.fillText('+1', pos.x, pos.y + 1);
					}
				}
			}
		}

		function drawUnits() {
			state.units.forEach(function (unit) {
				if (unit.hp <= 0) {
					return;
				}

				const pos = axialToPixel(unit.q, unit.r);

				drawHex(
					pos.x,
					pos.y,
					HEX_SIZE - 6,
					unit.fill,
					unit.side === 'blue' ? '#1d4ed8' : '#b91c1c',
					3
				);

				ctx.font = '20px Arial';
				ctx.textAlign = 'center';
				ctx.textBaseline = 'middle';
				ctx.fillText(unit.emoji, pos.x, pos.y + 1);

				ctx.fillStyle = '#111827';
				ctx.font = 'bold 11px Arial';
				ctx.fillText(String(unit.hp), pos.x, pos.y + 20);

				if (state.selectedUnitId === unit.id) {
					ctx.beginPath();
					ctx.arc(pos.x, pos.y, HEX_SIZE - 2, 0, Math.PI * 2);
					ctx.strokeStyle = '#10b981';
					ctx.lineWidth = 3;
					ctx.stroke();
				}
			});
		}

		function drawBaseLabels() {
			const bluePos = axialToPixel(state.baseTiles.blue.q, state.baseTiles.blue.r);
			const redPos = axialToPixel(state.baseTiles.red.q, state.baseTiles.red.r);

			ctx.fillStyle = '#1e3a8a';
			ctx.font = 'bold 14px Arial';
			ctx.textAlign = 'center';
			ctx.fillText('Blue Base', bluePos.x, bluePos.y - 42);

			ctx.fillStyle = '#991b1b';
			ctx.fillText('Red Base', redPos.x, redPos.y - 42);
		}

		function drawOverlay() {
			if (state.started && !state.gameOver) {
				return;
			}

			ctx.save();
			ctx.fillStyle = 'rgba(15, 23, 42, 0.10)';
			ctx.fillRect(0, 0, canvas.width, canvas.height);

			ctx.fillStyle = '#0f172a';
			ctx.textAlign = 'center';

			if (state.gameOver) {
				ctx.font = 'bold 38px Arial';
				ctx.fillText(state.winner + ' Wins', canvas.width / 2, canvas.height / 2 - 10);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Press Restart to play again.', canvas.width / 2, canvas.height / 2 + 24);
			} else {
				ctx.font = 'bold 34px Arial';
				ctx.fillText('Wit Bases', canvas.width / 2, canvas.height / 2 - 10);
				ctx.font = 'bold 18px Arial';
				ctx.fillText('Press Start to begin.', canvas.width / 2, canvas.height / 2 + 24);
			}

			ctx.restore();
		}

		function draw() {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			drawBoard();
			drawBaseLabels();
			drawUnits();
			drawOverlay();
		}

		function pixelToHex(px, py) {
			const x = px - ORIGIN_X;
			const y = py - ORIGIN_Y;

			const q = ((Math.sqrt(3) / 3) * x - (1 / 3) * y) / HEX_SIZE;
			const r = ((2 / 3) * y) / HEX_SIZE;

			return hexRound(q, r);
		}

		function hexRound(q, r) {
			let x = q;
			let z = r;
			let y = -x - z;

			let rx = Math.round(x);
			let ry = Math.round(y);
			let rz = Math.round(z);

			const xDiff = Math.abs(rx - x);
			const yDiff = Math.abs(ry - y);
			const zDiff = Math.abs(rz - z);

			if (xDiff > yDiff && xDiff > zDiff) {
				rx = -ry - rz;
			} else if (yDiff > zDiff) {
				ry = -rx - rz;
			} else {
				rz = -rx - ry;
			}

			return {q: rx, r: rz};
		}

		canvas.addEventListener('click', function (event) {
			if (!state.started || state.gameOver) {
				return;
			}

			const rect = canvas.getBoundingClientRect();
			const px = (event.clientX - rect.left) * (canvas.width / rect.width);
			const py = (event.clientY - rect.top) * (canvas.height / rect.height);
			const hex = pixelToHex(px, py);

			if (hex.q < 0 || hex.q >= COLS || hex.r < 0 || hex.r >= ROWS) {
				return;
			}

			const clickedUnit = getUnitAt(hex.q, hex.r);

			if (state.mode === 'spawn') {
				if (clickedUnit && clickedUnit.side === state.currentSide) {
					selectUnit(clickedUnit);
				} else {
					spawnUnitAt(hex.q, hex.r);
				}
				return;
			}

			if (clickedUnit && clickedUnit.side === state.currentSide) {
				selectUnit(clickedUnit);
				return;
			}

			moveOrAttackSelected(hex.q, hex.r);
		});

		startButton.addEventListener('click', function () {
			if (state.started && !state.gameOver) {
				return;
			}
			resetGame();
			startGame();
		});

		restartButton.addEventListener('click', function () {
			resetGame();
		});

		endTurnButton.addEventListener('click', function () {
			endTurn();
		});

		unitButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				state.selectedSpawn = btn.getAttribute('data-unit');
				state.mode = 'spawn';
				state.selectedUnitId = null;
				setActiveSpawnButton();
				updateStats();
				setMessage(unitDefs[state.selectedSpawn].name + ' selected for spawn.');
			});
		});

		resetGame();
	});
});
JS;

if (!function_exists('zo_wit_bases_render')) {
	function zo_wit_bases_render($post_id = 0, $game = array()) {
		$game_id = 'zo-wit-bases-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--wit-bases" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-wb-wrap">
				<h2 class="zo-wb-title">Wit Bases</h2>
				<p class="zo-wb-subtitle">Big-map turn-based base battle inspired by wit-based tactics games.</p>

				<div class="zo-wb-topbar">
					<div class="zo-wb-stats">
						<div class="zo-wb-stat">Turn: <span class="zo-wb-turn">1</span></div>
						<div class="zo-wb-stat">Side: <span class="zo-wb-side-name">Blue</span></div>
						<div class="zo-wb-stat">Wits: <span class="zo-wb-wits">5</span></div>
						<div class="zo-wb-stat">Blue Base: <span class="zo-wb-blue-base">5</span></div>
						<div class="zo-wb-stat">Red Base: <span class="zo-wb-red-base">5</span></div>
						<div class="zo-wb-stat">Selected: <span class="zo-wb-selected">Scout</span></div>
						<div class="zo-wb-stat">Winner: <span class="zo-wb-winner">-</span></div>
					</div>

					<div class="zo-wb-controls">
						<button type="button" class="zo-wb-btn zo-wb-btn--primary zo-wb-start">Start</button>
						<button type="button" class="zo-wb-btn zo-wb-end-turn">End Turn</button>
						<button type="button" class="zo-wb-btn zo-wb-btn--danger zo-wb-restart">Restart</button>
					</div>
				</div>

				<div class="zo-wb-layout">
					<div class="zo-wb-board-wrap">
						<canvas class="zo-wb-canvas" width="1180" height="650" aria-label="Wit Bases board"></canvas>
						<div class="zo-wb-message">Press Start. Blue goes first.</div>
					</div>

					<div class="zo-wb-side">
						<h3>Spawn Units</h3>

						<div class="zo-wb-unit-grid">
							<button type="button" class="zo-wb-unit-btn is-active" data-unit="scout">🏃 Scout - Cost 1</button>
							<button type="button" class="zo-wb-unit-btn" data-unit="soldier">⚔️ Soldier - Cost 2</button>
							<button type="button" class="zo-wb-unit-btn" data-unit="sniper">🎯 Sniper - Cost 3</button>
							<button type="button" class="zo-wb-unit-btn" data-unit="heavy">🛡️ Heavy - Cost 4</button>
						</div>

						<h3>How to Play</h3>
						<ul>
							<li>Each turn you get 5 wits, plus bonus from captured wit tiles.</li>
							<li>Spawning costs wits.</li>
							<li>Moving costs 1 wit.</li>
							<li>Attacking costs 1 wit.</li>
							<li>Capture yellow +1 tiles by standing on them.</li>
							<li>Destroy the enemy base to win.</li>
						</ul>

						<h3>Controls</h3>
						<ul>
							<li>Choose a unit on the right to enter spawn mode.</li>
							<li>Click your spawn tile to create that unit.</li>
							<li>Click one of your units to select it.</li>
							<li>Click another tile to move or attack.</li>
							<li>Press End Turn when done.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'wit-bases',
	'name'            => 'Wit Bases',
	'author'          => 'Arslan',
	'description'     => 'A big-map turn-based tactics game with bases and wit points.',
	'render_callback' => 'zo_wit_bases_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);