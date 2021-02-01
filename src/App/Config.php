<?php

//el contenedor ens serveix per a poder passar dades a qualsevol lloc de l'app
$container->set('db_settings', function(){
    return (object)[
        "DB_NAME" =>"restaurant",
        "DB_PASS" =>"",
        "DB_HOST" =>"localhost",
        "DB_USER" =>"root",
        "DB_CHARSET" =>"utf8"
    ];
});