<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $table = 'salidas';
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
