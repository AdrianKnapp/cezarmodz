<?php
if (!isset($_SESSION)) {
    session_start();
}
require "config.php";
if (isset($_POST["email"]) && !empty($_POST["email"])) {
    $email = $_POST["email"];
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $sql = $pdo->query($sql);

    if ($sql->rowCount() > 0) {
        foreach ($sql->fetchAll() as $usuario):
            $userID = $usuario["id"];
            $userName = $usuario["nome"];
            $CortarNome = explode(" ", $userName);
            $FirstName = $CortarNome[0];
            $userEmail = $usuario["email"];
            $senha = $usuario["senha"];
        endforeach;
        $token_key = mb_strimwidth(
            str_shuffle(
                "ABCDEFGHIJKLMNOPKRSTUVXZabcdefghijklmnopkrstuvxz1234567890"
            ),
            0,
            45
        );
        //$misturada = mb_strimwidth(str_shuffle($str),0,45);

        $sql_insert_token = "
        INSERT INTO
            user_password_reset
        SET
            user_id = '$userID',
            token_key = '$token_key',
            token_dt_expire = DATE_ADD(NOW(), INTERVAL 24 HOUR)
    ";
        $sql_insert_token = $pdo->query($sql_insert_token);

        $_SESSION["email"] = $userEmail;
        $_SESSION["nome"] = $FirstName;
        header("Location: email.php?token_key=$token_key");
    } else {
        $_SESSION["msg"] = "";
        header("Location: senhaRecorder.php");
    }
} else {
    $_SESSION["msg"] = "";
    header("Location: senhaRecorder.php");
}
?>
