<?php
require_once 'CLASSES/usuarios.php';
$u = new Usuario;
?>

<!DOCTYPE html>
<html>

<head>
<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" type="text/css" href="CSS/style.css"/>
    <link rel="icon" href="images/icon.jpg">
    
    <title>Tela de login </title>
</head>

<body>
    <div class="container">
        <div class="box">
            <!--Form Login-->
            <form method="POST" id="form">
                <div class="title">
                    <span>Login</span>
                </div>
                <div class="input">
                    <input value="<?php if(isset($_COOKIE["user"])) { echo $_COOKIE["user"]; } ?>" 
                    type="text" name="user" placeholder="Usuário" id="user">
                    <small></small>
                </div>
                <div class="input">
                    <input value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" 
                    type="password" name="password" placeholder="Senha" id="password">
                    <small></small>
                    <span class="eye">
                        <i class="fa fa-eye" aria-hidden="true" id="show" onclick="toggle()"></i>
                        <i class="fa fa-eye-slash" aria-hidden="true" id="hide" onclick="toggle()"></i>
                    </span>
                </div>
                <div class="check">
                    <input type="checkbox" id="rem" name="remeber">
                    <label for="rem">Lembrar-me</label>
                </div>
                <button type="submit" name="logar" onclick="return checkInputs();">Entrar</button>
            </form>
        </div>
    </div>
    <script src="SCRIPT/main.js"></script>
</body>
<?php
if(isset($_POST['logar'])){
    $user = addslashes($_POST['user']);
    $password = addslashes($_POST['password']);

    if(!empty($user) && !empty($password)){
        $u->conectar("tcc","localhost","root","");
        if($u->msgErro == ""){
            if($u->logar($user,$password)){
                if(!empty($_POST['remeber'])){
                    setcookie("user",$user,time()+ (10 * 365 * 24 * 60 * 60));
                    setcookie ("password",$password,time()+ (10 * 365 * 24 * 60 * 60));
                } else {
                    if(isset($_COOKIE["user"])){  
                        setcookie ("user","");  
                    }  
                    if(isset($_COOKIE["password"])){  
                        setcookie ("password","");  
                    }  
                }
                header("location: homepage.php");
            } else {
                setcookie ("user","");
                setcookie ("password","");  
                ?>
                <script>
                    setErrorFor(userName," ");
                    setErrorFor(inputPassword,"Usuário e/ou senha incorretos");
                </script>
                <?php
            }
        } else {
            ?>
            <div class="input error">
                <small><?php echo "Erro: ".$u->msgErro; ?></small>
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
</html>