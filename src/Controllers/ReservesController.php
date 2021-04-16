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
    public function taulesOcupades($resquest, $response, array $arg)
    {
        //en $arg se li tenen que passar dia, sala i hora
        $arg=[
            "dia"=>'2020-10-10',
            "sala"=>1,
            "hora"=>'23:00:00',
        ];
        //porta les dades del contenedor que porta la connexió a BD
        $pdo=$this->container->get('db');
        //trau les reserves que estan ocupades(hora de acabar > hora de nova reserva)
        $sql="SELECT SUM(taules) as 'ocupades' FROM reserves WHERE dia = :dia AND 
        sala = :sala AND ADDTIME(hora,'01:45:00')> :hora;";
        $params=[
            ":dia"=>$arg['dia'],
            ":sala"=>$arg['sala'],
            ":hora"=>$arg['hora'],
        ];
        
        try {
            $query= $pdo->prepare($sql);
            $query->execute($params);
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }

        if ($query->rowCount() > 0) {
            $response->getBody()->write(json_encode($query->fetchAll()))->withStatus(200);
        } else {
            $response="No hi ha taules ocupades per al dia ". date("d/m/Y", $arg["dia"]).
            " a les ".date("H:i", $arg["hora"])." en la sala sol·licitada";
        }
        return $response
            ->withHeader('Conten-Type', 'application/json');
    }
    
    //insertar reserva a la base de dades
    public function insertReserva($resquest, $response, $arg)
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
       
        //devuelve el array encode con json
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
