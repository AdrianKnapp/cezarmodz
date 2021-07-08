<?php
session_start();
require 'config.php';
require 'classes/usuarios.class.php';

if(!isset($_SESSION['logado'])) {
  header("Location: login.php");
  exit;
}
$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);
unset($_SESSION['logado']);
header('Location: login.php');
?>