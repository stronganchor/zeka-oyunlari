<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
 * SECURITY HARD-DISABLE (2026-08-12)
 *
 * Roster 1000 previously shipped with a generated truncation marker and
 * browser-stored short PINs. A later regression restored anonymous account
 * and progress endpoints. Keep this module limited to the disabled response
 * until an adult maintainer approves a replacement that meets AGENTS.md and
 * SECURITY.md, including a written threat model and abuse controls.
 */
function zo_game_roster_1000_security_disabled_render() {
	return '<div class="zo-game-security-disabled" role="status"><h2>Roster 1000 is temporarily unavailable</h2><p>This game was disabled while its account and saved-progress code is rebuilt safely.</p></div>';
}

$zo_roster_1000_security_cleanup = <<<'JS'
try {
	window.localStorage.removeItem('zoRoster1000AccountsV1');
	window.localStorage.removeItem('zoRoster1000CurrentAccountV1');
} catch (error) {}
try {
	window.sessionStorage.removeItem('zoSharedCurrentAccountV1');
	window.sessionStorage.removeItem('zoSharedCurrentPinV1');
	window.sessionStorage.removeItem('zoRoster1000CurrentAccountV1');
} catch (error) {}
JS;

return array(
	'slug'            => 'roster-1000',
	'name'            => 'Roster 1000 (temporarily disabled for security)',
	'author'          => 'Asker',
	'description'     => 'Temporarily disabled while the account and saved-progress implementation receives an adult security review.',
	'render_callback' => 'zo_game_roster_1000_security_disabled_render',
	'inline_style'    => '.zo-game-security-disabled{max-width:720px;margin:24px auto;padding:24px;border:2px solid #b45309;border-radius:16px;background:#fff7ed;color:#7c2d12}.zo-game-security-disabled h2{margin:0 0 8px}.zo-game-security-disabled p{margin:0}',
	'inline_script'   => $zo_roster_1000_security_cleanup,
);
