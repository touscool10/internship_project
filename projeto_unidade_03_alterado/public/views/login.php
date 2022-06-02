<?php require_once("../../connection/connection.php"); ?>
<?php include_once("../include/funcoes.php"); ?>


<?php
// iniciar variavel de sessão
    session_start();
    if(isset($_POST["usuario"])) {
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

/*         $login = "SELECT * ";
        $login .= " FROM clientes ";
        $login .= " WHERE usuario = '{$usuario}' and senha = '{$senha}' "; */

        $login = "SELECT * FROM clientes WHERE usuario = '{$usuario}' and senha = '{$senha}' ";

        $acesso = mysqli_query($connection, $login);

        if (!$acesso) {
            die("Falha na consulta ao banco");
        }

        $informacao = mysqli_fetch_assoc($acesso);
        if ( empty($informacao)) {
            $mensagem = "Login sem sucesso";
        } else {
            $_SESSION["user_portal"] = $informacao["clienteID"];
            if ($informacao["nivel"] == "user") {
                header("Location: clientList.php");
            } else {
                header("Location: clientList.php");
                
            }
        }
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="../css/estilo.css" rel="stylesheet">
        <link href="../css/login.css" rel="stylesheet">

    </head>

    <body>
        <?php include_once("../include/header.php"); ?>
        
        <main>  
            <div id="janela_login">
                <form action="login.php" method="post">
                    <h2>Login</h2>
                    <input type="text" name="usuario" placeholder="Usuário">
                    <input type="password" name="senha" placeholder="Senha">
                    <a class = "password-recovery" href="">Recuperar Senha</a>
                    <input type="submit" value="login">

                    <?php
                        if(isset($mensagem)) { ?>
                            <p><?php echo $mensagem?></p>
                    <?php    }
                    ?>
                </form>
                <a class = "sign-up" href="clientUpdate.php">Cadastrar-se</a>
            </div>
        </main>

        <?php include_once("../include/footer.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($connection);
?>