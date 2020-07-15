<?php
abstract class Model {
    public static $db;
    
}


//conexio que passara a tots els models fills perque esta es la classe pare
Model::$db = DataBase::connect();

?>