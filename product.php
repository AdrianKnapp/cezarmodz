<?php
session_start();
require 'config.php';
require 'classes/usuarios.class.php';




if(isset($_GET['id']) && !empty($_GET['id'])){
    $produtoId = $_GET['id'];
    $_SESSION['produtoID'] = $produtoId;
    $buscarAnuncios = "
    SELECT
    pt.id_produto,
    pt.nome,
    pt.plataforma,
    pt.tipo,
    pt.valor,
    pt.link_insta,
    pt.descricao,
    pt.img_address,
    pf.id_plataforma,
    pf.nome_plat
    FROM produtos AS pt
    INNER JOIN plataformas AS pf
    ON pt.plataforma = pf.id_plataforma
    WHERE pt.id_produto = '$produtoId';
    ";
    $buscarAnuncios = $pdo->query($buscarAnuncios);
    if($buscarAnuncios->rowCount() >0){
        $_SESSION['anuncioExiste'] = '';
       
    } else {
        $_SESSION['anuncioInexiste'] = '';
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>Produto - CezarModz</title>
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
    <?php
        if(isset($_SESSION['logado'])) {
            echo "<input type='hidden' value='bG9nYWRv' id='log'>";
            $usuarios = new Usuarios($pdo);
            $usuarios->setUsuario($_SESSION['logado']);
            $userID = $_SESSION['logado'];
            $buscarUsuarios = "SELECT nome, email FROM usuarios WHERE id = $userID";
            $buscarUsuarios = $pdo->query($buscarUsuarios);
            if($buscarUsuarios->rowCount() > 0){
                $usuario = $buscarUsuarios->fetch();
                $nome = $usuario['nome'];
                $email = $usuario['email'];
                $_SESSION['userEmail'] = $email;
            }
        } else {
            echo "<input type='hidden' value='ZGVzY29uZWN0YWRv' id='log'>";
        }
    ?>
    <div class="space-100"></div>
    <section id="product">
        <div class="container">
            <div class="cima">
                
                <?php 
                    if(isset($_SESSION['anuncioExiste'])){
                        foreach($buscarAnuncios->fetchAll() AS $anuncio):
                            $anuncioId = $anuncio['id_produto'];
                            $anuncioNome = $anuncio['nome'];
                            $anuncioPlat = $anuncio['nome_plat'];
                            $anuncioImagem = $anuncio['img_address'];
                            $anuncioTipo = $anuncio['tipo'];
                            $anuncioValor = $anuncio['valor'];
                            $anuncioDesc = $anuncio['descricao'];
                            $anuncioLink = $anuncio['link_insta'];
                            $porcentagem =  20 / 100 * $anuncioValor;
                            $anuncioDesconto = $anuncioValor + $porcentagem;
                            $anuncioDesc = explode(', ', $anuncioDesc);
                            switch($anuncioTipo){
                                case 'up':
                                    $tipo = "UPGRADE";
                                break;
                                case 'conta':
                                    $tipo = "CONTA";
                                break;
                            }


                            echo "
                                <div class='left-cima'>
                                    <img class='product-img' src='imagens/$anuncioImagem' alt=''>
                                </div>
                                <div class='right-cima'>
                                <h1> $tipo $anuncioNome </h1>
                                <div class='row plataform'>
                                    <h3>
                                        $anuncioPlat
                                    </h3>
                                </div>
                                <h3> $anuncioDesconto R$ </h3>
                                <h2> $anuncioValor R$ </h2>
                                
                                ";
                                $_SESSION['valor'] = $anuncioValor;
                                $_SESSION['id'] = $anuncioId;
                                ?>
                                <div class='row-center'>
                                        <div type='submit' class='comprar-button'>
                                            COMPRAR
                                        </div>
                                </div>
                                <form action="processarPagamento.php" method="POST" class='formPagamento'>
                                        <script
                                            src="https://www.mercadopago.com.br/integrations/v1/web-tokenize-checkout.js"
                                            data-public-key="TEST-7cbaf9d8-1e86-4c41-88a5-bd12af3a7334"
                                            data-transaction-amount="<?php echo $anuncioValor; ?>">
                                        </script>
                                </form>
                                <div class='row-center'>
                                    <div class='info'>
                                        <h2> ITENS CONTIDOS </h2>
                                        <ul>
                                        <?php
                                            for ($i=0; $i<sizeof($anuncioDesc); $i++) {
                                                echo "
                                                    <li> $anuncioDesc[$i] </li>   
                                                ";
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                                
                                <?php
                        endforeach;
                    }
                    if(isset($_SESSION['anuncioInexiste'])){
                        echo '
                            <div class="row-center">
                                <h2> Anúncio não existe. </h2>
                            </div>
                        ';
                    }
                        unset($_SESSION['anuncioInexiste']);
                    
                    ?>
                </div>
            </div>
            <div class="row-center">
                <div class="baixo">
                    <h4 class='link'>         
                                    Veja mais no <a href="<?php echo $anuncioLink ?>" target="_blank">instagram </a> 
                    </h4>
                    <div class="row-center">
                    <h1 class='titleFaq'> ATENÇÃO LEIA </h1>
                    </div>
                    <div class="faq">
                        <?php
                            switch($anuncioPlat){
                                case 'PS4':
                                    $faq = "
                                        <h1> 1. Para adquirir uma conta é preciso ter o jogo? </h1>
                                        <h2>
                                            Sim, a conta não inclui o jogo. Ou seja, o comprador necessita já ter o jogo comprado.
                                        </h2>
                                        <h1> 2. A conta possui PSN PLUS? </h1>
                                        <h2>
                                            Não, a conta não possui PSN PLUS?
                                        </h2>
                                        <h1> 3. Como saber o que a conta possui? </h1>
                                        <h2>
                                            Tudo que a conta possui está no descritivo. Se não está no descritivo, a conta não possui!
                                        </h2>
                                        <h1> 4. Existe algum risco de BAN ao comprar um conta? </h1>
                                        <h2>
                                            Não, as contas são 100% seguras!
                                        </h2>
                                        <h1> 5. Como irei receber os dados para acessar a conta? </h1>
                                        <h2>
                                            Ao estar cadastrado no site, o endereço de E-mail vinculado a sua conta receberá um E-mail com os dados de acesso e também as instruções de segurança para alteração dos dados da conta após a confirmação da compra.
                                        </h2>
                                        <h1> 6. Realizei a compra. Porém não consigo acessar a conta, como proceder? </h1>
                                        <h2>
                                            Para evitar problemas, iremos verificar no E-mail da conta se houve alguma alteração de ID ou senha. Caso não conste nada, haverá um contato direto com o cliente para resolvermos o problema.
                                        </h2>
                                        <h1> 7. Como funciona o pós venda? </h1>
                                        <h2>
                                            No mesmo E-mail onde você receberá os dados de acesso, estará o link de acesso ao nosso Whatsapp, dessa forma você terá um contato direto conosco.
                                        </h2>
                                        <h1> 8. ATENÇAO </h1>
                                        <h2>
                                            Confirme a plataforma antes de efetuar a compra! Pois não há reembolso para compra de produto de plataforma diferente da sua!
                                        </h2>
                                        ";
                                break;
                                case 'XBOX':
                                    $faq = "
                                        <h1> 1. Para adquirir uma conta é preciso ter o jogo? </h1>
                                        <h2>
                                            Sim, a conta não inclui o jogo. Ou seja, o comprador necessita já ter o jogo comprado.
                                        </h2>
                                        <h1> 2. A conta possui LIVE GOLD? </h1>
                                        <h2>
                                            Não, a conta não possui LIVE GOLD?
                                        </h2>
                                        <h1> 3. Como saber o que a conta possui? </h1>
                                        <h2>
                                            Tudo que a conta possui está no descritivo. Se não está no descritivo, a conta não possui!
                                        </h2>
                                        <h1> 4. Existe algum risco de BAN ao comprar um conta? </h1>
                                        <h2>
                                            Não, as contas são 100% seguras!
                                        </h2>
                                        <h1> 5. Como irei receber os dados para acessar a conta? </h1>
                                        <h2>
                                            Ao estar cadastrado no site, o endereço de E-mail vinculado a sua conta receberá um E-mail com os dados de acesso e também as instruções de segurança para alteração dos dados da conta após a confirmação da compra.
                                        </h2>
                                        <h1> 6. Realizei a compra. Porém não consigo acessar a conta, como proceder? </h1>
                                        <h2>
                                            Para evitar problemas, iremos verificar no E-mail da conta se houve alguma alteração de ID ou senha. Caso não conste nada, haverá um contato direto com o cliente para resolvermos o problema.
                                        </h2>
                                        <h1> 7. Como funciona o pós venda? </h1>
                                        <h2>
                                            No mesmo E-mail onde você receberá os dados de acesso, estará o link de acesso ao nosso Whatsapp, dessa forma você terá um contato direto conosco.
                                        </h2>
                                        <h1> 8. ATENÇAO </h1>
                                        <h2>
                                            Confirme a plataforma antes de efetuar a compra! Pois não há reembolso para compra de produto de plataforma diferente da sua!
                                        </h2>
                                        <h3>
                                            OBS: Para evitar problemas de possível fraude e garantir a segurança para o cliente, as contas possuem um código de verificação para troca das informações da conta, sendo assim, após a compra entraremos em contato com o cliente para auxiliar na troca das informações e fornecer o código! 
                                        </h3>
                                    ";
                                break;
                                case 'PC':
                                    $faq = "
                                        <h1> 1. Para adquirir uma conta é preciso ter o jogo? </h1>
                                        <h2>
                                            Sim, a conta não inclui o jogo. Ou seja, o comprador necessita já ter o jogo comprado.
                                        </h2>
                                        <h1> 2. Como saber o que a conta possui? </h1>
                                        <h2>
                                            Tudo que a conta possui está no descritivo. Se não está no descritivo, a conta não possui!
                                        </h2>
                                        <h1> 3. Existe algum risco de BAN ao comprar um conta? </h1>
                                        <h2>
                                            Não, as contas são 100% seguras!
                                        </h2>
                                        <h1> 4. Como irei receber os dados para acessar a conta? </h1>
                                        <h2>
                                            Ao estar cadastrado no site, o endereço de E-mail vinculado a sua conta receberá um E-mail com os dados de acesso e também as instruções de segurança para alteração dos dados da conta após a confirmação da compra.
                                        </h2>
                                        <h1> 5. Realizei a compra. Porém não consigo acessar a conta, como proceder? </h1>
                                        <h2>
                                            Para evitar problemas, iremos verificar no E-mail da conta se houve alguma alteração de ID ou senha. Caso não conste nada, haverá um contato direto com o cliente para resolvermos o problema.
                                        </h2>
                                        <h1> 6. Como funciona o pós venda? </h1>
                                        <h2>
                                            No mesmo E-mail onde você receberá os dados de acesso, estará o link de acesso ao nosso Whatsapp, dessa forma você terá um contato direto conosco.
                                        </h2>
                                        <h1> 7. ATENÇAO </h1>
                                        <h2>
                                            Confirme a plataforma antes de efetuar a compra! Pois não há reembolso para compra de produto de plataforma diferente da sua!
                                        </h2>
                                        <h3>
                                            OBS: Para evitar problemas de possível fraude e garantir a segurança para o cliente, as contas possuem um código de verificação para troca das informações da conta, sendo assim, após a compra entraremos em contato com o cliente para auxiliar na troca das informações e fornecer o código! 
                                        </h3>
                                    ";
                                break;
                            }
                            switch($anuncioTipo){
                                case 'up':
                                    $faq = "
                                    <div class='row-center'>
                                    <h1 class='titleFaq titleUpgrade'> PARA O UPGRADE DE PS4 E XBOX ONE: </h1>
                                    </div>
                                    <h2> 
                                        - Não é possível aumentar level. 
                                    </h2>
                                    <h2>
                                        - Não fazemos trajes.
                                    </h2>
                                    <h2>
                                        - Não é possível adicionar dinheiro direto na sua conta!
                                    </h2>
                                    <h1> 
                                        O UP consiste em adicionar os carros na conta do cliente, para que o cliente consiga o valor contratado ele mesmo vai vendendo os carros recomendação de 3 carros por dia, até que se venda todos e obtenha a quantia contratada! 
                                    </h1>
                                    <h2>
                                        - Não é possível fazer por outro método apenas por esse que inclui os carros! 
                                    </h2>
                                    <h2>
                                        - É necessário que ao realizar a compra receber o E-mail com o WhatsApp da nossa equipe o cliente entre em contato com a gente para informar os dados de acesso da conta dele e ser informado sobre o dia do UP!
                                    </h2>
                                    <h2>
                                        - Caso a sua conta possui duas etapas ou algum tipo de trava de segurança, por favor remova, pois não iremos aceitar atrasos em nossos agendamentos por conta dessas travas!
                                    </h2>
                                    <h2>
                                        - Caso a senha da conta esteja errada, iremos informar o cliente e remarcaremos para o próximo dia disponível
                                    </h2>
                                    <div class='row-center'>
                                        <h1 class='titleFaq titleUpgrade'> PARA O UPGRADE DE PC: </h1>
                                    </div>
                                    <h1> 1. Para adquirir uma conta é preciso ter o jogo? </h1>
                                    <h2>
                                        Sim, a conta não inclui o jogo. Ou seja, o comprador necessita já ter o jogo comprado.
                                    </h2>
                                    <h1> 2. O UP inclui aumento de level? </h1>
                                    <h2>
                                        Sim, Após a compra o cliente ire receber um E-mail com nosso link de WhatsApp por lá pode nos informar qual level ele deseja na sua conta. Para aumento de level apenas disponível no PC.
                                    </h2>
                                    <h1> 3. Existe algum risco de BAN ao UPAR a minha conta? </h1>
                                    <h2>
                                        Não, todos os métodos que utilizamos foram exaustivamente testados pela nossa equipe, e possuímos contas de teste para avaliar os riscos dos diferentes métodos. E também pedimos que o cliente seja moderado ao usar o dinheiro que foi adicionado!
                                    </h2>
                                    <h1> 4. Como funciona o UP?</h1>
                                    <h2>
                                        Adicionamos os itens do pacote com MOD MENU pago na conta do cliente.
                                        A opção de MOD MENU está apenas disponível para o PC. não existe MOD MENU para console! 
                                    </h2>
                                    <h1> 5. Quais dados preciso fornecer ao comprar um UP com a CezarModz?</h1>
                                    <h2>
                                        Ao comprar o UP para sua conta, você irá receber um e-mail com as devidas instruções. Os dados que iremos precisar são: E-mail e senha da conta que deseja upar e informar pro qual launcher ele joga, podendo ser Rockstar Launcher, STEAM ou Epic Games.
                                    </h2>
                                    <h1> 6. Como irei saber o dia do UP na minha conta? </h1>
                                    <h2>
                                        Após a realização da compra será enviado um E-mail informando o Whatsapp da nossa equipe. Ao entrar em contato, informaremos para qual dia o UP foi agendado.
                                    </h2>
                                    <h1> 7. ATENÇAO </h1>
                                        <h2>
                                            Confirme a plataforma antes de efetuar a compra! Pois não há reembolso para compra de produto de plataforma diferente da sua!
                                        </h2>
                                    ";
                                break;
                            }
                            echo $faq;
                        ?>
                        
                    </div>
                </div>
            </div>
            <div class="space-100"></div>
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
    <script src="assets/js/product.js"></script>
</body>
</html>
