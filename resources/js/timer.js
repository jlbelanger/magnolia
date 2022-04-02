function Timer($button) {
	const prettyTime = (milliseconds) => {
		const date = new Date(0);
		date.setSeconds(milliseconds / 1000);
		let start;
		if (milliseconds < 600000) {
			// x:xx
			start = 15;
		} else if (milliseconds < 3600000) {
			// xx:xx
			start = 14;
		} else if (milliseconds < 36000000) {
			// x:xx:xx
			start = 12;
		} else {
			// xx:xx:xx
			start = 11;
		}
		return date.toISOString().substr(start).replace(/\.\d+Z$/, '');
	};

	const secondsUntil = (date) => {
		const now = new Date();
		const seconds = date - now.getTime();
		if (seconds <= 0) {
			return '';
		}
		return prettyTime(seconds);
	};

	const onClickStop = (e) => {
		e.target.parentNode.remove();
	};

	const tick = () => {
		const $timers = document.querySelectorAll('.timer--on');
		if ($timers.length <= 0) {
			clearInterval(window.TICK_INTERVAL);
			window.TICK_INTERVAL = null;
			return;
		}

		$timers.forEach(($timer) => {
			const seconds = secondsUntil(Date.parse($timer.getAttribute('data-until')));
			if (seconds === '') {
				$timer.classList.remove('timer--on');
				$timer.querySelector('.timer__text').remove();

				const $stopButton = document.createElement('button');
				$stopButton.setAttribute('class', 'timer__stop');
				$stopButton.setAttribute('type', 'button');
				$stopButton.addEventListener('click', onClickStop);
				$stopButton.innerText = 'Stop';
				$timer.appendChild($stopButton);

				const $audio = document.createElement('audio');
				$audio.setAttribute('loop', true);
				$timer.appendChild($audio);

				const $source = document.createElement('source');
				$source.setAttribute('src', '/assets/sounds/magnolia-simms.mp3');
				$source.setAttribute('type', 'audio/mpeg');
				$audio.appendChild($source);

				$audio.play();

				return;
			}
			$timer.querySelector('.timer__text').innerText = seconds;
		});
	};

	const onClickStart = () => {
		const date = new Date();
		const seconds = parseInt($button.getAttribute('data-timer'), 10);
		date.setSeconds(date.getSeconds() + seconds);

		const $container = document.getElementById('timer-container');

		const $timer = document.createElement('div');
		$timer.setAttribute('class', 'timer timer--on');
		$timer.setAttribute('data-until', date);
		$container.appendChild($timer);

		const $text = document.createElement('div');
		$text.setAttribute('class', 'timer__text');
		$text.innerText = secondsUntil(date);
		$timer.appendChild($text);

		if (window.TICK_INTERVAL) {
			return;
		}

		window.TICK_INTERVAL = setInterval(tick, 500);
	};

	const init = () => {
		$button.addEventListener('click', onClickStart);
	};

	init();
}

function initTimer() {
	const $elements = document.querySelectorAll('[data-timer]');
	if ($elements.length <= 0) {
		return;
	}

	$elements.forEach(($element) => {
		Timer($element);
	});

	const $container = document.createElement('div');
	$container.setAttribute('id', 'timer-container');
	document.body.appendChild($container);
}

initTimer();
