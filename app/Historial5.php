<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial5 extends Model
{
    protected $table = 'historial2';
    protected $fillable =[
        'nombre',
        'articulo',
        'stock',
        'stock1',
        'stock2',
        'entrada1',
        'precio_proveedor',
        'cantidad',
        'precio',
        'precio1',
        'saldo',
        'saldo1',
        'promedio',
        'total',
        'reingreso',
        'salida1'
    ];

    public $timestamps = true;
    }
