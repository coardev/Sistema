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

Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=>['auth']],function(){
    
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardController');
    //Notificaciones 
    Route::post('/notification/get', 'NotificationController@get'); 
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Almacenero']], function () {
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        Route::get('/categoria/listarPdf','CategoriaController@listarPdf')->name('categorias_pdf');

        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/actualizar1', 'ArticuloController@agregar');
        Route::put('/articulo/actualizar2', 'ArticuloController@restar');
        Route::delete('/articulo/eliminar', 'ArticuloController@eliminar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo/listarPdf','ArticuloController@listarPdf')->name('articulos_pdf');

        
        Route::get('/articulo1', 'ArticuloController@index');
        Route::post('/articulo1/registrar', 'ArticuloController@store');
        Route::put('/articulo1/actualizar', 'ArticuloController@update');
        Route::put('/articulo1/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo1/activar', 'ArticuloController@activar');
        Route::get('/articulo1/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo1/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo1/listarPdf','ArticuloController@listarPdf')->name('articulos_pdf');

        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/proveedor/listarPdf','ProveedorController@listarPdf')->name('proveedores_pdf');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}','IngresoController@pdf')->name('ingreso_pdf');
        Route::get('/ingreso/listarPdf','IngresoController@listarPdf')->name('ingresos_pdf');
    });

    Route::group(['middleware' => ['Vendedor']], function () {
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/listarPdf','ClienteController@listarPdf')->name('clientes_pdf');
        Route::get('/salida2', 'HistorialSalidaController@index2');
        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');

        Route::get('/venta', 'VentaController@index');
        Route::get('/venta2', 'VentaController@index2');
        Route::get('/venta3', 'VentaController@index3');
        Route::get('/interna/pdfTicket/{id}','VentaInterna@pdfTicket')->name('ventaticket_pdf');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta1/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta1/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');
        Route::get('/venta/pdfTicket/{id}','VentaController@pdfTicket')->name('ventaticket_pdf');
        Route::get('/venta/pdfTicket1/{id}','VentaController@pdfTicket1')->name('ventaticket_pdf');
        Route::get('/venta/listarPdf','VentaController@listarPdf')->name('ventas_pdf');
    });

    Route::group(['middleware' => ['Administrador']], function () {
        
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        Route::get('/categoria/listarPdf','CategoriaController@listarPdf')->name('categorias_pdf');

        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
        Route::get('/articulo2/listarArticuloVenta2', 'ArticuloController@listarArticuloVentaSalida');
        Route::get('/articulo/listarPdf','ArticuloController@listarPdf')->name('articulos_pdf');

        Route::get('/articulo1', 'ArticuloController@index');
        Route::post('/articulo1/registrar', 'ArticuloController@store');
        Route::put('/articulo1/actualizar', 'ArticuloController@update');
        Route::put('/articulo1/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo1/activar', 'ArticuloController@activar');
        Route::get('/articulo1/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo1/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo1/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo1/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
        Route::get('/articulo1/listarPdf','ArticuloController@listarPdf')->name('articulos_pdf');
        

        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        Route::get('/proveedor/listarPdf','ProveedorController@listarPdf')->name('proveedores_pdf');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/pdf/{id}','IngresoController@pdf')->name('ingreso_pdf');
        Route::get('/ingreso/listarPdf','IngresoController@listarPdf')->name('ingresos_pdf');
        
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/listarPdf','ClienteController@listarPdf')->name('clientes_pdf');

        Route::get('/venta', 'VentaController@index');
        Route::get('/venta2', 'VentaController@index2');
        Route::get('/venta3', 'VentaController@index3');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::get('/interna', 'VentaInterna@index');
        Route::post('/interna/registrar', 'VentaInterna@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::put('/venta/actualizar', 'VentaController@update');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/interna/obtenerCabecera', 'VentaInterna@obtenerCabecera');
        Route::get('/interna/obtenerDetalles', 'VentaInterna@obtenerDetalles');
        Route::get('/venta1/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta1/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}','VentaController@pdf')->name('venta_pdf');
        Route::get('/venta/pdfTicket/{id}','VentaController@pdfTicket')->name('ventaticket_pdf');
        Route::get('/interna/pdf/{id}','VentaInterna@pdf')->name('venta_pdf');
        Route::get('/interna/pdfTicket/{id}','VentaInterna@pdfTicket')->name('ventaticket_pdf');
        Route::get('/interna/pdf/{id}','VentaInterna@pdf')->name('interna_pdf');
        Route::get('/venta/pdfTicket1/{id}','VentaController@pdfTicket1')->name('ventaticket_pdf');
        Route::get('/venta/listarPdf','VentaController@listarPdf')->name('ventas_pdf');

        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        Route::get('/historial', 'HistorialController@index');
        Route::get('/historial2', 'Historial2Controller@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        Route::get('/detalle', 'DetalleController@index');
        Route::get('/cancelacion', 'DetalleCancelacionController@index');
        Route::get('/salida', 'HistorialSalidaController@index');
        Route::get('/salida2', 'HistorialSalidaController@index2');
        Route::put('/salida2/actualizar', 'HistorialSalidaController@update');
        Route::put('/detalle/actualizar', 'DetalleController@update');
        
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
        Route::get('/user/listarPdf','UserController@listarPdf')->name('usuarios_pdf');
    });

});

//Route::get('/home', 'HomeController@index')->name('home');
