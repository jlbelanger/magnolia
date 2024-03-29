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
		return date.toISOString().substring(start).replace(/\.\d+Z$/, '');
	};

	const secondsUntil = (date) => {
		const now = new Date();
		const seconds = date - now.getTime();
		if (seconds <= 0) {
			return '';
		}
		return prettyTime(seconds);
	};

	const secondsSince = (date) => {
		const now = new Date();
		const seconds = now.getTime() - date;
		if (seconds <= 0) {
			return '';
		}
		return prettyTime(seconds);
	};

	const onClickStop = (e) => {
		e.target.parentNode.remove();
	};

	const onKeyDown = (e) => {
		if (e.key === 'Escape') {
			window.DRAG_ELEMENT = null;
		}
	};

	const onMouseDown = (e) => {
		window.DRAG_ELEMENT = e.target.closest('.timer');

		// Calculate and save the starting position.
		const left = parseFloat(window.DRAG_ELEMENT.style.left) || window.DRAG_ELEMENT.offsetLeft;
		const top = parseFloat(window.DRAG_ELEMENT.style.top) || window.DRAG_ELEMENT.offsetTop;
		const x = e.clientX ? e.clientX : e.x;
		const y = e.clientY ? e.clientY : e.y;
		window.DRAG_START_X = left ? x - left : x;
		window.DRAG_START_Y = top ? y - top : y;

		e.preventDefault();
		return false;
	};

	const onMouseUp = () => {
		window.DRAG_ELEMENT = null;
	};

	const onMouseMove = (e) => {
		// Check if dragging is on.
		if (window.DRAG_ELEMENT === null) {
			return;
		}

		// Calculate the new position.
		const $timerButton = window.DRAG_ELEMENT.querySelector('.timer__text');
		let left = e.clientX - window.DRAG_START_X;
		left = Math.max(0, left);
		left = Math.min(left, window.innerWidth - $timerButton.clientWidth);
		let top = e.clientY - window.DRAG_START_Y;
		top = Math.max(0, top);
		top = Math.min(top, window.innerHeight - $timerButton.clientHeight);

		// Set the new position.
		window.DRAG_ELEMENT.style.left = `${left}px`;
		window.DRAG_ELEMENT.style.top = `${top}px`;
		window.DRAG_ELEMENT.style.bottom = 'auto';
		window.DRAG_ELEMENT.style.right = 'auto';
	};

	const simulateEvent = (e) => {
		const touch = e.changedTouches[0];
		const simulatedEvent = document.createEvent('MouseEvent');
		simulatedEvent.initMouseEvent(
			{
				touchstart: 'mousedown',
				touchmove: 'mousemove',
				touchend: 'mouseup',
			}[e.type],
			true,
			true,
			window,
			1,
			touch.screenX,
			touch.screenY,
			touch.clientX,
			touch.clientY,
			false,
			false,
			false,
			false,
			0,
			null
		);
		return simulatedEvent;
	};

	// https://stackoverflow.com/a/6362527
	const touchHandler = (e) => {
		if (e.target.className !== 'timer__text') {
			return;
		}
		const touch = e.changedTouches[0];
		touch.target.dispatchEvent(simulateEvent(e));
		e.preventDefault();
	};

	const onTouchMove = (e) => {
		if (window.DRAG_ELEMENT === null) {
			return;
		}
		onMouseMove(simulateEvent(e));
		e.preventDefault();
	};

	const onClickStart = () => {
		const date = new Date();
		const seconds = parseInt($button.getAttribute('data-timer'), 10);
		const isStopwatch = seconds === 0;
		date.setSeconds(date.getSeconds() + seconds);

		const $container = document.getElementById('timer-container');

		const $timer = document.createElement('div');
		$timer.setAttribute('class', 'timer timer--on');
		if (isStopwatch) {
			$timer.setAttribute('data-since', date);
		} else {
			$timer.setAttribute('data-until', date);
		}
		$container.appendChild($timer);

		const $text = document.createElement('button');
		$text.setAttribute('class', 'timer__text');
		$text.setAttribute('type', 'button');
		$text.innerText = isStopwatch ? '0:00' : secondsUntil(date);
		$text.addEventListener('mousedown', onMouseDown);
		$text.addEventListener('mouseup', onMouseUp);
		$timer.appendChild($text);

		if (!isStopwatch) {
			const $audio = document.createElement('audio');
			$audio.setAttribute('loop', true);
			$timer.appendChild($audio);

			const $source = document.createElement('source');
			$source.setAttribute('src', '/assets/sounds/magnolia-simms.mp3');
			$source.setAttribute('type', 'audio/mpeg');
			$audio.appendChild($source);
		}

		const $removeButton = document.createElement('button');
		$removeButton.setAttribute('aria-label', 'Stop');
		$removeButton.setAttribute('class', 'timer__stop');
		$removeButton.setAttribute('type', 'button');
		$removeButton.innerText = '×';
		$removeButton.addEventListener('click', onClickStop);
		$timer.appendChild($removeButton);

		if (window.TICK_INTERVAL) {
			return;
		}

		window.TICK_INTERVAL = setInterval(tick, 500); // eslint-disable-line no-use-before-define

		window.DRAG_ELEMENT = null;
		window.DRAG_START_X = 0;
		window.DRAG_START_Y = 0;
		document.addEventListener('mousemove', onMouseMove);
		document.addEventListener('keydown', onKeyDown);
		document.addEventListener('touchstart', touchHandler, true);
		document.addEventListener('touchend', touchHandler, true);
		document.addEventListener('touchcancel', touchHandler, true);
		document.addEventListener('touchmove', onTouchMove, { passive: false });
	};

	const tick = () => {
		const $timers = document.querySelectorAll('.timer--on');
		if ($timers.length <= 0) {
			clearInterval(window.TICK_INTERVAL);
			window.TICK_INTERVAL = null;

			window.DRAG_ELEMENT = null;
			window.DRAG_START_X = 0;
			window.DRAG_START_Y = 0;

			document.removeEventListener('mousemove', onMouseMove);
			document.removeEventListener('keydown', onKeyDown);
			document.removeEventListener('touchstart', touchHandler, true);
			document.removeEventListener('touchend', touchHandler, true);
			document.removeEventListener('touchcancel', touchHandler, true);
			document.removeEventListener('touchmove', onTouchMove, { passive: false });
			return;
		}

		$timers.forEach(($timer) => {
			const dateSince = $timer.getAttribute('data-since');
			if (dateSince) {
				const seconds = secondsSince(Date.parse(dateSince));
				$timer.querySelector('.timer__text').innerText = seconds;
				return;
			}

			const seconds = secondsUntil(Date.parse($timer.getAttribute('data-until')));
			if (seconds === '') {
				$timer.classList.remove('timer--on');

				const $text = $timer.querySelector('.timer__text');
				$text.removeEventListener('mousedown', onMouseDown);
				$text.removeEventListener('mouseup', onMouseUp);
				$text.addEventListener('click', onClickStop);
				$text.innerText = 'Stop';

				$timer.querySelector('audio').play();

				return;
			}
			$timer.querySelector('.timer__text').innerText = seconds;
		});
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
