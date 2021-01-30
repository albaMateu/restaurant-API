<?php
	
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
	require __DIR__. '/src/config/db.php';

	//funcions
	/* require "functions/sales.php";
	require "functions/reserva.php"; */
	
	// Instantiate App
	$app = AppFactory::create();
	$app->setBasePath("/Restaurant-API/index.php"); //SUPER IMPORTANT O NO ANIRA

	// Parse json, form data and xml
	//$app->addBodyParsingMiddleware();

	$app ->addRoutingMiddleware();
	
	// Add error middleware
	$app->addErrorMiddleware(true, true, true);

	require __DIR__."/src/config/routes.php";
	
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

	/*$app->get("/pruebas", function(Request $request, Response $response){
		$response->getBody()->write("Slim funciona");
		return $response;		
	});*/
	
	//routing bo
	/* $app->get("/sales", 'getSales');
	$app->post("/reserva", function (Request $request, Response $response) use ($app) {
		$json= $app->request->post('json');
		$form = json_decode($json);

		$result = array(
			'status'=>'success',
			'code' => 200,
			'data' => $form
		);	
	
		$response=json_encode($result);
		return $response;
	}); */

	$app->run();

?>