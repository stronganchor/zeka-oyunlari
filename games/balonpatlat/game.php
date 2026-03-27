<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--balon-patlatmali *{box-sizing:border-box}
.zo-game-root--balon-patlatmali{max-width:920px;margin:0 auto;padding:16px;font-family:Arial,sans-serif}
.zo-game-root--balon-patlatmali .zo-bp-wrap{background:#fff;border:1px solid #dbe3ea;border-radius:18px;padding:18px;box-shadow:0 10px 28px rgba(0,0,0,.08)}
.zo-game-root--balon-patlatmali .zo-bp-title{text-align:center;font-size:30px;margin:0 0 8px}
.zo-game-root--balon-patlatmali .zo-bp-sub{text-align:center;color:#4b5563;margin:0 0 16px}
.zo-game-root--balon-patlatmali .zo-bp-top{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px}
.zo-game-root--balon-patlatmali .zo-bp-stats{display:flex;gap:10px;flex-wrap:wrap}
.zo-game-root--balon-patlatmali .zo-bp-stat{background:#f3f6fa;border:1px solid #dbe3ea;border-radius:12px;padding:10px 14px;font-weight:700}
.zo-game-root--balon-patlatmali .zo-bp-btn{padding:10px 16px;border:1px solid #7c3aed;background:#7c3aed;color:#fff;border-radius:12px;font-weight:700;cursor:pointer}
.zo-game-root--balon-patlatmali canvas{display:block;width:100%;height:auto;background:linear-gradient(180deg,#dbeafe 0%,#f5d0fe 100%);border:1px solid #cfd8e3;border-radius:14px;cursor:pointer}
.zo-game-root--balon-patlatmali .zo-bp-msg{margin-top:12px;padding:12px;border-radius:12px;background:#faf5ff;border:1px solid #e9d5ff;font-weight:700;color:#6b21a8}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded',function(){
document.querySelectorAll('.zo-game-root--balon-patlatmali').forEach(function(root){
const canvas=root.querySelector('canvas'),ctx=canvas.getContext('2d'),start=root.querySelector('.zo-bp-start'),restart=root.querySelector('.zo-bp-restart');
const scoreEl=root.querySelector('.zo-bp-score'),timeEl=root.querySelector('.zo-bp-time'),bestEl=root.querySelector('.zo-bp-best'),msg=root.querySelector('.zo-bp-msg');
const W=760,H=420; let best=+localStorage.getItem('zo_balon_best')||0;
const colors=['#ef4444','#3b82f6','#22c55e','#f59e0b','#ec4899','#8b5cf6'];
const s={run:false,over:false,score:0,time:30,last:0,balloons:[]};
function reset(){s.run=false;s.over=false;s.score=0;s.time=30;s.last=0;s.balloons=[];scoreEl.textContent='0';timeEl.textContent='30';bestEl.textContent=best;msg.textContent='Balonlara tıkla.';draw();}
function spawn(){if(s.balloons.length>9)return;s.balloons.push({x:40+Math.random()*(W-80),y:H+40,r:22+Math.random()*18,color:colors[Math.floor(Math.random()*colors.length)],speed:1.2+Math.random()*2});}
function drawBalloon(b){
ctx.beginPath();ctx.fillStyle=b.color;ctx.arc(b.x,b.y,b.r,0,Math.PI*2);ctx.fill();
ctx.strokeStyle='rgba(255,255,255,.6)';ctx.lineWidth=3;ctx.beginPath();ctx.arc(b.x-b.r/3,b.y-b.r/3,b.r/4,0,Math.PI*2);ctx.stroke();
ctx.strokeStyle='#6b7280';ctx.lineWidth=2;ctx.beginPath();ctx.moveTo(b.x,b.y+b.r);ctx.lineTo(b.x,b.y+b.r+24);ctx.stroke();
}
function update(dt){
s.time-=dt/60;if(s.time<=0){s.time=0;s.run=false;s.over=true;best=Math.max(best,s.score);localStorage.setItem('zo_balon_best',best);bestEl.textContent=best;msg.textContent='Süre bitti.';}
if(Math.random()<0.09)spawn();
for(let i=s.balloons.length-1;i>=0;i--){s.balloons[i].y-=s.balloons[i].speed;if(s.balloons[i].y+s.balloons[i].r<0)s.balloons.splice(i,1);}
scoreEl.textContent=s.score;timeEl.textContent=Math.ceil(s.time);
}
function draw(){
ctx.clearRect(0,0,W,H);
for(const b of s.balloons)drawBalloon(b);
if(!s.run){
ctx.fillStyle='rgba(15,23,42,.12)';ctx.fillRect(0,0,W,H);
ctx.fillStyle='#0f172a';ctx.textAlign='center';ctx.font='bold 34px Arial';ctx.fillText('Balon Patlatmalı',W/2,H/2-8);
ctx.font='bold 18px Arial';ctx.fillText(s.over?'Skor: '+s.score:'Başlamak için düğmeye bas',W/2,H/2+26);
}
}
function loop(t){if(!s.run){draw();return;}const dt=Math.min((t-s.last)/16.67,2);s.last=t;update(dt);draw();if(s.run)requestAnimationFrame(loop);}
canvas.addEventListener('click',function(e){
if(!s.run)return;
const rect=canvas.getBoundingClientRect(),x=(e.clientX-rect.left)*(canvas.width/rect.width),y=(e.clientY-rect.top)*(canvas.height/rect.height);
for(let i=s.balloons.length-1;i>=0;i--){
const b=s.balloons[i],dx=x-b.x,dy=y-b.y;
if(Math.sqrt(dx*dx+dy*dy)<=b.r){s.balloons.splice(i,1);s.score+=10;scoreEl.textContent=s.score;break;}
}
});
start.addEventListener('click',function(){if(!s.run){s.run=true;s.last=performance.now();msg.textContent='Patlat.';requestAnimationFrame(loop);}});
restart.addEventListener('click',reset);
reset();
});
});
JS;

if (!function_exists('zo_balon_patlatmali_render')) {
	function zo_balon_patlatmali_render($post_id = 0, $game = array()) {
		ob_start(); ?>
		<div class="zo-game-root zo-game-root--balon-patlatmali">
			<div class="zo-bp-wrap">
				<h2 class="zo-bp-title">Balon Patlatmalı</h2>
				<p class="zo-bp-sub">Yukarı çıkan balonları patlat.</p>
				<div class="zo-bp-top">
					<div class="zo-bp-stats">
						<div class="zo-bp-stat">Skor: <span class="zo-bp-score">0</span></div>
						<div class="zo-bp-stat">Süre: <span class="zo-bp-time">30</span></div>
						<div class="zo-bp-stat">En İyi: <span class="zo-bp-best">0</span></div>
					</div>
					<div>
						<button type="button" class="zo-bp-btn zo-bp-start">Başlat</button>
						<button type="button" class="zo-bp-btn zo-bp-restart">Sıfırla</button>
					</div>
				</div>
				<canvas width="760" height="420"></canvas>
				<div class="zo-bp-msg">Balonlara tıkla.</div>
			</div>
		</div>
		<?php return ob_get_clean();
	}
}

return array(
	'slug' => 'balon-patlatmali',
	'name' => 'Balon Patlatmalı',
	'author' => 'Arslan',
	'description' => 'Tıklayarak balon patlatma oyunu.',
	'render_callback' => 'zo_balon_patlatmali_render',
	'inline_style' => $inline_style,
	'inline_script' => $inline_script,
);