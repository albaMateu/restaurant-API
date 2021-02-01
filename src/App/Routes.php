<?php

use Slim\Routing\RouteCollectorProxy;

$app->group('/v1', function(RouteCollectorProxy $group){
    $group ->get('/sales','App\Controllers\SalesController:getAll');
});


/* $app->group('/v1'. function(RouteCollectorProxy $group){
    $group ->get('/sales','App\Controllers\SalesController:getAll');
}); */