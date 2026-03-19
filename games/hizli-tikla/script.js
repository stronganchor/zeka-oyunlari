(function () {
	function initHizliTiklaGame(gameRoot) {
		if (!gameRoot || gameRoot.dataset.zoHizliTiklaReady === '1') {
			return;
		}

		const game = gameRoot.querySelector('.zo-ht');

		if (!game) {
			return;
		}

		gameRoot.dataset.zoHizliTiklaReady = '1';

		const scoreEl = game.querySelector('.zo-ht__score');
		const timeEl = game.querySelector('.zo-ht__time');
		const button = game.querySelector('.zo-ht__button');
		const message = game.querySelector('.zo-ht__message');

		if (!scoreEl || !timeEl || !button || !message) {
			return;
		}

		let score = 0;
		let timeLeft = 10;
		let timer = null;
		let running = false;

		function updateUI() {
			scoreEl.textContent = String(score);
			timeEl.textContent = String(timeLeft);
		}

		function clearGameTimer() {
			if (timer !== null) {
				window.clearInterval(timer);
				timer = null;
			}
		}

		function endGame() {
			running = false;
			clearGameTimer();
			button.textContent = 'Tekrar Oyna';
			button.classList.remove('is-playing');
			button.classList.add('is-finished');
			message.textContent = 'Süre bitti. Skorun: ' + score;
		}

		function startGame() {
			score = 0;
			timeLeft = 10;
			running = true;

			updateUI();

			button.textContent = 'Tıkla';
			button.classList.add('is-playing');
			button.classList.remove('is-finished');
			message.textContent = 'Hızlı ol. Süre başladı.';

			clearGameTimer();

			timer = window.setInterval(function () {
				timeLeft -= 1;
				updateUI();

				if (timeLeft <= 0) {
					endGame();
				}
			}, 1000);
		}

		button.addEventListener('click', function () {
			if (!running) {
				startGame();
				return;
			}

			score += 1;
			updateUI();
		});

		updateUI();
	}

	function initAllHizliTiklaGames() {
		const gameRoots = document.querySelectorAll('.zo-game-root--hizli-tikla');

		gameRoots.forEach(function (gameRoot) {
			initHizliTiklaGame(gameRoot);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAllHizliTiklaGames);
	} else {
		initAllHizliTiklaGames();
	}
})();