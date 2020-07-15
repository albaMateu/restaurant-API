<?php

    require_once "config.php";

    class DataBase{
        public static $db;

        static function connect(){
            $con= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($con->connect_errno){
                echo "Error connexió";
            }
            
            return $con;
        }    
    }

    
?>