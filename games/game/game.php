<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--oyun-merkezi * {
	box-sizing: border-box;
}

.zo-game-root--oyun-merkezi {
	max-width: 1100px;
	margin: 0 auto;
	padding: 16px;
	font-family: Arial, sans-serif;
	color: #1f2937;
}

.zo-game-root--oyun-merkezi .zo-om-wrap {
	background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
	border: 1px solid #dbe3ea;
	border-radius: 24px;
	padding: 20px;
	box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
}

.zo-game-root--oyun-merkezi .zo-om-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 34px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--oyun-merkezi .zo-om-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.5;
	color: #475569;
}

.zo-game-root--oyun-merkezi .zo-om-topbar {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	justify-content: center;
	margin-bottom: 18px;
}

.zo-game-root--oyun-merkezi .zo-om-stat {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 14px;
	padding: 10px 14px;
	font-size: 15px;
	font-weight: 700;
	box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
}

.zo-game-root--oyun-merkezi .zo-om-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: center;
	margin-bottom: 20px;
}

.zo-game-root--oyun-merkezi .zo-om-btn {
	border: 1px solid #cbd5e1;
	border-radius: 14px;
	padding: 11px 16px;
	font: inherit;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	background: #ffffff;
	color: #1e293b;
	transition: transform 0.15s ease, opacity 0.15s ease;
}

.zo-game-root--oyun-merkezi .zo-om-btn:hover,
.zo-game-root--oyun-merkezi .zo-om-btn:focus {
	outline: none;
	transform: translateY(-1px);
}

.zo-game-root--oyun-merkezi .zo-om-btn--primary {
	background: #2563eb;
	border-color: #2563eb;
	color: #ffffff;
}

.zo-game-root--oyun-merkezi .zo-om-btn--danger {
	background: #ef4444;
	border-color: #ef4444;
	color: #ffffff;
}

.zo-game-root--oyun-merkezi .zo-om-grid {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 16px;
}

.zo-game-root--oyun-merkezi .zo-om-card {
	position: relative;
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 20px;
	padding: 16px;
	box-shadow: 0 8px 18px rgba(0, 0, 0, 0.05);
	min-height: 220px;
	display: flex;
	flex-direction: column;
}

.zo-game-root--oyun-merkezi .zo-om-card.is-locked {
	opacity: 0.7;
}

.zo-game-root--oyun-merkezi .zo-om-icon {
	font-size: 44px;
	line-height: 1;
	margin-bottom: 10px;
}

.zo-game-root--oyun-merkezi .zo-om-card-title {
	margin: 0 0 8px;
	font-size: 22px;
	line-height: 1.2;
	color: #0f172a;
}

.zo-game-root--oyun-merkezi .zo-om-card-text {
	margin: 0 0 12px;
	font-size: 14px;
	line-height: 1.5;
	color: #475569;
	min-height: 42px;
}

.zo-game-root--oyun-merkezi .zo-om-stars {
	font-size: 20px;
	letter-spacing: 2px;
	margin-bottom: 10px;
	min-height: 28px;
}

.zo-game-root--oyun-merkezi .zo-om-requirement {
	font-size: 13px;
	font-weight: 700;
	color: #b45309;
	margin-bottom: 10px;
	min-height: 18px;
}

.zo-game-root--oyun-merkezi .zo-om-meta {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-bottom: 12px;
}

.zo-game-root--oyun-merkezi .zo-om-badge {
	background: #f1f5f9;
	border: 1px solid #dbe3ea;
	border-radius: 999px;
	padding: 6px 10px;
	font-size: 12px;
	font-weight: 700;
	color: #334155;
}

.zo-game-root--oyun-merkezi .zo-om-card-actions {
	margin-top: auto;
	display: flex;
	gap: 8px;
	flex-wrap: wrap;
}

.zo-game-root--oyun-merkezi .zo-om-open {
	background: #16a34a;
	border-color: #16a34a;
	color: #ffffff;
}

.zo-game-root--oyun-merkezi .zo-om-preview {
	background: #ffffff;
	border: 1px solid #dbe3ea;
	border-radius: 20px;
	padding: 12px;
	margin-top: 20px;
	display: none;
}

.zo-game-root--oyun-merkezi .zo-om-preview.is-visible {
	display: block;
}

.zo-game-root--oyun-merkezi .zo-om-preview-top {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 10px;
}

.zo-game-root--oyun-merkezi .zo-om-preview-title {
	margin: 0;
	font-size: 22px;
	color: #0f172a;
}

.zo-game-root--oyun-merkezi .zo-om-frame {
	display: block;
	width: 100%;
	height: 72vh;
	min-height: 520px;
	border: 0;
	border-radius: 14px;
	background: #ffffff;
}

.zo-game-root--oyun-merkezi .zo-om-help {
	margin-top: 12px;
	text-align: center;
	font-size: 13px;
	line-height: 1.5;
	color: #64748b;
}

@media (max-width: 980px) {
	.zo-game-root--oyun-merkezi .zo-om-grid {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}
}

@media (max-width: 640px) {
	.zo-game-root--oyun-merkezi {
		padding: 10px;
	}

	.zo-game-root--oyun-merkezi .zo-om-wrap {
		padding: 14px;
	}

	.zo-game-root--oyun-merkezi .zo-om-title {
		font-size: 28px;
	}

	.zo-game-root--oyun-merkezi .zo-om-grid {
		grid-template-columns: 1fr;
	}

	.zo-game-root--oyun-merkezi .zo-om-frame {
		height: 68vh;
		min-height: 420px;
	}
}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const roots = document.querySelectorAll('.zo-game-root--oyun-merkezi');

	roots.forEach(function (root) {
		const progressKey = 'zo_oyun_merkezi_progress_v1';

		const games = [
			{
				id: 'dinozorlu',
				name: 'Dinozorlu',
				icon: '🦖',
				desc: 'Dino koşar. Engellerin üstünden zıpla.',
				url: '/oyun/dinozorlu/',
				requireStars: 0,
				difficulty: 'Kolay'
			},
			{
				id: 'balon-patlatmali',
				name: 'Balon Patlatmalı',
				icon: '🎈',
				desc: 'Balonlara tıkla ve puan topla.',
				url: '/oyun/balon-patlatmali/',
				requireStars: 0,
				difficulty: 'Kolay'
			},
			{
				id: 'hayvan-kurtarmali',
				name: 'Hayvan Kurtarmalı',
				icon: '🐶',
				desc: 'Hayvanları bul ve güvenli yere götür.',
				url: '/oyun/hayvan-kurtarmali/',
				requireStars: 2,
				difficulty: 'Orta'
			},
			{
				id: 'arabali',
				name: 'Arabalı',
				icon: '🚗',
				desc: 'Şerit değiştir. Araba çarpışmalarından kaç.',
				url: '/oyun/arabali/',
				requireStars: 3,
				difficulty: 'Orta'
			},
			{
				id: 'ses-efektli-surum',
				name: 'Ses Efektli',
				icon: '🔊',
				desc: 'Renkli toplara tıkla. Her tıkta ses çıksın.',
				url: '/oyun/ses-efektli-surum/',
				requireStars: 4,
				difficulty: 'Orta'
			},
			{
				id: 'meyve-topla',
				name: 'Meyve Topla',
				icon: '🍎',
				desc: 'Meyveleri topla. Çamurlardan kaç.',
				url: '/oyun/meyve-topla/',
				requireStars: 5,
				difficulty: 'Zor'
			}
		];

		const totalStarsEl = root.querySelector('.zo-om-total-stars');
		const unlockedEl = root.querySelector('.zo-om-unlocked-count');
		const cardsWrap = root.querySelector('.zo-om-grid');
		const resetButton = root.querySelector('.zo-om-reset-progress');
		const autoDemoButton = root.querySelector('.zo-om-demo-progress');
		const previewWrap = root.querySelector('.zo-om-preview');
		const previewTitle = root.querySelector('.zo-om-preview-title');
		const frame = root.querySelector('.zo-om-frame');
		const closePreview = root.querySelector('.zo-om-close-preview');

		function getDefaultProgress() {
			const out = {
				stars: {},
				totalStars: 0
			};

			games.forEach(function (game) {
				out.stars[game.id] = 0;
			});

			return out;
		}

		function loadProgress() {
			try {
				const raw = localStorage.getItem(progressKey);
				if (!raw) {
					return getDefaultProgress();
				}
				const parsed = JSON.parse(raw);
				const base = getDefaultProgress();

				if (parsed && parsed.stars) {
					Object.keys(base.stars).forEach(function (id) {
						base.stars[id] = Math.max(0, Math.min(3, parseInt(parsed.stars[id] || 0, 10) || 0));
					});
				}

				base.totalStars = Object.values(base.stars).reduce(function (sum, n) {
					return sum + n;
				}, 0);

				return base;
			} catch (e) {
				return getDefaultProgress();
			}
		}

		function saveProgress(progress) {
			try {
				localStorage.setItem(progressKey, JSON.stringify(progress));
			} catch (e) {}
		}

		function getStarsHtml(count) {
			let html = '';
			for (let i = 1; i <= 3; i++) {
				html += i <= count ? '⭐' : '☆';
			}
			return html;
		}

		function isUnlocked(game, progress) {
			return progress.totalStars >= game.requireStars;
		}

		function countUnlocked(progress) {
			let count = 0;
			games.forEach(function (game) {
				if (isUnlocked(game, progress)) {
					count += 1;
				}
			});
			return count;
		}

		function updateTop(progress) {
			totalStarsEl.textContent = String(progress.totalStars);
			unlockedEl.textContent = String(countUnlocked(progress));
		}

		function renderCards() {
			const progress = loadProgress();
			updateTop(progress);
			cardsWrap.innerHTML = '';

			games.forEach(function (game) {
				const card = document.createElement('div');
				const stars = progress.stars[game.id] || 0;
				const unlocked = isUnlocked(game, progress);

				card.className = 'zo-om-card' + (unlocked ? '' : ' is-locked');

				card.innerHTML =
					'<div class="zo-om-icon">' + game.icon + '</div>' +
					'<h3 class="zo-om-card-title">' + game.name + '</h3>' +
					'<p class="zo-om-card-text">' + game.desc + '</p>' +
					'<div class="zo-om-stars">' + getStarsHtml(stars) + '</div>' +
					'<div class="zo-om-requirement">' + (unlocked ? 'Açık' : ('Kilitli: ' + game.requireStars + ' yıldız gerek')) + '</div>' +
					'<div class="zo-om-meta">' +
						'<div class="zo-om-badge">Zorluk: ' + game.difficulty + '</div>' +
						'<div class="zo-om-badge">Yıldız: ' + stars + '/3</div>' +
					'</div>' +
					'<div class="zo-om-card-actions">' +
						'<button type="button" class="zo-om-btn zo-om-award" data-id="' + game.id + '">+1 Yıldız</button>' +
						'<button type="button" class="zo-om-btn zo-om-remove" data-id="' + game.id + '">-1</button>' +
						'<button type="button" class="zo-om-btn zo-om-open' + (unlocked ? '' : ' is-disabled') + '" data-id="' + game.id + '"' + (unlocked ? '' : ' disabled') + '>Aç</button>' +
					'</div>';

				cardsWrap.appendChild(card);
			});

			bindCardEvents();
		}

		function recalcTotal(progress) {
			progress.totalStars = Object.values(progress.stars).reduce(function (sum, n) {
				return sum + n;
			}, 0);
		}

		function addStar(id) {
			const progress = loadProgress();
			progress.stars[id] = Math.min(3, (progress.stars[id] || 0) + 1);
			recalcTotal(progress);
			saveProgress(progress);
			renderCards();
		}

		function removeStar(id) {
			const progress = loadProgress();
			progress.stars[id] = Math.max(0, (progress.stars[id] || 0) - 1);
			recalcTotal(progress);
			saveProgress(progress);
			renderCards();
		}

		function openGame(id) {
			const game = games.find(function (item) {
				return item.id === id;
			});
			if (!game) {
				return;
			}

			const progress = loadProgress();
			if (!isUnlocked(game, progress)) {
				return;
			}

			previewTitle.textContent = game.name;
			frame.setAttribute('src', game.url);
			previewWrap.classList.add('is-visible');
			previewWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
		}

		function bindCardEvents() {
			root.querySelectorAll('.zo-om-award').forEach(function (btn) {
				btn.addEventListener('click', function () {
					addStar(btn.getAttribute('data-id'));
				});
			});

			root.querySelectorAll('.zo-om-remove').forEach(function (btn) {
				btn.addEventListener('click', function () {
					removeStar(btn.getAttribute('data-id'));
				});
			});

			root.querySelectorAll('.zo-om-open').forEach(function (btn) {
				btn.addEventListener('click', function () {
					openGame(btn.getAttribute('data-id'));
				});
			});
		}

		resetButton.addEventListener('click', function () {
			const blank = getDefaultProgress();
			saveProgress(blank);
			frame.removeAttribute('src');
			previewWrap.classList.remove('is-visible');
			renderCards();
		});

		autoDemoButton.addEventListener('click', function () {
			const demo = getDefaultProgress();
			demo.stars['dinozorlu'] = 2;
			demo.stars['balon-patlatmali'] = 2;
			demo.stars['hayvan-kurtarmali'] = 1;
			recalcTotal(demo);
			saveProgress(demo);
			renderCards();
		});

		closePreview.addEventListener('click', function () {
			frame.removeAttribute('src');
			previewWrap.classList.remove('is-visible');
		});

		renderCards();
	});
});
JS;

if (!function_exists('zo_oyun_merkezi_render')) {
	function zo_oyun_merkezi_render($post_id = 0, $game = array()) {
		$game_id = 'zo-oyun-merkezi-' . wp_rand(1000, 999999);

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--oyun-merkezi" id="<?php echo esc_attr($game_id); ?>">
			<div class="zo-om-wrap">
				<h2 class="zo-om-title">Arslan’ın Oyun Merkezi</h2>
				<p class="zo-om-subtitle">Yıldız kazan. Yeni oyunların kilidini aç. Hepsini aynı menüden başlat.</p>

				<div class="zo-om-topbar">
					<div class="zo-om-stat">Toplam Yıldız: <span class="zo-om-total-stars">0</span></div>
					<div class="zo-om-stat">Açık Oyun: <span class="zo-om-unlocked-count">0</span></div>
				</div>

				<div class="zo-om-actions">
					<button type="button" class="zo-om-btn zo-om-btn--primary zo-om-demo-progress">Örnek İlerleme Ver</button>
					<button type="button" class="zo-om-btn zo-om-btn--danger zo-om-reset-progress">İlerlemeyi Sıfırla</button>
				</div>

				<div class="zo-om-grid"></div>

				<div class="zo-om-preview">
					<div class="zo-om-preview-top">
						<h3 class="zo-om-preview-title">Oyun</h3>
						<button type="button" class="zo-om-btn zo-om-close-preview">Kapat</button>
					</div>
					<iframe class="zo-om-frame" loading="lazy" allowfullscreen></iframe>
				</div>

				<p class="zo-om-help">
					Şu an yıldızları menüden elle veriyoruz. İstersen sonraki adımda her oyunun içine gerçek yıldız kazanma sistemi bağlayayım.
				</p>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'oyun-merkezi',
	'name'            => 'Oyun Merkezi',
	'author'          => 'Arslan',
	'description'     => 'Tüm oyunları ortak menü, yıldız ve kilit sistemiyle gösteren merkez.',
	'render_callback' => 'zo_oyun_merkezi_render',
	'inline_style'    => $inline_style,
	'inline_script'   => $inline_script,
);