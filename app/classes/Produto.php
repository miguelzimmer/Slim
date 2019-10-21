<?php

class Produto
{
    private $pdo;
    public $msg = "";

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:dbname=projeto;host=localhost", "root", "");
        }
            catch (PDOException $e) {
            $msg = $e->getMessage();
        }

    }

    public function cadastrar($dados = [])
    {
        #Verificando se ja existe um produto cadastrado
        $sql = $this->pdo->prepare("SELECT id_produto FROM produtos WHERE nome = :n");
        #para alterar o (:n) da query utilizei o bindValue
        $sql->bindValue(":n",$dados["nome"]);
        $sql->execute();
        #Contando as linhas que vai vim do banco de dados
        if($sql->rowCount() > 0) {
            return "Produto já cadastrado!";  // ja esta cadastrado
        } else {
            // caso nao, Cadastrar
            $sql = $this->pdo->prepare("INSERT INTO produtos (nome,valor,quantidade) VALUES(:n,:v,:q)");
            $sql->bindValue(":n", $dados["nome"]);
            $sql->bindValue(":v", $dados["valor"]);
            $sql->bindValue(":q", $dados["quantidade"]);
            $sql->execute();

            return "Produto cadastrado com sucesso!";
        }
    }

    public function listar()
    {
        $sql = $this->pdo->query("SELECT id_produto, nome, valor, quantidade FROM produtos", PDO::FETCH_ASSOC);

        return ($sql->rowCount() > 0) ? $sql->fetchAll() : [];
    }

    /**
     * Pegar o valor total de todos os produtos cadastrados
     */
    public function getValorTotal()
    {
        $sql = $this->pdo->query("SELECT valor, quantidade FROM produtos");

        $valor_total = 0;

        if ($sql->rowCount() > 0) {
            $produtos = $sql->fetchAll();

            foreach ($produtos as $produto) {
                $valor_total += intval($produto["valor"]) * intval($produto["quantidade"]);
            }
        }

        return $valor_total;
    }

}
