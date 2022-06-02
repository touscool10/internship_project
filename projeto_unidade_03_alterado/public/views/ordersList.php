<?php require_once("../../connection/connection.php"); ?>

<?php
    // iniciar variavel de sessão
    session_start();

    // restringir acesso
    if (!isset($_SESSION["user_portal"])) {
        header("Location: login.php");
    }


//-------Consultar usuário-------

    $userConsult = "SELECT * FROM clientes WHERE clienteID = {$_SESSION["user_portal"]}";
    $userConsult = mysqli_query($connection, $userConsult);
    if(!$userConsult) {
        die('User Failed to connect to database');
    }
    $user = mysqli_fetch_assoc($userConsult);

    if ($user["nivel"] == "user") {
        $nivel = 0;
    } else {
        $nivel = 1;
    }

    setlocale(LC_ALL, 'pt_BR');


//-------Verificar permissao do usuario-------

if ($nivel == 0 && !isset($_GET["clienteID"])) {
    Header("Location: userDashboard.php");
} 
elseif(isset($_GET["clienteID"])) {

    $clienteID = $_GET["clienteID"];


//-------Consultar dados do cliente-------

    $clienteConsult = "SELECT nomecompleto ";
    $clienteConsult .= " FROM clientes ";
    $clienteConsult .= " WHERE clienteID = {$clienteID}";
    $clienteConnect = mysqli_query($connection, $clienteConsult);
    if(!$clienteConnect) {

        die('cliente Failed to connect to database');
    }
    $cliente = mysqli_fetch_assoc($clienteConnect);


//-------Consultar cliente anterior e posterior-------

    // ID Menor
    $clienteIDMenorConsult = "SELECT clienteID FROM clientes WHERE clienteID < {$clienteID} ORDER BY clienteID DESC LIMIT 1";
    $clienteIDMenorConnect = mysqli_query($connection, $clienteIDMenorConsult);
    if(!$clienteIDMenorConnect) {
        die('clienteIDMenorConnect Failed to connect to database');
    }
    $clienteIDMenor = mysqli_fetch_assoc($clienteIDMenorConnect);

    // ID Maior
    $clienteIDMaiorConsult = "SELECT clienteID FROM clientes WHERE clienteID > {$clienteID} ORDER BY clienteID ASC LIMIT 1";
    $clienteIDMaiorConnect = mysqli_query($connection, $clienteIDMaiorConsult);
    if(!$clienteIDMaiorConnect) {
        die('clienteIDMaiorConnect Failed to connect to database');
    }
    $clienteIDMaior = mysqli_fetch_assoc($clienteIDMaiorConnect);


//-------Consultar pedidos do cliente-------

    $ordersConsult = "SELECT * ";
    $ordersConsult .= " FROM pedidos ";
    $ordersConsult .= " WHERE clienteID = {$clienteID} ";
    $orders = mysqli_query($connection, $ordersConsult);
    if(!$orders) {
        die('orders Failed to connect to database');
    }

} else {
    $ordersConsult = "SELECT * ";
    $ordersConsult .= " FROM pedidos ";
    $orders = mysqli_query($connection, $ordersConsult);
    if(!$orders) {
        die('orders Failed to connect to database');
    }

}



//-------COnsultar todos os clientes-------

    $clientesConsult = "SELECT * ";
    $clientesConsult .= " FROM clientes ";
    $clientes = mysqli_query($connection, $clientesConsult);
    if(!$clientes) {
        die('clientes failed to connect to database');
    } 
    
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/orders.css">

</head>
<body>
    <header>
        <?php include_once("../include/header.php"); ?>
        <?php include_once("../include/funcoes.php"); ?>
    </header>

    <main>
        <?php include_once("../include/navbar.php"); ?>
        <section class="content">
            <div class="contentTitle">
                <div class="seta-esq">
                    <?php
                        if(isset($clienteIDMenor)) {?>
                            <a href="ordersList.php?clienteID=<?php echo $clienteIDMenor["clienteID"]?>"><img class="seta" src="../images/seta-direita.png" alt=""></a>
                    <?php }
                    ?>
                </div>
                <?php if(isset($clienteID)) {
                        echo '<h2>' . $cliente["nomecompleto"] . '</h2>';
                    } ?>
                <?php if(isset($clienteIDMaior)) {?>
                    <div class="seta-dir">
                        <a href="ordersList.php?clienteID=<?php echo $clienteIDMaior["clienteID"] ?>"><img class="seta" src="../images/seta-direita.png" alt=""></a>
                    </div>
            <?php } ?>
            </div>
            
            <div class="orders">
                <div class="ordersList">
                    <?php                       
                        if( mysqli_num_rows($orders) == 0){
                            echo '<h3 class="nped">Não há pedidos para esse cliente</h3>';
                        }else{  
                            while ($row = mysqli_fetch_assoc($orders)) { 
                                ?>
                                <div class="order" id="<?php echo "order" . $row["pedidoID"]?>">
                                    <div class="orderTitle">
                                        <h3>Pedido nº <?php echo $row["pedidoID"]?></h3>
                                        <a href="ordersUpdate.php?pedidoID=<?php echo $row["pedidoID"]?>">
                                            <img src="../images/edit.png" alt="">
                                        </a>
                                    </div>
                                    <ul class="orderContent">
                                        <li><h4>Cliente: </h4><?php 
                                            $nomeConsult = "SELECT nomecompleto FROM clientes WHERE clienteID = {$row["clienteID"]}";
                                            $nome = mysqli_fetch_assoc(mysqli_query($connection, $nomeConsult));
                                            
                                            if ( !isset($nome["nomecompleto"]) ) {
                                                echo "Cliente não existe!";
                                            } else {
                                                echo utf8_encode($nome["nomecompleto"]);
                                            }

                                            
                                        ?></li>
                                        <li><h4>Transportadora: </h4><?php 
                                            $transportadoraConsult = "SELECT nometransportadora FROM transportadoras WHERE transportadoraID = {$row["transportadoraID"]}";
                                            $transportadora = mysqli_fetch_assoc(mysqli_query($connection, $transportadoraConsult));
                                            //echo $transportadora['nometransportadora'];
                                            echo utf8_encode( $transportadora['nometransportadora'] );
                                        ?></li>
                                        <li><h4>Data Pedido: </h4><?php echo formatDateOuput($row["data_pedido"])?></li>
                                        <li><h4>Data Entrega: </h4><?php echo formatDateOuput($row["data_entrega"])?></li>
                                        <li><h4>Data Saída: </h4><?php echo formatDateOuput($row["data_saida"])?></li>
                                        <li><h4>Valor Pedido: </h4><?php echo $row["valor_pedido"]?></li>
                                        <li><h4>Status Pedido: </h4><?php 
                                            $statusConsult = "SELECT nomestatus FROM pedidos_status WHERE statusID = {$row["status_pedido"]}";
                                            $status = mysqli_fetch_assoc(mysqli_query($connection, $statusConsult));
                                            echo $status['nomestatus'];
                                        ?></li>
                                        <li><h4>Conhecimento Frete: </h4><?php echo $row["conhecimento"]?></li>
                                    </ul>
                                </div>
                                <?php
                                    if($row["status_pedido"] == 1) { ?>
                                        <script>
                                            document.styleSheets[1].addRule('<?php echo "#order" . $row["pedidoID"]?>', 'background-color:#85e085');
                                        </script>
                                    <?php 
                                    } elseif($row["status_pedido"] == 2) { ?>
                                        <script>
                                            document.styleSheets[1].addRule('<?php echo "#order" . $row["pedidoID"]?>', 'background-color:#ffd633');
                                        </script>
                                    <?php 
                                    } elseif($row["status_pedido"] == 3 || $row["status_pedido"] == 4) { ?>
                                        <script>
                                            document.styleSheets[1].addRule('<?php echo "#order" . $row["pedidoID"]?>', 'background-color:#ff7c7c');
                                        </script>
                                    <?php 
                                    } ?>
                            <?php 
                            } 
                        } ?>
                    <div class="addOrder">
                        <a href="ordersUpdate.php">
                            <img class="addImg" src="../images/plus.png" alt="">
                            <p>Adicionar Pedido</p>
                        </a>
                    </div>
                </div>                

            </div>
        </section>
    </main>

    <footer>
        <?php include_once("../include/footer.php"); ?>
    </footer>
</body>
</html>
<?php
    // Fechar conexao
    mysqli_close($connection);
?>