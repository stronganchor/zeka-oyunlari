<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'monster-cooking-contest',
	'name' => 'Monster Cooking Contest',
	'description' => 'Collect ingredients for a funny monster feast.',
	'goal' => 'Collect tasty ingredients and dodge spicy smoke clouds.',
	'hero' => 'Chef',
	'item' => 'Food',
	'hazard' => 'Smoke',
	'heroColor' => '#fed7aa',
	'itemColor' => '#a3e635',
	'hazardColor' => '#6b7280',
	'accent' => '#a3e635',
	'bgA' => '#7c2d12',
	'bgB' => '#166534',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 4,
));
