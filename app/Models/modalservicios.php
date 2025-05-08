<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modalservicios extends Model
{
    protected $table = 'modalservicios';
    protected $primaryKey = 'id_modalservicio';

    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
        'id_servicio',
        'fecha',
        'estado'
    ];

    public $timestamps = false;

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    public function watModal()
    {
        return $this->hasMany(WatModal::class, 'id_modalservicio', 'id_modalservicio');
    }
    public function emailModal()
    {
        return $this->hasMany(EmailModal::class, 'id_modalservicio', 'id_modalservicio');
    }

}
