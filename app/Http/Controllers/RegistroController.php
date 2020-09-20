<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registro;
use Carbon\Carbon;

class RegistroController extends Controller
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
            $registro = Registro::where('tipo','=','1')
            ->where('fecha_hora','=', Carbon :: today())
            ->orderBy('id', 'desc')->paginate(100000000);
        }
        else{
            $registro = Registro::where($criterio2, 'like', '%'. $buscar2 . '%')
            ->whereDate($criterio1, '>=', $buscar1 )
            ->whereDate($criterio, '<=', $buscar)
            ->where('tipo','=','1')
            ->orderBy('id', 'desc')->paginate(10000000);
        }
        

        return [
            'pagination' => [
                'total'        => $registro->total(),
                'current_page' => $registro->currentPage(),
                'per_page'     => $registro->perPage(),
                'last_page'    => $registro->lastPage(),
                'from'         => $registro->firstItem(),
                'to'           => $registro->lastItem(),
            ],
            'registro' => $registro
        ];
    }
    
   
}
