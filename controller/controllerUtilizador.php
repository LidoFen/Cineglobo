<?php

require_once '../model/modelUtilizador.php';

$utilizador = new Utilizador();

if ($_POST['op'] == 1) {
    $res = $utilizador->registaUtilizador(
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],
        $_POST['tipoUtilizador']
    );

    echo ($res);

}else  if ($_POST['op'] == 2) {
    $res = $utilizador->getSelectTipo();

    echo ($res);

} else if($_POST['op'] == 3){
    $resp = $utilizador -> login($_POST['username'],$_POST['password']);
    echo($resp);
}else if($_POST['op'] == 4){
    $resp = $utilizador -> logout();
    echo($resp);
}