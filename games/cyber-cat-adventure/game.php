<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'cyber-cat-adventure',
	'name' => 'Cyber Cat Adventure',
	'description' => 'A neon cat collects data fish in a cyber city.',
	'goal' => 'Collect data fish and avoid security drones in the neon streets.',
	'hero' => 'Cat',
	'item' => 'Data',
	'hazard' => 'Drone',
	'heroColor' => '#f9a8d4',
	'itemColor' => '#22d3ee',
	'hazardColor' => '#f43f5e',
	'accent' => '#22d3ee',
	'bgA' => '#111827',
	'bgB' => '#0e7490',
	'target' => 210,
	'difficulty' => 2,
	'speed' => 16,
));
