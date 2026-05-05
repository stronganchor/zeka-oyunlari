<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'time-travel-parkour',
	'name' => 'Time-Travel Parkour',
	'description' => 'Leap across time rifts and collect clock shards.',
	'goal' => 'Collect clock shards to stabilize the timeline while dodging time rifts.',
	'hero' => 'Leap',
	'item' => 'Clock',
	'hazard' => 'Rift',
	'heroColor' => '#a78bfa',
	'itemColor' => '#facc15',
	'hazardColor' => '#fb7185',
	'accent' => '#facc15',
	'bgA' => '#312e81',
	'bgB' => '#155e75',
	'target' => 190,
	'difficulty' => 2,
	'speed' => 12,
));
