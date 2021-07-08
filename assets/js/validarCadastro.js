
function validarCadastro(){

    let alerta = document.querySelector(".alert");
    let cadastroName = document.forms["cadastrar"]["cadastro-name"].value;
    let cadastroEmail = document.forms["cadastrar"]["cadastro-email"].value;
    let cadastroPass = document.forms["cadastrar"]["cadastro-pass"].value;
    let cadastroSecondPass = document.forms["cadastrar"]["second-cadastro-pass"].value;
    let numeroCelular = document.forms["cadastrar"]["num-celular"].value;
    var alertaPhp = document.querySelector(".loginAlert");

    if(cadastroName == "" || cadastroName.length > 50){
        if (alertaPhp != undefined) {
            alertaPhp.style.display = 'none';
            alerta.style.display = "block";
            alerta.innerHTML = "Digite seu nome.";
            return false;
        } else {
            alerta.style.display = "block";
            alerta.innerHTML = "Digite seu nome.";
            return false;
        }
    } if(numeroCelular == "" || numeroCelular.length > 11){
        if (alertaPhp != undefined) {
            alertaPhp.style.display = 'none';
            alerta.style.display = "block";
            alerta.innerHTML = "Digite seu celular.";
            return false;
        } else{
            alerta.style.display = "block";
            alerta.innerHTML = "Digite seu celular.";
            return false;
        }
    } if(cadastroEmail == "" || cadastroEmail.length > 80){
        if (alertaPhp != undefined) {
            alertaPhp.style.display = 'none';
            alerta.style.display = "block";
            alerta.innerHTML = "Digite seu Email.";
            return false;
        } else{
            alerta.style.display = "block";
            alerta.innerHTML = "Digite seu Email.";
            return false;
        }
    } if(cadastroPass == ""){
        if (alertaPhp != undefined){
            alertaPhp.style.display = 'none';
            alerta.style.display = "block";
            alerta.innerHTML = "Digite sua senha.";
            return false;
        } else{
            alerta.style.display = "block";
            alerta.innerHTML = "Digite sua senha.";
            return false;
        }
    } if(cadastroPass.length < 8) {
        if (alertaPhp != undefined){
            alertaPhp.style.display = 'none';
            alerta.style.display = "block";
            alerta.innerHTML = "Sua senha deve conter pelo menos 8 caractéres.";
            return false;
        } else{
            alerta.style.display = "block";
            alerta.innerHTML = "Sua senha deve conter pelo menos 8 caractéres.";
            return false;
        }
    } if(cadastroPass != cadastroSecondPass) {
        if (alertaPhp != undefined){
            alertaPhp.style.display = 'none';
            alerta.style.display = "block";
            alerta.innerHTML = "As senhas não coincidem.";
            return false;
        } else{
            alerta.style.display = "block";
            alerta.innerHTML = "As senhas não coincidem.";
            return false;
        }
    } else{
        return true;
    }
};
function somenteNumeros(num) {
    var er = /[^0-9.]/;
    er.lastIndex = 0;
    var campo = num;
    if (er.test(campo.value)) {
      campo.value = "";
    }
}

// BLOQUEANDO CARACTÉRES ESPECIAIS.
var regexName = "^[ a-zA-Z0-9-Zàèìòùáéíóúâêîôûãõ\b]+$";
var regexEmail = "^[ a-zA-Z0-9-Zàèìòùáéíóúâêîôûãõ\b.-_]+$";

$('input[name="cadastro-name"]').on('keypress', validateField("cadastro-name", regexName));
$('input[name="cadastro-sobrenome"]').on('keypress', validateField("cadastro-sobrenome", regexName));
$('input[name="cadastro-email"]').on('keypress', validateField("cadastro-email", regexEmail));
$('input[name="cadastro-pass"]').on('keypress', validateField("cadastro-pass", regexName));
$('input[name="second-cadastro-pass"]').on('keypress', validateField("second-cadastro-pass", regexName));

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
