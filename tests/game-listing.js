// Run: node tests/game-listing.js [--preview]. Uses only bundled PHP/Node runtimes.
const assert = require('assert').strict;
const fs = require('fs');
const path = require('path');
const vm = require('vm');
const {execFileSync} = require('child_process');
const repo = path.dirname(__dirname);
const fixture = JSON.parse(execFileSync('php', [path.join(__dirname, 'game-listing.php'), '--fixture'], {encoding:'utf8'}));
function matches(text, regex) {
	const found = [];
	let match;
	while ((match = regex.exec(text)) !== null) found.push(match);
	return found;
}
const scripts = html => matches(html, /<script\b[^>]*>([\s\S]*?)<\/script>/g).map(match => match[1]);
const gridScripts = scripts(fixture.grid);
const translationScripts = scripts(fixture.echo);
const translationScript = translationScripts[translationScripts.length - 1];
for (const script of [...gridScripts, translationScript, fixture.echo_script]) {
	new vm.Script(script);
}

let checks = 0;
function element(attributes) {
	const attrs = Object.assign({}, attributes);
	const classes = new Set();
	return {
		children:[], hidden:false, textContent:'', value:'', listeners:{},
		getAttribute:name=>attrs[name] || null,
		setAttribute(name, value) { attrs[name] = value; },
		hasAttribute:name=>Object.prototype.hasOwnProperty.call(attrs, name),
		removeAttribute(name) { delete attrs[name]; },
		addEventListener(name, handler) { (this.listeners[name] || (this.listeners[name] = [])).push(handler); },
		emit(name) { (this.listeners[name] || []).forEach(handler=>handler({preventDefault(){},stopPropagation(){}})); },
		appendChild(child) { this.children = this.children.filter(item=>item !== child); this.children.push(child); },
		querySelector:()=>null, querySelectorAll:()=>[], focus(){},
		classList:{contains:name=>classes.has(name),toggle(name, active){if(active)classes.add(name);else classes.delete(name);}}
	};
}
const cards = fixture.cards.map(element);
const grid = element();
grid.children = cards.slice();
grid.querySelectorAll = ()=>grid.children;
const nodes = {
	'#zo-game-search':element(), '#zo-game-category':element(), '#zo-game-sort':element(),
	'[data-zo-games-grid]':grid,
	'[data-zo-games-search-toggle]':element(), '[data-zo-games-search-panel]':element({hidden:''}),
	'[data-zo-games-search-close]':element(), '[data-zo-games-reset]':element(),
	'[data-zo-games-count]':element({'data-count-template':'%d oyun gösteriliyor'}),
	'[data-zo-games-live-empty]':element(),
	'[data-zo-favorites-section]':element(), '[data-zo-favorites-list]':element(),
	'[data-zo-recent-section]':element(), '[data-zo-recent-list]':element()
};
nodes['#zo-game-category'].value = 'all';
nodes['#zo-game-sort'].value = 'title';
const wrap = element();
wrap.querySelector = selector=>nodes[selector] || null;
wrap.querySelectorAll = selector=>selector === '[data-zo-games-reset]' ? [nodes[selector]] : [];
const recentWrites = [];
const filterContext = vm.createContext({
	document:{currentScript:{closest:()=>wrap},createElement:()=>element()},
	window:{setTimeout:callback=>callback()},
	localStorage:{getItem:()=>JSON.stringify([{slug:'roster-1000',url:'/old-roster-link/'},{slug:'binary-puzzle',url:'/oyunlar/binary-puzzle/'}]),setItem(key,value){ if (key === 'zoRecentlyPlayedGames') recentWrites.push(value); }}
});
for (const script of gridScripts.filter(script=>script.includes('function applyFilters') || script.includes('var recentKey='))) {
	vm.runInContext(script, filterContext);
}
const shown = ()=>grid.children.filter(card=>!card.hidden).map(card=>card.getAttribute('data-slug'));
const binaryCard = cards.find(card=>card.getAttribute('data-slug') === 'binary-puzzle');
for (const handler of binaryCard.listeners.click || []) {
	handler({target:{closest:selector=>selector.includes('data-zo-game-description-link') || selector === 'a' ? {} : null}});
}
assert.equal(recentWrites.length, 0, 'Reading a description does not record a game play.');
checks++;
for (const handler of binaryCard.listeners.click || []) {
	handler({target:{closest:selector=>selector === 'a' ? {} : null}});
}
assert.equal(recentWrites.length, 1, 'Opening the game still records a recent play.');
checks++;
for (const query of ['ikili','İKİLİ','IKILI','I\u0307kili']) {
	nodes['#zo-game-search'].value = query;
	nodes['#zo-game-search'].emit('input');
	assert.deepEqual(shown(), ['binary-puzzle']);
	assert.equal(nodes['[data-zo-games-count]'].textContent, '1 oyun gösteriliyor');
	checks++;
}
nodes['#zo-game-search'].value = '';
nodes['#zo-game-category'].value = 'sports';
nodes['#zo-game-category'].emit('change');
assert.deepEqual(shown(), ['soccer-match-ai']);
checks++;
nodes['#zo-game-search'].value = 'no matching game';
nodes['#zo-game-search'].emit('input');
assert.equal(shown().length, 0);
assert.equal(nodes['[data-zo-games-live-empty]'].hidden, false);
nodes['[data-zo-games-reset]'].emit('click');
assert.equal(shown().length, fixture.cards.length);
assert.equal(nodes['[data-zo-games-live-empty]'].hidden, true);
checks++;
for (const selector of ['[data-zo-favorites-list]','[data-zo-recent-list]']) {
	assert.equal(nodes[selector].children.length, 1, 'Unavailable game is excluded from saved shortcuts.');
	assert.equal(nodes[selector].children[0].href, '/oyunlar/binary-puzzle/');
	checks++;
}
// Exercise both emitted live filters, including composed/decomposed Turkish I.
for (const script of gridScripts.filter(script => script.includes('function applyFilters'))) {
	const source = script.match(/function normalize\(value\)\{[^}]+\}/)[0];
	const normalize = vm.runInNewContext('(' + source + ')');
	for (const input of ['ikili','İKİLİ','IKILI','I\u0307kili','ıkılı']) {
		assert.equal(normalize('İkili Bulmaca').includes(normalize(input)), true, input);
		checks++;
	}
	assert.equal(normalize('ÇIĞ ŞÖLENİ'), 'cig soleni');
	checks++;
}

// Run the real emitted translator and verify complete phrases survive rescans.
const root = {
	nodeType:1, nodeName:'DIV', closest:()=>null, hasAttribute:()=>false,
	matches:()=>false, querySelectorAll:()=>[]
};
const document = {
	getElementById:()=>root, title:'Yankı Haritacısı',
	createTreeWalker:()=>({nextNode:()=>null})
};
const context = vm.createContext({
	document, window:{addEventListener(){}}, NodeFilter:{SHOW_TEXT:4},
	MutationObserver:class { observe(){} }, setTimeout(){}
});
vm.runInContext(translationScript, context);
for (const [original, translated] of Object.entries(fixture.translations)) {
	let value = root.__zoTranslate(original);
	assert.equal(value, translated, original);
	for (let scan = 0; scan < 5; scan++) {
		value = root.__zoTranslate(value);
		assert.equal(value, translated, 'Repeated translation: ' + original);
	}
	checks++;
}
// Every game status message must have a complete Turkish translation.
for (const match of matches(fixture.echo_script, /setMessage\('([^']+)'/g)) {
	assert.ok(fixture.translations[match[1]], 'Missing dynamic message: ' + match[1]);
	checks++;
}
console.log(`PASS: generated JavaScript syntax and ${checks} search/translation checks`);

if (process.argv.includes('--preview')) {
	const output = path.join(repo, '.listing-preview.tmp');
	fs.mkdirSync(output, {recursive:true});
	const page = (title, css, body) => '<!doctype html><html lang="tr"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>' + title + '</title><style>body{margin:0;padding:24px;font-family:Arial,sans-serif;color:#1f2937}*{box-sizing:border-box}button,input,select{font:inherit}a{color:#1d4ed8}button{cursor:pointer}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #93c5fd;outline-offset:3px}' + css + '</style><body>' + body + '</body></html>';
	fs.writeFileSync(path.join(output, 'index.html'), page('Asker listing preview', fixture.css, fixture.grid));
	fs.writeFileSync(path.join(output, 'echo.html'), page('Yankı Haritacısı preview', fixture.echo_css, '<main class="zo-game-page">' + fixture.echo + '</main><script>' + fixture.echo_script + '</script>'));
	const covers = {
		'roster-1000':'roster-1000', 'binary-puzzle':'binary-puzzle',
		'soccer-match-ai':'soccer-vs-ai', 'echo-cartographer':'echo-cartographer',
		'time-loop-runner':'time-loop-runner', 'time-traveler-puzzle':'time-traveler-puzzle'
	};
	for (const [slug, folder] of Object.entries(covers)) {
		const source = path.join(repo, 'games', folder, 'featured-image.png');
		if (!fs.existsSync(source)) continue;
		const target = path.join(output, 'games', slug);
		fs.mkdirSync(target, {recursive:true});
		fs.copyFileSync(source, path.join(target, 'featured-image.png'));
	}
	for (const name of ['zeka-logo.png', 'zeka.com search.png']) {
		fs.copyFileSync(path.join(repo, name), path.join(output, name));
	}
	console.log('PREVIEW=' + output);
}
