<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--tr-search-launcher {
	max-width: 760px;
	margin: 0 auto;
	padding: 20px;
	border: 2px solid #d8e2ec;
	border-radius: 18px;
	background: #ffffff;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
}

.zo-game-root--tr-search-launcher .zo-tsl-title {
	margin: 0 0 10px;
	font-size: 30px;
	line-height: 1.2;
	text-align: center;
	color: #1f2937;
}

.zo-game-root--tr-search-launcher .zo-tsl-desc {
	margin: 0 0 18px;
	font-size: 15px;
	line-height: 1.5;
	text-align: center;
	color: #4b5563;
}

.zo-game-root--tr-search-launcher .zo-tsl-panel {
	display: grid;
	grid-template-columns: 1fr;
	gap: 14px;
}

.zo-game-root--tr-search-launcher .zo-tsl-field {
	display: flex;
	flex-direction: column;
	gap: 6px;
}

.zo-game-root--tr-search-launcher .zo-tsl-label {
	font-size: 15px;
	font-weight: 700;
	color: #1f2937;
}

.zo-game-root--tr-search-launcher .zo-tsl-input {
	width: 100%;
	padding: 13px 14px;
	border: 2px solid #c8d4e0;
	border-radius: 12px;
	font-size: 17px;
	background: #f8fbff;
	color: #111827;
	box-sizing: border-box;
}

.zo-game-root--tr-search-launcher .zo-tsl-actions {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--tr-search-launcher .zo-tsl-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 14px;
	font-size: 16px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--tr-search-launcher .zo-tsl-button--open {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--tr-search-launcher .zo-tsl-button--shuffle {
	background: #f59e0b;
	color: #ffffff;
}

.zo-game-root--tr-search-launcher .zo-tsl-button--reset {
	background: #e5e7eb;
	color: #111827;
}

.zo-game-root--tr-search-launcher .zo-tsl-sites {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--tr-search-launcher .zo-tsl-site {
	border: 2px solid #d6dee8;
	border-radius: 14px;
	padding: 12px;
	background: #f8fafc;
	display: flex;
	align-items: center;
	gap: 10px;
	box-sizing: border-box;
}

.zo-game-root--tr-search-launcher .zo-tsl-check {
	width: 18px;
	height: 18px;
	margin: 0;
	flex: 0 0 auto;
}

.zo-game-root--tr-search-launcher .zo-tsl-site-name {
	font-size: 15px;
	font-weight: 700;
	color: #1f2937;
}

.zo-game-root--tr-search-launcher .zo-tsl-stats {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--tr-search-launcher .zo-tsl-stat {
	border-radius: 14px;
	padding: 14px;
	background: #f4f7fb;
	border: 2px solid #d7e0ea;
	text-align: center;
}

.zo-game-root--tr-search-launcher .zo-tsl-stat-label {
	display: block;
	font-size: 13px;
	font-weight: 700;
	color: #51606f;
	margin-bottom: 4px;
}

.zo-game-root--tr-search-launcher .zo-tsl-stat-value {
	display: block;
	font-size: 24px;
	font-weight: 700;
	line-height: 1.1;
	color: #111827;
}

.zo-game-root--tr-search-launcher .zo-tsl-status {
	min-height: 24px;
	padding: 12px;
	border-radius: 12px;
	background: #f8fbff;
	border: 2px dashed #c8d4e0;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
	color: #374151;
}

.zo-game-root--tr-search-launcher .zo-tsl-links {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--tr-search-launcher .zo-tsl-link {
	display: block;
	text-decoration: none;
	text-align: center;
	padding: 12px 14px;
	border-radius: 12px;
	background: #eef6f8;
	border: 2px solid #c7dde2;
	font-size: 14px;
	font-weight: 700;
	color: #0f4c5c;
	box-sizing: border-box;
}

@media (max-width: 640px) {
	.zo-game-root.zo-game-root--tr-search-launcher {
		padding: 16px;
	}

	.zo-game-root--tr-search-launcher .zo-tsl-title {
		font-size: 25px;
	}

	.zo-game-root--tr-search-launcher .zo-tsl-actions,
	.zo-game-root--tr-search-launcher .zo-tsl-sites,
	.zo-game-root--tr-search-launcher .zo-tsl-stats,
	.zo-game-root--tr-search-launcher .zo-tsl-links {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--tr-search-launcher');

	games.forEach(function (game) {
		const input = game.querySelector('.zo-tsl-input');
		const openButton = game.querySelector('.zo-tsl-button--open');
		const shuffleButton = game.querySelector('.zo-tsl-button--shuffle');
		const resetButton = game.querySelector('.zo-tsl-button--reset');
		const status = game.querySelector('.zo-tsl-status');
		const sitesCount = game.querySelector('.zo-tsl-stat-value--sites');
		const launchesCount = game.querySelector('.zo-tsl-stat-value--launches');
		const pointsCount = game.querySelector('.zo-tsl-stat-value--points');
		const linksWrap = game.querySelector('.zo-tsl-links');
		const siteBoxes = Array.prototype.slice.call(game.querySelectorAll('.zo-tsl-check'));

		let launches = 0;
		let points = 0;

		const siteMap = {
			trendyol: {
				label: 'Trendyol',
				url: function (q) { return 'https://www.trendyol.com/sr?q=' + encodeURIComponent(q); }
			},
			n11: {
				label: 'N11',
				url: function (q) { return 'https://www.n11.com/arama?q=' + encodeURIComponent(q); }
			},
			hepsiburada: {
				label: 'Hepsiburada',
				url: function (q) { return 'https://www.hepsiburada.com/ara?q=' + encodeURIComponent(q); }
			},
			ciceksepeti: {
				label: 'Çiçeksepeti',
				url: function (q) { return 'https://www.ciceksepeti.com/arama?query=' + encodeURIComponent(q); }
			},
			pttavm: {
				label: 'PttAVM',
				url: function (q) { return 'https://www.pttavm.com/arama?q=' + encodeURIComponent(q); }
			},
			sahibinden: {
				label: 'Sahibinden',
				url: function (q) { return 'https://www.sahibinden.com/kelime?query=' + encodeURIComponent(q); }
			},
			dolap: {
				label: 'Dolap',
				url: function (q) { return 'https://www.dolap.com/ara?q=' + encodeURIComponent(q); }
			},
			gardrops: {
				label: 'Gardrops',
				url: function (q) { return 'https://www.gardrops.com/search?q=' + encodeURIComponent(q); }
			},
			migros: {
				label: 'Migros',
				url: function (q) { return 'https://www.migros.com.tr/arama?q=' + encodeURIComponent(q); }
			}
		};

		function getSelectedSites() {
			return siteBoxes
				.filter(function (box) { return box.checked; })
				.map(function (box) { return box.value; });
		}

		function updateStats() {
			sitesCount.textContent = String(getSelectedSites().length);
			launchesCount.textContent = String(launches);
			pointsCount.textContent = String(points);
		}

		function renderLinks(query, selectedSites) {
			linksWrap.innerHTML = '';

			selectedSites.forEach(function (siteKey) {
				const site = siteMap[siteKey];
				if (!site) {
					return;
				}

				const link = document.createElement('a');
				link.className = 'zo-tsl-link';
				link.href = site.url(query);
				link.target = '_blank';
				link.rel = 'noopener noreferrer';
				link.textContent = site.label + ' aramasını aç';
				linksWrap.appendChild(link);
			});
		}

		function setStatus(message) {
			status.textContent = message;
		}

		function openSearches() {
			const query = input.value.trim();
			const selectedSites = getSelectedSites();

			if (!query) {
				setStatus('Önce bir ürün adı yaz.');
				return;
			}

			if (!selectedSites.length) {
				setStatus('En az bir site seç.');
				return;
			}

			selectedSites.forEach(function (siteKey, index) {
				const site = siteMap[siteKey];
				if (!site) {
					return;
				}

				const targetUrl = site.url(query);

				if (index === 0) {
					window.open(targetUrl, '_blank', 'noopener');
				} else {
					setTimeout(function () {
						window.open(targetUrl, '_blank', 'noopener');
					}, index * 120);
				}
			});

			launches += 1;
			points += selectedSites.length;
			updateStats();
			renderLinks(query, selectedSites);
			setStatus('Arama sekmeleri açıldı: ' + selectedSites.length + ' site.');
		}

		function shuffleSites() {
			const boxes = siteBoxes.slice();

			boxes.forEach(function (box) {
				box.checked = false;
			});

			const shuffled = boxes.slice().sort(function () {
				return Math.random() - 0.5;
			});

			const pickCount = Math.max(2, Math.min(5, Math.floor(Math.random() * 4) + 2));

			shuffled.slice(0, pickCount).forEach(function (box) {
				box.checked = true;
			});

			updateStats();
			setStatus('Rastgele site seçimi yapıldı.');
		}

		function resetTool() {
			input.value = '';
			siteBoxes.forEach(function (box) {
				box.checked = box.hasAttribute('data-default');
			});
			launches = 0;
			points = 0;
			linksWrap.innerHTML = '';
			updateStats();
			setStatus('Hazır. Ürün adı yaz ve siteleri aç.');
		}

		openButton.addEventListener('click', openSearches);
		shuffleButton.addEventListener('click', shuffleSites);
		resetButton.addEventListener('click', resetTool);

		input.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				openSearches();
			}
		});

		siteBoxes.forEach(function (box) {
			box.addEventListener('change', updateStats);
		});

		resetTool();
	});
});
JS;

if (!function_exists('zo_game_tr_search_launcher_render')) {
	function zo_game_tr_search_launcher_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-tr-search-launcher-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--tr-search-launcher" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-tsl-title">TR Search Launcher</h2>
			<p class="zo-tsl-desc">Bir ürün adı yaz. İstediğin siteleri seç. Sonra arama sekmelerini hızlıca aç.</p>

			<div class="zo-tsl-panel">
				<div class="zo-tsl-field">
					<label class="zo-tsl-label" for="<?php echo esc_attr($instance_id . '-query'); ?>">Ürün Adı</label>
					<input class="zo-tsl-input" id="<?php echo esc_attr($instance_id . '-query'); ?>" type="text" placeholder="Örnek: patates dilimleyici" />
				</div>

				<div class="zo-tsl-sites">
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="trendyol" data-default checked />
						<span class="zo-tsl-site-name">Trendyol</span>
					</label>
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="n11" data-default checked />
						<span class="zo-tsl-site-name">N11</span>
					</label>
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="hepsiburada" data-default checked />
						<span class="zo-tsl-site-name">Hepsiburada</span>
					</label>
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="ciceksepeti" />
						<span class="zo-tsl-site-name">Çiçeksepeti</span>
					</label>
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="pttavm" />
						<span class="zo-tsl-site-name">PttAVM</span>
					</label>
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="sahibinden" />
						<span class="zo-tsl-site-name">Sahibinden</span>
					</label>
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="dolap" />
						<span class="zo-tsl-site-name">Dolap</span>
					</label>
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="gardrops" />
						<span class="zo-tsl-site-name">Gardrops</span>
					</label>
					<label class="zo-tsl-site">
						<input class="zo-tsl-check" type="checkbox" value="migros" />
						<span class="zo-tsl-site-name">Migros</span>
					</label>
				</div>

				<div class="zo-tsl-actions">
					<button type="button" class="zo-tsl-button zo-tsl-button--open">Aramaları Aç</button>
					<button type="button" class="zo-tsl-button zo-tsl-button--shuffle">Rastgele Siteler</button>
					<button type="button" class="zo-tsl-button zo-tsl-button--reset">Sıfırla</button>
				</div>

				<div class="zo-tsl-stats">
					<div class="zo-tsl-stat">
						<span class="zo-tsl-stat-label">Seçili Site</span>
						<span class="zo-tsl-stat-value zo-tsl-stat-value--sites">0</span>
					</div>
					<div class="zo-tsl-stat">
						<span class="zo-tsl-stat-label">Açılış Sayısı</span>
						<span class="zo-tsl-stat-value zo-tsl-stat-value--launches">0</span>
					</div>
					<div class="zo-tsl-stat">
						<span class="zo-tsl-stat-label">Toplam Puan</span>
						<span class="zo-tsl-stat-value zo-tsl-stat-value--points">0</span>
					</div>
				</div>

				<div class="zo-tsl-status" aria-live="polite">Hazır. Ürün adı yaz ve siteleri aç.</div>
				<div class="zo-tsl-links"></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'tr-search-launcher',
	'name'            => 'TR Search Launcher',
	'author'          => 'Asker',
	'description'     => 'A browser-based Turkish shopping search launcher for quickly opening product searches across multiple sites.',
	'render_callback' => 'zo_game_tr_search_launcher_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);