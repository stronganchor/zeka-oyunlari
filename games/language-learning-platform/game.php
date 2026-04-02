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

$css='
.zo-ll-root{max-width:900px;margin:0 auto;padding:20px;background:#0f172a;color:#fff;border-radius:18px}
.zo-ll-input{width:100%;padding:6px;margin-bottom:6px;border-radius:8px;border:none}
.zo-ll-btn{padding:6px 12px;border-radius:999px;border:none;background:#38bdf8;color:#000;font-weight:bold;margin:4px 4px 4px 0;cursor:pointer}
.zo-ll-select{width:100%;padding:6px;margin-bottom:10px;border-radius:8px}
.zo-ll-edit-item{background:#1e293b;padding:8px;border-radius:10px;margin-bottom:8px}
.zo-ll-card-wrap{perspective:1000px;margin:20px 0}
.zo-ll-card{width:100%;height:260px;position:relative;transform-style:preserve-3d;transition:transform .6s}
.zo-ll-card.flipped{transform:rotateY(180deg)}
.zo-ll-face{position:absolute;width:100%;height:100%;backface-visibility:hidden;border-radius:16px;display:flex;flex-direction:column;justify-content:center;align-items:center;background:#1e293b;padding:10px}
.zo-ll-back{transform:rotateY(180deg);background:#334155}
.zo-ll-img{max-height:120px;margin-bottom:10px;border-radius:10px}
.small-preview{max-height:60px;margin-top:4px;border-radius:6px}
';

/* ================= JS ================= */

$js=<<<JS
document.addEventListener("DOMContentLoaded",function(){

const game=document.querySelector(".zo-ll-root");
const ajaxUrl=window.location.origin+"/wp-admin/admin-ajax.php";
const nonce=game.dataset.nonce;

let sets=[];
let currentSetIndex=null;
let currentIndex=0;

/* ================= LOAD ================= */

function fetchSets(){
fetch(ajaxUrl+"?action=zo_ll_get_sets")
.then(r=>r.json())
.then(d=>{
if(d.success){
sets=d.data||[];
renderSelect();
}
});
}

function renderSelect(){
const select=document.querySelector(".zo-ll-set-select");
select.innerHTML='<option value="">Select Set</option>';
sets.forEach((s,i)=>{
select.innerHTML+=`<option value="\${i}">\${s.language} - \${s.category}</option>`;
});
}

/* ================= SELECT ================= */

document.querySelector(".zo-ll-set-select").onchange=function(){
if(this.value==="") return;
currentSetIndex=parseInt(this.value);
currentIndex=0;
renderEditList();
showCard();
};

/* ================= SHOW CARD ================= */

function showCard(){
if(currentSetIndex===null) return;
const items=sets[currentSetIndex].items;
if(!items.length) return;

const item=items[currentIndex];

document.querySelector(".zo-ll-front-word").textContent=item.word;
document.querySelector(".zo-ll-back-translation").textContent=item.translation;

const img=document.querySelector(".zo-ll-img");
if(item.image){ img.src=item.image; img.style.display="block"; }
else img.style.display="none";

const audioBtn=document.querySelector(".zo-ll-audio-btn");
if(item.audio){
audioBtn.style.display="inline-block";
audioBtn.onclick=function(){ new Audio(item.audio).play(); };
}else audioBtn.style.display="none";

document.querySelector(".zo-ll-card").classList.remove("flipped");
}

/* ================= NAVIGATION ================= */

document.querySelector(".zo-ll-prev").onclick=function(){
if(currentIndex>0){currentIndex--;showCard();}
};

document.querySelector(".zo-ll-next").onclick=function(){
if(currentSetIndex===null)return;
if(currentIndex < sets[currentSetIndex].items.length-1){
currentIndex++;
showCard();
}
};

document.querySelector(".zo-ll-card").onclick=function(){
this.classList.toggle("flipped");
};

/* ================= EDIT LIST ================= */

function renderEditList(){

const container=document.querySelector(".zo-ll-edit-list");
container.innerHTML="";
if(currentSetIndex===null) return;

sets[currentSetIndex].items.forEach((item,i)=>{

container.innerHTML+=`
<div class="zo-ll-edit-item">
<input class="zo-ll-input edit-word" data-i="\${i}" value="\${item.word}">
<input class="zo-ll-input edit-translation" data-i="\${i}" value="\${item.translation}">

<label>Image:</label>
<input type="file" class="edit-image-file" data-i="\${i}">
<img src="\${item.image||''}" class="small-preview">

<label>Audio:</label>
<input type="file" class="edit-audio-file" data-i="\${i}">

<button class="zo-ll-btn edit-delete" data-i="\${i}">Delete</button>
</div>`;
});

attachEditHandlers();
}

function attachEditHandlers(){

document.querySelectorAll(".edit-word").forEach(inp=>{
inp.oninput=function(){
sets[currentSetIndex].items[this.dataset.i].word=this.value;
};
});

document.querySelectorAll(".edit-translation").forEach(inp=>{
inp.oninput=function(){
sets[currentSetIndex].items[this.dataset.i].translation=this.value;
};
});

document.querySelectorAll(".edit-delete").forEach(btn=>{
btn.onclick=function(){
sets[currentSetIndex].items.splice(this.dataset.i,1);
renderEditList();
showCard();
};
});

document.querySelectorAll(".edit-image-file").forEach(inp=>{
inp.onchange=function(){
uploadFile(this.files[0],url=>{
sets[currentSetIndex].items[this.dataset.i].image=url;
renderEditList();
});
};
});

document.querySelectorAll(".edit-audio-file").forEach(inp=>{
inp.onchange=function(){
uploadFile(this.files[0],url=>{
sets[currentSetIndex].items[this.dataset.i].audio=url;
});
};
});
}

/* ================= ADD NEW WORD TO EXISTING ================= */

document.querySelector(".zo-ll-add-new-word").onclick=function(){

if(currentSetIndex===null) return;

const word=prompt("Word:");
const trans=prompt("Translation:");

if(!word||!trans) return;

sets[currentSetIndex].items.push({
word:word,
translation:trans,
image:"",
audio:""
});

renderEditList();
};

/* ================= UPLOAD ================= */

function uploadFile(file,callback){

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
if(d.success) callback(d.data);
else alert(d.data);
});
}

/* ================= SAVE ================= */

document.querySelector(".zo-ll-save-all").onclick=function(){

const pass=prompt("Admin password:");
if(!pass) return;

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
if(d.success) alert("Saved");
else alert(d.data);
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

<h2>Language Flashcards</h2>

<select class="zo-ll-select zo-ll-set-select"></select>

<div class="zo-ll-card-wrap">
<div class="zo-ll-card">

<div class="zo-ll-face">
<h2 class="zo-ll-front-word"></h2>
<button class="zo-ll-btn zo-ll-audio-btn" style="display:none;">Play Audio</button>
</div>

<div class="zo-ll-face zo-ll-back">
<img class="zo-ll-img" style="display:none">
<h3 class="zo-ll-back-translation"></h3>
</div>

</div>
</div>

<button class="zo-ll-btn zo-ll-prev">Prev</button>
<button class="zo-ll-btn zo-ll-next">Next</button>

<hr>

<h3>Edit Words</h3>
<div class="zo-ll-edit-list"></div>

<button class="zo-ll-btn zo-ll-add-new-word">Add New Word</button>
<button class="zo-ll-btn zo-ll-save-all">Save Changes</button>

</div>

<?php return ob_get_clean(); }

return [
'slug'=>'language-learning-platform',
'name'=>'Language Learning Platform',
'author'=>'Asker',
'description'=>'Advanced editable flashcard system.',
'render_callback'=>'zo_game_language_learner_render',
'inline_style'=>$css,
'inline_script'=>$js
];