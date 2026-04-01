<?php
if (!defined('ABSPATH')) exit;

/* ================= AJAX ================= */

add_action('wp_ajax_zo_ll_get_sets','zo_ll_get_sets');
add_action('wp_ajax_nopriv_zo_ll_get_sets','zo_ll_get_sets');

add_action('wp_ajax_zo_ll_save_set','zo_ll_save_set');
add_action('wp_ajax_nopriv_zo_ll_save_set','zo_ll_save_set');

add_action('wp_ajax_zo_ll_upload_file','zo_ll_upload_file');
add_action('wp_ajax_nopriv_zo_ll_upload_file','zo_ll_upload_file');

function zo_ll_get_sets(){
	wp_send_json_success(get_option('zo_ll_sets',[]));
}

function zo_ll_save_set(){

	check_ajax_referer('zo_ll_nonce','nonce');

	if($_POST['password']!=='asker1905123'){
		wp_send_json_error('Wrong password');
	}

	$sets=json_decode(stripslashes($_POST['sets']),true);
	update_option('zo_ll_sets',$sets);

	wp_send_json_success($sets);
}

function zo_ll_upload_file(){

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
.zo-ll-card{height:220px;background:#1e293b;border-radius:14px;display:flex;flex-direction:column;justify-content:center;align-items:center;cursor:pointer}
.zo-ll-img{max-height:100px;margin-bottom:8px;border-radius:8px}
.zo-ll-edit{background:#334155;padding:8px;border-radius:8px;margin-bottom:8px}
';

/* ================= JS ================= */

$js=<<<JS
document.addEventListener("DOMContentLoaded",function(){

const game=document.querySelector(".zo-ll-root");
const ajaxUrl=window.location.origin+"/wp-admin/admin-ajax.php";
const nonce=game.dataset.nonce;

let sets=[];
let currentSet=0;
let currentIndex=0;

function fetchSets(){
fetch(ajaxUrl+"?action=zo_ll_get_sets")
.then(r=>r.json())
.then(d=>{
if(d.success){
sets=d.data||[];
renderSetList();
}
});
}

function renderSetList(){
const select=document.querySelector(".zo-ll-set-select");
select.innerHTML="";
sets.forEach((s,i)=>{
select.innerHTML+=`<option value="\${i}">\${s.title}</option>`;
});
}

document.querySelector(".zo-ll-set-select").onchange=function(){
currentSet=this.value;
currentIndex=0;
showCard();
};

function showCard(){
if(!sets[currentSet])return;
const item=sets[currentSet].items[currentIndex];
document.querySelector(".zo-ll-word-show").textContent=item.word;
document.querySelector(".zo-ll-translation-show").textContent=item.translation;

const img=document.querySelector(".zo-ll-img");
if(item.image){
img.src=item.image;
img.style.display="block";
}else img.style.display="none";
}

document.querySelector(".zo-ll-next").onclick=function(){
if(currentIndex<sets[currentSet].items.length-1){currentIndex++;showCard();}
};

document.querySelector(".zo-ll-prev").onclick=function(){
if(currentIndex>0){currentIndex--;showCard();}
};

document.querySelector(".zo-ll-save-all").onclick=function(){

const pass=prompt("Admin password:");
if(!pass)return;

fetch(ajaxUrl,{
method:"POST",
body:new URLSearchParams({
action:"zo_ll_save_set",
password:pass,
sets:JSON.stringify(sets),
nonce:nonce
})
})
.then(r=>r.json())
.then(d=>{
alert(d.success?"Saved":"Error");
});
};

document.querySelectorAll(".zo-ll-upload").forEach(btn=>{
btn.onclick=function(){
const pass=prompt("Admin password:");
if(!pass)return;

const input=this.previousElementSibling;
const file=input.files[0];
if(!file)return;

const formData=new FormData();
formData.append("action","zo_ll_upload_file");
formData.append("file",file);
formData.append("password",pass);
formData.append("nonce",nonce);

fetch(ajaxUrl,{method:"POST",body:formData})
.then(r=>r.json())
.then(d=>{
if(d.success){
alert("Uploaded");
}else alert(d.data);
});
};
});

fetchSets();
});
JS;

/* ================= RENDER ================= */

function zo_game_language_learner_render($post_id=0,$module=[]){

$nonce=wp_create_nonce('zo_ll_nonce');

ob_start(); ?>

<div class="zo-game-root zo-ll-root" data-nonce="<?php echo esc_attr($nonce); ?>">

<h2>Language Platform</h2>

<select class="zo-ll-set-select"></select>

<div class="zo-ll-card">
<img class="zo-ll-img" style="display:none">
<h3 class="zo-ll-word-show"></h3>
<p class="zo-ll-translation-show"></p>
</div>

<button class="zo-ll-btn zo-ll-prev">Prev</button>
<button class="zo-ll-btn zo-ll-next">Next</button>

<hr>

<h3>Edit / Add Words</h3>

<input type="file" class="zo-ll-input">
<button class="zo-ll-btn zo-ll-upload">Upload File</button>

<button class="zo-ll-btn zo-ll-save-all">Save All</button>

</div>

<?php return ob_get_clean(); }

return [
'slug'=>'language-learning-platform',
'name'=>'Language Learning Platform',
'author'=>'Asker',
'description'=>'Editable language platform with custom uploads.',
'render_callback'=>'zo_game_language_learner_render',
'inline_style'=>$css,
'inline_script'=>$js
];