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
    $res = $sessao->filtrarSessoes($filmeId);
    echo($res);
}


?>