<?php
session_start();
require 'config.php';
require 'classes/usuarios.class.php';

if(
  isset($_POST['cadastro-email']) && !empty($_POST['cadastro-email'])
  &&
  isset($_POST['cadastro-pass']) && !empty($_POST['cadastro-pass'])
  &&
  $_POST['cadastro-pass'] == $_POST['second-cadastro-pass']
  ) {

  $oldNome = addslashes($_POST['cadastro-name']);
  $oldEmail = addslashes($_POST['cadastro-email']);
  $oldNumeroCelular = addslashes($_POST['num-celular']);
  $senha1 = md5($_POST['cadastro-pass']);

  $origem = $_POST['origem'];
  
  $nome = filter_var($oldNome, FILTER_SANITIZE_STRING);
  $email = filter_var($oldEmail, FILTER_SANITIZE_EMAIL);
  $numCelular = filter_var($oldNumeroCelular, FILTER_SANITIZE_NUMBER_INT);

  $verificarSeExisteEmail = "SELECT email FROM usuarios WHERE email = '$email' AND email_confirmacao = 1";
  $verificarSeExisteEmail = $pdo->query($verificarSeExisteEmail);

  if($verificarSeExisteEmail->rowCount() > 0){
    $_SESSION['emailExistente'] = "";
    header('Location: cadastro.php');
    exit;
  }
  $deletarEmail = "DELETE FROM usuarios WHERE email = '$email' AND email_confirmacao = 0";
  $deletarEmail = $pdo->query($deletarEmail);
  
  $usuarios = new Usuarios($pdo);
  $usuarios->cadastrarUsuario($nome, $numCelular, $email, $senha1, $origem);

  $token_key = mb_strimwidth(
    str_shuffle(
        "ABCDEFGHIJKLMNOPKRSTUVXZabcdefghijklmnopkrstuvxz1234567890"
    ),
    0,
    45
  );
  $sql_insert_token = "
    INSERT INTO
        confirmar_email
    SET
        user_email = '$email',
        token_key = '$token_key',
        token_dt_expire = DATE_ADD(NOW(), INTERVAL 3 HOUR)
    ";
  $sql_insert_token = $pdo->query($sql_insert_token);
  header("Location: confirmarEmail.php?token=$token_key&email=$email");
} else {
  
}

?>