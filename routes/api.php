<?php

use Illuminate\Http\Request;
use App\Exports\ContratosExport;
use App\Exports\EventosExport;
use Maatwebsite\Excel\Facades\Excel;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\Auth\LoginController@login');

Route::post('refresh', 'Api\Auth\LoginController@refresh');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api','scope:administrador,editor,visor,apiweb']], function(){

	// auth login regis
	Route::post('logout', 'Api\Auth\LoginController@logout');

	Route::resource('proveedores', 'ProveedorController');
	Route::resource('proveedoresc', 'ProveedorCController');
	Route::resource('ordenes', 'OrdenController');
	
	//Route::resource('po_vendor', 'Po_vendorController');
	Route::resource('usuarios', 'UserController');
	Route::resource('socio', 'SocioController');
	Route::resource('categoria', 'CategoriaController');
	Route::resource('archivo', 'ArchivoController');
	Route::resource('contrato', 'ContratoController');
	Route::resource('evento', 'EventoController');
	Route::resource('uorganizativa', 'OrganizativaUnidadController');

	Route::get('archivos', 'ArchivoController@archivos');
	Route::get('archivosFile', 'ArchivoController@archivosFile');
	
	Route::get('ordenver', 'OrdenController@ordenver');
	Route::get('contratover', 'ContratoController@contratover');

	Route::get('sociosall', 'AngularController@socios');

	Route::get('contratosall', 'AngularController@contratos');
	Route::get('uorganizativasall', 'AngularController@uorganizativas');
	
	Route::get('usuariosall', 'AngularController@usuarios');

	Route::get('countnot', 'AngularController@countnot');
	Route::get('cambiarestadonot', 'AngularController@cambiarestadonot');
	//recursos
	Route::get('departamentosall', 'RecursoController@departamentosall');
	Route::get('cuentasall', 'RecursoController@cuentasall');
	Route::get('subcuentasall', 'RecursoController@subcuentasall');
	Route::get('marcasall', 'RecursoController@marcasall');
	Route::get('categoriasall', 'RecursoController@categoriasall');
	Route::get('usersall', 'RecursoController@usersall');
	Route::get('bancosall', 'RecursoController@bancosall');
	Route::get('paisesall', 'RecursoController@paisesall');
	Route::get('accall', 'RecursoController@accall');
	Route::get('terminospagoall', 'RecursoController@terminospagoall');
	Route::get('terminospagocoinsall', 'RecursoController@terminospagocoinsall');
	Route::get('metodospagoall', 'RecursoController@metodospagoall');
	
	Route::get('proveedorestall', 'RecursoController@proveedorestall');
	Route::get('proveedorestone', 'RecursoController@proveedorestone');

	Route::get('ordenesprove', 'ResponsableController@responsables');
	// Route::delete('responsables', 'ResponsableController@destroy');
	Route::delete('/responsables/{id}', 'ResponsableController@destroy');
	Route::get('responsables', 'ResponsableController@responsables');
	Route::post('responsables', 'ResponsableController@store');
	
	Route::post('cuotas', 'CuotaController@store');
	Route::get('cuotas', 'CuotaController@cuotas');

	Route::get('recordatorios', 'RecordatorioController@recordatorios');


	Route::put('/contratos/{id}', 'ContratoController@update');
	Route::post('contratos', 'ContratoController@store');
	

	Route::put('proveedoresc', 'ProveedorCController@update');
	
	// Route::get('ordenver', 'OrdenController@ordenver');
	Route::post('ordenc', 'OrdenCController@store');
	Route::get('ordenesproveedor', 'OrdenController@ordenesproveedor');

});
	Route::get('/excelcontratos/{id}/{dateinicio?}/{datefin?}', function ($id,$dateinicio='',$datefin='') {
		return Excel::download(new ContratosExport($id,$dateinicio,$datefin), 'contratos.xlsx');

	});

	Route::get('/exceleventos/{id}/{dateinicio?}/{datefin?}', function ($id,$dateinicio='',$datefin='') {
		return Excel::download(new EventosExport($id,$dateinicio,$datefin), 'eventos.xlsx');
	});