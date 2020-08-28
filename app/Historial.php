<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'historial';
    protected $fillable =[
        'nombre',
        'stock',
        'stock1',
        'precio_proveedor',
        'reingreso',
        'fecha_hora',
        'importe'
    ];

    public $timestamps = true;
    }
