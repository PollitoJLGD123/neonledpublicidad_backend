<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contactanos extends Model
{
    use HasFactory;

    protected $table = 'contactanos';
    protected $primaryKey = 'id_contactanos';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'distrito',
        'email',
        'detalle_reclamacion',
        'mensaje',
        'estado',
        'fecha_hora',
        'fecha_hora_actualizacion',
    ];
    
}
