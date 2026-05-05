<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'castle-siege-commander',
	'name' => 'Castle Siege Commander',
	'description' => 'Collect command flags during a castle siege.',
	'goal' => 'Collect command flags and dodge catapult stones to win the siege.',
	'hero' => 'Chief',
	'item' => 'Flag',
	'hazard' => 'Stone',
	'heroColor' => '#fef3c7',
	'itemColor' => '#ef4444',
	'hazardColor' => '#78716c',
	'accent' => '#ef4444',
	'bgA' => '#44403c',
	'bgB' => '#7f1d1d',
	'target' => 200,
	'difficulty' => 3,
	'speed' => 6,
));
