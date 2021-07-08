<?php
  session_start();
  require 'loader.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de senha - CezarModz</title>
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
    <link rel="stylesheet" href="assets/css/styleSenhaR.css">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <?php
            require 'menu.php';
        ?>
    </header>
    <div class="space-100"></div>
    <section id="login">
        <div class="container">
            <div class="login-box">

                <h1> RECURAR SENHA </h1>

                <form action="RecorderProcess.php" method="POST" onsubmit="return VerificarCampos()" name="recSenha" id="login">
                    <div class="row-center">
                        <h3 class="alert"> Alerta </h3>
                    </div>
                    <?php
                        if (isset($_SESSION['msg'])) {
                            echo "
                                <div class='row-center'>
                                    <h3 class='loginAlert'> Email inválido. </h3>
                                </div> ";
                        }
                        unset($_SESSION['msg']);
                    ?>
                   
                    <label for="email"> E-mail: </label>
                    <input type="email" name="email" class="text-area" id="campo">
                    <?php
                        if (isset($_GET['sucefull'])) {
                            echo "
                                <div class='row-center'>
                                    <h3 class='loginAlert sucefull'>Seu email foi enviado! </h3>
                                </div> ";
                            session_destroy();
                        }
                    ?>
                    <div class="row-center">
                        <input type="submit" value="RECEBER EMAIL" class="login-button">
                    </div>
                    
                    <div class="row-center final-login">
                        <a href="login.php">
                            <h4> Já possui um login? </h4>
                        </a>
                        <a href="cadastro.php">
                            <h4> Não possui login? </h4>
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
    <script src="assets/js/recuperarSenha.js"></script>
</body>
</html>