<?php 
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } else if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1){ 
    require_once 'CLASSES/usuarios.php';
    $u = new Usuario;


    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }	else {
        echo 'Código não informado!';
        exit;
    }

    $u->conectar("tcc","localhost","root","");

    $u->deletaFuncionario($id);

    header("location: funcionarios.php");

    } else { 
        header("location: homePage.php");
        exit;
    }
?>