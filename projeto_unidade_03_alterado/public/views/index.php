<?php require_once("../../connection/connection.php"); ?>

<?php
    setlocale(LC_ALL, 'pt_BR');

    $clients = "SELECT nomecompleto, telefone, email, clienteID ";
    $clients .= " FROM clientes ";

    $dbResult = mysqli_query($connection, $clients);
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
    <title>Display Infos Clientes</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/clientList.css">

</head>
<body>
    <header>
        <?php include_once("../include/header.php"); ?>
    </header>
    <main>
        <?php
            while($row = mysqli_fetch_assoc($dbResult)) {
        ?>

            <div class="client">
                <h3><?php echo $row["nomecompleto"]?></h3>
                <ul>
                    <li class="general">Telefone: <?php echo $row["telefone"]?></li>
                    <li class="general">E-mail: <?php echo $row["email"]?></li>
                    <li><a href="order.php?clientID=<?php echo $row["clienteID"]?>&clientName=<?php echo $row["nomecompleto"]?>">Consultar pedidos</a></li>
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