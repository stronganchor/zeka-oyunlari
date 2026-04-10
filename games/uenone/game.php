<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root {
	max-width: 760px;
	margin: 0 auto;
	padding: 16px;
	text-align: center;
	font-family: Arial, sans-serif;
	box-sizing: border-box;
}

.zo-game-root * {
	box-sizing: border-box;
}

.zo-mini-manager-wrap {
	background: #f6fbff;
	border: 2px solid #87b7d8;
	border-radius: 18px;
	padding: 18px;
	box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.zo-mini-manager-title {
	margin: 0 0 8px;
	font-size: 28px;
	line-height: 1.2;
}

.zo-mini-manager-text {
	margin: 0 0 14px;
	font-size: 16px;
	line-height: 1.5;
}

.zo-mini-manager-topbar {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 16px;
}

.zo-mini-manager-pill {
	background: #ffffff;
	border: 1px solid #87b7d8;
	border-radius: 999px;
	padding: 8px 12px;
	font-size: 14px;
	font-weight: bold;
}

.zo-mini-manager-layout {
	display: grid;
	grid-template-columns: 1.15fr 0.85fr;
	gap: 16px;
	align-items: start;
	margin-top: 12px;
}

.zo-mini-manager-panel {
	background: #ffffff;
	border: 2px solid #d8e7f2;
	border-radius: 16px;
	padding: 14px;
	text-align: left;
}

.zo-mini-manager-panel-title {
	margin: 0 0 12px;
	font-size: 18px;
	text-align: center;
}

.zo-mini-manager-shop {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
}

.zo-mini-manager-card {
	border: 2px solid #d8e7f2;
	border-radius: 14px;
	padding: 12px;
	text-align: center;
	background: #fbfdff;
}

.zo-mini-manager-emoji {
	font-size: 34px;
	line-height: 1;
	margin-bottom: 6px;
}

.zo-mini-manager-name {
	font-weight: bold;
	font-size: 16px;
	margin-bottom: 6px;
}

.zo-mini-manager-small {
	font-size: 13px;
	line-height: 1.4;
	margin-bottom: 8px;
}

.zo-mini-manager-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 10px 12px;
	font-size: 15px;
	font-weight: bold;
	cursor: pointer;
	background: #4f8db4;
	color: #fff;
	width: 100%;
}

.zo-mini-manager-btn:hover,
.zo-mini-manager-btn:focus {
	opacity: 0.92;
}

.zo-mini-manager-btn:disabled {
	opacity: 0.6;
	cursor: default;
}

.zo-mini-manager-actions {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
	margin-top: 10px;
}

.zo-mini-manager-big-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #2e7b57;
	color: #fff;
	width: 100%;
}

.zo-mini-manager-big-btn:hover,
.zo-mini-manager-big-btn:focus {
	opacity: 0.92;
}

.zo-mini-manager-big-btn.is-alt {
	background: #8a6436;
}

.zo-mini-manager-stats {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
}

.zo-mini-manager-stat {
	background: #f6fbff;
	border: 1px solid #d8e7f2;
	border-radius: 12px;
	padding: 10px;
	text-align: center;
	font-weight: bold;
	font-size: 14px;
}

.zo-mini-manager-log {
	margin-top: 12px;
	background: #f9fcff;
	border: 1px solid #d8e7f2;
	border-radius: 12px;
	padding: 10px;
	min-height: 76px;
	font-size: 14px;
	line-height: 1.5;
}

.zo-mini-manager-instructions {
	margin-top: 14px;
	background: #fffdf5;
	border: 1px solid #ead9a5;
	border-radius: 12px;
	padding: 12px;
	text-align: left;
	font-size: 14px;
	line-height: 1.6;
}

.zo-mini-manager-controls {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
	gap: 10px;
	margin-top: 14px;
}

.zo-mini-manager-control-btn {
	appearance: none;
	border: 0;
	border-radius: 12px;
	padding: 12px 16px;
	font-size: 16px;
	font-weight: bold;
	cursor: pointer;
	background: #5f6fd1;
	color: #fff;
	min-width: 140px;
}

.zo-mini-manager-control-btn:hover,
.zo-mini-manager-control-btn:focus {
	opacity: 0.92;
}

.zo-mini-manager-status {
	min-height: 24px;
	margin-top: 10px;
	font-size: 15px;
	font-weight: bold;
}

@media (max-width: 680px) {
	.zo-mini-manager-layout {
		grid-template-columns: 1fr;
	}

	.zo-mini-manager-shop {
		grid-template-columns: 1fr;
	}

	.zo-mini-manager-actions,
	.zo-mini-manager-stats {
		grid-template-columns: 1fr;
	}

	.zo-mini-manager-title {
		font-size: 24px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--mini-manager-style');

	games.forEach(function (game) {
		const dayEl = game.querySelector('.zo-mini-manager-day');
		const moneyEl = game.querySelector('.zo-mini-manager-money');
		const customersEl = game.querySelector('.zo-mini-manager-customers');
		const happinessEl = game.querySelector('.zo-mini-manager-happiness');
		const workersEl = game.querySelector('.zo-mini-manager-workers');
		const productEl = game.querySelector('.zo-mini-manager-product');
		const upgradesEl = game.querySelector('.zo-mini-manager-upgrades');
		const logEl = game.querySelector('.zo-mini-manager-log');
		const statusEl = game.querySelector('.zo-mini-manager-status');

		const nextDayBtn = game.querySelector('.zo-mini-manager-next-day');
		const advertiseBtn = game.querySelector('.zo-mini-manager-advertise');
		const restartBtn = game.querySelector('.zo-mini-manager-restart');

		const buyButtons = game.querySelectorAll('.zo-mini-manager-buy');

		let state = {};

		function clamp(value, min, max) {
			return Math.max(min, Math.min(max, value));
		}

		function resetGame() {
			state = {
				day: 1,
				money: 100,
				customers: 0,
				happiness: 50,
				workers: 1,
				productLevel: 1,
				advertisingBoost: 0,
				decorLevel: 0,
				toolsLevel: 0,
				playedDays: 0
			};

			updateUI();
			setLog('Welcome, manager. Your small shop is ready.');
			setStatus('Buy upgrades and press Next Day to run the shop.');
		}

		function updateUI() {
			dayEl.textContent = 'Day: ' + state.day;
			moneyEl.textContent = 'Money: $' + state.money;
			customersEl.textContent = 'Customers: ' + state.customers;
			happinessEl.textContent = 'Happiness: ' + state.happiness;
			workersEl.textContent = 'Workers: ' + state.workers;
			productEl.textContent = 'Product Level: ' + state.productLevel;
			upgradesEl.textContent = 'Upgrades: ' + (state.decorLevel + state.toolsLevel);

			buyButtons.forEach(function (btn) {
				const cost = parseInt(btn.getAttribute('data-cost'), 10);
				btn.disabled = state.money < cost;
			});
		}

		function setLog(text) {
			logEl.textContent = text;
		}

		function setStatus(text) {
			statusEl.textContent = text;
		}

		function buyItem(type, cost) {
			if (state.money < cost) {
				setStatus('Not enough money.');
				return;
			}

			state.money -= cost;

			if (type === 'worker') {
				state.workers += 1;
				setLog('You hired a new worker. Your team is bigger.');
			} else if (type === 'product') {
				state.productLevel += 1;
				setLog('You improved your product. Customers will like it more.');
			} else if (type === 'decor') {
				state.decorLevel += 1;
				state.happiness = clamp(state.happiness + 8, 0, 100);
				setLog('You upgraded the shop decoration. The place looks nicer.');
			} else if (type === 'tools') {
				state.toolsLevel += 1;
				setLog('You bought better tools. Work will go faster.');
			}

			updateUI();
			setStatus('Upgrade bought.');
		}

		function advertise() {
			if (state.money < 20) {
				setStatus('You need $20 to advertise.');
				return;
			}

			state.money -= 20;
			state.advertisingBoost += 8;
			updateUI();
			setLog('You paid for advertising. More people may come next day.');
			setStatus('Advertising activated.');
		}

		function runDay() {
			const baseCustomers = 6 + state.workers * 3 + state.productLevel * 2 + state.decorLevel;
			const randomBonus = Math.floor(Math.random() * 6);
			const totalCustomers = baseCustomers + randomBonus + state.advertisingBoost;

			const earnPerCustomer = 3 + state.productLevel + state.toolsLevel;
			const totalEarned = totalCustomers * earnPerCustomer;

			const wageCost = state.workers * 8;
			const supplyCost = 12 + state.productLevel * 4;
			const decorBonus = state.decorLevel * 2;
			const happinessChange = Math.floor(totalCustomers / 6) + decorBonus - 3;

			state.customers = totalCustomers;
			state.money += totalEarned - wageCost - supplyCost;
			state.happiness = clamp(state.happiness + happinessChange, 0, 100);
			state.advertisingBoost = 0;
			state.playedDays += 1;

			if (state.happiness >= 80) {
				state.money += 15;
				setLog('Great day. Happy customers gave your shop a bonus.');
			} else if (state.happiness <= 20) {
				state.money = Math.max(0, state.money - 10);
				setLog('Bad day. Unhappy customers hurt your business.');
			} else {
				setLog(
					'Day ' + state.day +
					': ' + totalCustomers + ' customers, earned $' + totalEarned +
					', costs $' + (wageCost + supplyCost) + '.'
				);
			}

			if (state.money < 0) {
				state.money = 0;
			}

			state.day += 1;
			updateUI();

			if (state.money === 0 && state.playedDays > 2) {
				setStatus('Your shop is struggling. Buy carefully and keep customers happy.');
			} else if (state.money >= 300) {
				setStatus('Excellent. Your mini business is growing fast.');
			} else {
				setStatus('New day ready. Choose your next move.');
			}
		}

		buyButtons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				const type = btn.getAttribute('data-type');
				const cost = parseInt(btn.getAttribute('data-cost'), 10);
				buyItem(type, cost);
			});
		});

		advertiseBtn.addEventListener('click', advertise);
		nextDayBtn.addEventListener('click', runDay);
		restartBtn.addEventListener('click', resetGame);

		resetGame();
	});
});
JS;

if (!function_exists('zo_game_mini_manager_style_render')) {
	function zo_game_mini_manager_style_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mini-manager-style-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--mini-manager-style" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-mini-manager-wrap">
				<h3 class="zo-mini-manager-title">Mini Manager Style</h3>
				<p class="zo-mini-manager-text">Run a tiny shop. Buy upgrades. Keep customers happy. Grow your money.</p>

				<div class="zo-mini-manager-topbar">
					<div class="zo-mini-manager-pill zo-mini-manager-day">Day: 1</div>
					<div class="zo-mini-manager-pill zo-mini-manager-money">Money: $100</div>
					<div class="zo-mini-manager-pill zo-mini-manager-customers">Customers: 0</div>
					<div class="zo-mini-manager-pill zo-mini-manager-happiness">Happiness: 50</div>
				</div>

				<div class="zo-mini-manager-layout">
					<div class="zo-mini-manager-panel">
						<h4 class="zo-mini-manager-panel-title">Shop Upgrades</h4>

						<div class="zo-mini-manager-shop">
							<div class="zo-mini-manager-card">
								<div class="zo-mini-manager-emoji">🧑‍🍳</div>
								<div class="zo-mini-manager-name">Hire Worker</div>
								<div class="zo-mini-manager-small">More workers bring more customers.<br>Cost: $50</div>
								<button type="button" class="zo-mini-manager-btn zo-mini-manager-buy" data-type="worker" data-cost="50">Buy</button>
							</div>

							<div class="zo-mini-manager-card">
								<div class="zo-mini-manager-emoji">⭐</div>
								<div class="zo-mini-manager-name">Better Product</div>
								<div class="zo-mini-manager-small">Better products make each sale worth more.<br>Cost: $40</div>
								<button type="button" class="zo-mini-manager-btn zo-mini-manager-buy" data-type="product" data-cost="40">Buy</button>
							</div>

							<div class="zo-mini-manager-card">
								<div class="zo-mini-manager-emoji">🪴</div>
								<div class="zo-mini-manager-name">Nice Decoration</div>
								<div class="zo-mini-manager-small">A prettier shop makes customers happier.<br>Cost: $30</div>
								<button type="button" class="zo-mini-manager-btn zo-mini-manager-buy" data-type="decor" data-cost="30">Buy</button>
							</div>

							<div class="zo-mini-manager-card">
								<div class="zo-mini-manager-emoji">🧰</div>
								<div class="zo-mini-manager-name">Better Tools</div>
								<div class="zo-mini-manager-small">Better tools improve your daily earnings.<br>Cost: $35</div>
								<button type="button" class="zo-mini-manager-btn zo-mini-manager-buy" data-type="tools" data-cost="35">Buy</button>
							</div>
						</div>

						<div class="zo-mini-manager-actions">
							<button type="button" class="zo-mini-manager-big-btn zo-mini-manager-next-day">Next Day</button>
							<button type="button" class="zo-mini-manager-big-btn is-alt zo-mini-manager-advertise">Advertise $20</button>
						</div>
					</div>

					<div class="zo-mini-manager-panel">
						<h4 class="zo-mini-manager-panel-title">Manager Info</h4>

						<div class="zo-mini-manager-stats">
							<div class="zo-mini-manager-stat zo-mini-manager-workers">Workers: 1</div>
							<div class="zo-mini-manager-stat zo-mini-manager-product">Product Level: 1</div>
							<div class="zo-mini-manager-stat zo-mini-manager-upgrades">Upgrades: 0</div>
							<div class="zo-mini-manager-stat">Goal: Grow</div>
						</div>

						<div class="zo-mini-manager-log">Welcome, manager. Your small shop is ready.</div>

						<div class="zo-mini-manager-instructions">
							<strong>How to play:</strong><br>
							1. Start with $100.<br>
							2. Buy workers, products, decoration, or tools.<br>
							3. Press <strong>Next Day</strong> to run the shop.<br>
							4. Customers come in, you earn money, and you also pay daily costs.<br>
							5. Use <strong>Advertise</strong> if you want more customers on the next day.<br>
							6. Keep happiness high and grow your business as long as you can.
						</div>
					</div>
				</div>

				<div class="zo-mini-manager-controls">
					<button type="button" class="zo-mini-manager-control-btn zo-mini-manager-restart">Restart Game</button>
				</div>

				<div class="zo-mini-manager-status">Buy upgrades and press Next Day to run the shop.</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'mini-manager-style',
	'name'            => 'Mini Manager Style',
	'author'          => 'Arslan',
	'description'     => 'A simple shop management game with clear instructions.',
	'render_callback' => 'zo_game_mini_manager_style_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);