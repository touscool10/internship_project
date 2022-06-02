<?php require_once("../../connection/connection.php"); ?>

<?php
    // iniciar variavel de sessão
    session_start();

    // restringir acesso
    if (!isset($_SESSION["user_portal"])) {
        header("Location: login.php");
    }

    setlocale(LC_ALL, 'pt_BR');

    $clientes = "SELECT nomecompleto, ddd, telefone, email, clienteID ";
    $clientes .= " FROM clientes ";
    $clientes .= " WHERE clienteID = {$_SESSION["user_portal"]} ";

    $dbResult = mysqli_query($connection, $clientes);
    if(!$dbResult) {
        die('Failed to connect to database');
    }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Infos clientes</title>
    <link rel="stylesheet" href="../css/userDashboard.css">
    <link rel="stylesheet" href="../css/clienteList.css">

</head>
<body>
    <header>
        <?php include_once("../include/header.php"); ?>
    </header>
    <main>
        <?php
            while($row = mysqli_fetch_assoc($dbResult)) {
        ?>

            <div class="cliente">
                <div class="clienteHeader">
                    <h3><?php echo $row["nomecompleto"]?></h3>
                    <a href="">Editar cadastro</a>
                </div>
                
                <ul>
                    <li class="general">Telefone: <?php echo $row["ddd"] . " " . $row["telefone"]?></li>
                    <li class="general">E-mail: <?php echo $row["email"]?></li>
                    <li><a href="ordersList.php?clienteID=<?php echo $row["clienteID"]?>&clienteName=<?php echo $row["nomecompleto"]?>">Consultar pedidos</a></li>
                </ul>
            </div>            
        <?php
            }
        ?>
        
    </main>
    <footer>
        <?php include_once("../include/footer.php"); ?>
    </footer>
</body>
</html>
<?php
    // Fechar conexao
    mysqli_close($connection);
?>