// Accessibility: skip to content (https://www.bignerdranch.com/blog/web-accessibility-skip-navigation-links/).
document.getElementById('skip').addEventListener('click', (e) => {
	let skipTo = e.target.getAttribute('href').split('#')[1];
	skipTo = document.getElementById(skipTo);
	skipTo.setAttribute('tabindex', -1);
	skipTo.addEventListener('blur', () => {
		skipTo.removeAttribute('tabindex');
	});
	skipTo.focus();
});
