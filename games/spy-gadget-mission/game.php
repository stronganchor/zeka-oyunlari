<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'spy-gadget-mission',
	'name' => 'Spy Gadget Mission',
	'description' => 'Sneak through lasers and collect spy gadgets.',
	'goal' => 'Collect gadgets and dodge laser scanners to complete the mission.',
	'hero' => 'Spy',
	'item' => 'Gadget',
	'hazard' => 'Laser',
	'heroColor' => '#94a3b8',
	'itemColor' => '#22c55e',
	'hazardColor' => '#ef4444',
	'accent' => '#22c55e',
	'bgA' => '#020617',
	'bgB' => '#1f2937',
	'target' => 200,
	'difficulty' => 3,
	'speed' => 10,
));
