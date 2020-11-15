<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

// GET totes les reserves

$app-> get ('/reserves', function(Request $request, Response $response){
    $sql= "SELECT * FROM reserves";
    try{
        $db= new db();
        $db= $db->getConnection();
        $stmt= $db->prepare($sql);
        /* $stmt->bind_param(); */
        $stmt->execute(); 
        $query=$stmt->get_result();

        if($query->num_rows > 0){
            //crear una array de objetos a partir del resultado de la query
            $reserves= array();
            while ($reserva =$query->fetch_assoc()) {
                $reserves[]=$reserva;
            }        
           
        }else{
            $reserves= json_encode("No existeixen reserves en la base de dades.");
        }

    }catch (Exception $e){
        echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;        
        error_log(date("d-m-Y H:i:s"). $stmt->errno. ":".$stmt->error."\n", 3, "C:/xampp/htdocs/Restaurant-API/logs/errors.log");
        
        $result = array(
            'status'=>'error',
            'code' => $stmt->errno,
            'message' => $stmt->error
        );
        $db= null;
        return $result;
    }
    $db=null;
    $result = array(
        'status'=>'success',
        'code' => 200,
        'data' => $reserves
    );	

    $response = json_encode($result);

    return $response;

});

// GET recuperar reserva per id

$app-> get ('/reserva/{id}', function(Request $request, Response $response){
    $id_reserva= $request->getAttribute('id');
    $sql= "SELECT * FROM reserves WHERE id= ?";
    try{
        $db= new db();
        $db= $db->getConnection();
        $stmt= $db->prepare($sql);
        // primer un string en el tipo de dades de totes les variables, després les variables a insertar al sql
        $stmt->bind_param(
           "i",$id_reserva
        );
        $stmt->execute(); 
        $query=$stmt->get_result();

        if($query->num_rows > 0){
            //crear una array de objetos a partir del resultado de la query
            $reserves= array();
            while ($reserva =$query->fetch_assoc()) {
                $reserves[]=$reserva;
            }        
           
        }else{
            $reserves= json_encode("No existeixen reserves en la base de dades.");
        }

    }catch (Exception $e){
        echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;        
        error_log(date("d-m-Y H:i:s"). $stmt->errno. ":".$stmt->error."\n", 3, "C:/xampp/htdocs/Restaurant-API/logs/errors.log");
        
        $result = array(
            'status'=>'error',
            'code' => $stmt->errno,
            'message' => $stmt->error
        );
        $db= null;
        return $result;
    }
    $db=null;
    $result = array(
        'status'=>'success',
        'code' => 200,
        'data' => $reserves
    );	

    $response = json_encode($result);

    return $response;

});

// POST crear reserva

$app-> post ('/reserva/nova', function(Request $request, Response $response) use ($app){
     /* $post= file_get_contents('php://input');
     print_r($post); */
 
    /*   $pers = $request->getParam('pers');
    $nom = $request->getParam('nom');
    $tel = $request->getParam('tel');
    $dia = null;
    $hora = null;
    $taules = $request->getParam('taules');
    $sala = $request->getParam('sala');
    $email = $request->getParam('email');
    $coment = $request->getParam('coment');  */

    //$post=$request->getBody();
    $json = $request->getBody();
    
    $pers = (string)$json->pers;
    echo $pers;

  /*   $nom = $parseBody['nom'];
    $tel = $parseBody['tel'];
    $dia = $parseBody['dia'];
    $hora = $parseBody['hora'];
    $taules = $parseBody['taules'];
    $sala = $parseBody['sala'];
    $email = $parseBody['email'];
    $coment = $parseBody['coment'];  */
    
 
    /* $sql= "INSERT INTO reserves (pers, nom, tel, dia, hora, taules, sala, email, coment) VALUES 
            (?, ?, ?,? ,? , ?, ?, ?, ?)";
    try{
        $db= new db();
        $db= $db->getConnection();
        $stmt= $db->prepare($sql);
        $stmt->bind_param(
            "issssiiss",
            $pers, $nom, $tel, $dia, $hora, $taules, $sala, $email, $coment
        );
        $stmt->execute(); 
        $reserves= json_encode("Reserva guardada");
        
    }catch (Exception $e){
        echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;        
        error_log(date("d-m-Y H:i:s"). $stmt->errno. ":".$stmt->error."\n", 3, "C:/xampp/htdocs/Restaurant-API/logs/errors.log");
        
        $result = array(
            'status'=>'error',
            'code' => $stmt->errno,
            'message' => $stmt->error
        );
        $db= null;
        return $result;
    }
    $db=null;
    $result = array(
        'status'=>'success',
        'code' => 200,
        'data' => $reserves
    );	
    
    $response = json_encode($result); 
   
    return $response;*/

});