<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial2 extends Model
{
    protected $table = 'historial2';
    protected $fillable =[
        'nombre',
        'articulo',
        'cantidad',
        'precio4',
        'estado',
        'inventariable',
        'salida1'
    ];

    public $timestamps = true;
    }
