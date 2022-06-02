<?php require_once("../../connection/connection.php"); ?>

<?php
    if(isset($_GET["clientID"])) {
        $clientID = $_GET["clientID"];
    } else {
        Header("Location: index.php");
    }

    $ordersConsult = "SELECT * ";
    $ordersConsult .= " FROM pedidos ";
    $ordersConsult .= " WHERE clienteID = {$clientID} ";
    $orders = mysqli_query($connection, $ordersConsult);
    if(!$orders) {
        die('orders Failed to connect to database');
    }
   

    $clientConsult = "SELECT nomecompleto ";
    $clientConsult .= " FROM clientes ";
    $clientConsult .= " WHERE clienteID = {$clientID}";
    $clientConnect = mysqli_query($connection, $clientConsult);
    if(!$clientConnect) {
        die('client Failed to connect to database');
    }
    $client = mysqli_fetch_assoc($clientConnect);

    $clientIDMenorConsult = "SELECT clienteID FROM clientes WHERE clienteID < {$clientID} ORDER BY clienteID DESC LIMIT 1";
    $clientIDMenorConnect = mysqli_query($connection, $clientIDMenorConsult);
    if(!$clientIDMenorConnect) {
        die('clientIDMenorConnect Failed to connect to database');
    }
    $clientIDMenor = mysqli_fetch_assoc($clientIDMenorConnect);
    
    $clientIDMaiorConsult = "SELECT clienteID FROM clientes WHERE clienteID > {$clientID} ORDER BY clienteID ASC LIMIT 1";
    $clientIDMaiorConnect = mysqli_query($connection, $clientIDMaiorConsult);
    if(!$clientIDMaiorConnect) {
        die('clientIDMaiorConnect Failed to connect to database');
    }
    $clientIDMaior = mysqli_fetch_assoc($clientIDMaiorConnect);

    
    
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="../css/pedido.css">

</head
>
<body>
    <header>
        <?php include_once("../include/header.php"); ?>
    </header>

    <main>
        <div class="seta-esq">
            <?php
                if(isset($clientIDMenor)) {?>
                    <a href="order.php?clientID=<?php echo $clientIDMenor["clienteID"]?>"><img class="seta" src="../images/seta-direita.png" alt=""></a>
            <?php }
            ?>
        </div>
        <div>
            <h2><?php echo $client["nomecompleto"]?></h2>
            <?php                       
                if( mysqli_num_rows($orders) == 0){
                    echo '<h2 class="nped">Não há pedidos para esse cliente</h>';
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
        <div class="seta-dir">
            <?php
                if(isset($clientIDMaior)) {?>
            <a href="order.php?clientID=<?php echo $clientIDMaior["clienteID"] ?>"><img class="seta" src="../images/seta-direita.png" alt=""></a>
            <?php }
            ?>
        </div>
        
    </main>

    <footer>
        <?php include_once("../include/footer.php"); ?>
    </footer>
</body>
</html>