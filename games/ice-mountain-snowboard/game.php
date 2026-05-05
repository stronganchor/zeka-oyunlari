<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'ice-mountain-snowboard',
	'name' => 'Ice Mountain Snowboard',
	'description' => 'Snowboard down an icy mountain collecting flags.',
	'goal' => 'Collect race flags and dodge ice blocks on the mountain slope.',
	'hero' => 'Board',
	'item' => 'Flag',
	'hazard' => 'Ice',
	'heroColor' => '#bae6fd',
	'itemColor' => '#ef4444',
	'hazardColor' => '#e0f2fe',
	'accent' => '#38bdf8',
	'bgA' => '#075985',
	'bgB' => '#7dd3fc',
	'target' => 210,
	'difficulty' => 2,
	'speed' => 16,
));
