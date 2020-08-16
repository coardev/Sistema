<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Detalle;
use App\Historial;
use App\Historial5;
use App\Articulo;
use App\Venta;


class DetalleController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
      
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            
        }
        else{
            $detalle = Detalle::select('detalle_ventas.created_at',
            'detalle_ventas.categoria',DB::raw('sum(detalle_ventas.cantidad*detalle_ventas.precio4+detalle_ventas.precio5+detalle_ventas.precio6+detalle_ventas.cantidad2*detalle_ventas.precio3) as importe'))
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->where('detalle_ventas.estado','=','Venta Cobrada')
            ->groupBy('detalle_ventas.categoria')         
            ->orderBy('id', 'desc')
            ->paginate(10000000);
           
        }
        

        return [
            'pagination' => [
                'total'        => $detalle->total(),
                'current_page' => $detalle->currentPage(),
                'per_page'     => $detalle->perPage(),
                'last_page'    => $detalle->lastPage(),
                'from'         => $detalle->firstItem(),
                'to'           => $detalle->lastItem(),
            ],
            'detalle' => $detalle
        ];
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $detalle = Detalle::findOrFail($request->id);
        $detalle->idarticulo = $request->idarticulo;
        $detalle->idventa = $request->idventa;
        $detalle->precio = $request->precio;
        $detalle->precio1 = $request->precio1;
        $detalle->articulo = $request->articulo;
        $detalle->cantidad = $request->cantidad;
        $detalle->precio_proveedor = $request->precio_proveedor;
        $detalle->total = $request->total;
        $detalle->stock2 = $request->stock2;
        $detalle->estado = 'Venta Cancelada';
        
        $detalle->save();

        //Reingreso Tabla Entrada
        $this->__historial($detalle->articulo, $detalle->cantidad, $detalle->precio_proveedor);

        //Cancelacion de Articulo
        //$this->__historial5($detalle->articulo,$detalle->cantidad,$detalle->stock2,$detalle->precio_proveedor,$detalle->precio1,$detalle->total);
        
        //Actualiza Stock Tabla Articulos
        $this->__articulo($request->idarticulo,$detalle->articulo,$detalle->cantidad);

        //Actualiza Estado Tabla Venta
        $this->__venta($request->idventa,$detalle->estado);
    }


    //Reingreso a Tabla de Entradas
    private function __historial($articulo = '', $cantidad = '', $precio_proveedor = '')
    {
       
        $historial = new Historial();
        $historial->nombre = $articulo;
        $historial->stock1 = $cantidad ;
        $historial->precio_proveedor = $precio_proveedor;
        $historial->reingreso = $precio_proveedor*$cantidad;
        $historial->estado = 'Reingreso' ;
 
        $historial->save();
    }    

    //Reingreso a tabla Entrada + Salidas 
    private function __historial5($articulo = '',$cantidad = '',$stock2 = '',$precio_proveedor = '',$precio1 = '',$total = '')
    {
       
        $historial5 = new Historial5();
        
        $historial5->nombre = $articulo ;
        $historial5->stock = $cantidad ;
        $historial5->existencia = $cantidad + $stock2 ;
        $historial5->precio1 = $precio_proveedor;
        $historial5->promedio = $precio1;
        $historial5->reingreso = $precio1*$cantidad ;
        $historial5->total = ($precio1*$cantidad) + $total ;
        
        
        $historial5->save();
    }   


    //Actualizacion Stock Reingreso Articulo
    private function __articulo($idarticulo = null, $articulo = '',$cantidad = '')
    {
        print($cantidad);
        $articulo = Articulo::findOrFail($idarticulo); 
        //$articulo->articulo = $request->articulo;
       
        $articulo->stock += $cantidad;

        $articulo->save();
    }    

    //Actualizacion Stock Reingreso Articulo
    private function __venta($idventa = null, $estado = '')
    {
       
        $venta = Venta::findOrFail($idventa); 
        //$articulo->articulo = $request->articulo;
        $venta->estado = 'Venta Cancelada';

        $venta->save();
    }    
   
}
