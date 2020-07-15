<?php
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;
	use Slim\Exception\NotFoundException;
	
	require __DIR__ . '/vendor/autoload.php';
	require_once "config/db.php";

	$db= DataBase::connect();
	
	// Instantiate App
	$app = AppFactory::create();
	$app->setBasePath("/Restaurant-API/index.php"); //SUPER IMPORTANT O NO ANIRA
	
	// Add error middleware
	$app->addErrorMiddleware(true, true, true);
	
	// Add routes
	/* $app->get('/NO', function (Request $request, Response $response) {
		$response->getBody()->write('<a href="/hello/world">Try /hello/world</a>');
		return $response;
	});*/
	
	/* $app->get('/', function (Request $request, Response $response, $args) {
		$name = $args['name'];
		$response->getBody()->write("Hello, aLBA");
		return $response;
	});  */

	$app->get("/pruebas", function(Request $request, Response $response){
		$response->getBody()->write("Slim funciona");
		return $response;		
	});
	
	$app->get("/salas", function(Request $request, Response $response) use ($db, $app){
		$sql= "SELECT * FROM sala ORDER BY id DESC;";
		$query= $db->query($sql);
	
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
	});
	

	$app->run();

?>