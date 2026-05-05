<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'supermarket-dash',
	'name' => 'Supermarket Dash',
	'description' => 'Dash through aisles collecting groceries.',
	'goal' => 'Collect grocery items and dodge runaway shopping carts.',
	'hero' => 'Dash',
	'item' => 'Food',
	'hazard' => 'Cart',
	'heroColor' => '#f8fafc',
	'itemColor' => '#22c55e',
	'hazardColor' => '#ef4444',
	'accent' => '#22c55e',
	'bgA' => '#0f766e',
	'bgB' => '#ca8a04',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 14,
));
