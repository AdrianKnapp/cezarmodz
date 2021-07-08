<?php
session_start();
require 'config.php';
require 'classes/usuarios.class.php';

if(isset($_POST['email']) && !empty($_POST['email'])) {
  $loginEmail = addslashes($_POST['email']);
  $loginSenha = md5($_POST['senha']);
  $usuarios = new Usuarios($pdo);

  if($usuarios->fazerLogin($loginEmail, $loginSenha)) {

    if(!empty($_GET['page'])){
      $page = $_GET['page'];
      header("Location: $page"); 
    } else {
      header("Location: index.php"); 
    }
    exit;

  } else {
    $_SESSION['alertMsg'] = "";
    header("Location: login.php");
      exit;
  }
}
?>
