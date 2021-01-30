<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//require_once BASE_URL."/utilities.php";

//contar les taules

//inserta reserva
function insertReserva (Request $request, Response $response){

    
    //agarre datos del formulari
    //json= $app->request->post();

    //llig les dades del form
    //$js = file_get_contents('php://input');

    //decodifique json en array
    $json=$request->getBody();

    //$json=$request->withParsedBody($js);
    echo "objecte:";
    var_dump($json);

    $result = array(
        'status'=>'success',
        'code' => 200,
        'data' => $json
    );	

    $response->getBody()->write($result);
    $response->withHeader('Content-Type', 'application/json');
    return $response;
    

   /*  $db= getConnection();
    mysqli_query($db,"insert into articulos(descripcion,precio) values
                  ('$form->descripcion',$form->precio)");

    $sql= "SELECT * FROM sala ORDER BY id DESC;";
    
    $stmt= $db->prepare($sql);
    /* $stmt->bind_param(); 
    $stmt->execute(); 
    $query=$stmt->get_result();
    /*$query=$db->query($sql); */

    //var_dump($stmt->sqlstate);

   /* if (!$query) {
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

    //crear una array de objetos a partir del resultado de la query
    $sales= array();
    while ($sala =$query->fetch_assoc()) {
        $sales[]=$sala;
    }

    $result = array(
        'status'=>'success',
        'code' => 200,
        'data' => $sales
    );	

    $response->getBody()->write(json_encode($result));

    return $response; */
    
}

?>