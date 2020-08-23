<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historial;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $buscar2 = $request->buscar2;
        $criterio2 = $request->criterio2;
        $buscar1 = $request->buscar1;
        $criterio1 = $request->criterio1;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
       
        
        if ($buscar==''){
            $historial = Historial::orderBy('id', 'desc')->paginate(100000);
        }
        else{
            $historial = Historial::where($criterio2, 'like', '%'. $buscar2 . '%')
            ->whereDate($criterio1, '>=', $buscar1 )
            ->whereDate($criterio, '<=', $buscar)
            ->orderBy('id', 'desc')
            ->paginate(1000000);
        }
        

        return [
            'pagination' => [
                'total'        => $historial->total(),
                'current_page' => $historial->currentPage(),
                'per_page'     => $historial->perPage(),
                'last_page'    => $historial->lastPage(),
                'from'         => $historial->firstItem(),
                'to'           => $historial->lastItem(),
            ],
            'historial' => $historial
        ];
    }
    
   
}
