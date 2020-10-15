function verificarLogin(){

    let alerta = document.querySelector(".alert");
    let LoginEmail = document.forms["fazerLogin"]["login-email"].value;
    let loginPass = document.forms["fazerLogin"]["login-pass"].value;

    if(LoginEmail == "") {
        alerta.style.display = "block";
        alerta.innerHTML = "Digite seu email";
        return false;
    } if(LoginPass == "") {
        alerta.style.display = "block";
        alerta.innerHTML = "Digite sua senha";
        return false;
    } else {
        return true;
    }
}


var regexName = "^[ a-zA-Z0-9-Zàèìòùáéíóúâêîôûãõ\b]+$";
var regexEmail = "^[ a-zA-Z0-9-Zàèìòùáéíóúâêîôûãõ\b.-_]+$";

$('input[name="login-email"]').on('keypress', validateField("login-email", regexEmail));
$('input[name="login-pass"]').on('keypress', validateField("login-pass", regexName));


function validateField(name, regexValue) {
    $(`input[name="${name}"]`).on('keypress', function() {
      var regex = new RegExp(regexValue);
      var _this = this;

      setTimeout( function(){
          var texto = $(_this).val();
          if(!regex.test(texto))
          {
              $(_this).val(texto.substring(0, (texto.length-1)))
          }
      }, 0);
    });
  }