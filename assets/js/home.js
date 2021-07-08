var slideItem = 0;

window.onload = function() {
	setInterval(passarSlide, 7000);

	var slidewidth = document.getElementById("slideshow").offsetWidth;
	var objs = document.getElementsByClassName("slide");
	for(var i=0;i<objs.length;i++) {
		objs[i].style.width = slidewidth+"px";
	}
}

function passarSlide() {
	var slidewidth = document.getElementById("slideshow").offsetWidth;
	
	if(slideItem >= 1) {
		slideItem = 0;
	} else {
		slideItem++;
	}

	document.getElementsByClassName("slarea")[0].style.marginLeft = "-"+(slidewidth * slideItem)+"px";
}
function mudarSlide(pos) {
	slideItem = pos;
	var slidewidth = document.getElementById("slideshow").offsetWidth;
	document.getElementsByClassName("slarea")[0].style.marginLeft = "-"+(slidewidth * slideItem)+"px";
}
const formFiltros = document.querySelector('.formFiltros');
const abrirFiltros = document.querySelector('.abrirFiltros');
const modalFiltros = document.querySelector('.filtroPopUp');
const fecharModal = document.querySelector('.cancelModal');

abrirFiltros.addEventListener('click', function(){
	modalFiltros.classList.toggle('modalFiltro');
});

fecharModal.addEventListener('click', function(){
	modalFiltros.classList.toggle('modalFiltro');
});


