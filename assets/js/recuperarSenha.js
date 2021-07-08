function VerificarCampos(){
  let alerta = document.querySelector(".alert");
  let campo = document.forms["recSenha"]["campo"].value;
  var alertaPhp = document.querySelector(".loginAlert");

  if(campo == ""){
    if (alertaPhp != undefined) {
        alertaPhp.style.display = 'none';
        alerta.style.display = "block";
        alerta.innerHTML = "Preencha o campo.";
        return false;
    } else {
        alerta.style.display = "block";
        alerta.innerHTML = "Preencha o campo.";
        return false;
    }
}   return true;
}