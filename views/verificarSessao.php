<?php
session_start();

if (isset($_GET['logout'])){
    session_destroy();
    session_unset();
    header('Location: listaClientes.php');
}

if (!isset($_SESSION['usuario'])){
    header('Location: login.php');
}
