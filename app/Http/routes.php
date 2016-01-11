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
Route::get('/home', 'PagesController@home');
Route::get('/', 'CustomAuthController@index');

Route::get('escritorio', 'DefaultController@dashboard');
Route::get('api/warehousesList', 'jsonController@warehousesList');
Route::get('api/warehousesByType/{id}', 'jsonController@warehousesType');
Route::get('api/warehousesByActivity/{id}', 'jsonController@warehousesActivity');
Route::get('api/warehousesByActivity', 'jsonController@warehousesByActivity');  // este es el nuevo
Route::get('api/warehouseDetail/{id}', 'jsonController@warehouseDetail');

Route::get('api/inventory/{warehouse_id}', 'jsonController@articlesAvailable');
Route::get('api/articles/serial', 'jsonController@articlesSerial');
Route::get('search/autocomplete/{table}', 'SearchController@autocomplete');
Route::get('search/name2Id', 'SearchController@name2Id');
Route::get('articulos/import', 'ImportController@articles');
Route::post('articulos/import', 'ImportController@importArticles');
Route::get('movimientos/porAprobar', 'ApproveController@viewAll');
Route::post('movimientos/aprobar', 'ApproveController@approveMovement');
Route::post('movimientos/rechazar', 'ApproveController@rejectMovement');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::get('reportes/articulos/', 'ReportsController@articles');
Route::get('reportes/articulos/all', 'ReportsController@excelArticles');
Route::get('reportes/almacenes', 'ReportsController@inventory');
Route::get('reportes/movimientosPorAlmacen', 'ReportsController@showMovimientosPorAlmacen');
Route::post('reportes/movimientosPorAlmacen', 'ReportsController@movimientosPorAlmacen');
Route::get('reportes/listadoCumplimientoDeMaterial', 'ReportsController@showListadoCumplimientoDeMaterial');
Route::post('reportes/listadoCumplimientoDeMaterial', 'ReportsController@ListadoCumplimientoDeMaterial');

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


/*Route::get('/', function () {
    return 'Hello World';
});*/