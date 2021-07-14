$(document).ready(function () {
	const pageStyle = localStorage.getItem('pageStyle');

	switch (pageStyle) {
		case 'light':
			changeStyleToLight();
			break;
		case 'dark':
			$('#darkSwitch').prop('checked', true);
			changeStyleToDark();
	}
});

$("#darkSwitch").change(function () {
	if (darkSwitch.checked) {
		changeStyleToDark();
	} else {
		changeStyleToLight();
	}
});


function changeStyleToDark() {
	$(".input-dark-mode-box img").attr("src", "assets/img/night-button.svg");
	$(":root").get(0).style.setProperty("--color-texts", "white");
	$(":root").get(0).style.setProperty("--background-color", "#1c1c1c");
	$(":root").get(0).style.setProperty("--offer-color", "white");
	$(":root").get(0).style.setProperty("--color-texts-on-hover", "#171717");
	$(":root").get(0).style.setProperty("--white-background-color", "#1c1c1c");
	$(":root").get(0).style.setProperty("--anuncio-background-color", "#272727");
	$("header").css({
		'border-bottom': '1px solid #949494'
	});
	$("#filter-button").removeClass("btn-outline-dark").addClass("btn-outline-light");
	$(".dropdown-menu").addClass("dropdown-menu-dark");
	localStorage.setItem('pageStyle','dark');
}

function changeStyleToLight() {
	$(".input-dark-mode-box img").attr("src", "assets/img/sun-button.svg");
	$(":root").get(0).style.setProperty("--color-texts", "#171717");
	$(":root").get(0).style.setProperty("--background-color", "#ebebeb");
	$(":root").get(0).style.setProperty("--offer-color", "#ff481f");
	$(":root").get(0).style.setProperty("--color-texts-on-hover", "white");
	$(":root").get(0).style.setProperty("--white-background-color", "white");
	$(":root").get(0).style.setProperty("--anuncio-background-color", "white");
	$("header").css({
		'border-bottom': '0'
	});
	$("#filter-button").removeClass("btn-outline-light").addClass("btn-outline-dark");
	$(".dropdown-menu").removeClass("dropdown-menu-dark");
	localStorage.setItem('pageStyle','light');
}

$(".input-menor").change(function () {
	bloquearOutrosInputs(this, ".input-maior");
});
$(".input-maior").change(function () {
	bloquearOutrosInputs(this, ".input-menor");
});
$(".input-ps4").change(function () {
	bloquearOutrosInputs(this, ".input-xbox");
	bloquearOutrosInputs(this, ".input-pc");
});
$(".input-xbox").change(function () {
	bloquearOutrosInputs(this, ".input-ps4");
	bloquearOutrosInputs(this, ".input-pc");
});
$(".input-pc").change(function () {
	bloquearOutrosInputs(this, ".input-ps4");
	bloquearOutrosInputs(this, ".input-xbox");
});
$(".input-conta").change(function () {
	bloquearOutrosInputs(this, ".input-upgrade");;
});
$(".input-upgrade").change(function () {
	bloquearOutrosInputs(this, ".input-conta");
});

function bloquearOutrosInputs(elemento, elementoParaBloquear) {
	if (elemento.checked) {
		$(elementoParaBloquear).prop("disabled", true);
	} else {
		$(elementoParaBloquear).prop("disabled", false);
	}
}

$(".filtrar-button").click(function () {
	$(".submit-button-filter").trigger('click');
});




$(document).ready(function () {
	// Bloquear botão de avançar página 
	const inputNextHREF = $(".pagination-input-next").attr('href');
	let buttonNextStatus = '';
	switch (inputNextHREF) {
		case 'index.php':
			buttonNextStatus = 'blocked';
			$(".pagination-button-right").addClass("pagination-button-right-disabled")
			break;
	}

	if (buttonNextStatus == 'blocked') {
		$(".pagination-input-next").click(function () {
			event.preventDefault();
		});
	}


	// Bloquear botão de voltar página 
	const inputPreviousHREF = $(".pagination-input-previous").attr('href');
	let buttonPreviousStatus = '';
	switch (inputPreviousHREF) {
		case 'index.php':
			buttonPreviousStatus = 'blocked';
			$(".pagination-button-left").addClass("pagination-button-left-disabled")
			break;
	}

	if (buttonPreviousStatus == 'blocked') {
		$(".pagination-input-previous").click(function () {
			event.preventDefault();
		});
	}
	if ($(".pagination-button-right").hasClass("pagination-button-right-disabled") && $(".pagination-button-left").hasClass("pagination-button-left-disabled")) {
		$('.pagination-button-left').css({
			borderRight: "1px solid #b0b0b0"
		});
	} else {}
});
