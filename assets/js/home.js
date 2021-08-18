window.onload = () => {
	const pageStyle = localStorage.getItem('pageStyle');
	const presentUrl = window.location.href;
	const urlWithoutGetParameters = presentUrl.split('?')[0];
	const menuLiText = document.getElementById("inicio-item-menu");
	const menuLiBar = document.getElementById("inicio-bar-menu");
	const switchDarkMode = document.querySelector('#darkSwitch');

	if (urlWithoutGetParameters === 'http://localhost/CezarModz/index.php', 'http://localhost/CezarModz/' || presentUrl === 'http://localhost/CezarModz/') {
		menuLiText.classList.add("item-menu-actived");
		menuLiBar.classList.add("item-bar-actived");
	}

	switch (pageStyle) {
		case 'light':
			changeStyleToLight();
			break;
		case 'dark':
			switchDarkMode.checked = true;
			changeStyleToDark();
	}


	// Block next page button
	const linkNextPageHref = document.querySelector(".pagination-input-next").getAttribute('href');
	const buttonNextPage = document.querySelector(".pagination-button-right");

	switch (linkNextPageHref) {
		case 'index.php':
			buttonNextPage.classList.add("pagination-button-right-disabled")
			document.querySelector('.pagination-input-next').addEventListener('click', () => event.preventDefault());
			break;
	}


	// Block previous page button
	const linkPreviousPageHref = document.querySelector(".pagination-input-previous").getAttribute('href');
	const buttonPreviousPage = document.querySelector(".pagination-button-left");

	switch (linkPreviousPageHref) {
		case 'index.php':
			buttonPreviousPage.classList.add("pagination-button-left-disabled")
			document.querySelector('.pagination-input-previous').addEventListener('click', () => event.preventDefault());
			break;
	}


	if ($(".pagination-button-right").hasClass("pagination-button-right-disabled") && $(".pagination-button-left").hasClass("pagination-button-left-disabled")) {
		$('.pagination-button-left').css({
			borderRight: "1px solid #b0b0b0"
		});
	} else {}
};

function initFilterSystem() {
	const filterCheckbox = document.querySelectorAll('.dropdown-checkbox');
	if (filterCheckbox.length) {
		filterCheckbox.forEach((checkbox, index) => checkbox.addEventListener('change', () => blockOtherCheckboxes(checkbox.classList[1], index)));

		function blockOtherCheckboxes(inputClass, index) {
			const checkboxGroupToBlock = document.querySelectorAll('.' + inputClass);
			const checkboxHidden = document.getElementsByClassName('js-' + inputClass)[0];

			if (filterCheckbox[index].checked) {
				checkboxGroupToBlock.forEach((checkbox) => checkbox.checked = false);
				filterCheckbox[index].checked = true;
				checkboxHidden.checked = false;
			} else {
				checkboxHidden.checked = true;
			}
		}
	}
}
initFilterSystem();


function initDarkmodeSystem() {
	const switchDarkMode = document.querySelector('#darkSwitch');
	switchDarkMode.addEventListener('change', () => {
		if (switchDarkMode.checked)
			changeStyleToDark()
		else
			changeStyleToLight()
	});
}
initDarkmodeSystem();

function changeCssVariables(colors) {
	const header = document.querySelector('header');
	const root = document.documentElement;

	root.style.setProperty('--color-texts', colors.colorTexts);
	root.style.setProperty('--background-color', colors.backgroundColor);
	root.style.setProperty('--offer-color', colors.offerColor);
	root.style.setProperty('--color-texts-on-hover', colors.colorTextsOnHover);
	root.style.setProperty('--label-filter-bgcolor', colors.labelFilterBgColor);
	root.style.setProperty('--white-background-color', colors.whiteBgColor);
	root.style.setProperty('--softdark-background-color', colors.SoftdarkBgColor);
	root.style.setProperty('--color-border-to-darkmode', colors.colorBorderToDarkmode);
	root.style.setProperty('--color-pagination-button-disabled', colors.colorPaginationButtonDisabled);
	root.style.setProperty('--darkmode-toggle-system', colors.darkmodeToggleSystem);
	header.style.borderBottomWidth = colors.headerBorderBottom;
	localStorage.setItem('pageStyle', colors.localStorageValue);
}

function changeStyleToDark() {
	const colors = {
		colorTexts: '#e8e8e8',
		backgroundColor: '#171717',
		offerColor: 'white',
		colorTextsOnHover: '#171717',
		labelFilterBgColor: '#545454',
		whiteBgColor: '#171717',
		SoftdarkBgColor: '#272727',
		colorBorderToDarkmode: '#3b3b3b',
		colorPaginationButtonDisabled: '#595959',
		headerBorderBottom: '1px',
		localStorageValue: 'dark',
		darkmodeToggleSystem: '#ff7c1f'
	}
	changeCssVariables(colors);
}

function changeStyleToLight() {
	const colors = {
		colorTexts: '#525252',
		backgroundColor: '#ebebeb',
		offerColor: '#ff481f',
		colorTextsOnHover: 'white',
		labelFilterBgColor: '#dbdbdb',
		whiteBgColor: 'white',
		SoftdarkBgColor: 'white',
		colorBorderToDarkmode: 'white',
		colorPaginationButtonDisabled: '#b0b0b0',
		headerBorderBottom: '0',
		localStorageValue: 'light',
		darkmodeToggleSystem: '#525252'
	}
	changeCssVariables(colors);
}

function initFilterButtonSystem() {
	const filtrarButton = document.querySelector('.filtrar-button');
	const checkboxes = document.querySelectorAll('.dropdown-checkbox');
	const submitButton = document.querySelector('.submit-button-filter');
	filtrarButton.addEventListener('click', () => {
		checkboxes.forEach((checkbox, index) => {
			if (checkbox.checked)
				submitButton.click();
		});
	});
}
initFilterButtonSystem();