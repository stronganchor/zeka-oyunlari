<?php
if (!defined('ABSPATH')) exit;

$css = <<<CSS
.zo-wrap{max-width:1100px;margin:0 auto;font-family:Arial;color:#fff}
.zo-box{background:#0f172a;border-radius:16px;padding:16px}
.zo-row{display:flex;gap:10px;margin-bottom:10px;flex-wrap:wrap}
.zo-input,.zo-select{padding:10px;border-radius:10px;border:1px solid #333;background:#111;color:#fff;width:100%}
.zo-btn{padding:10px;border-radius:10px;border:0;cursor:pointer;font-weight:bold}
.zo-btn-blue{background:#2563eb}
.zo-btn-green{background:#10b981}
.zo-btn-pink{background:#ec4899}
canvas,img{max-width:100%;border-radius:12px}
CSS;

$js = <<<JS
document.addEventListener('DOMContentLoaded', function(){

const root = document.querySelector('.zo-wrap');
const prompt = root.querySelector('.prompt');
const provider = root.querySelector('.provider');
const apiUrl = root.querySelector('.api-url');
const apiKey = root.querySelector('.api-key');
const renderBtn = root.querySelector('.render');
const canvas = root.querySelector('canvas');
const ctx = canvas.getContext('2d');
const img = root.querySelector('.api-img');

let coins = 100;

// ---------- TRANSLATION ----------
function trToEn(text){
 return text
 .replace(/mavi/g,'blue')
 .replace(/kırmızı/g,'red')
 .replace(/yeşil/g,'green')
 .replace(/gerçekçi/g,'realistic')
 .replace(/göz/g,'eyes');
}

// ---------- KID SAFE ----------
function safe(text){
 return !/blood|sex|nude|kill|silah|seks|kan/i.test(text);
}

// ---------- LOCAL RENDER ----------
function localRender(text){
 ctx.fillStyle="#111";ctx.fillRect(0,0,512,512);
 ctx.fillStyle="#3b82f6";
 ctx.fillRect(100,100,300,300);
 ctx.fillStyle="#fff";
 ctx.fillText(text,50,480);
}

// ---------- API RENDER ----------
async function apiRender(text){
 let res,src="";

 if(provider.value==="gemini"){
   res=await fetch(apiUrl.value+"?key="+apiKey.value,{
     method:"POST",
     headers:{"Content-Type":"application/json"},
     body:JSON.stringify({prompt:text})
   });
   let j=await res.json();
   src="data:image/png;base64,"+j.images[0].data;
 }

 else if(provider.value==="huggingface"){
   res=await fetch(apiUrl.value,{
     method:"POST",
     headers:{Authorization:"Bearer "+apiKey.value},
     body:JSON.stringify({inputs:text})
   });
   src=URL.createObjectURL(await res.blob());
 }

 else if(provider.value==="fal"){
   res=await fetch(apiUrl.value,{
     method:"POST",
     headers:{Authorization:"Key "+apiKey.value},
     body:JSON.stringify({prompt:text})
   });
   let j=await res.json();
   src=j.images[0].url;
 }

 else{
   res=await fetch(apiUrl.value,{
     method:"POST",
     headers:{Authorization:"Bearer "+apiKey.value},
     body:JSON.stringify({prompt:text})
   });
   let j=await res.json();
   src=j.data?.[0]?.url || "";
 }

 if(src){
   img.src=src;
   img.style.display="block";
   canvas.style.display="none";
 }
}

// ---------- RENDER BUTTON ----------
renderBtn.onclick=async()=>{
 let text=prompt.value.trim();
 if(!text) return;

 if(!safe(text)){
   alert("Blocked by kid-safe mode");
   return;
 }

 text=trToEn(text);

 if(coins<10){
   alert("No coins");
   return;
 }

 coins-=10;

 if(provider.value==="local"){
   localRender(text);
   canvas.style.display="block";
   img.style.display="none";
 }else{
   await apiRender(text);
 }
};

// ---------- SAVE ----------
root.querySelector('.save').onclick=()=>{
 let link=document.createElement('a');
 link.download="image.png";
 link.href=canvas.toDataURL();
 link.click();
};

});
JS;

if (!function_exists('zo_render')) {
function zo_render() {
ob_start(); ?>
<div class="zo-wrap">
<div class="zo-box">

<div class="zo-row">
<textarea class="zo-input prompt" placeholder="Prompt"></textarea>
</div>

<div class="zo-row">
<select class="zo-select provider">
<option value="local">Local</option>
<option value="gemini">Gemini</option>
<option value="huggingface">HuggingFace</option>
<option value="fal">fal.ai</option>
<option value="custom">Custom</option>
</select>
</div>

<div class="zo-row">
<input class="zo-input api-url" placeholder="API URL">
<input class="zo-input api-key" placeholder="API KEY">
</div>

<div class="zo-row">
<button class="zo-btn zo-btn-blue render">Render</button>
<button class="zo-btn zo-btn-green save">Save PNG</button>
</div>

<canvas width="512" height="512"></canvas>
<img class="api-img" style="display:none"/>

</div>
</div>
<?php
return ob_get_clean();
}}

return [
 'slug'=>'ai-studio-pro',
 'name'=>'AI Studio Pro',
 'render_callback'=>'zo_render',
 'inline_style'=>$css,
 'inline_script'=>$js
];