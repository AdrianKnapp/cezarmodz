<?php
require 'config.php';
session_start();
if(isset($_POST['anuncioNome']) && !empty($_POST['anuncioNome'])){
  $produtoNome = addslashes($_POST['anuncioNome']);
  $produtoPlat = $_POST['anuncioPlataforma'];
  $produtoTipo  = $_POST['anuncioTipo'];
  $produtoValor = addslashes($_POST['anuncioPreco']);
  $produtoDesc = addslashes($_POST['anuncioDesc']);
  $produtoLink = addslashes($_POST['anuncioLink']);
  $contaEmail = addslashes(base64_encode($_POST['emailContaVenda']));
  $contaSenha = addslashes(base64_encode($_POST['senhaContaVenda']));
  $arquivo = $_FILES['anuncioImg'];
  
  if(isset($arquivo['tmp_name']) && !empty($arquivo['tmp_name'])) {
    $ext = strtolower(substr($arquivo['tmp_name'],-4));
    $nomedoarquivo = md5(time().rand(0, 999)). $ext;
    move_uploaded_file($arquivo['tmp_name'], 'imagens/'.$nomedoarquivo);

    $nomeArquivo = $nomedoarquivo; 
    $width = 1000;
    $height = 1000;

    list($larguraOriginal, $alturaOriginal) = getimagesize('imagens/'.$nomeArquivo);

    } 
  $imagemFinal = imagecreatetruecolor($width, $height);

  $imagemOriginal = imagecreatefromjpeg('imagens/'.$nomeArquivo);

  imagecopyresampled($imagemFinal, $imagemOriginal, 0, 0, 0, 0, $width, $height, $larguraOriginal, $alturaOriginal);

  imagejpeg($imagemFinal, 'imagens/'.$nomedoarquivo , 100);
  echo 'imagem redimencionada com sucesso!';

  $inserir_anuncio = "
  INSERT INTO produtos
  (
  nome, 
  plataforma, 
  valor, 
  descricao, 
  link_insta,
  tipo,
  email,
  senha,
  img_address
  )
  VALUES 
  (
  '$produtoNome', 
  $produtoPlat, 
  $produtoValor, 
  '$produtoDesc', 
  '$produtoLink',
  '$produtoTipo',
  '$contaEmail',
  '$contaSenha',
  '$nomedoarquivo'
  );
  ";
  $inserir_anuncio = $pdo->query($inserir_anuncio);
  $_SESSION['inserido'] = "teste";
  header('Location: perfil.php');
}
?>