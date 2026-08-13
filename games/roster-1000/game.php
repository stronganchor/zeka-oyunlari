<?php

if (!defined('ABSPATH')) {
	exit;
}

function zo_roster_1000_clean_progress($progress) {
	if (!is_array($progress)) {
		return array();
	}
	$owned = array();
	if (!empty($progress['owned']) && is_array($progress['owned'])) {
		foreach ($progress['owned'] as $hero_id => $is_owned) {
			$hero_id = absint($hero_id);
			if ($hero_id >= 1 && $hero_id <= 1000 && $is_owned) {
				$owned[(string) $hero_id] = true;
			}
		}
	}
	$owned['1'] = true;
	return array(
		'coins' => min(1000000000, max(0, absint($progress['coins'] ?? 150))),
		'level' => min(9999, max(1, absint($progress['level'] ?? 1))),
		'wins' => min(1000000000, max(0, absint($progress['wins'] ?? 0))),
		'page' => min(83, max(0, absint($progress['page'] ?? 0))),
		'selectedId' => min(1000, max(1, absint($progress['selectedId'] ?? 1))),
		'owned' => $owned,
	);
}

function zo_roster_1000_accounts_table() {
	global $wpdb;

	return $wpdb->prefix . 'zo_player_accounts';
}

function zo_roster_1000_ensure_accounts_table() {
	global $wpdb;

	$table = zo_roster_1000_accounts_table();
	$charset_collate = $wpdb->get_charset_collate();

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta("CREATE TABLE {$table} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		nickname_key varchar(64) NOT NULL,
		nickname varchar(32) NOT NULL,
		pin_hash varchar(255) NOT NULL,
		progress longtext NULL,
		created_at datetime NOT NULL,
		updated_at datetime NOT NULL,
		PRIMARY KEY  (id),
		UNIQUE KEY nickname_key (nickname_key)
	) {$charset_collate};");

	return $table;
}

function zo_roster_1000_normalize_nickname($nickname) {
	$nickname = sanitize_text_field(wp_unslash((string) $nickname));
	$nickname = trim(preg_replace('/\s+/', '-', $nickname));
	return function_exists('mb_strtolower') ? mb_strtolower(substr($nickname, 0, 32), 'UTF-8') : strtolower(substr($nickname, 0, 32));
}

function zo_roster_1000_account_request() {
	check_ajax_referer('zo_roster_1000_progress', 'nonce');

	global $wpdb;
	$table = zo_roster_1000_ensure_accounts_table();
	$nickname = isset($_POST['nickname']) ? zo_roster_1000_normalize_nickname($_POST['nickname']) : '';
	$pin = isset($_POST['pin']) ? preg_replace('/\D+/', '', (string) wp_unslash($_POST['pin'])) : '';
	$mode = isset($_POST['mode']) ? sanitize_key(wp_unslash($_POST['mode'])) : '';

	if ($nickname === '' || strlen($pin) < 4 || strlen($pin) > 9) {
		wp_send_json_error(array('message' => 'Enter a nickname and a 4 to 9 digit PIN.'), 400);
	}

	$key = md5($nickname);
	$account = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE nickname_key = %s LIMIT 1", $key), ARRAY_A);

	if ($mode === 'register') {
		if ($account) {
			wp_send_json_error(array('message' => 'That nickname already exists. Use Sign In.'), 409);
		}

		$progress = isset($_POST['progress']) ? json_decode(wp_unslash($_POST['progress']), true) : array();
		$progress = zo_roster_1000_clean_progress($progress);
		$now = current_time('mysql', true);
		$inserted = $wpdb->insert(
			$table,
			array(
				'nickname_key' => $key,
				'nickname' => $nickname,
				'pin_hash' => wp_hash_password($pin),
				'progress' => wp_json_encode($progress),
				'created_at' => $now,
				'updated_at' => $now,
			),
			array('%s', '%s', '%s', '%s', '%s', '%s')
		);

		if (!$inserted) {
			wp_send_json_error(array('message' => 'The account could not be created.'), 500);
		}

		wp_send_json_success(array('nickname' => $nickname, 'progress' => $progress));
	}

	if (!$account || !wp_check_password($pin, $account['pin_hash'])) {
		wp_send_json_error(array('message' => 'Nickname or PIN did not match.'), 401);
	}

	$progress = !empty($account['progress']) ? json_decode($account['progress'], true) : array();
	wp_send_json_success(array('nickname' => $account['nickname'], 'progress' => zo_roster_1000_clean_progress($progress)));
}
add_action('wp_ajax_nopriv_zo_roster_1000_account', 'zo_roster_1000_account_request');
add_action('wp_ajax_zo_roster_1000_account', 'zo_roster_1000_account_request');

function zo_roster_1000_save_account_progress() {
	check_ajax_referer('zo_roster_1000_progress', 'nonce');

	global $wpdb;
	$table = zo_roster_1000_ensure_accounts_table();
	$nickname = isset($_POST['nickname']) ? zo_roster_1000_normalize_nickname($_POST['nickname']) : '';
	$pin = isset($_POST['pin']) ? preg_replace('/\D+/', '', (string) wp_unslash($_POST['pin'])) : '';
	$progress = isset($_POST['progress']) ? json_decode(wp_unslash($_POST['progress']), true) : array();
	$key = md5($nickname);
	$account = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE nickname_key = %s LIMIT 1", $key), ARRAY_A);

	if (!$account || strlen($pin) < 4 || !wp_check_password($pin, $account['pin_hash'])) {
		wp_send_json_error(array('message' => 'Account verification failed.'), 401);
	}

	$wpdb->update(
		$table,
		array('progress' => wp_json_encode(zo_roster_1000_clean_progress($progress)), 'updated_at' => current_time('mysql', true)),
		array('id' => (int) $account['id']),
		array('%s', '%s'),
		array('%d')
	);
	wp_send_json_success();
}
add_action('wp_ajax_nopriv_zo_roster_1000_save_progress', 'zo_roster_1000_save_account_progress');
add_action('wp_ajax_zo_roster_1000_save_progress', 'zo_roster_1000_save_account_progress');

$css = <<<'CSS'
.zo-game-root--roster-1000 {
	max-width: 1120px;
	margin: 0 auto;
	padding: 16px;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	color: #10233d;
}

.zo-game-root--roster-1000 * {
	box-sizing: border-box;
}

.zo-game-root--roster-1000 .zo-r1-shell {
	background: linear-gradient(180deg, #fff9ec 0%, #eef7ff 100%);
	border: 1px solid #d8e6f2;
	border-radius: 24px;
	padding: 18px;
	box-shadow: 0 16px 36px rgba(16, 35, 61, 0.08);
}

.zo-game-root--roster-1000 .zo-r1-title {
	margin: 0 0 8px;
	text-align: center;
	font-size: 34px;
	line-height: 1.15;
}

.zo-game-root--roster-1000 .zo-r1-subtitle {
	margin: 0 0 18px;
	text-align: center;
	font-size: 15px;
	line-height: 1.55;
	color: #47607d;
}

.zo-game-root--roster-1000 .zo-r1-account {
	display: grid;
	grid-template-columns: minmax(0, 1fr) auto;
	gap: 12px;
	align-items: end;
	margin-bottom: 16px;
	padding: 14px;
	background: #ffffff;
	border: 1px solid #dbe8f4;
	border-radius: 18px;
}

.zo-game-root--roster-1000 .zo-r1-account-fields,
.zo-game-root--roster-1000 .zo-r1-account-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	align-items: end;
}

.zo-game-root--roster-1000 .zo-r1-field {
	display: flex;
	flex-direction: column;
	gap: 5px;
	min-width: 140px;
}

.zo-game-root--roster-1000 .zo-r1-field label {
	font-size: 12px;
	font-weight: 800;
	color: #5f7690;
	text-transform: uppercase;
}

.zo-game-root--roster-1000 .zo-r1-field .zo-r1-input {
	width: 100%;
}

.zo-game-root--roster-1000 .zo-r1-account-status {
	grid-column: 1 / -1;
	min-height: 20px;
	font-size: 13px;
	font-weight: 700;
	color: #0f766e;
}

.zo-game-root--roster-1000 .zo-r1-topbar {
	display: grid;
	grid-template-columns: 1.4fr 1fr;
	gap: 16px;
	margin-bottom: 16px;
}

.zo-game-root--roster-1000 .zo-r1-stats,
.zo-game-root--roster-1000 .zo-r1-controls {
	background: rgba(255, 255, 255, 0.88);
	border: 1px solid #dbe8f4;
	border-radius: 18px;
	padding: 14px;
}

.zo-game-root--roster-1000 .zo-r1-stat-grid {
	display: grid;
	grid-template-columns: repeat(5, minmax(0, 1fr));
	gap: 10px;
}

.zo-game-root--roster-1000 .zo-r1-stat {
	background: #f4f9ff;
	border: 1px solid #d8e6f2;
	border-radius: 14px;
	padding: 10px;
	text-align: center;
}

.zo-game-root--roster-1000 .zo-r1-stat-label {
	display: block;
	font-size: 12px;
	font-weight: 700;
	color: #5f7690;
	margin-bottom: 5px;
	text-transform: uppercase;
}

.zo-game-root--roster-1000 .zo-r1-stat-value {
	display: block;
	font-size: 23px;
	font-weight: 800;
	color: #10233d;
}

.zo-game-root--roster-1000 .zo-r1-stat-value--hero {
	font-size: 15px;
	line-height: 1.3;
}

.zo-game-root--roster-1000 .zo-r1-controls {
	display: flex;
	flex-direction: column;
	gap: 10px;
}

.zo-game-root--roster-1000 .zo-r1-button-row,
.zo-game-root--roster-1000 .zo-r1-pad {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.zo-game-root--roster-1000 .zo-r1-btn,
.zo-game-root--roster-1000 .zo-r1-page-btn {
	border: 0;
	border-radius: 12px;
	padding: 11px 14px;
	font: inherit;
	font-size: 14px;
	font-weight: 700;
	cursor: pointer;
}

.zo-game-root--roster-1000 .zo-r1-btn--primary {
	background: #0f766e;
	color: #fff;
}

.zo-game-root--roster-1000 .zo-r1-btn--secondary,
.zo-game-root--roster-1000 .zo-r1-page-btn {
	background: #dbeafe;
	color: #12335c;
}

.zo-game-root--roster-1000 .zo-r1-btn--warn {
	background: #f97316;
	color: #fff;
}

.zo-game-root--roster-1000 .zo-r1-btn[disabled],
.zo-game-root--roster-1000 .zo-r1-page-btn[disabled] {
	cursor: not-allowed;
	opacity: 0.48;
}

.zo-game-root--roster-1000 .zo-r1-move {
	min-width: 78px;
	background: #1d4ed8;
	color: #fff;
}

.zo-game-root--roster-1000 .zo-r1-layout {
	display: grid;
	grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.95fr);
	gap: 16px;
}

.zo-game-root--roster-1000 .zo-r1-arena-wrap,
.zo-game-root--roster-1000 .zo-r1-side {
	background: rgba(255, 255, 255, 0.88);
	border: 1px solid #dbe8f4;
	border-radius: 20px;
	padding: 14px;
}

.zo-game-root--roster-1000 .zo-r1-canvas {
	display: block;
	width: 100%;
	height: auto;
	border-radius: 18px;
	background: radial-gradient(circle at top, #243b63 0%, #10233d 58%, #091423 100%);
	border: 1px solid #27486f;
	touch-action: none;
}

.zo-game-root--roster-1000 .zo-r1-status {
	margin-top: 12px;
	min-height: 48px;
	padding: 12px 14px;
	border-radius: 14px;
	background: #eff6ff;
	border: 1px solid #bfdbfe;
	font-size: 14px;
	font-weight: 700;
	line-height: 1.45;
	color: #1d4ed8;
}

.zo-game-root--roster-1000 .zo-r1-side-head {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-game-root--roster-1000 .zo-r1-side-title {
	margin: 0;
	font-size: 20px;
}

.zo-game-root--roster-1000 .zo-r1-page-label {
	font-size: 13px;
	font-weight: 700;
	color: #5f7690;
}

.zo-game-root--roster-1000 .zo-r1-shop-meta {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 10px;
	margin-bottom: 10px;
}

.zo-game-root--roster-1000 .zo-r1-total {
	font-size: 13px;
	font-weight: 700;
	color: #47607d;
}

.zo-game-root--roster-1000 .zo-r1-jump {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 8px;
}

.zo-game-root--roster-1000 .zo-r1-input {
	width: 96px;
	border: 1px solid #bfdbfe;
	border-radius: 12px;
	padding: 10px 12px;
	font: inherit;
	font-size: 14px;
	color: #12335c;
	background: #ffffff;
}

.zo-game-root--roster-1000 .zo-r1-roster {
	display: grid;
	grid-template-columns: 1fr;
	gap: 10px;
	max-height: 620px;
	overflow: auto;
	padding-right: 4px;
}

.zo-game-root--roster-1000 .zo-r1-card {
	border: 1px solid #dbe8f4;
	border-radius: 16px;
	padding: 12px;
	background: #fbfdff;
}

.zo-game-root--roster-1000 .zo-r1-card.is-owned {
	background: #f0fdf4;
	border-color: #a7f3d0;
}

.zo-game-root--roster-1000 .zo-r1-card.is-selected {
	background: #fff7ed;
	border-color: #fdba74;
}

.zo-game-root--roster-1000 .zo-r1-card-top {
	display: flex;
	justify-content: space-between;
	gap: 8px;
	align-items: center;
	margin-bottom: 8px;
}

.zo-game-root--roster-1000 .zo-r1-card-name {
	font-size: 16px;
	font-weight: 800;
}

.zo-game-root--roster-1000 .zo-r1-card-badge {
	padding: 4px 8px;
	border-radius: 999px;
	font-size: 11px;
	font-weight: 800;
	text-transform: uppercase;
	background: #dbeafe;
	color: #1d4ed8;
}

.zo-game-root--roster-1000 .zo-r1-card-stats {
	display: grid;
	grid-template-columns: repeat(4, minmax(0, 1fr));
	gap: 8px;
	margin-bottom: 10px;
}

.zo-game-root--roster-1000 .zo-r1-mini {
	background: #f4f9ff;
	border: 1px solid #dbe8f4;
	border-radius: 12px;
	padding: 8px;
	text-align: center;
}

.zo-game-root--roster-1000 .zo-r1-mini strong {
	display: block;
	font-size: 15px;
}

.zo-game-root--roster-1000 .zo-r1-mini span {
	display: block;
	font-size: 11px;
	font-weight: 700;
	color: #5f7690;
	text-transform: uppercase;
}

.zo-game-root--roster-1000 .zo-r1-card-text {
	margin: 0 0 10px;
	font-size: 13px;
	line-height: 1.45;
	color: #47607d;
}

.zo-game-root--roster-1000 .zo-r1-card-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.zo-game-root--roster-1000 .zo-r1-help {
	margin-top: 12px;
	padding: 12px 14px;
	border-radius: 14px;
	background: #fffaf0;
	border: 1px solid #fde68a;
	font-size: 13px;
	line-height: 1.55;
	color: #7c5d18;
}

@media (max-width: 980px) {
	.zo-game-root--roster-1000 .zo-r1-topbar,
	.zo-game-root--roster-1000 .zo-r1-account,
	.zo-game-root--roster-1000 .zo-r1-layout {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 720px) {
	.zo-game-root--roster-1000 {
		padding: 10px;
	}

	.zo-game-root--roster-1000 .zo-r1-shell {
		padding: 12px;
	}

	.zo-game-root--roster-1000 .zo-r1-title {
		font-size: 28px;
	}

	.zo-game-root--roster-1000 .zo-r1-stat-grid,
	.zo-game-root--roster-1000 .zo-r1-card-stats {
		grid-template-columns: 1fr 1fr;
	}
}
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--roster-1000');

	games.forEach(function (game) {
		const canvas = game.querySelector('.zo-r1-canvas');
		if (!canvas) {
			return;
		}

		const ctx = canvas.getContext('2d');
		const startButton = game.querySelector('.zo-r1-start');
		const restartButton = game.querySelector('.zo-r1-restart');
		const nextButton = game.querySelector('.zo-r1-next');
		const prevPageButton = game.querySelector('.zo-r1-prev-page');
		const nextPageButton = game.querySelector('.zo-r1-next-page');
		const rosterEl = game.querySelector('.zo-r1-roster');
		const statusEl = game.querySelector('.zo-r1-status');
		const pageLabelEl = game.querySelector('.zo-r1-page-label');
		const totalEl = game.querySelector('.zo-r1-total');
		const jumpInput = game.querySelector('.zo-r1-jump-input');
		const jumpButton = game.querySelector('.zo-r1-jump-btn');
		const accountNameInput = game.querySelector('.zo-r1-account-name');
		const accountPinInput = game.querySelector('.zo-r1-account-pin');
		const accountCreateButton = game.querySelector('.zo-r1-account-create');
		const accountSigninButton = game.querySelector('.zo-r1-account-signin');
		const accountSignoutButton = game.querySelector('.zo-r1-account-signout');
		const accountStatusEl = game.querySelector('.zo-r1-account-status');

		const coinsEl = game.querySelector('.zo-r1-coins');
		const levelEl = game.querySelector('.zo-r1-level');
		const enemiesEl = game.querySelector('.zo-r1-enemies');
		const heroEl = game.querySelector('.zo-r1-hero');
		const winsEl = game.querySelector('.zo-r1-wins');

		const WIDTH = 760;
		const HEIGHT = 520;
		const HERO_RADIUS = 15;
		const ENEMY_RADIUS = 12;
		const PAGE_SIZE = 12;
		const TOTAL_CHARACTERS = 1000;
		const REWARD_PER_WIN = 50;
		const ACCOUNT_STORE_KEY = 'zoRoster1000AccountsV1';
		const ACCOUNT_SESSION_KEY = 'zoRoster1000CurrentAccountV1';
		const progressAjaxUrl = game.getAttribute('data-zo-progress-ajax') || '';
		const progressNonce = game.getAttribute('data-zo-progress-nonce') || '';
		const i18nNode = game.querySelector('.zo-r1-i18n');
		let i18n = {};

		try {
			i18n = i18nNode ? JSON.parse(i18nNode.textContent || '{}') : {};
		} catch (error) {
			i18n = {};
		}

		function t(key, fallback) {
			return i18n[key] || fallback || key;
		}

		function fmt(key, fallback, values) {
			let text = t(key, fallback);
			Object.keys(values || {}).forEach(function (name) {
				text = text.split('{' + name + '}').join(String(values[name]));
			});
			return text;
		}

		canvas.width = WIDTH;
		canvas.height = HEIGHT;

		const archetypes = [
			{name: t('sparkName', 'Spark'), speed: 1.35, power: 0.82, rate: 1.25, aura: '#fde047', bio: t('sparkBio', 'Fast feet and quick shots.')},
			{name: t('shieldName', 'Shield'), speed: 0.9, power: 1.05, rate: 0.86, aura: '#93c5fd', bio: t('shieldBio', 'Zorlu dalgalarda daha uzun dayanÄ±r.')},
			{name: t('novaName', 'Nova'), speed: 1.08, power: 1.18, rate: 0.94, aura: '#fca5a5', bio: t('novaBio', 'Dengeli kontrolle gÃ¼Ã§lÃ¼ vuruÅŸlar.')},
			{name: t('echoName', 'Echo'), speed: 1.16, power: 0.94, rate: 1.12, aura: '#c4b5fd', bio: t('echoBio', 'Dengeli arena duelist.')},
			{name: t('bloomName', 'Bloom'), speed: 1.02, power: 0.9, rate: 1.3, aura: '#86efac', bio: t('bloomBio', 'Seri ateÅŸ baskÄ±sÄ± uzmanÄ±.')},
			{name: t('stoneName', 'Stone'), speed: 0.84, power: 1.28, rate: 0.8, aura: '#fdba74', bio: t('stoneBio', 'YavaÅŸ, dayanÄ±klÄ± ve aÄŸÄ±r vuruÅŸlu.')}
		];

		const state = {
			running: false,
			levelActive: false,
			gameOver: false,
			coins: 150,
			level: 1,
			wins: 0,
			page: 0,
			lastTime: 0,
			selectedId: 1,
			owned: {1: true},
			keys: {
				up: false,
				down: false,
				left: false,
				right: false
			},
			hero: null,
			enemies: [],
			projectiles: [],
			spawnTimer: 0,
			spawned: 0,
			targetEnemyCount: 0,
			touchTarget: null,
			accountKey: '',
			accountPin: ''
		};

		function storageAvailable(type) {
			try {
				const storage = window[type];
				const key = '__zo_r1_storage_test__';
				storage.setItem(key, key);
				storage.removeItem(key);
				return true;
			} catch (error) {
				return false;
			}
		}

		const canStore = storageAvailable('localStorage');
		const canSessionStore = storageAvailable('sessionStorage');

		function readAccounts() {
			if (!canStore) {
				return {};
			}

			try {
				return JSON.parse(window.localStorage.getItem(ACCOUNT_STORE_KEY) || '{}') || {};
			} catch (error) {
				return {};
			}
		}

		function writeAccounts(accounts) {
			if (!canStore) {
				return false;
			}

			try {
				window.localStorage.setItem(ACCOUNT_STORE_KEY, JSON.stringify(accounts));
				return true;
			} catch (error) {
				return false;
			}
		}

		function normalizeAccountName(name) {
			return String(name || '').trim().toLowerCase().replace(/\s+/g, '-').slice(0, 32);
		}

		function cleanPin(pin) {
			return String(pin || '').replace(/\D/g, '').slice(0, 9);
		}

		function getProgress() {
			return {
				coins: state.coins,
				level: state.level,
				wins: state.wins,
				page: state.page,
				selectedId: state.selectedId,
				owned: state.owned
			};
		}

		function applyProgress(progress) {
			const owned = progress && progress.owned && typeof progress.owned === 'object' ? progress.owned : {1: true};
			owned[1] = true;
			state.coins = Math.max(0, parseInt(progress && progress.coins, 10) || 150);
			state.level = clamp(parseInt(progress && progress.level, 10) || 1, 1, 9999);
			state.wins = Math.max(0, parseInt(progress && progress.wins, 10) || 0);
			state.page = clamp(parseInt(progress && progress.page, 10) || 0, 0, Math.ceil(TOTAL_CHARACTERS / PAGE_SIZE) - 1);
			state.selectedId = clamp(parseInt(progress && progress.selectedId, 10) || 1, 1, TOTAL_CHARACTERS);
			state.owned = owned;
			if (!state.owned[state.selectedId]) {
				state.selectedId = 1;
			}
			resetForSelectedHero(false);
		}

		function setAccountStatus(text) {
			if (accountStatusEl) {
				accountStatusEl.textContent = text;
			}
		}

		function updateAccountUi() {
			const signedIn = !!state.accountKey;
			[startButton, restartButton, nextButton, prevPageButton, nextPageButton, jumpButton].forEach(function (button) {
				button.disabled = !signedIn;
			});
			game.querySelectorAll('.zo-r1-move').forEach(function (button) {
				button.disabled = !signedIn;
			});
			if (accountSignoutButton) {
				accountSignoutButton.disabled = !signedIn;
			}
			if (accountCreateButton) {
				accountCreateButton.disabled = !canStore;
			}
			if (accountSigninButton) {
				accountSigninButton.disabled = !canStore;
			}
		}

		function saveProgress() {
			if (!state.accountKey || !canStore) {
				return;
			}

			const accounts = readAccounts();
			if (!accounts[state.accountKey]) {
				return;
			}
			accounts[state.accountKey].progress = getProgress();
			writeAccounts(accounts);
			saveServerProgress(accounts[stat…5549 tokens truncated…== 'S') {
				state.keys.down = isDown;
			}
			if (key === 'ArrowLeft' || key === 'a' || key === 'A') {
				state.keys.left = isDown;
			}
			if (key === 'ArrowRight' || key === 'd' || key === 'D') {
				state.keys.right = isDown;
			}
		}

		game.addEventListener('keydown', function (event) {
			updateKeyState(true, event.key);
			if (/Arrow|w|a|s|d|W|A|S|D/.test(event.key)) {
				event.preventDefault();
			}
		});

		game.addEventListener('keyup', function (event) {
			updateKeyState(false, event.key);
		});

		canvas.addEventListener('pointerdown', function (event) {
			const rect = canvas.getBoundingClientRect();
			state.touchTarget = {
				x: (event.clientX - rect.left) * (WIDTH / rect.width),
				y: (event.clientY - rect.top) * (HEIGHT / rect.height)
			};
			game.focus();
		});

		canvas.addEventListener('pointermove', function (event) {
			if (!state.touchTarget) {
				return;
			}
			const rect = canvas.getBoundingClientRect();
			state.touchTarget = {
				x: (event.clientX - rect.left) * (WIDTH / rect.width),
				y: (event.clientY - rect.top) * (HEIGHT / rect.height)
			};
		});

		canvas.addEventListener('pointerup', function () {
			state.touchTarget = null;
		});

		canvas.addEventListener('pointerleave', function () {
			state.touchTarget = null;
		});

		game.querySelectorAll('.zo-r1-move').forEach(function (button) {
			const dir = button.getAttribute('data-dir');
			button.addEventListener('pointerdown', function () {
				state.keys[dir] = true;
				game.focus();
			});
			button.addEventListener('pointerup', function () {
				state.keys[dir] = false;
			});
			button.addEventListener('pointerleave', function () {
				state.keys[dir] = false;
			});
		});

		startButton.addEventListener('click', function () {
			if (!state.levelActive && !state.gameOver) {
				beginLevel();
				game.focus();
			}
		});

		nextButton.addEventListener('click', function () {
			if (!state.levelActive && !state.gameOver && state.level > 1) {
				beginLevel();
				game.focus();
			}
		});

		restartButton.addEventListener('click', function () {
			if (!requireAccount()) {
				return;
			}
			state.selectedId = 1;
			state.owned = {1: true};
			state.page = 0;
			resetForSelectedHero(true);
			saveProgress();
			game.focus();
		});

		prevPageButton.addEventListener('click', function () {
			if (!requireAccount()) {
				return;
			}
			state.page = Math.max(0, state.page - 1);
			renderRoster();
			updateHud();
			saveProgress();
		});

		nextPageButton.addEventListener('click', function () {
			if (!requireAccount()) {
				return;
			}
			state.page = Math.min(Math.ceil(TOTAL_CHARACTERS / PAGE_SIZE) - 1, state.page + 1);
			renderRoster();
			updateHud();
			saveProgress();
		});

		jumpButton.addEventListener('click', function () {
			jumpToHero();
		});

		jumpInput.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				event.preventDefault();
				jumpToHero();
			}
		});

		if (accountPinInput) {
			accountPinInput.addEventListener('input', function () {
				accountPinInput.value = cleanPin(accountPinInput.value);
			});
			accountPinInput.addEventListener('keydown', function (event) {
				if (event.key === 'Enter') {
					event.preventDefault();
					signinAccount();
				}
			});
		}

		if (accountCreateButton) {
			accountCreateButton.addEventListener('click', createAccount);
		}

		if (accountSigninButton) {
			accountSigninButton.addEventListener('click', signinAccount);
		}

		if (accountSignoutButton) {
			accountSignoutButton.addEventListener('click', signoutAccount);
		}

		if (!restoreAccountSession()) {
			resetForSelectedHero(true);
			updateAccountUi();
			setAccountStatus(t('accountRequired', 'Create an account or sign in with your PIN to play.'));
		}
		game.setAttribute('tabindex', '0');
	});
});
JS;

if (!function_exists('zo_game_roster_1000_render')) {
	function zo_game_roster_1000_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-roster-1000-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		$language    = function_exists('zo_get_current_language') ? zo_get_current_language() : 'tr';
		$translations = array(
			'en' => array(
				'title' => 'Roster 1000',
				'subtitle' => 'Fight through endless arena waves, earn 50 coins for every win, and grow your team by buying from a generated roster of 1000 heroes. Higher levels send more enemies with smarter movement and stronger attacks.',
				'coins' => 'Coins',
				'level' => 'Level',
				'enemies' => 'Enemies',
				'hero' => 'Hero',
				'wins' => 'Wins',
				'accountName' => 'Account',
				'pin' => 'PIN (4-9 digits)',
				'createAccount' => 'Create Account',
				'signIn' => 'Sign In',
				'signOut' => 'Sign Out',
				'accountNamePlaceholder' => 'Arslan',
				'pinPlaceholder' => '1234',
				'accountRequired' => 'Create an account or sign in with your PIN to play.',
				'signedInAs' => 'Signed in as {name}.',
				'storageBlocked' => 'This browser is blocking saved accounts.',
				'nameRequired' => 'Type an account name.',
				'pinRequired' => 'Make a PIN with 4 to 9 digits.',
				'accountExists' => 'That account already exists. Use Sign In.',
				'signinNeeded' => 'Enter your account name and a 4 to 9 digit PIN.',
				'badSignin' => 'Account name or PIN did not match.',
				'signedOut' => 'Signed out. Enter your PIN to play again.',
				'start' => 'Start',
				'nextWave' => 'Next Wave',
				'restartRun' => 'Restart Run',
				'up' => 'Up',
				'left' => 'Left',
				'down' => 'Down',
				'right' => 'Right',
				'help' => 'Use arrow keys or WASD on desktop. On mobile, tap the arena to move toward that point or use the move buttons. Clear each wave to earn 50 coins, then buy stronger characters.',
				'pickOrBuyStatus' => 'Bir karakter seÃ§ veya satÄ±n al, sonra BaÅŸlat dÃ¼ÄŸmesine bas. Temizlenen her dalga 50 coin verir.',
				'shopTitle' => '1000 Hero Shop',
				'prev' => 'Prev',
				'next' => 'Next',
				'pageLabel' => 'Sayfa {page} / {pages}',
				'showingHeroes' => 'Kahramanlar {from}-{to} / {total}',
				'heroPlaceholder' => 'Hero #',
				'jumpAria' => 'Jump to hero number',
				'go' => 'Go',
				'canvasLabel' => 'Roster 1000 arena',
				'hp' => 'HP',
				'power' => 'Power',
				'speed' => 'Speed',
				'rapid' => 'Rapid',
				'selected' => 'Selected',
				'select' => 'Select',
				'buy' => 'Buy',
				'costCoins' => 'Bedel: {price} coin.',
				'tierLabel' => 'Kademe {tier}',
				'sparkName' => 'Spark',
				'shieldName' => 'Shield',
				'novaName' => 'Nova',
				'echoName' => 'Echo',
				'bloomName' => 'Bloom',
				'stoneName' => 'Stone',
				'sparkBio' => 'Fast feet and quick shots.',
				'shieldBio' => 'Zorlu dalgalarda daha uzun dayanÄ±r.',
				'novaBio' => 'Dengeli kontrolle gÃ¼Ã§lÃ¼ vuruÅŸlar.',
				'echoBio' => 'Dengeli arena duelist.',
				'bloomBio' => 'Seri ateÅŸ baskÄ±sÄ± uzmanÄ±.',
				'stoneBio' => 'YavaÅŸ, dayanÄ±klÄ± ve aÄŸÄ±r vuruÅŸlu.',
				'levelStarted' => 'Seviye {level} baÅŸladÄ±. DÃ¼ÅŸmanlar her dalgada daha gÃ¼Ã§lÃ¼ ve daha kalabalÄ±k olur.',
				'waveCleared' => 'Dalga temizlendi. 50 coin kazandÄ±n. {level}. seviye iÃ§in hazÄ±r olduÄŸunda Sonraki Dalga dÃ¼ÄŸmesine bas.',
				'heroDefeated' => 'KahramanÄ±n {level}. seviyede yenildi. Daha gÃ¼Ã§lÃ¼ bir karakter al veya koÅŸuyu yeniden baÅŸlat.',
				'heroSelected' => '{name} is now selected.',
				'notEnoughCoins' => '{name} iÃ§in yeterli coin yok. Her seferinde 50 coin kazanmak iÃ§in daha fazla dalga temizle.',
				'boughtHero' => '{name}, {price} coin karÅŸÄ±lÄ±ÄŸÄ±nda alÄ±ndÄ±.',
				'enterHeroNumber' => '1 ile 1000 arasÄ±nda bir kahraman numarasÄ± gir.',
				'jumpedToHero' => 'Jumped to hero #{id}.',
				'runOver' => 'Run Over',
				'restartOrBuy' => 'Yeniden baÅŸla veya kadrodan daha gÃ¼Ã§lÃ¼ bir savaÅŸÃ§Ä± al.',
				'arenaTitle' => '1000 Kadro ArenasÄ±',
				'pressStartRun' => 'Press Start to begin your run.',
				'pressNextWave' => 'Press Next Wave to continue to level {level}.',
			),
			'tr' => array(
				'title' => '1000 Karakter ArenasÄ±',
				'subtitle' => 'Sonsuz arena dalgalarÄ±nda savaÅŸ, her galibiyette 50 coin kazan ve 1000 kahramanlÄ±k listeden satÄ±n alarak takÄ±mÄ±nÄ± bÃ¼yÃ¼t. YÃ¼ksek seviyeler daha akÄ±llÄ± hareket eden ve daha gÃ¼Ã§lÃ¼ saldÄ±ran daha fazla dÃ¼ÅŸman gÃ¶nderir.',
				'coins' => 'Coin',
				'level' => 'Seviye',
				'enemies' => 'DÃ¼ÅŸmanlar',
				'hero' => 'Kahraman',
				'wins' => 'Galibiyet',
				'accountName' => 'Hesap',
				'pin' => 'PIN (4-9 hane)',
				'createAccount' => 'Hesap OluÅŸtur',
				'signIn' => 'GiriÅŸ Yap',
				'signOut' => 'Ã‡Ä±kÄ±ÅŸ',
				'accountNamePlaceholder' => 'Arslan',
				'pinPlaceholder' => '1234',
				'accountRequired' => 'Oynamak iÃ§in hesap oluÅŸtur veya PIN ile giriÅŸ yap.',
				'signedInAs' => '{name} olarak giriÅŸ yapÄ±ldÄ±.',
				'storageBlocked' => 'Bu tarayÄ±cÄ± kayÄ±tlÄ± hesaplarÄ± engelliyor.',
				'nameRequired' => 'Bir hesap adÄ± yaz.',
				'pinRequired' => '4-9 haneli bir PIN yap.',
				'accountExists' => 'Bu hesap zaten var. GiriÅŸ Yap kullan.',
				'signinNeeded' => 'Hesap adÄ±nÄ± ve 4-9 haneli PIN gir.',
				'badSignin' => 'Hesap adÄ± veya PIN eÅŸleÅŸmedi.',
				'signedOut' => 'Ã‡Ä±kÄ±ÅŸ yapÄ±ldÄ±. Tekrar oynamak iÃ§in PIN gir.',
				'start' => 'BaÅŸlat',
				'nextWave' => 'Sonraki Dalga',
				'restartRun' => 'KoÅŸuyu Yeniden BaÅŸlat',
				'up' => 'YukarÄ±',
				'left' => 'Sol',
				'down' => 'AÅŸaÄŸÄ±',
				'right' => 'SaÄŸ',
				'help' => 'Bilgisayarda ok tuÅŸlarÄ±nÄ± veya WASD kullan. Mobilde o noktaya gitmek iÃ§in arenaya dokun veya hareket dÃ¼ÄŸmelerini kullan. Her dalgayÄ± temizleyip 50 coin kazan, sonra daha gÃ¼Ã§lÃ¼ karakterler satÄ±n al.',
				'pickOrBuyStatus' => 'Bir karakter seÃ§ veya satÄ±n al, sonra BaÅŸlatâ€™a bas. Temizlenen her dalga 50 coin verir.',
				'shopTitle' => '1000 Kahraman MaÄŸazasÄ±',
				'prev' => 'Ã–nceki',
				'next' => 'Sonraki',
				'pageLabel' => 'Sayfa {page} / {pages}',
				'showingHeroes' => 'Kahramanlar {from}-{to} / {total}',
				'heroPlaceholder' => 'Kahraman #',
				'jumpAria' => 'Kahraman numarasÄ±na git',
				'go' => 'Git',
				'canvasLabel' => '1000 Karakter ArenasÄ±',
				'hp' => 'Can',
				'power' => 'GÃ¼Ã§',
				'speed' => 'HÄ±z',
				'rapid' => 'Seri',
				'selected' => 'SeÃ§ili',
				'select' => 'SeÃ§',
				'buy' => 'SatÄ±n Al',
				'costCoins' => 'Bedel: {price} coin.',
				'tierLabel' => 'Kademe {tier}',
				'sparkName' => 'KÄ±vÄ±lcÄ±m',
				'shieldName' => 'Kalkan',
				'novaName' => 'Nova',
				'echoName' => 'YankÄ±',
				'bloomName' => 'Ã‡iÃ§ek',
				'stoneName' => 'TaÅŸ',
				'sparkBio' => 'HÄ±zlÄ± ayaklar ve seri atÄ±ÅŸlar.',
				'shieldBio' => 'Zorlu dalgalarda daha uzun dayanÄ±r.',
				'novaBio' => 'Dengeli kontrolle gÃ¼Ã§lÃ¼ vuruÅŸlar yapar.',
				'echoBio' => 'Dengeli bir arena dÃ¼ellocusu.',
				'bloomBio' => 'Seri atÄ±ÅŸ baskÄ±sÄ±nda uzmandÄ±r.',
				'stoneBio' => 'YavaÅŸ, dayanÄ±klÄ± ve aÄŸÄ±r vuruÅŸludur.',
				'levelStarted' => 'Seviye {level} baÅŸladÄ±. DÃ¼ÅŸmanlar her dalgada daha gÃ¼Ã§lÃ¼ ve daha kalabalÄ±k olur.',
				'waveCleared' => 'Dalga temizlendi. 50 coin kazandÄ±n. {level}. seviye iÃ§in hazÄ±r olduÄŸunda Sonraki Dalgaâ€™ya bas.',
				'heroDefeated' => 'KahramanÄ±n {level}. seviyede yenildi. Daha gÃ¼Ã§lÃ¼ bir karakter al veya koÅŸuyu yeniden baÅŸlat.',
				'heroSelected' => '{name} artÄ±k seÃ§ili.',
				'notEnoughCoins' => '{name} iÃ§in yeterli coin yok. Her dalgada 50 coin kazanmak iÃ§in daha fazla dalga temizle.',
				'boughtHero' => '{name}, {price} coin karÅŸÄ±lÄ±ÄŸÄ±nda alÄ±ndÄ±.',
				'enterHeroNumber' => '1 ile 1000 arasÄ±nda bir kahraman numarasÄ± gir.',
				'jumpedToHero' => 'Kahraman #{id} bÃ¶lÃ¼mÃ¼ne gidildi.',
				'runOver' => 'KoÅŸu Bitti',
				'restartOrBuy' => 'Yeniden baÅŸla veya listeden daha gÃ¼Ã§lÃ¼ bir savaÅŸÃ§Ä± al.',
				'arenaTitle' => '1000 Karakter ArenasÄ±',
				'pressStartRun' => 'KoÅŸuya baÅŸlamak iÃ§in BaÅŸlatâ€™a bas.',
				'pressNextWave' => '{level}. seviyeye devam etmek iÃ§in Sonraki Dalgaâ€™ya bas.',
			),
		);
		$i18n = array_merge($translations['en'], isset($translations[$language]) ? $translations[$language] : array());
		$r1 = static function ($key, $values = array()) use ($i18n) {
			$text = isset($i18n[$key]) ? $i18n[$key] : '';
			foreach ($values as $name => $value) {
				$text = str_replace('{' . $name . '}', (string) $value, $text);
			}
			return $text;
		};
		$progress_ajax_url = admin_url('admin-ajax.php');
		$progress_nonce = wp_create_nonce('zo_roster_1000_progress');

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--roster-1000" id="<?php echo esc_attr($instance_id); ?>" data-zo-progress-ajax="<?php echo esc_url($progress_ajax_url); ?>" data-zo-progress-nonce="<?php echo esc_attr($progress_nonce); ?>">
			<script type="application/json" class="zo-r1-i18n"><?php echo wp_json_encode($i18n); ?></script>
			<div class="zo-r1-shell">
				<h2 class="zo-r1-title"><?php echo esc_html($r1('title')); ?></h2>
				<p class="zo-r1-subtitle"><?php echo esc_html($r1('subtitle')); ?></p>

				<div class="zo-r1-account" id="zo-roster-account">
					<div class="zo-r1-account-fields">
						<div class="zo-r1-field">
							<label for="<?php echo esc_attr($instance_id); ?>-account"><?php echo esc_html($r1('accountName')); ?></label>
							<input type="text" class="zo-r1-input zo-r1-account-name" id="<?php echo esc_attr($instance_id); ?>-account" maxlength="32" autocomplete="username" placeholder="<?php echo esc_attr($r1('accountNamePlaceholder')); ?>">
						</div>
						<div class="zo-r1-field">
							<label for="<?php echo esc_attr($instance_id); ?>-pin"><?php echo esc_html($r1('pin')); ?></label>
							<input type="password" class="zo-r1-input zo-r1-account-pin" id="<?php echo esc_attr($instance_id); ?>-pin" inputmode="numeric" pattern="[0-9]{4,9}" minlength="4" maxlength="9" autocomplete="current-password" placeholder="<?php echo esc_attr($r1('pinPlaceholder')); ?>">
						</div>
					</div>
					<div class="zo-r1-account-actions">
						<button type="button" class="zo-r1-btn zo-r1-btn--primary zo-r1-account-create"><?php echo esc_html($r1('createAccount')); ?></button>
						<button type="button" class="zo-r1-btn zo-r1-btn--secondary zo-r1-account-signin"><?php echo esc_html($r1('signIn')); ?></button>
						<button type="button" class="zo-r1-btn zo-r1-btn--warn zo-r1-account-signout"><?php echo esc_html($r1('signOut')); ?></button>
					</div>
					<div class="zo-r1-account-status" aria-live="polite"><?php echo esc_html($r1('accountRequired')); ?></div>
				</div>

				<div class="zo-r1-topbar">
					<div class="zo-r1-stats">
						<div class="zo-r1-stat-grid">
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label"><?php echo esc_html($r1('coins')); ?></span>
								<span class="zo-r1-stat-value zo-r1-coins">150</span>
							</div>
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label"><?php echo esc_html($r1('level')); ?></span>
								<span class="zo-r1-stat-value zo-r1-level">1</span>
							</div>
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label"><?php echo esc_html($r1('enemies')); ?></span>
								<span class="zo-r1-stat-value zo-r1-enemies">0</span>
							</div>
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label"><?php echo esc_html($r1('hero')); ?></span>
								<span class="zo-r1-stat-value zo-r1-stat-value--hero zo-r1-hero"><?php echo esc_html($r1('sparkName')); ?> #1</span>
							</div>
							<div class="zo-r1-stat">
								<span class="zo-r1-stat-label"><?php echo esc_html($r1('wins')); ?></span>
								<span class="zo-r1-stat-value zo-r1-wins">0</span>
							</div>
						</div>
					</div>

					<div class="zo-r1-controls">
						<div class="zo-r1-button-row">
							<button type="button" class="zo-r1-btn zo-r1-btn--primary zo-r1-start"><?php echo esc_html($r1('start')); ?></button>
							<button type="button" class="zo-r1-btn zo-r1-btn--secondary zo-r1-next"><?php echo esc_html($r1('nextWave')); ?></button>
							<button type="button" class="zo-r1-btn zo-r1-btn--warn zo-r1-restart"><?php echo esc_html($r1('restartRun')); ?></button>
						</div>
						<div class="zo-r1-pad">
							<button type="button" class="zo-r1-btn zo-r1-move" data-dir="up"><?php echo esc_html($r1('up')); ?></button>
							<button type="button" class="zo-r1-btn zo-r1-move" data-dir="left"><?php echo esc_html($r1('left')); ?></button>
							<button type="button" class="zo-r1-btn zo-r1-move" data-dir="down"><?php echo esc_html($r1('down')); ?></button>
							<button type="button" class="zo-r1-btn zo-r1-move" data-dir="right"><?php echo esc_html($r1('right')); ?></button>
						</div>
						<div class="zo-r1-help"><?php echo esc_html($r1('help')); ?></div>
					</div>
				</div>

				<div class="zo-r1-layout">
					<div class="zo-r1-arena-wrap">
						<canvas class="zo-r1-canvas" width="760" height="520" aria-label="<?php echo esc_attr($r1('canvasLabel')); ?>"></canvas>
						<div class="zo-r1-status" aria-live="polite"><?php echo esc_html($r1('pickOrBuyStatus')); ?></div>
					</div>

					<div class="zo-r1-side">
						<div class="zo-r1-side-head">
							<h3 class="zo-r1-side-title"><?php echo esc_html($r1('shopTitle')); ?></h3>
							<div class="zo-r1-button-row">
								<button type="button" class="zo-r1-page-btn zo-r1-prev-page"><?php echo esc_html($r1('prev')); ?></button>
								<span class="zo-r1-page-label"><?php echo esc_html($r1('pageLabel', array('page' => 1, 'pages' => 84))); ?></span>
								<button type="button" class="zo-r1-page-btn zo-r1-next-page"><?php echo esc_html($r1('next')); ?></button>
							</div>
						</div>

						<div class="zo-r1-shop-meta">
							<div class="zo-r1-total"><?php echo esc_html($r1('showingHeroes', array('from' => 1, 'to' => 12, 'total' => 1000))); ?></div>
							<div class="zo-r1-jump">
								<input type="number" min="1" max="1000" step="1" class="zo-r1-input zo-r1-jump-input" placeholder="<?php echo esc_attr($r1('heroPlaceholder')); ?>" aria-label="<?php echo esc_attr($r1('jumpAria')); ?>">
								<button type="button" class="zo-r1-btn zo-r1-btn--secondary zo-r1-jump-btn"><?php echo esc_html($r1('go')); ?></button>
							</div>
						</div>

						<div class="zo-r1-roster"></div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

return array(
	'slug'            => 'roster-1000',
	'name'            => 'TR: 1000 Karakter ArenasÄ± | EN: Roster 1000 | DE: Roster 1000 | FR: Roster 1000 | ES-MX: Roster 1000 | ES-ES: Roster 1000',
	'author'          => 'Asker',
	'description'     => 'TR: 1000 satÄ±n alÄ±nabilir karakter, her seviyede zorlaÅŸan yapay zeka, her dalgada daha fazla dÃ¼ÅŸman ve her galibiyette 50 coin sunan sonsuz bir arena oyunu. | EN: An endless arena game with 1000 buyable characters, harder AI every level, more enemies per wave, and 50 coins for every win. | DE: Ein endloses Arena-Spiel mit 1000 kaufbaren Figuren, schwierigerer KI pro Level, mehr Gegnern pro Welle und 50 MÃ¼nzen fÃ¼r jeden Sieg. | FR: Un jeu dâ€™arÃ¨ne sans fin avec 1000 personnages Ã  acheter, une IA plus difficile Ã  chaque niveau, plus dâ€™ennemis par vague et 50 piÃ¨ces par victoire. | ES-MX: Un juego de arena sin fin con 1000 personajes comprables, IA mÃ¡s difÃ­cil en cada nivel, mÃ¡s enemigos por oleada y 50 monedas por victoria. | ES-ES: Un juego de arena sin fin con 1000 personajes comprables, IA mÃ¡s difÃ­cil en cada nivel, mÃ¡s enemigos por oleada y 50 monedas por victoria.',
	'render_callback' => 'zo_game_roster_1000_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);

