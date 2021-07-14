<?php
ini_set('session.cookie_samesite', 'None');
session_start();
require 'config.php';
require 'classes/usuarios.class.php';
require 'classes/index.class.php';

$presentUrl =  $_SERVER["REQUEST_URI"];

$page = 0;
$nextPage = $page + 1;
switch ($page) {
    case 0:
        $previousPage = 0;
        echo "Página anterior: ".$previousPage."<br>";
        break;
    case 1:
        $previousPage = $page - 1;
        echo "Página anterior: ".$previousPage."<br>";
        break;
}

if(isset($_GET['p'])){
    $page = $_GET['p']; // pegar a paginação.
}


if($page == 0) {
    $linesToQuery = 10 * 0;
} else {
    $linesToQuery = 10 * $page;
    echo "Buscar a partir da linha: ".$linesToQuery;
}

$query = new Query($pdo, $linesToQuery);
$structure = '';
$dbTotalLines =  $query->queryToCountDbDataLines($structure);
$totalNumPages = ceil($dbTotalLines / 10);
print_r("Número total de paginas: ".$totalNumPages);

if(isset($_GET['valor']) || isset($_GET['plataforma']) || isset($_GET['tipo'])) {
    $getsAtUrl = explode("?", $presentUrl);
    $getsAtUrl = explode("&", $getsAtUrl[1]);
    echo "<br>";
    print_r($getsAtUrl);
    echo "<br>";
    $plat = '';
    $val = '';
    $tipo = '';

    if(isset($_GET['plataforma'])){
        $plat = addslashes($_GET['plataforma']);
    }
    if (isset($_GET['valor'])) {
        $val = addslashes($_GET['valor']);
    }
    if (isset($_GET['tipo'])) {
        $tipo = addslashes($_GET['tipo']);
    }
    
    

    if($plat != '' && $val != '' && $tipo != ''){
        $structure = "
        WHERE pt.plataforma = $plat
        AND pt.disponibilidade = 0
        AND pt.tipo = '$tipo'
        ORDER BY pt.valor $val
        ";
        if($query->queryFilter($structure)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structure);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($plat != '' && $val != ''){
        $structure = "
        WHERE pt.plataforma = $plat
        AND pt.disponibilidade = 0
        ORDER BY pt.valor $val
        ";
        if($query->queryFilter($structure)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structure);
            $totalNumPages = ceil($dbTotalLines / 10);
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
            $dbTotalLines =  $query->queryToCountDbDataLines($structure);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($val != '' && $tipo != ''){
        $structure = "
        WHERE pt.disponibilidade = 0
        AND pt.tipo = '$tipo'
        ORDER BY pt.valor $val
        ";
        if($query->queryFilter($structure)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structure);
            $totalNumPages = ceil($dbTotalLines / 10);
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
            $dbTotalLines =  $query->queryToCountDbDataLines($structure);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($val != ''){
        $structure = "
            WHERE pt.disponibilidade = 0
            ORDER BY pt.valor $val
        ";
        if($query->queryFilter($structure)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structure);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structure);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($tipo != ''){
        $structure = "
            WHERE pt.tipo = '$tipo'
            AND pt.disponibilidade = 0
        ";
        if($query->queryFilter($structure)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structure);
            $totalNumPages = ceil($dbTotalLines / 10);
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

echo "<br> Página atual: ".$page;

if(isset($getsAtUrl)) {
    if(isset($getsAtUrl[2])) {
        $urlToPagination = $getsAtUrl[0]."&".$getsAtUrl[1]."&".$getsAtUrl[2]."&";
    } else if(isset($getsAtUrl[1])) {
        $urlToPagination = $getsAtUrl[0]."&".$getsAtUrl[1]."&";
    } else if(isset($getsAtUrl[0])) {
        $urlToPagination = $getsAtUrl[0]."&";
    } 
    
    echo "<br>";
    print_r($getsAtUrl);
    /* echo "<br>".$getsAtUrl[1];
    echo "<br>".$getsAtUrl[2];
    echo "<br>".$getsAtUrl[3]; */
} else {
    $urlToPagination = "";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Início - CezarModz </title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/variaveis-globais.css">
    <link rel="stylesheet" href="assets/css/styleHome.css">
    <link rel="stylesheet" href="assets/css/bootstrap.5.0.2.min.css">
    <link rel="stylesheet" href="assets/css/menu.css">
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
    <?php
        require 'menu.php';
    ?>
    <section id="store">
        <div class="container">
            <div class="row-left" style="display: flex; flex-direction:column">
                <div class="filter">
                    <form method='GET' action="index.php?p=<?php echo $page.$urlToPagination;?>">
                        Valor
                        <input type="checkbox" class="inputs-form-filter" name="valor" value="" 
                            <?php
                                if(!isset($_GET['valor'])) {
                                    echo "checked";
                                } else {
                                    switch ($_GET['valor']) {
                                        case "":
                                            echo "checked";
                                            break;
                                        default:
                                            echo "disabled";
                                    }
                                }
                            ?>
                        >
                        Plataforma
                        <input type="checkbox" class="inputs-form-filter" name="plataforma" value=""
                            <?php
                                if(!isset($_GET['plataforma'])) {
                                    echo "checked";
                                } else {
                                    switch ($_GET['plataforma']) {
                                        case "":
                                            echo "checked";
                                            break;
                                        default:
                                            echo "disabled";
                                    }
                                }
                            ?>
                        >
                        Tipo
                        <input type="checkbox" class="inputs-form-filter" name="tipo" value=""
                            <?php
                                if(!isset($_GET['tipo'])) {
                                    echo "checked";
                                } else {
                                    switch ($_GET['tipo']) {
                                        case "":
                                            echo "checked";
                                            break;
                                        default:
                                            echo "disabled";
                                    }
                                }
                            ?>
                        >
                        <div class="filter-buttons-group">
                            <div class="btn-group">
                                <button class="filter-button dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" id='filter-button'>
                                    ORDENAR POR
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-line dropdown-item-title"> Preço </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="form-check-input preco input-menor" type="checkbox" value="ASC" name='valor'
                                            <?php
                                                if(isset(($_GET['valor'])) && $_GET['valor'] == 'ASC') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset(($_GET['valor']))){
                                                        switch ($_GET['valor']) {
                                                            case "DESC":
                                                                echo "disabled";
                                                            break;
                                                            default:
                                                                
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span> Menor </span> 
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="form-check-input preco input-maior" type="checkbox" value="DESC" name='valor'
                                            <?php
                                                if(isset(($_GET['valor'])) && $_GET['valor'] == 'DESC') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset(($_GET['valor']))){
                                                        switch ($_GET['valor']) {
                                                            case "ASC":
                                                                echo "disabled";
                                                            break;
                                                            default:
                                                                
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span> Maior </span> 
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="dropdown-line dropdown-item-title"> Plataforma </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="form-check-input plataforma input-ps4" type="checkbox" value="1" name='plataforma'
                                            <?php
                                                if(isset(($_GET['plataforma'])) && $_GET['plataforma'] == '1') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset($_GET['plataforma'])){
                                                        switch ($_GET['plataforma']) {
                                                            case "2":
                                                                echo "disabled";
                                                            break;
                                                            case "3":
                                                                echo "disabled";
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span> PS4 </span> 
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="form-check-input plataforma input-xbox" type="checkbox" value="2" name='plataforma'
                                            <?php
                                                if(isset(($_GET['plataforma'])) && $_GET['plataforma'] == '2') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset(($_GET['plataforma']))){
                                                        switch ($_GET['plataforma']) {
                                                            case "1":
                                                                echo "disabled";
                                                            break;
                                                            case "3":
                                                                echo "disabled";
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span> XBOX </span> 
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="form-check-input plataforma input-pc" type="checkbox" value="3" name='plataforma'
                                            <?php
                                                if(isset(($_GET['plataforma'])) && $_GET['plataforma'] == '3') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset(($_GET['plataforma']))){
                                                        switch ($_GET['plataforma']) {
                                                            case "2":
                                                                echo "disabled";
                                                            break;
                                                            case "1":
                                                                echo "disabled";
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span> PC </span> 
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="dropdown-line dropdown-item-title"> Tipo </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="form-check-input tipo input-conta" type="checkbox" value="conta" name='tipo'
                                            <?php
                                                if(isset(($_GET['tipo'])) && $_GET['tipo'] == 'conta') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset($_GET['tipo'])){
                                                        switch ($_GET['tipo']) {
                                                            case "up":
                                                                echo "disabled";
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span> Conta </span> 
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="form-check-input tipo input-upgrade" type="checkbox" value="up" name='tipo'
                                            <?php
                                                if(isset(($_GET['tipo'])) && $_GET['tipo'] == 'up') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset($_GET['tipo'])){
                                                        switch ($_GET['tipo']) {
                                                            case "conta":
                                                                echo "disabled";
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span> Upgrade </span> 
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="submit-button-filter"  type="submit" value="Submit">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" class='filter-button filtrar-button'> FILTRAR </button>
                            <?php
                            if(isset($_GET['valor'])) {
                                echo "
                                    <a href='index.php'>
                                        <button type='button' class='filter-button'> LIMPAR FILTROS </button>
                                    </a>
                                ";
                            }
                            ?>
                        </div>
                    </form>
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
                                $classeTipoAnuncio = 'highlight-upgrade';
                            break;
                            case 'conta':
                                $anuncioTipo = 'CONTA';
                                $classeTipoAnuncio = 'highlight-conta';
                            break;
                        }
                        /* switch($anuncioPlat){
                            case 'PS4':
                                $platformColor = '#3777bf';
                            break;
                            case 'XBOX':
                                $platformColor = '#37bf90';
                            break;
                            case 'PC':
                                $platformColor = '#ff7c1f';
                            break;
                        } */
                        echo "
                        <div class='anuncio-box'>
                            <img src='imagens/$anuncioImagem' alt='Imagem'>
                            <div class='row-center'>
                                <h1>  $anuncioNome </h1>
                            </div>
                            <h4 id='anuncioDesconto'>R$ $anuncioDesconto</h4>
                            <div class='row-center'>
                                <h2>R$ $anuncioValor</h2>
                            </div>
                            <div class='row-center'>
                                <a href='product.php?id=$anuncioId' target='blank_'>
                                    <div class='see-more'>
                                        VER MAIS
                                    </div>
                                </a>
                            </div>
                            <div class='row-right anuncio-plataforma' >
                                <span class='$classeTipoAnuncio'> $anuncioTipo </span>
                                <span> $anuncioPlat </span>
                                
                            </div>
                        </div>";
                    endforeach;
                }  
            ?>
        </div>
        <?php
            if(!isset($_SESSION['anuncios'])){
                echo "
                <div class='without-anuncios'>
                    Não há anúncios.
                </div>
                <div class='space-100'></div>
                ";
            }  unset($_SESSION['anuncios']);
        ?>
        <div class="pagination-inputs-box">
                <div class="pagination-inputs">
                    <a href="<?php
                                if($page > 0 ){
                                    echo "index.php?".$urlToPagination."p=".$previousPage;
                                } else {
                                    echo "index.php";
                                }?>" class="pagination-input-previous">
                        <button type="button" class="pagination-button pagination-button-left"> ANTERIOR </button>
                    </a>
                    <a href="<?php 
                                if($page >= $totalNumPages - 1) {
                                    echo "index.php";
                                } else {
                                    echo "index.php?".$urlToPagination."p=".$nextPage;
                                }
                            ?>" class="pagination-input-next">
                        <button type="button" class="pagination-button pagination-button-right"> PRÓXIMA </button>
                    </a>
                </div>
        </div>
        <footer id="footer">
            <div class="container">
                <div class="footer-left footer-box">
                    <h3> Contato via E-mail </h3>
                    <h5><a href="mailto:contato@cezarmodz.com" target="blank_"> Contato comercial </a></h5>
                    <h5><a href="mailto:suporte@cezarmodz.com" target="blank_"> Suporte ao cliente </a></h5>
                </div>
                <div class="footer-right footer-box">
                    <h3> Redes sociais </h3>
                    <h5><a href="https://www.instagram.com/cezarmodz/?hl=pt-br" target="blank_"> Instagram </a></h5>
                    <h5><a href="https://www.facebook.com/CezarMods" target="blank_"> Facebook </a></h5>
                </div>
                <div class="footer-bottom  footer-box">
                    <h6> Todos direitos reservados </h6>
                    <h6> Desenvolvido por <a href="https://flow.page/adrianknapp" target="blank_">Adrian Knapp</a>  </h6>
                </div>
            </div>
        </footer>
    </section>

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
    <script type="text/javascript" src="assets/js/bootstrap.5.0.2.bundle.min.js"></script>
</body>
</html>