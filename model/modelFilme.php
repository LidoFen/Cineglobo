<?php

require_once 'connection.php';


class Filme {

    function getFilmesSelect() {

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, nome FROM filme";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $msg .= "<option value='".$row['id']."'>".$row['id']." - ".$row['nome']."</option>";
        }
        } else {
            $msg = "<option value='-1' disabled>Sem Filmes Registados</option>";
        }

        $conn->close();

        return ($msg);

    }

    function getSelectTipo(){
        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, descricao FROM tipofilme";
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

    function uploads($img, $nomeFilme){


        $dir = "../cartazesFilmes/".$nomeFilme."/";
        $dir1 = "cartazesFilmes/".$nomeFilme."/";
        $flag = false;
        $targetBD = "";
    
        if(!is_dir($dir)){
            if(!mkdir($dir, 0777, TRUE)){
                die ("Erro, não é possivel criar o diretório");
            }
        }
      if(array_key_exists('cartazFilme', $img)){
        if(is_array($img)){
          if(is_uploaded_file($img['cartazFilme']['tmp_name'])){
            $fonte = $img['cartazFilme']['tmp_name'];
            $ficheiro = $img['cartazFilme']['name'];
            $end = explode(".",$ficheiro);
            $extensao = end($end);
    
            $newName = "cartaz_".$nomeFilme."_dataEnv_".date("Ymd_H_i_s").".".$extensao;
    
            $target = $dir.$newName;
            $targetBD = $dir1.$newName;
    
            $flag = move_uploaded_file($fonte, $target);
            
          } 
        }
      }
        return (json_encode(array(
            "flag" => $flag,
            "target" => $targetBD
        )));
    
    
    }

    function updateFilmeImg($diretorio, $lastInsertedId){
        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE filme SET cartaz = '".$diretorio."' WHERE id =".$lastInsertedId;

        if ($conn->query($sql) === TRUE) {
            $msg = "Imagem adicionada com sucesso";
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
          

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($resp);
    }

    function registaFilme($nomeFilme, $descricaoFilme, $tipoFilme, $img) {

        global $conn;
        $msg = "";
        $flag = true;

        $sql = "INSERT INTO filme (nome, descricao, idTipo) VALUES ('".$nomeFilme."', '".$descricaoFilme."', '".$tipoFilme."')";
        

        if ($conn->query($sql) === TRUE) {

        $lastInsertedId = $conn->insert_id; // Retrieve the last inserted ID

        $msg = "Filme registado com sucesso";
        $resp = $this -> uploads($img, $nomeFilme);

        $res = json_decode($resp, TRUE);

        if($res['flag']){
            $this->updateFilmeImg($res['target'], $lastInsertedId);
        }

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

    function getFilmes() {
        global $conn;
        $filmes = array();

        $sql = "SELECT filme.id, filme.nome, filme.descricao as descricaoFilme, filme.cartaz, tipofilme.descricao AS descricaoTipo FROM filme, tipofilme WHERE filme.idTipo = tipofilme.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $filmes[] = array(
                    "id" => $row['id'],
                    "nome" => $row['nome'],
                    "descricao" => $row['descricaoFilme'],
                    "tipo" => $row['descricaoTipo'],
                    "cartaz" => $row['cartaz']
                );
            }
        }

        $conn->close();

        return $filmes;
    }

    function removerFilme($id){
        global $conn;
        $msg = "";
        $flag = true;

        $sql = "DELETE FROM filme WHERE id = ".$id;

        if ($conn->query($sql) === TRUE) {
            $msg = "Removido com Sucesso";
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));
          
        $conn->close();

        return($resp);
    }

    function getDadosFilme($id){
        
        global $conn;

        $conn->set_charset("utf8");
        
        $row = "";
        $msg = "";

    
        $sql = "SELECT * FROM filme WHERE id = ".$id;
        $result = $conn->query($sql);

        $sql1 = "SELECT id, descricao FROM tipofilme";
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
    
        $result = array('dadosFilme' => $row, 'tipoFilme' => $msg);
    
        return json_encode($result);
    }

    function guardaEditFilme($id, $nome, $descricao, $tipo, $cartaz){
        
        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE filme SET nome = '".$nome."', descricao = '".$descricao."', idTipo = '".$tipo."' WHERE id =".$id;
        

        if ($conn->query($sql) === TRUE) {


            $msg = "Filme registado com sucesso";
            $resp = $this -> uploads($cartaz, $nome);

            $res = json_decode($resp, TRUE);

            if($res['flag']){
                $this->updateFilmeImg($res['target'], $id);
            }

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
 
    function getInfo($id){

        global $conn;
        $msg = "";
        $msg1 = "";

        $sql = "SELECT * FROM filme WHERE id = ".$id;
        $result = $conn->query($sql);
        

        $sql1 = "SELECT tipofilme.id AS tipoFilmeID, tipofilme.descricao AS nomeTipo FROM tipofilme INNER JOIN filme ON tipofilme.id = filme.idTipo WHERE filme.id = ".$id;
        $result1 = $conn->query($sql1);

        

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {

                $row1 = $result1->fetch_assoc();


                $msg .= "<tr>";
                $msg .= "<td>".$row['id']."</td>";
                $msg .= "<td>".$row['nome']."</td>";
                $msg .= "<td>".$row['descricao']."</td>";
                $msg .= "<td>".$row1['nomeTipo']."</td>";
                $msg .= "<td><img src='".$row['cartaz']."' height='200px'></td>";
                $msg .= "</tr>";

            }   
        }



        $conn->close();

        return (json_encode($msg, JSON_UNESCAPED_UNICODE));

    }
}


?>