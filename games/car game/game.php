<?php

/**
 * Game Name: Car Lane Switch
 * Author: Asker
 * Description: Simple lane-switch car dodge game
 */

if (!defined('ABSPATH')) exit;

$css = <<<CSS
.zo-car-game{max-width:500px;margin:0 auto;text-align:center;color:#fff;font-family:Arial}
canvas{background:#111;border-radius:12px;width:100%}
.zo-ui{margin-top:10px}
button{padding:10px 15px;border-radius:10px;border:0;margin:5px;cursor:pointer}
.start{background:#10b981}
.reset{background:#ef4444}
CSS;

$js = <<<JS
document.addEventListener("DOMContentLoaded",()=>{

const canvas=document.querySelector(".zo-car-canvas");
const ctx=canvas.getContext("2d");

let lane=1; // 0 left,1 center,2 right
let carY=500;
let obstacles=[];
let speed=4;
let score=0;
let running=false;

function reset(){
 lane=1;
 obstacles=[];
 score=0;
 speed=4;
}

function spawn(){
 const laneX=[100,250,400];
 obstacles.push({
   x:laneX[Math.floor(Math.random()*3)],
   y:-50
 });
}

function update(){
 if(!running) return;

 if(Math.random()<0.03) spawn();

 for(let o of obstacles){
   o.y+=speed;

   if(o.y>600){
     score++;
     speed+=0.1;
   }

   // collision
   let carX=[100,250,400][lane];
   if(Math.abs(o.x-carX)<40 && Math.abs(o.y-carY)<40){
     running=false;
     alert("Game Over! Score: "+score);
   }
 }

 obstacles=obstacles.filter(o=>o.y<650);
}

function draw(){
 ctx.clearRect(0,0,500,600);

 // lanes
 ctx.fillStyle="#222";
 ctx.fillRect(80,0,340,600);

 ctx.strokeStyle="#555";
 ctx.setLineDash([20,20]);
 ctx.beginPath();
 ctx.moveTo(200,0);
 ctx.lineTo(200,600);
 ctx.moveTo(320,0);
 ctx.lineTo(320,600);
 ctx.stroke();
 ctx.setLineDash([]);

 // player car
 let carX=[100,250,400][lane];
 ctx.fillStyle="#3b82f6";
 ctx.fillRect(carX-25,carY-40,50,80);

 // obstacles
 ctx.fillStyle="#ef4444";
 for(let o of obstacles){
   ctx.fillRect(o.x-25,o.y-40,50,80);
 }

 // score
 ctx.fillStyle="#fff";
 ctx.font="20px Arial";
 ctx.fillText("Score: "+score,10,30);
}

function loop(){
 update();
 draw();
 requestAnimationFrame(loop);
}

document.addEventListener("keydown",e=>{
 if(e.key==="ArrowLeft" && lane>0) lane--;
 if(e.key==="ArrowRight" && lane<2) lane++;
});

canvas.addEventListener("click",()=>{
 lane=(lane+1)%3;
});

document.querySelector(".start").onclick=()=>{
 running=true;
};

document.querySelector(".reset").onclick=()=>{
 reset();
 running=true;
};

reset();
loop();

});
JS;

function render_car_game(){
 ob_start(); ?>
<div class="zo-car-game">
 <canvas class="zo-car-canvas" width="500" height="600"></canvas>
 <div class="zo-ui">
   <button class="start">Start</button>
   <button class="reset">Reset</button>
 </div>
 <p>Use ← → or tap screen</p>
</div>
<?php return ob_get_clean();
}

return [
 'slug' => 'car-lane-switch',
 'name' => 'Car Lane Switch',
 'author' => 'Asker',
 'author_uri' => '',
 'description' => 'Simple lane-switch car dodge game',
 'version' => '1.0.0',
 'render_callback' => 'render_car_game',
 'inline_style' => $css,
 'inline_script' => $js
];