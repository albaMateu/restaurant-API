<?php 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class salesController{

    function getSales (Request $request, Response $response){
        $sql= "SELECT * FROM sala ORDER BY id DESC;";
        $db= getConnection();
        $stmt= $db->prepare($sql);
        /* $stmt->bind_param(); */
        $stmt->execute(); 
        $query=$stmt->get_result();
        /*$query=$db->query($sql); */
    
        //var_dump($stmt->sqlstate);
    
        if (!$query) {
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
    
        //crear una array de obejtos a partir del resultado de la query
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
    
        return $response;
        
    }
}