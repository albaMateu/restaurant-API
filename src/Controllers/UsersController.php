<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;
use PDOException;
use utilities;

class UsersController extends BaseController
{
    public function generateToken($request, $response)
    {
        //token random de 32 caracters

        $token = bin2hex(random_bytes(16));

        $result = array(
            "token" => $token
        );

        $response->getBody()->write(json_encode($result));
        return $response;
    }


    public function getToken($request, $response)
    {

        $json = file_get_contents('php://input');

        $email = json_decode($json, true);


        $user = UsersController::getPwdUserByEmail($email['email']);

        if (is_null($user)) {

            $response = UsersController::generateToken($request, $response);
        } else {
            $user = $user[0];
            $token = explode(":", $user->pwd);
            $result = array(
                "token" => $token[1]
            );

            $response->getBody()->write(json_encode($result));
        }

        return $response;
    }




    public function login($request, $response)
    {
    }

    public function register($request, $response)
    {
        $json = file_get_contents('php://input');

        $hash = json_decode($json, true);
        /* $user = explode(":", $hash);

        $email= $user[0];
        $pwd= $user[1]; */

        $result = array(
            "token" => $hash
        );


        $response->getBody()->write(json_encode($result));


        return $response;
    }



    //insertar usuari a la base de dades
    public function insertUser($resquest, $response)
    {
        $json = file_get_contents('php://input');

        $post = json_decode($json, true);

        $pers = htmlspecialchars($post['pers']);
        $dia = $post['dia'];
        $hora = $post['hora'];
        $taules = $post['taules'];
        $sala = $post['sala'];
        $nom = htmlspecialchars($post['nom']);
        $tel = $post['tel'];
        $email = htmlspecialchars($post['email']);
        if (isset($post['coment'])) {
            $coment = htmlspecialchars($post['coment']);
        } else {
            $coment = "";
        }

        //porta les dades del contenedor que porta la connexió a BD
        $pdo = $this->container->get('db');
        $sql = "INSERT INTO reserves (pers, dia, hora, taules, sala, nom, tel, email, coment) 
        VALUES (:pers, :dia, :hora, :taules, :sala, :nom, :tel, :email, :coment);";


        try {
            $query = $pdo->prepare($sql);
            $query->bindParam(':pers', $pers);
            $query->bindParam(':dia', $dia);
            $query->bindParam(':hora', $hora);
            $query->bindParam(':taules', $taules);
            $query->bindParam(':sala', $sala);
            $query->bindParam(':nom', $nom);
            $query->bindParam(':tel', $tel);
            $query->bindParam(':email', $email);
            $query->bindParam(':coment', $coment);
            /* $result=$query->execute(); */
            $result = true;

            if ($result) {
                $code = 200;
            }
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            $code = $err->getCode();
            //mete error en log.
            utilities::logError($code, "Falló la ejecución: (" . $err->getMessage() . ") " . $err->getCode());
        }

        //devuelve el array

        $result = array(
            "code" => $code
        );

        //el encode es precis ahi, sino no va
        $response->getBody()->write(json_encode($result));
        return $response;
    }


    //torna un usuari per id - 
    public function getUser($resquest, $response, $arg)
    {
        $id = $resquest->getAttribute('id');
        //porta les dades del contenedor que porta la connexió a BD
        $pdo = $this->container->get('db');
        $sql = "SELECT * FROM usuaris WHERE id= :id;";

        $params = [":id" => $id];
        $query = $pdo->prepare($sql);

        try {
            $query->execute($params);
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }

        if ($query->rowCount() > 0) {
            $response->getBody()->write(json_encode($query->fetchAll()));
        } else {
            $response = "No existeixen reserves en la base de dades";
        }
        return $response;
    }

    //torna si existeix l'usuari o no. busca per email
    public function getUserByEmail($resquest, $response, $email)
    {
        $exist = false;
        $email = $resquest->getAttribute('email');
        //porta les dades del contenedor que porta la connexió a BD
        $pdo = $this->container->get('db');
        $sql = "SELECT * FROM usuaris WHERE email= :email;";

        $params = [":email" => $email];
        $query = $pdo->prepare($sql);

        try {
            $query->execute($params);
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }

        if ($query->rowCount() > 0) {
            /* $response->getBody()->write(json_encode($query->fetchAll())); */
            $exist = true;
        }


        $result = array(
            "exist" => $exist
        );

        //el encode es precis ahi, sino no va
        $response->getBody()->write(json_encode($result));
        return $response;
    }

    public function getPwdUserByEmail($email)
    {
        $pdo = $this->container->get('db');
        $sql = "SELECT pwd FROM usuaris WHERE email= :email AND actiu = 1;";

        $params = [":email" => $email];
        $query = $pdo->prepare($sql);

        try {
            $query->execute($params);
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }

        if ($query->rowCount() > 0) {
            $response = $query->fetchAll();
        } else {
            $response = null;
        }

        return $response;
    }
}
