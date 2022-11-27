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
        $hash = file_get_contents('php://input');

        $hash = base64_decode($hash);
        $user = explode(":", $hash);

        $email = $user[0];
        $pwd = $user[1];


        $code = UsersController::insertUser($email, $pwd);

        $result = array(
            "token" => $user[2],
            "code" => $code
        );


        $response->getBody()->write(json_encode($result));


        return $response;
    }



    //insertar client a la base de dades
    public function insertUser($email, $pwd)
    {
        $today = date('UTC+1');

        //porta les dades del contenedor que porta la connexió a BD
        $pdo = $this->container->get('db');
        $sql = "INSERT INTO usuaris (email, pwd, actiu, rol) 
        VALUES ( :email, :pwd, 1, 3);";


        try {
            $query = $pdo->prepare($sql);
            /*  $query->bindParam(':nom', 'alba');
            $query->bindParam(':cognoms', 'algo '); */
            $query->bindParam(':email', $email);
            $query->bindParam(':pwd', $pwd);
            /* $query->bindParam(':tel', '666666666'); */
            $result = $query->execute();
            /* $result = true; */

            if ($result) {
                $code = 200;
            }
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            $code = $err->getCode();
            //mete error en log.
            utilities::logError($code, "Falló la ejecución: (" . $err->getMessage() . ") " . $err->getCode());
        }

        return $code;
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

        //se usa eso en vez de $_POST porque los datos llegan en texto en body y no por un formulario
        $email = file_get_contents('php://input');

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

        //transforma array a json
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
