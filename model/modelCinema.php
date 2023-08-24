<?php

require_once 'connection.php';


class Cinema {

    function getSelectTipo(){
        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";
    
        $sql = "SELECT id, descricao FROM localidade";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $msg .= "<option value='".$row['id']."'>".$row['descricao']."</option>";
        }
        } else {
            $msg = "<option value='-1' disabled>Sem Localizações Registadas</option>";
        }
    
        $conn->close();
    
        return ($msg);
    
    }

    function getCinemas() {

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, nome FROM cinema";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $msg .= "<option value='".$row['id']."'>".$row['id']." - ".$row['nome']."</option>";
        }
        } else {
            $msg = "<option value='-1' disabled>Sem Cinemas Registados</option>";
        }

        $conn->close();

        return ($msg);
    }
    
    function getSalas() {

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, descricao FROM sala";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $msg .= "<option value='".$row['id']."'>".$row['descricao']."</option>";
        }
        } else {
            $msg = "<option value='-1' disabled>Sem Salas Registados</option>";
        }

        $conn->close();

        return ($msg);
    } 
    
    function registaCinema($nome, $telefone, $localidade, $email) {
    
        global $conn;
        $msg = "";
        $flag = true;
    
        $sql = "INSERT INTO cinema (nome, idLocalidade, telefone, email) VALUES ('".$nome."', '".$localidade."', '".$telefone."', '".$email."')";
        
    
        if ($conn->query($sql) === TRUE) {
    
            $lastInsertedId = $conn->insert_id; // Retrieve the last inserted ID
            
            $msg = "Cinema registado com sucesso";
    
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    
        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));
    
        return ($resp);
    }

    function getListaCinemas(){

        global $conn;
        $msg = "";
        session_start();
    
        $sql = "SELECT cinema.id, cinema.nome, cinema.idLocalidade, cinema.telefone, cinema.email, localidade.descricao 
                FROM cinema, localidade WHERE cinema.idLocalidade = localidade.id";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $msg .= "<tr>";
                $msg .= "<td>".$row['id']."</td>";
                $msg .= "<td>".$row['nome']."</td>";
                $msg .= "<td>".$row['descricao']."</td>";
                $msg .= "<td>".$row['telefone']."</td>";
                $msg .= "<td>".$row['email']."</td>";
    
                // Only show the edit button for tipoUtilizador 1 or 2
                if(isset($_SESSION['tipoUtilizador']) && ($_SESSION['tipoUtilizador'] == 1 || $_SESSION['tipoUtilizador'] == 2)) {
                    $msg .= "<td><button class='btn btn-warning' onclick = 'getDadosCinema(".$row['id'].")'><i class='bi bi-pencil-fill'></i></button></td>";
                } else {
                    $msg .= "<td>Sem permissão!</td>"; // Empty cell if not allowed to edit
                }
    
                // Show the remove button for tipoUtilizador 1
                if(isset($_SESSION['tipoUtilizador']) && $_SESSION['tipoUtilizador'] == 1) {
                    $msg .= "<td><button class='btn btn-danger' onclick = 'removerCinema(".$row['id'].")'><i class='bi bi-trash-fill'></i></button></td>";
                } else {
                    $msg .= "<td>Sem permissão!</td>"; // Empty cell if not allowed to remove
                }
    
                $msg .= "</tr>";
            }
        } else {
            $msg .= "<tr>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td>Sem Resultados!</td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "</tr>";
        }
    
        $conn->close();
    
        return ($msg);
    }
    
    
    function removerCinema($id){

        global $conn;
        $msg = "";
        $sql = "DELETE FROM cinema WHERE id = ".$id;
        $flag = true;

        if ($conn->query($sql) === TRUE) {
            $msg = "Cinema removido com sucesso";
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
          
        $conn->close();

        $res = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($res);
    }

    function getDadosCinema($id){
    
        global $conn;

        $conn->set_charset("utf8");
        
        $row = "";
        $msg = "";

    
        $sql = "SELECT * FROM cinema WHERE id = ".$id;
        $result = $conn->query($sql);

        $sql1 = "SELECT id, descricao FROM localidade";
        $result1 = $conn->query($sql1);
    
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
    
        }

        if ($result1->num_rows > 0) {
            while($row1 = $result1->fetch_assoc()) {
                $msg .= "<option value='".$row1['id']."'>".$row1['descricao']."</option>";
            }
        }
    
        $conn->close();
    
        $result = array('dadosCinema' => $row, 'localidade' => $msg);
    
        return json_encode($result);
    }
    

    function guardaEditCinema($id, $nome, $telefone, $localidade, $email){

        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE cinema SET nome = '".$nome."', idLocalidade = '".$localidade."', telefone = '".$telefone."', email = '".$email."' WHERE id = ".$id;

        if ($conn->query($sql) === TRUE) {
            $msg = "Alterado com sucesso";

        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
          
        $conn->close();

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($resp);


    }
    
}
