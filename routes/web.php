<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Auth::routes();
Route::get('/logoutSession', [App\Http\Controllers\HomeController::class, 'logout'])->name('logoutSession')->middleware('auth');
################################### RUTAS REGIONES R #############################################################
Route::get('/acceso/R0/{url}', [App\Http\Controllers\RegionController::class, 'AccesoRegionR0'])->name('acceso.r0')->middleware('auth');
Route::get('/acceso/R1/{url}', [App\Http\Controllers\RegionController::class, 'AccesoRegionR1'])->name('acceso.r1')->middleware('auth');
Route::get('/acceso/R2/{url}', [App\Http\Controllers\RegionController::class, 'AccesoRegionR2'])->name('acceso.r2')->middleware('auth');
Route::get('/acceso/R3/{url}', [App\Http\Controllers\RegionController::class, 'AccesoRegionR3'])->name('acceso.r3')->middleware('auth');


################################### RUTAS REGIONES R #############################################################
// --------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/food', [App\Http\Controllers\HomeController::class, 'index2'])->name('patio')->middleware('auth');
Route::get('/food_concentrate', [App\Http\Controllers\HomeController::class, 'index3'])->name('patio_concentrado')->middleware('auth');
Route::get('/accesos_concentrado', [App\Http\Controllers\HomeController::class, 'index4'])->name('accesos')->middleware('auth');
Route::view('/usuarios', 'CRUD.usuarios')->name('usuarios')->middleware('auth', 'can:usuarios.index');
Route::view('/gestion_mall', 'CRUD.mall')->name('mall')->middleware('auth', 'can:mall.index');
// --------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/acceso_exterior', [App\Http\Controllers\AccesoExteriorController::class, 'index'])->name('acceso_exterior')->middleware('auth');

// --------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/search_date', [App\Http\Controllers\buscarFechaController::class, 'index'])->name('searchDate')->middleware('auth');
Route::post('/search_date', [App\Http\Controllers\buscarFechaController::class, 'index'])->name('searchDate.post')->middleware('auth');
Route::get('/limpiar_filtros_search', [App\Http\Controllers\buscarFechaController::class, 'LimpiarFiltrosSearch'])->name('limpiarFiltrosSearch')->middleware('auth');
Route::get('/search_date/pdf', [App\Http\Controllers\buscarFechaController::class, 'pdf'])->name('searchDate.pdf')->middleware('auth');
Route::get('/search_date/excel', [App\Http\Controllers\buscarFechaController::class, 'export'])->name('searchDate.excel')->middleware('auth');

// --------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/accesos_concentrado', [App\Http\Controllers\PrimerPiso::class, 'index4'])->name('accesos_concentrado')->middleware('auth');
Route::get('/food', [App\Http\Controllers\Patio::class, 'index2'])->name('patio')->middleware('auth');
Route::get('/food_concentrate', [App\Http\Controllers\Patio::class, 'index3'])->name('food_concentrate')->middleware('auth');
Route::get('/changePassword', [App\Http\Controllers\Contrasenia::class, 'showChangePasswordForm'])->name('cambiarContraseña')->middleware('auth');
Route::post('/changePassword', [App\Http\Controllers\Contrasenia::class, 'changePassword'])->name('changePassword')->middleware('auth');
// --------------------------------------------------------------------------------------------------------------------------------------------------
Route::resource('users', UserController::class)->only(['index', 'edit', 'update'])->names('admin.users');
// --------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/vehicle', [App\Http\Controllers\VehiculosController::class, 'index'])->name('vehicle')->middleware('auth');
Route::get('/vehiculos_personas', [App\Http\Controllers\VehiculosController::class, 'vehiculosPersonas'])->name('vehiculos_personas')->middleware('auth');
Route::get('/search_vehicle', [App\Http\Controllers\VehiculosController::class, 'buscarPatentes'])->name('search')->middleware('auth');
Route::post('/search_vehicle', [App\Http\Controllers\VehiculosController::class, 'buscarPatentes'])->name('search.post')->middleware('auth');

Route::post('/buscar-patente', [App\Http\Controllers\VehiculosController::class, 'BuscarPatente'])->name('buscar-patente')->middleware('auth');

// ---------------------MANTENEDOR DE MALLS-----------------------------------------------------------------------------------------------------------------------------
Route::get('/malls/listado', [App\Http\Controllers\MallsController::class, 'index'])->name('malls/listado')->middleware('auth');
Route::get('/malls/nuevo', [App\Http\Controllers\MallsController::class, 'NuevoMall'])->name('malls/nuevo')->middleware('auth');
Route::post('/malls/nuevo', [App\Http\Controllers\MallsController::class, 'NuevoMall'])->name('malls/nuevo.post')->middleware('auth');
Route::get('/malls/editar/{id}', [App\Http\Controllers\MallsController::class, 'EditarMall'])->name('malls/editar')->middleware('auth');
Route::post('/malls/editar/{id}', [App\Http\Controllers\MallsController::class, 'EditarMall'])->name('malls/editar.post')->middleware('auth');
Route::post('/malls/eliminar', [App\Http\Controllers\MallsController::class, 'EliminarMall'])->name('malls/eliminar')->middleware('auth');
Route::post('/malls/validar-basedatos', [App\Http\Controllers\MallsController::class, 'ValidarBaseDatos'])->name('malls/validar-basedatos')->middleware('auth');
// ---------------------MANTENEDOR DE USUARIOS-----------------------------------------------------------------------------------------------------------------------------
Route::get('/users/listado', [App\Http\Controllers\UserController::class, 'index'])->name('users/listado')->middleware('auth');
Route::get('/users/nuevo', [App\Http\Controllers\UserController::class, 'NuevoUsuario'])->name('users/nuevo')->middleware('auth');
Route::post('/users/nuevo', [App\Http\Controllers\UserController::class, 'NuevoUsuario'])->name('users/nuevo.post')->middleware('auth');
Route::get('/users/editar/{id}', [App\Http\Controllers\UserController::class, 'EditarUsuario'])->name('users/editar')->middleware('auth');
Route::post('/users/editar/{id}', [App\Http\Controllers\UserController::class, 'EditarUsuario'])->name('users/editar.post')->middleware('auth');
Route::post('/users/eliminar', [App\Http\Controllers\UserController::class, 'EliminarUsuario'])->name('users/eliminar')->middleware('auth');


// Route::middleware(['SwitchDatabase'])->group(function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio')->middleware('auth');
// --------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/marketing', [App\Http\Controllers\MarketingController::class, 'index'])->name('marketing')->middleware('auth');
Route::get('/marketing_yesterday', [App\Http\Controllers\MarketingController::class, 'index2'])->name('marketing_yesterday')->middleware('auth');
Route::get('/marketing_historico', [App\Http\Controllers\MarketingController::class, 'MarketingHistorico'])->name('marketing_historico')->middleware('auth');
Route::post('/marketing_historico', [App\Http\Controllers\MarketingController::class, 'MarketingHistorico'])->name('marketing_historico.post')->middleware('auth');

#ROUTES GERENCIA
Route::get('gerentes/administracion', [App\Http\Controllers\GerenteController::class, 'index'])->name('gerentes/administracion')->middleware('auth');
Route::get('redirect-mall/{id}', [App\Http\Controllers\GerenteController::class, 'RedirectMall'])->name('redirect/mall')->middleware('auth');
Route::get('gerentes/retorna/{distribucion_id}/{user_id_reference}', [App\Http\Controllers\GerenteController::class, 'GerenteRetorna'])->name('gerentes/retorna')->middleware('auth');
Route::get('mi-perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('miperfil')->middleware('auth');
Route::post('mi-perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('miperfil.post')->middleware('auth');

#######################ROUTES ALARMAS##############################
Route::get('alarmas/ingresar-persona', [App\Http\Controllers\AlarmasController::class, 'ingresar_persona'])->name('ingresar_persona')->middleware('auth');
Route::post('alarmas/ingresar-persona', [App\Http\Controllers\AlarmasController::class, 'ingresar_persona'])->name('ingresar_persona.post')->middleware('auth');
Route::post('alarmas/analyze-persona', [App\Http\Controllers\AlarmasController::class, 'AnalyzePersona'])->name('analyze_persona')->middleware('auth');


