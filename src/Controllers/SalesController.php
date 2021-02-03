<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class SalesController extends BaseController{
    public function getAll($resquest, $response, $arg){
        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        $query=$pdo->query("SELECT* FROM sales;");
        $response->getBody()->write(json_encode($query->fetchAll()));
        return $response
            ->withHeader('Conten-Type','application/json')
            ->withStatus(200);
        ;
    }
}
