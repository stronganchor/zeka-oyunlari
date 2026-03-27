<?php
/**
 * Game Name: Car Lane Switch
 * Author: Asker
 * Description: Simple lane-switch car dodge game
 */

if (!defined('ABSPATH')) exit;

$css = <<<CSS
.zo-car-game{max-width:500px;margin:0 auto;text-align:center;color:#fff;font-family:Arial}
.zo-car-game canvas{background:#111;border-radius:12px;width:100%;display:block}
.zo-ui{margin-top:10px}
.zo-car-game button{padding:10px 15px;border-radius:10px;border:0;margin:5px;cursor:pointer}
.zo-car-game .start{background:#10b981;color:#fff}
.zo-car-game .reset{background:#ef4444;color:#fff}
CSS;

$js = <<<JS
document.addEventListener("DOMContentLoaded", () => {
	const root = document.querySelector(".zo-car-game");
	if (!root) return;

	const canvas = root.querySelector(".zo-car-canvas");
	const ctx = canvas.getContext("2d");

	let lane = 1;
	let carY = 500;
	let obstacles = [];
	let speed = 4;
	let score = 0;
	let running = false;

	function reset() {
		lane = 1;
		obstacles = [];
		score = 0;
		speed = 4;
		running = false;
	}

	function spawn() {
		const laneX = [100, 250, 400];
		obstacles.push({
			x: laneX[Math.floor(Math.random() * 3)],
			y: -50
		});
	}

	function update() {
		if (!running) return;

		if (Math.random() < 0.03) spawn();

		for (let o of obstacles) {
			o.y += speed;

			if (o.y > 600) {
				score++;
				speed += 0.1;
			}

			const carX = [100, 250, 400][lane];
			if (Math.abs(o.x - carX) < 40 && Math.abs(o.y - carY) < 40) {
				running = false;
				alert("Game Over! Score: " + score);
			}
		}

		obstacles = obstacles.filter(o => o.y < 650);
	}

	function draw() {
		ctx.clearRect(0, 0, 500, 600);

		ctx.fillStyle = "#222";
		ctx.fillRect(80, 0, 340, 600);

		ctx.strokeStyle = "#555";
		ctx.setLineDash([20, 20]);
		ctx.beginPath();
		ctx.moveTo(200, 0);
		ctx.lineTo(200, 600);
		ctx.moveTo(320, 0);
		ctx.lineTo(320, 600);
		ctx.stroke();
		ctx.setLineDash([]);

		const carX = [100, 250, 400][lane];
		ctx.fillStyle = "#3b82f6";
		ctx.fillRect(carX - 25, carY - 40, 50, 80);

		ctx.fillStyle = "#ef4444";
		for (let o of obstacles) {
			ctx.fillRect(o.x - 25, o.y - 40, 50, 80);
		}

		ctx.fillStyle = "#fff";
		ctx.font = "20px Arial";
		ctx.fillText("Score: " + score, 10, 30);
	}

	function loop() {
		update();
		draw();
		requestAnimationFrame(loop);
	}

	document.addEventListener("keydown", e => {
		if (e.key === "ArrowLeft" && lane > 0) lane--;
		if (e.key === "ArrowRight" && lane < 2) lane++;
	});

	canvas.addEventListener("click", () => {
		lane = (lane + 1) % 3;
	});

	root.querySelector(".start").addEventListener("click", () => {
		running = true;
	});

	root.querySelector(".reset").addEventListener("click", () => {
		reset();
		running = true;
	});

	reset();
	loop();
});
JS;

function render_car_game() {
	ob_start(); ?>
	<div class="zo-car-game">
		<canvas class="zo-car-canvas" width="500" height="600"></canvas>
		<div class="zo-ui">
			<button class="start">Start</button>
			<button class="reset">Reset</button>
		</div>
		<p>Use ← → or tap screen</p>
		<p style="font-size:12px;opacity:0.7;">by Asker</p>
	</div>
	<?php
	return ob_get_clean();
}

return [
	'slug' => 'car-lane-switch',
	'name' => 'Car Lane Switch',
	'author' => 'Asker',
	'description' => 'Simple lane-switch car dodge game',
	'render_callback' => 'render_car_game',
	'inline_style' => $css,
	'inline_script' => $js,
];