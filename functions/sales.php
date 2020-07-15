<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//require_once BASE_URL."/utilities.php";


function getSales (Request $request, Response $response){
    $sql= "SELECT * FROM sala ORDER BY id DESC;";
    $db= getConnection();
    $query= $db->query($sql);

    error_log(date("d-m-Y H:i:s"). $db->errno. ":".$db->error."\n", 3, "C:/xampp/htdocs/Restaurant-API/logs/errors.log");
    $db=null;

    //crear una array de obejtos a partir del resultado de la query
    $productos= array();
    while ($producto =$query->fetch_assoc()) {
        $productos[]=$producto;
    }

    $result = array(
        'status'=>'success',
        'code' => 200,
        'data' => $productos
    );	

    $response->getBody()->write(json_encode($result));
    return $response;
}

?>