<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
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
        'precio4',
        'inventariable',
        'estado'
        

    ];
    public $timestamps = true;
}
