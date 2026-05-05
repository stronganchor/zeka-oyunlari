<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'tiny-city-giant',
	'name' => 'Tiny City Giant',
	'description' => 'A gentle giant collects repair kits in a tiny city.',
	'goal' => 'Collect repair kits for tiny buildings and avoid traffic swarms.',
	'hero' => 'Giant',
	'item' => 'Kit',
	'hazard' => 'Cars',
	'heroColor' => '#fdba74',
	'itemColor' => '#4ade80',
	'hazardColor' => '#f43f5e',
	'accent' => '#4ade80',
	'bgA' => '#1e40af',
	'bgB' => '#334155',
	'target' => 180,
	'difficulty' => 2,
	'speed' => 0,
));
