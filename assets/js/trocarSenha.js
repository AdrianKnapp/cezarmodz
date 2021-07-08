function validarCampos(){
  let alerta = document.querySelector(".alert");
  let senha1 = document.forms["trocarSenha"]["senha1"].value;
  let senha2 = document.forms["trocarSenha"]["senha2"].value;

  
    if(senha1, senha2 == ""){
      alerta.style.display = "block";
      alerta.innerHTML = "Campos vazios";
      return false;
    } if (senha1 != senha2){
      alerta.style.display = "block";
      alerta.innerHTML = "Senhas não coincidem";
      return false;
    } if (senha1, senha2.length < 8){
      alerta.style.display = "block";
      alerta.innerHTML = "Sua senha deve conter 8 caractéres";
      return false;
    } return true;

}