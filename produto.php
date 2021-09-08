<?php
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    }
    require_once 'CLASSES/produtos.php';
    require_once 'CLASSES/usuarios.php';
    $u = new Usuario;
    $p = new Produto;

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }	else {
        echo 'Código não informado!';
        exit;
    }

    $p->conectar("tcc","localhost","root","");
    $produtos = $p->detalhaProduto($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/styleProduto.css">
    <title>Informações</title>
</head>
<body>
<header>
        <h1>Produto</h1>
        <div class="headericons">
            <a href="homepage.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a>
            <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
        </div>
    </header>
    
            <?php       
                foreach ($produtos as $p){
            ?>
        <div class="container">
            <div class="box">
                <div class="title">
                    <label>Produto: </label>
                    <label> <?= $p['produto'] ?></label>
                </div>
                <div class="left">
                    <div class="text">
                        <label>Código: </label>
                        <div class="border">
                            <label><?= $p['codigo'] ?></label>
                        </div>
                    </div>
                    <div class="text">
                        <label>Categoria: </label>
                        <div class="border">
                            <label><?= $p['categoria'] ?></label>
                        </div>
                    </div>
                    <div class="text">
                        <label>Estoque: </label>
                        <div class="border">
                            <label><?= $p['quantidade'] ?></label>
                        </div>
                    </div>
                    <div class="text">
                        <label>Status: </label>
                        <div class="border">
                            <label><?php if($p['quantidade'] > 0){
                                                echo "Disponivel";
                                            } else {
                                                echo "Indisponivel";
                                            }
                            ?> </label>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="text">
                        <label>Fornecedor: </label>
                        <div class="border">
                            <label><?= $p['fornecedor'] ?></label>
                        </div>
                    </div>
                    <div class="text">
                        <label>Valor: </label>
                        <div class="border">
                            <label> R$ <?= number_format($p['valor'],2) ?></label>
                        </div>
                    </div>
                    <div class="text">
                        <label>Usuario de Cadastro: </label>
                        <div class="border">
                            <label><?= $p['user'] ?></label>
                        </div>
                    </div>
                    <div class="text">
                        <label>Data de Alteração: </label>
                        <div class="border">
                            <label><?= $p['data'] ?></label>
                        </div>
                    </div>
                </div>
                <div class="center">
                    <div class="textdesc">
                        <label>Descrição: </label>
                        <div class="desc">
                            <label><?= $p['descricao'] ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>    
</body>

</html>