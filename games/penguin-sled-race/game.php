<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'penguin-sled-race',
	'name' => 'Penguin Sled Race',
	'description' => 'Slide down ice lanes collecting fish flags.',
	'goal' => 'Collect fish flags and dodge snow bumps in the sled race.',
	'hero' => 'Sled',
	'item' => 'Fish',
	'hazard' => 'Snow',
	'heroColor' => '#111827',
	'itemColor' => '#67e8f9',
	'hazardColor' => '#f8fafc',
	'accent' => '#67e8f9',
	'bgA' => '#0e7490',
	'bgB' => '#dbeafe',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 16,
));
