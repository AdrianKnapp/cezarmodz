<?php
    session_start();
    require '../config.php';
    require 'class/usuarios.class.php';
    if(isset($_POST['email']) && !empty($_POST['pass'])) {
        $email = addslashes($_POST['email']);
        $pass = md5($_POST['pass']);
        $usuarios = new Usuarios($pdo);

        if($usuarios->fazerLogin($email, $pass)) {
            header('Location: index.html');
        } else {
            $_SESSION['alertMsg'] = "";
            header("Location: login.php");
            exit;
        }
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login | Admin </title>
    <!-- CSS -->
    <link rel="stylesheet" href="admin-css/bootstrap.4.5.min.css">
    <link rel="stylesheet" href="admin-css/login.css">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="57x57" href="../assets/img/icon/apple-icon-57x57.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="60x60" href="../assets/img/icon/apple-icon-60x60.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/img/icon/apple-icon-72x72.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/icon/apple-icon-76x76.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/img/icon/apple-icon-114x114.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/icon/apple-icon-120x120.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/img/icon/apple-icon-144x144.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="152x152" href="../assets/img/icon/apple-icon-152x152.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/icon/apple-icon-180x180.png" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="192x192"  href="../assets/img/icon/android-icon-192x192.png" type="image/x-icon" /> 
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/icon/favicon-32x32.png" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/img/icon/favicon-96x96.png" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/icon/favicon-16x16.png" type="image/x-icon" />
    <link rel="manifest" href="../assets/img/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ff781e">
    <meta name="msapplication-TileImage" content="../assets/img/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ff781e">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="box flex-column d-flex align-items-center">
            <img src="../assets/img/LogoCezar5.png" alt="">
            <h3 class="h3"> LOGIN | ADMIN </h3>
            <form action="" method="POST" class="d-flex flex-column justify-content-center align-items-center w-75">
                <label for="" class="w-100"> E-mail: </label>
                <input type="email" name="email" class="w-100">
                <label for="" class="w-100"> Senha: </label>
                <input type="password" name="pass" class="w-100">
                <input type="submit" value="FAZER LOGIN" class="btn">
            </form>
        </div>
    </div>









    <script src="admin-js/jquery.3.5.1.js"></script>
    <script src="admin-js/bootstrap.bundle.4.5.min.js"></script>
</body>
</html>