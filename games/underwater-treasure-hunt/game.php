<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'underwater-treasure-hunt',
	'name' => 'Underwater Treasure Hunt',
	'description' => 'Dive for pearls and treasure under the sea.',
	'goal' => 'Collect pearls and treasure coins while avoiding drifting mines.',
	'hero' => 'Diver',
	'item' => 'Pearl',
	'hazard' => 'Mine',
	'heroColor' => '#67e8f9',
	'itemColor' => '#fef9c3',
	'hazardColor' => '#0f172a',
	'accent' => '#67e8f9',
	'bgA' => '#075985',
	'bgB' => '#0f766e',
	'target' => 190,
	'difficulty' => 1,
	'speed' => 4,
));
