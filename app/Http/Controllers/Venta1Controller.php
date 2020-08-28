<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\Historial2;
use App\DetalleVenta;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $buscar1 = $request->buscar1;
        $criterio1 = $request->criterio1;
        
        if ($buscar==''){
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante',
            'ventas.created_at','ventas.fecha_hora','ventas.efectivo','ventas.efectivo1','ventas.tarjeta','ventas.vales','ventas.cambio','ventas.total',
            'ventas.estado','personas.nombre','users.usuario')
            ->where('ventas.fecha_hora','=', Carbon :: today())
            ->orderBy('ventas.id', 'desc')
            ->paginate(250);
        }
        else{
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante',
            'ventas.created_at','ventas.fecha_hora','ventas.efectivo','ventas.efectivo1','ventas.tarjeta','ventas.vales','ventas.cambio','ventas.total',
            'ventas.estado','personas.nombre','users.usuario')
            ->whereDate($criterio, '>=', $buscar)
            ->whereDate($criterio1, '<=', $buscar1)
            ->orderBy('ventas.id', 'desc')
            ->paginate(1000000);
        }
        
        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante',
        'ventas.fecha_hora','ventas.total',
        'ventas.estado','personas.nombre','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();
        
        return ['venta' => $venta];
    }
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio',
        'articulos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }
      
    public function listarPdf(){
        $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante',
            'ventas.fecha_hora','ventas.total',
            'ventas.estado','personas.nombre','users.usuario')
            ->orderBy('ventas.id', 'desc')->get();
        $cont=Venta::count();

        $pdf = \PDF::loadView('pdf.ventaspdf',['ventas'=>$ventas,'cont'=>$cont])->setPaper('a4', 'landscape');
        return $pdf->download('ventas.pdf');
    }

    public function pdf(Request $request,$id){
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante',
        'ventas.created_at','ventas.total',
        'ventas.estado','personas.nombre',
        'personas.direccion','personas.email',
        'personas.telefono','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();

        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio',
        'articulos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $numventa=Venta::select('id')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.venta',['venta'=>$venta,'detalles'=>$detalles]);
        return $pdf->download('venta-'.$numventa[0]->id.'.pdf');
    }

    public function pdfTicket(Request $request,$id){
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante',
        'ventas.created_at','ventas.total',
        'ventas.estado','personas.nombre',
        'personas.direccion','personas.email',
        'personas.telefono','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();

        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio',
        'articulos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $numventa=Venta::select('id')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.ventaticket',['venta'=>$venta,'detalles'=>$detalles]);
        return $pdf->download('ventaTicket-'.$numventa[0]->id.'.pdf');
    }

    public function pdfTicket1(Request $request,$id){
        $venta1 = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante',
        'ventas.created_at','ventas.total',
        'ventas.estado','personas.nombre',
        'personas.direccion','personas.email',
        'personas.telefono','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();

        $detalles1 = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio',
        'articulos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $numventa1=Venta::select('id')->where('id',$id)->get();

        $pdf1 = \PDF::loadView('pdf.ventaticket1',['venta'=>$venta1,'detalles'=>$detalles1]);
        return $pdf1->download('ventaTicket1-'.$numventa1[0]->id.'.pdf');
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = \Auth::user()->id;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->fecha_hora = $mytime->toDateString();
            $venta->total = $request->total;
            $venta->estado = 'Venta Registrada';
            $venta->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                $detalle->stock = $det['stock'];
                $detalle->articulo = $det['articulo'];
                $detalle->categoria = $det['nombre_categoria'];
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio_proveedor = $det['precio_proveedor'];  
                $detalle->precio = $det['precio'];    
                $detalle->precio1 = $det['precio1'];
                $detalle->stock2 = $det['stock']-$det['cantidad'];
                $detalle->importe = $det['precio']*$det['cantidad'];
                $detalle->total = ($det['stock']-$det['cantidad'])*$det['precio1'];
                $detalle->estado = 'Venta Concretada';

                $detalle->save();
                $this->__historial2($detalle->articulo,$detalle->cantidad,$detalle->precio1,$detalle->stock2,$detalle->total);
               
            }       
            DB::commit();
            return [
                'id' => $venta->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $venta = Venta::findOrFail($request->id);
        $venta->efectivo = $request->efectivo;
        $venta->estado = 'Venta Concretada';
        $venta->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $venta = Venta::findOrFail($request->id);
        $venta->tarjeta = $request->tarjeta;
        $venta->vales = $request->vales;
        $venta->efectivo = $request->efectivo;
        $venta->estado = 'Venta Cobrada';
        $venta->save();
    }

    private function __historial2($articulo = '',$cantidad = '',$precio1 = '',$stock2 = '',$total = '')
    {
       
        $historial2 = new Historial2();
        
        $historial2->nombre = $articulo ;
        $historial2->cantidad = $cantidad ;
        $historial2->salida1 = $cantidad*$precio1 ;
        $historial2->existencia = $stock2 ;
        $historial2->promedio = $precio1 ;
        $historial2->total = $total ;
        $historial2->save();
    }    
   
}
