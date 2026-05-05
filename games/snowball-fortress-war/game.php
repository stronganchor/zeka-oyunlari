<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'snowball-fortress-war',
	'name' => 'Snowball Fortress War',
	'description' => 'Collect snow bricks to build a fortress.',
	'goal' => 'Collect snow bricks and dodge flying snowballs in the fortress war.',
	'hero' => 'Builder',
	'item' => 'Brick',
	'hazard' => 'Snow',
	'heroColor' => '#dbeafe',
	'itemColor' => '#f8fafc',
	'hazardColor' => '#93c5fd',
	'accent' => '#93c5fd',
	'bgA' => '#1d4ed8',
	'bgB' => '#0e7490',
	'target' => 200,
	'difficulty' => 3,
	'speed' => 10,
));
