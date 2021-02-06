<?php

use Slim\Routing\RouteCollectorProxy;

$app->group('/v1', function(RouteCollectorProxy $group){
    $group ->get('/sales','App\Controllers\SalesController:getAll');
    $group ->get('/reserves','App\Controllers\ReservesController:getAll');
    $group ->get('/reserva/{id}','App\Controllers\ReservesController:getReserva');
});


/* $app->group('/v1'. function(RouteCollectorProxy $group){
    $group ->get('/sales','App\Controllers\SalesController:getAll');
}); */