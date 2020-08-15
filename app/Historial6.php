<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial6 extends Model
{
    protected $table = 'articulos';
    protected $fillable =[
        'idcategoria',
        'codigo',
        'nombre',
        'precio_proveedor',
        'precio_proveedor1',
        'precio_venta',
        'iva',
        'ieps',
        'stock',
        'minimo',
        'promedio',
        'total',
        'existencia',
        'stock1',
        'salida1',
        'descripcion',
        'condicion'
    ];

    public $timestamps = true;
    }
