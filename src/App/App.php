<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

$container_aux= new \DI\Container();
AppFactory::setContainer($container_aux);

$app = AppFactory::create();
$app->setBasePath("/restaurant-api"); // IMPRESCINDIBLE el que volem que siga la URL base del projecte (en este cas hem omitit la carpeta public)

/* $app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
}); */

$container=$app->getContainer();
require __DIR__."/Routes.php";
require __DIR__."/Config.php";

$app->run();