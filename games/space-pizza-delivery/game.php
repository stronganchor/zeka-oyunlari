<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'space-pizza-delivery',
	'name' => 'Space Pizza Delivery',
	'description' => 'Pilot through orbit to deliver hot space pizza.',
	'goal' => 'Collect pizza crates and avoid asteroids before the delivery timer ends.',
	'hero' => 'Ship',
	'item' => 'Pizza',
	'hazard' => 'Rock',
	'heroColor' => '#22d3ee',
	'itemColor' => '#fb923c',
	'hazardColor' => '#64748b',
	'accent' => '#fb923c',
	'bgA' => '#020617',
	'bgB' => '#1e3a8a',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 14,
));
