<?php

namespace DownsMaster\Controllers;

$container = $app->getContainer();
$container['view'] = function(){
    $view = new \Slim\Views\Twig('../app/public/views',[
        'cache'=> false
    ]);
    return $view;
};

class HomeController{
    public function index($resquest, $response, $args){
      
        return $this->view->render($response, 'index.php');

    }
};
