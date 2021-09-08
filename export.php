<?php
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } else if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1) { 

    require_once 'CLASSES/produtos.php';
    $p = new Produto;

    $p->conectar("tcc","localhost","root","");

    $produtos = $p->selecionaTudo();
    
    $html = '<table><tr><th>Codigo</th><th>Nome</th><th>Valor</th><th>Categoria</th>
    <th>Fornecedor</th><th>Estoque</th><th>Entradas</th><th>Saidas</th>
    <th>Data de Alteracao</th></tr>';

    foreach ($produtos as $p){
        
        $html .= '<tr><td>'. $p['codigo'] .'</td><td>'. $p['produto'] .'</td>
        <td>'. $p['valor'] .'</td><td>'. $p['categoria'] .'</td>
        <td>'. $p['fornecedor'] .'</td><td>'. $p['quantidade'] .'</td>
        <td>'. $p['entrada'] .'</td><td>'. $p['saida'] .'</td>
        <td>'. $p['datacad'] .'</td></tr>';

    }

    $html .= '</table>';
    header('Content-Type:application/xls');
    header('Content-Disposition:attachment;filename=tabela.xls');
    echo $html;


    } else { 
        header("location: homePage.php");
        exit;
    }
?>