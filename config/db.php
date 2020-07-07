<?php

    require_once "config.php";

    class DataBAse{
        public static $db;

        static function connect(){
            $con= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($con->connect_errno){
                echo "Error conexió";
            }else{
                echo "todo good";
            }
            
            return $con;
        }    
    }

    $db=DataBase::connect();
?>