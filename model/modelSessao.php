<?php

require_once 'connection.php';


class Sessao {

    function registaSessao($descricao, $cinema, $filme, $sala, $horario) {
    
        global $conn;
        $msg = "";
        $flag = true;
    
        $horario = str_replace(['T'], [', '], $horario);
        $horario .= 'm';

        $sql = "INSERT INTO sessao (descricao, idCinema, idFilme, idSala, horario) VALUES ('".$descricao."', '".$cinema."', '".$filme."', '".$sala."', '".$horario."')";
        
    
        if ($conn->query($sql) === TRUE) {
    
            $lastInsertedId = $conn->insert_id; // Retrieve the last inserted ID
            
            $msg = "Sessão registada com sucesso";
    
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

    function getListaSessoes(){

        global $conn;
        $msg = "";
        session_start();
    
        $sql = "SELECT sessao.id, sessao.descricao, cinema.nome AS nomeCinema, filme.nome AS nomeFilme, sala.descricao AS nomeSala, sessao.horario
                FROM sessao, cinema, filme, sala 
                WHERE cinema.id = sessao.idCinema AND filme.id = sessao.idFilme AND sala.id = sessao.idSala";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $msg .= "<tr>";
                $msg .= "<td>".$row['id']."</td>";
                $msg .= "<td>".$row['descricao']."</td>";
                $msg .= "<td>".$row['nomeCinema']."</td>";
                $msg .= "<td>".$row['nomeFilme']."</td>";
                $msg .= "<td>".$row['nomeSala']."</td>";
                $msg .= "<td>".$row['horario']."</td>";


                if(isset($_SESSION['tipoUtilizador']) && ($_SESSION['tipoUtilizador'] == 1 || $_SESSION['tipoUtilizador'] == 2)) {
                    $msg .= "<td><button class='btn btn-warning' onclick = 'getDadosSessao(".$row['id'].")'><i class='bi bi-pencil-fill'></i></button></td>";
                } else {
                    $msg .= "<td>Sem permissão!</td>"; 
                }
    
                if(isset($_SESSION['tipoUtilizador']) && $_SESSION['tipoUtilizador'] == 1) {
                    $msg .= "<td><button class='btn btn-danger' onclick = 'removerSessao(".$row['id'].")'><i class='bi bi-trash-fill'></i></button></td>";
                } else {
                    $msg .= "<td>Sem permissão!</td>";
                }

                $msg .= "</tr>";
            }
        } else {
            $msg .= "<tr>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "</tr>";
        }
    
        $conn->close();
    
        return ($msg);
    }

    function filtrarSessoes($filmeId){
        global $conn;
        $msg = "";
        
        // Use the $filmeId to filter the results
        $sql = "SELECT sessao.id, sessao.descricao, cinema.nome AS nomeCinema, filme.nome AS nomeFilme, sala.descricao AS nomeSala, sessao.horario
                FROM sessao, cinema, filme, sala 
                WHERE cinema.id = sessao.idCinema AND filme.id = sessao.idFilme AND sala.id = sessao.idSala
                AND filme.id = '$filmeId'";
        
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $msg .= "<tr>";
                $msg .= "<td>".$row['id']."</td>";
                $msg .= "<td>".$row['descricao']."</td>";
                $msg .= "<td>".$row['nomeCinema']."</td>";
                $msg .= "<td>".$row['nomeFilme']."</td>";
                $msg .= "<td>".$row['nomeSala']."</td>";
                $msg .= "<td>".$row['horario']."</td>";
                $msg .= "</tr>";
            }
        } else {
            $msg .= "<tr>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "<td>N/D</td>";
            $msg .= "</tr>";
        }
    
        $conn->close();
    
        return ($msg);
        
        $conn->close();
    
        return ($msg);
    }

    function removerSessao($id) {
        global $conn;

        $msg = "";
        $sql = "DELETE FROM sessao WHERE id = ".$id;
        $flag = true;

        if ($conn->query($sql) === TRUE) {
            $msg = "Sessao removida com sucesso";
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

    function getDadosSessao($id){
    
        global $conn;

        $conn->set_charset("utf8");
        
        $row = "";
        $msg = "";


    
        $sql = "SELECT * FROM sessao WHERE id = ".$id;
        $result = $conn->query($sql);

    
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
    
        }

    
        $conn->close();
    
        $result = $row;
    
        return json_encode($result);
    }

    function guardaEditSessao($id, $descricao, $cinema, $filme, $sala, $horario){

        global $conn;
        $msg = "";
        $flag = true;

        $horario = str_replace(['T'], [', '], $horario);
        $horario .= 'm';

        $sql = "UPDATE sessao SET descricao = '".$descricao."', idCinema = '".$cinema."', idFilme = '".$filme."', idSala = '".$sala."', horario = '".$horario."' WHERE id = ".$id;

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

?>

