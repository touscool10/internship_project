<?php require_once("../../connection/connection.php"); ?>
<?php include_once("../include/funcoes.php"); ?>


<?php
    // inserção no banco 
    if (isset($_POST["cidade"])) {
        print_r($_POST);
        $nomecompleto   = $_POST["nomecompleto"];
        $endereco       = $_POST["endereco"];
        $complemento    = $_POST["complemento"];
        $numero         = $_POST["numero"];
        $cidade         = $_POST["cidade"];
        $estado         = $_POST["estado"];
        $cep            = $_POST["cep"];
        $ddd            = $_POST["ddd"];
        $telefone       = $_POST["telefone"];
        $email          = $_POST["email"];
        $usuario        = $_POST["usuario"];
        $senha          = $_POST["senha"];
        $nivel          = $_POST["nivel"];


        $inserir    = "INSERT INTO clientes ";
        $inserir    .= " (nomecompleto,endereco,complemento,numero,cidade,estadoID,cep,ddd,telefone,email,usuario,senha,nivel) ";
//        $inserir    .= " VALUES ('Willi', 'Av', '1', '5041', 'lages', 2, '88509100', '048', '999990015', 'willi.gerber@gmail.com', 'willi', 'willi', 'admin') ";

        $inserir    .= " VALUES ('$nomecompleto', '$endereco', '$complemento', '$numero', '$cidade', $estado, '$cep', '$ddd', '$telefone', '$email', '$usuario', '$senha', 'admin') ";

        $operacaoInserir = mysqli_query($connection, $inserir);
        if(!$operacaoInserir) {
            die("Falha na inserção de dados");
        } else {
            header("Location: login.php");
        }
    }

    $listaEstados = "SELECT nome, estadoID FROM estados ";
    $linha_estados = mysqli_query($connection,$listaEstados);
    if(!$linha_estados) {
        die("erro no banco");
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
            <div id="janela_formulario">
                <form action="signUp.php" method="post">
                    <input type="text" name="nomecompleto" placeholder="Nome Completo">
                    <input type="text" name="endereco" placeholder="Endereco">
                    <input type="text" name="complemento" placeholder="Complemento">
                    <input type="text" name="numero" placeholder="Número">
                    <input type="text" name="cidade" placeholder="Cidade">
                    <select name="estado">
                    <?php 
                        while($linha=mysqli_fetch_assoc($linha_estados)) { ?>
                            <option value="<?php echo $linha["estadoID"] ?>">
                                <?php echo $linha["nome"];?>
                            </option>
                        <?php 
                        } ?>
                    </select>
                    <input type="text" name="cep" placeholder="CEP">
                    <input type="text" name="ddd" placeholder="DDD">
                    <input type="text" name="telefone" placeholder="Telefone">
                    <input type="text" name="email" placeholder="Email">
                    <input type="text" name="usuario" placeholder="Usuário">
                    <input type="text" name="senha" placeholder="Senha">
                    <input type="hidden" name="nivel" value="user">
                    <input type="submit" value="Cadastrar-se">

                </form>
            </div>
            
        </main>

        <?php include_once("../include/footer.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($connection);
?>