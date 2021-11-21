<?php
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } else if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1) { 

    require_once 'CLASSES/produtos.php';
    $p = new Produto;

    $p->conectar("tcc","localhost","root","");

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css ">
    <link rel="stylesheet" type="text/css" href="CSS/styleControle.css" />
    <link rel="icon" href="images/icon.jpg">
    
    <title>Saída</title>
</head>
<body>
    <header>
        <h1>Controle de Estoque</h1>
        <div class="headericons">
        <a href="estoque.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a>
            <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
        </div>
    </header>
    <div class="container">
        <div class="box">
            <form method="POST">
                <h1 class="title">Retirar do Estoque</h1>
                <div class="center">
                    <div class="input">
                        <label>Código do Produto</label>
                        <input type="number" name="codigo" id="codigo" maxlength="11" >
                        <small></small>
                    </div>
                    <div class="input">
                        <label>Quantidade</label>
                        <input type="text" name="quantidade" id="quantidade" maxlenght="11">
                        <small></small>
                    </div>
                </div>
                <button name="salvar" type="submit" onclick="return checkInputs();">Retirar</button>
            </form>
        </div>
    </div>
    <script src="SCRIPT/requiredestoque.js"></script>
</body>
<?php
if(isset($_POST['salvar'])){
    $cod = strip_tags($_POST['codigo']);
    $quantidade = strip_tags($_POST['quantidade']);

    $produtos = $p->selecionaCodigoProduto($cod);
    $estoque = 0;
    if($quantidade < 0){
        $quantidade = $quantidade * -1;
    }
    foreach($produtos as $prod){
        
        $estoque_total = $prod['quantidade'];
        $estoque = $prod['quantidade'] - $quantidade;

    }
    if(!empty($quantidade) && !empty($cod)){
        $p->conectar("tcc","localhost","root","");
        if($estoque < 0){
            ?>
                <div class="erro">
                    <small>Estoque insuficiente</small>
                    <small>Quantidade disponivel no estoque: <?php echo $estoque_total ?></small>
                </div>
            <?php
            } else {
            if($p->updateSaida($estoque,$cod,$quantidade)){
                header("Location: estoque.php");
            } else {
                ?>
                    <div class="erro">
                        <small>Código não existe</small>
                    </div>
                <?php
            }
        }
    } else {
            ?>
                <script>
                    form.addEventListener('submit', (e) => {   
                        checkInputs();
                        if(!checkInputs()){
                            e.preventDefault();
                        }
                    });
                </script>
            <?php
    }
}
    } else { 
        header("location: homePage.php");
        exit;
    }
?>
