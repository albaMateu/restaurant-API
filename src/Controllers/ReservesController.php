<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;

class ReservesController extends BaseController{

    public function getAll($resquest, $response, $arg){
        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        $sql="SELECT * FROM reserves;";
        $query=$pdo->query($sql);
        if($query->rowCount() > 0){
            $response->getBody()->write(json_encode($query->fetchAll()));
        }else{
            $response="No existeixen reserves en la base de dades";
        }
        return $response
            ->withHeader('Conten-Type','application/json')
            ->withStatus(200);
        ;
    }

    public function getReserva($resquest, $response, $arg){
        $id= $resquest->getAttribute('id');
        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        $sql="SELECT * FROM reserves WHERE id= :id;";
    
        $params=[":id"=>$id];
        $query= $pdo->prepare($sql);
        
        try{
            $query->execute($params); 
        }
        catch(PDOException $err)
        {
           // Mostramos un mensaje genérico de error.
           echo "Error: ejecutando consulta SQL.";
        }

        if($query->rowCount() > 0){
            $response->getBody()->write(json_encode($query->fetchAll()));
        }else{
            $response="No existeixen reserves en la base de dades";
        }
        return $response
            ->withHeader('Conten-Type','application/json')
            ->withStatus(200);
        ;
    }



}