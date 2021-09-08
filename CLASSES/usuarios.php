<?php

Class Usuario{

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

    public function cadastrarConta($user,$password,$cargo){
        global $pdo;

        $sql = $pdo->prepare("SELECT id FROM login WHERE user = :u");
        $sql->bindValue(":u",$user);
        $sql->execute();
        if($sql->rowCount() > 0){
            return false;
        } else {
            $sql = $pdo->prepare("INSERT INTO login (user, password, type) VALUES (:u, :s, :t)");
            $sql->bindValue(":u",$user);
            $sql->bindValue(":s",md5($password));
            $sql->bindValue(":t",$cargo);
            $sql->execute();

            $organiza = $pdo->prepare("set @autoid :=0; 
            update login set id = @autoid := (@autoid+1);
            alter table login Auto_Increment = 1;");
            $organiza->execute();

            return true;
        }
    }

    public function cadastrarFuncionario($nome,$cargo,$turno,$telefone){
        
        global $pdo;

        $sql = $pdo->prepare("INSERT INTO funcionarios (nome, cargo, turno, telefone) 
        VALUES (:n, :c, :t, :tl)");
        $sql->bindValue(":n",$nome);
        $sql->bindValue(":c",$cargo);
        $sql->bindValue(":t",$turno);
        $sql->bindValue(":tl",$telefone);
        $sql->execute();

        return true;
        
    }

    public function logar($user, $password){

        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM login WHERE user = :e AND password = :s");
        $sql->bindValue(":e",$user);
        $sql->bindValue(":s",md5($password));
        $sql->execute();

        if($sql->rowCount() > 0){
            $dado = $sql->fetch();
            session_start();
            $_SESSION['rol'] = $dado['type'];
            $_SESSION['id_user'] = $dado['id'];
            return true;
        } else {
            return false;
        }
    }

    public function logged($id){

        global $pdo;

        $array = array();

        $sql = $pdo->prepare("SELECT user FROM login WHERE id = :id");
        $sql->bindValue(":id",$id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch();
        }

        return $array;

    }

    public function mostraFuncionarios($pagina,$itens_por_pagina){

        global $pdo;

        $sql = "SELECT * FROM funcionarios INNER JOIN login on funcionarios.id = login.id 
        ORDER BY funcionarios.id LIMIT $pagina,$itens_por_pagina";
        $sql = $pdo->prepare($sql);
        $sql->execute();
            
        $funcionarios = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $funcionarios;
    }

    public function alterarSenha($id, $oldPassword,$password){

        global $pdo;
        
        $sql = $pdo->prepare("SELECT id FROM login WHERE id = '$id' AND password != :s");
        $sql->bindValue(":s",md5($oldPassword));
        $sql->execute();
        if($sql->rowCount() > 0){
            return false;
        } else {
            $newPassword = md5($password);
            $sql = $pdo->prepare("UPDATE login SET password = '$newPassword' WHERE id = $id");
            $sql->execute();

            return true;
        }
    }

    public function mostraPesquisa($busca){

        global $pdo;

        $sql = "SELECT * FROM funcionarios INNER JOIN login on funcionarios.id = login.id WHERE nome LIKE '%$busca%' OR user = '$busca'";
        $sql = $pdo->prepare($sql);
        $sql->execute();
            
        $funcionarios = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $funcionarios;
    }

    public function selecionaFuncionario($id){

        global $pdo;

        $sql = "SELECT * FROM funcionarios INNER JOIN login on funcionarios.id = login.id WHERE funcionarios.id = $id";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $funcionarios = $sql->fetch();

        return $funcionarios;
    }

    public function editarConta($user,$cargo,$id){

        global $pdo;
        
        $sql = $pdo->prepare("SELECT id FROM login WHERE user = :u AND id != :i");
        $sql->bindValue(":u",$user);
        $sql->bindValue(":i",$id);
        $sql->execute();
        if($sql->rowCount() > 0){
            return false;
        } else {
            $sql = $pdo->prepare("UPDATE login SET user = '$user', type = '$cargo' WHERE id = $id AND id != 1");
            $sql->execute();

            return true;
        }
    }

    public function editarFuncionario($nome,$cargo,$turno,$telefone,$id){

        global $pdo;
        
        $sql = $pdo->prepare("UPDATE funcionarios SET nome = '$nome', cargo = '$cargo', 
        turno = '$turno', telefone = '$telefone' WHERE id = $id AND id != 1");
        $sql->execute();

        return true;
       
    }

    public function deletaFuncionario($id){

        global $pdo;

        $sql = $pdo->prepare("DELETE FROM funcionarios WHERE id = $id AND cargo != 0");
        $sql->execute();

        $organiza = $pdo->prepare("set @autoid :=0; 
        update funcionarios set id = @autoid := (@autoid+1);
        alter table funcionarios Auto_Increment = 1;");
        $organiza->execute();

        $sql = $pdo->prepare("DELETE FROM login WHERE id = $id AND type != 0");
        $sql->execute();

        $organiza = $pdo->prepare("set @autoid :=0; 
        update login set id = @autoid := (@autoid+1);
        alter table login Auto_Increment = 1;");
        $organiza->execute();

    }

    public function paginacao($itens_por_pagina){

        global $pdo;

        $sql = "SELECT COUNT(id) FROM funcionarios";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $row = $sql->fetch();
        $numrecords = $row[0];

        $numlinks = ceil($numrecords/$itens_por_pagina);

        return $numlinks;

    }

    public function senha($id){

        global $pdo;

        $sql = "SELECT password FROM login WHERE id = $id";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        $senha = $sql->fetch();

        return $senha;

    }
}

?>