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
Route::get('/',         ['middleware'=>'soloInvitados','uses'=>'CustomAuthController@index']);
Route::get('/login',    ['middleware'=>'soloInvitados','uses'=>'CustomAuthController@index']);
Route::get('escritorio',            ['middleware' => 'soloUsuarios','uses'=>'DefaultController@dashboard']);
Route::get('api/warehousesList',    ['middleware' => 'soloUsuarios','uses'=>'jsonController@warehousesList']);
Route::get('api/warehousesByType',  ['middleware' => 'soloUsuarios','uses'=>'jsonController@warehousesByType']);
//Route::get('api/warehousesByActivity/{id}', ['middleware' => 'soloUsuarios','uses'=>'jsonController@warehousesActivity']);
Route::get('api/warehousesByActivity',      ['middleware' => 'soloUsuarios','uses'=>'jsonController@warehousesByActivity']);  // este es el nuevo
Route::get('api/warehouseDetail/{id}',      ['middleware' => 'soloUsuarios','uses'=>'jsonController@warehouseDetail']);
Route::get('api/inventory/{warehouse_id}',  ['middleware' => 'soloUsuarios','uses'=>'jsonController@articlesAvailable']);
Route::get('api/inventorybasic/{warehouse_id}',  ['middleware' => 'soloUsuarios','uses'=>'jsonController@articlesAvailableBasic']);
Route::get('api/articles/serial',           ['middleware' => 'soloUsuarios','uses'=>'jsonController@articlesSerial']);
Route::get('search/autocomplete/{table}',   ['middleware' => 'soloUsuarios','uses'=>'SearchController@autocomplete']);
Route::get('search/autocompleteBuscarEquipo',['middleware' => 'soloUsuarios','uses'=>'SearchController@autocompleteBuscarEquipo']);
Route::get('search/name2Id',                ['middleware' => 'soloUsuarios','uses'=>'SearchController@name2Id']);

Route::get('/ajustes', ['middleware' => 'soloUsuarios','uses'=>'SettingsController@showSettings']);
Route::post('/ajustes/cambiarEmpresa', ['middleware' => 'soloUsuarios','uses'=>'SettingsController@cambiarEmpresa']);
Route::get('/ajustes/actualizarArticulosActivos', ['middleware' => 'soloGerente','uses'=>'SettingsController@showFindInactiveArticles']);
Route::post('/ajustes/actualizarArticulosActivos', ['middleware' => 'soloGerente','uses'=>'SettingsController@findInactiveArticles']);

Route::get('articulos/import', ['middleware' => 'soloDirector','uses'=>'ImportController@articles']);
Route::post('articulos/import', ['middleware' => 'soloDirector','uses'=>'ImportController@importArticles']);
Route::get('vttickets/import', ['middleware' => 'soloSupervisor','uses'=>'ImportController@vttickets']);
Route::post('vttickets/import', ['middleware' => 'soloSupervisor','uses'=>'ImportController@importvttickets']);
Route::get('vttickets/agenda', ['middleware' => 'soloUsuarios','uses'=>'VtticketsController@agenda']);

Route::get('movimientos/porAprobar', ['middleware' => 'soloSupervisor','uses'=>'ApproveController@viewAll']);
Route::post('movimientos/aprobar', ['middleware' => 'soloSupervisor','uses'=>'ApproveController@approveMovement']);
Route::post('movimientos/rechazar', ['middleware' => 'soloSupervisor','uses'=>'ApproveController@rejectMovement']);
Route::get('movimientos/alta', ['middleware' => 'soloUsuarios','uses'=>'MovementsController@showAlta']);
Route::post('movimientos/alta', ['middleware' => 'soloUsuarios','uses'=>'MovementsController@alta']);

Route::get('movimientos/createbasic', ['middleware' => 'soloUsuarios','uses'=>'MovementsController@createbasic']);
Route::post('movimientos/storebasic', ['middleware' => 'soloUsuarios','uses'=>'MovementsController@storebasic']);

Route::get('movimientos/createserial', ['middleware' => 'soloUsuarios','uses'=>'MovementsController@createserial']);
Route::post('movimientos/storeserial', ['middleware' => 'soloUsuarios','uses'=>'MovementsController@storeserial']);

Route::post('movimientos/porseriales', ['middleware' => 'soloUsuarios','uses'=>'MovementsController@porseriales']);

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::get('reportes/articulos/',           ['middleware'=>'soloJefe','uses'=>'ReportsController@articles']);
Route::get('reportes/articulos/all',        ['middleware'=>'soloJefe','uses'=>'ReportsController@excelArticles']);
Route::get('reportes/articulosPorAlmacen',  ['middleware'=>'soloUsuarios','uses'=>'ReportsController@showArticulosPorAlmacen']);
Route::post('reportes/articulosPorAlmacen', ['middleware'=>'soloJefe','uses'=>'ReportsController@articulosPorAlmacen']);
Route::get('reportes/excelArticulosPorAlmacen/{id}', ['middleware'=>'soloJefe','uses'=>'ReportsController@excelArticulosPorAlmacen']);

/* prueba optimizacion existencia stock */
Route::get('reportes/articulosPorAlmacenAlt',  ['middleware'=>'soloUsuarios','uses'=>'ReportsController@showArticulosPorAlmacenAlt']);
Route::post('reportes/articulosPorAlmacenAlt', ['middleware'=>'soloJefe','uses'=>'ReportsController@articulosPorAlmacenAlt']);
//Route::get('reportes/inventarioPorAlmacen', ['middleware'=>'soloJefe','uses'=>'ReportsController@showInventarioPorAlmacen']);
//Route::post('reportes/inventarioPorAlmacen', ['middleware'=>'soloJefe','uses'=>'ReportsController@inventarioPorAlmacen']);
Route::get('reportes/seriadosPorAlmacen/{id}/{article}', ['middleware'=>'soloJefe','uses'=>'ReportsController@showSeriadosPorAlmacen']);

Route::get('reportes/movimientosPorAlmacen',    ['middleware' => 'soloUsuarios','uses'=>'ReportsController@showMovimientosPorAlmacen']);
Route::post('reportes/movimientosPorAlmacen',   ['middleware'=>'soloJefe','uses'=>'ReportsController@movimientosPorAlmacen']);
Route::get('reportes/excelMovimientosPorAlmacen/{rdActivity}/{fechaDesde}/{fechaHasta}/{company_id}', ['middleware'=>'soloJefe','uses'=>'ReportsController@excelMovimientosPorAlmacen']);

Route::get('reportes/movimientosPorTicket',     ['middleware' => 'soloUsuarios','uses'=>'ReportsController@showMovimientosPorTicket']);
Route::post('reportes/movimientosPorTicket',    ['middleware'=>'soloJefe','uses'=>'ReportsController@movimientosPorTicket']);
Route::get('reportes/excelMovimientosPorTicket/{ticket}', ['middleware'=>'soloJefe','uses'=>'ReportsController@excelMovimientosPorTicket']);

Route::get('reportes/movimientosPorUsuario',    ['middleware' => 'soloUsuarios','uses'=>'ReportsController@showMovimientosPorUsuario']);
Route::post('reportes/movimientosPorUsuario',   ['middleware'=>'soloJefe','uses'=>'ReportsController@movimientosPorUsuario']);
Route::get('reportes/buscarEquipo',             ['middleware'=>'soloJefe','uses'=>'ReportsController@showBuscarEquipo']);
Route::get('reportes/buscarEquipo/{serial}',    ['middleware'=>'soloJefe','uses'=>'ReportsController@buscarEquipo']);

Route::get('reportes/movimientosPorArticulo',    ['middleware' => 'soloUsuarios','uses'=>'ReportsController@showMovimientosPorAlmacen']);
Route::post('reportes/movimientosPorArticulo',   ['middleware'=>'soloJefe','uses'=>'ReportsController@movimientosPorAlmacen']);

Route::get('auditorias/serializados',    ['middleware' => 'soloDirector','uses'=>'AuditsController@showSerializados']);
Route::get('auditorias/articulosDesactivados',    ['middleware' => 'soloDirector','uses'=>'AuditsController@desactivateArticles']);
Route::get('auditorias/serializadosPorAlmacen/{id}',    ['middleware' => 'soloDirector','uses'=>'AuditsController@showSerializadosPorAlmacen']);

/*
Route::get('maps/{location}/{filename}', function ($location,$filename)
{
    $path = '/var/www/pandora/storage/planos/' . $location . '/' . $filename;

    //if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
*/

Route::get('maps',    ['middleware' => 'soloUsuarios','uses'=>'MapsController@showLocations']);
Route::get('maps/{location}',    ['middleware' => 'soloUsuarios','uses'=>'MapsController@showMaps']);
Route::get('maps/{location}/{filename}',    ['middleware' => 'soloUsuarios','uses'=>'MapsController@showFile']);
//Route::get('levels',    ['middleware' => 'soloUsuarios','uses'=>'MapsController@showLocations']);
Route::get('levels', function()
{
    return View::make('maps.levels');
});
Route::get('selector', function()
{
    return View::make('maps.selector');
});
/*Route::get('movimientos/alta', function () {
    $warehouseList = Array();

    return view('movements.alta', compact('warehouseList'));
});*/

Route::resource('login', 'CustomAuthController');
Route::get('logout', 'CustomAuthController@logout');
Route::resource('actividades', 'ActivitiesController');
Route::resource('articulos', 'ArticlesController');
Route::resource('vttickets', 'VtticketsController');
Route::resource('empresas', 'CompaniesController');
Route::resource('tipos' , 'TypesController');
Route::resource('usuarios', 'UsersController');
Route::resource('almacenes', 'WarehousesController');
Route::resource('movimientos', 'MovementsController');
Route::resource('mail', 'MailController');


/*Route::get('/', function () {
    return 'Hello World';
});*/