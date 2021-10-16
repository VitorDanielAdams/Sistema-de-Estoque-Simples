<?php

    Class Fornecedores{

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

        public function cadastrar($nome,$email,$cep,$telefone,$cnpj){
        
            global $pdo;
            
            $sql = $pdo->prepare("SELECT id FROM fornecedor WHERE nome = :n");
            $sql->bindValue(":n",$nome);
            $sql->execute();
            if($sql->rowCount() > 0){
                return false;
            } else {
                $sql = $pdo->prepare("INSERT INTO fornecedor (nome, email, cep, telefone, cnpj) 
                VALUES (:n, :e, :c, :t, :cnpj)");
                $sql->bindValue(":n",$nome);
                $sql->bindValue(":e",$email);
                $sql->bindValue(":c",$cep);
                $sql->bindValue(":t",$telefone);
                $sql->bindValue(":cnpj",$cnpj);
                $sql->execute();
        
                return true;
            }
        }

        public function mostra($pagina,$itens_por_pagina){
        
            global $pdo;
    
            $sql = "SELECT * FROM fornecedor LIMIT $pagina, $itens_por_pagina";
    
            $sql = $pdo->prepare($sql);
            $sql->execute();
            
            $fornecedores = $sql->fetchAll(PDO::FETCH_ASSOC);
    
            return $fornecedores;
        }

        public function deleta($id){

            global $pdo;
    
            $sql = $pdo->prepare("DELETE FROM fornecedor WHERE id = $id");
            $sql->execute();
    
            $organiza = $pdo->prepare("set @autoid :=0; 
            update fornecedor set id = @autoid := (@autoid+1);
            alter table fornecedor Auto_Increment = 1;");
            $organiza->execute();
    
        }

        public function fornecedor(){

            global $pdo;
    
            $sql = "SELECT nome FROM fornecedor";
            $sql = $pdo->prepare($sql);
            $sql->execute();
    
            $fornecedores = $sql->fetchAll(PDO::FETCH_ASSOC);
    
            return $fornecedores;
        }

        public function paginacao($itens_por_pagina){

            global $pdo;
    
            $sql = "SELECT COUNT(id) FROM fornecedor";
            $sql = $pdo->prepare($sql);
            $sql->execute();
    
            $row = $sql->fetch();
            $numrecords = $row[0];
    
            $numlinks = ceil($numrecords/$itens_por_pagina);
    
            return $numlinks;
    
        }

    }

?>