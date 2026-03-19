document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-ht');

	games.forEach(function (game) {
		const scoreEl = game.querySelector('.zo-ht__score');
		const timeEl = game.querySelector('.zo-ht__time');
		const button = game.querySelector('.zo-ht__button');
		const message = game.querySelector('.zo-ht__message');

		let score = 0;
		let timeLeft = 10;
		let timer = null;
		let running = false;

		function updateUI() {
			scoreEl.textContent = String(score);
			timeEl.textContent = String(timeLeft);
		}

		function endGame() {
			running = false;

			if (timer) {
				clearInterval(timer);
				timer = null;
			}

			button.textContent = 'Tekrar Oyna';
			message.textContent = 'Süre bitti. Skorun: ' + score;
		}

		function startGame() {
			score = 0;
			timeLeft = 10;
			running = true;

			updateUI();
			button.textContent = 'Tıkla';
			message.textContent = 'Hızlı ol';

			if (timer) {
				clearInterval(timer);
			}

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
			}

			if (!running) {
				return;
			}

			score += 1;
			updateUI();
		});

		updateUI();
	});
});