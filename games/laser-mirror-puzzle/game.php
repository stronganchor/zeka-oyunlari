<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'laser-mirror-puzzle',
	'name' => 'Laser Mirror Puzzle',
	'description' => 'Collect mirror chips and avoid laser beams.',
	'goal' => 'Collect mirror chips and dodge laser beams to solve the light puzzle.',
	'hero' => 'Mirror',
	'item' => 'Chip',
	'hazard' => 'Laser',
	'heroColor' => '#e0f2fe',
	'itemColor' => '#22d3ee',
	'hazardColor' => '#ef4444',
	'accent' => '#22d3ee',
	'bgA' => '#0f172a',
	'bgB' => '#0e7490',
	'target' => 200,
	'difficulty' => 3,
	'speed' => 7,
));
