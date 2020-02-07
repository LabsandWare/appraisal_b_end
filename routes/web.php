<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api/'], function () use ($router) {

    $router->get('login/','UsersCtrl@authenticate');
    $router->get('signup/','UsersCtrl@create');
    $router->get()->app->version();
    
});

$router->group(['prefix' => 'api/', 'middleware' => 'auth'], function () use ($router) {

    $router->post('supervisor/','SupervisorCtrl@store');
    $router->get('supervisor/', 'SupervisorCtrl@index');
    $router->get('supervisor/{id}/', 'SupervisorCtrl@show');
    $router->put('supervisor/{id}/', 'SupervisorCtrl@update');
    $router->delete('supervisor/{id}/', 'SupervisorCtrl@destroy');

    $router->post('emplpoyee/','EmployeeCtrl@store');
    $router->get('emplpoyee/', 'EmployeeCtrl@index');
    $router->get('emplpoyee/{id}/', 'EmployeeCtrl@show');
    $router->put('emplpoyee/{id}/', 'EmployeeCtrl@update');

    $router->post('appraisal/','AppraisalCtrl@store');
    $router->get('appraisal/', 'AppraisalCtrl@index');
    $router->get('appraisal/{id}/', 'AppraisalCtrl@show');
    $router->put('appraisal/{id}/', 'AppraisalCtrl@update');    
});