
<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--ses-efektli-surum *{box-sizing:border-box}
.zo-game-root--ses-efektli-surum{max-width:920px;margin:0 auto;padding:16px;font-family:Arial,sans-serif}
.zo-game-root--ses-efektli-surum .zo-ses-wrap{background:#fff;border:1px solid #dbe3ea;border-radius:18px;padding:18px;box-shadow:0 10px 28px rgba(0,0,0,.08)}
.zo-game-root--ses-efektli-surum .zo-ses-title{text-align:center;font-size:30px;margin:0 0 8px}
.zo-game-root--ses-efektli-surum .zo-ses-sub{text-align:center;color:#4b5563;margin:0 0 16px}
.zo-game-root--ses-efektli-surum .zo-ses-top{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px}
.zo-game-root--ses-efektli-surum .zo-ses-stats{display:flex;gap:10px;flex-wrap:wrap}
.zo-game-root--ses-efektli-surum .zo-ses-stat{background:#f3f6fa;border:1px solid #dbe3ea;border-radius:12px;padding:10px 14px;font-weight:700}
.zo-game-root--ses-efektli-surum .zo-ses-btn{padding:10px 16px;border:1px solid #9333ea;background:#9333ea;color:#fff;border-radius:12px;font-weight:700;cursor:pointer}
.zo-game-root--ses-efektli-surum canvas{display:block;width:100%;height:auto;background:linear-gradient(180deg,#dbeafe 0%,#fae8ff 100%);border:1px solid #cfd8e3;border-radius:14px;cursor:pointer}
.zo-game-root--ses-efektli-surum .zo-ses-msg{margin-top:12px;padding:12px;border-radius:12px;background:#faf5ff;border:1px solid #e9d5ff;font-weight:700;color:#6b21a8}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded',function(){
document.querySelectorAll('.zo-game-root--ses-efektli-surum').forEach(function(root){
const canvas=root.querySelector('canvas'),ctx=canvas.getContext('2d'),start=root.querySelector('.zo-ses-start'),restart=root.querySelector('.zo-ses-restart');
const scoreEl=root.querySelector('.zo-ses-score'),timeEl=root.querySelector('.zo-ses-time'),msg=root.querySelector('.zo-ses-msg');
const W=760,H=420,colors=['#ef4444','#3b82f6','#22c55e','#f59e0b','#ec4899','#8b5cf6'];
const s={run:false,score:0,time:25,last:0,balls:[],audio:null};
function beep(freq,dur,type){
try{
if(!s.audio)s.audio=new(window.AudioContext||window.webkitAudioContext)();
const o=s.audio.createOscillator(),g=s.audio.createGain();
o.type=type||'sine';o.frequency.value=freq;o.connect(g);g.connect(s.audio.destination);g.gain.setValueAtTime(.08,s.audio.currentTime);g.gain.exponentialRampToValueAtTime(.0001,s.audio.currentTime+dur);o.start();o.stop(s.audio.currentTime+dur);
}catch(e){}
}
function reset(){s.run=false;s.score=0;s.time=25;s.last=0;s.balls=[];scoreEl.textContent='0';timeEl.textContent='25';msg.textContent='Renkli toplara tıkla. Ses çıkar.';draw();}
function spawn(){if(s.balls.length>10)return;s.balls.push({x:35+Math.random()*(W-70),y:H+30,r:18+Math.random()*16,c:colors[Math.floor(Math.random()*colors.length)],v:1.3+Math.random()*1.8})}
function update(dt){
s.time-=dt/60;if(s.time<=0){s.time=0;s.run=false;msg.textContent='Süre bitti.';beep(220,.25,'triangle');}
if(Math.random()<0.08)spawn();
for(let i=s.balls.length-1;i>=0;i--){s.balls[i].y-=s.balls[i].v;if(s.balls[i].y+s.balls[i].r<0)s.balls.splice(i,1);}
timeEl.textContent=Math.ceil(s.time);
}
function draw(){
ctx.clearRect(0,0,W,H);
for(const b of s.balls){
ctx.beginPath();ctx.fillStyle=b.c;ctx.arc(b.x,b.y,b.r,0,Math.PI*2);ctx.fill();
ctx.fillStyle='rgba(255,255,255,.45)';ctx.beginPath();ctx.arc(b.x-b.r/3,b.y-b.r/3,b.r/4,0,Math.PI*2);ctx.fill();
}
if(!s.run){
ctx.fillStyle='rgba(15,23,42,.12)';ctx.fillRect(0,0,W,H);
ctx.fillStyle='#0f172a';ctx.textAlign='center';ctx.font='bold 34px Arial';ctx.fillText('Ses Efektli Sürüm',W/2,H/2-8);
ctx.font='bold 18px Arial';ctx.fillText('Başlat ve tıkla',W/2,H/2+26);
}
}
function loop(t){if(!s.run){draw();return;}const dt=Math.min((t-s.last)/16.67,2);s.last=t;update(dt);draw();if(s.run)requestAnimationFrame(loop);}
canvas.addEventListener('click',function(e){
if(!s.run)return;
const rect=canvas.getBoundingClientRect(),x=(e.clientX-rect.left)*(canvas.width/rect.width),y=(e.clientY-rect.top)*(canvas.height/rect.height);
for(let i=s.balls.length-1;i>=0;i--){
const b=s.balls[i],dx=x-b.x,dy=y-b.y;
if(Math.sqrt(dx*dx+dy*dy)<=b.r){
s.balls.splice(i,1);s.score+=10;scoreEl.textContent=s.score;beep(300+Math.random()*500,.12,'square');break;
}
}
});
start.addEventListener('click',function(){if(!s.run){beep(520,.15,'sine');s.run=true;s.last=performance.now();msg.textContent='Patlat ve dinle.';requestAnimationFrame(loop);}});
restart.addEventListener('click',reset);
reset();
});
});
JS;

if (!function_exists('zo_ses_efektli_surum_render')) {
	function zo_ses_efektli_surum_render($post_id = 0, $game = array()) {
		ob_start(); ?>
		<div class="zo-game-root zo-game-root--ses-efektli-surum">
			<div class="zo-ses-wrap">
				<h2 class="zo-ses-title">Ses Efektli Sürüm</h2>
				<p class="zo-ses-sub">Renkli toplara tıkla. Her tıklamada ses çıkar.</p>
				<div class="zo-ses-top">
					<div class="zo-ses-stats">
						<div class="zo-ses-stat">Skor: <span class="zo-ses-score">0</span></div>
						<div class="zo-ses-stat">Süre: <span class="zo-ses-time">25</span></div>
					</div>
					<div>
						<button type="button" class="zo-ses-btn zo-ses-start">Başlat</button>
						<button type="button" class="zo-ses-btn zo-ses-restart">Sıfırla</button>
					</div>
				</div>
				<canvas width="760" height="420"></canvas>
				<div class="zo-ses-msg">Renkli toplara tıkla. Ses çıkar.</div>
			</div>
		</div>
		<?php return ob_get_clean();
	}
}

return array(
	'slug' => 'ses-efektli-surum',
	'name' => 'Ses Efektli Sürüm',
	'author' => 'Arslan',
	'description' => 'Basit ses efektli tıklama oyunu.',
	'render_callback' => 'zo_ses_efektli_surum_render',
	'inline_style' => $inline_style,
	'inline_script' => $inline_script,
);