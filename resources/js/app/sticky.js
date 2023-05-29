function initSticky() {
	const $element = document.querySelector('[data-sticky]');
	if (!$element) {
		return;
	}

	const onScroll = () => {
		const elementTop = $element.getAttribute('data-sticky-offset-top');
		const margin = $element.getAttribute('data-sticky-top-margin');
		const threshold = elementTop - parseInt(margin, 10);
		if (window.pageYOffset >= threshold) {
			$element.classList.add('sticky');
		} else {
			$element.classList.remove('sticky');
		}
	};

	const onResize = () => {
		$element.classList.remove('sticky');
		$element.setAttribute('data-sticky-offset-top', $element.getBoundingClientRect().top);
		onScroll();
	};

	window.addEventListener('scroll', onScroll);
	window.addEventListener('resize', onResize);
	onResize();
}

initSticky();
