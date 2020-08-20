<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historial2;

class Historial2Controller extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $historial2 = Historial2::orderBy('id', 'desc')->paginate(100000000);
        }
        else{
            $historial2 = Historial2::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10000000);
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
    
   
}
