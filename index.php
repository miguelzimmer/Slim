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


$container = $app->getContainer();
$container['view'] = function() {
    $view = new \Slim\Views\Twig('./app/public/views',[
        'cache'=> false
    ]);
    return $view;
};

$app->get('/', function(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'login.html');
});

$app->get('/cadastrar', function(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'cadastrar.html');
});

$app->post('/cadastrarUsuario', function(Request $request, Response $response, array $args) use ($app) {
    $dados = $request->getParams();

    require 'app/classes/Usuario.php';

    $u = new Usuario();
    $msg = $u->cadastrar($dados);
    echo json_encode(["msg" => $msg]);
});

$app->post('/atualizarUsuario', function(Request $request, Response $response, array $args) use ($app) {
    $dados = $request->getParams();
    require 'app/classes/Usuario.php';
    $u = new Usuario();
    $msg = $u->atualizar($dados);
    echo json_encode(["msg" => $msg]);
});

//rota por meio post para logar o usuario
$app->post('/logarUsuario', function(Request $request, Response $response, array $args) use ($app) {
    $dados = $request->getParams();

    require "app/classes/Usuario.php";

    $u = new Usuario();
    $tipo = $u->logar($dados);

    if ($tipo) {
        echo json_encode(["tipo" => $tipo]);
    }else{
        echo json_encode(["msg" => "E-mail /ou senha incorretos!"]);
    }
});

//rota para diretor
$app->get('/diretor', function(Request $request, Response $response, array $args) {

    // if (isset($_SESSION) && $_SESSION['tipo'] == 'D') {
        return $this->view->render($response, 'diretor.html');
    // } else {
    //     return $this->view->render($response, 'permissao.html');
    // }
});

$app->get('/gerente', function(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'gerente.html');
});

$app->get('/colaborador', function(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'colaborador.html');
});

$app->get('/listaUsuario', function(Request $request, Response $response, array $args) use ($app) {
    require "app/classes/Usuario.php";
    $u = new Usuario();
    echo json_encode(["data" => $u->listar()]);
});

 $app->get('/listaProdutos', function(Request $request, Response $response, array $args) use ($app) {
     require "app/classes/Produto.php";
    $p = new Produto();
     echo json_encode(["data" => $p->listar()]);
    });

$app->post('/cadastrarProduto', function(Request $request, Response $response, array $args) use ($app) {
    $dados = $request->getParams();
    require 'app/classes/Produto.php';
    $p = new Produto();
    $msg = $p->cadastrar($dados);
    echo json_encode(["msg" => $msg]);
});

$app->get('/produtoTotal', function(Request $request, Response $response, array $args) use ($app) {
    require "app/classes/Produto.php";
    $p = new Produto();
    echo json_encode(["total" => $p->getValorTotal()]);
});

$app->post('/logout',function(Request $request, Response $response, array $args){
    unset($_SESSION['tipo']);
    session_destroy();
});

$app->run();


// nome, valor_unitario, quantidade
