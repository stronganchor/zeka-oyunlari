<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--dinozorlu *{box-sizing:border-box}
.zo-game-root--dinozorlu{max-width:920px;margin:0 auto;padding:16px;font-family:Arial,sans-serif}
.zo-game-root--dinozorlu .zo-dino-wrap{background:#fff;border:1px solid #dbe3ea;border-radius:18px;padding:18px;box-shadow:0 10px 28px rgba(0,0,0,.08)}
.zo-game-root--dinozorlu .zo-dino-title{text-align:center;font-size:30px;margin:0 0 8px}
.zo-game-root--dinozorlu .zo-dino-sub{text-align:center;color:#4b5563;margin:0 0 16px}
.zo-game-root--dinozorlu .zo-dino-top{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px}
.zo-game-root--dinozorlu .zo-dino-stats{display:flex;gap:10px;flex-wrap:wrap}
.zo-game-root--dinozorlu .zo-dino-stat{background:#f3f6fa;border:1px solid #dbe3ea;border-radius:12px;padding:10px 14px;font-weight:700}
.zo-game-root--dinozorlu .zo-dino-btn{padding:10px 16px;border:1px solid #16a34a;background:#16a34a;color:#fff;border-radius:12px;font-weight:700;cursor:pointer}
.zo-game-root--dinozorlu canvas{display:block;width:100%;height:auto;background:linear-gradient(180deg,#e0f2fe 0%,#fef3c7 100%);border:1px solid #cfd8e3;border-radius:14px}
.zo-game-root--dinozorlu .zo-dino-msg{margin-top:12px;padding:12px;border-radius:12px;background:#ecfdf5;border:1px solid #bbf7d0;font-weight:700;color:#166534}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded',function(){
document.querySelectorAll('.zo-game-root--dinozorlu').forEach(function(root){
const canvas=root.querySelector('canvas'),ctx=canvas.getContext('2d'),start=root.querySelector('.zo-dino-start'),restart=root.querySelector('.zo-dino-restart');
const scoreEl=root.querySelector('.zo-dino-score'),bestEl=root.querySelector('.zo-dino-best'),msg=root.querySelector('.zo-dino-msg');
const W=760,H=320,G=260; let best=+localStorage.getItem('zo_dino_best')||0;
const s={run:false,over:false,score:0,last:0,speed:5.5,dino:{x:90,y:G,w:34,h:42,vy:0,onGround:true},obs:[]};
function reset(){s.run=false;s.over=false;s.score=0;s.speed=5.5;s.last=0;s.dino={x:90,y:G,w:34,h:42,vy:0,onGround:true};s.obs=[];scoreEl.textContent='0';bestEl.textContent=best;msg.textContent='Başlat ve zıpla. Boşluk, W, Yukarı.';draw();}
function jump(){if(!s.dino.onGround||!s.run)return;s.dino.vy=-12.8;s.dino.onGround=false;}
function spawn(){const h=30+Math.random()*40,w=18+Math.random()*20;s.obs.push({x:W+20,y:G+42-h,w:w,h:h})}
function hit(a,b){return !(a.x+a.w<b.x||a.x>b.x+b.w||a.y+a.h<b.y||a.y>b.y+b.h)}
function update(dt){
s.score+=dt*10;s.speed=Math.min(12,5.5+s.score/90);scoreEl.textContent=Math.floor(s.score);
s.dino.vy+=0.65;s.dino.y+=s.dino.vy;if(s.dino.y>=G){s.dino.y=G;s.dino.vy=0;s.dino.onGround=true;}
if(Math.random()<0.02+s.speed*0.0007)spawn();
for(let i=s.obs.length-1;i>=0;i--){s.obs[i].x-=s.speed;if(s.obs[i].x+s.obs[i].w<0)s.obs.splice(i,1);}
for(const o of s.obs){if(hit(s.dino,o)){s.run=false;s.over=true;best=Math.max(best,Math.floor(s.score));localStorage.setItem('zo_dino_best',best);bestEl.textContent=best;msg.textContent='Oyun bitti. Tekrar dene.';}}
}
function draw(){
ctx.clearRect(0,0,W,H);
ctx.fillStyle='#a7f3d0';ctx.fillRect(0,G+42,W,40);
ctx.strokeStyle='#6b7280';ctx.lineWidth=2;ctx.beginPath();ctx.moveTo(0,G+42);ctx.lineTo(W,G+42);ctx.stroke();
ctx.fillStyle='#2563eb';ctx.fillRect(s.dino.x,s.dino.y,s.dino.w,s.dino.h);
ctx.fillStyle='#111827';ctx.fillRect(s.dino.x+22,s.dino.y+10,5,5);
ctx.fillStyle='#16a34a';
for(const o of s.obs){ctx.fillRect(o.x,o.y,o.w,o.h);ctx.fillRect(o.x+3,o.y+8,4,8);ctx.fillRect(o.x+o.w-7,o.y+14,4,8);}
if(!s.run){
ctx.fillStyle='rgba(15,23,42,.15)';ctx.fillRect(0,0,W,H);
ctx.fillStyle='#0f172a';ctx.textAlign='center';
ctx.font='bold 34px Arial';ctx.fillText('Dinozorlu',W/2,H/2-8);
ctx.font='bold 18px Arial';ctx.fillText(s.over?'Skor: '+Math.floor(s.score):'Başlamak için düğmeye bas',W/2,H/2+26);
}
}
function loop(t){if(!s.run){draw();return;}const dt=Math.min((t-s.last)/16.67,2);s.last=t;update(dt);draw();if(s.run)requestAnimationFrame(loop);}
window.addEventListener('keydown',function(e){if(['Space','ArrowUp','KeyW'].includes(e.code)){e.preventDefault(); if(!s.run&&!s.over){s.run=true;s.last=performance.now();msg.textContent='Kaç.';requestAnimationFrame(loop);} else jump();}});
start.addEventListener('click',function(){if(!s.run){s.run=true;s.last=performance.now();msg.textContent='Kaç.';requestAnimationFrame(loop);}});
restart.addEventListener('click',reset);
reset();
});
});
JS;

if (!function_exists('zo_dinozorlu_render')) {
	function zo_dinozorlu_render($post_id = 0, $game = array()) {
		ob_start(); ?>
		<div class="zo-game-root zo-game-root--dinozorlu">
			<div class="zo-dino-wrap">
				<h2 class="zo-dino-title">Dinozorlu</h2>
				<p class="zo-dino-sub">Dino koşar. Engellerin üstünden zıpla.</p>
				<div class="zo-dino-top">
					<div class="zo-dino-stats">
						<div class="zo-dino-stat">Skor: <span class="zo-dino-score">0</span></div>
						<div class="zo-dino-stat">En İyi: <span class="zo-dino-best">0</span></div>
					</div>
					<div>
						<button type="button" class="zo-dino-btn zo-dino-start">Başlat</button>
						<button type="button" class="zo-dino-btn zo-dino-restart">Sıfırla</button>
					</div>
				</div>
				<canvas width="760" height="320"></canvas>
				<div class="zo-dino-msg">Başlat ve zıpla. Boşluk, W, Yukarı.</div>
			</div>
		</div>
		<?php return ob_get_clean();
	}
}

return array(
	'slug' => 'dinozorlu',
	'name' => 'Dinozorlu',
	'author' => 'Arslan',
	'description' => 'Dino koşu ve zıplama oyunu.',
	'render_callback' => 'zo_dinozorlu_render',
	'inline_style' => $inline_style,
	'inline_script' => $inline_script,
);