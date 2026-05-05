<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'moon-base-builder',
	'name' => 'Moon Base Builder',
	'description' => 'Collect modules and build a moon base under meteor pressure.',
	'goal' => 'Gather base modules and dodge falling meteors to complete the moon station.',
	'hero' => 'Rover',
	'item' => 'Panel',
	'hazard' => 'Meteor',
	'heroColor' => '#cbd5e1',
	'itemColor' => '#38bdf8',
	'hazardColor' => '#f97316',
	'accent' => '#38bdf8',
	'bgA' => '#1e293b',
	'bgB' => '#475569',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 2,
));
