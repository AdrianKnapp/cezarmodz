<?php
require 'config.php';
session_start();

if(isset($_GET['token']) && !empty($_GET['token'])) {
  $token = addslashes($_GET['token']);

  $verificar_token = "
    SELECT * FROM
    confirmar_email
    WHERE
    token_key = '$token'
    AND
    token_manual_expired = 0
    AND
    token_dt_expire > NOW();
  ";
  $verificar_token = $pdo->query($verificar_token);

  if($verificar_token->rowCount() > 0) {
    $pegarEmail = "SELECT user_email FROM confirmar_email WHERE token_key = '$token';";
    $pegarEmail = $pdo->query($pegarEmail);
    foreach($pegarEmail->fetchAll() as $dados):
      $email = $dados['user_email'];
    endforeach;
    echo $email;

    $verificarEmail = "UPDATE usuarios SET email_confirmacao = 1 WHERE email = '$email';";
    $verificarEmail = $pdo->query($verificarEmail);
    $_SESSION['emailVerificado'] = '';
    header('Location: login.php?emailVerificado');
  } else {
    header('Location: index.php');
  }
}
