<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class SalesController extends BaseController
{
    public function getAll($resquest, $response, $arg)
    {
        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        $sql="SELECT * FROM sales;";
        $query=$pdo->query($sql);
        
        if ($query->rowCount() > 0) {
            $response->getBody()->write(json_encode($query->fetchAll()));
        } else {
            $response="No existeixen sales en la base de dades";
        }
        
        return $response
            ->withHeader('Conten-Type', 'application/json')
            ->withStatus(200);
        ;
    }
}
