<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamaciones extends Model
{
    protected $table = 'reclamacion';

    protected $primaryKey = 'id_reclamacion';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'departamento',
        'direccion',
        'distrito',
        'tipo_servicio',
        'fecha_incidente',
        'monto_reclamado',
        'descripcion_servicio',
        'declaracion_veraz',
        'acepta_politica',
        'estado',
    ];

    // Deshabilitar timestamps si no usas `created_at` y `updated_at`
    public $timestamps = false;

    // Ajustar el formato de los campos de fecha y decimal
    protected $casts = [
        'fecha_incidente' => 'date', // Formato de fecha
        'monto_reclamado' => 'decimal:2', // Decimal con 2 decimales
        'declaracion_veraz' => 'boolean', // Convertir tinyint(1) a booleano
        'acepta_politica' => 'boolean', // Convertir tinyint(1) a booleano
    ];
}
