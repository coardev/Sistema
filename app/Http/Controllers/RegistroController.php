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

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $registro = Registro::where('inventariable','=','1')
            ->where('fecha_hora','=', Carbon :: today())
            ->orderBy('id', 'desc')->paginate(100000000);
        }
        else{
            $registro = Registro::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10000000);
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
