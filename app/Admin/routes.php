<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/theatre',AdminTheatreController::class);
    $router->resource('/time',AdminTimeController::class);
    $router->resource('/seat',AdminSeatsController::class);
    $router->resource('/ticket',AdminTicketController::class);
    $router->resource('/user',AdminUserController::class);

});
