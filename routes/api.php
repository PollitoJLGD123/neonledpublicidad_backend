<?php

use App\Http\Controllers\Api\ContactosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductosController;
use App\Http\Controllers\Api\ReclamacionesController;
use App\Http\Controllers\Api\UsuariosController;
use App\Models\Productos;

// Api Contactanos
// Ruta para obtener contactos con paginación (de 20 en 20)
Route::get('/contactanos', [ContactosController::class, "get"]);
// Usar validacion para  los datos con VALIDATE de laravel
// Ruta para guardar contacto
Route::post('/contactanos', [ContactosController::class, "create"]);
// Ruta para actualizar el estado de un contacto (de 0 a 1)
Route::put('/contactanos/{id}', [ContactosController::class, "update"]);
// Ruta para eliminar un contacto por ID
Route::delete('/contactanos/{id}', [ContactosController::class, "delete"]);

// Api Contactanos
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
Route::post('/user/login', [UsuariosController::class, "login"]);
// Ruta para obtener usuarios con paginación (de 20 en 20)
Route::get('/user', [UsuariosController::class, "getAllByPage"]);
// Ruta para crear un usuario con datos (name, email, password)
Route::post('/user', [UsuariosController::class, "create"]);
// Ruta para crear un usuario con datos (name) y id por parametros
Route::put('/user/{id}', [UsuariosController::class, "update"]);
// Ruta para actualizar contraseña de un usuario con datos (password) y id por parametros
Route::put('/user/pass/{id}', [UsuariosController::class, "updatePass"]);
// Ruta para eliminar un usuario con id por parametros
Route::delete('/user/{id}', [UsuariosController::class, "delete"]);


