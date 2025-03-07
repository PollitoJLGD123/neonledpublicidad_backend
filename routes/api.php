<?php

use App\Http\Controllers\Api\ContactanosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductosController;
use App\Http\Controllers\Api\ReclamacionesController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UsuariosController;

// Api Contactanos

Route::get('/contactanos', [ContactanosController::class, 'get']);
Route::post('/create_contactanos', [ContactanosController::class, 'create']);
Route::put('/contactanos/{id}/estado', [ContactanosController::class, 'updateEstado']);
Route::delete('/eliminar_contacto/{id}', [ContactanosController::class, 'delete']);


// Api Productos
// Ruta para obtener contactos con paginación (de 20 en 20)
Route::get('/productos', [ProductosController::class, "get"]);
// Usar validacion para  los datos con VALIDATE de laravel
// Ruta para guardar contacto
Route::post('/productos', [ProductosController::class, "create"]);
// Ruta para actualizar el estado de un contacto (de 0 a 1)
// Route::put('/productos/{id}', [ProductosController::class, "update"]);
// Ruta para eliminar un contacto por ID
Route::delete('/productos/{id}', [ProductosController::class, "delete"]);


// Api Libro de reclamaciones
// Ruta para obtener contactos con paginación (de 20 en 20)
Route::get('/reclamaciones', [ReclamacionesController::class, "get"]);
// Usar validacion para  los datos con VALIDATE de laravel
// Api para guardar información en el backend ( nompre, apellido, tipo documento, nmr documento, email, celular, direccion, distrito, ciudad, tipo de reclamo, servicio, reclamo, ckeck, acepta politica de privacidad)
Route::post('/reclamaciones', [ReclamacionesController::class, "create"]);
// Ruta para eliminar un contacto por ID
Route::delete('/reclamaciones/{id}', [ReclamacionesController::class, "delete"]);


// Api de Modales de contacto
// Ruta para obtener contactos con paginación (de 20 en 20)
// Route::get('/modal', [ProductosController::class, "get"]);
// Usar validacion para  los datos con VALIDATE de laravel
// Api para guardar información en el backend (nombre, telefono, correo, servicio_id)
// Route::post('/modal', [ProductosController::class, "create"]);
// Ruta para eliminar un contacto por ID
// Route::delete('/modal/{id}', [ProductosController::class, "delete"]);


//login de usuario
Route::post('/user/login', [UserController::class, "login"]);
// Ruta para obtener usuarios con paginación (de 20 en 20)
Route::get('/user', [UserController::class, "getAllByPage"]);
// Ruta para crear un usuario con datos (name, email, password)
Route::post('/user', [UserController::class, "create"]);
// Ruta para crear un usuario con datos (name) y id por parametros
Route::put('/user/{id}', [UserController::class, "update"]);
// Ruta para actualizar contraseña de un usuario con datos (password) y id por parametros
Route::put('/user/pass/{id}', [UserController::class, "updatePass"]);
// Ruta para eliminar un usuario con id por parametros
Route::delete('/user/{id}', [UserController::class, "delete"]);


