<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--wisconsin-clock {
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

.zo-game-root--wisconsin-clock .zo-wc-title {
	margin: 0 0 10px;
	font-size: 24px;
	line-height: 1.2;
	text-align: center;
	color: #ffffff;
}

.zo-game-root--wisconsin-clock .zo-wc-clock-wrap {
	padding: 14px;
	border-radius: 14px;
	background: #171b20;
	border: 1px solid #2f3944;
}

.zo-game-root--wisconsin-clock .zo-wc-time {
	font-size: 56px;
	font-weight: 700;
	line-height: 1;
	letter-spacing: 1px;
	color: #ffffff;
	word-break: break-word;
}

.zo-game-root--wisconsin-clock .zo-wc-date {
	margin-top: 8px;
	font-size: 26px;
	line-height: 1.2;
	color: #ffffff;
}

.zo-game-root--wisconsin-clock .zo-wc-zone {
	margin-top: 14px;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
	color: #c8d1da;
}

.zo-game-root--wisconsin-clock .zo-wc-actions {
	margin-top: 14px;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-game-root--wisconsin-clock .zo-wc-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--wisconsin-clock .zo-wc-button--format {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--wisconsin-clock .zo-wc-button--refresh {
	background: #e5e7eb;
	color: #111827;
}

@media (max-width: 520px) {
	.zo-game-root.zo-game-root--wisconsin-clock {
		padding: 14px;
	}

	.zo-game-root--wisconsin-clock .zo-wc-time {
		font-size: 42px;
	}

	.zo-game-root--wisconsin-clock .zo-wc-date {
		font-size: 22px;
	}

	.zo-game-root--wisconsin-clock .zo-wc-actions {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--wisconsin-clock');

	games.forEach(function (game) {
		const timeEl = game.querySelector('.zo-wc-time');
		const dateEl = game.querySelector('.zo-wc-date');
		const zoneEl = game.querySelector('.zo-wc-zone');
		const formatButton = game.querySelector('.zo-wc-button--format');
		const refreshButton = game.querySelector('.zo-wc-button--refresh');

		let use24Hour = true;
		let timerId = null;
		const timeZone = 'America/Chicago';
		const locale = game.getAttribute('data-locale') || 'en-US';
		const zoneLabel = game.getAttribute('data-zone-label') || 'Wisconsin Time';

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

if (!function_exists('zo_game_wisconsin_clock_render')) {
	function zo_game_wisconsin_clock_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-wisconsin-clock-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		$lang = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
		$labels = array(
			'tr' => array('title' => 'Wisconsin Saati', 'zone' => 'Wisconsin Saati', 'format' => '12/24 Saat', 'refresh' => 'Yenile', 'locale' => 'tr-TR'),
			'en' => array('title' => 'Wisconsin Clock', 'zone' => 'Wisconsin Time', 'format' => '12/24 Format', 'refresh' => 'Refresh', 'locale' => 'en-US'),
			'de' => array('title' => 'Wisconsin-Uhr', 'zone' => 'Wisconsin-Zeit', 'format' => '12/24 Format', 'refresh' => 'Aktualisieren', 'locale' => 'de-DE'),
		);
		$label = isset($labels[$lang]) ? $labels[$lang] : $labels['tr'];

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--wisconsin-clock" id="<?php echo esc_attr($instance_id); ?>" data-locale="<?php echo esc_attr($label['locale']); ?>" data-zone-label="<?php echo esc_attr($label['zone']); ?>">
			<h2 class="zo-wc-title"><?php echo esc_html($label['title']); ?></h2>

			<div class="zo-wc-clock-wrap" aria-live="polite">
				<div class="zo-wc-time">00:00:00</div>
				<div class="zo-wc-date">1/1/2000</div>
			</div>

			<div class="zo-wc-zone"><?php echo esc_html($label['zone']); ?></div>

			<div class="zo-wc-actions">
				<button type="button" class="zo-wc-button zo-wc-button--format"><?php echo esc_html($label['format']); ?></button>
				<button type="button" class="zo-wc-button zo-wc-button--refresh"><?php echo esc_html($label['refresh']); ?></button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'wisconsin-clock',
	'name'            => 'Wisconsin Clock',
	'author'          => 'Asker',
	'description'     => 'A simple browser clock showing Wisconsin time with seconds.',
	'render_callback' => 'zo_game_wisconsin_clock_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
