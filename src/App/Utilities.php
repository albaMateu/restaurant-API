<?php

use Psr\Container\ContainerInterface;

class utilities
{
    public static function logError($errorCode, $errorMessage)
    {
        error_log(date("d-m-Y H:i:s - ") . $errorCode . ":" . $errorMessage . "\n", 3, "C:/xampp/htdocs/Restaurant-API/logs/errors.log");
    }

    public static function datosResult($code, $message)
    {
        if ($code == 200) {
            $status = "ENHORABONA!";
        } else {
            $status = "Oooh... ";
        }
        $result = array(
            "code" => $code,
            "message" => $message,
            "estat" => $status
        );
        return $result;
    }
}
