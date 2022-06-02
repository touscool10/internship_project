<?php require_once("../../conexao/conexao.php"); ?>

<?php
    // Excluir tranportadora
    if(isset($_POST["data_saida"])  && $_POST["data_saida"] != '' ) {

        $data = $_POST["data_saida"];
        echo $data; 
        
    }

    // Consulta Banco Dados
   /*  if(isset($_GET["codigo"])) {
        $id     = $_GET["codigo"];
        $tr     = "SELECT * FROM transportadoras WHERE transportadoraID = {$id}";
        $consulta_tr = mysqli_query($conecta, $tr);
        if(!$consulta_tr) {
            die("erro consulta banco");
        }
    } else {
        header("Location: listagem.php");
    }

    $info_transportadora = mysqli_fetch_assoc($consulta_tr); */
?>
