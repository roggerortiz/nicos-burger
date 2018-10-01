<?php

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

Route::get('/productos', 'ProductoController@index')->name('productos');
Route::post('/productos/crear', 'ProductoController@crear')->name('productos.crear');
Route::post('/productos/editar', 'ProductoController@editar')->name('productos.editar');
Route::post('/productos/eliminar', 'ProductoController@eliminar')->name('productos.eliminar');

Route::get('/productos/{id}/insumos', 'InsumoProductoController@index')->name('productos.insumos');
Route::post('/productos/insumos/agregar', 'InsumoProductoController@agregar')->name('productos.insumos.agregar');
Route::post('/productos/insumos/editar', 'InsumoProductoController@editar')->name('productos.insumos.editar');
Route::post('/productos/insumos/quitar', 'InsumoProductoController@quitar')->name('productos.insumos.quitar');

Route::get('/insumos', 'InsumoController@index')->name('insumos');
Route::post('/insumos/crear', 'InsumoController@crear')->name('insumos.crear');
Route::post('/insumos/editar', 'InsumoController@editar')->name('insumos.editar');
Route::post('/insumos/eliminar', 'InsumoController@eliminar')->name('insumos.eliminar');

Route::get('/', 'RegistroController@index')->name('inicio');
Route::get('/registros/{id}/reporte', 'RegistroController@reporte')->name('registros.reporte');
Route::get('/registros/{id}/ventas', 'RegistroController@ventas')->name('registros.ventas');
Route::get('/registros/{id}/gastos', 'RegistroController@gastos')->name('registros.gastos');
Route::post('/registros/crear', 'RegistroController@crear')->name('registros.crear');

Route::post('/ventas/crear', 'VentaController@crear')->name('ventas.crear');
Route::post('/ventas/editar', 'VentaController@editar')->name('ventas.editar');
Route::post('/ventas/eliminar', 'VentaController@eliminar')->name('ventas.eliminar');

Route::post('/gastos/crear', 'GastoController@crear')->name('gastos.crear');
Route::post('/gastos/editar', 'GastoController@editar')->name('gastos.editar');
Route::post('/gastos/eliminar', 'GastoController@eliminar')->name('gastos.eliminar');
