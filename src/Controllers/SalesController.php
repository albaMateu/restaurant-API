<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SalesController{
    public function getAll($resquest, $response, $arg){
        $response->getBody()->write("Hello world!");
        return $response;
    }
}
