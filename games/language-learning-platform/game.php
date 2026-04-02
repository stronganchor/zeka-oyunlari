<?php
if (!defined('ABSPATH')) exit;

/* ===== AJAX ===== */

add_action('wp_ajax_zo_ll_get','zo_ll_get');
add_action('wp_ajax_nopriv_zo_ll_get','zo_ll_get');

add_action('wp_ajax_zo_ll_save','zo_ll_save');
add_action('wp_ajax_nopriv_zo_ll_save','zo_ll_save');

add_action('wp_ajax_zo_ll_upload','zo_ll_upload');
add_action('wp_ajax_nopriv_zo_ll_upload','zo_ll_upload');

function zo_ll_get(){
	wp_send_json_success(get_option('zo_ll_sets',[]));
}

function zo_ll_save(){

	check_ajax_referer('zo_ll_nonce','nonce');

	if($_POST['password'] !== 'asker1905123'){
		wp_send_json_error('Wrong password');
	}

	$data = json_decode(stripslashes($_POST['sets']), true);
	update_option('zo_ll_sets',$data);

	wp_send_json_success();
}

function zo_ll_upload(){

	check_ajax_referer('zo_ll_nonce','nonce');

	if($_POST['password'] !== 'asker1905123'){
		wp_send_json_error('Wrong password');
	}

	if(empty($_FILES['file'])){
		wp_send_json_error('No file');
	}

	require_once ABSPATH.'wp-admin/includes/file.php';
	$upload = wp_handle_upload($_FILES['file'],['test_form'=>false]);

	if(isset($upload['error'])){
		wp_send_json_error($upload['error']);
	}

	wp_send_json_success($upload['url']);
}

/* ===== CSS ===== */

$css='
.ll{background:#0f172a;color:#fff;padding:20px;border-radius:16px;max-width:900px;margin:auto}
.ll input{width:100%;margin:4px 0;padding:6px;border-radius:6px;border:none}
.ll button{margin:4px 4px 4px 0;padding:6px 10px;border:none;border-radius:20px;background:#38bdf8;color:#000;font-weight:bold;cursor:pointer}
.card-wrap{perspective:1000px;margin:20px 0}
.card{height:240px;position:relative;transform-style:preserve-3d;transition:.6s}
.card.flip{transform:rotateY(180deg)}
.face{position:absolute;width:100%;height:100%;backface-visibility:hidden;border-radius:14px;background:#1e293b;display:flex;flex-direction:column;justify-content:center;align-items:center}
.back{transform:rotateY(180deg);background:#334155}
img{max-height:120px;margin-bottom:10px}
.edit{background:#1e293b;padding:8px;border-radius:8px;margin:6px 0}
';

/* ===== JS ===== */

$js=<<<JS
document.addEventListener("DOMContentLoaded",function(){

const root=document.querySelector(".ll");
const ajax=window.location.origin+"/wp-admin/admin-ajax.php";
const nonce=root.dataset.nonce;

let sets=[];
let currentSet=null;
let currentIndex=0;

/* LOAD */
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
const sel=root.querySelector(".set");
sel.innerHTML='<option value="">Select</option>';
sets.forEach((s,i)=>{
sel.innerHTML+=`<option value="\${i}">\${s.name}</option>`;
});
}

root.querySelector(".set").onchange=function(){
if(this.value==="")return;
currentSet=parseInt(this.value);
currentIndex=0;
renderEdit();
show();
};

/* SHOW CARD */
function show(){
if(currentSet===null)return;
const item=sets[currentSet].items[currentIndex];
root.querySelector(".front-word").textContent=item.word;
root.querySelector(".back-trans").textContent=item.translation;

const img=root.querySelector(".img");
if(item.image){ img.src=item.image; img.style.display="block"; }
else img.style.display="none";

const btn=root.querySelector(".audio");
if(item.audio){
btn.style.display="inline-block";
btn.onclick=()=>new Audio(item.audio).play();
}else btn.style.display="none";

root.querySelector(".card").classList.remove("flip");
}

root.querySelector(".prev").onclick=()=>{ if(currentIndex>0){currentIndex--;show();} };
root.querySelector(".next").onclick=()=>{ if(currentSet!==null && currentIndex<sets[currentSet].items.length-1){currentIndex++;show();} };
root.querySelector(".card").onclick=()=>root.querySelector(".card").classList.toggle("flip");

/* EDIT */
function renderEdit(){
const box=root.querySelector(".edit-list");
box.innerHTML="";
if(currentSet===null)return;

sets[currentSet].items.forEach((item,i)=>{
box.innerHTML+=`
<div class="edit">
<input data-i="\${i}" class="w" value="\${item.word}">
<input data-i="\${i}" class="t" value="\${item.translation}">
<input type="file" data-i="\${i}" class="imgf">
<input type="file" data-i="\${i}" class="audf">
<button data-i="\${i}" class="del">Delete</button>
</div>`;
});

attachEdit();
}

function attachEdit(){

root.querySelectorAll(".w").forEach(inp=>{
inp.oninput=function(){
sets[currentSet].items[this.dataset.i].word=this.value;
};
});

root.querySelectorAll(".t").forEach(inp=>{
inp.oninput=function(){
sets[currentSet].items[this.dataset.i].translation=this.value;
};
});

root.querySelectorAll(".del").forEach(btn=>{
btn.onclick=function(){
sets[currentSet].items.splice(this.dataset.i,1);
renderEdit();
show();
};
});

root.querySelectorAll(".imgf").forEach(inp=>{
inp.onchange=function(){
upload(this.files[0],url=>{
sets[currentSet].items[this.dataset.i].image=url;
});
};
});

root.querySelectorAll(".audf").forEach(inp=>{
inp.onchange=function(){
upload(this.files[0],url=>{
sets[currentSet].items[this.dataset.i].audio=url;
});
};
});
}

/* ADD WORD */
root.querySelector(".add").onclick=function(){
if(currentSet===null)return;
sets[currentSet].items.push({word:"New",translation:"",image:"",audio:""});
renderEdit();
};

/* UPLOAD */
function upload(file,cb){
if(!file)return;
const pass=prompt("Admin password:");
if(!pass)return;

const fd=new FormData();
fd.append("action","zo_ll_upload");
fd.append("file",file);
fd.append("password",pass);
fd.append("nonce",nonce);

fetch(ajax,{method:"POST",body:fd})
.then(r=>r.json())
.then(d=>{
if(d.success)cb(d.data);
else alert(d.data);
});
}

/* SAVE */
root.querySelector(".save").onclick=function(){
const pass=prompt("Admin password:");
if(!pass)return;

fetch(ajax,{
method:"POST",
body:new URLSearchParams({
action:"zo_ll_save",
password:pass,
sets:JSON.stringify(sets),
nonce:nonce
})
})
.then(r=>r.json())
.then(d=>{
if(d.success)alert("Saved");
else alert(d.data);
});
};

load();
});
JS;

/* ===== RENDER ===== */

function zo_game_language_learner_render(){

$nonce=wp_create_nonce('zo_ll_nonce');

ob_start(); ?>

<div class="ll" data-nonce="<?php echo esc_attr($nonce); ?>">

<select class="set"></select>

<div class="card-wrap">
<div class="card">
<div class="face">
<h2 class="front-word"></h2>
<button class="audio" style="display:none">Play Audio</button>
</div>
<div class="face back">
<img class="img" style="display:none">
<h3 class="back-trans"></h3>
</div>
</div>
</div>

<button class="prev">Prev</button>
<button class="next">Next</button>

<hr>

<h3>Edit Words</h3>
<div class="edit-list"></div>

<button class="add">Add Word</button>
<button class="save">Save</button>

</div>

<?php return ob_get_clean(); }

return [
'slug'=>'language-learning-platform',
'name'=>'Language Learning Platform',
'author'=>'Asker',
'description'=>'Stable flashcard system.',
'render_callback'=>'zo_game_language_learner_render',
'inline_style'=>$css,
'inline_script'=>$js
];