<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable =[
        'idcategoria','codigo','nombre','inventariable','precio_proveedor','precio_proveedor1','precio_venta','iva','ieps','stock','minimo','promedio','total','existencia','stock1','salida1','descripcion','condicion'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
