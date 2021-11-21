
<?php 
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } else if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1){ 

    require_once 'CLASSES/produtos.php';
    $p = new Produto;
    require_once 'CLASSES/fornecedores.php';
    $f = new Fornecedores;

    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }	else {
        echo 'Código não informado!';
        exit;
    } 

    $f->conectar("tcc","localhost","root","");
    $p->conectar("tcc","localhost","root","");
    $produtos = $p->selecionaProduto($id); 
    
?>
<?php ob_start(); ?> 
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
    <link rel="stylesheet" type="text/css" href="CSS/styleAdd.css" />
    <link rel="icon" href="images/icon.jpg">

    <title>Editar</title>
</head>

<body>
    <header>
        <h1 class="titulo">Editar Produtos</h1>
        <div class="headericons">
            <a href="homepage.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a>
            <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
        </div>
    </header>
    <div class="container">
        <div class="box">
            <form method="POST" id="form">
                <fieldset>
                    <h1>Produto <?= $produtos['id'] ?></h1>
                <div class="left">
                    <div class="campo">
                        <label>Código do Produto</label>
                        <input value="<?= $produtos['codigo'] ?>" type="text" name="codigo" 
                        id="codigo" maxlenght="11">
                        <small></small>
                    </div>
                    
                    <div class="campo">
                        <label>Nome</label>
                        <input value="<?= $produtos['produto'] ?>" type="text" name="nome" 
                        id="nome" maxlenght="30">
                        <small></small>
                    </div>

                    <div class="campo">
                        <label>Fornecedor</label>
                        <select name="fornecedor" id="fornecedor">
                            <option value="<?= $produtos['fornecedor'] ?>"><?= $produtos['fornecedor'] ?></option>
                                <?php
                                    $fornecedores = $f->fornecedor();
                                    foreach ($fornecedores as $fornecedor){
                                ?>
                                <option value=<?= $fornecedor['nome'] ?>><?= $fornecedor['nome'] ?></option>
                                <?php } ?>
                        </select>
                        <small></small>
                    </div>
                </div>
                <div class="right">
                    <div class="campo">
                        <label>Descrição</label>
                        <input value="<?= $produtos['descricao'] ?>" type="text" name="description" 
                        id="description" maxlenght="100">
                        <small></small>
                    </div>

                    <div class="campo">
                        <label>Quantidade</label>
                        <input value="<?= $produtos['quantidade'] ?>" type="number" name="qtd" 
                        id="qtd" maxlenght="11">
                        <small></small>
                    </div>

                    <div class="campo">
                        <label>Preço</label>
                        <input value="<?= number_format($produtos['valor'],2) ?>" type="number" placeholder="R$" 
                        name="price" id="price" step="0.01" min="0.1" maxlenght="10">
                        <small></small>
                    </div>
                </div>
                    <div class="campo cat">
                        <label for="categoria">Categoria</label>
                        <input value="<?= $produtos['categoria'] ?>" type="option" name="categoria" 
                        id="categorias" list="categoria">
                        <datalist id="categoria">
                            <option value="Alimentos"></option>
                            <option value="Bebidas"></option>
                            <option value="Padaria/Outros"></option>
                            <option value="Carnes"></option>
                            <option value="Laticínios/Frios"></option>
                            <option value="Higiene/Limpeza"></option>
                            <option value="Frutas/Legumes/Verduras"></option>
                        </datalist>
                        <small></small>
                    </div>
                    <div class="botao">
                        <button name="editar" type="submit" class="adiciona" >Salvar</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <script src="SCRIPT/required.js"></script>
</body>
<?php
    if(isset($_POST['editar'])){

        $name = addslashes(strip_tags($_POST['nome']));
        $cod = strip_tags($_POST['codigo']);
        $quantidade = strip_tags($_POST['qtd']);
        $descricao = addslashes(strip_tags($_POST['description']));
        $categoria = addslashes(strip_tags($_POST['categoria']));
        $preco = strip_tags($_POST['price']);
        $fornecedor = addslashes(strip_tags($_POST['fornecedor']));

        if(!empty($name) && !empty($cod) && !empty($quantidade) && !empty($descricao) && !empty($categoria) 
        && !empty($preco)){
            $p->conectar("tcc","localhost","root","");
            if($p->msgErro == ""){
                if($p->editar($name,$quantidade,$categoria,$preco,$descricao,$cod,$fornecedor,$id)){
                    header("Location:homePage.php");
                    exit();
                } else {
                    ?>
                    <div class="erro">
                        <small>Código já cadastrado</small>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="erro">
                    <small><?php echo "Erro: ".$p->msgErro; ?></small>
                </div>
                <?php
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
?>
</HTML> <?php ob_end_flush(); ?>
<?php
} else { 
    header("location: homePage.php");
    exit;
}
?>
