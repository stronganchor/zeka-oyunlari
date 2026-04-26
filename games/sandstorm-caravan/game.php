<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--sandstorm-caravan {
	--ssc-ink: #312216;
	--ssc-soft: #6b4a2b;
	--ssc-accent: #c2410c;
	--ssc-card: rgba(255, 247, 237, 0.78);
	max-width: 980px;
	margin: 0 auto;
	padding: 20px;
	border-radius: 24px;
	border: 2px solid rgba(194, 65, 12, 0.18);
	background:
		radial-gradient(circle at top right, rgba(253, 224, 71, 0.22), transparent 28%),
		linear-gradient(180deg, #fff7ed 0%, #ffedd5 100%);
	box-sizing: border-box;
	font-family: "Trebuchet MS", Verdana, sans-serif;
	color: var(--ssc-ink);
}

.zo-game-root--sandstorm-caravan .zo-ssc-title {
	margin: 0 0 8px;
	font-size: 34px;
	text-align: center;
	color: #9a3412;
}

.zo-game-root--sandstorm-caravan .zo-ssc-desc {
	margin: 0 0 18px;
	text-align: center;
	line-height: 1.55;
	color: var(--ssc-soft);
}

.zo-game-root--sandstorm-caravan .zo-ssc-top {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 14px;
}

.zo-game-root--sandstorm-caravan .zo-ssc-stat,
.zo-game-root--sandstorm-caravan .zo-ssc-panel {
	padding: 12px;
	border-radius: 16px;
	background: var(--ssc-card);
	border: 1px solid rgba(194, 65, 12, 0.12);
}

.zo-game-root--sandstorm-caravan .zo-ssc-stat-label {
	display: block;
	margin-bottom: 4px;
	font-size: 12px;
	text-transform: uppercase;
	letter-spacing: 0.08em;
	color: #b45309;
}

.zo-game-root--sandstorm-caravan .zo-ssc-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
}

.zo-game-root--sandstorm-caravan .zo-ssc-middle {
	display: grid;
	grid-template-columns: 1.2fr 0.8fr;
	gap: 14px;
}

.zo-game-root--sandstorm-caravan .zo-ssc-subtitle {
	margin: 0 0 8px;
	font-size: 18px;
	color: #9a3412;
}

.zo-game-root--sandstorm-caravan .zo-ssc-route {
	height: 14px;
	border-radius: 999px;
	background: rgba(120, 53, 15, 0.14);
	overflow: hidden;
}

.zo-game-root--sandstorm-caravan .zo-ssc-route-fill {
	display: block;
	height: 100%;
	width: 0%;
	background: linear-gradient(90deg, #f59e0b 0%, #ea580c 100%);
	transition: width 220ms ease;
}

.zo-game-root--sandstorm-caravan .zo-ssc-weather,
.zo-game-root--sandstorm-caravan .zo-ssc-offer,
.zo-game-root--sandstorm-caravan .zo-ssc-status {
	line-height: 1.6;
	color: #4b3621;
}

.zo-game-root--sandstorm-caravan .zo-ssc-actions {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-top: 14px;
}

.zo-game-root--sandstorm-caravan .zo-ssc-button {
	border: 0;
	border-radius: 14px;
	padding: 12px 14px;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--sandstorm-caravan .zo-ssc-button--travel {
	background: #c2410c;
	color: #ffffff;
}

.zo-game-root--sandstorm-caravan .zo-ssc-button--scout {
	background: #f59e0b;
	color: #3f2600;
}

.zo-game-root--sandstorm-caravan .zo-ssc-button--trade {
	background: #0f766e;
	color: #ffffff;
}

.zo-game-root--sandstorm-caravan .zo-ssc-button--rest {
	background: #334155;
	color: #ffffff;
}

.zo-game-root--sandstorm-caravan .zo-ssc-button--reset {
	margin-top: 10px;
	width: 100%;
	background: #fff7ed;
	color: #9a3412;
	border: 1px solid rgba(194, 65, 12, 0.18);
}

.zo-game-root--sandstorm-caravan .zo-ssc-log {
	margin: 0;
	padding-left: 18px;
	color: #5b4630;
}

.zo-game-root--sandstorm-caravan .zo-ssc-log li + li {
	margin-top: 6px;
}

@media (max-width: 820px) {
	.zo-game-root--sandstorm-caravan {
		padding: 14px;
	}

	.zo-game-root--sandstorm-caravan .zo-ssc-top {
		grid-template-columns: 1fr 1fr;
	}

	.zo-game-root--sandstorm-caravan .zo-ssc-middle {
		grid-template-columns: 1fr;
	}

	.zo-game-root--sandstorm-caravan .zo-ssc-actions {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--sandstorm-caravan');

	roots.forEach(function (root) {
		const dayEl = root.querySelector('.zo-ssc-day');
		const distanceEl = root.querySelector('.zo-ssc-distance');
		const waterEl = root.querySelector('.zo-ssc-water');
		const cluesEl = root.querySelector('.zo-ssc-clues');
		const moraleEl = root.querySelector('.zo-ssc-morale');
		const weatherEl = root.querySelector('.zo-ssc-weather');
		const offerEl = root.querySelector('.zo-ssc-offer');
		const routeFillEl = root.querySelector('.zo-ssc-route-fill');
		const routeTextEl = root.querySelector('.zo-ssc-route-text');
		const statusEl = root.querySelector('.zo-ssc-status');
		const logEl = root.querySelector('.zo-ssc-log');

		const buttons = {
			travel: root.querySelector('.zo-ssc-button--travel'),
			scout: root.querySelector('.zo-ssc-button--scout'),
			trade: root.querySelector('.zo-ssc-button--trade'),
			rest: root.querySelector('.zo-ssc-button--rest'),
			reset: root.querySelector('.zo-ssc-button--reset')
		};

		const goal = 24;
		const weatherTable = [
			{ name: 'Calm Dawn', water: 0, morale: 1, distance: 1 },
			{ name: 'Dry Wind', water: 1, morale: 0, distance: 0 },
			{ name: 'Sandstorm Wall', water: 2, morale: -1, distance: -1 }
		];
		const offers = [
			{ text: 'Nomads offer 3 water for 1 tool.', needKey: 'tools', need: 1, gainKey: 'water', gain: 3 },
			{ text: 'Scouts offer 2 clues for 2 water.', needKey: 'water', need: 2, gainKey: 'clues', gain: 2 },
			{ text: 'Mechanics offer 2 morale for 1 clue.', needKey: 'clues', need: 1, gainKey: 'morale', gain: 2 },
			{ text: 'Merchants offer 1 tool for 3 water.', needKey: 'water', need: 3, gainKey: 'tools', gain: 1 }
		];

		let state = null;

		function clamp(value, min) {
			return value < min ? min : value;
		}

		function randomItem(list) {
			return list[Math.floor(Math.random() * list.length)];
		}

		function addLog(text) {
			state.log.unshift(text);
			state.log = state.log.slice(0, 6);
		}

		function updateOfferAndWeather() {
			state.weather = randomItem(weatherTable);
			state.offer = randomItem(offers);
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function finishTurn() {
			state.water = clamp(state.water, 0);
			state.tools = clamp(state.tools, 0);
			state.clues = clamp(state.clues, 0);
			state.morale = clamp(state.morale, 0);

			if (state.distance >= goal) {
				state.gameOver = true;
				setStatus('The caravan reaches the city gates before the dunes close behind you.');
				render();
				return;
			}

			if (state.water <= 0 || state.morale <= 0) {
				state.gameOver = true;
				setStatus('The caravan breaks apart in the dunes. Reset and try a safer route.');
				render();
				return;
			}

			state.day += 1;
			if (state.day > 9) {
				state.gameOver = true;
				setStatus('Time runs out before the caravan finds the city. Reset and try again.');
				render();
				return;
			}

			updateOfferAndWeather();
			setStatus('Choose the next move before the desert shifts again.');
			render();
		}

		function travel() {
			if (state.gameOver) {
				return;
			}

			let distanceGain = 3;
			let waterCost = 2;
			let moraleShift = 0;

			if (state.clues > 0) {
				state.clues -= 1;
				distanceGain += 1;
			}

			distanceGain += state.weather.distance;
			waterCost += state.weather.water;
			moraleShift += state.weather.morale;

			if (state.tools === 0) {
				moraleShift -= 1;
			}

			state.distance += Math.max(1, distanceGain);
			state.water -= Math.max(1, waterCost);
			state.morale += moraleShift;

			addLog('Travel: +' + Math.max(1, distanceGain) + ' distance through ' + state.weather.name + '.');
			finishTurn();
		}

		function scout() {
			if (state.gameOver) {
				return;
			}

			state.clues += 2;
			state.water -= 1 + state.weather.water;
			state.distance += Math.max(0, state.weather.distance);
			state.morale += state.weather.morale;

			addLog('Scout: new landmarks found while crossing ' + state.weather.name + '.');
			finishTurn();
		}

		function trade() {
			if (state.gameOver) {
				return;
			}

			const offer = state.offer;
			if (state[offer.needKey] >= offer.need) {
				state[offer.needKey] -= offer.need;
				state[offer.gainKey] += offer.gain;
				addLog('Trade: ' + offer.text);
			} else {
				state.morale -= 1;
				addLog('Trade failed: the caravan could not afford the camp offer.');
			}

			state.water -= state.weather.water;
			finishTurn();
		}

		function rest() {
			if (state.gameOver) {
				return;
			}

			state.water -= 1 + state.weather.water;
			state.morale += 2 + Math.max(0, state.weather.morale);
			if (state.tools > 0 && state.weather.name === 'Sandstorm Wall') {
				state.tools -= 1;
				addLog('Rest: the camp survived, but one tool was lost in the storm.');
			} else {
				addLog('Rest: the caravan regains its nerve beneath the tents.');
			}

			finishTurn();
		}

		function render() {
			dayEl.textContent = String(state.day) + ' / 9';
			distanceEl.textContent = String(state.distance) + ' / ' + String(goal);
			waterEl.textContent = String(state.water);
			cluesEl.textContent = String(state.clues);
			moraleEl.textContent = String(state.morale);
			weatherEl.textContent = state.weather.name + ' changes travel by ' + (state.weather.distance >= 0 ? '+' : '') + state.weather.distance + ', water by +' + state.weather.water + ', morale by ' + (state.weather.morale >= 0 ? '+' : '') + state.weather.morale + '.';
			offerEl.textContent = state.offer.text;
			routeFillEl.style.width = Math.min(100, Math.round((state.distance / goal) * 100)) + '%';
			routeTextEl.textContent = 'Distance to city: ' + state.distance + ' of ' + goal;
			logEl.innerHTML = '';

			state.log.forEach(function (item) {
				const li = document.createElement('li');
				li.textContent = item;
				logEl.appendChild(li);
			});

			Object.keys(buttons).forEach(function (key) {
				if (key !== 'reset') {
					buttons[key].disabled = state.gameOver;
				}
			});
		}

		function reset() {
			state = {
				day: 1,
				distance: 0,
				water: 11,
				tools: 4,
				clues: 3,
				morale: 6,
				log: ['A fresh caravan leaves the dunes at sunrise.'],
				weather: weatherTable[0],
				offer: offers[0],
				gameOver: false
			};

			updateOfferAndWeather();
			setStatus('Guide the caravan by balancing water, clues, tools, and morale.');
			render();
		}

		buttons.travel.addEventListener('click', travel);
		buttons.scout.addEventListener('click', scout);
		buttons.trade.addEventListener('click', trade);
		buttons.rest.addEventListener('click', rest);
		buttons.reset.addEventListener('click', reset);

		reset();
	});
});
JS;

if (!function_exists('zo_game_sandstorm_caravan_render')) {
	function zo_game_sandstorm_caravan_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-sandstorm-caravan-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--sandstorm-caravan" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-ssc-title">Sandstorm Caravan</h2>
			<p class="zo-ssc-desc">Lead a caravan to the city before the dunes swallow the route. Each day you choose whether to travel, scout, trade, or rest while the weather keeps rewriting the desert.</p>

			<div class="zo-ssc-top">
				<div class="zo-ssc-stat">
					<span class="zo-ssc-stat-label">Day</span>
					<span class="zo-ssc-stat-value zo-ssc-day">1 / 9</span>
				</div>
				<div class="zo-ssc-stat">
					<span class="zo-ssc-stat-label">Distance</span>
					<span class="zo-ssc-stat-value zo-ssc-distance">0 / 24</span>
				</div>
				<div class="zo-ssc-stat">
					<span class="zo-ssc-stat-label">Water</span>
					<span class="zo-ssc-stat-value zo-ssc-water">11</span>
				</div>
				<div class="zo-ssc-stat">
					<span class="zo-ssc-stat-label">Clues</span>
					<span class="zo-ssc-stat-value zo-ssc-clues">3</span>
				</div>
				<div class="zo-ssc-stat">
					<span class="zo-ssc-stat-label">Morale</span>
					<span class="zo-ssc-stat-value zo-ssc-morale">6</span>
				</div>
			</div>

			<div class="zo-ssc-middle">
				<div class="zo-ssc-panel">
					<h3 class="zo-ssc-subtitle">Route Progress</h3>
					<div class="zo-ssc-route"><span class="zo-ssc-route-fill"></span></div>
					<p class="zo-ssc-route-text" style="margin:10px 0 0;">Distance to city: 0 of 24</p>

					<h3 class="zo-ssc-subtitle" style="margin-top:14px;">Daily Conditions</h3>
					<p class="zo-ssc-weather"></p>

					<h3 class="zo-ssc-subtitle" style="margin-top:14px;">Camp Offer</h3>
					<p class="zo-ssc-offer"></p>

					<div class="zo-ssc-actions">
						<button type="button" class="zo-ssc-button zo-ssc-button--travel">Travel</button>
						<button type="button" class="zo-ssc-button zo-ssc-button--scout">Scout</button>
						<button type="button" class="zo-ssc-button zo-ssc-button--trade">Trade</button>
						<button type="button" class="zo-ssc-button zo-ssc-button--rest">Rest</button>
					</div>

					<button type="button" class="zo-ssc-button zo-ssc-button--reset">Reset Caravan</button>
				</div>

				<div class="zo-ssc-panel">
					<h3 class="zo-ssc-subtitle">Guide Log</h3>
					<p class="zo-ssc-status" aria-live="polite"></p>
					<ul class="zo-ssc-log"></ul>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug' => 'sandstorm-caravan',
	'name' => 'Sandstorm Caravan',
	'author' => 'asker',
	'description' => 'A desert survival game where you trade water, clues, and tools to lead a caravan through shifting sandstorms.',
	'render_callback' => 'zo_game_sandstorm_caravan_render',
	'inline_style' => $css,
	'inline_script' => $js,
);
