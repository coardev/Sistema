<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Historial;
use App\Historial2;
use App\Registro;
use App\Historial3;
use App\Historial4;
use Carbon\Carbon;
use App\User;


class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        Articulo::all() -> last();
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.inventariable','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_proveedor','articulos.minimo','articulos.precio_proveedor1','articulos.precio_venta','articulos.promedio','articulos.iva','articulos.ieps','articulos.stock','articulos.total','articulos.descripcion','articulos.condicion','articulos.created_at')
            ->orderBy('articulos.id', 'asc')->paginate(100);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.inventariable','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_proveedor','articulos.minimo','articulos.precio_proveedor1','articulos.precio_venta','articulos.promedio','articulos.iva','articulos.ieps','articulos.stock','articulos.total','articulos.descripcion','articulos.condicion','articulos.created_at')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'asc')->paginate(1500);
        }
        

        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

    public function listarArticulo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.inventariable','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_proveedor','articulos.minimo','articulos.precio_proveedor1','articulos.precio_venta','articulos.promedio','articulos.total','articulos.promedio','articulos.stock','articulos.descripcion','articulos.condicion','articulos.created_at')
            ->orderBy('articulos.id', 'asc')->paginate(2500);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.inventariable','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_proveedor','articulos.minimo','articulos.precio_proveedor1','articulos.precio_venta','articulos.promedio','articulos.total','articulos.promedio','articulos.stock','articulos.descripcion','articulos.condicion','articulos.created_at')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'asc')->paginate(2500);
        }
        

        return ['articulos' => $articulos];
    }
 
    public function listarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.inventariable','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_proveedor','articulos.minimo','articulos.precio_proveedor1','articulos.precio_venta','articulos.promedio','articulos.iva','articulos.ieps','articulos.stock','articulos.total','articulos.promedio','articulos.descripcion','articulos.condicion','articulos.created_at')
            //->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'asc')->paginate(100);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.inventariable','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_proveedor','articulos.minimo','articulos.precio_proveedor1','articulos.precio_venta','articulos.promedio','articulos.iva','articulos.ieps','articulos.stock','articulos.total','articulos.promedio','articulos.descripcion','articulos.condicion','articulos.created_at')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            //->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'asc')->paginate(1500);
        }
        

        return ['articulos' => $articulos];
    }

    public function listarArticuloVentaSalida(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.inventariable','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_proveedor','articulos.minimo','articulos.precio_proveedor1','articulos.precio_venta','articulos.promedio','articulos.iva','articulos.ieps','articulos.stock','articulos.total','articulos.promedio','articulos.descripcion','articulos.condicion','articulos.created_at')
             ->where('articulos.inventariable','=','1')
            ->orderBy('articulos.id', 'asc')->paginate(2500);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.inventariable','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_proveedor','articulos.minimo','articulos.precio_proveedor1','articulos.precio_venta','articulos.promedio','articulos.iva','articulos.ieps','articulos.stock','articulos.total','articulos.promedio','articulos.descripcion','articulos.condicion','articulos.created_at')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.inventariable','=','1')
            ->orderBy('articulos.id', 'asc')->paginate(2500);
        }
        

        return ['articulos' => $articulos];
    }

    public function listarPdf(){
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.nombre')
            ->orderBy('articulos.nombre', 'asc')->get();

        $cont=Articulo::count();

        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont])->setPaper('a4', 'Portrait');
        return $pdf->download('articulos.pdf');
    }

    public function buscarArticulo(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $articulos];
    }

    public function buscarArticuloVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id','nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['articulos' => $articulos];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
     
       
        $articulo = new Articulo();
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_proveedor = $request->precio_proveedor;
        $articulo->precio_proveedor1 = $request->stock*$request->precio_proveedor / $request->stock;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->iva = $request->iva;
        $articulo->inventariable = $request->inventariable;
        $articulo->ieps = $request->ieps;
        $articulo->stock = $request->stock;
        $articulo->minimo = $request->minimo;
        $articulo->promedio = $request->stock*$request->precio_proveedor/$request->stock;
        $articulo->existencia = $request->stock;
        $articulo->total = $request->stock*$request->precio_proveedor;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
        
        //Registrar en Tabla Entrada
        $this->__historial($articulo->nombre, $articulo->stock,$articulo->precio_proveedor,$articulo->inventariable);
      
        //Registrar en Inventario Entrada + Salida
        //$this->__registro($articulo->nombre,$articulo->inventariable,$articulo->stock, $articulo->existencia,  $articulo->precio_proveedor, $articulo->precio_proveedor1, $articulo->total);
       

       
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->inventariable = $request->inventariable;
        $articulo->precio_proveedor = $request->precio_proveedor;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->iva = $request->iva;
        $articulo->ieps = $request->ieps;
        $articulo->minimo = $request->minimo;
        $articulo->stock1 = $request->stock1;
        $articulo->salida1 = $request->stock1 * $request->precio_proveedor ;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
        
       
    }

    public function agregar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->inventariable = $request->inventariable;
        $articulo->precio_proveedor = $request->precio_proveedor;
        $articulo->precio_proveedor1 = (($request->stock*$request->precio_proveedor1)+($request->stock1 * $request->precio_proveedor)) / ($request->stock+$request->stock1); 
        $articulo->precio_venta = $request->precio_venta;
        $articulo->iva = $request->iva;
        $articulo->ieps = $request->ieps;
        $articulo->stock = $request->stock+$request->stock1;
        $articulo->minimo = $request->minimo;
        $articulo->stock1 = $request->stock1;
        $articulo->salida1 = $request->stock1 * $request->precio_proveedor ;
        $articulo->descripcion = $request->descripcion;
        $articulo->total = $request->stock*$request->precio_proveedor1+($request->stock1 * $request->precio_proveedor);
        $articulo->condicion = '1';
        $articulo->save();

        //REgistrar Tabla Entradas - Articulo Agregados
        $this->__agregados($articulo->nombre,$articulo->stock1,$articulo->precio_proveedor);

         //Registro Inventaros Salida + Entrada
        $this->__registro1($articulo->nombre,$articulo->stock,$articulo->stock1, $articulo->precio_proveedor,$articulo->precio_proveedor1,$articulo->inventariable,$articulo->total);
    }

    public function restar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->inventariable = $request->inventariable;
        $articulo->precio_proveedor = $request->precio_proveedor;
        $articulo->precio_proveedor1 = (($request->stock*$request->precio_proveedor1)+($request->stock1 * $request->precio_proveedor)) / ($request->stock+$request->stock1); 
        $articulo->precio_venta = $request->precio_venta;
        $articulo->iva = $request->iva;
        $articulo->ieps = $request->ieps;
        $articulo->stock = $request->stock-$request->stock2;
        $articulo->minimo = $request->minimo;
        $articulo->stock1 = $request->stock1;
        $articulo->stock2 = $request->stock2;
        $articulo->salida1 = $request->stock1 * $request->precio_proveedor ;
        $articulo->descripcion = $request->descripcion;
        $articulo->total = $request->stock*$request->precio_proveedor1+($request->stock1 * $request->precio_proveedor);
        $articulo->condicion = '1';
        $articulo->save();


        //Funcion Restar Administrador -- Tabla Salidas 
        $this->__historial6($request->id,$articulo->nombre,$articulo->inventariable,$articulo->precio_venta,$articulo->stock2);


    }

    public function eliminar($id)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::find($id);
        $articulo->delete();

       
    }

    private function __historial($nombre = '', $stock = '', $precio_proveedor = '', $inventariable = '' )
    {
        $mytime= Carbon::now('America/Lima');
       
        $historial = new Historial();
        $historial->nombre = $nombre;
        $historial->stock = $stock ;
        $historial->precio_proveedor = $precio_proveedor ;
        $historial->importe = $stock*$precio_proveedor ;
        $historial->estado = 'Nuevo Ingreso' ;
        $historial->tipo = $inventariable;
        $historial->fecha_hora = $mytime->toDateString();
        $historial->save();
    }    

    //Actualizacion Tabla Entradas 
    private function __agregados($nombre = '', $stock1 = '', $precio_proveedor = '' )
    {
        $mytime= Carbon::now('America/Lima');
        $agregados = new Historial4();
        $agregados->nombre = $nombre;
        $agregados->stock1 = $stock1 ;
        $agregados->precio_proveedor = $precio_proveedor ;
        $agregados->reingreso = $precio_proveedor*$stock1;
        $agregados->fecha_hora = $mytime->toDateString();
        $agregados->estado = 'Agregados' ;
        $agregados->save();
    }    

    private function __registro1($nombre = '', $stock = '', $stock1 = '', $precio_proveedor = '', $precio_proveedor1 = '', $inventariable = '', $total = '' )
    {
        $mytime= Carbon::now('America/Lima');
        $registro1 = new Registro();
        $registro1->nombre = $nombre;
        $registro1->stock = $stock1 ;
        $registro1->existencia = $stock ;
        $registro1->tipo = $inventariable ;
        $registro1->precio_proveedor = $precio_proveedor;
        $registro1->precio1 = $precio_proveedor1;
        $registro1->saldo1 = $stock1*$precio_proveedor;
        $registro1->total = $total;
        $registro1->fecha_hora = $mytime->toDateString();
        $registro1->estado = 'Agregados' ;
        $registro1->save();
    }    
    
    

    //Registro Tabla 3 Entradas + Salidas
   
    private function __registro($nombre = '', $stock = '',$inventariable = '', $existencia = '', $precio_proveedor = '', $precio_proveedor1 = '', $total = '')
    {
       
        $registro = new Registro();
        $registro->nombre = $nombre;
        $registro->stock = $stock ; //
        $registro->tipo = $inventariable; //
        $registro->existencia = $existencia ;
        $registro->total = $total ;
        $registro->precio_proveedor = $precio_proveedor ;
        $registro->promedio = $precio_proveedor1 ;
        $registro->precio1 = $precio_proveedor ;
        $registro->saldo1 = $stock * $precio_proveedor ;
        $registro->save();
    }   

    private function __historial3($nombre = '',$stock = '',$stock1 = '',$precio_proveedor = '',$precio_proveedor1 = '',$salida1 = '',$total = '')
    {
       
        $historial3 = new Historial3();
        $historial3->nombre = $nombre;
        $historial3->stock = $stock1;
        $historial3->existencia = $stock;
        $historial3->precio1 = $precio_proveedor;
        $historial3->promedio = $precio_proveedor1;
        $historial3->saldo1 = $salida1;
        $historial3->total = $total;
        $historial3->save();
    }   

    //Funcion Restar Administrador -- Tabla Salidas 
    private function __historial6($id = null,$nombre = '',$inventariable = '',$precio_venta = '',$stock2 = '')
    {
       
        $historial6 = new Historial2();
        $historial6->articulo = $nombre;
        $historial6->idarticulo = $id;
        $historial6->inventariable = $inventariable;
        $historial6->precio4 = $precio_venta;
        $historial6->cantidad = $stock2;
        $historial6->fecha_hora =  Carbon :: today();
        $historial6->estado = 'Restado by Admin';
        $historial6->save();
    }    

    

}
