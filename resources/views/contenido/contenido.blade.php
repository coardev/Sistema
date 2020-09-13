    @extends('principal')
    @section('contenido')

    @if(Auth::check())
            @if (Auth::user()->idrol == 1)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>

            <template v-if="menu==1">            
                <categoria :ruta="ruta"></categoria>
            </template>

            <template v-if="menu==2">
                <articulo :ruta="ruta"></articulo>
            </template>

            <template v-if="menu==3">
                <ingreso :ruta="ruta"></ingreso>
            </template>

            <template v-if="menu==4">
                <proveedor :ruta="ruta"></proveedor>
            </template>

            <template v-if="menu==5">
                <venta :ruta="ruta"></venta>
            </template>

            <template v-if="menu==6">
                <cliente :ruta="ruta"></cliente>
            </template>

            <template v-if="menu==7">
                <user :ruta="ruta"></user>
            </template>

            <template v-if="menu==8">
                <rol :ruta="ruta"></rol>
            </template>

            <template v-if="menu==9">
                <consultaingreso :ruta="ruta"></consultaingreso>
            </template>

            <template v-if="menu==10">
                <consultaventa :ruta="ruta"></consultaventa>
            </template>

            <template v-if="menu==11">
                <ayuda></ayuda>
            </template>

            <template v-if="menu==12">
                <acerca></acerca>
            </template>

            <template v-if="menu==13">
                <historial :ruta="ruta"></historial>
            </template>

            <template v-if="menu==14">
                <detalle :ruta="ruta"></detalle>
            </template>

            <template v-if="menu==15">
                <articulo1 :ruta="ruta"></articulo1>
            </template>

            <template v-if="menu==16">
                <registro :ruta="ruta"></registro>
            </template>

            <template v-if="menu==17">
                <venta1  :ruta="ruta"></venta1>
            </template>

            <template v-if="menu==18">
                <venta2  :ruta="ruta"></venta2>
            </template>

            
            <template v-if="menu==19">
                <detalle1  :ruta="ruta"></detalle1>
            </template>

            <template v-if="menu==20">
                <detalle2  :ruta="ruta"></detalle2>
            </template>

            <template v-if="menu==21">
                <venta3  :ruta="ruta"></venta3>
            </template>

            
            <template v-if="menu==22">
                <venta4  :ruta="ruta"></venta4>
            </template>

            <template v-if="menu==23">
                <interna  :ruta="ruta"></interna>
            </template>

            <template v-if="menu==24">
                <detalle3  :ruta="ruta"></detalle3>
            </template>



            
            @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>
            <template v-if="menu==5">
                <venta :ruta="ruta"></venta>
            </template>

            <template v-if="menu==6">
                <cliente :ruta="ruta"></cliente>
            </template>
            <template v-if="menu==10">
                <consultaventa :ruta="ruta"></consultaventa>
            </template>

            <template v-if="menu==11">
                <ayuda></ayuda>
            </template>

            <template v-if="menu==12">
                <acerca></acerca>
            </template>

            <template v-if="menu==14">
                <detalle :ruta="ruta"></detalle>
            </template>

            <template v-if="menu==15">
                <articulo1 :ruta="ruta"></articulo1>
            </template>


            <template v-if="menu==17">
                <venta1  :ruta="ruta"></venta1>
            </template>

            
            <template v-if="menu==18">
                <venta2  :ruta="ruta"></venta2>
            </template>

            
            <template v-if="menu==19">
                <detalle1  :ruta="ruta"></detalle1>
            </template>

            <template v-if="menu==20">
                <detalle2  :ruta="ruta"></detalle2>
            </template>

            <template v-if="menu==21">
                <venta3  :ruta="ruta"></venta3>
            </template>

            <template v-if="menu==22">
                <venta4  :ruta="ruta"></venta4>
            </template>

            
            <template v-if="menu==24">
                <detalle3  :ruta="ruta"></detalle3>
            </template>

            <template v-if="menu==23">
                <interna  :ruta="ruta"></interna>
            </template>

            @elseif (Auth::user()->idrol == 3)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>
            <template v-if="menu==1">
                <categoria :ruta="ruta"></categoria>
            </template>

            <template v-if="menu==2">
                <articulo :ruta="ruta"></articulo>
            </template>

            <template v-if="menu==3">
                <ingreso :ruta="ruta"></ingreso>
            </template>

            <template v-if="menu==4">
                <proveedor :ruta="ruta"></proveedor>
            </template>
            <template v-if="menu==9">
                <consultaingreso :ruta="ruta"></consultaingreso>
            </template>
            <template v-if="menu==11">
                <ayuda></ayuda>
            </template>

            <template v-if="menu==12">
                <acerca></acerca>
            </template>

            <template v-if="menu==14">
                <detalle :ruta="ruta"></detalle>
            </template>

            <template v-if="menu==15">
                <articulo1 :ruta="ruta"></articulo1>
            </template>


            <template v-if="menu==17">
                <venta1  :ruta="ruta"></venta1>
            </template>

            
            <template v-if="menu==19">
                <detalle1  :ruta="ruta"></detalle1>
            </template>

            <template v-if="menu==20">
                <detalle2  :ruta="ruta"></detalle2>
            </template>

            <template v-if="menu==21">
                <venta3  :ruta="ruta"></venta3>
            </template>

            <template v-if="menu==22">
                <venta4  :ruta="ruta"></venta4>
            </template>

            <template v-if="menu==23">
                <interna  :ruta="ruta"></interna>
            </template>

            
            <template v-if="menu==24">
                <detalle3  :ruta="ruta"></detalle3>
            </template>


            @elseif (Auth::user()->idrol == 4)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>
            <template v-if="menu==1">
                <categoria :ruta="ruta"></categoria>
            </template>

            <template v-if="menu==2">
                <articulo :ruta="ruta"></articulo>
            </template>

            <template v-if="menu==3">
                <ingreso :ruta="ruta"></ingreso>
            </template>

            <template v-if="menu==4">
                <proveedor :ruta="ruta"></proveedor>
            </template>
            <template v-if="menu==9">
                <consultaingreso :ruta="ruta"></consultaingreso>
            </template>
            <template v-if="menu==11">
                <ayuda></ayuda>
            </template>

            <template v-if="menu==12">
                <acerca></acerca>
            </template>

            <template v-if="menu==14">
                <detalle :ruta="ruta"></detalle>
            </template>

            <template v-if="menu==15">
                <articulo1 :ruta="ruta"></articulo1>
            </template>


            <template v-if="menu==17">
                <venta1  :ruta="ruta"></venta1>
            </template>

            <template v-if="menu==18">
                <venta2  :ruta="ruta"></venta2>
            </template>

            
            <template v-if="menu==19">
                <detalle1  :ruta="ruta"></detalle1>
            </template>

            <template v-if="menu==20">
                <detalle2  :ruta="ruta"></detalle2>
            </template>

            <template v-if="menu==21">
                <venta3  :ruta="ruta"></venta3>
            </template>

            <template v-if="menu==22">
                <venta4  :ruta="ruta"></venta4>
            </template>

            <template v-if="menu==23">
                <interna  :ruta="ruta"></interna>
            </template>

            
            <template v-if="menu==24">
                <detalle3  :ruta="ruta"></detalle3>
            </template>
            @else

            @endif

    @endif
       
        
    @endsection