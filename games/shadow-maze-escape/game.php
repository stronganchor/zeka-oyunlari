<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'shadow-maze-escape',
	'name' => 'Shadow Maze Escape',
	'description' => 'Slip through a dark maze, collect light sparks, and avoid shadow walls.',
	'goal' => 'Collect light sparks to reveal the exit while dodging moving shadow walls.',
	'hero' => 'Runner',
	'item' => 'Light',
	'hazard' => 'Wall',
	'heroColor' => '#f8fafc',
	'itemColor' => '#fde047',
	'hazardColor' => '#475569',
	'accent' => '#fde047',
	'bgA' => '#020617',
	'bgB' => '#334155',
	'target' => 180,
	'difficulty' => 1,
	'speed' => 4,
));
