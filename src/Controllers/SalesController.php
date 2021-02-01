<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class SalesController extends BaseController{
    public function getAll($resquest, $response, $arg){
        //porta les dades del contenedor que posem
        $config=$this->container->get('db_settings');

        echo "<pre>";
        var_dump($config);
        echo "</pre>";

        $response->getBody()->write("Hello world!");
        return $response;
    }
}
