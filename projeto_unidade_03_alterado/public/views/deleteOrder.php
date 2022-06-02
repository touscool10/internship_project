<?php require_once("../../connection/connection.php"); ?>
<?php include_once("../include/funcoes.php"); ?> 

<?php

    if(isset($_POST["pedidoID"]) && $_POST["pedidoID"] != null) {

        $pedidoID = $_POST["pedidoID"];
        $retorno = functionDeleteOrder($pedidoID, $connection);
    
    } else {
        $retorno["success"] = false;
        $retorno["message"] = "Houve um erro na remoção do pedido";
    }

    echo json_encode($retorno);

    mysqli_close($connection);

?> 
