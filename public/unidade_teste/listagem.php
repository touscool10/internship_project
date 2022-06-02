<?php require_once("../../conexao/conexao.php"); ?>


<?php
    // tabela de pedidos
    $pedidos = "SELECT * FROM pedidos ";
    $consulta_pedidos = mysqli_query($conecta, $pedidos);
    if(!$consulta_pedidos) {
        die("erro no banco");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
      <!--   <link href="_css/estilo.css"            rel="stylesheet">
        <link href="_css/novo-alteracao.css"    rel="stylesheet"> -->
    </head>

    <body>
        <?php include_once("../_incluir/topo.php"); ?>
        <?php include_once("../_incluir/funcoes.php"); ?>  

        <form action="takeDate.php" method="post">
            <label for="data_saida">Data Saída</label>
            <input type="datetime-local" id=data_saida name="data_saida" placeholder = "Digite a data de saída"><br><br>

            <input type="submit" id=submit name="submit" value="Enviar">
                
        </form>
   


        
        <main>  
            <div id="janela_transportadoras">
                <?php
                    while($linha = mysqli_fetch_assoc($consulta_pedidos)) {
                ?>
                <ul>
                    <li><?php echo $linha["pedidoID"] ?></li>
                    <li><?php echo $linha["clienteID"] ?></li>
                    <li><?php echo $linha["transportadoraID"] ?></li>  

                    <li><?php echo  convertDateFromDB($linha["data_pedido"]) ?></li>  
                    
                    <li><?php echo  convertDateFromDB($linha["data_saida"]) ?></li>   
                    
                    <li><?php echo  convertDateFromDB($linha["data_entrega"]) ?></li>  

                    <li><?php echo $linha["status_pedido"] ?></li>  
                    <li><?php echo $linha["valor_pedido"] ?></li>  
                    <li><?php echo $linha["conhecimento"] ?></li>  

                </ul> <br><br>
                <?php
                    }
                ?>
            </div>
        </main>

        <?php include_once("../_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>