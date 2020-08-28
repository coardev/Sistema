<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial4 extends Model
{
    protected $table = 'historial';
    protected $fillable =[
        'nombre',
        'stock',
        'stock1',
        'precio_proveedor',
        'importe',
        'fecha_hora'
    ];

    public $timestamps = true;
    }
