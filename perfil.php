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

if(isset($_SESSION['inserido']) ){
    ?>
        <script type='text/javascript'>
            window.onload = function(){
                alert('Anúncio inserido com sucesso.');
            };
        </script>
    <?php
    unset($_SESSION['inserido']);
} else{
}
if(isset($_SESSION['upgraded']) ){
    ?>
        <script type='text/javascript'>
            window.onload = function(){
                alert('Anúncio atualizado com sucesso.');
            };
        </script>
    <?php
    unset($_SESSION['upgraded']);
} else{
}


$userID = $_SESSION['logado'];

if(isset($_POST['senha1']) && isset($_POST['senha2']) && !empty($_POST['senha1']) && !empty($_POST['senha2'])){
    $novaSenha = md5($_POST['senha1']);
    $upgradeSenha = "
        UPDATE usuarios SET
        senha = '$novaSenha'
        WHERE id = $userID;
    ";
    $upgradeSenha = $pdo->query($upgradeSenha);
    $_SESSION['senhaAlterada'] = '';
    header('Location: login.php');
    exit;
} else {

}

if(isset($_SESSION['senhaAlterada']) ){
    ?>
        <script type='text/javascript'>
            window.onload = function(){
                alert('Senha alterada com sucesso.');
            };
        </script>
    <?php
    unset($_SESSION['senhaAlterada']);
} else{
}

if($usuarios->temPermissao("ADM") == false) {
    $pedidos = "
        SELECT
        pd.id, 
        pd.id_usuario, 
        pd.compraID,
        pd.cartao,
        pd.parcelas,
        pd.status,
        pd.id_produto, 
        pd.data_compra, 
        pt.nome, 
        pt.plataforma, 
        pt.descricao,
        pt.valor, 
        pt.tipo,
        pf.nome_plat 
        FROM pedidos as pd 
        INNER JOIN produtos AS pt 
        INNER JOIN plataformas AS pf 
        WHERE pd.id_usuario = '$userID'
        AND pd.id_produto = pt.id_produto
        AND pt.plataforma = id_plataforma;
    ";
    $pedidos = $pdo->query($pedidos);
    if($pedidos->rowCount() > 0){
        $_SESSION['pedidos'] = '';
       
    } else{
        // Não há pedidos.
    }
  } else {
      $queryAnuncios = "
        SELECT
        pt.id_produto,
        pt.nome,
        pt.plataforma,
        pt.descricao,
        pt.link_insta,
        pt.img_address,
        pt.disponibilidade,
        pt.valor,
        pt.dt_cadastro,
        pf.nome_plat
        FROM produtos AS pt
        INNER JOIN plataformas AS pf
        ON pt.plataforma = pf.id_plataforma
        WHERE pt.disponibilidade = 0
        ORDER BY dt_cadastro DESC;
        ;
      ";
      $queryAnuncios = $pdo->query($queryAnuncios);
      if($queryAnuncios->rowCount() >= 0){
        $anuncios = $_SESSION['adm'] = '';
      }
      if(isset($_GET['id'])) {
        $idParaDeletar = $_GET['id'];
        $deletarProduto = "UPDATE produtos SET disponibilidade = 1 WHERE id_produto = '$idParaDeletar';";
        $deletarProduto = $pdo->query($deletarProduto);
        header('Location: perfil.php');
      }
      
  }
  
// Buscar dados do usuário no sistema.

$dadosUsuario = "SELECT * FROM usuarios WHERE id = '$userID';";
$dadosUsuario = $pdo->query($dadosUsuario);
if($dadosUsuario->rowCount() > 0){
    foreach($dadosUsuario as $dados):
        $nomeUsuario = $dados['nome'];
        $emailUsuario = $dados['email'];
        $numUsuario = $dados['num_celular'];
    endforeach;
} else {
    "Usuario NÃO encontrado";
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - CezarModz</title>
     <!-- SEO -->
     <meta name="description" content=" Adiquira a conta que você sempre quis conosoco agora mesmo! ">
    <meta name="author" content="Adrian Knapp">
    <meta name="keywords" content=" Adiquira a conta que você sempre quis conosoco agora mesmo! "/>
    <link rel="alternate" href="" hreflang="pt-br"/>
    <meta name="robots" content="index, follow">
    <meta property="og:title" content=" A melhor loja de contas MOD do Brasil! "/>
    <meta property="og:image" content="assets/img/LogoCezar5.png"/>
    <meta property="og:description" content=" Adiquira a conta que você sempre quis conosoco agora mesmo! "/>
    <meta name="theme-color" content="#ffbb00">
    <meta property="business:contact_data:country_name" content="Brasil"/>
    <meta property="business:contact_data:website" content="https://cezarmodz.com.br/"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:description" content=" Adiquira a conta que você sempre quis conosoco agora mesmo! "/>
    <meta name="twitter:title" content=" A melhor loja de contas MOD do Brasil! "/>
    <meta name="twitter:image" content="assets/img/LogoCezar5.png" ">
    <meta name="geo.region" content="BR"/>
    <meta name="description" content=" Adiquira a conta que você sempre quis conosoco agora mesmo! "/>
    <link rel="canonical" href="https://cezarmodz.com.br"/>
    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="pt_BR"/>
    <meta name="format-detection" content="telephone=no">
    <!-- SEO -->
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styleHome.css">
    <link rel="stylesheet" href="assets/css/styleProduct.css">
    <link rel="stylesheet" href="assets/css/styleProfile.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="assets/img/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/icon/favicon-16x16.png">
    <link rel="manifest" href="assets/img/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ff781e">
    <meta name="msapplication-TileImage" content="assets/img/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ff781e">
</head>
<body>
    <?php
        require 'loader.php';
    ?>
    <header>
        <?php
            require 'menu.php';
        ?>
    </header>
    <div class="space-100"></div>

    <section id="profile">
        <div class="container">
            <div class="profile-buttons">
                <h1> PERFIL </h1>
            </div>
            <div class="profile-box">
                <div class="top-box">
                    <img src="assets/img/user.svg" alt="">
                    <div class="top-text">
                        <div class="row-left">
                            <h2 class="nome">
                                <?php
                                    echo $nomeUsuario;
                                    if(isset($anuncios)){
                                        echo "
                                        <div class='permissao'>
                                            ADM
                                        </div>
                                        ";
                                    }
                                ?>
                            </h2>
                        </div>
                        <div class="row-left">
                            <h2>
                            <?php
                                    echo $emailUsuario;
                                ?>
                            </h2>
                        </div>
                        <div class="row-left">
                            <!-- Button trigger modal -->
                            <h2 type="button" class="button" data-toggle="modal" data-target="#exampleModal">
                                Segurança e dados
                            </h2>
                        </div>
                        <div class="row-left">
                            <a href="destruirLogin.php">
                                <h2> Sair </h2>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                    $html = "";
                    if(!isset($anuncios)){
                        if(isset($_SESSION['pedidos'])){
                            foreach($pedidos->fetchAll() as $pedidos):
                                $pedidoNome = $pedidos['nome'];
                                $data = $pedidos['data_compra'];
                                $pedidoValor = $pedidos['valor'];
                                $pedidoPlat = $pedidos['nome_plat'];
                                $pedidoTipo = $pedidos['tipo'];
                                $pedidoParcelas = $pedidos['parcelas'];
                                $card = $pedidos['cartao'];
                                $pedidoId = $pedidos['compraID'];
                                $pedidoStatus = $pedidos['status'];
                                $pedidoData = new DateTime($data);
                                $pedidoData = $pedidoData->format('d/m/Y');

                                switch($pedidoStatus){
                                    case 'pending': 
                                        case 'in_process':
                                        case 'authorized':
                                        case 'in_mediation':
                                            $pedidoStatus =  "PENDENTE";
                                        break;
                                        case 'approved':
                                            $pedidoStatus =  "APROVADO";
                                        break;
                                        case 'rejected':
                                            $pedidoStatus = "REJEITADO";
                                        break;
                                        case 'cancelled':
                                        case 'refunded':
                                        case 'charged_back':
                                            $pedidoStatus = "CACELADO";
                                        break;
                                }


                                switch($pedidoTipo){
                                    case "up":
                                        $tipo = "UPGRADE";
                                    break;
                                    case "conta":
                                        $tipo = "CONTA";
                                    break;
                                }
                                switch($card){
                                    case "master":
                                        $cartao = "MASTERCARD";
                                    break;
                                    case "visa":
                                        $cartao = "VISA";
                                    break;
                                    case "amex":
                                        $cartao = "AMERICAN EXPRESS";
                                    break;
                                    case "hipercard":
                                        $cartao = "HIPERCARD";
                                    break;
                                    case "elo":
                                        $cartao = "ELO";
                                    break;
                                }
                                $html .= "                         
                                    <tr>
                                        <td> $tipo $pedidoNome </td>
                                        <td> $pedidoValor R$</td>
                                        <td>
                                        <!-- Button trigger modal -->
                                            <p type='button' class='abrirModalPedidos' data-toggle='modal' data-target='#pedidoModal$pedidoId'>
                                            Ver mais
                                        </p>
                                        </td>
                                    </tr>
                                    
                                    
                                    <!-- Modal -->
                                    <div class='modal fade' id='pedidoModal$pedidoId' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                      <div class='modal-dialog'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h5 class='modal-title titlePedidos' id='exampleModalLabel'> PEDIDO $pedidoId</h5>
                                            <button type='button' class='close'data-dismiss='modal' aria-label='Close'>
                                              <span aria-hidden='true'>&times;</span>
                                            </button>
                                          </div>
                                          <div class='modal-body pedidosModal'>
                                            <h1> $tipo $pedidoNome </h1>
                                            <h2> $pedidoValor R$ </h2>
                                            <h3> $cartao - $pedidoParcelas"."x  </h3>
                                            <h3> $pedidoPlat </h3>
                                            <h3> PAGAMENTO $pedidoStatus </h3>
                                            <h3> $pedidoData </h3>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                
                                ";
                            endforeach;
                        ?>
                            <div class='pedidos'>
                                <h2> PEDIDOS </h2>
                                <div class='anuncio'>
                                <table class='table'>
                                    <tr>
                                        <th> NOME:</th>
                                        <th> DATA: </th>
                                        <th> ACÕES: </th>
                                    </tr>
                                <?php
                                    echo $html;
                                ?>
                                </table>
                            </div>
                            </div>

                        <?php
                            unset($_SESSION['pedidos']);
                            
                        } else {
                            echo "
                                <div class='pedidos'>
                                    <h2> Não há pedidos </h2>
                                </div>
                            ";
                        }
                    } else {
                        $produtoHTML = '';
                        $modal = '';
                        foreach($queryAnuncios->fetchAll() as $produto):
                            $produtoId = $produto['id_produto'];
                            $produtoNome = $produto['nome'];
                            $produtoPlat = $produto['nome_plat'];
                            $produtoDataInicio = $produto['dt_cadastro'];
                            $produtoDesc = $produto['descricao'];
                            $produtoLink = $produto['link_insta'];
                            $produtoValor = $produto['valor'];
                            $produtoData = new DateTime($produtoDataInicio);
                            $produtoData = $produtoData->format('d/m/Y');
                            $produtoHTML .= "
                                    <tr class='linha'>
                                        <td> $produtoNome </td>
                                        <td> $produtoValor R$ </td>
                                        <td> $produtoData </td>
                                        <td class='acoes'>
                                            <p class='edita' data-toggle='modal' data-target='#exampleModal$produtoId'>
                                                EDITAR
                                            </p>
                                        </td>
                                        </tr>     
                            ";
                            $modal .= "
                                <!-- Modal -->
                                <div class='modal fade ' id='exampleModal$produtoId' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered'>
                                    <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>
                                            EDITAR ANÚNCIO
                                        </h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true' onclick='fecharTudo($produtoId)'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='upgradeAnuncio.php?id=$produtoId' method='POST' class='formAddProduto' enctype='multipart/form-data'>
                                            <label for='upgradeNome' class='labelUpload'> Nome: </label> 
                                            <input type='text' name='upgradeNome' placeholder='$produtoNome' class='inputUpload' required>
                                            <label for='upgradeNome' > Plataforma: </label> 
                                            <select name='upgradePlataforma' class='select'>
                                                <option class='option' value='1'> PS4 </option>
                                                <option class='option' value='2'> XBOX </option>
                                                <option class='option' value='3'> PC </option>
                                            </select>
                                            <label for='upgradePreco' class='labelUpload'> Preço: </label> 
                                            <input type='text' name='upgradePreco' placeholder='$produtoValor' class='inputUpload' required pattern='[0-9]+$'>
                                            <label for='upgradeDesc' class='labelUpload'> Descrição: </label> 
                                            <input type='text' name='upgradeDesc' placeholder='$produtoDesc' class='inputUpload' required>
                                
                                            <label for='upgradeLink' class='labelUpload'> Instagram: </label> 
                                            <input type='url' name='upgradeLink' placeholder='$produtoLink' class='inputUpload' required>
                                            <div class='row-center'>
                                            <input type='submit' value='FINALIZAR' class='editarBotao'>
                                            </div>
                                        </form>
                                        <div class='row-center'>
                                        <button class='buttonDelete' id='certeza$produtoId' onclick='certezaDeletar($produtoId)'>  DELETAR ANÚNCIO </button>
                                        </div>
                                        <div class='row-center delete-title confirmacao-title$produtoId' 
                                        style='display:none;'>
                                            TEM CERTEZA?
                                        </div>
                                        <div class='row-center confirmacao$produtoId' style='display:none;'>
                                            <p class='deleteButton positive' onclick='excluir($produtoId)'>
                                            SIM
                                            </p>
                                            <p class='deleteButton negative' onclick='ocultar($produtoId)' id='ocultar$produtoId'>
                                            NÃO
                                            </p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            ";
                        endforeach;
                        echo "
                            <div class='anuncio'>
                            <h2 class='gerenciarTitle'> GERENCIAR ANUNCIOS <img src='assets/img/add.svg' class='add' data-toggle='modal' data-target='#modalAdicionarProduto'></h2>
                            <div class='tableScroll'>
                            <table class='table'>
                                    <tr>
                                        <th> NOME:</th>
                                        <th> VALOR: </th>
                                        <th> INSERIDO: </th>
                                        <th> ACÕES </th>
                                    </tr>
                                $produtoHTML
                            </table>
                            </div>
                            </div>
                            $modal
                        ";
                    }
                ?>
               
            </div>
        </div>
    </section>
    <div class="space-150"></div>
    


<!-- Modal Segurança e Dados-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content modalSeguranca">
      <div class="modal-header">
        <h5 class="modal-title modalPerfilTitle" id="exampleModalLabel">
            Segurança e dados
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body modalCorpoPerfil">
      <h3> Trocar senha: </h3>
            <div class="row-left">
                <form action="" method='POST' onsubmit="return verificarSenhas()" name="trocarSenha">
                    <input type="password" name='senha1' placeholder="Nova senha" class="campoTrocarSenha">
                    <input type="password" name='senha2' placeholder="Repita a senha" class="campoTrocarSenha">
                    <input type="submit" value="TROCAR" class="enviar botaoTrocarSenha" class="">
                </form>
            </div>
            <div class="row-center">
                    <div class="alerta">
                        Alerta
                    </div>
                </div>
            <h3> Seu número: </h3> 
            <h3 class="numero">
                <?php
                    echo $numUsuario;
                ?>
            </h3>
      </div>
    </div>
  </div>
</div>



<?php
if($usuarios->temPermissao("ADM")){
    echo "
    <!-- Modal Adicionar produto-->
    <div class='modal fade' id='modalAdicionarProduto' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
        <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>
                ADICIONAR ANÚNCIO
            </h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        <div class='modal-body'>
        <form action='uploadAnuncio.php' method='POST' class='formAddProduto' enctype='multipart/form-data'>
                <label for='anuncioNome' class='labelUpload'> Nome: </label> 
                <input type='text' name='anuncioNome' placeholder='Ex: PLATINIUM' class='inputUpload' required>
                <label for='anuncioNome'> Plataforma: </label> 
                <select name='anuncioPlataforma' class='select'>
                    <option class='option' value='1'> PS4 </option>
                    <option class='option' value='2'> XBOX </option>
                    <option class='option' value='3'> PC </option>
                </select>
                <label for='anuncioTipo'> Tipo: </label> 
                <select name='anuncioTipo' class='select'>
                    <option class='option' value='conta'> CONTA </option>
                    <option class='option' value='up'> UPGRADE </option>
                </select>
                <label for='anuncioPreco' class='labelUpload'> Preço: </label> 
                <input type='text' name='anuncioPreco' placeholder='Ex: 200 (Não coloque o cifrão)' class='inputUpload' required pattern='[0-9]+$'>
                <label for='anuncioDesc' class='labelUpload'> Descrição: </label> 
                <input type='text' name='anuncioDesc' placeholder='Ex: 10 MILHÕES, 10 CARROS, 2 IATES' class='inputUpload' required>
                <label for='emailContaVenda' class='labelUpload'> Email: </label> 
                <input type='email' name='emailContaVenda' placeholder='Email da conta a venda' class='inputUpload'>
                <label for='senhaContaVenda' class='labelUpload'> Senha: </label> 
                <input type='text' name='senhaContaVenda' placeholder='Senha da conta a venda' class='inputUpload'>

                <label for='anuncioImg'> Imagem: </label> 
                <input type='file' name='anuncioImg' class='uploadImagem' required>

                <label for='anuncioLink' class='labelUpload'> Instagram: </label> 
                <input type='url' name='anuncioLink' placeholder='Ex: https://www.instagram.com/p/CHIgKvpBEh3/' class='inputUpload' required>
                <input type='submit' value='INSERIR ANÚNCIO' class='editarBotao'>
                
            </form>
        </div>
        </div>
    </div>
    </div>
    ";
} else{

}
?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/scriptMenu.js"></script>
    <script src="assets/js/perfil.js"></script>
</body>
</html>