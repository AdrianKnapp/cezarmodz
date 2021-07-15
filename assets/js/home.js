$(document).ready(function () {
	const pageStyle = localStorage.getItem('pageStyle');
	const presentUrl = window.location.href;
	const urlWithoutGetParameters = presentUrl.split('?')[0];

	if (urlWithoutGetParameters === 'http://localhost/CezarModz/index.php') {
		console.log(urlWithoutGetParameters);
		$("#inicio-item-menu").addClass("item-menu-actived");
		$("#inicio-bar-menu").addClass("item-bar-actived");
	} else {
		
	}
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
	$(":root").get(0).style.setProperty("--color-texts", "#e8e8e8");
	$(":root").get(0).style.setProperty("--background-color", "#1c1c1c");
	$(":root").get(0).style.setProperty("--offer-color", "white");
	$(":root").get(0).style.setProperty("--color-texts-on-hover", "#171717");
	$(":root").get(0).style.setProperty("--label-filter-bgcolor", "#545454");
	$(":root").get(0).style.setProperty("--white-background-color", "#1c1c1c");
	$(":root").get(0).style.setProperty("--softdark-background-color", "#272727");
	$(":root").get(0).style.setProperty("--color-border-to-darkmode", "#3b3b3b");
	$("header").css({
		'border-bottom-width': '1px'
	});
	$("#filter-button").removeClass("btn-outline-dark").addClass("btn-outline-light");
	$(".dropdown-menu").addClass("dropdown-menu-dark");
	localStorage.setItem('pageStyle','dark');
}

function changeStyleToLight() {
	$(".input-dark-mode-box img").attr("src", "assets/img/sun-button.svg");
	$(":root").get(0).style.setProperty("--color-texts", "#525252");
	$(":root").get(0).style.setProperty("--background-color", "#ebebeb");
	$(":root").get(0).style.setProperty("--offer-color", "#ff481f");
	$(":root").get(0).style.setProperty("--color-texts-on-hover", "white");
	$(":root").get(0).style.setProperty("--label-filter-bgcolor", "#dbdbdb");
	$(":root").get(0).style.setProperty("--white-background-color", "white");
	$(":root").get(0).style.setProperty("--softdark-background-color", "white");
	$(":root").get(0).style.setProperty("--color-border-to-darkmode", "white");
	$("header").css({
		'border-bottom-width': '0'
	});
	$("#filter-button").removeClass("btn-outline-light").addClass("btn-outline-dark");
	$(".dropdown-menu").removeClass("dropdown-menu-dark");
	localStorage.setItem('pageStyle','light');
}

$(".input-menor").change(function () {
	bloquearOutrosInputs(this, ".input-maior", "#span-for-input-maior", ".label-maior");
	bloquearInputsPadroes("#inputs-form-filter-valor");
});
$(".input-maior").change(function () {
	bloquearOutrosInputs(this, ".input-menor", "#span-for-input-menor", ".label-menor");
	bloquearInputsPadroes("#inputs-form-filter-valor");
});
$(".input-ps4").change(function () {
	bloquearOutrosInputs(this, ".input-xbox", "#span-for-input-xbox", ".label-xbox");
	bloquearOutrosInputs(this, ".input-pc", "#span-for-input-pc", ".label-pc");
	bloquearInputsPadroes("#inputs-form-filter-plataforma");
});
$(".input-xbox").change(function () {
	bloquearOutrosInputs(this, ".input-ps4", "#span-for-input-ps4", ".label-ps4");
	bloquearOutrosInputs(this, ".input-pc", "#span-for-input-pc", ".label-pc");
	bloquearInputsPadroes("#inputs-form-filter-plataforma");
});
$(".input-pc").change(function () {
	bloquearOutrosInputs(this, ".input-ps4", "#span-for-input-ps4", ".label-ps4");
	bloquearOutrosInputs(this, ".input-xbox", "#span-for-input-xbox", ".label-xbox");
	bloquearInputsPadroes("#inputs-form-filter-plataforma");
});
$(".input-conta").change(function () {
	bloquearOutrosInputs(this, ".input-upgrade", "#span-for-input-upgrade", ".label-upgrade");;
	bloquearInputsPadroes("#inputs-form-filter-tipo");
});
$(".input-upgrade").change(function () {
	bloquearOutrosInputs(this, ".input-conta", "#span-for-input-conta", ".label-conta");
	bloquearInputsPadroes("#inputs-form-filter-tipo");
});

function bloquearOutrosInputs(elemento, elementoParaBloquear, elementToChangeColor, elementToBlockHoverEvent) {
	if (elemento.checked) {
		$(elementoParaBloquear).prop("disabled", true);
		$(elementToChangeColor).get(0).style.setProperty("color", "#969696");
		console.log(elementToChangeColor);
		$(elementToBlockHoverEvent).removeClass("label-with-hover-function");
	} else {
		$(elementoParaBloquear).prop("disabled", false);
		$(elementToChangeColor).get(0).style.setProperty("color", "var(--color-texts)");
	}
}
function bloquearInputsPadroes(tipoDoInput) {
	const input = $(tipoDoInput).get(0);
	if (input.checked) {
		$(tipoDoInput).prop("disabled", true);
		$(tipoDoInput).prop("checked", false);
	} else {
		$(tipoDoInput).prop("disabled", false);
		$(tipoDoInput).prop("checked", true);
	}
}

$(".filtrar-button").click(function () {
	checkEmptyCheckbox();
});

function checkEmptyCheckbox() {
	if($(".input-menor").get(0).checked || $(".input-maior").get(0).checked || $(".input-ps4").get(0).checked || $(".input-xbox").get(0).checked || $(".input-pc").get(0).checked || $(".input-conta").get(0).checked || $(".input-upgrade").get(0).checked) {
		$(".submit-button-filter").trigger('click');
		return true;
	} else {
		return false;
	}
}




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
