<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--london-clock {
	max-width: 420px;
	margin: 0 auto;
	padding: 18px;
	border: 2px solid #2a3138;
	border-radius: 18px;
	background: #111316;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	color: #ffffff;
	text-align: left;
}

.zo-game-root--london-clock .zo-lc-title {
	margin: 0 0 10px;
	font-size: 24px;
	line-height: 1.2;
	text-align: center;
	color: #ffffff;
}

.zo-game-root--london-clock .zo-lc-clock-wrap {
	padding: 14px;
	border-radius: 14px;
	background: #171b20;
	border: 1px solid #2f3944;
}

.zo-game-root--london-clock .zo-lc-time {
	font-size: 56px;
	font-weight: 700;
	line-height: 1;
	letter-spacing: 1px;
	color: #ffffff;
	word-break: break-word;
}

.zo-game-root--london-clock .zo-lc-date {
	margin-top: 8px;
	font-size: 26px;
	line-height: 1.2;
	color: #ffffff;
}

.zo-game-root--london-clock .zo-lc-zone {
	margin-top: 14px;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
	color: #c8d1da;
}

.zo-game-root--london-clock .zo-lc-actions {
	margin-top: 14px;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-game-root--london-clock .zo-lc-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--london-clock .zo-lc-button--format {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--london-clock .zo-lc-button--refresh {
	background: #e5e7eb;
	color: #111827;
}

@media (max-width: 520px) {
	.zo-game-root.zo-game-root--london-clock {
		padding: 14px;
	}

	.zo-game-root--london-clock .zo-lc-time {
		font-size: 42px;
	}

	.zo-game-root--london-clock .zo-lc-date {
		font-size: 22px;
	}

	.zo-game-root--london-clock .zo-lc-actions {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--london-clock');

	games.forEach(function (game) {
		const timeEl = game.querySelector('.zo-lc-time');
		const dateEl = game.querySelector('.zo-lc-date');
		const zoneEl = game.querySelector('.zo-lc-zone');
		const formatButton = game.querySelector('.zo-lc-button--format');
		const refreshButton = game.querySelector('.zo-lc-button--refresh');

		let use24Hour = true;
		let timerId = null;
		const timeZone = 'Europe/London';
		const locale = game.getAttribute('data-locale') || 'en-GB';
		const zoneLabel = game.getAttribute('data-zone-label') || 'London Time';

		function updateClock() {
			const now = new Date();

			timeEl.textContent = new Intl.DateTimeFormat(locale, {
				timeZone: timeZone,
				hour: '2-digit',
				minute: '2-digit',
				second: '2-digit',
				hour12: !use24Hour
			}).format(now);

			dateEl.textContent = new Intl.DateTimeFormat(locale, {
				timeZone: timeZone,
				year: 'numeric',
				month: 'numeric',
				day: 'numeric'
			}).format(now);

			zoneEl.textContent = zoneLabel;
		}

		function startClock() {
			if (timerId) {
				clearInterval(timerId);
			}
			updateClock();
			timerId = setInterval(updateClock, 1000);
		}

		formatButton.addEventListener('click', function () {
			use24Hour = !use24Hour;
			updateClock();
		});

		refreshButton.addEventListener('click', function () {
			updateClock();
		});

		startClock();
	});
});
JS;

if (!function_exists('zo_game_london_clock_render')) {
	function zo_game_london_clock_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-london-clock-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		$lang = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
		$labels = array(
			'tr' => array('title' => 'Londra Saati', 'zone' => 'Londra Saati', 'format' => '12/24 Saat', 'refresh' => 'Yenile', 'locale' => 'tr-TR'),
			'en' => array('title' => 'London Clock', 'zone' => 'London Time', 'format' => '12/24 Format', 'refresh' => 'Refresh', 'locale' => 'en-GB'),
			'de' => array('title' => 'London-Uhr', 'zone' => 'Londoner Zeit', 'format' => '12/24 Format', 'refresh' => 'Aktualisieren', 'locale' => 'de-DE'),
		);
		$label = isset($labels[$lang]) ? $labels[$lang] : $labels['tr'];

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--london-clock" id="<?php echo esc_attr($instance_id); ?>" data-locale="<?php echo esc_attr($label['locale']); ?>" data-zone-label="<?php echo esc_attr($label['zone']); ?>">
			<h2 class="zo-lc-title"><?php echo esc_html($label['title']); ?></h2>

			<div class="zo-lc-clock-wrap" aria-live="polite">
				<div class="zo-lc-time">00:00:00</div>
				<div class="zo-lc-date">1/1/2000</div>
			</div>

			<div class="zo-lc-zone"><?php echo esc_html($label['zone']); ?></div>

			<div class="zo-lc-actions">
				<button type="button" class="zo-lc-button zo-lc-button--format"><?php echo esc_html($label['format']); ?></button>
				<button type="button" class="zo-lc-button zo-lc-button--refresh"><?php echo esc_html($label['refresh']); ?></button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'london-clock',
	'name'            => 'London Clock',
	'author'          => 'Asker',
	'description'     => 'A simple browser clock showing London time with seconds.',
	'render_callback' => 'zo_game_london_clock_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
