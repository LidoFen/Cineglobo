<?php

require_once 'connection.php';


class Utilizador {

    function getSelectTipo(){
        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";
    
        $sql = "SELECT id, descricao FROM tipouser";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $msg .= "<option value='".$row['id']."'>".$row['descricao']."</option>";
        }
        } else {
            $msg = "<option value='-1' disabled>Sem Tipos Registados</option>";
        }
    
        $conn->close();
    
        return ($msg);
    
    }
    
    
    function registaUtilizador($username, $password, $email, $tipoUtilizador) {
    
        global $conn;
        $msg = "";
        $flag = true;
    
        $sql = "INSERT INTO user (username, password, email, idTipo) VALUES ('".$username."', '".md5($password)."', '".$email."', '".$tipoUtilizador."')";
        
    
        if ($conn->query($sql) === TRUE) {
    
            $lastInsertedId = $conn->insert_id; // Retrieve the last inserted ID
            
            $msg = "Utilizador registado com sucesso";
    
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }

    
        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        $conn->close();
    
        return ($resp);
    }

    function wFicheiro($texto){
        $file = '../logs.txt';
        // Open the file to get existing content
        $current = file_get_contents($file);
        // Append a new person to the file
        $current .= $texto."\n";
        // Write the contents back to the file
        file_put_contents($file, $current);
    }

    function wFicheiroError($texto){
        $file = '../error.txt';
        // Open the file to get existing content
        $current = file_get_contents($file);
        // Append a new person to the file
        $current .= $texto."\n";
        // Write the contents back to the file
        file_put_contents($file, $current);
    }

    function login($username, $password){
        global $conn;
        $msg = "";
        $flag = true;
        session_start();
    
        
        if (isset($_SESSION['username'])) {
            $msg = "Já tem sessão iniciada com o username ".$_SESSION['username'].". Faça logout primeiro";
            $flag = false;
        } else {
            $sql = "SELECT * FROM user WHERE username LIKE '".$username."' AND password LIKE '".md5($password)."'";
    
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                
                $row = $result->fetch_assoc();
                $msg = "Bem-vindo, ".$row['username']." !";
                $_SESSION['username'] = $row['username'];
                $_SESSION['tipoUtilizador'] = $row['idTipo'];
    
                
                $textoLog = "Login com sucesso: ID: " . $row['id'] . ", Username: " . $row['username'] . ", Data: " . date('Y-m-d H:i:s');
                $this-> wFicheiro($textoLog);
            } else {
                $flag = false;
                $msg = "Erro! Dados Inválidos";
    
               
                $textoLogErro = "Login Falhado: Username: " . $username . ", Data: " . date('Y-m-d H:i:s');
                $this -> wFicheiroError($textoLogErro);
            }
        }
    
        $conn->close();
    
        return (json_encode(array(
            "msg" => $msg,
            "flag" => $flag,
        )));
    }
    
    


    function logout() {

        session_start();
        $msg = "";
        $flag = true;

        if(isset($_SESSION['username'])) {

            session_destroy();
            $msg = "Sessão Terminada";
            
            return (json_encode(array(
                "msg" => $msg,
                "flag" => $flag,
            )));

        } else {

            $flag = false;
            $msg = "Nenhuma sessão ativa.";
            return (json_encode(array(
                "msg" => $msg,
                "flag" => $flag,
            )));
        }
    }
    
        
        
     
        
        

}
