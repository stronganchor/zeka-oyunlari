<?php
if (!defined('ABSPATH')) exit;

/* ===== AJAX READ ONLY ===== */

add_action('wp_ajax_zo_ll_get','zo_ll_get');
add_action('wp_ajax_nopriv_zo_ll_get','zo_ll_get');

function zo_ll_get(){
	wp_send_json_success(get_option('zo_ll_sets',[]));
}

/* ===== CSS ===== */

$css='
.ll{background:#0f172a;color:#fff;padding:20px;border-radius:16px;max-width:800px;margin:auto}
select{margin-bottom:10px;padding:6px;border-radius:6px}
.card-wrap{perspective:1000px;margin:20px 0}
.card{height:220px;position:relative;transform-style:preserve-3d;transition:.6s}
.card.flip{transform:rotateY(180deg)}
.face{position:absolute;width:100%;height:100%;backface-visibility:hidden;border-radius:14px;background:#1e293b;display:flex;flex-direction:column;justify-content:center;align-items:center}
.back{transform:rotateY(180deg);background:#334155}
button{margin:4px;padding:6px 10px;border:none;border-radius:20px;background:#38bdf8;color:#000;font-weight:bold;cursor:pointer}
';

/* ===== JS ===== */

$js=<<<JS
document.addEventListener("DOMContentLoaded",function(){

const ajax=window.location.origin+"/wp-admin/admin-ajax.php";

let sets=[];
let currentSet=null;
let index=0;

function load(){
fetch(ajax+"?action=zo_ll_get")
.then(r=>r.json())
.then(d=>{
if(d.success){
sets=d.data||[];
renderSelect();
}
});
}

function renderSelect(){
const sel=document.querySelector(".set");
sel.innerHTML='<option value="">Select Set</option>';

sets.forEach((s,i)=>{
sel.innerHTML+=`<option value="\${i}">\${s.language||''} - \${s.category||''}</option>`;
});
}

document.querySelector(".set").onchange=function(){
if(this.value==="") return;
currentSet=parseInt(this.value);
index=0;
show();
};

function show(){
if(currentSet===null) return;
const items=sets[currentSet].items;
if(!items || !items.length) return;

document.querySelector(".front-word").textContent=items[index].word;
document.querySelector(".back-trans").textContent=items[index].translation;
document.querySelector(".card").classList.remove("flip");
}

document.querySelector(".prev").onclick=function(){
if(currentSet===null) return;
if(index>0){index--;show();}
};

document.querySelector(".next").onclick=function(){
if(currentSet===null) return;
if(index < sets[currentSet].items.length-1){index++;show();}
};

document.querySelector(".card").onclick=function(){
this.classList.toggle("flip");
};

load();
});
JS;

/* ===== RENDER ===== */

function zo_game_language_learner_render(){

ob_start(); ?>

<div class="ll">

<select class="set"></select>

<div class="card-wrap">
<div class="card">
<div class="face">
<h2 class="front-word"></h2>
</div>
<div class="face back">
<h3 class="back-trans"></h3>
</div>
</div>
</div>

<button class="prev">Prev</button>
<button class="next">Next</button>

</div>

<?php return ob_get_clean(); }

return [
'slug'=>'language-learning-platform',
'name'=>'Language Learning Platform',
'author'=>'Asker',
'description'=>'Phase 1 dynamic.',
'render_callback'=>'zo_game_language_learner_render',
'inline_style'=>$css,
'inline_script'=>$js
];