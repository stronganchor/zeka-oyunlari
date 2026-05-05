<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'dino-island-rescue',
	'name' => 'Dino Island Rescue',
	'description' => 'Rescue supply packs on a dinosaur island.',
	'goal' => 'Collect rescue packs and avoid stomping dino tracks.',
	'hero' => 'Ranger',
	'item' => 'Pack',
	'hazard' => 'Dino',
	'heroColor' => '#86efac',
	'itemColor' => '#fbbf24',
	'hazardColor' => '#16a34a',
	'accent' => '#fbbf24',
	'bgA' => '#166534',
	'bgB' => '#0f766e',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 6,
));
