<?php
    function real_format($valor) {
        $valor  = number_format($valor,2,",",".");
        return "R$ " . $valor;
    }

    function send_mail($email, $subject, $message) {
        // Define email parameters
        $to= $email;
        $sub = $subject;
        $mes = $message;
        $headers='From: phpmailteste4@gmail.com' . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Send email
        mail($to, $sub, $mes, $headers);
    }

    function formatDateInput($date) {
        //28/04/2022

        $arr = explode("/",$date);
        $arr = array_reverse($arr);
        $arr = implode("-",$arr);
        $arr = $arr." 00:00:00";   //2022-04-28 00:00:00

        //echo $arr;

        return $arr;
    }


    function formatDateOuput($date) {

        //2022-05-05 00:00:00

        //comentar várias linhas : Shift+ Alt + A
        $arr = explode(" ",$date);
        $arr = $arr[0];
        $arr = explode("-",$arr);
        $arr = array_reverse($arr);
        $arr = implode("/",$arr);
  
        return $arr;
    }

    function functionDeleteOrder($pedidoID, $connection) {
        $delete = "DELETE FROM pedidos WHERE pedidoID = {$pedidoID}";
        $deleteSubmit = mysqli_query($connection, $delete);
        if(!$deleteSubmit) {

            $retorno["success"] = false;
            $retorno["message"] = "Erro ao remover o pedido";

            return $retorno;
        }

        $retorno["success"] = true;
        $retorno["message"] = "Pedido removido com sucesso!!";
        
        return $retorno;

    }
?>