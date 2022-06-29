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
    
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/adminDashboard.css">

</head>

<body>
    <header>
        <?php include_once("../include/header.php"); ?>
    </header>
    <main>
        <?php include_once("../include/navbar.php"); ?>
        <section class="content">
            <div class = "esq">

            </div>
            <div class="clienteList">
                <?php
                    while($row = mysqli_fetch_assoc($dbResult)) {
                ?>
                    <div class="cliente">
                        <div class="orderTitle">
                            <h3><?php echo $row["nomecompleto"]?></h3>
                            <a href="clientUpdate.php?clienteID=<?php echo $row["clienteID"]?>">
                                <img src="../images/edit.png" alt="">
                            </a>
                            <a href="ordersList.php?clienteID=<?php echo $row["clienteID"]?>">
                                <img src="../images/details.png" alt="">
                            </a>
                            
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
            </div>
            <div class="addcliente">
                <a href="clientUpdate.php">
                    <img class="addImg" src="../images/plus.png" alt="">
                    <p>Adicionar cliente</p>
                </a>
            </div>

            </div>
        </section>
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