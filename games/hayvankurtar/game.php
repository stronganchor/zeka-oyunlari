<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--hayvan-kurtarmali *{box-sizing:border-box}
.zo-game-root--hayvan-kurtarmali{max-width:920px;margin:0 auto;padding:16px;font-family:Arial,sans-serif}
.zo-game-root--hayvan-kurtarmali .zo-hk-wrap{background:#fff;border:1px solid #dbe3ea;border-radius:18px;padding:18px;box-shadow:0 10px 28px rgba(0,0,0,.08)}
.zo-game-root--hayvan-kurtarmali .zo-hk-title{text-align:center;font-size:30px;margin:0 0 8px}
.zo-game-root--hayvan-kurtarmali .zo-hk-sub{text-align:center;color:#4b5563;margin:0 0 16px}
.zo-game-root--hayvan-kurtarmali .zo-hk-top{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px}
.zo-game-root--hayvan-kurtarmali .zo-hk-stats{display:flex;gap:10px;flex-wrap:wrap}
.zo-game-root--hayvan-kurtarmali .zo-hk-stat{background:#f3f6fa;border:1px solid #dbe3ea;border-radius:12px;padding:10px 14px;font-weight:700}
.zo-game-root--hayvan-kurtarmali .zo-hk-btn{padding:10px 16px;border:1px solid #0ea5e9;background:#0ea5e9;color:#fff;border-radius:12px;font-weight:700;cursor:pointer}
.zo-game-root--hayvan-kurtarmali canvas{display:block;width:100%;height:auto;background:linear-gradient(180deg,#d9f99d 0%,#bbf7d0 100%);border:1px solid #cfd8e3;border-radius:14px}
.zo-game-root--hayvan-kurtarmali .zo-hk-msg{margin-top:12px;padding:12px;border-radius:12px;background:#ecfeff;border:1px solid #a5f3fc;font-weight:700;color:#0f766e}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded',function(){
document.querySelectorAll('.zo-game-root--hayvan-kurtarmali').forEach(function(root){
const canvas=root.querySelector('canvas'),ctx=canvas.getContext('2d'),start=root.querySelector('.zo-hk-start'),restart=root.querySelector('.zo-hk-restart');
const savedEl=root.querySelector('.zo-hk-saved'),needEl=root.querySelector('.zo-hk-need'),bestEl=root.querySelector('.zo-hk-best'),msg=root.querySelector('.zo-hk-msg');
const W=760,H=440; let best=+localStorage.getItem('zo_hk_best')||0;
const emojis=['🐶','🐱','🐰','🐥','🐑','🐢'];
const s={run:false,over:false,saved:0,need:5,last:0,player:{x:60,y:220,r:18},barn:{x:660,y:150,w:70,h:130},animal:null,carrying:false,muds:[]};
function rand(a,b){return a+Math.random()*(b-a)}
function reset(){s.run=false;s.over=false;s.saved=0;s.need=5;s.player={x:60,y:220,r:18};s.carrying=false;s.muds=[{x:250,y:90,r:28},{x:380,y:260,r:34},{x:530,y:150,r:26}];spawnAnimal();savedEl.textContent='0';needEl.textContent='5';bestEl.textContent=best;msg.textContent='Hayvanı bul ve ahıra götür.';draw();}
function spawnAnimal(){s.animal={x:rand(130,600),y:rand(70,370),r:18,emoji:emojis[Math.floor(Math.random()*emojis.length)]};}
function dist(a,b){const dx=a.x-b.x,dy=a.y-b.y;return Math.sqrt(dx*dx+dy*dy)}
function update(){
for(const m of s.muds){if(dist(s.player,m)<s.player.r+m.r){s.player.x=60;s.player.y=220;s.carrying=false;msg.textContent='Çamura girdin. Baştan dön.';}}
if(!s.carrying&&dist(s.player,s.animal)<s.player.r+s.animal.r){s.carrying=true;msg.textContent='Hayvanı aldın. Ahıra götür.';}
if(s.carrying){
s.animal.x=s.player.x+24;s.animal.y=s.player.y-6;
if(s.player.x>s.barn.x&&s.player.x<s.barn.x+s.barn.w&&s.player.y>s.barn.y&&s.player.y<s.barn.y+s.barn.h){
s.saved++;savedEl.textContent=s.saved;
if(s.saved>=s.need){s.run=false;s.over=true;best=Math.max(best,s.saved);localStorage.setItem('zo_hk_best',best);bestEl.textContent=best;msg.textContent='Hepsi kurtarıldı.';}
else{s.carrying=false;spawnAnimal();msg.textContent='Güzel. Yenisi geliyor.';}
}
}
}
function draw(){
ctx.clearRect(0,0,W,H);
ctx.fillStyle='#92400e';ctx.fillRect(s.barn.x,s.barn.y,s.barn.w,s.barn.h);
ctx.fillStyle='#f59e0b';ctx.fillRect(s.barn.x+15,s.barn.y+65,40,65);
ctx.fillStyle='#1f2937';ctx.font='bold 18px Arial';ctx.fillText('Ahır',s.barn.x+13,s.barn.y-10);
for(const m of s.muds){ctx.beginPath();ctx.fillStyle='#7c5a3c';ctx.arc(m.x,m.y,m.r,0,Math.PI*2);ctx.fill();}
if(s.animal){ctx.font='28px Arial';ctx.fillText(s.animal.emoji,s.animal.x-12,s.animal.y+10);}
ctx.beginPath();ctx.fillStyle='#2563eb';ctx.arc(s.player.x,s.player.y,s.player.r,0,Math.PI*2);ctx.fill();
if(!s.run){
ctx.fillStyle='rgba(15,23,42,.12)';ctx.fillRect(0,0,W,H);
ctx.fillStyle='#0f172a';ctx.textAlign='center';ctx.font='bold 34px Arial';ctx.fillText('Hayvan Kurtarmalı',W/2,H/2-8);
ctx.font='bold 18px Arial';ctx.fillText(s.over?'Kurtarılan: '+s.saved:'Başlamak için düğmeye bas',W/2,H/2+26);
}
}
function loop(){if(!s.run){draw();return;}update();draw();if(s.run)requestAnimationFrame(loop);}
window.addEventListener('keydown',function(e){
const k=e.code;
if(['ArrowUp','ArrowDown','ArrowLeft','ArrowRight','KeyW','KeyA','KeyS','KeyD'].includes(k))e.preventDefault();
if(k==='ArrowUp'||k==='KeyW')s.player.y=Math.max(18,s.player.y-16);
if(k==='ArrowDown'||k==='KeyS')s.player.y=Math.min(H-18,s.player.y+16);
if(k==='ArrowLeft'||k==='KeyA')s.player.x=Math.max(18,s.player.x-16);
if(k==='ArrowRight'||k==='KeyD')s.player.x=Math.min(W-18,s.player.x+16);
});
start.addEventListener('click',function(){if(!s.run){s.run=true;msg.textContent='Kurtar.';requestAnimationFrame(loop);}});
restart.addEventListener('click',reset);
reset();
});
});
JS;

if (!function_exists('zo_hayvan_kurtarmali_render')) {
	function zo_hayvan_kurtarmali_render($post_id = 0, $game = array()) {
		ob_start(); ?>
		<div class="zo-game-root zo-game-root--hayvan-kurtarmali">
			<div class="zo-hk-wrap">
				<h2 class="zo-hk-title">Hayvan Kurtarmalı</h2>
				<p class="zo-hk-sub">Hayvanı bul. Ahıra götür. Çamura basma.</p>
				<div class="zo-hk-top">
					<div class="zo-hk-stats">
						<div class="zo-hk-stat">Kurtarılan: <span class="zo-hk-saved">0</span></div>
						<div class="zo-hk-stat">Hedef: <span class="zo-hk-need">5</span></div>
						<div class="zo-hk-stat">En İyi: <span class="zo-hk-best">0</span></div>
					</div>
					<div>
						<button type="button" class="zo-hk-btn zo-hk-start">Başlat</button>
						<button type="button" class="zo-hk-btn zo-hk-restart">Sıfırla</button>
					</div>
				</div>
				<canvas width="760" height="440"></canvas>
				<div class="zo-hk-msg">Hayvanı bul ve ahıra götür.</div>
			</div>
		</div>
		<?php return ob_get_clean();
	}
}

return array(
	'slug' => 'hayvan-kurtarmali',
	'name' => 'Hayvan Kurtarmalı',
	'author' => 'Arslan',
	'description' => 'Hayvan kurtarma oyunu.',
	'render_callback' => 'zo_hayvan_kurtarmali_render',
	'inline_style' => $inline_style,
	'inline_script' => $inline_script,
);