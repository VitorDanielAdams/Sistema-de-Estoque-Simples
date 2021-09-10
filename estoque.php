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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css ">
    <link rel="stylesheet" type="text/css" href="CSS/styleEstoque.css" />
    <title>Estoque</title>
</head>
<body>
    <header>
        <h1>Estoque</h1>
        <div class="headericons">
            <a href="homePage.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            <a href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
        </div>
    </header>
    <div class="barratarefas">
        <form method="GET">
            <button name="nome" type="submit" id="nome">
                <img src="./images/filter.svg" alt="filtrar">
            </button>
            <button name="id" type="submit" id="id">
                <img src="./images/filter-right.svg" alt="filtrar">
            </button>
        </form>
        <a href="fornecedores.php">Fornecedores</a>
    </div>
    <div class="barratarefas btn"> 
        <a href="entrada.php" name="entrada" id="entrada">Entrada</a>
        <a href="saida.php" name="saida" id="saida">Saida</a>
        <a href="export.php" id="excel"><img src="./images/excel.svg" alt="excel"></a>
    </div>
    <div class="filt-right">
        <form method="POST" class="form">
        <div class="searchbar-mes">
                <select name="mes">
                    <option value="">Mes</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
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
                <button name="pesq" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
    <?php 

    if (isset($_POST['pesq'])) {
        $category = addslashes($_POST['category']);
        $mes = addslashes($_POST['mes']);
        if(!empty($_POST['category']) && !empty($_POST['mes'])){
            $categoria = " WHERE categoria = '$category' AND MONTH(data) = '$mes'";
        } else if(!empty($_POST['category'])) {
            $categoria = " WHERE categoria = '$category' ";
        } else if(!empty($_POST['mes'])){
            $categoria = " WHERE MONTH(data) = '$mes' ";
        }  else {
            $categoria = '';
        }
        
    } else {
        $categoria = '';
    }
    if (isset($_GET['nome'])){
        $order = " ORDER BY produtos.produto ASC ";
        ?>
            <script>
                document.getElementById('nome').style.display = "none";
                document.getElementById('id').style.display = "block";
            </script>
        <?php
    } else {
        $order = " ORDER BY produtos.id ASC ";
        ?>
            <script>
                document.getElementById('id').style.display = "none";
                document.getElementById('nome').style.display = "block";
            </script>
        <?php
    }

    $produtos = $p->mostra($order, $categoria);

    ?>
    <form method="POST" action="control.php">
        <main>
            <table id="data-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Fornecedor</th>
                        <th class="center">Estoque</th>
                        <th class="center">Entradas</th>
                        <th class="center">Saidas</th>
                        <th class="center">Data de Alteração</th>
                        <th class="center">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php   
                    foreach ($produtos as $produto){
                            if($produto['quantidade'] <= 0) {
                                $color = '#6E0D25';
                            } else {
                                $color = '#141e30';
                            }
                        echo "
            
                            <tr style='color:".$color."'>
                
                        ";
                ?>      
                        <td><span onclick="copy(this)"><?= $produto['codigo'] ?></span></td>
                        <td><?= $produto['produto'] ?></td>
                        <td><?= $produto['fornecedor'] ?></td>
                        <td class="center"><?= $produto['quantidade'] ?></td>
                        <td class="center"><?= $produto['entrada'] ?></td>
                        <td class="center"><?= $produto['saida'] ?></td>
                        <td class="center"><?= $produto['data'] ?></td>
                        <td>
                            <?php echo " <div class='center status' 
                            style='background-color:".$color."'>";?>
                                <?php if($produto['quantidade'] > 0){
                                    echo "Disponivel";
                                  } else {
                                    echo "Indisponivel";
                                  }?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                
            </table>
        </main>
    </form>
    <?php if (!isset($_POST['pesq'])){ 
          } else {
                ?> 
                <div class="paginacao">
                    <?php
                        echo "<a href='estoque.php' class='pag'>Voltar</a>";
                    ?>
                </div>
                <?php
            }
        ?>
</body>
<script type="text/javascript">
    function copy(that){
        var inp =document.createElement('input');
        document.body.appendChild(inp)
        inp.value =that.textContent
        inp.select();
        document.execCommand('copy',false);
        inp.remove();
    }
</script>
<?php 
    } else { 
        header("location: homePage.php");
        exit;
    }
?>
</html>