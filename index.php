<?php
session_start();
require 'config.php';
require 'classes/usuarios.class.php';
require 'classes/index.class.php';

unset($_SESSION['anuncios']);
$query = new Query($pdo);


if(isset($_GET['valor']) && isset($_GET['plataforma']) && isset($_GET['tipo'])) {
    $plat = addslashes($_GET['plataforma']);
    $val = addslashes($_GET['valor']);
    $tipo = addslashes($_GET['tipo']);

    if($plat != '' && $val != '' && $tipo != ''){
        $structure = "
        WHERE pt.plataforma = $plat
        AND pt.disponibilidade = 0
        AND pt.tipo = '$tipo'
        ORDER BY pt.valor $val;
        ";
        if($query->queryFilter($structure)){
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($plat != '' && $val != ''){
        $structure = "
        WHERE pt.plataforma = $plat
        AND pt.disponibilidade = 0
        ORDER BY pt.valor $val;
        ";
        if($query->queryFilter($structure)){
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($plat != '' && $tipo != ''){
        $structure = "
        WHERE pt.plataforma = $plat
        AND pt.disponibilidade = 0
        AND pt.tipo = '$tipo'
        ";
        if($query->queryFilter($structure)){
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($val != '' && $tipo != ''){
        $structure = "
        WHERE pt.disponibilidade = 0
        AND pt.tipo = '$tipo'
        ORDER BY pt.valor $val;
        ";
        if($query->queryFilter($structure)){
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($plat != ''){
        $structure = "
            WHERE pt.plataforma = $plat
            AND pt.disponibilidade = 0
        ";
        if($query->queryFilter($structure)){
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($val != ''){
        $structure = "
            WHERE pt.disponibilidade = 0
            ORDER BY pt.valor $val;
        ";
        if($query->queryFilter($structure)){
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($tipo != ''){
        $structure = "
            WHERE pt.tipo = '$tipo'
            AND pt.disponibilidade = 0;
        ";
        if($query->queryFilter($structure)){
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    }
    
} else {
    if($query->queryDefault()){
        $buscarAnuncios = $query->queryDefault();
        $_SESSION['anuncios'] = '';
    } else {
        $_SESSION['alertaAnuncio'] = '';
    }
}



?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Início - CezarModz </title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/styleHome.css">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/icon/apple-icon-57x57.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/icon/apple-icon-60x60.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/icon/apple-icon-72x72.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/icon/apple-icon-76x76.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/icon/apple-icon-114x114.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/icon/apple-icon-120x120.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/icon/apple-icon-144x144.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/icon/apple-icon-152x152.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/apple-icon-180x180.png" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="192x192"  href="assets/img/icon/android-icon-192x192.png" type="image/x-icon" /> 
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/icon/favicon-32x32.png" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/icon/favicon-96x96.png" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/icon/favicon-16x16.png" type="image/x-icon" />
    <link rel="manifest" href="assets/img/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ff781e">
    <meta name="msapplication-TileImage" content="assets/img/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ff781e">
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
    <meta name="twitter:image" content="assets/img/LogoCezar5.png">
    <meta name="geo.region" content="BR"/>
    <meta name="description" content=" Adiquira a conta que você sempre quis conosoco agora mesmo! "/>
    <link rel="canonical" href="https://cezarmodz.com.br"/>
    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="pt_BR"/>
    <meta name="format-detection" content="telephone=no">
    <!-- SEO -->
</head>
<body>
    <header>
        <?php
            require 'menu.php';
        ?>
    </header>
    <div class="space-100"></div>
    <section id="store">
        <div class="container">
        <div class="slideshow" id="slideshow">
            <!--
					<div class="slidebolinhas">
						<div class="bolinha" onclick="mudarSlide(0)"> </div>
						<div class="bolinha" onclick="mudarSlide(1)"> </div>
                    </div>
-->
					<div class="slarea">
					<a href="https://www.instagram.com/cezarmodz/?hl=pt-br" target="_blank">
						<div class="slide" style="background-image:url('assets/img/Banner.png');"> 
						</div>
					</a>
					<a href="https://www.instagram.com/cezarmodz/?hl=pt-br" target="_blank">
						<div class="slide" style="background-image:url('assets/img/Banner2.png');"> 
						</div>
					</a>
					</div>
				</div>
            <div class="row-center title-home">
                <div class="title-store">
                    PRODUTOS
                </div>
            </div>
            <div class="row-left">
                <div class="filter">
                    <form method="GET">
                        <h6>FILTRO</h6>
                        <select name="valor" class="select">
                            <option class="option" value=""> PREÇO </option>
                            <option class="option" value="ASC"  <?php if(isset($val)) echo ($val=="ASC")?'selected="selected"':'' ?>> Menor - Maior </option>
                            <option class="option" value="DESC"  <?php if(isset($val)) echo ($val=="DESC")?'selected="selected"':'' ?>> Maior - Menor </option>
                        </select>
                        <select name="plataforma" class="select">
                            <option class="option" value=""> PLATAFORMA </option>
                            <option class="option" value="1" <?php if(isset($plat)) echo ($plat=="1")?'selected="selected"':'' ?>> PS4 </option>
                            <option class="option" value="2" <?php if(isset($plat)) echo ($plat=="2")?'selected="selected"':'' ?>> XBOX </option>
                            <option class="option" value="3" <?php if(isset($plat)) echo ($plat=="3")?'selected="selected"':'' ?>> PC </option>
                        </select>
                        <select name="tipo" class="select">
                            <option class="option" value=""> TIPO </option>
                            <option class="option" value="conta" <?php if(isset($tipo)) echo ($tipo=="conta")?'selected="selected"':'' ?>> CONTA </option>
                            <option class="option" value="up" <?php if(isset($tipo)) echo ($tipo=="up")?'selected="selected"':'' ?>> UPGRADE </option>
                        </select>
                        <button type="submit" class='limparButton filtrar'> FILTRAR </button>
                    </form>
                    <button class='limparButton' onclick='location.href="index.php"'> LIMPAR </button>
                    
                </div>
                <button class='abrirFiltros'> FILTROS </button>
            </div>
            
            <div class="products-box">
            <?php
                if(isset($_SESSION['anuncios'])){
                    foreach($buscarAnuncios->fetchAll() as $anuncios):
                        $anuncioId = $anuncios['id_produto'];
                        $anuncioPlat = $anuncios['nome_plat'];
                        $anuncioNome = $anuncios['nome'];
                        $anuncioTipo = $anuncios['tipo'];
                        $anuncioImagem = $anuncios['img_address'];
                        $anuncioValor = $anuncios['valor'];
                        $porcentagem =  20 / 100 * $anuncioValor;
                        $anuncioDesconto = $anuncioValor + $porcentagem;

                        switch($anuncioTipo){
                            case 'up':
                                $anuncioTipo = 'UPGRADE';
                            break;
                            case 'conta':
                                $anuncioTipo = 'CONTA';
                            break;
                        }
                        
                        echo "
                        <div class='anuncio-box'>
                            <img src='imagens/$anuncioImagem' alt='Imagem'>
                            <div class='row-center'>
                                <h1> $anuncioTipo $anuncioNome </h1>
                            </div>
                            <h4> $anuncioDesconto R$ </h4>
                            <div class='row-center'>
                                <h2> $anuncioValor R$</h2>
                            </div>
                            <div class='row-center'>
                                <a href='product.php?id=$anuncioId'>
                                    <input type='submit' class='see-more' value='VER MAIS'>
                                </a>
                            </div>
                            <div class='row-right'>
                                <h3>$anuncioPlat</h3>
                            </div>
                        </div>";
                    endforeach;
                } /* else {
                    echo "NÃO HÁ ANUNCIOS";
                } */
                if(isset($_SESSION['alertaAnuncio'])){
                    echo "
                        <div class='row-center'>
                            <h2 class='alertaAnuncio'> Não há anúncios. </h2>
                        </div>
                    ";
                } unset($_SESSION['alertaAnuncio']);
                ?>
        </div>
    </section>
    <div class="space-100"></div>

    <footer id="footer">
        <div class="container">
            <div class="row-center">
                <h1> CONTATO </h1>
            </div>
            <div class="row-center">
                <h3> contato@cezarmodz.com.br </h3>
            </div>
            <div class="row-center">
                <h1> REDES SOCIAIS </h1>
            </div>
            <div class="row-center">
                <a href="">
                    <img src="assets/img/instagram.svg" alt="" >
                </a>
            </div>
        </div>
        <div class="container credits">
            <h4> Todos os direitos reservados - CezarModz </h4>
            <h4> Desenvolvido por <a href="https://linktr.ee/adrianknapp" class='dev' target="_blank"> Adrian Knapp </a> </h4>
        </div>
    </footer>

    <!-- MODAL FILTRO RESPONSIVO -->
    <div class="filtroPopUp">
        <form method="GET" class='formFiltros'>
            <select name="valor" class="select">
                <option class="option" value=""> PREÇO </option>
                <option class="option" value="ASC"  <?php if(isset($val)) echo ($val=="ASC")?'selected="selected"':'' ?>> Menor - Maior </option>
                <option class="option" value="DESC"  <?php if(isset($val)) echo ($val=="DESC")?'selected="selected"':'' ?>> Maior - Menor </option>
            </select>
            <select name="plataforma" class="select">
                <option class="option" value=""> PLATAFORMA </option>
                <option class="option" value="1" <?php if(isset($plat)) echo ($plat=="1")?'selected="selected"':'' ?>> PS4 </option>
                <option class="option" value="2" <?php if(isset($plat)) echo ($plat=="2")?'selected="selected"':'' ?>> XBOX </option>
                <option class="option" value="3" <?php if(isset($plat)) echo ($plat=="3")?'selected="selected"':'' ?>> PC </option>
            </select>
            <select name="tipo" class="select">
                <option class="option" value=""> TIPO </option>
                <option class="option" value="conta" <?php if(isset($tipo)) echo ($tipo=="conta")?'selected="selected"':'' ?>> CONTA </option>
                <option class="option" value="up" <?php if(isset($tipo)) echo ($tipo=="up")?'selected="selected"':'' ?>> UPGRADE </option>
            </select>
            <button type="submit" class='limparButton filtrar'> FILTRAR </button>
        </form>
    <button class='limparButton' onclick='location.href="index.php"'> LIMPAR </button>
    <button class='cancelModal'> CANCELAR </button>
    </div>
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/scriptMenu.js"></script>
    <script type="text/javascript" src="assets/js/home.js"></script>
</body>
</html>