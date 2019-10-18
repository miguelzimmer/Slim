<?php

class Usuario
{
    private $pdo;
    public $msgErro = "";

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:dbname=projeto;host=localhost", "root", "");
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }

    public function cadastrar($dados = [])
    {
        #Verificando se ja existe um email cadastrado
        $sql = $this->pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
        #para alterar o (:e) da query utilizei o bindValue
        $sql->bindValue(":e", $dados["email"]);
        $sql->execute();
        #Contando as linhas que vai vim do banco de dados
        if($sql->rowCount() > 0) {
            return "Usuário já cadastrado!";  // ja esta cadastrado
        } else {
            // caso nao, Cadastrar
            $sql = $this->pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES(:n,:e,:s,:t)");
            $sql->bindValue(":n", $dados["nome"]);
            $sql->bindValue(":e", $dados["email"]);
            $sql->bindValue(":s" ,md5($dados["senha"]));
            $sql->bindValue(":t", $dados["tipo"]);
            $sql->execute();

            return "Usuário cadastrado com sucesso!";
        }
    }

    public function logar($dados = [])
    {
        //Verificar se o email e senha estao cadastrados,se sim
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $dados["email"]);
        $sql->bindValue(":s", md5($dados["senha"]));
        $sql->execute();

        if($sql->rowCount() > 0) {
            //entrar no sistema (sessao)
            $dados = $sql->fetch();// funçao fetch pega o que vem do banco e transforma em array
            session_start();
            $_SESSION['id_usuario'] = $dados['id_usuario'];
            return $dados["tipo"]; //logado com sucesso
        } else {
            return false; // nao foi possivel logar
        }
    }
    public function listar()
    {
        $sql = $this->pdo->query("SELECT id_usuario, nome, email, tipo FROM usuarios", PDO::FETCH_ASSOC);

        return ($sql->rowCount() > 0) ? $sql->fetchAll() : [];
    }

}
