<?php require_once("../../connection/connection.php"); ?>
<?php include_once("../include/funcoes.php"); ?>


<?php

    $listaEstados = "SELECT nome, estadoID FROM estados ";
    $linha_estados = mysqli_query($connection,$listaEstados);
    if(!$linha_estados) {
        die("erro no banco");
    }

    if(isset($_GET["clienteID"])) {
        $clienteID = $_GET["clienteID"];
        $clienteConsulta = "SELECT *, nome FROM clientes c INNER JOIN estados e on c.estadoID = e.estadoID WHERE clienteID = {$clienteID}";
        $clienteResult = mysqli_query($connection, $clienteConsulta);
        if(!$clienteResult) {
            die('Failed to connect to database');
        }
        $cliente = mysqli_fetch_assoc($clienteResult);

    } 

    if(isset($_POST["clienteID"]) && $_POST["clienteID"] != null) {
        // UPDATE
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
            $clienteID      = $_POST["clienteID"];

            $update    = "UPDATE clientes ";
            $update    .= " SET ";
            $update    .= " nomecompleto = '{$nomecompleto}', ";
            $update    .= " endereco = '{$endereco}', ";
            $update    .= " complemento = '{$complemento}', ";
            $update    .= " numero = '{$numero}', ";
            $update    .= " cidade = '{$cidade}', ";
            $update    .= " estadoID = {$estado}, ";
            $update    .= " cep = '{$cep}', ";
            $update    .= " ddd = '{$ddd}', ";
            $update    .= " telefone = '{$telefone}', ";
            $update    .= " email = '{$email}', ";
            $update    .= " usuario = '{$usuario}', ";
            $update    .= " senha = '{$senha}', ";
            $update    .= " nivel = '{$nivel}' ";
            $update    .= " WHERE clienteID = {$clienteID}";

            $operacaoUpdate = mysqli_query($connection, $update);
            if(!$operacaoUpdate) {
                die("Falha no update dos dados");
            } else {
                header('Location: clientList.php');
            }

        // ADD
    } elseif(isset($_POST["nomecompleto"])) {
        $nomecompleto   = $_POST["nomecompleto"];
        $endereco       = $_POST["endereco"];
        $complemento    = $_POST["complemento"];
        $numero         = $_POST["numero"];
        $cidade         = $_POST["cidade"];
        $estado         = $_POST["estado"   ];
        $cep            = $_POST["cep"];
        $ddd            = $_POST["ddd"];
        $telefone       = $_POST["telefone"];
        $email          = $_POST["email"];
        $usuario        = $_POST["usuario"];
        $senha          = $_POST["senha"];
        $nivel          = $_POST["nivel"];

        $inserir    = "INSERT INTO clientes ";
        $inserir    .= " (nomecompleto,endereco,complemento,numero,cidade,estadoID,cep,ddd,telefone,email,usuario,senha,nivel) ";
        $inserir    .= " VALUES ('$nomecompleto', '$endereco', '$complemento', '$numero', '$cidade', $estado, '$cep', '$ddd', '$telefone', '$email', '$usuario', '$senha', 'admin') ";

        $operacaoInserir = mysqli_query($connection, $inserir);
        if(!$operacaoInserir) {
            die("Falha na inserção de dados");
        } else {
            header('Location: clientList.php');
        }
    }

    function functionDelete($clienteID) {
        $delete = "DELETE FROM clientes WHERE clienteID = {$clienteID}";
        global $connection;
        $deleteSubmit = mysqli_query($connection, $delete);
        if(!$delete) {
            die("Erro ao deletar pedido");
        }
//        header("location: clientList.php");
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
                    <form action="clientUpdate.php" method="post">
                        <input type="text" name="nomecompleto" placeholder="Nome Completo" value="<?php echo isset($cliente) ? $cliente['nomecompleto'] : null ?>">
                        <input type="text" name="endereco" placeholder="Endereco" value="<?php echo isset($cliente) ? $cliente['endereco'] : null ?>">
                        <input type="text" name="complemento" placeholder="Complemento" value="<?php echo isset($cliente) ? $cliente['complemento'] : null ?>">
                        <input type="text" name="numero" placeholder="Número" value="<?php echo isset($cliente) ? $cliente['numero'] : null ?>">
                        <input type="text" name="cidade" placeholder="Cidade" value="<?php echo isset($cliente) ? $cliente['cidade'] : null ?>">
                        <select name="estado">
                            <?php
                                while ($row=mysqli_fetch_assoc($linha_estados)) { ?>
                                    <option value="<?php echo $row["estadoID"] ?>" 
                                        <?php if (isset($cliente["estadoID"]) && $cliente["estadoID"] == $row["estadoID"]) { ?>
                                            selected
                                        <?php } ?> >
                                        <?php echo $row["nome"]; ?>
                                    </option>
                                <?php    
                                } 
                            ?>
                        </select>
                        <input type="text" name="cep" placeholder="CEP" value="<?php echo isset($cliente) ? $cliente['cep'] : null ?>">
                        <input type="text" name="ddd" placeholder="DDD" value="<?php echo isset($cliente) ? $cliente['ddd'] : null ?>">
                        <input type="text" name="telefone" placeholder="Telefone" value="<?php echo isset($cliente) ? $cliente['telefone'] : null ?>">
                        <input type="text" name="email" placeholder="Email" value="<?php echo isset($cliente) ? $cliente['email'] : null ?>">
                        <input type="text" name="usuario" placeholder="Usuário" value="<?php echo isset($cliente) ? $cliente['usuario'] : null ?>">
                        <input type="text" name="senha" placeholder="Senha" value="<?php echo isset($cliente) ? $cliente['senha'] : null ?>">
                        <input type="hidden" name="nivel" value="user" value="<?php echo isset($cliente) ? $cliente['nivel'] : null ?>">
                        <input type="hidden" name="clienteID" value="<?php echo isset($cliente) ? $cliente['clienteID'] : null ?>">
                        
                        <!-- Verificar a condição isset cliente para update ou add -->
                        <input type="submit" value="<?php echo isset($cliente) ? "Atualizar" : "Adicionar" ?>">
                    </form>
                </div>
                <div class="delete">
                    <?php if (isset($cliente["clienteID"])) { ?>
                        <button onclick="<?php functionDelete($cliente['clienteID'], $connection)?>">Deletar</button>
                    <?php } ?>
                </div>
            </section>
        </main>

        <?php include_once("../include/footer.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($connection);
?>