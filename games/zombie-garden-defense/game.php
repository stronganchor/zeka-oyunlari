<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'zombie-garden-defense',
	'name' => 'Zombie Garden Defense',
	'description' => 'Collect seed power and protect the garden.',
	'goal' => 'Collect seed power and dodge zombie weeds before they overrun the garden.',
	'hero' => 'Plant',
	'item' => 'Seed',
	'hazard' => 'Weed',
	'heroColor' => '#4ade80',
	'itemColor' => '#fef08a',
	'hazardColor' => '#15803d',
	'accent' => '#4ade80',
	'bgA' => '#14532d',
	'bgB' => '#3f6212',
	'target' => 210,
	'difficulty' => 3,
	'speed' => 8,
));
