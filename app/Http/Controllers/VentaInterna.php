<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\Interna;
use App\Historial2;
use App\Salida;
use App\DetalleVenta;
use App\DetalleInterna;

class VentaInterna extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $internas = Interna::where('fecha_hora','=', Carbon :: today())
            ->orderBy('id', 'desc')->paginate(100000000);
        }
        else{
            $internas = Interna::join('personas','internas.idcliente','=','personas.id')
            ->join('users','internas.idusuario','=','users.id')
            ->select('internas.id','internas.tipo_comprobante',
            'internas.created_at','internas.efectivo','internas.efectivo1','internas.tarjeta','internas.vales','internas.cambio','internas.total',
            'internas.estado','personas.nombre','users.usuario')
            ->where('internas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('internas.id', 'desc')
            ->paginate(10000000);
        }
        
        return [
            'pagination' => [
                'total'        => $internas->total(),
                'current_page' => $internas->currentPage(),
                'per_page'     => $internas->perPage(),
                'last_page'    => $internas->lastPage(),
                'from'         => $internas->firstItem(),
                'to'           => $internas->lastItem(),
            ],
            'internas' => $internas
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $interna = Interna::join('personas','internas.idcliente','=','personas.id')
        ->join('users','internas.idusuario','=','users.id')
        ->select('internas.id','internas.tipo_comprobante',
        'internas.created_at','internas.total',
        'internas.estado','personas.nombre','users.usuario')
        ->where('internas.id','=',$id)
        ->orderBy('internas.id', 'desc')->take(1)->get();
        
        return ['interna' => $interna];
    }
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $internas = DetalleInterna::join('articulos','detalle_internas.idarticulo','=','articulos.id')
        ->select('detalle_internas.cantidad','detalle_internas.precio4','detalle_internas.cantidad1','detalle_internas.precio5','detalle_internas.cantidad2','detalle_internas.precio3','detalle_internas.precio','detalle_internas.inventariable',
        'articulos.nombre as articulo')
        ->where('detalle_internas.idventa','=',$id)
        ->orderBy('detalle_internas.id', 'desc')->get();
        
        return ['internas' => $internas];
    }
      
    

    public function pdf(Request $request,$id){
        $interna = Interna::join('personas','internas.idcliente','=','personas.id')
        ->join('users','internas.idusuario','=','users.id')
        ->select('internas.id','internas.tipo_comprobante',
        'internas.created_at','internas.total',
        'internas.estado','personas.nombre',
        'personas.direccion','personas.email',
        'personas.telefono','users.usuario')
        ->where('internas.id','=',$id)
        ->orderBy('internas.id', 'desc')->take(1)->get();

        $internas = DetalleInterna::join('articulos','detalle_internas.idarticulo','=','articulos.id')
        ->select('detalle_internas.cantidad','detalle_internas.precio',
        'articulos.nombre as articulo')
        ->where('detalle_internas.idventa','=',$id)
        ->orderBy('detalle_internas.id', 'desc')->get();

        $numventa=Interna::select('id')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.interna',['interna'=>$interna,'internas'=>$internas]);
        return $pdf->download('interna-'.$numventa[0]->id.'.pdf');
    }

    public function pdfTicket(Request $request,$id){
        $interna = Interna::join('personas','internas.idcliente','=','personas.id')
        ->join('users','internas.idusuario','=','users.id')
        ->select('internas.id','internas.tipo_comprobante',
        'internas.created_at','internas.total','internas.cambio','internas.efectivo',
        'internas.estado','personas.nombre',
        'personas.direccion','personas.email',
        'personas.telefono','users.usuario')
        ->where('internas.id','=',$id)
        ->orderBy('internas.id', 'desc')->take(1)->get();

        $internas = DetalleInterna::join('articulos','detalle_internas.idarticulo','=','articulos.id')
        ->select('detalle_internas.cantidad','detalle_internas.precio4','detalle_internas.cantidad1','detalle_internas.precio5','detalle_internas.cantidad2','detalle_internas.precio','detalle_internas.precio3',
        'articulos.nombre as articulo')
        ->where('detalle_internas.idventa','=',$id)
        ->orderBy('detalle_internas.id', 'desc')->get();

        $numventa=Interna::select('id')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.internaticket',['interna'=>$interna,'internas'=>$internas]);
        return $pdf->download('ventaTicket-'.$numventa[0]->id.'.pdf');
    }

    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $interna = new Interna();
            $interna->idcliente = $request->idcliente;
            $interna->idusuario = \Auth::user()->id;
            $interna->tipo_comprobante = $request->tipo_comprobante;
            $interna->fecha_hora = $mytime->toDateString();
            $interna->total = $request->total;
            $interna->estado = 'Venta Interna';
            $interna->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleInterna();
                $detalle->idventa = $interna->id;
                $detalle->stock = $det['stock'];
                $detalle->inventariable = $det['inventariable'];  
                $detalle->articulo = $det['articulo'];
                $detalle->categoria = $det['nombre_categoria'];
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio4 = $det['precio4'];
                $detalle->cantidad1 = $det['cantidad1'];
                $detalle->precio5 = $det['precio5'];
                $detalle->cantidad2 = $det['cantidad2'];
                $detalle->precio3 = $det['precio3'];
                $detalle->precio_proveedor = $det['precio_proveedor'];  
                $detalle->precio = $det['precio'];  
                $detalle->precio1 = $det['precio1'];
                $detalle->stock2 = $det['stock']-$det['cantidad'];
                $detalle->importe = $det['precio']*$det['cantidad'];
                $detalle->total = ($det['stock']-$det['cantidad'])*$det['precio1'];
                $detalle->fecha_hora = $mytime->toDateString();
                $detalle->estado = 'Venta Interna';


                //Tabla Salidas -- Perfil Administrador
                $detalle->save();
                $this->__historial2($detalle->articulo,$detalle->cantidad,$detalle->precio4,$detalle->inventariable,$detalle->idarticulo,$detalle->fecha_hora);
               
            }       
            DB::commit();
            return [
                'id' => $interna->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    

    //Tabla Salidas -- Perfil Administrador
    private function __historial2($articulo = '',$cantidad = '',$precio4 = '',$inventariable = '',$idarticulo = '',$fecha_hora = '')
    {
       
        $historial2 = new Salida();
        
        $historial2->articulo = $articulo ;
        $historial2->precio4 = $precio4 ;
        $historial2->cantidad = $cantidad ;
        $historial2->inventariable = $inventariable ;
        $historial2->idarticulo = $idarticulo ;
        $historial2->estado = 'Venta Interna' ;
        $historial2->fecha_hora = $fecha_hora ;
        $historial2->save();
    }    

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $interna = Interna::findOrFail($request->id);
        $interna->estado = 'Venta Cancelada';
        $interna->save();

        $this->__detalleVenta($request->id);
    }

    private function __detalleVenta($id = null)
{ 
    DetalleInterna::where('idventa', $id)->update(['estado' => 'Venta Cancelada']);
          
} 

   
}
