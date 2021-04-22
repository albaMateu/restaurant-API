<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;
use DateTime;
use PDOException;
use utilities;

class ReservesController extends BaseController
{

    //enviar email-reb params per post (email,nom)
    public function confirmEmail($request, $response)
    {
        $json= file_get_contents('php://input');
                   
        $post= json_decode($json, true);
        
        $date= new DateTime($post['dia']);
        $dia= $date->format('d-m-Y');

        $assumpte= "La teua reserva en Resti Restaurant està confirmada";
        $missatge='
        <html>
         <head>
           <title>Resti Restaurant</title>
         </head>
         <body>
           <p>Hola '.$post['nom'].',</p>
           <p>Gràcies per elegir Resti Restaurant. Tenim moltes ganes de rebre-vos.</p>
           <p> Ací estan els detalls de la teua reserva:</p>
           <p>Reserva  el dia '.$dia.' a les '.$post['hora'].' per a '.$post['pers'].' en el/la '.$post['sala'].'.</p>
           <p>Si necessites fer canvis crida al telèfon o al mail que trobaràs a la nostra web.</p>
           <br>
           <p>Tenim moltes ganes de rebre-vos prompte!</p>
           <p>Resti Restaurant</p>
         </body>
         </html>
         ';

        $exit= utilities::sendEmail($missatge, $assumpte, $post['email'], $post['nom'], $this->container);

        $result= array(
            "envio" => $exit
        );
        //el encode es precis ahi, sino nova
        $response->getBody()->write(json_encode($result));
        return $response;
    }

    //buscar per hora, data i sala les reserves que hi ha
    public function taulesOcupades($request, $response, $args)
    {
        $json= file_get_contents('php://input');
                   
        $args= json_decode($json, true);

        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');

        //trau les taules que estan ocupades a l'hora de la reserva
        $sql="SELECT SUM(taules) as 'ocupades' FROM reserves WHERE dia = :dia AND sala = :sala AND :hora BETWEEN hora AND ADDTIME(hora, '01:45') ";
             
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
        if (isset($post['coment'])) {
            $coment=htmlspecialchars($post['coment']);
        } else {
            $coment= "";
        }

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


    //torna totes les reserves - SENSE US
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

    //torna una reserva per id - SENSE US
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
