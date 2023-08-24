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
}

?>

