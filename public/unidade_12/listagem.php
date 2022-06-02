<?php require_once("../../conexao/conexao.php"); ?>

<?php
    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');


    $totalProducts = "SELECT count(produtoID) as quantityProducts FROM produtos "; 
    $total = mysqli_query($conecta, $totalProducts);
    $registers = mysqli_fetch_assoc($total)["quantityProducts"];
    $quantityRegisters = intval($registers); // function intval gets the integer value of a variable;

    //var_dump($quantityRegisters); 

    $limite = 5; 

    $atualPage = 1 ;
    if (isset($_GET["page"])) {
        //$limite = 5; 
        $atualPage = intval($_GET["page"]) ;
    }


    $offsete = ($atualPage -1) * $limite;

    $totalPages = ceil($quantityRegisters / $limite);
    $totalPages = intval($totalPages);

    //var_dump($totalPages); 


    // Consulta ao banco de dados
    $produtos = "SELECT produtoID, nomeproduto, tempoentrega, precounitario, imagempequena ";
    $produtos .= "FROM produtos  "; 
    $produtos .= " LIMIT {$limite} OFFSET {$offsete}"; 

    if (isset($_GET["produto"])) {
        $nome_produto   = urlencode($_GET["produto"]);
        $produtos       .= "WHERE nomeproduto LIKE '%{$nome_produto}%' "; 
    }
    $resultado = mysqli_query($conecta, $produtos);
    if(!$resultado) {
        die("Falha na consulta ao banco");   
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/produtos.css" rel="stylesheet">
        <link href="_css/produto_pesquisa.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("../_incluir/topo.php"); ?>
        <?php include_once("../_incluir/funcoes.php"); ?>  
        
        <main n style="background-color: yellow ;">
            <div id="janela_pesquisa">
                <form action="listagem.php" method="get">
                    <input type="text"  name="produto" placeholder="Pesquisa"> 
                    <input type="image" name="pesquisa" src="assets/botao_search.png">
                </form>
            </div>
            
            <div id="listagem_produtos"> 
            <?php
                while($linha = mysqli_fetch_assoc($resultado)) {
            ?>
                <ul>
                    <li class="imagem">
                        <a href="detalhe.php?codigo=<?php echo $linha['produtoID'] ?>">
                            <img src="<?php echo $linha["imagempequena"] ?>">
                        </a>
                    </li>
                    <li><h3><?php echo $linha["nomeproduto"] ?></h3></li>
                    <li>Tempo de Entrega : <?php echo $linha["tempoentrega"] ?></li>
                    <li>Preço unitário : <?php echo real_format($linha["precounitario"]) ?></li>
                </ul>
             <?php
                }
            ?>           
            </div>

            
        </main>

        <section style="margin-top: 1px ; margin-left: 650px ;">
                    <?php 
                    
                    for ($i=1; $i<=$totalPages; $i++) { ?>
                    
                        <a style="margin-right: 10px ;" href="?page=<?php echo $i ?> "> <?php echo $i ?> </a>
                        
                    <?php }  ?>
        </section>


        <?php include_once("../_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>

<?php
/* 
$query = "SELECT COUNT(*) as total FROM redirect
WHERE user_id = '".$_SESSION['user_id']."'";
$r = mysql_fetch_assoc(mysql_query($query));

$totalPages = ceil($r['total'] / $perPage);

$links = "";
for ($i = 1; $i <= $totalPages; $i++) {
  $links .= ($i != $page ) 
            ? "<a href='index.php?page=$i'>Page $i</a> "
            : "$page ";
}


$r = mysql_query($query);

$query = "SELECT * FROM 'redirect'
WHERE 'user_id'= \''.$_SESSION['user_id'].' \' 
ORDER BY 'timestamp' LIMIT $startAt, $perPage";

$r = mysql_query($query);
 */
// display results here the way you want
