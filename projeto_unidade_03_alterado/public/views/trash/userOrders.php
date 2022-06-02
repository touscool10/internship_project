<?php require_once("../../connection/connection.php"); ?>

<?php
    // iniciar variavel de sessão
    session_start();

    // restringir acesso
    if (!isset($_SESSION["user_portal"])) {
        header("Location: login.php");
    }

    setlocale(LC_ALL, 'pt_BR');

    if(isset($_GET["clienteID"])) {
        $clienteID = $_GET["clienteID"];
    } else {
        header("Location: index.php");
    }

    $ordersConsult = "SELECT * ";
    $ordersConsult .= " FROM pedidos ";
    $ordersConsult .= " WHERE clienteID = {$clienteID} ";
    $orders = mysqli_query($connection, $ordersConsult);
    if(!$orders) {
        die('orders Failed to connect to database');
    }
   

    $clienteConsult = "SELECT nomecompleto ";
    $clienteConsult .= " FROM clientes ";
    $clienteConsult .= " WHERE clienteID = {$clienteID}";
    $clienteConnect = mysqli_query($connection, $clienteConsult);
    if(!$clienteConnect) {
        die('cliente Failed to connect to database');
    }
    $cliente = mysqli_fetch_assoc($clienteConnect);

    $clienteIDMenorConsult = "SELECT clienteID FROM clientes WHERE clienteID < {$clienteID} ORDER BY clienteID DESC LIMIT 1";
    $clienteIDMenorConnect = mysqli_query($connection, $clienteIDMenorConsult);
    if(!$clienteIDMenorConnect) {
        die('clienteIDMenorConnect Failed to connect to database');
    }
    $clienteIDMenor = mysqli_fetch_assoc($clienteIDMenorConnect);
    
    $clienteIDMaiorConsult = "SELECT clienteID FROM clientes WHERE clienteID > {$clienteID} ORDER BY clienteID ASC LIMIT 1";
    $clienteIDMaiorConnect = mysqli_query($connection, $clienteIDMaiorConsult);
    if(!$clienteIDMaiorConnect) {
        die('clienteIDMaiorConnect Failed to connect to database');
    }
    $clienteIDMaior = mysqli_fetch_assoc($clienteIDMaiorConnect);

    
    
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/orders1.css">

</head
>
<body>
    <header>
        <?php include_once("../include/header.php"); ?>
    </header>

    <main>
        <div class="seta-esq">
        <?php include_once("../include/navbar.php"); ?>
        <section class="content">
            <div class="seta-esq">
                <?php
                    if(isset($clienteIDMenor)) {?>
                        <a href="UserOrders.php?clienteID=<?php echo $clienteIDMenor["clienteID"]?>"><img class="seta" src="../images/seta-direita.png" alt=""></a>
                <?php }
                ?>
            </div>
        </div>
        <div class="orders">
            <h2><?php echo $cliente["nomecompleto"]?></h2>
            <div class="ordersList">
                <?php                       
                    if( mysqli_num_rows($orders) == 0){
                        echo '<h3 class="nped">Não há pedidos para esse cliente</h3>';
                    }else{  
                        while ($row = mysqli_fetch_assoc($orders)) { 
                            ?>
                            <div class="order">
                                <h3>Pedido nº <?php echo $row["pedidoID"]?></h3>
                                <ul>
                                    <li>Data Pedido: <?php echo $row["data_pedido"]?></li>
                                    <li>Valor Pedido: <?php echo $row["valor_pedido"]?></li>
                                    <li>Status Pedido: <?php echo $row["status_pedido"]?></li>
                                    <li>Data Entrega: <?php echo $row["data_entrega"]?></li>
                                </ul>
                            </div>  

                            <?php
                        }
                    }
                ?>
            </div>
            
        </div>
        <div class="seta-dir">
            <?php
                if(isset($clienteIDMaior)) {?>
            <a href="UserOrders.php?clienteID=<?php echo $clienteIDMaior["clienteID"] ?>"><img class="seta" src="../images/seta-direita.png" alt=""></a>
            <?php }
            ?>
        </div>
        
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