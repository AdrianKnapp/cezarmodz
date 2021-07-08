<?php
    require 'cadastrarUsuario.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se - CezarModz</title>
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
    <link rel="stylesheet" href="assets/css/styleHome.css">
    <link rel="stylesheet" href="assets/css/styleProduct.css">
    <link rel="stylesheet" href="assets/css/styleLogin.css">
    <link rel="stylesheet" href="assets/css/styleCadastro.css">
    <!-- FONT -->
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
    <section id="login">
        <div class="container">
            <div class="login-box">
                <h1> CADASTRE-SE </h1>
                <form action="cadastrarUsuario.php" method="POST" name="cadastrar" onsubmit="return validarCadastro()">
                    <div class="row-center">
                        <h3 class="alert"> Alerta </h3>
                    </div>
                    <?php
                        if (isset($_SESSION['emailExistente'])) {
                            echo "
                                <div class='row-center'>
                                    <h3 class='loginAlert'> Email já utilizado. </h3>
                                </div> ";
                            unset($_SESSION['emailExistente']);
                        }
                    ?>
                    <label for="cadastro-name"> Nome completo: </label>
                    <input type="text" name="cadastro-name" class="text-area" maxlength="50" pattern="[ a-zA-Z0-9]+">

                    <label for="num-celular"> Celular: </label>
                    <input type="tel" name="num-celular" class="text-area" maxlength="11" onkeyup="somenteNumeros(this)">

                    <label for="origem"> Onde nos conheceu: </label>
                    <select name='origem' class='selectOrigem' required>
                    <option class='option' value='Youtube'> Youtube </option>
                    <option class='option' value='Google'> Google </option>
                    <option class='option' value='Instagram'> Instagram </option>
                    <option class='option' value='Facebook'> Facebook </option>
                    <option class='option' value='Indicação'> Indicação </option>
                    </select>
                    <label for="cadastro-email"> E-mail: </label>
                    <input type="email" name="cadastro-email" class="text-area">

                    <label for="cadastro-pass"> Senha:  </label>
                    <input type="password" name="cadastro-pass" class="text-area">

                    <label for="second-cadastro-pass"> Repita a senha:  </label>
                    <input type="password" name="second-cadastro-pass" class="text-area">
                    <?php
                    if (isset($_GET['emailEnviado'])) {
                            echo "
                                <div class='row-center'>
                                    <h3 class='emailAlert'> Email de verificação enviado.</h3>
                                </div> ";
                        }
                    ?>
                    <div class="row-center">
                        <input type="submit" value="CADASTRAR" class="login-button">
                    </div>
                    <div class="row-center final-login">
                        <a href="login.php">
                            <h4> Já possiu um login? </h4>
                        </a>
                    </div>
                </form>
            </div>
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
                <a href="">
                    <img src="assets/img/youtube.svg" alt="" >
                </a>
            </div>
        </div>
        <div class="container credits">
            <h4> Todos os direitos reservados - CezarModz </h4>
            <h4> Desenvolvido por <a href="https://linktr.ee/adrianknapp" class='dev' target="_blank"> Adrian Knapp </a> </h4>
        </div>
    </footer>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/scriptMenu.js"></script>
    <script src="assets/js/validarCadastro.js"></script>
</body>
</html>