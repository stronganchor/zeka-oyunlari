<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'racing-through-volcanoes',
	'name' => 'Racing Through Volcanoes',
	'description' => 'Race through lava tunnels collecting boost rings.',
	'goal' => 'Grab boost rings and dodge lava bursts on the volcano track.',
	'hero' => 'Racer',
	'item' => 'Boost',
	'hazard' => 'Lava',
	'heroColor' => '#fef3c7',
	'itemColor' => '#22c55e',
	'hazardColor' => '#dc2626',
	'accent' => '#f97316',
	'bgA' => '#450a0a',
	'bgB' => '#9a3412',
	'target' => 220,
	'difficulty' => 3,
	'speed' => 18,
));
