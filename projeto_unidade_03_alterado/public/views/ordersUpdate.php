<?php require_once("../../connection/connection.php"); ?>
<?php include_once("../include/funcoes.php"); ?>


<?php
    if(isset($_GET["pedidoID"]) && $_GET["pedidoID"] != null) {
        $pedidoID = $_GET["pedidoID"];
        $pedidoConsulta = " SELECT *, nomecompleto, email, nometransportadora 
                            FROM pedidos p 
                            INNER JOIN clientes c on p.clienteID = c.clienteID 
                            INNER JOIN transportadoras t on p.transportadoraID = t.transportadoraID  
                            WHERE pedidoID = {$pedidoID}";
        $pedidoResult = mysqli_query($connection, $pedidoConsulta);
        
        if(!$pedidoResult) {
            die('Erro consulta pedido');
        }

        $pedido = mysqli_fetch_assoc($pedidoResult);

        $pedido['data_pedido'] = formatDateOuput($pedido['data_pedido']);
        $pedido['data_entrega'] = formatDateOuput($pedido['data_entrega']);
        $pedido['data_saida'] = formatDateOuput($pedido['data_saida']);

        
    }

    if(isset($_POST["pedidoID"]) && $_POST["pedidoID"] != null) {
//-------UPDATE-------
        $clienteID          = $_POST["clienteID"];
        $transportadoraID   = $_POST["transportadoraID"];
        $data_pedido        = $_POST["data_pedido"];
        $data_saida         = $_POST["data_saida"];
        $data_entrega      = $_POST["data_entrega"];
        $status_pedido      = $_POST["status_pedido"];
        $valor_pedido       = $_POST["valor_pedido"];
        $conhecimento       = $_POST["conhecimento"];
        $pedidoID           = $_POST["pedidoID"];
        $email           = $_POST["email"];

        $update    = "UPDATE pedidos ";
        $update    .= " SET ";
        $update    .= " clienteID = {$clienteID}, ";
        $update    .= " transportadoraID = {$transportadoraID}, ";
        $update    .= " data_pedido = {$data_pedido}, ";
        $update    .= " data_saida = {$data_saida}, ";
        $update    .= " data_entrega = {$data_entrega}, ";
        $update    .= " status_pedido = {$status_pedido}, ";
        $update    .= " valor_pedido = {$valor_pedido}, ";
        $update    .= " conhecimento = '{$conhecimento}' ";
        $update    .= " WHERE pedidoID = {$pedidoID}";

        $operacaoUpdate = mysqli_query($connection, $update);
            if(!$operacaoUpdate) {
//                print_r($update);
                die("Falha no update dos dados");
            } else {
                header('Location: ordersList.php');
            }
        
        $email = "{$email}";
        $subject = "Pedido " . $pedidoID . " atualizado";
        $message     = "O pedido " . $pedidoID . " foi atualizado, ";
        $message    .= " clienteID = '{$clienteID}', ";
        $message    .= " transportadoraID = '{$transportadoraID}', ";
        $message    .= " data_pedido = '{$data_pedido}', ";
        $message    .= " data_saida = '{$data_saida}', ";
        $message    .= " data_entrega = '{$data_entrega}', ";
        $message    .= " status_pedido = '{$status_pedido}', ";
        $message    .= " valor_pedido = '{$valor_pedido}', ";
        $message    .= " conhecimento = '{$conhecimento}' ";
        send_mail($email, $subject, $message);


    // inserção no banco 
    } elseif (isset($_POST["clienteID"])) {
        $clienteID          = $_POST["clienteID"];
        $transportadoraID   = $_POST["transportadoraID"];

/* 
        $data_pedido        = $_POST["data_pedido"];
        $data_saida         = $_POST["data_saida"];
        $data_entrega       = $_POST["data_entrega"]; */ 

        $data_pedido         = formatDateInput( $_POST["data_pedido"] );
        $data_saida          = formatDateInput( $_POST["data_saida"] );
        $data_entrega        = formatDateInput( $_POST["data_entrega"] );


        $status_pedido      = $_POST["status_pedido"];
        $valor_pedido       = $_POST["valor_pedido"];
        $conhecimento       = $_POST["conhecimento"];

        $inserir    = "INSERT INTO pedidos ";
        $inserir    .= " (clienteID, transportadoraID, data_pedido, data_saida, data_entrega, status_pedido, valor_pedido, conhecimento) ";
        $inserir    .= " VALUES ($clienteID, $transportadoraID, '$data_pedido', '$data_saida', '$data_entrega', $status_pedido, $valor_pedido, '$conhecimento') ";

        $operacaoInserir = mysqli_query($connection, $inserir);
        if(!$operacaoInserir) {
            die("Falha na inserção de dados");
        } else {
            header("Location: ordersList.php");
        }
    } else {
//        print_r($_POST);
    }

    $transportadorasConsult = "SELECT nometransportadora, transportadoraID FROM transportadoras ";
    $transportadoras = mysqli_query($connection,$transportadorasConsult);
    if(!$transportadoras) {
        die("Erro consulta transportadoras");
    }

    $statusConsult = "SELECT nomestatus, statusID FROM pedidos_status ";
    $status = mysqli_query($connection,$statusConsult);
    if(!$status) {
        die("Erro consulta status");
    }

    $clientesConsult = "SELECT nomecompleto, clienteID FROM clientes ";
    $clientes = mysqli_query($connection, $clientesConsult);
    if(!$clientes) {
        die("Erro consulta clientes");
    }


?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="../css/estilo.css" rel="stylesheet">
        <link href="../css/crud.css" rel="stylesheet">

    </head>

    <body>
        <?php include_once("../include/header.php"); ?>
        
        <main>
        <?php include_once("../include/navbar.php"); ?>
            <section class="content">
                <div id="janela_formulario">
                    <form action="ordersUpdate.php" method="post">
                        <label for="cliente">Cliente</label>
                        <select name="clienteID" placeholder="Cliente">
                            <?php
                                while ($row=mysqli_fetch_assoc($clientes)) { ?>
                                    <option value="<?php echo $row["clienteID"] ?>" 
                                        <?php if (isset($pedido["clienteID"]) && $pedido["clienteID"] == $row["clienteID"]) { ?>
                                            selected
                                        <?php } ?> >
                                        <?php 
                                            //echo $row["nomecompleto"]; 
                                            
                                                   
                                            if ( !isset($row["nomecompleto"]) ) {
                                                echo "Cliente não existe!";
                                            } else {
                                                echo $row["nomecompleto"];
                                            }

                                            ?>
                                    </option>
                            <?php } ?>
                        </select>
                        <label for="transportadora">Transportadora</label>
                        <select name="transportadoraID" placeholder="Transportadora">
                            <?php
                                while ($row=mysqli_fetch_assoc($transportadoras)) { ?>
                                    <option value="<?php echo $row["transportadoraID"] ?>" 
                                        <?php if (isset($pedido["transportadoraID"]) && $pedido["transportadoraID"] == $row["transportadoraID"]) { ?>
                                            selected
                                        <?php } ?> >
                                        <?php /*echo $row["nometransportadora"]; */?>
                                        <?php echo utf8_encode( $row["nometransportadora"] ); ?>
                                    </option>
                            <?php    
                            } ?>
                        </select>
                        <label for="data_pedido">Data Pedido</label>
                        <input type="datetime-local" name="data_pedido" placeholder="Data Pedido" value="<?php echo isset($pedido) ? $pedido['data_pedido'] : null ?>">
                        <label for="data_saida">Data Saida</label>
                        <input type="datetime-local" name="data_saida" placeholder="Data Saida" value="<?php echo isset($pedido) ? $pedido['data_saida'] : null ?>">
                        <label for="data_entrega">Data Entrega</label>
                        <input type="datetime-local" name="data_entrega" placeholder="Data Entrega" value="<?php echo isset($pedido) ? $pedido['data_entrega'] : null ?>">
                        <label for="valor_pedido">Valor Pedido</label>
                        <input type="text" name="valor_pedido" placeholder="Valor Pedido" value="<?php echo isset($pedido) ? $pedido['valor_pedido'] : null ?>">
                        <label for="status_pedido">Status Pedido</label>
                        <select name="status_pedido" placeholder="Status do Pedido">
                            <?php
                                while ($row=mysqli_fetch_assoc($status)) { ?>
                                    <option value="<?php echo $row["statusID"] ?>" 
                                        <?php if (isset($pedido["clienteID"]) && $pedido["status_pedido"] == $row["statusID"]) { ?>
                                            selected
                                        <?php } ?> >
                                        <?php echo $row["nomestatus"]; ?>
                                    </option>
                            <?php    
                            } ?>
                        <label for="conhecimento">Conhecimento Frete</label>
                        <input type="text" name="conhecimento" placeholder="Conhecimento Frete" value="<?php echo isset($pedido) ? $pedido['conhecimento'] : null ?>">
                        <input type="hidden" name="pedidoID" value="<?php echo isset($pedido) ? $pedido['pedidoID'] : null ?>">
                        <input type="hidden" name="email" value="<?php echo isset($pedido) ? $pedido['email'] : null ?>">
                        <input type="submit" value="<?php echo isset($pedido) ? "Atualizar" : "Adicionar" ?>">
                    </form>
                </div>
                <div class="delete">
                    <?php if (isset($pedido["pedidoID"])) { ?>
                      
                       <button id="btn-delete" title="<?php echo $pedido['pedidoID'] ?>">Deletar</button>
                       <h1 id="show-message"></h1>
                    <?php } ?>
                </div>
            </section>
            
            
        </main>

        <?php include_once("../include/footer.php"); ?> 


        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/script.js"></script>
    </body>

</html>

<?php
    // Fechar conexao
    mysqli_close($connection);
?>