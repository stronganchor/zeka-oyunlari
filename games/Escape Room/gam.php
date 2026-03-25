<?php
if (!defined('ABSPATH')) {
	exit;
}

return array(
	'slug' => 'escape-room',
	'name' => 'Escape Room',
	'author' => 'Arslan',
	'description' => 'Find clues, unlock the box, get the key, and escape the room.',

	'inline_style' => '
		.zo-escape-room-wrap{
			max-width:1000px;
			margin:0 auto;
			padding:20px;
			font-family:Arial,sans-serif;
			color:#222;
		}
		.zo-escape-room-title{
			text-align:center;
			margin-bottom:10px;
			font-size:32px;
			font-weight:700;
		}
		.zo-escape-room-sub{
			text-align:center;
			margin-bottom:20px;
			font-size:16px;
			color:#555;
		}
		.zo-escape-room-topbar{
			display:flex;
			flex-wrap:wrap;
			gap:12px;
			justify-content:center;
			align-items:center;
			margin-bottom:18px;
		}
		.zo-escape-room-stat{
			background:#f3f4f6;
			border:2px solid #d1d5db;
			border-radius:12px;
			padding:10px 14px;
			font-weight:700;
		}
		.zo-escape-room-room{
			display:grid;
			grid-template-columns:repeat(3,1fr);
			gap:14px;
			margin-bottom:18px;
		}
		.zo-escape-room-item{
			background:#fff;
			border:3px solid #d1d5db;
			border-radius:16px;
			padding:18px;
			min-height:140px;
			cursor:pointer;
			transition:transform .15s ease,border-color .15s ease,box-shadow .15s ease;
			box-shadow:0 6px 14px rgba(0,0,0,.06);
			display:flex;
			flex-direction:column;
			justify-content:center;
			align-items:center;
			text-align:center;
			user-select:none;
		}
		.zo-escape-room-item:hover{
			transform:translateY(-2px);
			border-color:#60a5fa;
			box-shadow:0 10px 18px rgba(0,0,0,.1);
		}
		.zo-escape-room-item.locked{
			background:#f9fafb;
		}
		.zo-escape-room-item.done{
			border-color:#22c55e;
			background:#f0fdf4;
		}
		.zo-escape-room-icon{
			font-size:42px;
			line-height:1;
			margin-bottom:10px;
		}
		.zo-escape-room-label{
			font-size:18px;
			font-weight:700;
			margin-bottom:6px;
		}
		.zo-escape-room-small{
			font-size:13px;
			color:#666;
		}
		.zo-escape-room-panel{
			background:#ffffff;
			border:3px solid #d1d5db;
			border-radius:16px;
			padding:18px;
			box-shadow:0 6px 14px rgba(0,0,0,.06);
		}
		.zo-escape-room-panel h3{
			margin:0 0 12px;
			font-size:22px;
		}
		.zo-escape-room-message{
			min-height:72px;
			background:#f9fafb;
			border:2px solid #e5e7eb;
			border-radius:12px;
			padding:12px;
			line-height:1.5;
			margin-bottom:14px;
		}
		.zo-escape-room-actions{
			display:flex;
			flex-wrap:wrap;
			gap:10px;
			margin-bottom:14px;
		}
		.zo-escape-room-btn{
			border:0;
			border-radius:12px;
			padding:12px 16px;
			font-size:15px;
			font-weight:700;
			cursor:pointer;
			background:#2563eb;
			color:#fff;
		}
		.zo-escape-room-btn:hover{
			filter:brightness(.96);
		}
		.zo-escape-room-btn.alt{
			background:#6b7280;
		}
		.zo-escape-room-btn.good{
			background:#16a34a;
		}
		.zo-escape-room-inputrow{
			display:flex;
			flex-wrap:wrap;
			gap:10px;
			align-items:center;
			margin-bottom:14px;
		}
		.zo-escape-room-input{
			padding:12px 14px;
			border:2px solid #cbd5e1;
			border-radius:12px;
			font-size:16px;
			min-width:180px;
			max-width:240px;
		}
		.zo-escape-room-inventory{
			display:flex;
			flex-wrap:wrap;
			gap:10px;
			margin-top:8px;
		}
		.zo-escape-room-badge{
			background:#fef3c7;
			border:2px solid #f59e0b;
			border-radius:999px;
			padding:8px 12px;
			font-size:14px;
			font-weight:700;
		}
		.zo-escape-room-win{
			display:none;
			margin-top:16px;
			padding:16px;
			border-radius:16px;
			background:#ecfdf5;
			border:3px solid #22c55e;
			font-size:18px;
			font-weight:700;
			text-align:center;
		}
		@media (max-width:700px){
			.zo-escape-room-room{
				grid-template-columns:1fr 1fr;
			}
		}
		@media (max-width:520px){
			.zo-escape-room-room{
				grid-template-columns:1fr;
			}
		}
	',

	'inline_script' => '
		(function(){
			function initEscapeRoom(root){
				if (!root || root.dataset.zoEscapeInit === "1") {
					return;
				}
				root.dataset.zoEscapeInit = "1";

				var movesEl = root.querySelector(".zoEscapeMoves");
				var cluesEl = root.querySelector(".zoEscapeClues");
				var doorStatusEl = root.querySelector(".zoEscapeDoorStatus");
				var msgEl = root.querySelector(".zoEscapeMessage");
				var inventoryEl = root.querySelector(".zoEscapeInventory");
				var codeInput = root.querySelector(".zoEscapeCodeInput");
				var tryCodeBtn = root.querySelector(".zoEscapeTryCodeBtn");
				var openDoorBtn = root.querySelector(".zoEscapeOpenDoorBtn");
				var hintBtn = root.querySelector(".zoEscapeHintBtn");
				var resetBtn = root.querySelector(".zoEscapeResetBtn");
				var winEl = root.querySelector(".zoEscapeWin");
				var itemEls = root.querySelectorAll(".zo-escape-room-item");

				var state;

				function resetGame(){
					state = {
						moves: 0,
						cluesFound: 0,
						inventory: [],
						seen: {
							desk: false,
							painting: false,
							bookshelf: false,
							plant: false,
							box: false,
							door: false
						},
						boxUnlocked: false,
						doorUnlocked: false,
						gameWon: false,
						code: "4286"
					};

					if (codeInput) {
						codeInput.value = "";
					}
					if (winEl) {
						winEl.style.display = "none";
					}

					itemEls.forEach(function(el){
						el.classList.remove("done");
						if (el.getAttribute("data-item") === "box" || el.getAttribute("data-item") === "door") {
							el.classList.add("locked");
						}
					});

					updateUI();
					setMessage("Click around the room to search for clues.");
				}

				function updateUI(){
					if (movesEl) {
						movesEl.textContent = state.moves;
					}
					if (cluesEl) {
						cluesEl.textContent = state.cluesFound;
					}
					if (doorStatusEl) {
						doorStatusEl.textContent = state.doorUnlocked ? "Unlocked" : "Locked";
					}

					if (inventoryEl) {
						inventoryEl.innerHTML = "";
						if (!state.inventory.length) {
							inventoryEl.innerHTML = "<div class=\"zo-escape-room-small\">No items yet.</div>";
						} else {
							state.inventory.forEach(function(item){
								var badge = document.createElement("div");
								badge.className = "zo-escape-room-badge";
								badge.textContent = item;
								inventoryEl.appendChild(badge);
							});
						}
					}

					var boxEl = root.querySelector("[data-item=\"box\"]");
					var doorEl = root.querySelector("[data-item=\"door\"]");

					if (boxEl) {
						if (state.boxUnlocked) {
							boxEl.classList.remove("locked");
							boxEl.classList.add("done");
						} else {
							boxEl.classList.add("locked");
							boxEl.classList.remove("done");
						}
					}

					if (doorEl) {
						if (state.doorUnlocked) {
							doorEl.classList.remove("locked");
							doorEl.classList.add("done");
						} else {
							doorEl.classList.add("locked");
							doorEl.classList.remove("done");
						}
					}
				}

				function setMessage(text){
					if (msgEl) {
						msgEl.textContent = text;
					}
				}

				function addMove(){
					state.moves++;
					updateUI();
				}

				function addInventory(item){
					if (state.inventory.indexOf(item) === -1) {
						state.inventory.push(item);
					}
					updateUI();
				}

				function markDone(itemName){
					var el = root.querySelector("[data-item=\"" + itemName + "\"]");
					if (el) {
						el.classList.add("done");
					}
				}

				function findClue(itemName, clueText, inventoryItem){
					if (!state.seen[itemName]) {
						state.seen[itemName] = true;
						state.cluesFound++;
						addInventory(inventoryItem);
						markDone(itemName);
						updateUI();
						setMessage(clueText);
					} else {
						setMessage("You already checked the " + itemName + ".");
					}
				}

				function handleItemClick(itemName){
					if (state.gameWon) {
						return;
					}

					addMove();

					if (itemName === "desk") {
						findClue("desk", "Inside the desk drawer you find a note: The first digit is 4.", "Desk Note: 4");
						return;
					}

					if (itemName === "painting") {
						findClue("painting", "Behind the painting is a scratch on the wall: The second digit is 2.", "Painting Clue: 2");
						return;
					}

					if (itemName === "bookshelf") {
						findClue("bookshelf", "A hidden paper slips from a book: The third digit is 8.", "Book Clue: 8");
						return;
					}

					if (itemName === "plant") {
						findClue("plant", "Under the plant pot is a tiny tag: The fourth digit is 6.", "Plant Clue: 6");
						return;
					}

					if (itemName === "box") {
						if (!state.boxUnlocked) {
							setMessage("The locked box needs a 4-digit code.");
						} else {
							if (!state.seen.box) {
								state.seen.box = true;
								addInventory("Door Key");
								setMessage("Inside the box you find the Door Key.");
							} else {
								setMessage("The box is open. You already took the Door Key.");
							}
						}
						return;
					}

					if (itemName === "door") {
						if (!state.doorUnlocked) {
							setMessage("The door is still locked.");
						} else if (!state.gameWon) {
							state.gameWon = true;
							if (winEl) {
								winEl.style.display = "block";
							}
							setMessage("You use the key and open the door. You escaped.");
							markDone("door");
						}
					}
				}

				itemEls.forEach(function(el){
					el.addEventListener("click", function(){
						handleItemClick(el.getAttribute("data-item"));
					});
				});

				if (tryCodeBtn) {
					tryCodeBtn.addEventListener("click", function(){
						if (state.gameWon) {
							return;
						}

						addMove();

						var value = codeInput ? (codeInput.value || "").trim() : "";
						if (value.length !== 4) {
							setMessage("Enter a 4-digit code.");
							return;
						}

						if (value === state.code) {
							if (!state.boxUnlocked) {
								state.boxUnlocked = true;
								updateUI();
								setMessage("Correct code. The locked box opens.");
							} else {
								setMessage("The box is already unlocked.");
							}
						} else {
							setMessage("Wrong code.");
						}
					});
				}

				if (openDoorBtn) {
					openDoorBtn.addEventListener("click", function(){
						if (state.gameWon) {
							return;
						}

						addMove();

						if (state.inventory.indexOf("Door Key") === -1) {
							setMessage("You need the Door Key first.");
							return;
						}

						state.doorUnlocked = true;
						updateUI();
						setMessage("The Door Key fits. Click the door to escape.");
					});
				}

				if (hintBtn) {
					hintBtn.addEventListener("click", function(){
						if (state.gameWon) {
							return;
						}

						addMove();

						if (state.cluesFound === 0) {
							setMessage("Start with the desk or the painting.");
						} else if (state.cluesFound < 4) {
							setMessage("The room hides four digits. Search every object except the locked ones.");
						} else if (!state.boxUnlocked) {
							setMessage("Put the four digits together in the order you found them.");
						} else if (state.inventory.indexOf("Door Key") === -1) {
							setMessage("The box has something important inside.");
						} else if (!state.doorUnlocked) {
							setMessage("Use the key on the door.");
						} else {
							setMessage("Click the door.");
						}
					});
				}

				if (resetBtn) {
					resetBtn.addEventListener("click", function(){
						resetGame();
					});
				}

				if (codeInput) {
					codeInput.addEventListener("keydown", function(e){
						if (e.key === "Enter" && tryCodeBtn) {
							tryCodeBtn.click();
						}
					});
				}

				resetGame();
			}

			function initAllEscapeRooms(){
				var roots = document.querySelectorAll(".zoEscapeRoom");
				roots.forEach(function(root){
					initEscapeRoom(root);
				});
			}

			if (document.readyState === "loading") {
				document.addEventListener("DOMContentLoaded", initAllEscapeRooms);
			} else {
				initAllEscapeRooms();
			}
		})();
	',

	'render_callback' => function($post_id, $module) {
		ob_start();
		?>
		<div class="zo-escape-room-wrap zoEscapeRoom">
			<div class="zo-escape-room-title">Escape Room</div>
			<div class="zo-escape-room-sub">Search the room. Find the code. Unlock the door.</div>

			<div class="zo-escape-room-topbar">
				<div class="zo-escape-room-stat">Moves: <span class="zoEscapeMoves">0</span></div>
				<div class="zo-escape-room-stat">Clues Found: <span class="zoEscapeClues">0</span>/4</div>
				<div class="zo-escape-room-stat">Door: <span class="zoEscapeDoorStatus">Locked</span></div>
			</div>

			<div class="zo-escape-room-room">
				<div class="zo-escape-room-item" data-item="desk">
					<div class="zo-escape-room-icon">🪑</div>
					<div class="zo-escape-room-label">Desk</div>
					<div class="zo-escape-room-small">Maybe there is a note.</div>
				</div>

				<div class="zo-escape-room-item" data-item="painting">
					<div class="zo-escape-room-icon">🖼️</div>
					<div class="zo-escape-room-label">Painting</div>
					<div class="zo-escape-room-small">Something looks odd.</div>
				</div>

				<div class="zo-escape-room-item" data-item="bookshelf">
					<div class="zo-escape-room-icon">📚</div>
					<div class="zo-escape-room-label">Bookshelf</div>
					<div class="zo-escape-room-small">One book sticks out.</div>
				</div>

				<div class="zo-escape-room-item" data-item="plant">
					<div class="zo-escape-room-icon">🪴</div>
					<div class="zo-escape-room-label">Plant</div>
					<div class="zo-escape-room-small">Check under the pot.</div>
				</div>

				<div class="zo-escape-room-item locked" data-item="box">
					<div class="zo-escape-room-icon">🧰</div>
					<div class="zo-escape-room-label">Locked Box</div>
					<div class="zo-escape-room-small">Needs a 4-digit code.</div>
				</div>

				<div class="zo-escape-room-item locked" data-item="door">
					<div class="zo-escape-room-icon">🚪</div>
					<div class="zo-escape-room-label">Door</div>
					<div class="zo-escape-room-small">Escape when it unlocks.</div>
				</div>
			</div>

			<div class="zo-escape-room-panel">
				<h3>Room Log</h3>
				<div class="zo-escape-room-message zoEscapeMessage">
					Click around the room to search for clues.
				</div>

				<div class="zo-escape-room-actions">
					<button class="zo-escape-room-btn alt zoEscapeHintBtn" type="button">Hint</button>
					<button class="zo-escape-room-btn alt zoEscapeResetBtn" type="button">Restart</button>
				</div>

				<div class="zo-escape-room-inputrow">
					<input type="text" class="zo-escape-room-input zoEscapeCodeInput" maxlength="4" inputmode="numeric" placeholder="Enter 4-digit code">
					<button class="zo-escape-room-btn zoEscapeTryCodeBtn" type="button">Unlock Box</button>
					<button class="zo-escape-room-btn good zoEscapeOpenDoorBtn" type="button">Open Door</button>
				</div>

				<h3>Inventory</h3>
				<div class="zo-escape-room-inventory zoEscapeInventory"></div>

				<div class="zo-escape-room-win zoEscapeWin">
					You escaped the room.
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	},
);