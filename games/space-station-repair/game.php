<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'space-station-repair',
	'name' => 'Space Station Repair',
	'description' => 'Repair a station by collecting tool parts.',
	'goal' => 'Collect repair tools and dodge electrical sparks in the station.',
	'hero' => 'Crew',
	'item' => 'Tool',
	'hazard' => 'Spark',
	'heroColor' => '#e2e8f0',
	'itemColor' => '#22d3ee',
	'hazardColor' => '#facc15',
	'accent' => '#22d3ee',
	'bgA' => '#020617',
	'bgB' => '#334155',
	'target' => 210,
	'difficulty' => 3,
	'speed' => 8,
));
