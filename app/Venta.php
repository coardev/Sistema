<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable =[
        'idcliente', 
        'idusuario',
        'tipo_comprobante',
        'fecha_hora',
        'total',
        'estado',
        'efectivo',
        'efectivo1',
        'tarjeta',
        'vales'
    ];
}
