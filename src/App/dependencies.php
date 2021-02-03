<?php
use Psr\Container\ContainerInterface;

// ens porta el contenedor general per a fer la conexió a la base de dades
$container -> set('db', function(ContainerInterface $c){
   $config=$c->get('db_settings');

   $host=$config->DB_HOST;
   $pass=$config->DB_PASS;
   $name=$config->DB_NAME;
   $user=$config->DB_USER;
   $charset=$config->DB_CHARSET;

    $opt=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, //lanza las excepciones si hay errores
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ, //els resultados los manda como objetos
    ];

    $dsn ="mysql:host=".$host.";dbname=".$name.";charset=".$charset;
    return new PDO($dsn,$user, $pass,$opt); //conexio
    
});