<?php 
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } else if ($_SESSION['rol'] == 0){ 
    require_once 'CLASSES/fornecedores.php';
    $f = new Fornecedores;


    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }	else {
        echo 'Código não informado!';
        exit;
    }

    $f->conectar("tcc","localhost","root","");

    $f->deleta($id);

    header("location: fornecedores.php");

    } else { 
        header("location: homePage.php");
        exit;
    }
?>