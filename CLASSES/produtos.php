<?php

Class Produto{

    private $pdo;
    public $msgErro = "";

    public function conectar($nome, $host, $user, $password){

        global $pdo;

        try{
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$user,$password);
        } catch (PDOException $e){
            $msgErro = $e->getMessage();
        }
        

    }

    public function cadastrar($name,$quantidade,$categoria,$preco,$descricao,$user,$cod,$fornecedor){
        
        global $pdo;

        $sql = $pdo->prepare("SELECT id FROM produtos WHERE codigo = :cd");
        $sql->bindValue(":cd",$cod);
        $sql->execute();
        if($sql->rowCount() > 0){
            return false;
        } else {
            $sql = $pdo->prepare("INSERT INTO produtos (produto, codigo, quantidade, categoria, valor, 
            descricao, user, fornecedor, datacad, data) VALUES (:n, :cd, :q, :c, :p, :d, :u, :f, :m, :data)");
            $data = date("Y-m-d");
            $sql->bindValue(":n",$name);
            $sql->bindValue(":cd",$cod);
            $sql->bindValue(":q",$quantidade);
            $sql->bindValue(":f",$fornecedor);
            $sql->bindValue(":c",$categoria);
            $sql->bindValue(":p",$preco);
            $sql->bindValue(":d",$descricao);
            $sql->bindValue(":u",$user);
            $sql->bindValue(":m",$data);
            $sql->bindValue(":data",$data);
            $sql->execute();

            return true;
        }
    }

    public function editar($name,$quantidade,$categoria,$preco,$descricao,$cod,$fornecedor,$id){

        global $pdo;
        
        $sql = $pdo->prepare("SELECT id FROM produtos WHERE codigo = :cd AND id != :i");
        $sql->bindValue(":cd",$cod);
        $sql->bindValue(":i",$id);
        $sql->execute();
        if($sql->rowCount() > 0){
            return false;
        } else {
            $data = date("Y-m-d");
            $sql = $pdo->prepare("UPDATE produtos SET produto = '$name', codigo = '$cod', 
            quantidade = '$quantidade', categoria = '$categoria', fornecedor = '$fornecedor',
            valor = '$preco', descricao = '$descricao', data = '$data' WHERE id = $id");
            $sql->execute();

            return true;
        }
    }

    public function updateEntrada($quantidade,$cod,$entrada){

        global $pdo;
        
        $sql = $pdo->prepare("SELECT id FROM produtos WHERE codigo = '$cod'");
        $sql->execute();
        if($sql->rowCount() <= 0){
            return false;
        } else {
            $data = date("Y-m-d");
            $sql = $pdo->prepare("UPDATE produtos SET quantidade = '$quantidade', 
            entrada = '$entrada', data = '$data' WHERE codigo = '$cod'");
            $sql->execute();

            return true;
        }
    }

    public function updateSaida($quantidade,$cod,$saida){

        global $pdo;

        $sql = $pdo->prepare("SELECT id FROM produtos WHERE codigo = '$cod'");
        $sql->execute();
        if($sql->rowCount() <= 0){
            return false;
        } else {
            $data = date("Y-m-d");
            $sql = $pdo->prepare("UPDATE produtos SET quantidade = '$quantidade', 
            saida = '$saida', data = '$data' WHERE codigo = '$cod'");
            $sql->execute();

            return true;
        }
    }

    public function paginacao($itens_por_pagina){

        global $pdo;

        $sql = "SELECT COUNT(id) FROM produtos";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $row = $sql->fetch();
        $numrecords = $row[0];

        $numlinks = ceil($numrecords/$itens_por_pagina);

        return $numlinks;

    }

    public function mostraCategoria($category){

        global $pdo;

        $sql = "SELECT * FROM produtos WHERE categoria = '$category'";
        $sql = $pdo->prepare($sql);
        $sql->execute();
            
        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;
    }

    public function mostraCategoriaBusca($category,$busca){

        global $pdo;

        $sql = "SELECT * FROM produtos WHERE categoria = '$category' AND busca LIKE '%$busca%'";
        $sql = $pdo->prepare($sql);
        $sql->execute();
        
        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;
    }

    public function mostra($order, $category){
        
        global $pdo;

        $sql = "SELECT * FROM produtos " .$category. "" .$order;

        $sql = $pdo->prepare($sql);
        $sql->execute();
        
        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;
    }

    public function mostraPesquisa($busca){

        global $pdo;

        $sql = "SELECT * FROM produtos WHERE produto LIKE '%$busca%' OR codigo = '$busca'";
        $sql = $pdo->prepare($sql);
        $sql->execute();
            
        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);


        return $produtos;
    }

    public function mostraTudo($pagina,$itens_por_pagina){

        global $pdo;

        $sql = "SELECT * FROM produtos LIMIT $pagina, $itens_por_pagina";
        $sql = $pdo->prepare($sql);
        $sql->execute();
        
        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;

    }

    public function selecionaProduto($id){

        global $pdo;

        $sql = "SELECT * FROM produtos WHERE id = $id";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $produtos = $sql->fetch();

        return $produtos;
    }

    public function selecionaCodigoProduto($cod){

        global $pdo;

        
        $sql = "SELECT * FROM produtos WHERE codigo = '$cod'";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;
    }

    public function deletaProduto($id){

        global $pdo;

        $sql = $pdo->prepare("DELETE FROM produtos WHERE id = $id");
        $sql->execute();

        $organiza = $pdo->prepare("set @autoid :=0; 
        update produtos set id = @autoid := (@autoid+1);
        alter table produtos Auto_Increment = 1;");
        $organiza->execute();

    }

    public function detalhaProduto($id){

        global $pdo;

        $sql = "SELECT * FROM produtos WHERE id = $id";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;
    }

    public function ordenarNome(){

        global $pdo;

        $sql = "SELECT * FROM produtos ORDER BY produtos.produto ASC";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;
    }

    public function ordenarId(){

        global $pdo;

        $sql = "SELECT * FROM produtos ORDER BY produtos.id ASC";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;
    }

    public function selecionaTudo(){

        global $pdo;

        $sql = "SELECT * FROM produtos";
        $sql = $pdo->prepare($sql);
        $sql->execute();
        
        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $produtos;

    }

}

?>