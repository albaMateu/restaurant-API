<?php

    require_once "config.php";

    function getConnection(){
        $db=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($db->connect_error) {
            error_log(date("d-m-Y H:i:s"). $db->connect_errno. ":".$db->connect_error."\n", 3, "C:/xampp/htdocs/Restaurant-API/logs/errors.log");
            die('Error de conexión: ' . $db->connect_error);
        }

        return $db;
    }

    
?>