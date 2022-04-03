const menuButton = document.getElementById('menu-button');

if (menuButton) {
	menuButton.addEventListener('click', () => {
		document.getElementById('nav').classList.toggle('show');
	});
}
