<?php

if (!defined('ABSPATH')) {
	exit;
}

/* =========================
   AJAX HANDLERS
========================= */

add_action('wp_ajax_zo_ll_save_set', 'zo_ll_save_set');
add_action('wp_ajax_nopriv_zo_ll_save_set', 'zo_ll_save_set');

add_action('wp_ajax_zo_ll_get_sets', 'zo_ll_get_sets');
add_action('wp_ajax_nopriv_zo_ll_get_sets', 'zo_ll_get_sets');

function zo_ll_save_set() {

	check_ajax_referer('zo_ll_nonce', 'nonce');

	$password = sanitize_text_field($_POST['password'] ?? '');

	if ($password !== 'asker1905123') {
		wp_send_json_error('Wrong admin password');
	}

	$title     = sanitize_text_field($_POST['title'] ?? '');
	$language  = sanitize_text_field($_POST['language'] ?? '');
	$category  = sanitize_text_field($_POST['category'] ?? '');
	$items_raw = wp_unslash($_POST['items'] ?? '');

	if (!$title || !$language || !$category || !$items_raw) {
		wp_send_json_error('Missing data');
	}

	$items = json_decode($items_raw, true);

	$list = get_option('zo_ll_shared_sets', array());

	$list[] = array(
		'title'    => $title,
		'language' => $language,
		'category' => $category,
		'items'    => $items,
	);

	update_option('zo_ll_shared_sets', $list);

	wp_send_json_success($list);
}

function zo_ll_get_sets() {
	wp_send_json_success(get_option('zo_ll_shared_sets', array()));
}

/* =========================
   STYLES
========================= */

$css = '
.zo-ll-root{max-width:900px;margin:0 auto;padding:20px;background:linear-gradient(180deg,#0f172a,#1e293b);border-radius:20px;color:#fff;font-family:inherit;}
.zo-ll-input{width:100%;padding:8px;margin-bottom:6px;border:none;border-radius:8px;}
.zo-ll-btn{background:#38bdf8;color:#0f172a;border:none;border-radius:999px;padding:8px 14px;font-weight:700;cursor:pointer;margin:4px 4px 6px 0;}
.zo-ll-card-wrap{perspective:1000px;max-width:400px;margin:20px auto;}
.zo-ll-card{height:250px;position:relative;transform-style:preserve-3d;transition:transform .6s;cursor:pointer;}
.zo-ll-card.flipped{transform:rotateY(180deg);}
.zo-ll-face{position:absolute;width:100%;height:100%;backface-visibility:hidden;border-radius:16px;background:#1e293b;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:10px;}
.zo-ll-back{transform:rotateY(180deg);background:#334155;}
.zo-ll-img{max-width:100%;max-height:120px;margin-bottom:10px;border-radius:10px;}
.zo-ll-select{width:100%;padding:8px;margin-bottom:6px;border-radius:8px;border:none;}
.zo-ll-status{min-height:24px;color:#facc15;font-weight:600;}
';

/* =========================
   SCRIPT
========================= */

$js = <<<JS
document.addEventListener("DOMContentLoaded",function(){

const games=document.querySelectorAll(".zo-ll-root");

games.forEach(function(game){

const ajaxUrl=window.location.origin+"/wp-admin/admin-ajax.php";
const nonce=game.dataset.nonce;
const loggedIn=game.dataset.loggedin==="1";

let tempItems=[];
let allSets=[];
let currentItems=[];
let currentIndex=0;

const card=game.querySelector(".zo-ll-card");
const frontWord=game.querySelector(".zo-ll-front-word");
const backWord=game.querySelector(".zo-ll-back-word");
const imgEl=game.querySelector(".zo-ll-img");
const audioBtn=game.querySelector(".zo-ll-audio");
const statusEl=game.querySelector(".zo-ll-status");
const setFilter=game.querySelector(".zo-ll-filter-set");

function showCard(){
if(!currentItems.length)return;
const item=currentItems[currentIndex];
frontWord.textContent=item.word;
backWord.textContent=item.translation;

if(item.image){
imgEl.src=item.image;
imgEl.style.display="block";
}else{
imgEl.style.display="none";
}

if(item.audio){
audioBtn.style.display="inline-block";
audioBtn.onclick=function(){new Audio(item.audio).play();};
}else{
audioBtn.style.display="none";
}

card.classList.remove("flipped");
}

card.onclick=function(){card.classList.toggle("flipped");};

game.querySelector(".zo-ll-next").onclick=function(){
if(currentIndex<currentItems.length-1){currentIndex++;showCard();}
};

game.querySelector(".zo-ll-prev").onclick=function(){
if(currentIndex>0){currentIndex--;showCard();}
};

function loadSets(){
fetch(ajaxUrl+"?action=zo_ll_get_sets")
.then(r=>r.json())
.then(d=>{
if(d.success){
allSets=d.data||[];
renderSetFilter();
}
});
}

function renderSetFilter(){
setFilter.innerHTML='<option value="">Select Set</option>';
allSets.forEach((s,i)=>{
setFilter.innerHTML+=`<option value="\${i}">\${s.language} - \${s.category} - \${s.title}</option>`;
});
}

setFilter.onchange=function(){
if(this.value!==""){
currentItems=allSets[this.value].items;
currentIndex=0;
showCard();
}
};

/* ===== MEDIA UPLOAD ===== */

function openMedia(field){

const frame=wp.media({
title:"Select File",
button:{text:"Use this file"},
multiple:false
});

frame.on("select",function(){
const attachment=frame.state().get("selection").first().toJSON();
field.value=attachment.url;
});

frame.open();
}

if(loggedIn && typeof wp!=="undefined" && wp.media){

game.querySelector(".zo-ll-upload-audio").onclick=function(){
openMedia(game.querySelector(".zo-ll-audio-url"));
};

game.querySelector(".zo-ll-upload-image").onclick=function(){
openMedia(game.querySelector(".zo-ll-image-url"));
};

}else{

game.querySelectorAll(".zo-ll-upload-audio,.zo-ll-upload-image").forEach(btn=>{
btn.onclick=function(){alert("Login required for upload.");};
});

}

/* ===== ADD ITEM ===== */

game.querySelector(".zo-ll-add-item").onclick=function(){

const word=game.querySelector(".zo-ll-word").value.trim();
const trans=game.querySelector(".zo-ll-translation").value.trim();
const audio=game.querySelector(".zo-ll-audio-url").value.trim();
const image=game.querySelector(".zo-ll-image-url").value.trim();

if(!word||!trans)return;

tempItems.push({word:word,translation:trans,audio:audio,image:image});

game.querySelector(".zo-ll-word").value="";
game.querySelector(".zo-ll-translation").value="";
game.querySelector(".zo-ll-audio-url").value="";
game.querySelector(".zo-ll-image-url").value="";
};

/* ===== SAVE SET ===== */

game.querySelector(".zo-ll-save").onclick=function(){

const title=game.querySelector(".zo-ll-title").value.trim();
const language=game.querySelector(".zo-ll-language").value.trim();
const category=game.querySelector(".zo-ll-category").value.trim();

if(!title||!language||!category||!tempItems.length)return;

const pass=prompt("Admin password:");
if(!pass)return;

fetch(ajaxUrl,{
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:new URLSearchParams({
action:"zo_ll_save_set",
title:title,
language:language,
category:category,
items:JSON.stringify(tempItems),
password:pass,
nonce:nonce
})
})
.then(r=>r.json())
.then(d=>{
if(d.success){
statusEl.textContent="Saved.";
tempItems=[];
loadSets();
}else{
statusEl.textContent=d.data;
}
});
};

loadSets();

});
});
JS;

/* =========================
   RENDER
========================= */

function zo_game_language_learner_render($post_id=0,$module=array()){

if(is_user_logged_in()){
	wp_enqueue_media();
}

$instance='zo-ll-'.wp_rand(1000,999999);
$nonce=wp_create_nonce('zo_ll_nonce');

ob_start();
?>
<div class="zo-game-root zo-ll-root"
     id="<?php echo esc_attr($instance); ?>"
     data-nonce="<?php echo esc_attr($nonce); ?>"
     data-loggedin="<?php echo is_user_logged_in()?'1':'0'; ?>">

<h2>Language Learning Platform</h2>

<select class="zo-ll-select zo-ll-filter-set"></select>

<div class="zo-ll-card-wrap">
<div class="zo-ll-card">
<div class="zo-ll-face">
<img class="zo-ll-img" style="display:none;">
<h3 class="zo-ll-front-word"></h3>
</div>
<div class="zo-ll-face zo-ll-back">
<h3 class="zo-ll-back-word"></h3>
<button class="zo-ll-btn zo-ll-audio" style="display:none;">Play Audio</button>
</div>
</div>
</div>

<button class="zo-ll-btn zo-ll-prev">Previous</button>
<button class="zo-ll-btn zo-ll-next">Next</button>

<hr>

<h3>Admin Add Set</h3>

<input class="zo-ll-input zo-ll-title" placeholder="Set Title">
<input class="zo-ll-input zo-ll-language" placeholder="Language">
<input class="zo-ll-input zo-ll-category" placeholder="Category">

<input class="zo-ll-input zo-ll-word" placeholder="Word">
<input class="zo-ll-input zo-ll-translation" placeholder="Translation">

<input class="zo-ll-input zo-ll-audio-url" placeholder="Audio URL">
<button class="zo-ll-btn zo-ll-upload-audio">Upload Audio</button>

<input class="zo-ll-input zo-ll-image-url" placeholder="Image URL">
<button class="zo-ll-btn zo-ll-upload-image">Upload Image</button>

<button class="zo-ll-btn zo-ll-add-item">Add Item</button>
<button class="zo-ll-btn zo-ll-save">Save Set</button>

<div class="zo-ll-status"></div>

</div>
<?php
return ob_get_clean();
}

return array(
'slug'=>'language-learning-platform',
'name'=>'Language Learning Platform',
'author'=>'Asker',
'description'=>'Flashcards with upload support.',
'render_callback'=>'zo_game_language_learner_render',
'inline_style'=>$css,
'inline_script'=>$js,
);