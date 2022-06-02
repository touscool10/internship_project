<?php
    function real_format($valor) {
        $valor  = number_format($valor,2,",",".");
        return "R$ " . $valor;
    }

    function mostrarAviso($numero) {
        $array_erro = array(
            UPLOAD_ERR_OK => "Arquivo publicado com sucesso.",
            UPLOAD_ERR_INI_SIZE => "O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.",
            UPLOAD_ERR_FORM_SIZE => "O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML",
            UPLOAD_ERR_PARTIAL => "O upload do arquivo foi feito parcialmente.",
            UPLOAD_ERR_NO_FILE => "Nenhum arquivo foi enviado.",
            UPLOAD_ERR_NO_TMP_DIR => "Pasta temporária ausente.",
            UPLOAD_ERR_CANT_WRITE => "Falha em escrever o arquivo em disco.",
            UPLOAD_ERR_EXTENSION => "Uma extensão do PHP interrompeu o upload do arquivo."
        );

        return $array_erro[$numero];
    }

    function uploadArquivo($arquivo_publicado, $folder) {
        if($arquivo_publicado["error"] == 0) {
            $pasta_temporaria   = $arquivo_publicado['tmp_name'];
            $arquivo            = alterarNome($arquivo_publicado['name']);
            $pasta              = $folder;
            $tipo               = $arquivo_publicado["type"];
            $extensao           = strrchr($arquivo,".");
            
            if($tipo == "image/png" || $tipo == "image/jpeg"){
                if(move_uploaded_file($pasta_temporaria, $pasta . "/" . $arquivo)){
                    $mensagem = mostrarAviso($arquivo_publicado["error"]);
                } else {
                    $mensagem = "Erro na publicação.";
                }
            } else{
                $mensagem = "Erro: Arquivo não pode ter a extensão" . $extensao;
            }
        } else {
            $mensagem = mostrarAviso($arquivo_publicado["error"]);
        }

        return array($mensagem, $arquivo);
    }

    function alterarNome($arquivo) {
        $extensao   = strrchr($arquivo,".");
        $alfabeto   = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $tamanho    = 12;
        $letra      = "";
        $resultado  = "";

        for($i = 1; $i <= $tamanho; $i ++) {
            $letra      = substr($alfabeto, rand(0,strlen($alfabeto)-1), 1);
            $resultado .= $letra;
        }

        $agora = getdate();
        $codigo_ano = $agora["year"] . "_" . $agora["yday"];
        $codigo_data = $agora["hours"] . $agora["minutes"] . $agora["seconds"];

        return "img_" . $resultado . "_" . $codigo_ano . "_" . $codigo_data . $extensao;
    }

    function enviarMensagem($dados) {
        // Dados do formulário
        $nome               =       $dados["nome"];
        $email              =       $dados["email"];
        $mensagem_usuario   =       $dados["mensagem"];

        // Criar variáveis de destino
        $destino            =       "touscool10@gmail.com";
        $remetente          =       "setondenougbodohoue17@gmail.com";
        $assunto            =       "Duvidas sobre produtos";

        // Montar o corpo do email
        $mensagem           =       "O usuário " . $nome . " enviou uma mensagem." . "\n";
        $mensagem           .=       "Email do usuário " . $email ."\n";
        $mensagem           .=       "Mensagem: " . $mensagem_usuario ."\n";

        //5 – agora inserimos as codificações corretas e  tudo mais.
       
        $headers = "From: setondenougbodohoue17@gmail.com";
        

        return mail($destino, $assunto, $mensagem, $headers);
    }

    function barraDePesquisa($action, $method, $source) {

    return '

                "<form action="' . $action . 'method = "'. $method. '">
                    <input type="text" name="produto" placeholder = "Buscar">
                    <input type="image" name="pesquisa" src="'.$source.'">
                </form>
            ';
    }

    function convertDateFromDB($data) {

        //from 2007-12-22 00:00:00   to      22/12/2007                                         

        $arr = explode(" ",$data);   // ['2007-12-22', '00:00:00']
        $arr =    $arr[0]; // 2007-12-22
        $arr =  explode("-",$arr); // [2007, 12, 22]
        $arr = array_reverse($arr,); // [22, 12, 2007]
        $arr =  implode("/",$arr); 

        return $arr;
    }

    function convertDateIntoDB($data) {

        // from 2022-05-27T17:43 to 2007-12-22 00:00:00 

    }

    
?>

