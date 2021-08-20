<?php

use Core\Route\Router;
use App\Controllers\HomeController;
use App\Controllers\UploadFileController;

$router = new Router();

$router->get('/', HomeController::class);
$router->get('/upload', UploadFileController::class);

$router->addNotFoundHandler(function(){
    echo 'Not Found';
});

$router->dispatch();