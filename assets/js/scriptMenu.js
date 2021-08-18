$('.menuMobile').on('click', function(){
    $('.modalMenu').slideDown();
    $('.modalMenu').addClass( "mostrarMenu" )
    $('.modalMenu ul').show();
});
$('.fechar').on('click', function(){
    $('.modalMenu').slideUp();
    $('.modalMenu').removeClass( "mostrarMenu")
    $('.modalMenu ul').hide();
});
$('.modalMenu').on('click', function(){
    $('.modalMenu').slideUp();
    $('.modalMenu').removeClass( "mostrarMenu")
    $('.modalMenu ul').hide();
});
    

