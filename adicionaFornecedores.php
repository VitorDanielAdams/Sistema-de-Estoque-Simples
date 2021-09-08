<?php
session_start();
if(!isset($_SESSION['id_user'])){
    header("location: index.php");
    exit;
} else if ($_SESSION['rol'] == 0){ 

require_once 'CLASSES/fornecedores.php';
$f = new Fornecedores;

require_once 'CLASSES/produtos.php';
$p = new Produto;

$p->conectar("tcc","localhost","root","");
$f->conectar("tcc","localhost","root","");
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css ">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="CSS/styleAddFornecedor.css" />
        <title>Cadastro de Fornecedor</title>
    </head>

    <body>
        <header>
            <h1>Adicionar Fornecedor</h1>
            <div class="headericons">
                <a href="fornecedores.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a>
                <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
            </div>
        </header>
        <!--Form Cadastro-->
        <div class="container">
            <div class="box">
                <form method="POST" id="form">
                    <div class="title">
                        <span>Informações</span>
                    </div>
                    <div class="input">
                        <input type="text" name="nome" placeholder="Nome do Fornecedor" id="nome" maxlength="30">
                        <small></small>
                    </div>
                    <div class="input">
                        <input type="text" name="email" placeholder="Email da Empresa" id="email" maxlength="50">
                        <small></small>
                    </div>
                    <div class="input">
                        <input type="text" name="cep" placeholder="CEP" id="cep" maxlength="11">
                        <small></small>
                    </div>
                    <div class="input">
                        <input type="number" name="telefone" placeholder="Telefone" id="telefone" maxlength="11">
                        <small></small>
                    </div>
                    <div class="input">
                        <input type="tex" name="cnpj" placeholder="Cnpj" id="cnpj" maxlength="18">
                        <small></small>
                    </div>
                    <button name="salvar" type="submit" onclick="return checkInputs();">Cadastrar</button>
                </form>
            </div>
        </div>
        <script src="SCRIPT/requiredfornecedores.js"></script>
    </body>
<?php
    if(isset($_POST['salvar'])){
        $nome = addslashes($_POST['nome']);
        $email =  addslashes($_POST['email']);
        $cep = addslashes($_POST['cep']);
        $telefone = $_POST['telefone'];
        $cnpj = addslashes($_POST['cnpj']);

        if(!empty($nome) && !empty($email) && !empty($cep) && !empty($telefone) && !empty($cnpj)){
            $f->conectar("tcc","localhost","root","");
            if($f->msgErro == ""){
                if($f->cadastrar($nome,$email,$cep,$telefone,$cnpj)){
                    ?>
                        <div class="sucess">
                            <small>Cadastrado com sucesso</small>
                        </div>
                    <?php
                } else {
                    ?>
                        <div class="erro">
                            <small>Fornecedor ja cadastrado</small>
                        </div>
                    <?php
                }
            } else {
                ?>
                    <div class="erro">
                        <small><?php echo "Erro: ".$f->msgErro; ?></small>
                    </div>
                <?php
            }
        } else {
            ?>
                <script>
                    form.addEventListener('submit', (e) => {
                        checkInputs();
                        if (!checkInputs()) {
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