
function validarCadastro(){

    let alerta = document.querySelector(".alert");
    let cadastroName = document.forms["cadastrar"]["cadastro-name"].value;
    let cadastroSobrenome = document.forms["cadastrar"]["cadastro-sobrenome"].value;
    let dataNascimento = document.forms["cadastrar"]["data-nascimento"].value;
    let cadastroEmail = document.forms["cadastrar"]["cadastro-email"].value;
    let cadastroPass = document.forms["cadastrar"]["cadastro-pass"].value;
    let cadastroSecondPass = document.forms["cadastrar"]["second-cadastro-pass"].value;

    if(cadastroName == "" || cadastroName.length > 50){
        alerta.style.display = "block";
        alerta.innerHTML = "Digite seu nome.";
        return false;
    } if(cadastroSobrenome == "" || cadastroSobrenome.length > 100){
        alerta.style.display = "block";
        alerta.innerHTML = "Digite seu sobrenome.";
        return false;
    } if(dataNascimento == ""){
        alerta.style.display = "block";
        alerta.innerHTML = "Digite sua data de nascimento.";
        return false;
    } if(dataNascimento.length > 10) {
        alerta.style.display = "block";
        alerta.innerHTML = "Digite sua data de nascimento corretamente.";
        return false;
    } if(cadastroEmail == "" || cadastroEmail.length > 80){
        alerta.style.display = "block";
        alerta.innerHTML = "Digite seu Email.";
        return false;
    } if(cadastroPass == ""){
        alerta.style.display = "block";
        alerta.innerHTML = "Digite sua senha.";
        return false;
    } if(cadastroPass.length < 8) {
        alerta.style.display = "block";
        alerta.innerHTML = "Sua senha deve conter pelo menos 8 caractéres.";
        return false;
    } if(cadastroPass != cadastroSecondPass) {
        alerta.style.display = "block";
        alerta.innerHTML = "As senhas não coincidem.";
        return false;
    }else{
        return true;
    }
};

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
