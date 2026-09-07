<?php

if (!defined('ABSPATH')) {
	exit;
}

$inline_style = <<<'CSS'
.zo-game-root--monster-maze{max-width:1100px;margin:0 auto;padding:14px;font-family:Arial,sans-serif;color:#e5e7eb}
.zo-game-root--monster-maze *{box-sizing:border-box}
.zo-mm-card{background:linear-gradient(145deg,#111827,#1f2937);border:1px solid #374151;border-radius:20px;padding:18px;box-shadow:0 18px 45px rgba(0,0,0,.28)}
.zo-mm-title{margin:0 0 6px;text-align:center;font-size:clamp(24px,4vw,36px);color:#fca5a5}
.zo-mm-sub{margin:0 auto 14px;max-width:760px;text-align:center;color:#cbd5e1;line-height:1.5}
.zo-mm-top{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:12px}
.zo-mm-stats{display:flex;gap:8px;flex-wrap:wrap}.zo-mm-stat{padding:9px 12px;border-radius:999px;background:#374151;font-weight:800}
.zo-mm-btn{border:0;border-radius:10px;padding:10px 14px;background:#dc2626;color:#fff;font-weight:800;cursor:pointer}.zo-mm-btn:hover{background:#b91c1c}
.zo-mm-canvas-wrap{position:relative;max-width:900px;margin:auto}.zo-mm-canvas{display:block;width:100%;height:auto;aspect-ratio:3/2;border:2px solid #4b5563;border-radius:12px;background:#111827;image-rendering:auto;cursor:crosshair;touch-action:none}
.zo-mm-message{margin:12px 0 0;padding:10px 12px;border-radius:10px;background:#374151;color:#fef3c7;font-weight:700;text-align:center}
.zo-mm-controls{display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-top:12px}.zo-mm-control{min-width:54px;padding:11px 15px;border:1px solid #6b7280;border-radius:10px;background:#4b5563;color:#fff;font-size:16px;font-weight:800;cursor:pointer;touch-action:manipulation}.zo-mm-control:active{background:#ef4444}
.zo-mm-help{margin:13px auto 0;max-width:760px;color:#cbd5e1;text-align:center;font-size:14px;line-height:1.5}
@media(max-width:560px){.zo-mm-card{padding:12px}.zo-mm-stat{font-size:13px;padding:8px 10px}.zo-mm-top{justify-content:center}.zo-mm-canvas{aspect-ratio:4/3}.zo-mm-help{font-size:13px}}
CSS;

$inline_script = <<<'JS'
document.addEventListener('DOMContentLoaded',function(){
document.querySelectorAll('.zo-game-root--monster-maze').forEach(function(root){
var canvas=root.querySelector('.zo-mm-canvas'),ctx=canvas.getContext('2d'),levelEl=root.querySelector('.zo-mm-level'),healthEl=root.querySelector('.zo-mm-health'),message=root.querySelector('.zo-mm-message');
var W=900,H=600,S=21,TILE=1,FOV=Math.PI/3,MAX=100,keys={},state,raf=0;
function maze(){var m=Array.from({length:S},function(){return Array(S).fill(1)}),stack=[[1,1]];m[1][1]=0;while(stack.length){var p=stack[stack.length-1],ds=[[2,0],[-2,0],[0,2],[0,-2]].sort(function(){return Math.random()-.5}),found=false;for(var i=0;i<ds.length;i++){var x=p[0]+ds[i][0],y=p[1]+ds[i][1];if(x>0&&x<S-1&&y>0&&y<S-1&&m[y][x]===1){m[p[1]+ds[i][1]/2][p[0]+ds[i][0]/2]=0;m[y][x]=0;stack.push([x,y]);found=true;break}}if(!found)stack.pop()}m[S-2][S-2]=2;return m}
function free(x,y){var gx=Math.floor(x),gy=Math.floor(y);return gx>=0&&gx<S&&gy>=0&&gy<S&&state.map[gy][gx]!==1}
function monsters(){var a=[],count=Math.min(2+Math.floor(state.level/3),15);for(var n=0;n<count;n++){var x,y;do{x=2+Math.floor(Math.random()*(S-4));y=2+Math.floor(Math.random()*(S-4))}while(state.map[y][x]!==0||(x<4&&y<4));a.push({x:x+.5,y:y+.5,hp:30+state.level*10,max:30+state.level*10,speed:.005+state.level*.00017,hit:0})}return a}
function reset(){state={level:1,map:maze(),x:1.5,y:1.5,a:0,hp:100,enemies:[],cool:0,run:false,over:false,won:false};state.enemies=monsters();message.textContent='Başlat düğmesine bas. Çıkışa ulaşmak için tüm canavarları yen.';updateHud();draw()}
function start(){if(state.over||state.won){reset()}state.run=true;state.over=false;state.cool=0;message.textContent='Canavarları vur ve yeşil çıkışa ulaş.';if(!raf){state.last=performance.now();raf=requestAnimationFrame(loop)}}
function updateHud(){levelEl.textContent=state.level+'/'+MAX;healthEl.textContent=Math.max(0,Math.ceil(state.hp))}
function ray(angle){var d=0,step=.025;while(d<30){d+=step;if(!free(state.x+Math.cos(angle)*d,state.y+Math.sin(angle)*d))return d}return 30}
function shoot(){if(!state.run||state.cool>0)return;state.cool=15;var hit=null,best=999;state.enemies.forEach(function(e){var dx=e.x-state.x,dy=e.y-state.y,d=Math.hypot(dx,dy),diff=Math.atan2(Math.sin(Math.atan2(dy,dx)-state.a),Math.cos(Math.atan2(dy,dx)));if(Math.abs(diff)<.10&&d<best){hit=e;best=d}});if(hit){hit.hp-=25;if(hit.hp<=0)state.enemies.splice(state.enemies.indexOf(hit),1)}}
function update(dt){var turn=(keys.ArrowLeft?-1:0)+(keys.ArrowRight?1:0);state.a+=turn*.045*dt;var f=(keys.ArrowUp||keys.KeyW?1:0)-(keys.ArrowDown||keys.KeyS?1:0),side=(keys.KeyD?1:0)-(keys.KeyA?1:0),speed=.055*dt;var nx=state.x+(Math.cos(state.a)*f+Math.cos(state.a+Math.PI/2)*side)*speed,ny=state.y+(Math.sin(state.a)*f+Math.sin(state.a+Math.PI/2)*side)*speed;if(f||side){if(free(nx,state.y))state.x=nx;if(free(state.x,ny))state.y=ny}if(state.cool>0)state.cool-=dt;state.enemies.forEach(function(e){var dx=state.x-e.x,dy=state.y-e.y,d=Math.hypot(dx,dy);if(d>0.48){var ex=e.x+dx/d*e.speed*dt,ey=e.y+dy/d*e.speed*dt;if(free(ex,e.y))e.x=ex;if(free(e.x,ey))e.y=ey}else if(e.hit<=0){state.hp-=1+Math.floor(state.level/5);e.hit=40}e.hit-=dt});var ex=S-1.5,ey=S-1.5;if(!state.enemies.length&&Math.hypot(state.x-ex,state.y-ey)<.55){state.level++;if(state.level>MAX){state.won=true;state.run=false;message.textContent='Tebrikler! 100 seviyenin tamamını bitirdin.'}else{state.map=maze();state.x=1.5;state.y=1.5;state.a=0;state.enemies=monsters();message.textContent='Seviye '+state.level+' başladı.'}}if(state.hp<=0){state.hp=0;state.run=false;state.over=true;message.textContent='Oyun bitti. Yeniden başlatıp tekrar dene.'}updateHud()}
function draw(){ctx.fillStyle='#6ca8d8';ctx.fillRect(0,0,W,H/2);ctx.fillStyle='#34383d';ctx.fillRect(0,H/2,W,H/2);for(var r=0;r<W;r++){var ang=state.a-FOV/2+FOV*r/W,d=ray(ang)*Math.cos(state.a-ang),wh=Math.min(H*2,Math.floor(500/d)),shade=Math.max(28,220-Math.floor(d*17));ctx.fillStyle='rgb('+shade+','+Math.floor(shade*.55)+','+Math.floor(shade*.35)+')';ctx.fillRect(r,H/2-wh/2,1,wh)}var visible=state.enemies.map(function(e){var dx=e.x-state.x,dy=e.y-state.y,d=Math.hypot(dx,dy),diff=Math.atan2(Math.sin(Math.atan2(dy,dx)-state.a),Math.cos(Math.atan2(dy,dx)));return {e:e,d:d,diff:diff}}).filter(function(o){return Math.abs(o.diff)<FOV/2&&o.d>.25}).sort(function(a,b){return b.d-a.d});visible.forEach(function(o){var size=Math.min(420,Math.floor(2.2/o.d*500)),sx=W/2+o.diff/FOV*W,sy=H/2-size/2;ctx.fillStyle='#b91c1c';ctx.fillRect(sx-size/2,sy,size,size);ctx.fillStyle='#111';ctx.fillRect(sx-size/2,sy-10,size,6);ctx.fillStyle='#22c55e';ctx.fillRect(sx-size/2,sy-10,size*Math.max(0,o.e.hp/o.e.max),6);ctx.fillStyle='#fee2e2';ctx.fillRect(sx-size*.2,sy+size*.25,size*.12,size*.12);ctx.fillRect(sx+size*.08,sy+size*.25,size*.12,size*.12)});drawMap();if(!state.run){ctx.fillStyle='rgba(0,0,0,.48)';ctx.fillRect(0,0,W,H);ctx.fillStyle='#fff';ctx.textAlign='center';ctx.font='bold 32px Arial';ctx.fillText(state.won?'100 SEVİYE TAMAMLANDI!':state.over?'OYUN BİTTİ':'CANAVAR LABİRENTİ',W/2,H/2-10);ctx.font='bold 17px Arial';ctx.fillText(state.over?'Yeniden başlat düğmesine bas':'Başlamak için Başlat düğmesine bas',W/2,H/2+28)}}
function drawMap(){var sc=7,ox=12,oy=12;for(var y=0;y<S;y++)for(var x=0;x<S;x++){ctx.fillStyle=state.map[y][x]===1?'#111827':state.map[y][x]===2?'#22c55e':'#d1d5db';ctx.fillRect(ox+x*sc,oy+y*sc,sc-1,sc-1)}ctx.fillStyle='#2563eb';ctx.beginPath();ctx.arc(ox+state.x*sc,oy+state.y*sc,3,0,Math.PI*2);ctx.fill();state.enemies.forEach(function(e){ctx.fillStyle='#ef4444';ctx.beginPath();ctx.arc(ox+e.x*sc,oy+e.y*sc,2,0,Math.PI*2);ctx.fill()})}
function loop(t){var dt=Math.min(2,(t-state.last)/16.67);state.last=t;if(state.run){update(dt);draw();raf=requestAnimationFrame(loop)}else{raf=0;draw()}}
window.addEventListener('keydown',function(e){keys[e.code]=true;if(['ArrowUp','ArrowDown','ArrowLeft','ArrowRight','Space'].indexOf(e.code)>=0)e.preventDefault();if(e.code==='Space')shoot()});window.addEventListener('keyup',function(e){keys[e.code]=false});canvas.addEventListener('click',shoot);root.querySelector('.zo-mm-start').addEventListener('click',start);root.querySelector('.zo-mm-restart').addEventListener('click',reset);root.querySelectorAll('[data-key]').forEach(function(btn){var key=btn.getAttribute('data-key');btn.addEventListener('pointerdown',function(e){e.preventDefault();if(key==='Space')shoot();else keys[key]=true});['pointerup','pointercancel','pointerleave'].forEach(function(ev){btn.addEventListener(ev,function(){if(key!=='Space')keys[key]=false})})});reset();
});});
JS;

function zo_monster_maze_render($post_id = 0, $module = array()) {
	ob_start(); ?>
	<div class="zo-game-root zo-game-root--monster-maze">
		<div class="zo-mm-card">
			<h2 class="zo-mm-title">100-Seviye Canavar Labirenti</h2>
			<p class="zo-mm-sub">Arslan'ın 3D labirentinde canavarları yen, çıkışı bul ve 100 seviyeyi tamamla.</p>
			<div class="zo-mm-top"><div class="zo-mm-stats"><span class="zo-mm-stat">Seviye: <span class="zo-mm-level">1/100</span></span><span class="zo-mm-stat">Can: <span class="zo-mm-health">100</span></span></div><div><button type="button" class="zo-mm-btn zo-mm-start">Başlat</button> <button type="button" class="zo-mm-btn zo-mm-restart">Sıfırla</button></div></div>
			<div class="zo-mm-canvas-wrap"><canvas class="zo-mm-canvas" width="900" height="600" aria-label="Canavar labirenti oyunu"></canvas></div>
			<div class="zo-mm-message" aria-live="polite"></div>
			<div class="zo-mm-controls"><button type="button" class="zo-mm-control" data-key="ArrowLeft">◀</button><button type="button" class="zo-mm-control" data-key="ArrowUp">▲</button><button type="button" class="zo-mm-control" data-key="ArrowDown">▼</button><button type="button" class="zo-mm-control" data-key="ArrowRight">▶</button><button type="button" class="zo-mm-control" data-key="Space">● Ateş</button></div>
			<p class="zo-mm-help"><strong>Kontroller:</strong> Oklar/WASD ile hareket et, sol-sağ oklarla dön, SPACE veya Ateş ile vur. Haritadaki yeşil çıkışa gitmeden önce tüm canavarları yenmelisin.</p>
		</div>
	</div>
	<?php return ob_get_clean();
}

return array(
	'slug' => '100-seviye-canavar-labirenti',
	'name' => '100-Seviye Canavar Labirenti',
	'author' => 'Arslan',
	'description' => 'Canavarları yenip 100 farklı labirent seviyesini tamamlamaya çalıştığın 3D tarayıcı oyunu.',
	'render_callback' => 'zo_monster_maze_render',
	'inline_style' => $inline_style,
	'inline_script' => $inline_script,
);
