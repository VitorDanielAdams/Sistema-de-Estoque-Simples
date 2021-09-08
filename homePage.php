<?php
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index.php");
        exit;
    } 

    $y = 0;

    require_once 'CLASSES/usuarios.php';
    $u = new Usuario;

    $u->conectar("tcc","localhost","root","");

    if($u->logged($_SESSION['id_user'])){
        $user = $u->logged($_SESSION['id_user']);
    } else {
        header("location: index.php");
        exit;
    }

    require_once 'CLASSES/produtos.php';
    $p = new Produto;
    $p->conectar("tcc","localhost","root","");

?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;500&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="CSS/styleHome.css">

        <title>Lista</title>
    </head>

    <body>
        <header>
            <h1>Lista de produtos</h1>
            <div class="headericons">
                <a><i class="fa fa-user" aria-hidden="true"></i> Ola, <?= $user['user'] ?></a>
                <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
            </div>
        </header>
        <div class="barratarefas">
            <form method="POST">
                <button name="nome" type="submit" id="nome">
                    <img src="./images/filter.svg" alt="filtrar">
                </button>
                <button name="id" type="submit" id="id">
                    <img src="./images/filter-right.svg" alt="filtrar">
                </button>
                <script>
                    document.getElementById('id').style.display = "none";
                </script>
            </form>
            <?php if($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1){ ?>
            <a href="adicionaProduto.php">Adicionar</a>
            <a href="estoque.php">Estoque</a>
            <?php 
            }
            if($_SESSION['rol'] == 0){ ?>
            <a href="funcionarios.php">Funcionarios</a>
            <?php } ?>
        </div>
        <form method="POST" class="form">
            <div class="searchbar">
                <input name="busca" placeholder="Procure pelo produto">
            </div>
            <div class="searchbar">
            <select name="category">
                <option value="">Categorias</option>
                <option value="Alimentos">Alimentos</option>
                <option value="Bebidas">Bebidas</option>
                <option value="Padaria/Outros">Padaria/Outros</option>
                <option value="Carnes">Carnes</option>
                <option value="Laticínios/Frios">Laticínios/Frios</option>
                <option value="Higiene/Limpeza">Higiene/Limpeza</option>
                <option value="Frutas/Legumes/Verduras">Frutas/Legumes/Verduras</option>
            </select>
            </div>
            <button type="submit" name="pesq"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    <?php 
    
    $itens_por_pagina = 6;
    $numlinks = $p->paginacao($itens_por_pagina);
    $pagina = (isset($_GET['page'])) ? $_GET['page'] : 0;	
    if (!$pagina) $pagina = 0;
    $start = $pagina * $itens_por_pagina;

    

    if (isset($_POST['pesq'])) {

        $busca = addslashes($_POST['busca']);
        $category = addslashes($_POST['category']);

        if(!empty($_POST['category'])) {

           $produtos = $p->mostraCategoria($category);

        } else if (!empty($_POST['category']) && !empty($_POST['busca'])){

           $produtos = $p->mostraCategoriaBusca($category);

        } else if(!empty($_POST['busca'])){

            $produtos = $p->mostraPesquisa($busca);

        } else {
            $produtos = $p->mostraTudo($start,$itens_por_pagina);
        }
            
    } else if (isset($_POST['nome'])){

        $produtos = $p->ordenarNome();

    ?>
        <script>
            document.getElementById('nome').style.display = "none";
            document.getElementById('id').style.display = "block";
        </script>
    <?php
    } else if (isset($_POST['id'])){

        $produtos = $p->ordenarId(); 
        
    ?>
       <script>
            document.getElementById('id').style.display = "none";
            document.getElementById('nome').style.display = "block";
        </script>
    <?php
    } else {

        $produtos = $p->mostraTudo($start,$itens_por_pagina);

    }
    ?>
        <main>
            <table id="data-table">
                <thead>
                    <!-- título das colunas -->
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Disponibilidade</th>
                        <th class="center">Categoria</th>
                        <th></th>
                        <?php if($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1){ ?>
                        <th></th>
                        <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <?php 
                    
                    foreach ($produtos as $p){
                ?>
                    <tbody>
                        <tr>
                            <td>
                                <?= $p['codigo'] ?>
                            </td>
                            <td>
                                <?= $p['produto'] ?>
                            </td>
                            <td>R$
                                <?= number_format($p['valor'], 2)?>
                            </td>
                            <td>
                                <?php if($p['quantidade'] > 0){
                                    echo "Disponivel";
                                  } else {
                                    echo "Indisponivel";
                                  }?>
                            </td>
                            <td class="center">
                                <?= $p['categoria'] ?>
                            </td>

                            <td>
                                <a href='produto.php?id=<?= $p['id'] ?>'>
                                    <img src="./images/up.svg" alt="detalhar">
                                </a>
                            </td>
                            <?php if($_SESSION['rol'] == 0 || $_SESSION['rol'] == 1){ ?>
                            <td>
                                <a href='editar.php?id=<?= $p['id'] ?>'>
                                    <img src="./images/edit.svg" alt="editar">
                                </a>
                            </td>
                            <td>
                                <a href='excluir.php?id=<?= $p['id'] ?>'>
                                    <img src="./images/remove.svg" alt="remover">
                                </a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
            </table>
        </main>
        <?php if (!isset($_POST['pesq']) && !isset($_POST['nome']) && !isset($_POST['id'])){ ?>
        <div class="paginacao">
            <?php 
                if($start > 0){
                    echo "<a href='homePage.php?page=".($pagina-1)."' class='pag'>Anterior</a>";
                }
                for($i=0;$i<$numlinks;$i++){
                    $y = $i+1;
                    $class = ' ';
                    if ($pagina == $i){
                        $class = 'active';
                    } 
                    echo "<a href='homePage.php?page=".$i."' class='pag ".$class."'>$y</a>";
                }
                if($y > $pagina && $pagina < $numlinks-1){
                    echo "<a href='homePage.php?page=".($pagina+1)."' class='pag'>Proxima</a>";
                } 
            ?>
        </div>
        <?php 
            } else {
                ?> 
                <div class="paginacao">
                    <?php
                        echo "<a href='homePage.php' class='pag'>Voltar</a>";
                    ?>
                </div>
                <?php
            }
        ?>
    </body>

    </html>