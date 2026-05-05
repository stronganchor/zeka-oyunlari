<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'firefighter-rescue-city',
	'name' => 'Firefighter Rescue City',
	'description' => 'Collect water tanks and rescue a smoky city.',
	'goal' => 'Collect water tanks and dodge fire bursts to protect the city.',
	'hero' => 'Truck',
	'item' => 'Water',
	'hazard' => 'Fire',
	'heroColor' => '#ef4444',
	'itemColor' => '#38bdf8',
	'hazardColor' => '#f97316',
	'accent' => '#38bdf8',
	'bgA' => '#374151',
	'bgB' => '#7f1d1d',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 8,
));
