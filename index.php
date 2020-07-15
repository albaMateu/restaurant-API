<?php
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;
	use Slim\Exception\NotFoundException;

	//CORS
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
	header("Access-Control-Allow-Headers: X-Requested-With");
	header('Content-Type: text/html; charset=utf-8');
	header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
	
	require __DIR__ . '/vendor/autoload.php';
	require_once "config/db.php";

	//funcions
	require "functions/sales.php";
	
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
	
	//routing
	$app->get("/sales", 'getSales');
	

	$app->run();

?>