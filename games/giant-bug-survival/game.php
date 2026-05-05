<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'giant-bug-survival',
	'name' => 'Giant Bug Survival',
	'description' => 'Survive in a backyard where everything is huge.',
	'goal' => 'Collect nectar drops and dodge giant bug charges.',
	'hero' => 'Tiny',
	'item' => 'Nectar',
	'hazard' => 'Bug',
	'heroColor' => '#bbf7d0',
	'itemColor' => '#f9a8d4',
	'hazardColor' => '#166534',
	'accent' => '#f9a8d4',
	'bgA' => '#365314',
	'bgB' => '#854d0e',
	'target' => 170,
	'difficulty' => 3,
	'speed' => 8,
));
