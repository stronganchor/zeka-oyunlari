<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root--mindsweeper{max-width:920px;margin:0 auto;padding:22px;border-radius:26px;background:linear-gradient(145deg,#101c3a,#203b70);color:#eef5ff;font-family:"Trebuchet MS","Segoe UI",sans-serif;box-sizing:border-box;box-shadow:0 20px 45px rgba(20,39,86,.25)}
.zo-ms-card{background:rgba(8,18,43,.72);border:1px solid rgba(160,201,255,.28);border-radius:20px;padding:20px}.zo-ms-title{text-align:center;margin:0 0 6px;font-size:36px}.zo-ms-subtitle{text-align:center;color:#bdd2f3;margin:0 auto 18px;line-height:1.5}.zo-ms-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:18px}.zo-ms-stat{background:#172b56;border-radius:14px;padding:10px;text-align:center}.zo-ms-label{display:block;color:#9db7df;font-size:11px;text-transform:uppercase;letter-spacing:.08em}.zo-ms-value{display:block;font-size:23px;font-weight:800;margin-top:3px}.zo-ms-board-wrap{overflow:auto;padding:3px}.zo-ms-board{display:grid;gap:4px;justify-content:center;min-width:max-content}.zo-ms-cell{width:38px;height:38px;border:0;border-radius:8px;background:#31558f;color:#fff;font-size:19px;font-weight:900;cursor:pointer;box-shadow:inset 0 -3px rgba(0,0,0,.18);transition:transform .1s,background .1s}.zo-ms-cell:hover{transform:translateY(-2px);background:#426eaf}.zo-ms-cell.is-open{background:#dceaff;color:#17315d;box-shadow:none}.zo-ms-cell.is-flag{background:#f6b73c;color:#392500}.zo-ms-cell.is-mine{background:#e85d75}.zo-ms-n1{color:#2c6fd1!important}.zo-ms-n2{color:#23945e!important}.zo-ms-n3{color:#d34b4b!important}.zo-ms-n4{color:#7849b9!important}.zo-ms-actions{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin:18px 0 10px}.zo-ms-btn{border:0;border-radius:999px;padding:11px 18px;font-weight:800;cursor:pointer;background:#6fd6c7;color:#0d2940}.zo-ms-btn--secondary{background:#fff;color:#17315d}.zo-ms-status{text-align:center;min-height:24px;color:#d7e6ff}.zo-ms-help{text-align:center;color:#9db7df;font-size:13px;margin-top:8px}@media(max-width:600px){.zo-ms-title{font-size:29px}.zo-game-root--mindsweeper{padding:12px}.zo-ms-card{padding:14px}.zo-ms-cell{width:32px;height:32px;font-size:16px}.zo-ms-stats{gap:5px}.zo-ms-value{font-size:18px}}
CSS;

$js = <<<'JS'
(function(){
  function init(root){
    var boardEl=root.querySelector('.zo-ms-board'), levelEl=root.querySelector('.zo-ms-level'), minesEl=root.querySelector('.zo-ms-mines'), flagsEl=root.querySelector('.zo-ms-flags'), statusEl=root.querySelector('.zo-ms-status');
    var level=1, rows, cols, mines, cells=[], flags=new Set(), opened=new Set(), mineSet=new Set(), started=false, gameOver=false;
    function key(r,c){return r+','+c}
    function around(r,c){var a=[];for(var dr=-1;dr<=1;dr++)for(var dc=-1;dc<=1;dc++)if((dr||dc)&&r+dr>=0&&r+dr<rows&&c+dc>=0&&c+dc<cols)a.push([r+dr,c+dc]);return a}
    function config(){rows=Math.min(16,7+Math.floor((level-1)/7));cols=Math.min(22,9+Math.floor((level-1)/5));mines=Math.min(rows*cols-9,8+level*2+Math.floor(level/10)*3)}
    function build(firstR,firstC){var safe=new Set([key(firstR,firstC)]);around(firstR,firstC).forEach(function(p){safe.add(key(p[0],p[1]))});var choices=[];for(var r=0;r<rows;r++)for(var c=0;c<cols;c++)if(!safe.has(key(r,c)))choices.push([r,c]);var seed=level*7919+Date.now()%100000;function rand(){seed=(seed*9301+49297)%233280;return seed/233280}while(mineSet.size<mines){var p=choices[Math.floor(rand()*choices.length)];mineSet.add(key(p[0],p[1]))}}
    function count(r,c){var n=0;around(r,c).forEach(function(p){if(mineSet.has(key(p[0],p[1])))n++});return n}
    function render(){config();levelEl.textContent=level;minesEl.textContent=mines;flagsEl.textContent=flags.size+'/'+mines;boardEl.style.gridTemplateColumns='repeat('+cols+',1fr)';boardEl.innerHTML='';cells=[];for(var r=0;r<rows;r++){cells[r]=[];for(var c=0;c<cols;c++){var b=document.createElement('button');b.type='button';b.className='zo-ms-cell';b.setAttribute('aria-label','Hidden cell '+(r+1)+','+(c+1));(function(rr,cc){b.addEventListener('click',function(){openCell(rr,cc)});b.addEventListener('contextmenu',function(e){e.preventDefault();toggleFlag(rr,cc)})})(r,c);boardEl.appendChild(b);cells[r][c]=b}}}
    function paint(r,c){var b=cells[r][c], k=key(r,c);b.className='zo-ms-cell';if(flags.has(k)){b.textContent='⚑';b.classList.add('is-flag');return}if(!opened.has(k)){b.textContent='';return}if(mineSet.has(k)){b.textContent='✹';b.classList.add('is-mine');return}var n=count(r,c);b.classList.add('is-open');b.textContent=n||'';if(n)b.classList.add('zo-ms-n'+n)}
    function openCell(r,c){if(gameOver||flags.has(key(r,c)))return;if(!started){build(r,c);started=true}var queue=[[r,c]];while(queue.length){var p=queue.pop(),k=key(p[0],p[1]);if(opened.has(k)||flags.has(k))continue;if(mineSet.has(k)){gameOver=true;opened.add(k);for(var mr=0;mr<rows;mr++)for(var mc=0;mc<cols;mc++)if(mineSet.has(key(mr,mc)))paint(mr,mc);statusEl.textContent='Boom! Try this level again.';return}opened.add(k);if(count(p[0],p[1])===0)around(p[0],p[1]).forEach(function(next){if(!opened.has(key(next[0],next[1])))queue.push(next)});paint(p[0],p[1])}if(opened.size>=rows*cols-mines){gameOver=true;statusEl.textContent='Level '+level+' cleared!';if(level<50){setTimeout(function(){level++;newLevel()},500)}else statusEl.textContent='🏆 You completed all 50 levels!'}}
    function toggleFlag(r,c){if(gameOver||opened.has(key(r,c)))return;var k=key(r,c);if(flags.has(k))flags.delete(k);else if(flags.size<mines)flags.add(k);paint(r,c);flagsEl.textContent=flags.size+'/'+mines}
    function newLevel(){flags=new Set();opened=new Set();mineSet=new Set();started=false;gameOver=false;statusEl.textContent='Click a square to begin. The first move is always safe.';render()}
    root.querySelector('.zo-ms-new').addEventListener('click',newLevel);root.querySelector('.zo-ms-retry').addEventListener('click',newLevel);newLevel();
  }
  document.querySelectorAll('.zo-game-root--mindsweeper').forEach(init);
})();
JS;

if (!function_exists('zo_game_mindsweeper_render')) {
	function zo_game_mindsweeper_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-mindsweeper-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));
		ob_start(); ?>
		<div class="zo-game-root zo-game-root--mindsweeper" id="<?php echo esc_attr($instance_id); ?>">
			<div class="zo-ms-card">
				<h2 class="zo-ms-title">🧠 Mindsweeper</h2>
				<p class="zo-ms-subtitle">Clear the safe squares, mark the mines, and beat all 50 levels. Click to reveal; right-click (or long-press menu) to flag.</p>
				<div class="zo-ms-stats"><div class="zo-ms-stat"><span class="zo-ms-label">Level</span><span class="zo-ms-value zo-ms-level">1</span></div><div class="zo-ms-stat"><span class="zo-ms-label">Mines</span><span class="zo-ms-value zo-ms-mines">10</span></div><div class="zo-ms-stat"><span class="zo-ms-label">Flags</span><span class="zo-ms-value zo-ms-flags">0/10</span></div><div class="zo-ms-stat"><span class="zo-ms-label">Goal</span><span class="zo-ms-value">50</span></div></div>
				<div class="zo-ms-board-wrap"><div class="zo-ms-board"></div></div>
				<div class="zo-ms-actions"><button type="button" class="zo-ms-btn zo-ms-new">New Level</button><button type="button" class="zo-ms-btn zo-ms-btn--secondary zo-ms-retry">Restart</button></div>
				<div class="zo-ms-status">Click a square to begin. The first move is always safe.</div><div class="zo-ms-help">Numbers show how many mines touch that square.</div>
			</div>
		</div>
		<?php return ob_get_clean();
	}
}

return array('slug'=>'mindsweeper','name'=>'Mindsweeper','author'=>'Arslan','description'=>'Clear mines across 50 progressively harder levels in this classic logic game.','render_callback'=>'zo_game_mindsweeper_render','inline_style'=>$css,'inline_script'=>$js);
