<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'secret-agent-school',
	'name' => 'Secret Agent School',
	'description' => 'Train as a secret agent by collecting badges.',
	'goal' => 'Collect agent badges and dodge training lasers to pass spy school.',
	'hero' => 'Agent',
	'item' => 'Badge',
	'hazard' => 'Laser',
	'heroColor' => '#e5e7eb',
	'itemColor' => '#38bdf8',
	'hazardColor' => '#ef4444',
	'accent' => '#38bdf8',
	'bgA' => '#111827',
	'bgB' => '#374151',
	'target' => 200,
	'difficulty' => 3,
	'speed' => 10,
));
