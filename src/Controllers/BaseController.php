<?php
namespace App\Controllers;

use Psr\Container\ContainerInterface;

class BaseController{

    protected $container;

    public function __construct(ContainerInterface $c){
        //per a que el contenedor estiga disponible en els controladors.
        $this->container= $c;
    }
}