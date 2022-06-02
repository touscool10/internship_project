<?php require_once("../../conexao/conexao.php"); ?>

<?php
// Testar Parametro
    if(isset($_GET["codigo"])) {
        $produtoID = $_GET["codigo"];
    } else {
        Header("Location: listagem.php");
    }

// Consulta ao banco
    $consulta = "SELECT * ";
    $consulta .= " FROM produtos ";
    $consulta .= " WHERE produtoID = {$produtoID} ";
    $detalhe = mysqli_query($conecta, $consulta);

    if(!$detalhe) {
        die("Falha no banco de dados");
    } else {
        $dados_detalhe = mysqli_fetch_assoc($detalhe);

        $produtoID      = $dados_detalhe["produtoID"];
        $nomeproduto    = $dados_detalhe["nomeproduto"];
        $descricao      = $dados_detalhe["descricao"];
        $codigobarra    = $dados_detalhe["codigobarra"];
        $tempoentrega   = $dados_detalhe["tempoentrega"];
        $nomeproduto    = $dados_detalhe["nomeproduto"];
        $precorevenda     = $dados_detalhe["precorevenda"];
        $precounitario  = $dados_detalhe["precounitario"];
        $estoque        = $dados_detalhe["estoque"];
        $imagemgrande   = $dados_detalhe["imagemgrande"];

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
        <link href="_css/produto_detalhe.css" rel="stylesheet">

    </head>

    <body>
        <?php include_once("../_incluir/topo.php"); ?>
        <?php include_once("../_incluir/funcoes.php"); ?> 
        
        <main>  
            <div id="detalhe_produto">
                <ul>
                    <li class="imagem"><img src="<?php echo $imagemgrande?>" alt=""></li>
                    <li><h2><?php echo $nomeproduto?></h2></li>
                    <li>Descrição: <?php echo $descricao?></li>
                    <li>Código de Barras: <?php echo $codigobarra?></li>
                    <li>Tempo de Entrega: <?php echo $tempoentrega?> dias</li>
                    <li>Preço Revenda: <?php echo real_format($precorevenda)?></li>
                    <li>Preço Unitário: <?php echo real_format($precounitario)?></li>
                    <li>Estoque: <?php echo $estoque?></li>

                </ul>
            </div>
        </main>

        <?php include_once("../_incluir/rodape.php"); ?>
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>