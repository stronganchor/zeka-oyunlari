<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'soccer-with-power-ups',
	'name' => 'Soccer With Power-Ups',
	'description' => 'Collect power-ups on a wild soccer field.',
	'goal' => 'Collect power-ups and dodge sliding tackles to control the match.',
	'hero' => 'Player',
	'item' => 'Power',
	'hazard' => 'Tackle',
	'heroColor' => '#f8fafc',
	'itemColor' => '#facc15',
	'hazardColor' => '#ef4444',
	'accent' => '#facc15',
	'bgA' => '#166534',
	'bgB' => '#15803d',
	'target' => 210,
	'difficulty' => 2,
	'speed' => 14,
));
