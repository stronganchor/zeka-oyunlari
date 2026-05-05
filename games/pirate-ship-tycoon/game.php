<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'pirate-ship-tycoon',
	'name' => 'Pirate Ship Tycoon',
	'description' => 'Collect gold crates to upgrade a pirate ship.',
	'goal' => 'Gather gold crates and dodge cannonballs to grow your pirate fleet.',
	'hero' => 'Ship',
	'item' => 'Gold',
	'hazard' => 'Cannon',
	'heroColor' => '#0ea5e9',
	'itemColor' => '#facc15',
	'hazardColor' => '#1f2937',
	'accent' => '#facc15',
	'bgA' => '#0c4a6e',
	'bgB' => '#854d0e',
	'target' => 220,
	'difficulty' => 2,
	'speed' => 5,
));
