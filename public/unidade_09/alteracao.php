<?php require_once("../../conexao/conexao.php"); ?>

<?php
    if(isset($_POST["cidade"])){
        $nome       = $_POST["nometransportadora"];
        $endereco   = $_POST["endereco"];
        $cidade     = $_POST["cidade"];
        $estados    = $_POST["estados"];
        $telefone   = $_POST["telefone"];
        $cep        = $_POST["cep"];
        $cnpj       = $_POST["cnpj"];
        $tID        = $_POST["transportadoraID"];

        // objeto de alteração
        $alterar    = "UPDATE transportadoras ";
        $alterar    .= " SET ";
        $alterar    .= "nometransportadora = '{$nome}', ";
        $alterar    .= "endereco = '{$endereco}', ";
        $alterar    .= "cidade = '{$cidade}', ";
        $alterar    .= "estadoID = {$estados}, ";
        $alterar    .= "telefone = '{$telefone}', ";
        $alterar    .= "cep = '{$cep}', ";
        $alterar    .= "cnpj = '{$cnpj}', ";
        $alterar    .= "cep = '{$cep}' ";
        $alterar    .= "WHERE transportadoraID = {$tID}";

        $operacaoAlteracao = mysqli_query($conecta, $alterar);
        if(!$operacaoAlteracao) {
            die("Erro na alteracao de dados"); 
        } else {
            header("Location: listagem.php");
        }
    }

    // consulta tabela transportadora
    $transp = "SELECT * FROM transportadoras ";
    if(isset($_GET["codigo"])) {
        $id = $_GET["codigo"];
        $transp .= " WHERE transportadoraID = {$id}";
    } else {
        $transp .= " WHERE transportadoraID = 1";
    }

    $con_transp = mysqli_query($conecta, $transp);
    if(!$con_transp) {
        die("Erro consulta no banco de dados");
    } else {
        $info_transp = mysqli_fetch_assoc($con_transp);
    }

    // consulta tabela estados
    $estados = "SELECT estadoID, nome FROM estados ";
    $listaEstados = mysqli_query($conecta, $estados);
    if(!$listaEstados) {
        die("Erro consulta dados estados");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("../_incluir/topo.php"); ?>
        <?php include_once("../_incluir/funcoes.php"); ?> 
        
        <main>  
            <div id="janela_formulario">
                <form action="alteracao.php" method="post">
                    <h2>Alteração de Transportadora</h2>

                    <label for="nometransportadora">Nome da Transportadora</label>
                    <input type="text" value="<?php echo $info_transp["nometransportadora"] ?>" name="nometransportadora">

                    <label for="endereco">Endereco</label>
                    <input type="text" value="<?php echo $info_transp["endereco"] ?>" name="endereco">

                    <label for="cidade">Cidade</label>
                    <input type="text" value="<?php echo $info_transp["cidade"] ?>" name="cidade">

                    <label for="estados">Estados</label>
                    <select name="estados" id="estados">
                        <?php
                            $meuEstado = $info_transp["estadoID"];
                            while($linha = mysqli_fetch_assoc($listaEstados)) {
                                $estadoMomento = $linha["estadoID"];
                                if($meuEstado == $estadoMomento) {

                        ?>
                                    <option value="<?php echo $linha["estadoID"] ?>" selected>
                                        <?php echo $linha["nome"]; ?>
                                    </option>
                        <?php
                                } else {

                        ?>
                                    <option value="<?php echo $linha["estadoID"] ?>">
                                        <?php echo $linha["nome"]; ?>
                                    </option>
                        <?php
                                }
                            }
                        ?>
                    </select>

                    <label for="telefone">Telefone</label>
                    <input type="text" value="<?php echo $info_transp["telefone"] ?>" name="telefone">

                    <label for="CEP">CEP</label>
                    <input type="text" value="<?php echo $info_transp["cep"] ?>" name="cep">

                    <label for="CNPJ">CNPJ</label>
                    <input type="text" value="<?php echo $info_transp["cnpj"] ?>" name="cnpj">

                    <input type="hidden" name="transportadoraID" value="<?php echo $info_transp["transportadoraID"] ?>">

                    <input type="submit" value="Confirmar Alteracao">
                </form>
            </div>
        </main>

        <?php include_once("../_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>