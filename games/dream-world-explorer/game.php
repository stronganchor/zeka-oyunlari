<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'dream-world-explorer',
	'name' => 'Dream World Explorer',
	'description' => 'Collect dream stars in a shifting dream world.',
	'goal' => 'Collect dream stars and dodge sleepy fog clouds.',
	'hero' => 'Dream',
	'item' => 'Star',
	'hazard' => 'Fog',
	'heroColor' => '#f0abfc',
	'itemColor' => '#fef08a',
	'hazardColor' => '#94a3b8',
	'accent' => '#f0abfc',
	'bgA' => '#701a75',
	'bgB' => '#1d4ed8',
	'target' => 180,
	'difficulty' => 1,
	'speed' => 8,
));
