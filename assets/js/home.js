// Verificando se existe cookie para alterar estilo da página ao carrega-la
$(document).ready(function () {
	const myCookie = Cookies.get("pageStyle");

	switch (myCookie) {
		case 'light':
			changeStyleToLight();
			break;
		case 'dark':
			$('#darkSwitch').prop('checked', true);
			changeStyleToDark();
	}
});

// Evento do switch de mudar style da página
const darkSwitch = document.getElementById("darkSwitch");
darkSwitch.addEventListener("change", function () {
	if (darkSwitch.checked) {
		changeStyleToDark();
	} else {
		changeStyleToLight();
	}
});


// Mudar estilo para black
function changeStyleToDark() {
	$(".input-dark-mode-box img").attr("src", "assets/img/night-button.svg");
	$(":root").get(0).style.setProperty("--color-texts", "white");
	$(":root").get(0).style.setProperty("--background-color", "#1c1c1c");
	$(":root").get(0).style.setProperty("--price-color", "white");
	$(":root").get(0).style.setProperty("--offer-color", "white");
	$(":root").get(0).style.setProperty("--color-texts-on-hover", "#171717");
	$(":root").get(0).style.setProperty("--white-background-color", "#1c1c1c");
	$(":root").get(0).style.setProperty("--anuncio-background-color", "#272727");
	$("header").css({
		'border-bottom': '1px solid #949494'
	});
	$("#filter-button").removeClass("btn-outline-dark").addClass("btn-outline-light");
	$(".dropdown-menu").addClass("dropdown-menu-dark");
	Cookies.set("pageStyle", "dark");

}

// Mudar estilo para light
function changeStyleToLight() {
	$(".input-dark-mode-box img").attr("src", "assets/img/sun-button.svg");
	$(":root").get(0).style.setProperty("--color-texts", "#171717");
	$(":root").get(0).style.setProperty("--background-color", "#ebebeb");
	$(":root").get(0).style.setProperty("--price-color", "#ff7c1f");
	$(":root").get(0).style.setProperty("--offer-color", "#ff481f");
	$(":root").get(0).style.setProperty("--color-texts-on-hover", "white");
	$(":root").get(0).style.setProperty("--white-background-color", "white");
	$(":root").get(0).style.setProperty("--anuncio-background-color", "white");
	$("header").css({
		'border-bottom': '0'
	});
	$("#filter-button").removeClass("btn-outline-light").addClass("btn-outline-dark");
	$(".dropdown-menu").removeClass("dropdown-menu-dark");
	Cookies.set("pageStyle", "light");
}

$(".input-menor").change(function () {
	bloquearOutrosInputs(this, ".input-maior");
	montarURLparaFiltrar(this, "ASC");
});
$(".input-maior").change(function () {
	bloquearOutrosInputs(this, ".input-menor");
	montarURLparaFiltrar(this, "DESC");
});
$(".input-ps4").change(function () {
	bloquearOutrosInputs(this, ".input-xbox");
	bloquearOutrosInputs(this, ".input-pc");
	montarURLparaFiltrar(this, "1");
});
$(".input-xbox").change(function () {
	bloquearOutrosInputs(this, ".input-ps4");
	bloquearOutrosInputs(this, ".input-pc");
	montarURLparaFiltrar(this, "2");
});
$(".input-pc").change(function () {
	bloquearOutrosInputs(this, ".input-ps4");
	bloquearOutrosInputs(this, ".input-xbox");
	montarURLparaFiltrar(this, "3");
});
$(".input-conta").change(function () {
	bloquearOutrosInputs(this, ".input-upgrade");
	montarURLparaFiltrar(this, "conta");
});
$(".input-upgrade").change(function () {
	bloquearOutrosInputs(this, ".input-conta");
	montarURLparaFiltrar(this, "up");
});
switchsAtivos = ['a'];

function bloquearOutrosInputs(elemento, elementoParaBloquear) {
	if (elemento.checked) {
		$(elementoParaBloquear).prop("disabled", true);
	} else {
		$(elementoParaBloquear).prop("disabled", false);
	}
}

url = '';

function montarURLparaFiltrar(elemento, elementoParaBloquear) {
	if (elemento.checked) {
		if (switchsAtivos.indexOf(elementoParaBloquear) < 1) {
			switchsAtivos.push(elementoParaBloquear);
			console.log(switchsAtivos);
		}
	} else {
		if (switchsAtivos.indexOf(elementoParaBloquear) >= 1) {
			switchsAtivos.splice(switchsAtivos.indexOf(elementoParaBloquear), 1);
			console.log(switchsAtivos);
		}
	}
}

$(".filtrar-button").click(function () {
	$(".submit-button-filter").trigger('click');
});


function verificarArray(ordemValue) {
	return switchsAtivos.indexOf(ordemValue) > 0;
}

// Bloquear botão de voltar página 
const inputPreviousHREF = $(".pagination-input-previous").attr('href');
buttonPreviousStatus = '';
switch (inputPreviousHREF) {
	case 'index.php':
		buttonPreviousStatus  = 'blocked';
		$(".pagination-button-left").addClass( "pagination-button-left-disabled" )
	break;
}

if(buttonPreviousStatus == 'blocked'){
$(".pagination-input-previous").click(function () {
	event.preventDefault();
});
} 

// Bloquear botão de avançar página 
const inputNextHREF = $(".pagination-input-next").attr('href');
buttonNextStatus = '';
switch (inputNextHREF) {
	case 'index.php':
		buttonNextStatus  = 'blocked';
		$(".pagination-button-right").addClass( "pagination-button-right-disabled" )
	break;
}

if(buttonNextStatus == 'blocked'){
$(".pagination-input-next").click(function () {
	event.preventDefault();
});
} 

if ($(".pagination-button-right").hasClass("pagination-button-right-disabled") && $(".pagination-button-left").hasClass("pagination-button-left-disabled")) {
    $('.pagination-button-left').css({borderRight:"1px solid #b0b0b0"});
}