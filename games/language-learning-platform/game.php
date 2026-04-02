<?php
if (!defined('ABSPATH')) exit;

$css = '
.ll{background:#0f172a;color:#fff;padding:20px;border-radius:16px;max-width:800px;margin:auto}
.card-wrap{perspective:1000px;margin:20px 0}
.card{height:220px;position:relative;transform-style:preserve-3d;transition:.6s}
.card.flip{transform:rotateY(180deg)}
.face{position:absolute;width:100%;height:100%;backface-visibility:hidden;border-radius:14px;background:#1e293b;display:flex;flex-direction:column;justify-content:center;align-items:center}
.back{transform:rotateY(180deg);background:#334155}
img{max-height:120px;margin-bottom:10px}
button{margin:4px;padding:6px 10px;border:none;border-radius:20px;background:#38bdf8;color:#000;font-weight:bold;cursor:pointer}
';

$js = <<<JS
document.addEventListener("DOMContentLoaded",function(){

const data = [
{word:"Kaplan", translation:"Tiger", image:"", audio:""},
{word:"Kedi", translation:"Cat", image:"", audio:""}
];

let index=0;

function show(){
document.querySelector(".front-word").textContent=data[index].word;
document.querySelector(".back-trans").textContent=data[index].translation;
document.querySelector(".card").classList.remove("flip");
}

document.querySelector(".prev").onclick=function(){
if(index>0){index--;show();}
};

document.querySelector(".next").onclick=function(){
if(index<data.length-1){index++;show();}
};

document.querySelector(".card").onclick=function(){
this.classList.toggle("flip");
};

show();
});
JS;

function zo_game_language_learner_render(){

ob_start(); ?>

<div class="ll">

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
'description'=>'Test flashcard base.',
'render_callback'=>'zo_game_language_learner_render',
'inline_style'=>$css,
'inline_script'=>$js
];