<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;
    protected $table = 'cards';
    protected $primaryKey = 'id_card';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'public_image',
        'url_image',
        'id_plantilla',
        'id_blog',
        'id_empleado'
    ];

    public function blog(){
        return $this->hasOne(Blog::class, 'id_blog', 'id_blog');
    }

    public function empleado(){
        return $this->hasOne(Empleado::class, 'id_empleado', 'id_empleado');
    }
}
