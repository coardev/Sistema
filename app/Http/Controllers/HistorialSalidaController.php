<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historial2;
use App\DetalleInterna;
use App\Articulo;
use Carbon\Carbon;

class HistorialSalidaController extends Controller
{
    //Todas los Tipos de Salida -- Perfil Administrador
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $historial2 = Historial2::where('inventariable','=','1')
            ->where('fecha_hora','=', Carbon :: today())
            ->orderBy('id', 'desc')->paginate(100000000);
        }
        else{
            $historial2 = Historial2::where($criterio, 'like', '%'. $buscar . '%')
            ->where('inventariable','=','1')
            ->orderBy('id', 'desc')->paginate(10000000);
        }
        

        return [
            'pagination' => [
                'total'        => $historial2->total(),
                'current_page' => $historial2->currentPage(),
                'per_page'     => $historial2->perPage(),
                'last_page'    => $historial2->lastPage(),
                'from'         => $historial2->firstItem(),
                'to'           => $historial2->lastItem(),
            ],
            'historial2' => $historial2
        ];
    }
    
    //Venta Internas -- Perfil Vendedor
    public function index2(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar2 = $request->buscar2;
        $criterio2 = $request->criterio2;
        $buscar1 = $request->buscar1;
        $criterio1 = $request->criterio1;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $historial2 = DetalleInterna::where('estado','=','Venta Interna')
            ->where('fecha_hora','=', Carbon :: today())
            ->orderBy('id', 'desc')->paginate(10000);
        }
        else{
            $historial2 = DetalleInterna::where($criterio2, 'like', '%'. $buscar2 . '%')
            ->whereDate($criterio1, '>=', $buscar1 )
            ->whereDate($criterio, '<=', $buscar)
            ->orderBy('id', 'desc')
            ->paginate(10000000);
        }
        

        return [
            'pagination' => [
                'total'        => $historial2->total(),
                'current_page' => $historial2->currentPage(),
                'per_page'     => $historial2->perPage(),
                'last_page'    => $historial2->lastPage(),
                'from'         => $historial2->firstItem(),
                'to'           => $historial2->lastItem(),
            ],
            'historial2' => $historial2
        ];
    }
    

    //Index Para Tabla Salidas -- Administrador
    public function index3(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar2 = $request->buscar2;
        $criterio2 = $request->criterio2;
        $buscar1 = $request->buscar1;
        $criterio1 = $request->criterio1;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $historial2 = Historial2::where('inventariable','=','1')
            ->where('fecha_hora','=', Carbon :: today())
            ->orderBy('id', 'desc')->paginate(10000);
        }
        else{
            $historial2 = Historial2::where($criterio2, 'like', '%'. $buscar2 . '%')
            ->whereDate($criterio1, '>=', $buscar1 )
            ->whereDate($criterio, '<=', $buscar)
            ->where('inventariable','=','1')
            ->orderBy('id', 'desc')
            ->paginate(10000000);
        }
        

        return [
            'pagination' => [
                'total'        => $historial2->total(),
                'current_page' => $historial2->currentPage(),
                'per_page'     => $historial2->perPage(),
                'last_page'    => $historial2->lastPage(),
                'from'         => $historial2->firstItem(),
                'to'           => $historial2->lastItem(),
            ],
            'historial2' => $historial2
        ];
    }

    //Devolucion Articulo -- Venta Interna
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $historial2 = DetalleInterna::findOrFail($request->id);
        $historial2->estado = 'Venta Devuelta';
        $historial2->idarticulo = $request->idarticulo;
        $historial2->cantidad = $request->cantidad;
        $historial2->articulo = $request->articulo;
        $historial2->save();

        $this->__articulo($request->idarticulo,$historial2->articulo,$historial2->cantidad);

    }
    
    //Devolucion de Articulo de Venta Interna
    private function __articulo($idarticulo = null, $articulo = '',$cantidad = '')
    {
        print($cantidad);
        $articulo = Articulo::findOrFail($idarticulo); 
        //$articulo->articulo = $request->articulo;
       
        $articulo->stock += $cantidad;

        $articulo->save();
    }    
    
   
}
