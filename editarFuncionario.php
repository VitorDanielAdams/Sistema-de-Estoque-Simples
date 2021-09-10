<?php
session_start();
if(!isset($_SESSION['id_user'])){
    header("location: index.php");
    exit;
} else if ($_SESSION['rol'] == 0){ 

require_once 'CLASSES/usuarios.php';
$u = new Usuario;

if(isset($_GET['id'])) {
    $id = $_GET['id'];
}	else {
    echo 'Código não informado!';
    exit;
}

$u->conectar("tcc","localhost","root","");
$funcionarios = $u->selecionaFuncionario($id); 

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
        
        <link rel="stylesheet" type="text/css" href="CSS/styleCadastro.css" />
        <link rel="icon" href="images/icon.jpg">

        <title>Tela de Cadastro</title>
    </head>

    <body>
        <header>
            <h1>Editar Cadastro</h1>
            <div class="headericons">
                <a href="funcionarios.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a>
                <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
            </div>
        </header>
        <!--Form Cadastro-->
        <div class="container">
            <div class="box">
                <form method="POST" id="form">
                    <div class="title">
                        <span>Funcionario <?= $funcionarios['id'] ?></span>
                    </div>
                    <div class="input">
                        <input type="text" value="<?= $funcionarios['nome'] ?>" name="nome" 
                        placeholder="Nome" id="nome" maxlength="30">
                        <small></small>
                    </div>
                    <div class="select">
                        <select name="cargo" id="cargo" >
                            <option value="<?= $funcionarios['cargo'] ?>">Cargo</option>
                            <option value=0>Administrador</option>
                            <option value=1>Gerente</option>
                            <option value=2>Funcionario</option>
                        </select>
                        <small></small>
                    </div>
                    <div class="input">
                        <input type="text" value="<?= $funcionarios['turno'] ?>" name="turno" 
                        placeholder="Turno" id="turno" maxlength="20">
                        <small></small>
                    </div>
                    <div class="input">
                        <input type="number" value="<?= $funcionarios['telefone'] ?>" name="telefone" 
                        placeholder="Telefone" id="telefone" maxlength="20">
                        <small></small>
                    </div>
                    <div class="input">
                        <input type="text" value="<?= $funcionarios['user'] ?>" name="user" 
                        placeholder="Usuário" id="user" maxlength="30">
                        <small></small>
                    </div>
                    <button name="salvar" type="submit" onclick="return checkInputs();">Salvar</button>
                </form>
            </div>
        </div>
        <script src="SCRIPT/requiredfuncionarios.js"></script>
    </body>
<?php
    if(isset($_POST['salvar'])){
        $nome = addslashes($_POST['nome']);
        $cargo = $_POST['cargo'];
        $telefone = $_POST['telefone'];
        $turno = addslashes($_POST['turno']);
        $user = addslashes($_POST['user']);

        if(!empty($nome) && !empty($turno) && !empty($telefone) && !empty($user)){
            $u->conectar("tcc","localhost","root","");
            if($u->msgErro == ""){
                if($u->editarConta($user,$cargo,$id) && $u->editarFuncionario($nome,$cargo,$turno,$telefone,$id)){
                    header("location: funcionarios.php");
                } else {
                    ?>
                        <div class="erro">
                            <small>Usuario já cadastrado</small>
                        </div>
                    <?php
                }
            } else {
                ?>
                    <div class="erro">
                        <small><?php echo "Erro: ".$u->msgErro; ?></small>
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