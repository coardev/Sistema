<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleInterna extends Model
{
    protected $table = 'detalle_internas';
    protected $fillable = [
        'idventa', 
        'stock', 
        'stock2', 
        'articulo', 
        'idarticulo',
        'cantidad',
        'precio',
        'precio_proveedor',
        'promedio',
        'total',
        'precio1',
        'precio3',
        'inventariable',
        'granel',
        'fecha_hora'

    ];
    public $timestamps = false;
}
