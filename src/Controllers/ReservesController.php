<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;
use PDOException;

class ReservesController extends BaseController{


    public function insertReserva($resquest, $response, $arg){
        $json= file_get_contents('php://input');
        $post= json_decode($json, true);
        
        $pers= $post['pers'];
        $sala=$post['sala'];
        $dia=$post['dia'];
        $hora=$post['hora'];
        $coment="insertat des de la web";

        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        $sql="INSERT INTO reserves (pers, dia, hora, sala, coment) 
        VALUES (:pers, :dia, :hora, :sala, :coment);";

                       
        try{
          $query= $pdo->prepare($sql);
          $query->bindParam(':pers', $pers);
          $query->bindParam(':dia', $dia);
          $query->bindParam(':hora', $hora);
          $query->bindParam(':sala', $sala);
          $query->bindParam(':coment', $coment);
          $query->execute(); 

          $message= "Reserva realitzada amb èxit.";
        }
        catch(PDOException $err)
        {
          // Mostramos un mensaje genérico de error.          
         $message= "Falló la ejecución: (" . $err->getMessage() . ") " . $err->getCode();
        }

        $response->getBody()->write(json_encode($message));
        return $response;
        
    }


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