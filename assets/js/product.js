const botaoComprar = document.querySelector('.comprar-button');
const botaoMP = document.querySelector('.mercadopago-button');
const verificarLogin = document.querySelector('#log');
const pageAtual = window.location;
botaoComprar.addEventListener('click', function(){

switch(verificarLogin.value){
  case null:
  case "ZGVzY29uZWN0YWRv":
  window.location.href = 'login.php?page='+pageAtual;
  break;
case "bG9nYWRv":
  botaoMP.click();
break;
}
});

