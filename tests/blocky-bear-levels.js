const assert = require('assert');
const fs = require('fs');
const path = require('path');
const vm = require('vm');

const source = fs.readFileSync(path.join(__dirname, '..', 'games', 'blocky-bear-adventure', 'script.js'), 'utf8');
const begin = source.indexOf('function buildLevel(number) {');
const end = source.indexOf('function freshGame()', begin);
assert.ok(begin >= 0 && end > begin, 'level generator exists');
const buildLevel = vm.runInNewContext(`(() => { const GROUND = 520; ${source.slice(begin, end)} return buildLevel; })()`);

let previous;
const layouts = new Set();
for (let number = 1; number <= 1000; number++) {
	const level = buildLevel(number);
	const ground = level.platforms.filter((platform) => platform[1] === 520);
	assert.equal(ground.length, 4, `level ${number} has four landing sections`);
	assert.equal(level.coins.length, 23, `level ${number} has all coins`);
	assert.equal(level.enemies.length, 4 + Math.floor((number - 1) / 125));
	assert.equal(level.flagX, level.width - 90);
	for (let i = 0; i < 3; i++) {
		const gap = ground[i + 1][0] - ground[i][0] - ground[i][2];
		assert.ok(Math.abs(gap - level.gaps[i]) < 1e-8);
		assert.ok(gap < 200, `level ${number} gap ${i + 1} remains jumpable`);
		if (previous) assert.ok(gap > previous.gaps[i], `level ${number} gap ${i + 1} grows`);
	}
	for (const enemy of level.enemies) {
		assert.ok(enemy[0] >= enemy[1] && enemy[0] <= enemy[2], `level ${number} enemy starts on patrol`);
		if (previous) assert.ok(Math.abs(enemy[3]) > Math.abs(previous.enemies[0][3]), `level ${number} enemies speed up`);
	}
	const fingerprint = JSON.stringify([level.gaps, level.enemies.map((enemy) => enemy[3])]);
	assert.ok(!layouts.has(fingerprint), `level ${number} is distinct`);
	layouts.add(fingerprint);
	previous = level;
}
console.log('PASS: 1,000 distinct Blocky Bear levels grow harder and remain jumpable');

function element() {
	return {
		dataset: {}, listeners: {}, textContent: '', value: '',
		addEventListener(name, callback) { this.listeners[name] = callback; },
		setAttribute() {}, focus() {}
	};
}
const nodes = {};
for (const selector of ['canvas', '.zo-bear-overlay', '.zo-bear-overlay-title', '.zo-bear-overlay-detail',
	'.zo-bear-status', '.zo-bear-start', '.zo-bear-pause', '.zo-bear-hearts', '.zo-bear-coins',
	'.zo-bear-level', '.zo-bear-unlocked', '.zo-bear-level-input', '.zo-bear-level-go']) {
	nodes[selector] = element();
}
nodes.canvas.getContext = () => ({fillRect() {}, strokeRect() {}, beginPath() {}, ellipse() {}, fill() {}, stroke() {}});
const root = element();
root.dataset.labels = JSON.stringify({again: 'Again', next: 'Next', won: 'Won', coins: 'Coins',
	level: 'Level', instructions: 'Play', levelLocked: 'Locked', pause: 'Pause'});
root.querySelector = (selector) => nodes[selector];
root.querySelectorAll = () => [];
const saved = new Map([['zo-blocky-bear-adventure-unlocked', '7']]);
const window = {localStorage: {getItem: (key) => saved.get(key), setItem: (key, value) => saved.set(key, value)}, addEventListener() {}};
const document = {readyState: 'complete', querySelectorAll: () => [root], addEventListener() {}};
const instrumented = source.replace('let game = freshGame();',
	'let game = freshGame(); window.__bearTest = {finish, getLevel: () => level, getUnlocked: () => unlocked};');
assert.notEqual(instrumented, source, 'gameplay hooks can be checked');
vm.runInNewContext(instrumented, {window, document, performance: {now: () => 0},
	requestAnimationFrame: () => 1, cancelAnimationFrame() {}});
assert.equal(window.__bearTest.getLevel(), 7, 'saved level resumes');
assert.equal(nodes['.zo-bear-level-input'].value, '7');
nodes['.zo-bear-start'].listeners.click();
window.__bearTest.finish('won');
assert.equal(window.__bearTest.getUnlocked(), 8, 'win unlocks exactly the next level');
assert.equal(saved.get('zo-blocky-bear-adventure-unlocked'), '8', 'progress is saved');
assert.equal(nodes['.zo-bear-start'].textContent, 'Next');
nodes['.zo-bear-start'].listeners.click();
assert.equal(window.__bearTest.getLevel(), 8, 'next button starts the next level');
nodes['.zo-bear-level-input'].value = '1000';
nodes['.zo-bear-level-go'].listeners.click();
assert.equal(window.__bearTest.getLevel(), 8, 'locked levels cannot be selected');
nodes['.zo-bear-level-input'].value = '2';
nodes['.zo-bear-level-go'].listeners.click();
assert.equal(window.__bearTest.getLevel(), 2, 'unlocked levels can be replayed');
console.log('PASS: saved progress, next level, and level picker');
