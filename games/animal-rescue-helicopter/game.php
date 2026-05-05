<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'animal-rescue-helicopter',
	'name' => 'Animal Rescue Helicopter',
	'description' => 'Fly a rescue helicopter and collect emergency kits.',
	'goal' => 'Collect rescue kits and dodge storm clouds to save the animals.',
	'hero' => 'Heli',
	'item' => 'Kit',
	'hazard' => 'Storm',
	'heroColor' => '#facc15',
	'itemColor' => '#22c55e',
	'hazardColor' => '#64748b',
	'accent' => '#facc15',
	'bgA' => '#0369a1',
	'bgB' => '#16a34a',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 12,
));
