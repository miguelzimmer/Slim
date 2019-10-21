<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
//chamando o arquivo autoload.php para utilizar as funçoes do Slim
require_once 'vendor/autoload.php';
//habilitando os erros detalhados para melhor visualizaçao
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

/**instanciando a funçao do view para rendenrizar as telas
 * cache false para nao salvar o cache da pagina
 */
$container = $app->getContainer();
$container['view'] = function() {
    $view = new \Slim\Views\Twig('./app/public/views',[
        'cache'=> false
    ]);
    return $view;
};
//rota raiz da aplicaçao retornando a tela login
$app->get('/', function(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'login.html');
});
//rota cadastrar retornando a tela cadastrar
$app->get('/cadastrar', function(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'cadastrar.html');
});
//rota cadastrarUsuario com metodo post
$app->post('/cadastrarUsuario', function(Request $request, Response $response, array $args) use ($app) {
    //pegando os parametros da variavel Dados
    $dados = $request->getParams();
    //chamando a classe usuarios para essa pagina
    require 'app/classes/Usuario.php';
    //instanciando um novo usuario e chamando a funçao cadastrar
    $u = new Usuario();
    $msg = $u->cadastrar($dados);
    echo json_encode(["msg" => $msg]);
});
//rota atualizarUsuario com metodo post
$app->post('/atualizarUsuario', function(Request $request, Response $response, array $args) use ($app) {
    //pegando os parametros da variavel Dados
    $dados = $request->getParams();
    //chamando a classe Usuario e instanciando ela
    require 'app/classes/Usuario.php';
    $u = new Usuario();
    //usando a funçao atualizar dados
    $msg = $u->atualizar($dados);
    echo json_encode(["msg" => $msg]);
});

//rota por meio post para logar o usuario
$app->post('/logarUsuario', function(Request $request, Response $response, array $args) use ($app) {
    $dados = $request->getParams();
    //chamando a classe Usuario e instanciando ela
    require "app/classes/Usuario.php";
    $u = new Usuario();
    //tipo recebe a funcao logar passando os dados como paremetro
    $tipo = $u->logar($dados);
    //se tipo for verdadeiro, tipo(srting) recebe tipo se for falso retorna menssagem
    if ($tipo) {
        echo json_encode(["tipo" => $tipo]);
    }else{
        echo json_encode(["msg" => "E-mail /ou senha incorretos!"]);
    }
});
//rota para diretor retornando tela diretor
$app->get('/diretor', function(Request $request, Response $response, array $args) {

    // if (isset($_SESSION) && $_SESSION['tipo'] == 'D') {
    return $this->view->render($response, 'diretor.html');
    // } else {
    //     return $this->view->render($response, 'permissao.html');
    // }
});
//rota para gerente retornando tela gerente
$app->get('/gerente', function(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'gerente.html');
});
//rota para colaborador retornando tela gerente
$app->get('/colaborador', function(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'colaborador.html');
});
//rota para listar usuario
$app->get('/listaUsuario', function(Request $request, Response $response, array $args) use ($app) {
    //chamando a classe Usuario e instanciando ela
    require "app/classes/Usuario.php";
    $u = new Usuario();
    echo json_encode(["data" => $u->listar()]);
});
//rota para listar produtos com metodo get
 $app->get('/listaProdutos', function(Request $request, Response $response, array $args) use ($app) {
    //chamando a classe Produto e instanciando ela
    require "app/classes/Produto.php";
    $p = new Produto();
    //echo com json_encode para mandar em forma JSON
    echo json_encode(["data" => $p->listar()]);
    });
//rota para cadastrar produtos com metodo post
$app->post('/cadastrarProduto', function(Request $request, Response $response, array $args) use ($app) {
    // pegando dados como parametro
    $dados = $request->getParams();
    //chamando a classe Produto e instanciando ela
    require 'app/classes/Produto.php';
    $p = new Produto();
    $msg = $p->cadastrar($dados);
    echo json_encode(["msg" => $msg]);
});
//rota para somar os  produtos com metodo get
$app->get('/produtoTotal', function(Request $request, Response $response, array $args) use ($app) {
    //chamando a classe Produto e instanciando ela
    require "app/classes/Produto.php";
    $p = new Produto();
    echo json_encode(["total" => $p->getValorTotal()]);
});
// rota para deslogar do tipo do usuario
$app->post('/logout',function(Request $request, Response $response, array $args){
    unset($_SESSION['tipo']);
    session_destroy();
});
$app->run();
