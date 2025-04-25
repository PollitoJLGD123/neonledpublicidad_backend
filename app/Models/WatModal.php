<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WatModal extends Model
{
    use HasFactory;

    protected $table = 'modal_wats';
    protected $primaryKey = 'id_modal_wat';
    public $timestamps = false;

    protected $fillable = [
        'estado',
        'error',
        'id_modalservicio',
        'number_message',
        'fecha',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function modalServicio(){
        return $this->belongsTo(modalservicios::class,'id_modal_servicio', 'id_modalservicio');
    }
}
