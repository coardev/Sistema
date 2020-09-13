<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = 'registro';
    protected $fillable =[
        'idarticulo',
        'nombre',
        'articulo',
        'stock',
        'stock1',
        'existencia',
        'entrada1',
        'tipo',
        'precio_proveedor',
        'saldo',
        'saldo1',
        'cantidad',
        'precio',
        'precio1',
        'precio4',
        'reingreso',
        'total',
        'estado',
        'promedio',
        'fecha_hora'
    ];

    public $timestamps = true;
    }
