<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'magnetic-robot-puzzle',
	'name' => 'Magnetic Robot Puzzle',
	'description' => 'Collect magnet cores in a robot lab.',
	'goal' => 'Collect magnet cores and dodge polarity shocks in the robot puzzle lab.',
	'hero' => 'Robot',
	'item' => 'Core',
	'hazard' => 'Shock',
	'heroColor' => '#94a3b8',
	'itemColor' => '#38bdf8',
	'hazardColor' => '#f97316',
	'accent' => '#38bdf8',
	'bgA' => '#1f2937',
	'bgB' => '#0f766e',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 6,
));
