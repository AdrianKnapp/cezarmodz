<?php
session_start();
require 'config.php';
require 'classes/usuarios.class.php';

$userID = $_SESSION['logado'];
if(!isset($_SESSION['logado'])) {
  header("Location: login.php");
  exit;
}

$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);
if($usuarios->temPermissao("ADM")) {
  if(isset($_POST['upgradeNome']) && !empty($_POST['upgradeNome'])){
    $id = $_GET['id'];
    $nome = addslashes($_POST['upgradeNome']);
    $plataforma = addslashes($_POST['upgradePlataforma']);
    $preco = addslashes($_POST['upgradePreco']);
    $descricao = addslashes($_POST['upgradeDesc']);
    $link = addslashes($_POST['upgradeLink']);

    $upgrade = "
    UPDATE produtos SET 
    nome = '$nome',
    plataforma = $plataforma,
    valor = $preco,
    descricao = '$descricao',
    link_insta = '$link'
    WHERE id_produto = $id";
    $upgrade = $pdo->query($upgrade);
    $_SESSION['upgraded'] = '';
    header('Location: perfil.php');
    exit;
  }
  

} else {
  echo 'CAMPOS VÁZIOS!';
}




?>