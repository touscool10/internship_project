<?php require_once("../../conexao/conexao.php"); ?>

<?php
    // Consulta banco de dados - produtos
    $produtos = "SELECT produtoID, nomeproduto, tempoentrega, precounitario, imagempequena ";
    $produtos .= " FROM produtos ";
    $resultado = mysqli_query($conecta, $produtos);

    if (!$resultado) {
        die("Falha na consulta ao banco");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/produtos.css" rel="stylesheet">

    </head>

    <body>
        <?php include_once("../_incluir/topo.php"); ?>
        <?php include_once("../_incluir/funcoes.php"); ?>
        
        <main>
            <div id="listagem_produtos"> 
                <?php
                    while ($row = mysqli_fetch_assoc($resultado)) {
                ?>
                    <ul>
                        <li class="imagem"><img src="<?php echo $row["imagempequena"]?>" alt=""></li>
                        <li><h3><?php echo $row["nomeproduto"]?></h3></li>
                        <li>Tempo entrega: <?php echo $row["tempoentrega"]?></li>
                        <li>Preço Unitário: <?php echo real_format($row["precounitario"])?></li>
                    </ul>
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