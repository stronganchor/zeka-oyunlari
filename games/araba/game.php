<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--arabali *{box-sizing:border-box}
.zo-game-root--arabali{max-width:920px;margin:0 auto;padding:16px;font-family:Arial,sans-serif}
.zo-game-root--arabali .zo-car-wrap{background:#fff;border:1px solid #dbe3ea;border-radius:18px;padding:18px;box-shadow:0 10px 28px rgba(0,0,0,.08)}
.zo-game-root--arabali .zo-car-title{text-align:center;font-size:30px;margin:0 0 8px}
.zo-game-root--arabali .zo-car-sub{text-align:center;color:#4b5563;margin:0 0 16px}
.zo-game-root--arabali .zo-car-top{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px}
.zo-game-root--arabali .zo-car-stats{display:flex;gap:10px;flex-wrap:wrap}
.zo-game-root--arabali .zo-car-stat{background:#f3f6fa;border:1px solid #dbe3ea;border-radius:12px;padding:10px 14px;font-weight:700}
.zo-game-root--arabali .zo-car-btn{padding:10px 16px;border:1px solid #dc2626;background:#dc2626;color:#fff;border-radius:12px;font-weight:700;cursor:pointer}
.zo-game-root--arabali canvas{display:block;width:100%;height:auto;background:#374151;border:1px solid #cfd8e3;border-radius:14px}
.zo-game-root--arabali .zo-car-msg{margin-top:12px;padding:12px;border-radius:12px;background:#eff6ff;border:1px solid #bfdbfe;font-weight:700;color:#1d4ed8}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded',function(){
document.querySelectorAll('.zo-game-root--arabali').forEach(function(root){
const canvas=root.querySelector('canvas'),ctx=canvas.getContext('2d'),start=root.querySelector('.zo-car-start'),restart=root.querySelector('.zo-car-restart');
const scoreEl=root.querySelector('.zo-car-score'),bestEl=root.querySelector('.zo-car-best'),msg=root.querySelector('.zo-car-msg');
const W=420,H=620,lanes=[75,165,255,345]; let best=+localStorage.getItem('zo_arabali_best')||0;
const s={run:false,over:false,score:0,last:0,speed:6,playerLane:1,enemies:[]};
function reset(){s.run=false;s.over=false;s.score=0;s.last=0;s.speed=6;s.playerLane=1;s.enemies=[];scoreEl.textContent='0';bestEl.textContent=best;msg.textContent='Sağ ve sol ile şerit değiştir.';draw();}
function spawn(){const lane=Math.floor(Math.random()*4); if(s.enemies.length&&s.enemies[s.enemies.length-1].y<150)return; s.enemies.push({lane:lane,y:-120,color:['#22c55e','#f59e0b','#3b82f6','#ef4444'][Math.floor(Math.random()*4)]})}
function rectHit(ax,ay,aw,ah,bx,by,bw,bh){return !(ax+aw<bx||ax>bx+bw||ay+ah<by||ay>by+bh)}
function update(dt){
s.score+=dt*9;s.speed=Math.min(15,6+s.score/120);scoreEl.textContent=Math.floor(s.score);
if(Math.random()<0.045)spawn();
for(let i=s.enemies.length-1;i>=0;i--){s.enemies[i].y+=s.speed;if(s.enemies[i].y>H+130)s.enemies.splice(i,1);}
const px=lanes[s.playerLane]-30,py=H-130,pw=60,ph=100;
for(const e of s.enemies){
const ex=lanes[e.lane]-30,ey=e.y,ew=60,eh=100;
if(rectHit(px,py,pw,ph,ex,ey,ew,eh)){s.run=false;s.over=true;best=Math.max(best,Math.floor(s.score));localStorage.setItem('zo_arabali_best',best);bestEl.textContent=best;msg.textContent='Kaza yaptın.';}
}
}
function drawCar(x,y,color){
ctx.fillStyle=color;ctx.fillRect(x,y,60,100);
ctx.fillStyle='#111827';ctx.fillRect(x+8,y+12,44,24);
ctx.fillRect(x+8,y+64,12,20);ctx.fillRect(x+40,y+64,12,20);
}
function draw(){
ctx.clearRect(0,0,W,H);
ctx.fillStyle='#4b5563';ctx.fillRect(0,0,W,H);
ctx.fillStyle='#fbbf24';ctx.fillRect(0,0,20,H);ctx.fillRect(W-20,0,20,H);
ctx.strokeStyle='#fff';ctx.setLineDash([24,18]);ctx.lineWidth=4;
for(let i=1;i<4;i++){ctx.beginPath();ctx.moveTo(i*90+15,0);ctx.lineTo(i*90+15,H);ctx.stroke();}
ctx.setLineDash([]);
for(const e of s.enemies)drawCar(lanes[e.lane]-30,e.y,e.color);
drawCar(lanes[s.playerLane]-30,H-130,'#ffffff');
if(!s.run){
ctx.fillStyle='rgba(15,23,42,.2)';ctx.fillRect(0,0,W,H);
ctx.fillStyle='#fff';ctx.textAlign='center';ctx.font='bold 34px Arial';ctx.fillText('Arabalı',W/2,H/2-8);
ctx.font='bold 18px Arial';ctx.fillText(s.over?'Skor: '+Math.floor(s.score):'Başlamak için düğmeye bas',W/2,H/2+26);
}
}
function loop(t){if(!s.run){draw();return;}const dt=Math.min((t-s.last)/16.67,2);s.last=t;update(dt);draw();if(s.run)requestAnimationFrame(loop);}
window.addEventListener('keydown',function(e){
if(['ArrowLeft','ArrowRight','KeyA','KeyD'].includes(e.code))e.preventDefault();
if(!s.run&&!s.over&&(e.code==='Space'||e.code==='Enter')){s.run=true;s.last=performance.now();msg.textContent='Çarpma.';requestAnimationFrame(loop);return;}
if(e.code==='ArrowLeft'||e.code==='KeyA')s.playerLane=Math.max(0,s.playerLane-1);
if(e.code==='ArrowRight'||e.code==='KeyD')s.playerLane=Math.min(3,s.playerLane+1);
});
start.addEventListener('click',function(){if(!s.run){s.run=true;s.last=performance.now();msg.textContent='Çarpma.';requestAnimationFrame(loop);}});
restart.addEventListener('click',reset);
reset();
});
});
JS;

if (!function_exists('zo_arabali_render')) {
	function zo_arabali_render($post_id = 0, $game = array()) {
		ob_start(); ?>
		<div class="zo-game-root zo-game-root--arabali">
			<div class="zo-car-wrap">
				<h2 class="zo-car-title">Arabalı</h2>
				<p class="zo-car-sub">Şerit değiştir. Diğer arabalara çarpma.</p>
				<div class="zo-car-top">
					<div class="zo-car-stats">
						<div class="zo-car-stat">Skor: <span class="zo-car-score">0</span></div>
						<div class="zo-car-stat">En İyi: <span class="zo-car-best">0</span></div>
					</div>
					<div>
						<button type="button" class="zo-car-btn zo-car-start">Başlat</button>
						<button type="button" class="zo-car-btn zo-car-restart">Sıfırla</button>
					</div>
				</div>
				<canvas width="420" height="620"></canvas>
				<div class="zo-car-msg">Sağ ve sol ile şerit değiştir.</div>
			</div>
		</div>
		<?php return ob_get_clean();
	}
}

return array(
	'slug' => 'arabali',
	'name' => 'Arabali',
	'author' => 'Arslan',
	'description' => 'Şerit değiştirmeli araba oyunu.',
	'render_callback' => 'zo_arabali_render',
	'inline_style' => $inline_style,
	'inline_script' => $inline_script,
);