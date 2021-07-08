<?php
  session_start();
  require 'config.php';
  $token_key = $_GET['token_key'];

  if(isset($_POST['senha1']) && !empty($_POST['senha1'])) {
      if($_POST['senha1'] == $_POST['senha2']){
        $senha = md5($_POST['senha1']);

        $verificar = "
        SELECT * FROM
        user_password_reset
        WHERE
        token_key = '$token_key'
        ";
        $verificar = $pdo->query($verificar);


        if($verificar->rowCount() > 0) {
          foreach($verificar->fetchAll() as $dado):
            $userID = $dado['user_id'];
          endforeach;

        } else {
            echo "Não há mensagens.";
        }

        $sql_update_password = "
        UPDATE
          usuarios
        SET
          senha = '$senha'
        WHERE
          id = '$userID'
        LIMIT 1;
      ";
      $sql_update_password = $pdo->query($sql_update_password);

        $sql_expire_token = "
        UPDATE
          user_password_reset
        SET
          token_manual_expired = 1
        WHERE
          user_id = '$userID'
        ;
      ";
      $sql_expire_token = $pdo->query($sql_expire_token);
      header('Location: index.php');
      } else {
        $_SESSION['alertMsg'] = "";
      }

  } else {
    
  }


  if(isset($_GET['token_key']) && !empty($_GET['token_key'])) {
    $verificar_token = "
      SELECT * FROM
      user_password_reset
      WHERE
      token_key = '$token_key'
      AND 
      token_manual_expired = 0
      AND
      token_dt_expire > NOW();
    ";


    $verificar_token = $pdo->query($verificar_token);

    if($verificar_token->rowCount() > 0) {
      $_SESSION['valido'] = "";
    } else {
      $_SESSION['invalido'] = "";
    }

  } else {
    echo "Você está acessando uma página restrita.";
  }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mudar senha - CezarModz</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/styleHome.css">
    <link rel="stylesheet" href="assets/css/styleProduct.css">
    <link rel="stylesheet" href="assets/css/styleLogin.css">
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

                

                <form action="" method="POST" onsubmit="return validarCampos()" name="trocarSenha" id="login">
                    <?php
                        if (isset($_SESSION['valido'])) {
                            echo "
                            <h1> NOVA SENHA </h1> ";
                        }
                    ?>
                    <div class="row-center">
                        <h3 class="alert"> Alerta </h3>
                    </div>
                    <?php
                        if (isset($_SESSION['valido'])) {
                            echo "
                            <label for='senha1'> Nova senha: </label>
                            <input type='password'' name='senha1'class='text-area'>
        
                            <label for='senha2'> Repita a senha:  </label>
                            <input type='password' name='senha2' class='text-area'>
                            <div class='row-center'>
                            <input type='submit' value='TROCAR SENHA' class='login-button'>
                            </div>";
                            unset($_SESSION['valido']);
                        }
                    ?>
                    <?php
                        if (isset($_SESSION['invalido'])) {
                            echo "
                                <div class='row-center'>
                                <h1> TOKEN INVÁLIDO </h1>
                                </div> ";
                            unset($_SESSION['invalido']);
                        }
                    ?>
                    
                    
                    <div class="row-center final-login">
                        <a href="senhaRecorder.php">
                            <h4> Esqueci minha senha</h4>
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
    <script src="assets/js/trocarSenha.js"></script>
</body>
</html>