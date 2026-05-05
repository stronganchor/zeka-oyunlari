<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'mini-golf-planets',
	'name' => 'Mini Golf Planets',
	'description' => 'Putt across tiny planets in space.',
	'goal' => 'Collect golf flags and dodge gravity rocks around mini planets.',
	'hero' => 'Ball',
	'item' => 'Flag',
	'hazard' => 'Rock',
	'heroColor' => '#f8fafc',
	'itemColor' => '#22c55e',
	'hazardColor' => '#a855f7',
	'accent' => '#22c55e',
	'bgA' => '#020617',
	'bgB' => '#581c87',
	'target' => 180,
	'difficulty' => 2,
	'speed' => 5,
));
