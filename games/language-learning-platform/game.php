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

add_action('wp_ajax_zo_ll_delete_set', 'zo_ll_delete_set');
add_action('wp_ajax_nopriv_zo_ll_delete_set', 'zo_ll_delete_set');

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

	if (!is_array($items) || empty($items)) {
		wp_send_json_error('Invalid items');
	}

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
	$list = get_option('zo_ll_shared_sets', array());
	wp_send_json_success($list);
}

function zo_ll_delete_set() {

	check_ajax_referer('zo_ll_nonce', 'nonce');

	$password = sanitize_text_field($_POST['password'] ?? '');
	$index    = intval($_POST['index'] ?? -1);

	if ($password !== 'asker1905123') {
		wp_send_json_error('Wrong admin password');
	}

	$list = get_option('zo_ll_shared_sets', array());

	if (isset($list[$index])) {
		array_splice($list, $index, 1);
		update_option('zo_ll_shared_sets', $list);
	}

	wp_send_json_success($list);
}

/* =========================
   STYLES
========================= */

$css = <<<'CSS'
.zo-ll-root{
max-width:900px;
margin:0 auto;
padding:20px;
background:linear-gradient(180deg,#0f172a,#1e293b);
border-radius:20px;
color:#fff;
font-family:inherit;
}

.zo-ll-section{margin-bottom:20px;}

.zo-ll-input,.zo-ll-select{
width:100%;
padding:8px;
border-radius:8px;
border:none;
margin-bottom:6px;
}

.zo-ll-btn{
background:#38bdf8;
color:#0f172a;
border:none;
border-radius:999px;
padding:8px 14px;
font-weight:700;
cursor:pointer;
margin:4px 4px 6px 0;
}

.zo-ll-card-wrap{
perspective:1000px;
width:100%;
max-width:400px;
margin:20px auto;
}

.zo-ll-card{
width:100%;
height:250px;
position:relative;
transform-style:preserve-3d;
transition:transform .6s;
cursor:pointer;
}

.zo-ll-card.flipped{transform:rotateY(180deg);}

.zo-ll-face{
position:absolute;
width:100%;
height:100%;
backface-visibility:hidden;
border-radius:16px;
background:#1e293b;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
padding:10px;
}

.zo-ll-back{
transform:rotateY(180deg);
background:#334155;
}

.zo-ll-img{
max-width:100%;
max-height:120px;
margin-bottom:10px;
border-radius:10px;
}

.zo-ll-audio{
margin-top:10px;
}

.zo-ll-status{
min-height:24px;
color:#facc15;
font-weight:600;
}

.zo-ll-set{
background:rgba(255,255,255,.08);
padding:10px;
border-radius:10px;
margin-bottom:8px;
}
CSS;

/* =========================
   SCRIPT
========================= */

$js = <<<'JS'
document.addEventListener("DOMContentLoaded",function(){

const games=document.querySelectorAll(".zo-ll-root");

games.forEach(function(game){

const ajaxUrl=window.location.origin+"/wp-admin/admin-ajax.php";
const nonce=game.dataset.nonce;

let allSets=[];
let currentItems=[];
let currentIndex=0;

const statusEl=game.querySelector(".zo-ll-status");
const listBox=game.querySelector(".zo-ll-list");

const langFilter=game.querySelector(".zo-ll-filter-language");
const catFilter=game.querySelector(".zo-ll-filter-category");
const setFilter=game.querySelector(".zo-ll-filter-set");

const card=game.querySelector(".zo-ll-card");
const frontWord=game.querySelector(".zo-ll-front-word");
const backWord=game.querySelector(".zo-ll-back-word");
const imgEl=game.querySelector(".zo-ll-img");
const audioBtn=game.querySelector(".zo-ll-audio");

function renderFilters(){
langFilter.innerHTML='<option value="">All Languages</option>';
catFilter.innerHTML='<option value="">All Categories</option>';
setFilter.innerHTML='<option value="">Select Set</option>';

const languages=[...new Set(allSets.map(s=>s.language))];
const categories=[...new Set(allSets.map(s=>s.category))];

languages.forEach(l=>langFilter.innerHTML+=`<option>${l}</option>`);
categories.forEach(c=>catFilter.innerHTML+=`<option>${c}</option>`);

allSets.forEach((s,i)=>{
setFilter.innerHTML+=`<option value="${i}">${s.title}</option>`;
});
}

function loadSets(){
fetch(ajaxUrl+"?action=zo_ll_get_sets")
.then(r=>r.json())
.then(d=>{
if(d.success){
allSets=d.data||[];
renderFilters();
}
});
}

function loadSet(index){
currentItems=allSets[index].items;
currentIndex=0;
showCard();
}

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
audioBtn.onclick=function(){
new Audio(item.audio).play();
};
}else{
audioBtn.style.display="none";
}

card.classList.remove("flipped");
}

game.querySelector(".zo-ll-next").onclick=function(){
if(currentIndex<currentItems.length-1){
currentIndex++;
showCard();
}
};

game.querySelector(".zo-ll-prev").onclick=function(){
if(currentIndex>0){
currentIndex--;
showCard();
}
};

card.onclick=function(){
card.classList.toggle("flipped");
};

setFilter.onchange=function(){
if(this.value!==""){
loadSet(this.value);
}
};

game.querySelector(".zo-ll-save").onclick=function(){

const title=game.querySelector(".zo-ll-title").value.trim();
const language=game.querySelector(".zo-ll-language").value.trim();
const category=game.querySelector(".zo-ll-category").value.trim();
const items=currentItems;

if(!title||!language||!category||!items.length)return;

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
items:JSON.stringify(items),
password:pass,
nonce:nonce
})
})
.then(r=>r.json())
.then(d=>{
if(d.success){
statusEl.textContent="Saved.";
loadSets();
}else{
statusEl.textContent=d.data;
}
});
};

game.querySelector(".zo-ll-add-item").onclick=function(){

const word=game.querySelector(".zo-ll-word").value.trim();
const trans=game.querySelector(".zo-ll-translation").value.trim();
const audio=game.querySelector(".zo-ll-audio-url").value.trim();
const image=game.querySelector(".zo-ll-image-url").value.trim();

if(!word||!trans)return;

currentItems.push({word:word,translation:trans,audio:audio,image:image});

game.querySelector(".zo-ll-word").value="";
game.querySelector(".zo-ll-translation").value="";
game.querySelector(".zo-ll-audio-url").value="";
game.querySelector(".zo-ll-image-url").value="";
};

loadSets();

});
});
JS;

/* =========================
   RENDER
========================= */

function zo_game_language_learner_render($post_id=0,$module=array()){

$instance='zo-ll-'.($post_id?absint($post_id):wp_rand(1000,999999));
$nonce=wp_create_nonce('zo_ll_nonce');

ob_start();
?>
<div class="zo-game-root zo-ll-root" id="<?php echo esc_attr($instance); ?>" data-nonce="<?php echo esc_attr($nonce); ?>">

<h2>Language Learning Platform</h2>

<div class="zo-ll-section">
<select class="zo-ll-filter-language"></select>
<select class="zo-ll-filter-category"></select>
<select class="zo-ll-filter-set"></select>
</div>

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
<input class="zo-ll-input zo-ll-audio-url" placeholder="Audio URL (optional)">
<input class="zo-ll-input zo-ll-image-url" placeholder="Image URL (optional)">

<button class="zo-ll-btn zo-ll-add-item">Add Item</button>
<button class="zo-ll-btn zo-ll-save">Save Set</button>

<div class="zo-ll-status"></div>

<div class="zo-ll-list"></div>

</div>
<?php
return ob_get_clean();
}

return array(
'slug'=>'language-learning-platform',
'name'=>'Language Learning Platform',
'author'=>'Asker',
'description'=>'Flashcards with audio, images, categories, and multi-language support.',
'render_callback'=>'zo_game_language_learner_render',
'inline_style'=>$css,
'inline_script'=>$js,
);