<?php
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } else if ($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1) { 

    $y = 0;

    require_once 'CLASSES/fornecedores.php';
    $f = new Fornecedores;
    
    $f->conectar("tcc","localhost","root","");
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
    <link rel="stylesheet" type="text/css" href="CSS/styleFornecedores.css" />
    <link rel="icon" href="images/icon.jpg">
    
    <title>Fornecedores</title>
</head>

<body>
    <header>
        <h1>Fornecedores</h1>
        <div class="headericons">
            <a href="homePage.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            <a href="estoque.php"><i class="fa fa-archive" aria-hidden="true"></i> Estoque</a>
            <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
        </div>
    </header>
    <div class="barratarefas">
        <a href="adicionaFornecedores.php">Adicionar</a>
    </div>
    <?php 
        
    $itens_por_pagina = 6;
    $numlinks = $f->paginacao($itens_por_pagina);
    $pagina = (isset($_GET['page'])) ? $_GET['page'] : 0;	
    if (!$pagina) $pagina = 0;
    $start = $pagina * $itens_por_pagina;

    $fornecedores = $f->mostra($start,$itens_por_pagina);

    ?>
    <main>
        <table id="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Empresa</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>CEP</th>
                    <th>CNPJ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php   
                foreach ($fornecedores as $fornecedor){
                    
            ?>
                <tr>
                    <td><?= $fornecedor['id'] ?></td>
                    <td><?= $fornecedor['nome'] ?></td>
                    <td><?= $fornecedor['email'] ?></td>
                    <td><?= $fornecedor['telefone'] ?></td>
                    <td><?= $fornecedor['cep'] ?></td>
                    <td><?= $fornecedor['cnpj'] ?></td>
                    <td><a href='excluirFornecedor.php?id=<?= $fornecedor['id'] ?>'>
                    <img src="./images/remove.svg" alt="remover"></a></td>
                </tr>
            <?php } ?>
            </tbody>
            
        </table>
    </main>
        <div class="paginacao">
            <?php 
                if($start > 0){
                    echo "<a href='fornecedores.php?page=".($pagina-1)."' class='pag'>Anterior</a>";
                }
                for($i=0;$i<$numlinks;$i++){
                    $y = $i+1;
                    $class = ' ';
                    if ($pagina == $i){
                        $class = 'active';
                    } 
                    echo "<a href='fornecedores.php?page=".$i."' class='pag ".$class."'>$y</a>";
                }
                if($y > $pagina && $pagina < $numlinks-1){
                    echo "<a href='fornecedores.php?page=".($pagina+1)."' class='pag'>Proxima</a>";
                } 
            ?>
        </div>
</body>
</html>
<?php } else { 
        header("location: homePage.php");
        exit;
      }
?>