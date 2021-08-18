// Função vinculada ao onSubmit, verificando campos.
function verificarLogin(){
    let alerta = document.querySelector(".alert");
    let loginEmail = document.forms["fazerLogin"]["email"].value;
    let loginPass = document.forms["fazerLogin"]["senha"].value;
    var alertaPhp = document.querySelector(".loginAlert");

    // Executa a função de verificar os campos vazios.
   if(verificarCampos(loginEmail, "Digite seu email")){
       if(verificarCampos(loginPass, "Digite sua senha")){
           return true;
       } return false;
   } else {
       return false;
   }
   // Função que verifica os campos vazios. 
   function verificarCampos(nomeVariavel, alertaMensagem){
        if(nomeVariavel == ""){
            if (alertaPhp != undefined) {
                alertaPhp.style.display = 'none';
                alerta.style.display = "block";
                alerta.innerHTML = alertaMensagem;
                return false;
            } else {
                alerta.style.display = "block";
                alerta.innerHTML = alertaMensagem;
                return false;
            }
        }   return true;
    }
}

// Caractéres inválidos. 
var regexName = "^[ a-zA-Z0-9-Zàèìòùáéíóúâêîôûãõ\b]+$";
var regexEmail = "^[ a-zA-Z0-9-Zàèìòùáéíóúâêîôûãõ\b.-_]+$";

// Executa a função de verificar caractere ao pressionar uma tecla.
$('input[name="email"]').on('keypress', validateField("email", regexEmail));
$('input[name="senha"]').on('keypress', validateField("senha", regexName));

// Função de verificar caractere.
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
      }, 200);
    });
  };


