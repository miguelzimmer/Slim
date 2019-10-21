<?php

class Produto
{
    private $pdo;
    public $msg = "";
    // funçao para quando ser instanciada ja executar a conexão com banco
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:dbname=projeto;host=localhost", "root", "");
        }
            catch (PDOException $e) {
            $msg = $e->getMessage();
        }

    }
    //funçao para cadastrar produtos
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
    //função listar produtos
    public function listar()
    {
        /**   // query para selecionar id,nome,valor,quantidade da tabela produtos,
         * usando o fetch_assoc que retornar apenas um valor único por nome da coluna
        */
        $sql = $this->pdo->query("SELECT id_produto, nome, valor, quantidade FROM produtos", PDO::FETCH_ASSOC);
        return ($sql->rowCount() > 0) ? $sql->fetchAll() : [];
    }
    //função para pega valor total de todos os produtos
    public function getValorTotal()
    {
        $sql = $this->pdo->query("SELECT valor, quantidade FROM produtos");
        $valor_total = 0;
        //if para contar as linhas,maior que zero produtos recebe tudo em array
        if ($sql->rowCount() > 0) {
            $produtos = $sql->fetchAll();
            //foreach para contar os produtos de cada produto dentro do array e adicionar no valor_total
            foreach ($produtos as $produto) {
                $valor_total += intval($produto["valor"]) * intval($produto["quantidade"]);
            }
        }
        //retorna a soma no valor_total
        return $valor_total;
    }

}
