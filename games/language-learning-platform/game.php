<?php
if (!defined('ABSPATH')) exit;

/* ================= AJAX ================= */

add_action('wp_ajax_zo_ll_get_sets','zo_ll_get_sets');
add_action('wp_ajax_nopriv_zo_ll_get_sets','zo_ll_get_sets');

add_action('wp_ajax_zo_ll_save_sets','zo_ll_save_sets');
add_action('wp_ajax_nopriv_zo_ll_save_sets','zo_ll_save_sets');

add_action('wp_ajax_zo_ll_upload','zo_ll_upload');
add_action('wp_ajax_nopriv_zo_ll_upload','zo_ll_upload');

function zo_ll_get_sets(){
	wp_send_json_success(get_option('zo_ll_sets',[]));
}

function zo_ll_save_sets(){

	check_ajax_referer('zo_ll_nonce','nonce');

	if($_POST['password']!=='asker1905123'){
		wp_send_json_error('Wrong password');
	}

	$sets=json_decode(stripslashes($_POST['sets']),true);
	update_option('zo_ll_sets',$sets);

	wp_send_json_success($sets);
}

function zo_ll_upload(){

	check_ajax_referer('zo_ll_nonce','nonce');

	if($_POST['password']!=='asker1905123'){
		wp_send_json_error('Wrong password');
	}

	if(empty($_FILES['file'])){
		wp_send_json_error('No file');
	}

	require_once ABSPATH.'wp-admin/includes/file.php';

	$uploaded=wp_handle_upload($_FILES['file'],['test_form'=>false]);

	if(isset($uploaded['error'])){
		wp_send_json_error($uploaded['error']);
	}

	wp_send_json_success($uploaded['url']);
}

/* ================= CSS ================= */

$css = '
.zo-ll-root{max-width:900px;margin:0 auto;padding:20px;background:#0f172a;color:#fff;border-radius:18px;font-family:inherit}
.zo-ll-input{width:100%;padding:6px;margin-bottom:6px;border-radius:8px;border:none}
.zo-ll-btn{padding:6px 12px;border-radius:999px;border:none;background:#38bdf8;color:#000;font-weight:bold;margin:4px 4px 4px 0;cursor:pointer}
.zo-ll-card{height:220px;background:#1e293b;border-radius:14px;display:flex;flex-direction:column;justify-content:center;align-items:center;margin-bottom:10px;cursor:pointer}
.zo-ll-img{max-height:100px;margin-bottom:8px;border-radius:8px}
.zo-ll-set-select{width:100%;padding:6px;border-radius:8px;margin-bottom:10px}
.zo-ll-edit-box{background:#1e293b;padding:10px;border-radius:10px;margin-top:20px}
';

/* ================= JS ================= */

$js = <<<JS
document.addEventListener("DOMContentLoaded",function(){

const game=document.querySelector(".zo-ll-root");
const ajaxUrl=window.location.origin+"/wp-admin/admin-ajax.php";
const nonce=game.dataset.nonce;

let sets=[];
let currentSetIndex=null;
let currentIndex=0;
let newItems=[];

/* LOAD SETS */
function fetchSets(){
fetch(ajaxUrl+"?action=zo_ll_get_sets")
.then(r=>r.json())
.then(d=>{
if(d.success){
sets=d.data||[];
renderSetSelect();
}
});
}

function renderSetSelect(){
const select=document.querySelector(".zo-ll-set-select");
select.innerHTML='<option value="">Select Set</option>';
sets.forEach((s,i)=>{
select.innerHTML+=`<option value="\${i}">\${s.language} - \${s.category} - \${s.title}</option>`;
});
}

/* SELECT SET */
document.querySelector(".zo-ll-set-select").onchange=function(){
if(this.value==="") return;
currentSetIndex=parseInt(this.value);
currentIndex=0;
showCard();
};

/* SHOW CARD */
function showCard(){
if(currentSetIndex===null) return;
const items=sets[currentSetIndex].items;
if(!items || !items.length) return;

const item=items[currentIndex];

document.querySelector(".zo-ll-word-show").textContent=item.word;
document.querySelector(".zo-ll-translation-show").textContent=item.translation;

const img=document.querySelector(".zo-ll-img");
if(item.image){
img.src=item.image;
img.style.display="block";
}else{
img.style.display="none";
}

const audioBtn=document.querySelector(".zo-ll-audio-btn");
if(item.audio){
audioBtn.style.display="inline-block";
audioBtn.onclick=function(){ new Audio(item.audio).play(); };
}else{
audioBtn.style.display="none";
}
}

/* NAVIGATION */
document.querySelector(".zo-ll-prev").onclick=function(){
if(currentSetIndex===null) return;
if(currentIndex>0){currentIndex--;showCard();}
};

document.querySelector(".zo-ll-next").onclick=function(){
if(currentSetIndex===null) return;
const items=sets[currentSetIndex].items;
if(currentIndex < items.length-1){currentIndex++;showCard();}
};

/* UPLOAD FILE */
function uploadFile(inputField,callback){

const file=inputField.files[0];
if(!file) return;

const pass=prompt("Admin password:");
if(!pass) return;

const formData=new FormData();
formData.append("action","zo_ll_upload");
formData.append("file",file);
formData.append("password",pass);
formData.append("nonce",nonce);

fetch(ajaxUrl,{method:"POST",body:formData})
.then(r=>r.json())
.then(d=>{
if(d.success){
callback(d.data);
}else alert(d.data);
});
}

let imageURL="";
let audioURL="";

document.querySelector(".zo-ll-upload-image").onclick=function(){
uploadFile(document.querySelector(".zo-ll-image-file"),function(url){
imageURL=url;
alert("Image uploaded");
});
};

document.querySelector(".zo-ll-upload-audio").onclick=function(){
uploadFile(document.querySelector(".zo-ll-audio-file"),function(url){
audioURL=url;
alert("Audio uploaded");
});
};

/* ADD WORD */
document.querySelector(".zo-ll-add-word").onclick=function(){

const word=document.querySelector(".zo-ll-word").value.trim();
const trans=document.querySelector(".zo-ll-translation").value.trim();

if(!word||!trans) return;

newItems.push({
word:word,
translation:trans,
image:imageURL,
audio:audioURL
});

document.querySelector(".zo-ll-word").value="";
document.querySelector(".zo-ll-translation").value="";
imageURL="";
audioURL="";
alert("Word added");
};

/* SAVE SET */
document.querySelector(".zo-ll-save-set").onclick=function(){

const title=document.querySelector(".zo-ll-title").value.trim();
const language=document.querySelector(".zo-ll-language").value.trim();
const category=document.querySelector(".zo-ll-category").value.trim();

if(!title||!language||!category||!newItems.length) return;

const pass=prompt("Admin password:");
if(!pass) return;

sets.push({
title:title,
language:language,
category:category,
items:newItems
});

fetch(ajaxUrl,{
method:"POST",
body:new URLSearchParams({
action:"zo_ll_save_sets",
password:pass,
sets:JSON.stringify(sets),
nonce:nonce
})
})
.then(r=>r.json())
.then(d=>{
if(d.success){
alert("Saved");
newItems=[];
fetchSets();
}else alert(d.data);
});
};

fetchSets();
});
JS;

/* ================= RENDER ================= */

function zo_game_language_learner_render(){

$nonce=wp_create_nonce('zo_ll_nonce');

ob_start(); ?>

<div class="zo-game-root zo-ll-root" data-nonce="<?php echo esc_attr($nonce); ?>">

<h2>Language Learning Platform</h2>

<select class="zo-ll-set-select"></select>

<div class="zo-ll-card">
<img class="zo-ll-img" style="display:none">
<h3 class="zo-ll-word-show"></h3>
<p class="zo-ll-translation-show"></p>
<button class="zo-ll-btn zo-ll-audio-btn" style="display:none;">Play Audio</button>
</div>

<button class="zo-ll-btn zo-ll-prev">Prev</button>
<button class="zo-ll-btn zo-ll-next">Next</button>

<div class="zo-ll-edit-box">

<h3>Create New Set</h3>

<input class="zo-ll-input zo-ll-title" placeholder="Set Title">
<input class="zo-ll-input zo-ll-language" placeholder="Language">
<input class="zo-ll-input zo-ll-category" placeholder="Category">

<input class="zo-ll-input zo-ll-word" placeholder="Word">
<input class="zo-ll-input zo-ll-translation" placeholder="Translation">

<input type="file" class="zo-ll-input zo-ll-image-file">
<button class="zo-ll-btn zo-ll-upload-image">Upload Image</button>

<input type="file" class="zo-ll-input zo-ll-audio-file">
<button class="zo-ll-btn zo-ll-upload-audio">Upload Audio</button>

<button class="zo-ll-btn zo-ll-add-word">Add Word</button>
<button class="zo-ll-btn zo-ll-save-set">Save Set</button>

</div>

</div>

<?php return ob_get_clean(); }

return [
'slug'=>'language-learning-platform',
'name'=>'Language Learning Platform',
'author'=>'Asker',
'description'=>'Working language flashcard system.',
'render_callback'=>'zo_game_language_learner_render',
'inline_style'=>$css,
'inline_script'=>$js
];