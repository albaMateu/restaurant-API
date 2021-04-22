<?php

//el contenedor ens serveix per a poder passar dades a qualsevol lloc de l'app

//dades BD
$container->set('db_settings', function () {
    return (object)[
        "DB_NAME" =>"restaurant",
        "DB_PASS" =>"",
        "DB_HOST" =>"localhost",
        "DB_USER" =>"root",
        "DB_CHARSET" =>"utf8"
    ];
});

//info restaurant-horari PER ARA NO ES GASTA
$container->set('horari_rest', function () {
    return (object)[
        "inici_m" =>"12:30",
        "final_m" =>"16:30",
        "inici_v" =>"20:30",
        "final_v" =>"24:00",
        "intensiu" =>true
    ];
});

//dades per al SMTP
$container->set('dades_correu', function () {
    return (object)[
        "SMTP_mail" =>"info@vivacemusica.es",
        "SMTP_pwd" =>"VivaceMusica.2014",
        "SMTP_host" =>"smtp.ionos.es",
        "SMTP_from" =>"no-reply@restirestaurant.es",
        "SMTP_name" => "Resti Restaurant"
    ];
});
