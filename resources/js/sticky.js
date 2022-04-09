function initSticky() {
	const $element = document.querySelector('[data-sticky]');
	if (!$element) {
		return;
	}

	const onScroll = () => {
		const offsetFromTopOfPage = window.pageYOffset;
		const elementTop = parseInt($element.getAttribute('data-sticky-offset-top'), 10) - parseInt($element.getAttribute('data-sticky-top'), 10);
		if (offsetFromTopOfPage > elementTop) {
			$element.style.position = 'fixed';
		} else {
			$element.style.position = '';
		}
	};

	const onResize = () => {
		$element.setAttribute('data-sticky-offset-top', $element.offsetTop);
		$element.style.right = `${window.innerWidth - $element.offsetLeft - $element.scrollWidth}px`;
	};

	window.addEventListener('scroll', onScroll);
	window.addEventListener('resize', onResize);
	onResize();
}

initSticky();
