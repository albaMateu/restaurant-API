<?php


require_once "vendor/autoload.php";
require_once "funcions.php";
require_once "config/db.php";


$app= new \SlimªSlim();

$app->get("/sales", function() use ($db, $app){
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
	echo json_encode($result);
});

$app->run();
?>