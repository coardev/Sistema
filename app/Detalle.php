<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'idventa', 
        'idarticulo',
        'articulo',
        'cantidad',
        'precio',
        'precio1',
        'estado',
        'importe',
        'promedio'
    ];
    public $timestamps = true;
}
