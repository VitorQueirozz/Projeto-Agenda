<?php 

    $host = "localhost";
    $dbname = "agenda";
    $user = "root";
    $pass = "";

    try {

        $conexao = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

        //ATIVAR O MODO DE ERROS
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        //Erro na conexão
        $error = $e->getMessage();
        echo "Erro: $error";
    }
?>