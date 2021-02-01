<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/restaurant-api"); // IMPRESCINDIBLE el que volem que siga la URL base del projecte (en este cas hem omitit la carpeta public)

/* $app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
}); */

require __DIR__."/Routes.php";

$app->run();