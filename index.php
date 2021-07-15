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
        break;
    case 1:
        $previousPage = $page - 1;
        break;
}

if(isset($_GET['p'])){
    $page = $_GET['p']; // pegar a paginação.
    $nextPage = $page + 1;
}


if($page == 0) {
    $linesToQuery = 10 * 0;
} else {
    $linesToQuery = 10 * $page;
}

$query = new Query($pdo, $linesToQuery);
$structureOfQuery = '';
$dbTotalLines =  $query->queryToCountDbDataLines($structureOfQuery);
$totalNumPages = floor($dbTotalLines / 10);

if(isset($_GET['valor']) || isset($_GET['plataforma']) || isset($_GET['tipo'])) {
    $getsAtUrl = explode("?", $presentUrl);
    $getsAtUrl = explode("&", $getsAtUrl[1]);
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
        $structureOfQuery = "
        WHERE pt.plataforma = $plat
        AND pt.disponibilidade = 0
        AND pt.tipo = '$tipo'
        ORDER BY pt.valor $val
        ";
        if($query->queryFilter($structureOfQuery)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structureOfQuery);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structureOfQuery);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($plat != '' && $val != ''){
        $structureOfQuery = "
        WHERE pt.plataforma = $plat
        AND pt.disponibilidade = 0
        ORDER BY pt.valor $val
        ";
        if($query->queryFilter($structureOfQuery)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structureOfQuery);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structureOfQuery);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($plat != '' && $tipo != ''){
        $structureOfQuery = "
        WHERE pt.plataforma = $plat
        AND pt.disponibilidade = 0
        AND pt.tipo = '$tipo'
        ";
        if($query->queryFilter($structureOfQuery)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structureOfQuery);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structureOfQuery);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($val != '' && $tipo != ''){
        $structureOfQuery = "
        WHERE pt.disponibilidade = 0
        AND pt.tipo = '$tipo'
        ORDER BY pt.valor $val
        ";
        if($query->queryFilter($structureOfQuery)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structureOfQuery);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structureOfQuery);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($plat != ''){
        $structureOfQuery = "
            WHERE pt.plataforma = $plat
            AND pt.disponibilidade = 0
        ";
        if($query->queryFilter($structureOfQuery)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structureOfQuery);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structureOfQuery);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($val != ''){
        $structureOfQuery = "
            WHERE pt.disponibilidade = 0
            ORDER BY pt.valor $val
        ";
        if($query->queryFilter($structureOfQuery)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structureOfQuery);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structureOfQuery);
            $_SESSION['anuncios'] = '';
        } else {
            $_SESSION['alertaAnuncio'] = '';
        }
    } else if($tipo != ''){
        $structureOfQuery = "
            WHERE pt.tipo = '$tipo'
            AND pt.disponibilidade = 0
        ";
        if($query->queryFilter($structureOfQuery)){
            $dbTotalLines =  $query->queryToCountDbDataLines($structureOfQuery);
            $totalNumPages = ceil($dbTotalLines / 10);
            $buscarAnuncios = $query->queryFilter($structureOfQuery);
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

if(isset($getsAtUrl)) {
    if(isset($getsAtUrl[2])) {
        $urlToPagination = $getsAtUrl[0]."&".$getsAtUrl[1]."&".$getsAtUrl[2]."&";
    } else if(isset($getsAtUrl[1])) {
        $urlToPagination = $getsAtUrl[0]."&".$getsAtUrl[1]."&";
    } else if(isset($getsAtUrl[0])) {
        $urlToPagination = $getsAtUrl[0]."&";
    } 

} else {
    $urlToPagination = "";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Início </title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/variaveis-globais.css">
    <link rel="stylesheet" href="assets/css/styleHome.css">
    <link rel="stylesheet" href="assets/css/bootstrap.5.0.2.min.css">
    <link rel="stylesheet" href="assets/css/menu.css">
    <!-- JQUERY -->
    <script type="text/javascript" src="assets/js/jquery.js"></script>
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
    <section id="banner-section">
        <div class="container">
            <div class="banner-box">
                BANNER
            </div>
        </div>
    </section>
    <section id="store">
        <main class="container">
            <div class="row-left" style="display: flex; flex-direction:column">
                <div class="filter">
                    <form method='GET' action="index.php?p=<?php echo $page.$urlToPagination;?>">
                        <input type="checkbox" class="inputs-form-filter" name="valor"  value="" id="inputs-form-filter-valor"
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
                            ?>>
                        <input type="checkbox" class="inputs-form-filter" name="plataforma" value="" id="inputs-form-filter-plataforma"
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
                            ?>>
                        
                        <input type="checkbox" class="inputs-form-filter" name="tipo" value="" id="inputs-form-filter-tipo"
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
                                <button class="filter-button dropdown-toggle button-dropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    ORDENAR POR
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-line dropdown-item-title"> Preço </li>
                                    <li>
                                        <label class="dropdown-line dropdown-line-item label-with-hover-function label-menor">
                                            <input class="form-check-input preco input-menor" type="checkbox" value="ASC" name='valor' id='input-menor'
                                            <?php
                                                if(isset(($_GET['valor'])) && $_GET['valor'] == 'ASC') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset(($_GET['valor']))){
                                                        switch ($_GET['valor']) {
                                                            case "DESC":
                                                                /* echo "disabled"; */
                                                            break;
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span id='span-for-input-menor'> Menor </span> 
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-line dropdown-line-item label-with-hover-function label-maior">
                                            <input class="form-check-input preco input-maior" type="checkbox" value="DESC" name='valor'
                                            <?php
                                                if(isset(($_GET['valor'])) && $_GET['valor'] == 'DESC') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset(($_GET['valor']))){
                                                        switch ($_GET['valor']) {
                                                            case "ASC":
                                                                /* echo "disabled"; */;
                                                            break;
                                                            default:
                                                                
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span id='span-for-input-maior'> Maior </span> 
                                        </label>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="dropdown-line dropdown-item-title"> Plataforma </li>
                                    <li>
                                        <label class="dropdown-line dropdown-line-item label-with-hover-function label-ps4">
                                            <input class="form-check-input plataforma input-ps4" type="checkbox" value="1" name='plataforma'
                                            <?php
                                                if(isset(($_GET['plataforma'])) && $_GET['plataforma'] == '1') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset($_GET['plataforma'])){
                                                        switch ($_GET['plataforma']) {
                                                            case "2":
                                                                /* echo "disabled"; */;
                                                            break;
                                                            case "3":
                                                                /* echo "disabled"; */;
                                                            break;
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span id='span-for-input-ps4'> PS4 </span> 
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-line dropdown-line-item label-with-hover-function label-xbox">
                                            <input class="form-check-input plataforma input-xbox" type="checkbox" value="2" name='plataforma'
                                            <?php
                                                if(isset(($_GET['plataforma'])) && $_GET['plataforma'] == '2') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset(($_GET['plataforma']))){
                                                        switch ($_GET['plataforma']) {
                                                            case "1":
                                                                /* echo "disabled"; */;
                                                            break;
                                                            case "3":
                                                                /* echo "disabled"; */;
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span id='span-for-input-xbox'> XBOX </span> 
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-line dropdown-line-item label-with-hover-function label-pc">
                                            <input class="form-check-input plataforma input-pc" type="checkbox" value="3" name='plataforma'
                                            <?php
                                                if(isset(($_GET['plataforma'])) && $_GET['plataforma'] == '3') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset(($_GET['plataforma']))){
                                                        switch ($_GET['plataforma']) {
                                                            case "2":
                                                                /* echo "disabled"; */;
                                                            break;
                                                            case "1":
                                                                /* echo "disabled"; */;
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span id='span-for-input-pc'> PC </span> 
                                        </label>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="dropdown-line dropdown-item-title"> Tipo </li>
                                    <li>
                                        <label class="dropdown-line dropdown-line-item label-with-hover-function label-conta">
                                            <input class="form-check-input tipo input-conta" type="checkbox" value="conta" name='tipo'
                                            <?php
                                                if(isset(($_GET['tipo'])) && $_GET['tipo'] == 'conta') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset($_GET['tipo'])){
                                                        switch ($_GET['tipo']) {
                                                            case "up":
                                                                /* echo "disabled"; */;
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span id='span-for-input-conta'> Conta </span> 
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-line dropdown-line-item label-upgrade">
                                            <input class="form-check-input tipo input-upgrade" type="checkbox" value="up" name='tipo'
                                            <?php
                                                if(isset(($_GET['tipo'])) && $_GET['tipo'] == 'up') {
                                                    echo 'checked';
                                                } else {
                                                    if(isset($_GET['tipo'])){
                                                        switch ($_GET['tipo']) {
                                                            case "conta":
                                                                /* echo "disabled"; */;
                                                            break;
                                                            default:
                                                        }
                                                    }
                                                }
                                            ?>>
                                            <span id='span-for-input-upgrade'> Upgrade </span> 
                                        </label>
                                    </li>
                                    <li>
                                        <div class="dropdown-line dropdown-line-item">
                                            <input class="submit-button-filter" onsubmit="return checkEmptyCheckbox()" type="submit" value="Submit">
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
                            echo "
                            <div class='anuncio-box'>
                                <!-- <img src='imagens/$anuncioImagem' alt='Imagem'> -->
                                <div class='image-template-box'> IMAGE </div>
                                <div class='row-center'>
                                    <h1>  $anuncioNome </h1>
                                </div>
                                <h4>R$ $anuncioDesconto</h4>
                                <div class='row-center'>
                                    <h2>R$ $anuncioValor</h2>
                                </div>
                                <div class='row-center'>
                                    <a href='product.php?id=$anuncioId' target='blank_' class='see-more-link'>
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
                    <div class="box-between-pagination-buttons">
                        <span><?php echo $page+1;?></span> de <span><?php echo $totalNumPages;?></span>
                    </div>
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
        </main>
    </section>


    <script type="text/javascript" src="assets/js/scriptMenu.js"></script>
    <script type="text/javascript" src="assets/js/home.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.5.0.2.bundle.min.js"></script>
</body>
</html>