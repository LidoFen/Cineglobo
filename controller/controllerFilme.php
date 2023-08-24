<?php

require_once '../model/modelFilme.php';

$filme = new Filme();

if ($_POST['op'] == 1) {
    $res = $filme->registaFilme(
        $_POST['nomeFilme'],
        $_POST['descricaoFilme'],
        $_POST['selectTipoFilme'],
        $_FILES
    );

    echo ($res);

}else if ($_POST['op'] == 2) {
    $res = $filme->getSelectTipo();

    echo ($res);

}else if ($_POST['op'] == 3) {
    $filmes = $filme->getFilmes();
    if ($filmes !== false) {
        echo json_encode(array("flag" => true, "filmes" => $filmes));
    } else {
        echo json_encode(array("flag" => false));
    }

}else if ($_POST['op'] == 4) {
    $res = $filme->getFilmesSelect();

    echo ($res);

}else if($_POST['op'] == 5){
    $res = $filme -> removerFilme($_POST['id']);
    echo($res);

}else if($_POST['op'] == 6){
    $res = $filme -> getDadosFilme($_POST['id']);
    echo($res);

}else if($_POST['op'] == 7){
    $res = $filme -> guardaEditFilme(
        $_POST['id'],
        $_POST['nome'],
        $_POST['descricao'],
        $_POST['tipo'],
        $_FILES
    );
    
    echo ($res);

}else if($_POST['op'] == 8){
    $res = $filme -> getInfo($_POST['id']);
    echo($res);

}
