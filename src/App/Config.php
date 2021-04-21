<?php

//el contenedor ens serveix per a poder passar dades a qualsevol lloc de l'app
$container->set('db_settings', function () {
    return (object)[
        "DB_NAME" =>"restaurant",
        "DB_PASS" =>"",
        "DB_HOST" =>"localhost",
        "DB_USER" =>"root",
        "DB_CHARSET" =>"utf8"
    ];
});

$container->set('horari_rest', function () {
    return (object)[
        "inici_m" =>"12:30",
        "final_m" =>"16:30",
        "inici_v" =>"20:30",
        "final_v" =>"24:00",
        "intensiu" =>true
    ];
});
