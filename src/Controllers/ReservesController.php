<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;
use PDOException;
use utilities;

class ReservesController extends BaseController
{


    //buscar per hora, data i sala les reserves que hi ha
    public function taulesOcupades($request, $response, $args)
    {
        $json= file_get_contents('php://input');
                   
        $args= json_decode($json, true);

        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');

        //porta les dades de l'horari que estan al contenedor
        $horari=$this->container->get('horari');

        //trau les reserves que estan ocupades(>= perque volem saber quantes hi han ocupades a l'hora de la reserva)
        $sql="SELECT SUM(taules) as 'ocupades' FROM reserves WHERE dia = :dia AND sala = :sala AND ADDTIME(hora, '01:45') > :hora ";
             
        try {
            $query= $pdo->prepare($sql);
            $query->bindParam(':dia', $args['dia']);
            $query->bindParam(':sala', $args['sala']);
            $query->bindParam(':hora', $args['hora']);
            $query->execute();
        } catch (PDOException $err) {
            //mete error en log.
            utilities::logError($err->getCode(), "Falló la ejecución: (" . $err->getMessage() . ") " . $err->getCode());
        }

        $ocupades= (int)$query->fetchColumn();

        if (is_null($ocupades)) {
            $ocupades = (int) 0;
        }

        /* echo "server". $horari['final_v']; */

        $devuelve= array(
            "ocup"=> $ocupades
        );

        $response->getBody()->write(json_encode($devuelve));
        return $response;
    }
    
    //insertar reserva a la base de dades
    public function insertReserva($resquest, $response)
    {
        $json= file_get_contents('php://input');
           
         
        $post= json_decode($json, true);
        
        $pers= htmlspecialchars($post['pers']);
        $dia=$post['dia'];
        $hora=$post['hora'];
        $taules=$post['taules'];
        $sala=$post['sala'];
        $nom= htmlspecialchars($post['nom']);
        $tel=$post['tel'];
        $email=htmlspecialchars($post['email']);
        $coment=htmlspecialchars($post['coment']);

        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        $sql="INSERT INTO reserves (pers, dia, hora, taules, sala, nom, tel, email, coment) 
        VALUES (:pers, :dia, :hora, :taules, :sala, :nom, :tel, :email, :coment);";

                       
        try {
            $query= $pdo->prepare($sql);
            $query->bindParam(':pers', $pers);
            $query->bindParam(':dia', $dia);
            $query->bindParam(':hora', $hora);
            $query->bindParam(':taules', $taules);
            $query->bindParam(':sala', $sala);
            $query->bindParam(':nom', $nom);
            $query->bindParam(':tel', $tel);
            $query->bindParam(':email', $email);
            $query->bindParam(':coment', $coment);
            $query->execute();

            $message= "Reserva realitzada amb èxit";
            $code = 200;
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            $code= $err->getCode();
            $message= "No s'ha pogut insertar la reserva.";
            //mete error en log.
            utilities::logError($code, "Falló la ejecución: (" . $err->getMessage() . ") " . $err->getCode());
        }
       
        //devuelve el array
        $result=utilities::datosResult($code, $message);
        //el encode es precis ahi, sino nova
        $response->getBody()->write(json_encode($result));
        return $response;
    }


    public function getAll($resquest, $response, $arg)
    {
        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        $sql="SELECT * FROM reserves;";
        $query=$pdo->query($sql);
        if ($query->rowCount() > 0) {
            $response->getBody()->write(json_encode($query->fetchAll()));
        } else {
            $response="No existeixen reserves en la base de dades";
        }
        return $response->withHeader('Conten-Type', 'application/json');
        ;
    }

    public function getReserva($resquest, $response, $arg)
    {
        $id= $resquest->getAttribute('id');
        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        $sql="SELECT * FROM reserves WHERE id= :id;";
    
        $params=[":id"=>$id];
        $query= $pdo->prepare($sql);
        
        try {
            $query->execute($params);
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }

        if ($query->rowCount() > 0) {
            $response->getBody()->write(json_encode($query->fetchAll()));
        } else {
            $response="No existeixen reserves en la base de dades";
        }
        return $response
            ->withHeader('Conten-Type', 'application/json')
            ->withStatus(200);
        ;
    }
}
