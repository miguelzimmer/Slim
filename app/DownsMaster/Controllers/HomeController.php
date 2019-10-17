<?php

namespace DownsMaster\Controllers;

$container = $app->getContainer();
$container['view'] = function(){
    $view = new \Slim\Views\Twig('../app/public/views',[
        'cache'=> false
    ]);
    return $view;
};


