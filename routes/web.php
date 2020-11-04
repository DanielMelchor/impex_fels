<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('salir');

Route::group(['prefix' => 'empresas'], function () {
	Route::get('listado','GenEmpresaFelController@index')->name('empresas');
	Route::post('grabar_empresa','GenEmpresaFelController@store')->name('graba_empresa');
	Route::get('edicion_empresa/{empresa_id}', 'GenEmpresaFelController@edit')->name('edit_empresa');
	Route::post('actualizar_empresa/{empresa_id}','GenEmpresaFelController@update')->name('actualiza_empresa');
});

Route::group(['prefix' => 'consultas'], function () {
	Route::get('listado_fel','MaestroXmlController@index')->name('consulta_fel');
	Route::post('trae_detalle_autoriza', 'MaestroXmlController@get_aut')->name('trae_detalle_autoriza');
	Route::post('trae_detalle_errores', 'MaestroXmlController@get_err')->name('trae_detalle_errores');
});

Route::group(['prefix' => 'municipios'], function () {
	Route::post('trae_municipios_x_depto', 'GenMunicipioController@get_municipio')->name('trae_municipios_x_depto');
});

Route::group(['prefix' => 'permissions'], function(){
	Route::get('listado', 'PermissionController@index')->name('permisos');	
	Route::get('editar/{permiso_id}', 'PermissionController@edit')->name('editar_permiso');
	Route::post('grabar', 'PermissionController@store')->name('grabar_permiso');
	Route::post('actualizar/{permiso_id}', 'PermissionController@update')->name('actualizar_permiso');
});

Route::group(['prefix' => 'roles'], function(){
	Route::get('listado', 'RoleController@index')->name('roles');	
	Route::get('editar/{role_id}', 'RoleController@edit')->name('editar_role');
	Route::post('grabar', 'RoleController@store')->name('grabar_role');
	Route::post('actualizar/{role_id}', 'RoleController@update')->name('actualizar_role');
});

Route::group(['prefix' => 'usuarios'], function(){
	Route::get('listado', 'UsuarioController@index')->name('usuarios');	
	Route::get('editar/{usuario_id}', 'UsuarioController@edit')->name('editar_usuario');
	Route::post('grabar', 'UsuarioController@store')->name('grabar_usuario');
	Route::post('actualizar/{usuario_id}', 'UsuarioController@update')->name('actualizar_usuario');
	Route::get('contrasena', 'UsuarioController@index_contrasena')->name('contrasena');	
	Route::post('actualizar_contrasena', 'UsuarioController@update_contrasena')->name('actualizar_contrasena');
	Route::get('actualizar_pass/{usuario_id}', 'UsuarioController@update_pass')->name('actualizar_pass');
});

Route::get('/certifica', 'XmlController@firmaDocumento')->name('certificar');
Route::get('/reenvio/{xml_id}', 'XmlController@reenvio')->name('reenviar_documento');
