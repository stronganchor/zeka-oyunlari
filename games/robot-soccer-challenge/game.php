<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'robot-soccer-challenge',
	'name' => 'Robot Soccer Challenge',
	'description' => 'Drive a robot striker through a robotic soccer drill.',
	'goal' => 'Grab power balls, dodge blocker bots, and score enough points to win the match.',
	'hero' => 'Bot',
	'item' => 'Ball',
	'hazard' => 'Block',
	'heroColor' => '#38bdf8',
	'itemColor' => '#f8fafc',
	'hazardColor' => '#ef4444',
	'accent' => '#22c55e',
	'bgA' => '#14532d',
	'bgB' => '#0f766e',
	'target' => 200,
	'difficulty' => 2,
	'speed' => 8,
));
