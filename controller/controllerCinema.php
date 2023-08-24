<?php

require_once '../model/modelCinema.php';

$cinema = new Cinema();

if ($_POST['op'] == 1) {
    $res = $cinema->registaCinema(
        $_POST['nomeCinema'],
        $_POST['telefoneCinema'],
        $_POST['selectLocalCinema'],
        $_POST['emailCinema']
    );

    echo ($res);

}else if ($_POST['op'] == 2) {
    $res = $cinema->getSelectTipo();

    echo ($res);

}else if($_POST['op'] == 3){

    $res = $cinema -> getListaCinemas();
    echo($res);

}else if ($_POST['op'] == 4) {
    $res = $cinema->getCinemas();

    echo ($res);

}else if ($_POST['op'] == 5) {
    $res = $cinema->getSalas();

    echo ($res);

}else if($_POST['op'] == 6){

    $res = $cinema -> removerCinema($_POST['id']);
    echo($res);

}else if($_POST['op'] == 7){

    $res = $cinema -> getDadosCinema($_POST['id']);
    echo($res);

}else if($_POST['op'] == 8){

    $res = $cinema->guardaEditCinema(
        $_POST['id'],
        $_POST['nome'],
        $_POST['telefone'],
        $_POST['localidade'],
        $_POST['email']
    );

    echo($res);

}
