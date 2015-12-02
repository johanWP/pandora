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

Route::get('escritorio', 'DefaultController@dashboard');
Route::get('api/warehousesList', 'jsonController@warehousesList');
Route::get('api/inventory/{warehouse_id}', 'jsonController@articlesAvailable');
/*
Route::get('empresas', 'CompaniesController@index');
Route::get('empresas/create', 'CompaniesController@create');
Route::get('empresas/{id}', 'CompaniesController@show');
Route::post('empresas', 'CompaniesController@store');
*/
/*
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');



// Custom Authentication routes...
Route::get('auth/login2', 'Auth\AuthController@getLogin');
Route::post('auth/login2', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

*/

// Registration routes...
//Route::get('registro', 'CustomAuthController@create');
//Route::post('registro', 'CustomAuthController@postRegister');

Route::resource('login', 'CustomAuthController');
Route::get('logout', 'CustomAuthController@logout');
Route::resource('actividades', 'ActivitiesController');
Route::resource('articulos', 'ArticlesController');
Route::resource('empresas', 'CompaniesController');
Route::resource('tipos' , 'TypesController');
Route::resource('usuarios', 'UsersController');
Route::resource('almacenes', 'WarehousesController');
Route::resource('movimientos', 'MovementsController');