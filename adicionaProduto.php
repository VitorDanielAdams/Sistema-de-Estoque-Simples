<?php 
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } else if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1){ 

    require_once 'CLASSES/produtos.php';
    $p = new Produto;

    require_once 'CLASSES/usuarios.php';
    $u = new Usuario;

    require_once 'CLASSES/fornecedores.php';
    $f = new Fornecedores;

    $f->conectar("tcc","localhost","root","");
    $u->conectar("tcc","localhost","root","");
    $user = $u->logged($_SESSION['id_user']);
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
    <link rel="stylesheet" type="text/css" href="CSS/styleAdd.css" />

    <title>Adicionar Produto</title>
</head>

<body>
    <header>
        <h1>Adicionar Produtos</h1>
        <div class="headericons">
            <a href="homePage.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            <a href="fornecedores.php"><i class="fa fa-phone-square" aria-hidden="true"></i> Fornecedores</a>
            <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
        </div>
    </header>

    <div class="container">
        <div class="box">
            <form method="POST" id="form">
                <fieldset>
                    <h1>Novo Produto</h1>
                    
                    <div class="campo">
                        <label>Código do Produto</label>
                        <input type="number" name="codigo" id="codigo" maxlength="11" >
                        <small></small>
                    </div>

                    <div class="campo">
                        <label>Nome</label>
                        <input type="text" name="nome" id="nome" maxlenght="30">
                        <small></small>
                    </div>

                    <div class="campo">
                        <label>Fornecedor</label>
                        <select name="fornecedor" id="fornecedor">
                                <option value="hide"></option>
                                <?php
                                    $fornecedores = $f->fornecedor();
                                    foreach ($fornecedores as $fornecedor){
                                ?>
                                <option value=<?= $fornecedor['nome'] ?>><?= $fornecedor['nome'] ?></option>
                                <?php } ?>
                            </select>
                        <small></small>
                    </div>

                    <div class="campo">
                        <label>Descrição</label>
                        <input type="text" name="description" id="description" maxlenght="100">
                        <small></small>
                    </div>

                    <div class="campo">
                        <label>Quantidade</label>
                        <input type="number" name="qtd" id="qtd" maxlenght="11">
                        <small></small>
                    </div>

                    <div class="campo">
                        <label>Preço</label>
                        <input type="number" placeholder="R$" name="price" id="price" step="0.01" 
                        min="0.1" maxlenght="10">
                        <small></small>
                    </div>

                    <div class="campo cat">
                        <label for="categoria">Categoria</label>
                        <input type="option" name="categoria" id="categorias" list="categoria" 
                        placeholder="Selecione">
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
                        <button name="salvar" type="submit" class="adiciona" 
                        onclick="return checkInputs();">Adicionar</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <script src="SCRIPT/required.js"></script>
</body>

<?php
    if(isset($_POST['salvar'])){

        $name = addslashes($_POST['nome']);
        $cod = $_POST['codigo'];
        $quantidade = $_POST['qtd'];
        $descricao = addslashes($_POST['description']);
        $fornecedor = addslashes($_POST['fornecedor']);
        $categoria = addslashes($_POST['categoria']);
        $preco = $_POST['price'];

        if (!empty($name) && !empty($cod) &&  !empty($quantidade) && !empty($descricao) 
        && $fornecedor != 'hide' && !empty($categoria) && !empty($preco)){
            $p->conectar("tcc","localhost","root","");
            if($p->msgErro == ""){
                if($p->cadastrar($name,$quantidade,$categoria,$preco,$descricao,
                $user['user'],$cod,$fornecedor)){
                    ?>
                    <div class="sucess">
                        <small>Cadastrado com sucesso</small>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="erro">
                        <small>Produto já cadastrado</small>
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
} else { 
    header("location: homePage.php");
    exit;
}
?>
</html>