<?php 

    session_start();

    include_once("connection.php");
    include_once("url.php");

    $data = $_POST;

    // MODIFICAÇÂO NO BANCO
    if(!empty($data)) {

        //print_r($data); exit;

        // CRIAR CONTATO
        if($data["type"] === "create") {

            $name = $_POST["name"];
            $phone = $data["phone"];
            $observations = $data["observations"];

            $query = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations)";

            $stmt = $conexao->prepare($query);

            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":observations", $observations);

            try {

                $stmt->execute();
                $_SESSION["msg"] = "Contato criado com sucesso!";

            } catch (PDOException $e) {
                //Erro na conexão
                $error = $e->getMessage();
                echo "Erro: $error";
            } 

        }else if($data["type"] === "edit") {

            $name = $data["name"];
            $phone = $data["phone"];
            $observations = $data["observations"];
            $id = $data["id"];

            $query = "UPDATE contacts SET name = :name, phone = :phone, observations = :observations WHERE id = :id";

            $stmt = $conexao->prepare($query);

            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":observations", $observations);
            $stmt->bindParam(":id", $id);

            try {

                $stmt->execute();
                $_SESSION["msg"] = "Contato atualizado com sucesso!";

            } catch (PDOException $e) {
                //Erro na conexão
                $error = $e->getMessage();
                echo "Erro: $error";
            } 

        }else if($data["type"] === "delete") {

            $id = $data["id"];

            $query = "DELETE FROM contacts WHERE id = :id";

            $stmt = $conexao->prepare($query);

            $stmt->bindParam(":id", $id);

            try {

                $stmt->execute();
                $_SESSION["msg"] = "Contato deletado com sucesso!";

            } catch (PDOException $e) {
                //Erro na conexão
                $error = $e->getMessage();
                echo "Erro: $error";
            } 
        }

        // VOLTAR PARA HOME
        header("Location:" . $BASE_URL . "../index.php");

    // SELEÇÂO DE DADOS
    } else {

        $id;

        if(!empty($_GET)) {
            $id = $_GET["id"];
        }
    
        // RETORNA O DADO DE UM CONTATO
    
        if(!empty($id)) {
    
            $query = "SELECT * FROM contacts WHERE id = :id";
    
            $stmt = $conexao->prepare($query);
    
            $stmt->bindParam(":id", $id);
    
            $stmt->execute();
    
            $contact = $stmt->fetch();
    
        } else {
            
            // RETORNA TODOS OS CONTATOS
    
            $contacts = [];
    
            $query = "SELECT * FROM contacts";
    
            $stmt = $conexao->prepare($query);
    
            $stmt->execute();
    
            $contacts = $stmt->fetchAll();
        }
    }

    // FECHAR CONEXAO

    $conexao = null;
?>