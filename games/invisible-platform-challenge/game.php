<?php
if (!defined('ABSPATH')) { exit; }
require_once dirname(__DIR__) . '/_arslan_arcade_engine.php';
return zo_arslan_arcade_game_module(array(
	'slug' => 'invisible-platform-challenge',
	'name' => 'Invisible Platform Challenge',
	'description' => 'Find hidden platforms by collecting shimmer marks.',
	'goal' => 'Collect shimmer marks and avoid invisible gaps in the challenge arena.',
	'hero' => 'Seeker',
	'item' => 'Mark',
	'hazard' => 'Gap',
	'heroColor' => '#f8fafc',
	'itemColor' => '#a7f3d0',
	'hazardColor' => '#020617',
	'accent' => '#a7f3d0',
	'bgA' => '#0f172a',
	'bgB' => '#475569',
	'target' => 190,
	'difficulty' => 3,
	'speed' => 10,
));
