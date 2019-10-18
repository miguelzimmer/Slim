<?php

class Produto
{
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:dbname=projeto;host=localhost", "root", "");
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }
    // public function cadastrar($dados = [])
    // {
    //     #Verificando se ja existe um email cadastrado
    //     $sql = $this->pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
    //     #para alterar o (:e) da query utilizei o bindValue
    //     $sql->bindValue(":e", $dados["email"]);
    //     $sql->execute();
    //     #Contando as linhas que vai vim do banco de dados
    //     if($sql->rowCount() > 0) {
    //         return "Usuário já cadastrado!";  // ja esta cadastrado
    //     } else {
    //         // caso nao, Cadastrar
    //         $sql = $this->pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES(:n,:e,:s,:t)");
    //         $sql->bindValue(":n", $dados["nome"]);
    //         $sql->bindValue(":e", $dados["email"]);
    //         $sql->bindValue(":s" ,md5($dados["senha"]));
    //         $sql->bindValue(":t", $dados["tipo"]);
    //         $sql->execute();

    //         return "Usuário cadastrado com sucesso!";
    //     }
    // }
}
