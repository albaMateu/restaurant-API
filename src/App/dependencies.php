<?php
use Psr\Container\ContainerInterface;

// ens porta el contenedor general per a fer la conexió a la base de dades
$container -> set('db', function (ContainerInterface $c) {
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
    return new PDO($dsn, $user, $pass, $opt); //conexio
});

// ens porta el contenedor general les dades de l'horari
$container -> set('horari', function (ContainerInterface $c) {
    $horari=$c->get('horari_rest');

    $hores= array(
        'inici_m'=> $horari->inici_m,
        'final_m'=> $horari->final_m,
        'inici_v' => $horari->inici_v,
        'final_v' => $horari->final_v,
        'intensiu'=> $horari->intensiu
    );
    return $hores;
});
