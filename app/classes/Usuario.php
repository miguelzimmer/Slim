<?php

class Usuario
{
    private $pdo;


    // funçao para quando ser instanciada ja executar a conexão com banco
    public function __construct()
    {

        try {
            $this->pdo = new PDO("mysql:dbname=projeto;host=localhost", "root", "");
        } catch (PDOException $e) {
             $e->getMessage();
        }
    }
    //funçao para cadastrar usuarios
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
    // função para atualizar os dados do usuario
    public function atualizar($dados = [])
    {   //executando a query para fazer o update no banco
        $sql = $this->pdo->prepare("UPDATE usuarios SET tipo = :t WHERE id_usuario = :id");
        $sql->bindValue(":t", $dados["tipo"]);
        $sql->bindValue(":id", $dados["id_usuario"]);
        $sql->execute();
        return "Usuário atualizado com sucesso!";
    }
    // função logar
    public function logar($dados = [])
    {
        //Verificar se o email e senha estao cadastrados
        $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $dados["email"]);
        $sql->bindValue(":s", md5($dados["senha"]));
        $sql->execute();
        // verificando se a linha que vem do banco for maior que zero,se sim
        if($sql->rowCount() > 0) {
            //entrar no sistema (sessao)
            $dados = $sql->fetch();// funçao fetch pega o que vem do banco e transforma em array
            session_start();
            $_SESSION['tipo'] = $dados['tipo'];
            return $dados["tipo"]; //logado com sucesso
        } else {
            return false; // nao foi possivel logar
        }
    }
    //função listar usuarios
    public function listar()
    {   // query para selecionar id,nome,email,tipo da tabela usuarios
        $sql = $this->pdo->query("SELECT id_usuario, nome, email, tipo FROM usuarios", PDO::FETCH_ASSOC);//retornar apenas um valor único por nome da coluna.
        // vereficano se conta linha e maior que zero, se sim fetchaAll pega tudo e transforma em array
        return ($sql->rowCount() > 0) ? $sql->fetchAll() : [];
    }

}
