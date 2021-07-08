function ocultar(id) {
  const escondido = document.querySelector('.confirmacao'+id);
  const escondidoTitle = document.querySelector('.confirmacao-title'+id);
  escondidoTitle.classList.remove('anima');
  escondido.classList.remove('anima');
}

function excluir(id) {
  location.href = 'perfil.php?id=' + id;
}
function fecharTudo(id){
  const escondido = document.querySelector('.confirmacao'+id);
  const escondidoTitle = document.querySelector('.confirmacao-title'+id);
  escondidoTitle.classList.remove('anima');
  escondido.classList.remove('anima');
}

function certezaDeletar(id) {
  const botao = document.querySelector('#certeza'+id);
  const escondido = document.querySelector('.confirmacao'+id);
  const escondidoTitle = document.querySelector('.confirmacao-title'+id);
  if(escondido.classList.contains('anima')){
    escondidoTitle.classList.remove('anima');
    escondido.classList.remove('anima');
  } else {
    escondidoTitle.classList.add('anima');
    escondido.classList.add('anima');
  }
  
};

function verificarSenhas() {
  const senha1 = document.forms["trocarSenha"]["senha1"].value;
  const senha2 = document.forms["trocarSenha"]["senha2"].value;
  const alerta = document.querySelector('.alerta');
  if(senha1,senha2.length < 8){
    alerta.style.display = 'block';
    alerta.innerHTML = 'Sua senha é pequena demais.';
    return false;
  } if(senha1 !== senha2){
    alerta.style.display = 'block';
    alerta.innerHTML = 'Senhas não coincidem.';
    return false;
  } return true;
}


