<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$container = $app->getContainer();
$container['view'] = function(){
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

    $test = $request->getParsedBody(); //getAttributes
    echo json_encode($test);

//  $request->getParams();
//     echo json_encode(['data']);
});

$app->run();

