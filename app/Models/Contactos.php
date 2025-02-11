<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contactanos extends Model
{
    use HasFactory;

    protected $table = 'contactanos'; // Nombre correcto de la tabla en la base de datos

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nombre', 
        'apellido', 
        'telefono', 
        'distrito', 
        'email', 
        'tipo_reclamo', 
        'mensaje', 
        'estado', 
        'fecha_hora', 
        'fecha_hora_actualizacion'
    ];

    // Deshabilitar las columnas automáticas de timestamps si están gestionadas manualmente en la tabla
    public $timestamps = false;

    // Opcional: definir las columnas de fechas explícitas para el manejo de timestamp
    protected $dates = ['fecha_hora', 'fecha_hora_actualizacion'];
}
