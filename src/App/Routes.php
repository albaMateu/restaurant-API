<?php

use Slim\Routing\RouteCollectorProxy;

$app->group('/v1', function (RouteCollectorProxy $group) {
    $group->get('/sales', 'App\Controllers\SalesController:getAll');
    $group->get('/reserves', 'App\Controllers\ReservesController:getAll');
    $group->get('/reserva/{id}', 'App\Controllers\ReservesController:getReserva');
    $group->post('/reserva/new', 'App\Controllers\ReservesController:insertReserva');
    $group->post('/ocupades', 'App\Controllers\ReservesController:taulesOcupades');
    $group->post('/reserva/mail', 'App\Controllers\ReservesController:confirmEmail');
    $group->post('/user/login', 'App\Controllers\UsersController:login');
    $group->post('/user/register', 'App\Controllers\UsersController:register');
    $group->get('/user/token', 'App\Controllers\UsersController:generateToken');
    $group->post('/user/token', 'App\Controllers\UsersController:getToken');
    $group->post('/user/email', 'App\Controllers\UsersController:getUserByEmail');

    /* estes encara no estan fetes */
    $group->get('/user/{id}', 'App\Controllers\UsersController:getUser');
    $group->post('/reserves/user/{id}', 'App\Controllers\ReservesController:confirmEmail');
});


/* $app->group('/v1'. function(RouteCollectorProxy $group){
    $group ->get('/sales','App\Controllers\SalesController:getAll');
}); */
