<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--sound-citadel-rescue {
	max-width: 1000px;
	margin: 0 auto;
	padding: 16px;
	border: 2px solid #2e2a24;
	border-radius: 22px;
	background: linear-gradient(160deg, #0f1720 0%, #141f2e 58%, #1c2738 100%);
	box-sizing: border-box;
	font-family: 'Segoe UI', 'Trebuchet MS', sans-serif;
	color: #e9edf7;
}

.zo-game-root--sound-citadel-rescue .zo-scr-title {
	margin: 0 0 10px;
	font-size: 30px;
	text-align: center;
	color: #f8fafc;
}

.zo-game-root--sound-citadel-rescue .zo-scr-desc {
	margin: 0 0 14px;
	font-size: 14px;
	line-height: 1.55;
	text-align: center;
	color: #c4d0e5;
}

.zo-game-root--sound-citadel-rescue .zo-scr-grid {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 12px;
}

.zo-game-root--sound-citadel-rescue .zo-scr-stat {
	border: 1px solid #334155;
	background: #101a26;
	border-radius: 12px;
	padding: 10px;
	text-align: center;
}

.zo-game-root--sound-citadel-rescue .zo-scr-stat-label {
	display: block;
	font-size: 12px;
	color: #93a4bc;
	margin-bottom: 6px;
}

.zo-game-root--sound-citadel-rescue .zo-scr-stat-value {
	display: block;
	font-size: 22px;
	font-weight: 700;
	color: #e8edf7;
}

.zo-game-root--sound-citadel-rescue .zo-scr-board {
	border: 2px solid #2e3a50;
	border-radius: 14px;
	background: #050b12;
	padding: 12px;
	box-sizing: border-box;
}

.zo-game-root--sound-citadel-rescue .zo-scr-board-inner {
	display: block;
	width: 100%;
	height: 560px;
	background:
		radial-gradient(circle at 50% 8%, rgba(255,255,255,0.08), transparent 45%),
		radial-gradient(circle at 15% 35%, rgba(148, 163, 184, 0.1), transparent 40%),
		radial-gradient(circle at 85% 65%, rgba(125, 211, 252, 0.1), transparent 45%),
		linear-gradient(180deg, #090f17 0%, #0f1a29 100%);
		border: 1px solid #1b2940;
		border-radius: 12px;
}

.zo-game-root--sound-citadel-rescue .zo-scr-controls {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
	margin-top: 10px;
}

.zo-game-root--sound-citadel-rescue .zo-scr-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--sound-citadel-rescue .zo-scr-button--start {
	background: #16a34a;
	color: #ffffff;
}

.zo-game-root--sound-citadel-rescue .zo-scr-button--listen {
	background: #2563eb;
	color: #ffffff;
}

.zo-game-root--sound-citadel-rescue .zo-scr-button--clear {
	background: #dc2626;
	color: #ffffff;
}

.zo-game-root--sound-citadel-rescue .zo-scr-help {
	margin-top: 10px;
	font-size: 13px;
	line-height: 1.55;
	color: #a8b8cf;
}

.zo-game-root--sound-citadel-rescue .zo-scr-message {
	margin-top: 12px;
	min-height: 24px;
	text-align: center;
	font-weight: 700;
}

.zo-game-root--sound-citadel-rescue .zo-scr-message.success {
	color: #34d399;
}

.zo-game-root--sound-citadel-rescue .zo-scr-message.error {
	color: #f87171;
}

.zo-scr-lane-meter {
	height: 10px;
	margin-top: 8px;
	background: #1b2638;
	border-radius: 999px;
	overflow: hidden;
}

.zo-scr-lane-meter > span {
	display: block;
	height: 100%;
	background: linear-gradient(90deg, #22c55e 0%, #f59e0b 65%, #ef4444 100%);
	width: 0%;
	transition: width 260ms ease;
}

@media (max-width: 800px) {
	.zo-game-root--sound-citadel-rescue {
		padding: 12px;
	}

	.zo-game-root--sound-citadel-rescue .zo-scr-title {
		font-size: 24px;
	}

	.zo-game-root--sound-citadel-rescue .zo-scr-grid,
	.zo-game-root--sound-citadel-rescue .zo-scr-controls {
		grid-template-columns: 1fr 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--sound-citadel-rescue');

	roots.forEach(function (root) {
		const canvas = root.querySelector('.zo-scr-canvas');
		const ctx = canvas.getContext('2d');
		const startButton = root.querySelector('.zo-scr-button--start');
		const listenButton = root.querySelector('.zo-scr-button--listen');
		const clearButton = root.querySelector('.zo-scr-button--clear');
		const waveEl = root.querySelector('.zo-scr-wave');
		const scoreEl = root.querySelector('.zo-scr-score');
		const rescuedEl = root.querySelector('.zo-scr-rescued');
		const lostEl = root.querySelector('.zo-scr-lost');
		const messageEl = root.querySelector('.zo-scr-message');
		const threatMeters = root.querySelectorAll('.zo-scr-lane-meter > span');
		const costEl = root.querySelector('.zo-scr-cost');

		const WIDTH = 960;
		const HEIGHT = 560;
		const LANES = 5;
		const LANE_GAP = Math.floor((WIDTH - 220) / (LANES - 1));
		const TOWER_COST = 2;
		const GOAL_RESCUES = 32;

		canvas.width = WIDTH;
		canvas.height = HEIGHT;

		const laneYs = [];
		for (let i = 0; i < LANES; i++) {
			laneYs.push(72 + (i * ((HEIGHT - 140) / (LANES - 1)));
		}

		let running = false;
		let isGameOver = false;
		let wave = 1;
		let score = 0;
		let rescued = 0;
		let lost = 0;
		let money = 12;
		let animationId = null;
		let manualPulseMs = 0;
		let spawnDelay = 0;
		let spawnedThisWave = 0;
		let nextWaveDelay = 0;
		let waveSpawnTarget = 8;
		let lastPulseAt = 0;
		let autoGuidanceOn = true;
		let frame = 0;

		let towers = [];
		let curses = [];
		let spirits = [];
		let pulses = [];
		let bullets = [];
		let nextSpiritId = 1;

		const AudioState = {
			context: null,
			running: false,
			master: null
		};

		function setupAudio() {
			if (AudioState.context) {
				if (AudioState.context.state !== 'running') {
					AudioState.context.resume();
				}
				AudioState.running = true;
				return;
			}

			const context = new (window.AudioContext || window.webkitAudioContext)();
			AudioState.context = context;
			AudioState.master = context.createGain();
			AudioState.master.gain.value = 0.12;
			AudioState.master.connect(context.destination);
			AudioState.running = true;
		}

		function playTone(freq, pan = 0, duration = 0.10, volume = 0.16) {
			if (!AudioState.running || !AudioState.context || AudioState.context.state !== 'running') {
				return;
			}
			const t = AudioState.context.currentTime;
			const osc = AudioState.context.createOscillator();
			const gain = AudioState.context.createGain();
			const panner = AudioState.context.createStereoPanner();
			panner.pan.value = Math.max(-1, Math.min(1, pan));
			osc.type = 'sine';
			osc.frequency.setValueAtTime(freq, t);
			gain.gain.setValueAtTime(0, t);
			gain.gain.linearRampToValueAtTime(volume, t + 0.01);
			gain.gain.exponentialRampToValueAtTime(0.001, t + duration);
			osc.connect(gain);
			gain.connect(panner);
			panner.connect(AudioState.master);
			osc.start(t);
			osc.stop(t + duration + 0.02);
		}

		function randomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		function createSpirit(lane) {
			const x = 80 + randomInt(0, 20);
			return {
				id: nextSpiritId++,
				lane: lane,
				x: x,
				y: laneYs[lane],
				speed: 0.9 + (Math.random() * 0.3),
				radius: 13,
				state: 'trapped',
				rescueTimer: 0,
				maxRescueTimer: 140
			};
		}

		function createCurse(lane, waveNumber) {
			return {
				lane: lane,
				x: WIDTH - 72,
				y: laneYs[lane],
				radius: 11,
				speed: 1.2 + (waveNumber * 0.08) + (Math.random() * 0.4),
				hp: 1 + Math.floor(waveNumber / 3),
				maxHp: 1 + Math.floor(waveNumber / 3),
				targetSpirit: null
			};
		}

		function createTower(x, lane) {
			return {
				x: x,
				y: laneYs[lane],
				lane: lane,
				range: 220,
				cooldown: 0,
				fireRate: 30,
				damage: 1
			};
		}

		function isLaneOccupiedByTower(x, lane) {
			return towers.some(function (t) {
				return t.lane === lane && Math.abs(t.x - x) < 28;
			});
		}

		function createStartingState() {
			wave = 1;
			rescueCount = 0;
			score = 0;
			rescued = 0;
			lost = 0;
			money = 12;
			spawnedThisWave = 0;
			waveSpawnTarget = 6;
			spawnDelay = 0;
			nextWaveDelay = 120;
			running = false;
			isGameOver = false;
			autoGuidanceOn = true;
			towers = [];
			curses = [];
			spirits = [];
			pulses = [];
			bullets = [];
			nextSpiritId = 1;
			for (let i = 0; i < 3; i++) {
				const lane = i % LANES;
				spirits.push(createSpirit(lane));
			}
			nextWaveDelay = 0;
			setMessage('Press Start to sound the citadel horns.');
			updateHud();
		}

		const rescueGoal = GOAL_RESCUES;
		let rescueCount = 0;

		function updateHud() {
			waveEl.textContent = String(wave);
			scoreEl.textContent = String(score);
			rescuedEl.textContent = String(rescued) + ' / ' + String(rescueGoal);
			lostEl.textContent = String(lost);
			costEl.textContent = String(money);
		}

		function setMessage(text, type) {
			messageEl.textContent = text;
			messageEl.className = 'zo-scr-message';
			if (type === 'ok') {
				messageEl.classList.add('success');
			}
			if (type === 'bad') {
				messageEl.classList.add('error');
			}
		}

		function clearMessage() {
			setMessage('', '');
		}

		function lineDistanceFromRight(c) {
			return Math.max(0, c.x / (WIDTH - 90));
		}

		function lanePulseValue(lane) {
			const list = curses
				.filter(function (c) {
					return c.lane === lane;
				})
				.map(function (c) {
					return 1 - lineDistanceFromRight(c);
				});
			if (list.length === 0) {
				return 0;
			}
			return Math.min(1, Math.max(0.05, Math.max.apply(null, list)));
		}

		function nearestCurseForTower(tower) {
			let nearest = null;
			let best = 999999;
			for (let i = 0; i < curses.length; i++) {
				const c = curses[i];
				if (c.lane !== tower.lane) {
					continue;
				}
				const d = Math.abs(tower.x - c.x);
				if (d <= tower.range && d < best) {
					best = d;
					nearest = c;
				}
			}
			return nearest;
		}

		function fire(tower, target) {
			tower.cooldown = tower.fireRate;
			const vx = (target.x - tower.x) / 16;
			bullets.push({
				x: tower.x,
				y: tower.y,
				targetX: target.x,
				targetY: target.y,
				vx: vx,
				vy: 0,
				life: 18,
				steps: 16,
				targetId: target.id
			});
			playTone(900 + (target.hp * 120), 0, 0.05, 0.2);
			target.hp -= tower.damage;
			if (target.hp <= 0) {
				score += 14;
				curses = curses.filter(function (c) {
					return c.id !== target.id;
				});
				tower.cooldown += 12;
				playTone(1320, 0, 0.11, 0.15);
			}
		}

		function updateEntities() {
			if (!running || isGameOver) {
				if (nextWaveDelay > 0) {
					nextWaveDelay -= 1;
					if (nextWaveDelay === 1) {
						setMessage('Wave ' + wave + ' begins. Defend every trapped spirit.');
					}
				}
				return;
			}

			frame += 1;
			spawnDelay -= 1;
			score += 0.02;

			if (spawnDelay <= 0 && spawnedThisWave < waveSpawnTarget) {
				const lane = randomInt(0, LANES - 1);
				const curse = createCurse(lane, wave);
				curse.id = 'c-' + frame + '-' + lane;
				curses.push(curse);
				spawnDelay = Math.max(18, 40 - wave);
				spawnedThisWave += 1;
			}

			if (spawnedThisWave >= waveSpawnTarget && curses.length === 0 && spawnDelay < -40) {
				wave += 1;
				if (wave > 30) {
					wave = 30;
				}
				waveSpawnTarget = 6 + wave;
				spawnedThisWave = 0;
				nextWaveDelay = 180;
				money += 3;
				spawnDelay = 0;
				setMessage('Wave cleared. +' + 3 + ' echoes. Next wave in 3 seconds.', 'ok');
			}

			if (Math.random() < 0.007 && spirits.length < 5 && rescued + lost < rescueGoal && !isGameOver) {
				spirits.push(createSpirit(randomInt(0, LANES - 1));
			}

			if (spirits.filter(function (s) {
				return s.state !== 'lost';
			}).length < 2 && rescued + lost < rescueGoal && !isGameOver) {
				for (let s = 0; s < 2; s++) {
					spirits.push(createSpirit(randomInt(0, LANES - 1));
				}
			}

			for (let i = 0; i < curses.length; i++) {
				const curse = curses[i];
				curse.x -= curse.speed;
			}

			for (let i = 0; i < spirits.length; i++) {
				const spirit = spirits[i];
				if (spirit.state === 'lost') {
					continue;
				}
				if (spirit.state === 'trapped') {
					spirit.rescueTimer += 1;
					if (spirit.rescueTimer > spirit.maxRescueTimer) {
						spirit.state = 'escaping';
						setMessage('A spirit at lane ' + (spirit.lane + 1) + ' has started to break free.', 'ok');
					}
				} else if (spirit.state === 'escaping') {
					spirit.x += spirit.speed;
					if (spirit.x >= WIDTH - 56) {
						rescued += 1;
						score += 30;
						rescueCount += 1;
						spirits.splice(i, 1);
						i -= 1;
						money += 1;
						playTone(640, 0.6, 0.2, 0.14);
						setMessage('A spirit is rescued! Total: ' + rescued + '/' + rescueGoal, 'ok');
						if (rescued >= rescueGoal) {
							setMessage('Citadel echo lock achieved. You rescued the trapped spirits. Victory.', 'ok');
							isGameOver = true;
							running = false;
						}
					}
				}
			}

			for (let i = curses.length - 1; i >= 0; i--) {
				const c = curses[i];
				let hitSpirit = null;
				for (let j = 0; j < spirits.length; j++) {
					const s = spirits[j];
					if (s.state === 'lost') {
						continue;
					}
					if (s.lane === c.lane && c.x - c.radius <= s.x + s.radius + 4) {
						hitSpirit = s;
						break;
					}
				}
				if (hitSpirit) {
					lost += 1;
					hitSpirit.state = 'lost';
					spirits = spirits.filter(function (s) {
						return s.id !== hitSpirit.id;
					});
					curses.splice(i, 1);
					score = Math.max(0, score - 18);
					playTone(180, 0, 0.17, 0.2);
					setMessage('A trapped spirit was taken by the curse.', 'bad');
					if (lost >= 10) {
						isGameOver = true;
						running = false;
						setMessage('Citadel breached. Too many souls lost.');
					}
				}
			}

			curses = curses.filter(function (c) {
				return c.x > 34;
			});

			for (let i = 0; i < towers.length; i++) {
				const t = towers[i];
				if (t.cooldown > 0) {
					t.cooldown -= 1;
					continue;
				}
				const target = nearestCurseForLaneTarget(t);
				if (target) {
					fire(t, target);
				}
			}

			for (let i = bullets.length - 1; i >= 0; i--) {
				const b = bullets[i];
				if (b.life <= 0) {
					bullets.splice(i, 1);
					continue;
				}
				b.x += b.vx;
				b.life -= 1;
			}

			if (frame % 14 === 0) {
				for (let lane = 0; lane < LANES; lane++) {
					const c = lanePulseValue(lane);
					if (threatMeters[lane]) {
						threatMeters[lane].style.width = (c * 100).toFixed(0) + '%';
					}
				}
			}

			if ((frame - lastPulseAt) > 55) {
				if (autoGuidanceOn && (wave > 0)) {
					emitLaneAudio(true);
				}
				lastPulseAt = frame;
			}

			if (manualPulseMs > 0) {
				manualPulseMs -= 1;
			}

			draw();
			updateHud();
		}

		function nearestCurseForLaneTarget(tower) {
			let target = null;
			let best = 999999;
			for (let i = 0; i < curses.length; i++) {
				const c = curses[i];
				if (c.lane !== tower.lane) {
					continue;
				}
				const d = Math.abs(tower.x - c.x);
				if (d < best) {
					best = d;
					target = c;
				}
			}
			return target;
		}

		function emitLaneAudio(forceAll = false) {
			if (!AudioState.running || AudioState.context.state !== 'running') {
				return;
			}
			for (let lane = 0; lane < LANES; lane++) {
				const danger = lanePulseValue(lane);
				if (danger <= 0) {
					if (forceAll) {
						playTone(140 + (lane * 20), (lane / (LANES - 1)) * 1.3 - 0.65, 0.05, 0.05);
					}
					continue;
				}
				const freq = 220 + (danger * 560) + (lane * 35);
				const pan = (lane / (LANES - 1)) * 1.8 - 0.9;
				const vol = 0.06 + (danger * 0.12);
				playTone(freq, pan, 0.09, vol);
			}
		}

		function draw() {
			ctx.clearRect(0, 0, WIDTH, HEIGHT);

			ctx.fillStyle = 'rgba(255,255,255,0.04)';
			ctx.fillRect(0, 0, WIDTH, HEIGHT);

			for (let lane = 0; lane < LANES; lane++) {
				const y = laneYs[lane];
				ctx.strokeStyle = 'rgba(148, 163, 184, 0.18)';
				ctx.lineWidth = 1;
				ctx.setLineDash([8, 6]);
				ctx.beginPath();
				ctx.moveTo(52, y + 0);
				ctx.lineTo(WIDTH - 52, y + 0);
				ctx.stroke();
				ctx.setLineDash([]);
			}

			ctx.fillStyle = '#0f1727';
			ctx.fillRect(56, 30, 12, HEIGHT - 70);
			ctx.fillStyle = '#ef4444';
			ctx.fillRect(WIDTH - 70, 30, 12, HEIGHT - 70);

			for (let i = 0; i < towers.length; i++) {
				const t = towers[i];
				ctx.strokeStyle = 'rgba(34, 211, 238, 0.6)';
				ctx.lineWidth = 2;
				ctx.beginPath();
				ctx.arc(t.x, t.y, t.range, 0, Math.PI * 2);
				ctx.stroke();
				ctx.fillStyle = '#22d3ee';
				ctx.beginPath();
				ctx.arc(t.x, t.y, 15, 0, Math.PI * 2);
				ctx.fill();
				ctx.fillStyle = '#07111f';
				ctx.fillRect(t.x - 10, t.y - 3, 20, 6);
			}

			for (let i = 0; i < spirits.length; i++) {
				const s = spirits[i];
				ctx.beginPath();
				if (s.state === 'trapped') {
					ctx.fillStyle = '#f59e0b';
				} else {
					ctx.fillStyle = '#34d399';
				}
				ctx.arc(s.x, s.y, s.radius, 0, Math.PI * 2);
				ctx.fill();
				ctx.fillStyle = '#fef9c3';
				ctx.beginPath();
				ctx.moveTo(s.x - 9, s.y + 2);
				ctx.lineTo(s.x + 9, s.y + 2);
				ctx.lineTo(s.x, s.y - 12);
				ctx.fill();
			}

			for (let i = 0; i < curses.length; i++) {
				const c = curses[i];
				const danger = lanePulseValue(c.lane);
				ctx.fillStyle = danger > 0.7 ? '#f43f5e' : '#fb7185';
				ctx.beginPath();
				ctx.arc(c.x, c.y, c.radius, 0, Math.PI * 2);
				ctx.fill();
				ctx.fillStyle = '#1f2937';
				ctx.fillRect(c.x - 12, c.y - 14, 24, 6);
				ctx.fillStyle = '#cbd5e1';
				ctx.fillRect(c.x - 12, c.y - 14, 24 * (c.hp / c.maxHp), 6);
			}

			for (let i = 0; i < bullets.length; i++) {
				const b = bullets[i];
				ctx.fillStyle = '#eab308';
				ctx.beginPath();
				ctx.arc(b.x, b.y, 3.2, 0, Math.PI * 2);
				ctx.fill();
			}

			ctx.fillStyle = '#94a3b8';
			ctx.font = 'bold 16px sans-serif';
			ctx.textAlign = 'left';
			ctx.fillText('CASTLE ENTRANCE', 8, 48);
			ctx.textAlign = 'right';
			ctx.fillText('SANCTUARY', WIDTH - 8, 48);
		}

		function loop() {
			updateEntities();
			animationId = requestAnimationFrame(loop);
		}

		canvas.addEventListener('pointerdown', function (event) {
			if (!running || isGameOver) {
				return;
		}
			const rect = canvas.getBoundingClientRect();
			const scaleX = WIDTH / rect.width;
			const clickX = (event.clientX - rect.left) * scaleX;
			const clickY = (event.clientY - rect.top) * (HEIGHT / rect.height);
			let nearestLane = 0;
			let bestDist = Infinity;
			for (let lane = 0; lane < LANES; lane++) {
				const d = Math.abs(clickY - laneYs[lane]);
				if (d < bestDist) {
					bestDist = d;
					nearestLane = lane;
				}
			}
			if (money < TOWER_COST) {
				setMessage('Need more echoes. Rescue spirits to earn echoes.', 'bad');
				return;
			}
			if (isNaN(clickX) || clickX < 80 || clickX > WIDTH - 80) {
				return;
			}
			if (isLaneOccupiedByTower(clickX, nearestLane)) {
				setMessage('A ward already exists in that lane at this point.');
				return;
			}
			money -= TOWER_COST;
			towers.push(createTower(clickX, nearestLane));
			setMessage('Ward placed. Keep listening.');
			playTone(1100, -0.2, 0.08, 0.15);
			updateHud();
		});

		startButton.addEventListener('click', function () {
			setupAudio();
			autoGuidanceOn = true;
			running = true;
			if (isGameOver) {
				createStartingState();
				running = true;
			}
			clearMessage();
			setMessage('Defend the lanes by placing wards and listening with sound guidance.');
			emitLaneAudio(true);
		});

		listenButton.addEventListener('click', function () {
			if (!running) {
				setMessage('Press Start first.');
				return;
			}
			setupAudio();
			manualPulseMs = 2;
			emitLaneAudio(true);
		});

		clearButton.addEventListener('click', function () {
			if (confirm('Reset this battle?')) {
				createStartingState();
			draw();
		}
		});

		function bootstrap() {
			createStartingState();
			draw();
			if (!animationId) {
				loop();
			}
		}

		bootstrap();
	});
});
JS;

if (!function_exists('zo_game_sound_citadel_rescue_render')) {
	function zo_game_sound_citadel_rescue_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-sound-citadel-rescue-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--sound-citadel-rescue" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-scr-title">Sound Citadel Rescue</h2>
			<p class="zo-scr-desc">Build wards across 5 rune lanes and rescue trapped spirits. You can only rely on the sonar tones to know where curses are approaching each lane.</p>

			<div class="zo-scr-grid">
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Wave</span>
					<span class="zo-scr-stat-value zo-scr-wave">1</span>
				</div>
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Rescued / Goal</span>
					<span class="zo-scr-stat-value zo-scr-rescued">0 / 32</span>
				</div>
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Cursed Lost</span>
					<span class="zo-scr-stat-value zo-scr-lost">0</span>
				</div>
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Echoes</span>
					<span class="zo-scr-stat-value zo-scr-score">0</span>
				</div>
			</div>

			<div class="zo-scr-stat" style="margin-bottom:10px;">
				<span class="zo-scr-stat-label">Wards Cost</span>
				<span class="zo-scr-stat-value zo-scr-cost">12</span>
			</div>

			<div class="zo-scr-board">
				<canvas class="zo-scr-board-inner zo-scr-canvas" width="960" height="560"></canvas>
			</div>

			<div class="zo-scr-grid" style="margin-top:10px;">
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Lane threat (audio map)</span>
					<div class="zo-scr-lane-meter"><span></span></div>
				</div>
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Lane threat (audio map)</span>
					<div class="zo-scr-lane-meter"><span></span></div>
				</div>
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Lane threat (audio map)</span>
					<div class="zo-scr-lane-meter"><span></span></div>
				</div>
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Lane threat (audio map)</span>
					<div class="zo-scr-lane-meter"><span></span></div>
				</div>
			</div>
			<div class="zo-scr-grid" style="margin-top:10px;">
				<div class="zo-scr-stat">
					<span class="zo-scr-stat-label">Lane threat (audio map)</span>
					<div class="zo-scr-lane-meter"><span></span></div>
				</div>
			</div>

			<div class="zo-scr-controls">
				<button type="button" class="zo-scr-button zo-scr-button--start">Start</button>
				<button type="button" class="zo-scr-button zo-scr-button--listen">Listen</button>
				<button type="button" class="zo-scr-button zo-scr-button--clear">Reset</button>
			</div>

			<div class="zo-scr-message"></div>
			<div class="zo-scr-help">Click on the castle map lanes to place a ward. Higher beep pitch means a curse is closer; stereo panning tells lane direction.</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'sound-citadel-rescue',
	'name' => 'Sound Citadel Rescue',
	'author' => 'asker',
	'description' => 'A castle defense concept where you rescue trapped spirits by placing sonic wards across lanes. Curses move in darkness, and sound cues are your primary guide for where danger is strongest.',
	'render_callback' => 'zo_game_sound_citadel_rescue_render',
	'inline_style' => $css,
	'inline_script' => $js,
);
