<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--adana-clock {
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

.zo-game-root--adana-clock .zo-ac-title {
	margin: 0 0 10px;
	font-size: 24px;
	line-height: 1.2;
	text-align: center;
	color: #ffffff;
}

.zo-game-root--adana-clock .zo-ac-clock-wrap {
	padding: 14px;
	border-radius: 14px;
	background: #171b20;
	border: 1px solid #2f3944;
}

.zo-game-root--adana-clock .zo-ac-time {
	font-size: 56px;
	font-weight: 700;
	line-height: 1;
	letter-spacing: 1px;
	color: #ffffff;
	word-break: break-word;
}

.zo-game-root--adana-clock .zo-ac-date {
	margin-top: 8px;
	font-size: 26px;
	line-height: 1.2;
	color: #ffffff;
}

.zo-game-root--adana-clock .zo-ac-zone {
	margin-top: 14px;
	text-align: center;
	font-size: 14px;
	font-weight: 700;
	color: #c8d1da;
}

.zo-game-root--adana-clock .zo-ac-actions {
	margin-top: 14px;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
}

.zo-game-root--adana-clock .zo-ac-button {
	border: 0;
	border-radius: 12px;
	padding: 12px 10px;
	font-size: 15px;
	font-weight: 700;
	cursor: pointer;
	box-sizing: border-box;
}

.zo-game-root--adana-clock .zo-ac-button--format {
	background: #2997aa;
	color: #ffffff;
}

.zo-game-root--adana-clock .zo-ac-button--refresh {
	background: #e5e7eb;
	color: #111827;
}

@media (max-width: 520px) {
	.zo-game-root.zo-game-root--adana-clock {
		padding: 14px;
	}

	.zo-game-root--adana-clock .zo-ac-time {
		font-size: 42px;
	}

	.zo-game-root--adana-clock .zo-ac-date {
		font-size: 22px;
	}

	.zo-game-root--adana-clock .zo-ac-actions {
		grid-template-columns: 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--adana-clock');

	games.forEach(function (game) {
		const timeEl = game.querySelector('.zo-ac-time');
		const dateEl = game.querySelector('.zo-ac-date');
		const zoneEl = game.querySelector('.zo-ac-zone');
		const formatButton = game.querySelector('.zo-ac-button--format');
		const refreshButton = game.querySelector('.zo-ac-button--refresh');

		let use24Hour = true;
		let timerId = null;
		const timeZone = 'Europe/Istanbul';

		function updateClock() {
			const now = new Date();

			timeEl.textContent = new Intl.DateTimeFormat('tr-TR', {
				timeZone: timeZone,
				hour: '2-digit',
				minute: '2-digit',
				second: '2-digit',
				hour12: !use24Hour
			}).format(now);

			dateEl.textContent = new Intl.DateTimeFormat('tr-TR', {
				timeZone: timeZone,
				year: 'numeric',
				month: 'numeric',
				day: 'numeric'
			}).format(now);

			zoneEl.textContent = 'Adana Saati';
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

if (!function_exists('zo_game_adana_clock_render')) {
	function zo_game_adana_clock_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-adana-clock-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--adana-clock" id="<?php echo esc_attr($instance_id); ?>">
			<h2 class="zo-ac-title">Adana Clock</h2>

			<div class="zo-ac-clock-wrap" aria-live="polite">
				<div class="zo-ac-time">00:00:00</div>
				<div class="zo-ac-date">1.1.2000</div>
			</div>

			<div class="zo-ac-zone">Adana Saati</div>

			<div class="zo-ac-actions">
				<button type="button" class="zo-ac-button zo-ac-button--format">12/24 Saat</button>
				<button type="button" class="zo-ac-button zo-ac-button--refresh">Yenile</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'adana-clock',
	'name'            => 'Adana Clock',
	'author'          => 'Asker',
	'description'     => 'Adana saatini saniyelerle gösteren basit tarayıcı saati.',
	'render_callback' => 'zo_game_adana_clock_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);