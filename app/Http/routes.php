<?php
Route::get('/', function () {
    return view('auth/login');
});
Route::get('/acerca', function () {
    return view('acerca');
});

Route::resource('almacen/categoria','CategoriaController');
Route::resource('caja','CajaController');
Route::resource('consultacaja','ConsultaCajaController');
Route::resource('caja/detalle','DetalleCajaController');
Route::resource('almacen/subcategoria','SubcategoriaController');
Route::resource('almacen/marca','MarcaController');
Route::resource('consultas/compras','ConsulVenController');
Route::resource('consultas/compras','ConsulCompController');
Route::resource('movimientos/ultimos','MovimientoController');
Route::resource('traslados/articulos','ArticuloController2');//para sucursales ventas/credito/fechas
Route::resource('traslados/stock','StockController');
Route::resource('ventas/credito/fechas','FechaController');
Route::resource('pedidos/stock','Stock2Controller');
Route::resource('pedidos/entrantes','PedidoEntraController');
Route::resource('pedidos/realizados','PedidoHechoController');
Route::resource('pedidos/proveedor','PedidoProveedorController');
Route::resource('traslados/realizados','TrasladoHechoController');
Route::resource('traslados/entrantes','TrasladoEntraController');
Route::resource('almacen/material','MaterialController');
Route::resource('almacen/tipo','TipoController');
Route::resource('almacen/talla','TallaController');
Route::resource('almacen/edad','EdadController');
Route::resource('almacen/articulo','ArticuloController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('ventas/credito','CreditoController');
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');
Route::resource('compras/credito','CreditoProveedorController');
Route::resource('ventas/venta','VentaController');
Route::resource('seguridad/usuario','UsuarioController');

Route::resource('compras/proveedor/plus/ok','DetalleProveedorController');
Route::resource('almacen/articulo/plus/ok','DetalleArticuloController');

Route::get('events/{id_act}/remind/{role}/ok/{id_a}', [
'as' => 'sucursal_actual', 'uses' => 'RedireccionarController@designar']);

Route::get('eliminar/{id_act}', [
'as' => 'Eliminar_detalle', 'uses' => 'ProveedorController@update2']);

Route::get('eliminar2/{id_act}', [
'as' => 'Eliminar_detalle_not', 'uses' => 'TrasladoHechoController@destroy']);

Route::get('micuenta','UsuarioController@cuenta');
Route::get('traslados/stock/plus/{id}/articulos','TrasladoController@byArticulos');
Route::get('traslados/articulos/create/{id}/datos','ArticuloController2@byArticulos');

Route::get('pedidos/proveedor/show2/{id}','PedidoProveedorController@byresumen');



Route::get('traslados/stock/plus/{id}/articulos0','TrasladoController@byArticulos0');
Route::get('traslados/stock/plus/{id1}/mistock/{id2}/suc','TrasladoController@byStock');
Route::get('traslados/stock/plus/{id10}/mistock0/{id20}/suc0','TrasladoController@byStock0');
///pedidos/proveedor/show/mostrar
Route::get('pedidos/entrantes/show/{id1}/editar/{id2}/values/{id3}','PedidoEntraController@byupdate');

Route::get('ventas/credito/plus/{id1}/editar/{id2}/{id3}/{id4}','CreditoController@byupdate');

Route::get('pedidos/proveedor/show/{id1}/editar/{id2}','PedidoProveedorController@byupdate');
Route::get('pedidos/proveedor/show/mostrar/{id}','PedidoProveedorController@bymostrar');
Route::get('traslados/stock/plus/{idk1}/mistockk/{idk2}/suck','TrasladoController@byStockk');
Route::get('pedidos/realizados/plus/{id}/stock','PedidoHechoController@byStock');
Route::get('pedidos/realizados/plus/{id}/stock2','PedidoHechoController@byStock2');
Route::get('almacen/articulo/create/{id}/tipos','TipoController@bySubcategoria');

//AUI 15/08
Route::get('almacen/articulo/create/{id}/subcategorias','SubcategoriaController@bySubcategoria');
Route::get('compras/ingreso/create/{id}/detalles','IngresoController@byDetalles');
Route::get('ventas/venta/create/{id}/detalles','VentaController@byDetalles');
Route::get('compras/ingreso/create/{id}/filtro','IngresoController@byFiltro');
Route::get('ventas/venta/create/nuevo','ClienteController@store2');
Route::get('almacen/articulo/create/{id}/materiales','MaterialController@bySubcategoria');
Route::get('almacen/articulo/create/{id}/tallas','TallaController@bySubcategoria');



//Route::get('almacen/articulo/create/nuevo','ClienteController@store2');


Route::get('almacen/articulo/edit/{id}/tipos','TipoController@bySubcategoria');
Route::get('almacen/articulo/edit/{id}/materiales','MaterialController@bySubcategoria');
Route::get('almacen/articulo/edit/{id}/tallas','TallaController@bySubcategoria');

Route::auth();

Route::get('/home', 'HomeController@index');
//modificando
Route::get('/escritorio', 'EscritorioController@index');
Route::get('/escritorio_suc', 'Escritorio_SucursalController@index');
//Reportes
Route::get('reportecategorias', 'CategoriaController@reporte');
//mi inteto
Route::get('crear_reporte_ventas/general', 'VentaController@reporte1');
Route::get('reporteventaf/{id}', 'VentaController@factura');
Route::get('reporteventat/{id}', 'VentaController@ticket');
Route::get('reporteventab/{id}', 'VentaController@boleta');
Route::get('reporteventag/{id}', 'VentaController@guia');


//aaaa T.T
Route::get('reportearticulos', 'ArticuloController@reporte');
Route::get('reporteclientes', 'ClienteController@reporte');
Route::get('reporteproveedores', 'ProveedorController@reporte');
Route::get('reporteventas', 'VentaController@reporte');
Route::get('reporteingresos', 'IngresoController@reporte');
Route::get('reporteingreso/{id}', 'IngresoController@reportec');
Route::get('/{slug?}', 'HomeController@index');
