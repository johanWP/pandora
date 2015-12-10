<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'PagesController@home');
Route::get('/inicio', 'PagesController@inicio');

Route::get('escritorio', 'DefaultController@dashboard');
Route::get('api/warehousesList', 'jsonController@warehousesList');
Route::get('api/inventory/{warehouse_id}', 'jsonController@articlesAvailable');
Route::get('api/warehousesType/{id}', 'jsonController@warehousesType');
Route::get('api/articles/serial', 'jsonController@articlesSerial');

/*Route::get('/', function () {
    return 'Hello World';
});*/
Route::get('reportes/articulos/', 'ReportsController@articles');
Route::get('reportes/articulos/all', 'ReportsController@excelArticles');
Route::get('reportes/almacenes', 'ReportsController@inventory');
Route::get('movimientos/alta', function () {
    $warehouseList = Array();
    return view('movements.alta', compact('warehouseList'));
});
Route::resource('login', 'CustomAuthController');
Route::get('logout', 'CustomAuthController@logout');
Route::resource('actividades', 'ActivitiesController');
Route::resource('articulos', 'ArticlesController');
Route::resource('empresas', 'CompaniesController');
Route::resource('tipos' , 'TypesController');
Route::resource('usuarios', 'UsersController');
Route::resource('almacenes', 'WarehousesController');
Route::resource('movimientos', 'MovementsController');
Route::resource('mail', 'MailController');