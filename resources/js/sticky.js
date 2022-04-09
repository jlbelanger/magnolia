function initSticky() {
	const $element = document.querySelector('[data-sticky]');
	if (!$element) {
		return;
	}

	const onScroll = () => {
		const offsetFromTopOfPage = window.pageYOffset;
		const elementTop = $element.getAttribute('data-sticky-offset-top') - $element.getAttribute('data-sticky-top');
		if (offsetFromTopOfPage > elementTop) {
			$element.style.position = 'fixed';
		} else {
			$element.style.position = '';
		}
	};

	const onResize = () => {
		$element.setAttribute('data-sticky-offset-top', $element.offsetTop);
	};

	window.addEventListener('scroll', onScroll);
	window.addEventListener('resize', onResize);
	onResize();
}

initSticky();
