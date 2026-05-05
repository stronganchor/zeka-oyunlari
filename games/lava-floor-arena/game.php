<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'lava-floor-arena',
	'name' => 'Lava Floor Arena',
	'description' => 'Collect safe stones while the lava floor attacks.',
	'goal' => 'Collect safe stones and dodge lava waves in the arena.',
	'hero' => 'Jumper',
	'item' => 'Stone',
	'hazard' => 'Lava',
	'heroColor' => '#fde68a',
	'itemColor' => '#a7f3d0',
	'hazardColor' => '#ef4444',
	'accent' => '#f97316',
	'bgA' => '#7f1d1d',
	'bgB' => '#111827',
	'target' => 190,
	'difficulty' => 3,
	'speed' => 12,
));
