<?php

require_once '../model/modelSessao.php';

$sessao = new Sessao();

if ($_POST['op'] == 1) {
    $res = $sessao->registaSessao(
        $_POST['descricaoSessao'],
        $_POST['cinemaSessao'],
        $_POST['filmeSessao'],
        $_POST['salaSessao'],
        $_POST['horarioSessao']
    );  

    echo ($res);

}else if($_POST['op'] == 2){

    $res = $sessao -> getListaSessoes();
    echo($res);

}else if($_POST['op'] == 3){
    $filmeId = $_POST['filmeId'];
    $res = $sessao -> filtrarSessoes($filmeId);
    echo($res);
}else if($_POST['op'] == 4){

    $res = $sessao -> removerSessao($_POST['id']);
    echo($res);

}else if($_POST['op'] == 5){

    $res = $sessao -> getDadosSessao($_POST['id']);
    echo($res);

}else if($_POST['op'] == 6){

    $res = $sessao -> guardaEditSessao(
        $_POST['id'],
        $_POST['descricao'],
        $_POST['cinema'],
        $_POST['filme'],
        $_POST['sala'],
        $_POST['horario']
    );

    echo($res);

}


?>