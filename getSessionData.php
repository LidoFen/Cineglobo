<?php
session_start();

if (isset($_SESSION['tipoUtilizador'])) {
    $tipoUtilizador = $_SESSION['tipoUtilizador'];
    echo json_encode(array('tipoUser' => $tipoUtilizador));
} else {
    echo json_encode(array('tipoUser' => null));
}
?>

