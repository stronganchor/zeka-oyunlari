<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--shop-builder {
	max-width: 820px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d9e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--shop-builder .zo-sb-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}

.zo-game-root--shop-builder .zo-sb-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--shop-builder .zo-sb-top {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 10px;
	margin-bottom: 16px;
}

.zo-game-root--shop-builder .zo-sb-stat {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
	text-align: center;
}

.zo-game-root--shop-builder .zo-sb-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--shop-builder .zo-sb-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
	word-break: break-word;
}

.zo-game-root--shop-builder .zo-sb-main {
	display: grid;
	grid-template-columns: 1.15fr 0.85fr;
	gap: 16px;
	align-items: start;
}

.zo-game-root--shop-builder .zo-sb-panel {
	border: 2px solid #dbe4ee;
	border-radius: 16px;
	padding: 16px;
	background: #fbfdff;
	box-sizing: border-box;
}

.zo-game-root--shop-builder .zo-sb-panel-title {
	margin: 0 0 12px;
	font-size: 22px;
	line-height: 1.2;
	color: #1f2937;
	text-align: center;
}

.zo-game-root--shop-builder .zo-sb-shop-card {
	border: 2px dashed #c8d4e0;
	border-radius: 16px;
	padding: 18px;
	background: #f8fbff;
	text-align: center;
	margin-bottom: 12px;
}

.zo-game-root--shop-builder .zo-sb-shop-level {
	font-size: 18px;
	font-weight: 700;
	color: #2563eb;
	margin-bottom: 8px;
}

.zo-game-root--shop-builder .zo-sb-shop-name {
	font-size: 36px;
	font-weight: 700;
	line-height: 1.15;
	color: #111827;
	margin-bottom: 10px;
}

.zo-game-root--shop-builder .zo-sb-shop-desc {
	font-size: 15px;
	line-height: 1.5;
	color: #4b5563;
}

.zo-game-root--shop-builder .zo-sb-work-area {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	margin-top: 12px;
}

.zo-game-root--shop-builder .zo-sb-button {
	border: 0;
	border-radius: 12px;
	padding: 13px 14px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--shop-builder .zo-sb-button--earn {
	background: #2997aa;
	color: #ffffff;
	font-size: 17px;
}

.zo-game-root--shop-builder .zo-sb-button--upgrade {
	background: #10b981;
	color: #ffffff;
}

.zo-game-root--shop-builder .zo-sb-button--boost {
	background: #8b5cf6;
	color: #ffffff;
}

.zo-game-root--shop-builder .zo-sb-button--restart {
	background: #e5e7eb;
	color: #111827;
	width: 100%;
	margin-top: 12px;
}

.zo-game-root--shop-builder .zo-sb-button:disabled {
	opacity: 0.55;
	cursor: default;
}

.zo-game-root--shop-builder .zo-sb-status {
	min-height: 24px;
	margin-top: 12px;
	text-align: center;
	font-size: 15px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--shop-builder .zo-sb-status.is-good {
	color: #15803d;
}

.zo-game-root--shop-builder .zo-sb-status.is-warn {
	color: #d97706;
}

.zo-game-root--shop-builder .zo-sb-status.is-info {
	color: #2563eb;
}

.zo-game-root--shop-builder .zo-sb-upgrades {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
}

.zo-game-root--shop-builder .zo-sb-upgrade {
	border: 2px solid #d7e0ea;
	border-radius: 14px;
	padding: 12px;
	background: #f4f7fb;
}

.zo-game-root--shop-builder .zo-sb-upgrade-title {
	font-size: 17px;
	font-weight: 700;
	color: #111827;
	margin-bottom: 5px;
}

.zo-game-root--shop-builder .zo-sb-upgrade-text {
	font-size: 14px;
	line-height: 1.45;
	color: #4b5563;
	margin-bottom: 10px;
}

.zo-game-root--shop-builder .zo-sb-upgrade-meta {
	font-size: 14px;
	font-weight: 700;
	color: #1f2937;
	margin-bottom: 10px;
}

.zo-game-root--shop-builder .zo-sb-log {
	margin-top: 12px;
	border-radius: 14px;
	background: #f8fafc;
	border: 2px solid #dbe4ee;
	padding: 12px;
	font-size: 14px;
	line-height: 1.5;
	color: #1f2937;
	min-height: 110px;
}

.zo-game-root--shop-builder .zo-sb-log-title {
	font-weight: 700;
	margin-bottom: 6px;
}

.zo-game-root--shop-builder .zo-sb-log-list {
	margin: 0;
	padding-left: 18px;
}

.zo-game-root--shop-builder .zo-sb-log-list li + li {
	margin-top: 4px;
}

@media (max-width: 760px) {
	.zo-game-root.zo-game-root--shop-builder {
		padding: 16px;
	}

	.zo-game-root--shop-builder .zo-sb-title {
		font-size: 25px;
	}

	.zo-game-root--shop-builder .zo-sb-top,
	.zo-game-root--shop-builder .zo-sb-main,
	.zo-game-root--shop-builder .zo-sb-work-area {
		grid-template-columns: 1fr;
	}

	.zo-game-root--shop-builder .zo-sb-shop-name {
		font-size: 30px;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--shop-builder');

	games.forEach(function (game) {
		const coinsEl = game.querySelector('.zo-sb-coins');
		const levelEl = game.querySelector('.zo-sb-level');
		const incomeEl = game.querySelector('.zo-sb-income');
		const clicksEl = game.querySelector('.zo-sb-clicks');

		const shopLevelEl = game.querySelector('.zo-sb-shop-level');
		const shopNameEl = game.querySelector('.zo-sb-shop-name');
		const shopDescEl = game.querySelector('.zo-sb-shop-desc');

		const earnButton = game.querySelector('.zo-sb-button--earn');
		const boostButton = game.querySelector('.zo-sb-button--boost');
		const restartButton = game.querySelector('.zo-sb-button--restart');
		const statusEl = game.querySelector('.zo-sb-status');
		const logListEl = game.querySelector('.zo-sb-log-list');

		const upgradeButtons = {
			sign: game.querySelector('.zo-sb-button--upgrade-sign'),
			shelf: game.querySelector('.zo-sb-button--upgrade-shelf'),
			helper: game.querySelector('.zo-sb-button--upgrade-helper')
		};

		const shopStages = [
			{ level: 1, name: 'Mini Dükkan', desc: 'Küçük başladın. Tek tek satış yapıyorsun.' },
			{ level: 2, name: 'Mahalle Dükkanı', desc: 'Dükkan büyüyor. Daha çok müşteri geliyor.' },
			{ level: 3, name: 'Süper Dükkan', desc: 'Raflar dolu. Kazanç hızlandı.' },
			{ level: 4, name: 'Büyük Market', desc: 'Artık güçlü bir işletmen var.' },
			{ level: 5, name: 'Dev Alışveriş Merkezi', desc: 'Harika. Şehrin en büyük mağazası oldun.' }
		];

		let coins = 0;
		let level = 1;
		let clickIncome = 1;
		let autoIncome = 0;
		let clicks = 0;
		let timerId = null;

		const upgrades = {
			sign: {
				key: 'sign',
				name: 'Yeni Tabela',
				baseCost: 10,
				count: 0,
				description: 'Daha çok müşteri çeker. Tıklama kazancını artırır.',
				apply: function () {
					clickIncome += 1;
				}
			},
			shelf: {
				key: 'shelf',
				name: 'Yeni Raf',
				baseCost: 25,
				count: 0,
				description: 'Daha çok ürün koyarsın. Tıklama kazancını iyice artırır.',
				apply: function () {
					clickIncome += 2;
				}
			},
			helper: {
				key: 'helper',
				name: 'Yardımcı',
				baseCost: 40,
				count: 0,
				description: 'Sen tıklamasan da para kazandırır.',
				apply: function () {
					autoIncome += 1;
				}
			}
		};

		function formatNumber(value) {
			return String(Math.floor(value));
		}

		function getUpgradeCost(upgrade) {
			return upgrade.baseCost + (upgrade.count * Math.ceil(upgrade.baseCost * 0.65));
		}

		function addLog(message) {
			const item = document.createElement('li');
			item.textContent = message;
			logListEl.insertBefore(item, logListEl.firstChild);

			while (logListEl.children.length > 6) {
				logListEl.removeChild(logListEl.lastChild);
			}
		}

		function setStatus(message, type) {
			statusEl.textContent = message;
			statusEl.className = 'zo-sb-status';
			if (type) {
				statusEl.classList.add(type);
			}
		}

		function getStageForLevel(currentLevel) {
			if (currentLevel >= 12) {
				return shopStages[4];
			}
			if (currentLevel >= 8) {
				return shopStages[3];
			}
			if (currentLevel >= 5) {
				return shopStages[2];
			}
			if (currentLevel >= 3) {
				return shopStages[1];
			}
			return shopStages[0];
		}

		function refreshLevel() {
			const newLevel = 1 + Math.floor((upgrades.sign.count + upgrades.shelf.count + upgrades.helper.count) / 2);
			level = Math.min(12, newLevel);
		}

		function updateUpgradeCards() {
			Object.keys(upgrades).forEach(function (key) {
				const upgrade = upgrades[key];
				const cost = getUpgradeCost(upgrade);
				const button = upgradeButtons[key];

				if (!button) {
					return;
				}

				button.textContent = upgrade.name + ' Al (' + cost + ')';

				if (coins < cost) {
					button.disabled = true;
				} else {
					button.disabled = false;
				}

				const wrap = button.closest('.zo-sb-upgrade');
				if (wrap) {
					const meta = wrap.querySelector('.zo-sb-upgrade-meta');
					if (meta) {
						meta.textContent = 'Seviye: ' + upgrade.count + ' • Fiyat: ' + cost;
					}
				}
			});
		}

		function updateUI() {
			refreshLevel();

			const stage = getStageForLevel(level);

			coinsEl.textContent = formatNumber(coins);
			levelEl.textContent = formatNumber(level);
			incomeEl.textContent = formatNumber(clickIncome) + ' / ' + formatNumber(autoIncome);
			clicksEl.textContent = formatNumber(clicks);

			shopLevelEl.textContent = 'Dükkan Seviyesi ' + formatNumber(level);
			shopNameEl.textContent = stage.name;
			shopDescEl.textContent = stage.desc;

			updateUpgradeCards();
		}

		function earnCoins(amount) {
			coins += amount;
			updateUI();
		}

		function buyUpgrade(key) {
			const upgrade = upgrades[key];
			if (!upgrade) {
				return;
			}

			const cost = getUpgradeCost(upgrade);

			if (coins < cost) {
				setStatus('Yeterli paran yok.', 'is-warn');
				return;
			}

			coins -= cost;
			upgrade.count += 1;
			upgrade.apply();
			updateUI();
			setStatus(upgrade.name + ' alındı.', 'is-good');
			addLog(upgrade.name + ' satın alındı.');
		}

		function clickEarn() {
			clicks += 1;
			earnCoins(clickIncome);
			setStatus('Satış yaptın. +' + formatNumber(clickIncome) + ' para.', 'is-info');
		}

		function megaBoost() {
			const bonus = Math.max(10, clickIncome * 5);
			earnCoins(bonus);
			setStatus('Hızlı kampanya yaptın. +' + formatNumber(bonus) + ' para.', 'is-good');
			addLog('Kampanya kazancı: +' + formatNumber(bonus));
		}

		function startAutoIncome() {
			if (timerId) {
				clearInterval(timerId);
			}

			timerId = setInterval(function () {
				if (autoIncome > 0) {
					coins += autoIncome;
					updateUI();
				}
			}, 1000);
		}

		function resetGame() {
			coins = 0;
			level = 1;
			clickIncome = 1;
			autoIncome = 0;
			clicks = 0;

			Object.keys(upgrades).forEach(function (key) {
				upgrades[key].count = 0;
			});

			logListEl.innerHTML = '';
			addLog('Dükkan yeniden kuruldu.');
			setStatus('Hazır. Satış yaparak para kazan.', 'is-info');
			updateUI();
		}

		earnButton.addEventListener('click', clickEarn);
		boostButton.addEventListener('click', megaBoost);
		restartButton.addEventListener('click', resetGame);

		Object.keys(upgradeButtons).forEach(function (key) {
			const button = upgradeButtons[key];
			if (button) {
				button.addEventListener('click', function () {
					buyUpgrade(key);
				});
			}
		});

		startAutoIncome();
		resetGame();
	});
});
JS;

if (!function_exists('zo_game_shop_builder_render')) {
	function zo_game_shop_builder_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-shop-builder-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--shop-builder" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-sb-title">Shop Builder</h2>
			<p class="zo-sb-desc">Satış yap, para kazan, yükseltmeler al ve küçük dükkanı büyük bir mağazaya çevir.</p>

			<div class="zo-sb-top">
				<div class="zo-sb-stat">
					<span class="zo-sb-stat-label">Para</span>
					<span class="zo-sb-stat-value zo-sb-coins">0</span>
				</div>
				<div class="zo-sb-stat">
					<span class="zo-sb-stat-label">Seviye</span>
					<span class="zo-sb-stat-value zo-sb-level">1</span>
				</div>
				<div class="zo-sb-stat">
					<span class="zo-sb-stat-label">Tıklama / Otomatik</span>
					<span class="zo-sb-stat-value zo-sb-income">1 / 0</span>
				</div>
				<div class="zo-sb-stat">
					<span class="zo-sb-stat-label">Satış Sayısı</span>
					<span class="zo-sb-stat-value zo-sb-clicks">0</span>
				</div>
			</div>

			<div class="zo-sb-main">
				<div class="zo-sb-panel">
					<h3 class="zo-sb-panel-title">Dükkanın</h3>

					<div class="zo-sb-shop-card">
						<div class="zo-sb-shop-level">Dükkan Seviyesi 1</div>
						<div class="zo-sb-shop-name">Mini Dükkan</div>
						<div class="zo-sb-shop-desc">Küçük başladın. Tek tek satış yapıyorsun.</div>
					</div>

					<div class="zo-sb-work-area">
						<button type="button" class="zo-sb-button zo-sb-button--earn">Satış Yap</button>
						<button type="button" class="zo-sb-button zo-sb-button--boost">Kampanya Yap</button>
					</div>

					<div class="zo-sb-status" aria-live="polite">Hazır. Satış yaparak para kazan.</div>

					<div class="zo-sb-log">
						<div class="zo-sb-log-title">Son Olaylar</div>
						<ul class="zo-sb-log-list"></ul>
					</div>

					<button type="button" class="zo-sb-button zo-sb-button--restart">Baştan Başla</button>
				</div>

				<div class="zo-sb-panel">
					<h3 class="zo-sb-panel-title">Yükseltmeler</h3>

					<div class="zo-sb-upgrades">
						<div class="zo-sb-upgrade">
							<div class="zo-sb-upgrade-title">Yeni Tabela</div>
							<div class="zo-sb-upgrade-text">Daha çok müşteri çeker. Tıklama kazancını artırır.</div>
							<div class="zo-sb-upgrade-meta">Seviye: 0 • Fiyat: 10</div>
							<button type="button" class="zo-sb-button zo-sb-button--upgrade zo-sb-button--upgrade-sign">Yeni Tabela Al (10)</button>
						</div>

						<div class="zo-sb-upgrade">
							<div class="zo-sb-upgrade-title">Yeni Raf</div>
							<div class="zo-sb-upgrade-text">Daha çok ürün koyarsın. Tıklama kazancını iyice artırır.</div>
							<div class="zo-sb-upgrade-meta">Seviye: 0 • Fiyat: 25</div>
							<button type="button" class="zo-sb-button zo-sb-button--upgrade zo-sb-button--upgrade-shelf">Yeni Raf Al (25)</button>
						</div>

						<div class="zo-sb-upgrade">
							<div class="zo-sb-upgrade-title">Yardımcı</div>
							<div class="zo-sb-upgrade-text">Sen tıklamasan da para kazandırır.</div>
							<div class="zo-sb-upgrade-meta">Seviye: 0 • Fiyat: 40</div>
							<button type="button" class="zo-sb-button zo-sb-button--upgrade zo-sb-button--upgrade-helper">Yardımcı Al (40)</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'shop-builder',
	'name'            => 'Shop Builder',
	'author'          => 'Asker',
	'description'     => 'Satış yaparak para kazanılan ve yükseltmelerle büyüyen basit bir dükkan kurma oyunu.',
	'render_callback' => 'zo_game_shop_builder_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);