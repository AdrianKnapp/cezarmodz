<?php
    session_start();
    require '../config.php';

    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = addslashes($_POST['email']);
        $senha = addslashes(md5($_POST['pass']));

        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' AND permissoes = 'ADM'";
        $sql = $pdo->query($sql);
        
        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $_SESSION['logado'] = $sql['id'];
            echo $sql['id'];
        } else {
            echo 'n foi';
        }
    }
?>