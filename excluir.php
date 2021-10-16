<?php 
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } else if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1){ 
    require_once 'CLASSES/produtos.php';
    $p = new Produto;


    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }	else {
        echo 'Código não informado!';
        exit;
    }

    $p->conectar("tcc","localhost","root","");

    $p->deletaProduto($id);

    header("location: homepage.php");

    } else { 
        header("location: homePage.php");
        exit;
    }
?>
