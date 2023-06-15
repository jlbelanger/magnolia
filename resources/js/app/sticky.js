function initSticky() {
	const $element = document.querySelector('[data-sticky]');
	if (!$element) {
		return;
	}

	const onScroll = () => {
		const elementTop = $element.getAttribute('data-sticky-offset-top');
		const margin = $element.getAttribute('data-sticky-top-margin');
		const threshold = elementTop - parseInt(margin, 10);
		if (window.scrollY >= threshold) {
			$element.classList.add('sticky');
			$element.style.right = `${$element.getAttribute('data-sticky-offset-right')}px`;
		} else {
			$element.classList.remove('sticky');
			$element.style.right = null;
		}
	};

	const onResize = () => {
		$element.classList.remove('sticky');
		const rect = $element.getBoundingClientRect();
		$element.setAttribute('data-sticky-offset-top', window.scrollY + rect.top);
		$element.setAttribute('data-sticky-offset-right', window.innerWidth - rect.right);
		onScroll();
	};

	window.addEventListener('scroll', onScroll);
	window.addEventListener('resize', onResize);
	onResize();
}

initSticky();
