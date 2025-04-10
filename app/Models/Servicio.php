<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $primaryKey = 'id_servicio';

    protected $fillable = [
        'id_servicio',
        'nombre',
        'descripcion'
    ];

    public $timestamps = false;

    public function reclamacion(){
        return $this->belongsTo(Reclamacion::class, 'id_servicio');
    }
}
