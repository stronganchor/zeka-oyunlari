<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('zo_create_place_clock_game_module')) {
	function zo_create_place_clock_game_module($config) {
		$slug = sanitize_title($config['slug']);
		$name = isset($config['name']) ? $config['name'] : array();
		$description = isset($config['description']) ? $config['description'] : array();
		$zone = isset($config['timezone']) ? $config['timezone'] : 'UTC';
		$labels = isset($config['labels']) ? $config['labels'] : array();
		$class = sanitize_html_class($slug);

		$css = <<<'CSS'
.zo-game-root.zo-game-root--place-clock {
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

.zo-game-root--place-clock .zo-place-clock-title {
	margin: 0 0 10px;
	font-size: 24px;
	line-height: 1.2;
	text-align: center;
	color: #ffffff;
}

.zo-game-root--place-clock .zo-place-clock-wrap {
	padding: 14px;
	border-radius: 14px;
	background: #171b20;
	border: 1px solid #2f3944;
}

.zo-game-root--place-clock .zo-place-clock-time {
	font-size: 56px;
	font-weight: 700;
	line-height: 1;
	letter-spacing: 1px;
	color: #ffffff;
	word-break: break-word;
}

.zo-game-root--place-clock .zo-place-clock-date {
	margin-top: 8px;
	font-size: 26px;
	line-height: 1.2;
	color: #ffffff;
}

.zo-game-root--place-clock .zo-place-clock-zone {
	margin-top: 14px;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
	color: #c8d1da;
}

.zo-game-root--place-clock .zo-place-clock-actions {
	margin-top: 14px;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-game-root--place-clock .zo-place-clock-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--place-clock .zo-place-clock-button--format {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--place-clock .zo-place-clock-button--refresh {
	background: #e5e7eb;
	color: #111827;
}

@media (max-width: 520px) {
	.zo-game-root.zo-game-root--place-clock {
		padding: 14px;
	}

	.zo-game-root--place-clock .zo-place-clock-time {
		font-size: 42px;
	}

	.zo-game-root--place-clock .zo-place-clock-date {
		font-size: 22px;
	}

	.zo-game-root--place-clock .zo-place-clock-actions {
		grid-template-columns: 1fr;
	}
}
CSS;

		$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--place-clock');

	games.forEach(function (game) {
		const timeEl = game.querySelector('.zo-place-clock-time');
		const dateEl = game.querySelector('.zo-place-clock-date');
		const zoneEl = game.querySelector('.zo-place-clock-zone');
		const formatButton = game.querySelector('.zo-place-clock-button--format');
		const refreshButton = game.querySelector('.zo-place-clock-button--refresh');

		let use24Hour = true;
		let timerId = null;
		const timeZone = game.getAttribute('data-time-zone') || 'UTC';
		const locale = game.getAttribute('data-locale') || 'tr-TR';
		const zoneLabel = game.getAttribute('data-zone-label') || '';

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

		$render = function ($post_id = 0, $module = array()) use ($slug, $class, $zone, $labels) {
			$instance_id = 'zo-' . $slug . '-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
			$lang = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
			$label = isset($labels[$lang]) ? $labels[$lang] : $labels['tr'];

			ob_start();
			?>
			<div class="zo-game-root zo-game-root--place-clock zo-game-root--<?php echo esc_attr($class); ?>" id="<?php echo esc_attr($instance_id); ?>" data-time-zone="<?php echo esc_attr($zone); ?>" data-locale="<?php echo esc_attr($label['locale']); ?>" data-zone-label="<?php echo esc_attr($label['zone']); ?>">
				<h2 class="zo-place-clock-title"><?php echo esc_html($label['title']); ?></h2>

				<div class="zo-place-clock-wrap" aria-live="polite">
					<div class="zo-place-clock-time">00:00:00</div>
					<div class="zo-place-clock-date">1.1.2000</div>
				</div>

				<div class="zo-place-clock-zone"><?php echo esc_html($label['zone']); ?></div>

				<div class="zo-place-clock-actions">
					<button type="button" class="zo-place-clock-button zo-place-clock-button--format"><?php echo esc_html($label['format']); ?></button>
					<button type="button" class="zo-place-clock-button zo-place-clock-button--refresh"><?php echo esc_html($label['refresh']); ?></button>
				</div>
			</div>
			<?php
			return ob_get_clean();
		};

		return array(
			'slug'            => $slug,
			'name'            => sprintf('TR: %s | EN: %s | DE: %s', $name['tr'], $name['en'], $name['de']),
			'author'          => 'Asker',
			'description'     => sprintf('TR: %s EN: %s DE: %s', $description['tr'], $description['en'], $description['de']),
			'render_callback' => $render,
			'inline_style'    => $css,
			'inline_script'   => $js,
		);
	}
}
