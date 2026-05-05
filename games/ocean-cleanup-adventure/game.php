<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'ocean-cleanup-adventure',
	'name' => 'Ocean Cleanup Adventure',
	'description' => 'Clean the ocean by collecting trash safely.',
	'goal' => 'Collect cleanup bags and dodge rough waves to protect the ocean.',
	'hero' => 'Boat',
	'item' => 'Trash',
	'hazard' => 'Wave',
	'heroColor' => '#facc15',
	'itemColor' => '#22c55e',
	'hazardColor' => '#38bdf8',
	'accent' => '#22c55e',
	'bgA' => '#0369a1',
	'bgB' => '#0f766e',
	'target' => 210,
	'difficulty' => 2,
	'speed' => 8,
));
