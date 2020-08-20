<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = 'registro';
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
