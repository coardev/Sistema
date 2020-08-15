<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Ventas #3
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="fa fa-cog fa-spin"></i>&nbsp;Tickets
                        </button>
                        <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Realizar Venta</button>

                       
                        
                        
                        
                              
                              
                    </div>
                    <!-- Listado-->
                     <template v-if="listado==1">
                    <div class="card-body">
                        <div style="height: 80px" class="form-group row border">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Cliente(*)</label>
                                    <v-select
                                  
                                        :on-search="selectCliente"
                                        label="nombre"
                                        :options="arrayCliente"
                                        placeholder="Buscar Clientes..."
                                        :onChange="getDatosCliente"                                        
                                    >

                                    </v-select>
                                </div>
                                
                                    
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tipo Comprobante(*)</label>
                                    <input type="text" v-model="tipo_comprobante" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="">Criterio de Busqueda(*)</label>                               
                                <select class="form-control" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="inventariable">Tipo</option>
                                        <option value="codigo">Código</option>
                                        </select>
                                            </div>
                                
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                <label for="">Busqueda:</label>                               
                                <input type="text" v-autofocus v-model="buscarA" @keypress="listarArticulo(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                </div>
                                
                                </div>
                                   
                            <div class="col-md-12">
                                <div v-show="errorVenta" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjVenta" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div  class="form-group row border">
                            <div class="col-md-12">
                             <div style="height: 200px" class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th style="display: none">Tipo</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th style="display: none">Precio Proveedor</th>
                                            <th style="display: none">Precio Promedio</th>
                                            <th>Precio Venta</th>
                                            <th style="display: none">Stock</th>
                                            <th style="display: none">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td style="display: none" v-text="articulo.inventariable"></td>
                                            <td v-text="articulo.codigo"></td>
                                            <td v-text="articulo.nombre"></td>
                                            <td v-text="articulo.nombre_categoria"></td>
                                            <td style="display: none" v-text="articulo.precio_proveedor"></td>
                                            <td style="display: none" v-text="articulo.precio_proveedor1"></td>
                                            <td v-text="articulo.precio_venta"></td>
                                            <td style="display: none" v-text="articulo.stock"></td>
                                            <td style="display: none">
                                                <div v-if="articulo.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                            </div>
                          
                        </div>
                        
                                    
                                
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Tipo</th>
                                            <th>Stock</th>
                                            <th>Artículo</th>
                                            <th>Cetegoria</th>
                                            <th style="display: none">Precio!</th>
                                            <th>Precio Sugerido</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.inventariable">
                                            </td>
                                            <template v-if="detalle.inventariable === 1">
                                            <td v-text="detalle.stock">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td>
                                                N/A
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 3">
                                            <td>
                                                N/A
                                            </td>
                                            </template>
                                            <td v-text="detalle.articulo">
                                            </td>
                                             <td v-text="detalle.nombre_categoria">
                                            </td>
                                            <td style="display: none" v-text="detalle.precio1">
                                            </td>
                                            
                                             <td>
                                                <template v-if="detalle.inventariable === 1">
                                                <input input v-model="detalle.precio" type="number" readonly class="form-control">
                                                </template>
                                                <template v-if="detalle.inventariable === 2">
                                                <input input v-bind:value="detalle.precio" readonly class="form-control">
                                                </template>
                                                <template v-if="detalle.inventariable === 3">
                                                <input input v-bind:value="detalle.precio" readonly class="form-control">
                                                </template>
                                            </td>
                                            
                                            
                                            <td>
                                            <template v-if="detalle.inventariable === 1">
                                                <input type="number" v-model="detalle.precio4" v-bind:min="detalle.precio/100*(80)" class="form-control">
                                                </template>
                                                <template v-if="detalle.inventariable === 2">
                                                <input type="number" id="txtb" v-model="detalle.precio5" @mouseover="isDisabled = !isDisabled" 
                                                 @mouseout="isDisabled = !isDisabled"   :disabled="isDisabled1"  class="form-control">
                                                </template>
                                                <template v-if="detalle.inventariable === 3">
                                                <input type="number" v-model="detalle.precio3" v-bind:min="detalle.precio/100*(80)"  class="form-control">
                                                </template>
                                                
                                            </td>
                                            
                                            
                                            <td>
                                                <template v-if="detalle.inventariable === 1">
                                                <span style="color:red;" v-show="detalle.cantidad>detalle.stock">Stock: {{detalle.stock}}</span>
                                                <input input  v-model="detalle.cantidad" type="number" v-bind:max="detalle.stock" class="form-control">
                                                </template>
                                                <template v-if="detalle.inventariable === 2">
                                                <input id="txtc" v-model="detalle.cantidad1" type="number" @mouseover="isDisabled1 = !isDisabled1" 
                                                 @mouseout="isDisabled1 = !isDisabled1"
                                                 :disabled="isDisabled" v-bind:max="detalle.stock" class="form-control">
                                                </template>
                                                <template v-if="detalle.inventariable === 3">
                                                <input input  v-model="detalle.cantidad2" type="number" v-bind:max="detalle.stock" class="form-control">
                                                </template>
                                                

                                            </td>
                                                                                       
                                            
                                            <td>
                                                <template v-if="detalle.inventariable === 1">
                                                <input v-bind:value="detalle.precio4*detalle.cantidad" disabled>
                                                </template>
                                                <template v-if="detalle.inventariable === 2">
                                                <input id="txta" @keyup.enter="cambio()" v-bind:value="detalle.precio5*detalle.cantidad1" >
                                                </template>
                                                <template v-if="detalle.inventariable === 3">
                                                <input   v-bind:value="detalle.precio3*detalle.cantidad2" disabled>
                                                </template>
                                            </td>
                                            
                                        </tr>
                                       
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="8" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total=calcularNoInventariable+calcularInventariable+calcularServicio}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="9">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div  class="form-group row">
                            <div class="col-md-12">
                                
                                <button type="button" class="btn btn-primary" @click="registrarVenta()">Registrar Venta</button>
                              
                                </div>
                        </div>
                    </div>
                    </template>
                    <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                    <option value="id">Numero de Compra</option>
                                     <option value="fecha_hora">Fecha-Hora</option>
                                    </select>
                                    <input type="text" v-autofocus  v-model="buscar" @keyup.enter="listarVenta(1,buscar,criterio)" class="form-control" placeholder="Buscar Compra">
                                    <button type="submit" @click="listarVenta(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table id="myTable" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                               
                                        <th>Opciones</th>
                                        <th>Num. de Venta</th>
                                        <th>Usuario</th>
                                        <th>Cliente</th>
                                        <th>Fecha Hora</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                       
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="venta in arrayVenta" :key="venta.id">
                                        <td>
                                           <button type="button" @click="verVenta(venta.id)" class="btn btn-success btn-lg">
                                            <i class="icon-eye"></i>
                                            </button>

                                            

                                            <template v-if="venta.tipo_comprobante=='TICKET'">
                                                <button type="button" @click="pdfTicket1(venta.id)" class="btn btn-secondary btn-lg">
                                               <i class='fas fa-cash-register'></i>
                                                </button> &nbsp;
                                            </template>

                                          
                                             
                                            
                                            
                                        </td>
                                        <td id="printableArea" v-text="venta.id"></td>
                                        <td v-text="venta.usuario"></td>
                                        <td v-text="venta.nombre"></td>
                                        <td v-text="venta.created_at"></td>
                                        <td input="number" v-text="venta.total"></td>
                                        <td v-text="venta.estado"></td>
                                        
                                        
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                   
                    <!-- Fin Detalle-->
                    <!-- Ver ingreso -->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <p v-text="cliente"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <p v-text="fecha_hora"></p>
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante</label>
                                    <p v-text="tipo_comprobante"></p>
                                </div>
                            </div>
                           
                            
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Artículo</th>
                                            
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                          
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.inventariable">
                                            </td>
                                            <td v-text="detalle.articulo">
                                            </td>
                                            <template v-if="detalle.inventariable === 1">
                                            <td v-text="detalle.precio">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td v-text="detalle.precio3">
                                            </td>
                                            </template>
                                           <template v-if="detalle.inventariable === 1">
                                            <td v-text="detalle.cantidad">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td v-text="detalle.granel">
                                            </td>
                                            </template>

                                            <template v-if="detalle.inventariable === 1">
                                            <td v-text="detalle.precio*detalle.cantidad">
                                            </td>
                                            </template>

                                            <template v-if="detalle.inventariable === 2">
                                            <td v-text="detalle.precio3*detalle.granel">
                                            </td>
                                            </template>
                                            
                                        </tr>
                                      
                                        
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                         </div>
                    </template>
                    <!-- fin ver ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
    
 
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-6" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="inventariable">Tipo</option>
                                        <option value="codigo">Código</option>
                                        </select>
                                        <input type="text"  v-model="buscarA" @keyup.enter="listarArticulo(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarArticulo(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar Articulo</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th style="display: none">Tipo</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th style="display: none">Precio Proveedor</th>
                                            <th style="display: none">Precio Promedio</th>
                                            <th>Precio Venta</th>
                                            <th style="display: none">Stock</th>
                                            <th style="display: none">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td style="display: none" v-text="articulo.inventariable"></td>
                                            <td v-text="articulo.codigo"></td>
                                            <td v-text="articulo.nombre"></td>
                                            <td v-text="articulo.nombre_categoria"></td>
                                            <td style="display: none" v-text="articulo.precio_proveedor"></td>
                                            <td style="display: none" v-text="articulo.precio_proveedor1"></td>
                                            <td v-text="articulo.precio_venta"></td>
                                            <td style="display: none" v-text="articulo.stock"></td>
                                            <td style="display: none">
                                                <div v-if="articulo.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    
    import vSelect from 'vue-select';
    import Vue from "vue";
    import autofocus from "vue-autofocus-directive";
    Vue.directive("autofocus", autofocus);
    export default {
        
        props : ['ruta'],
        data (){
            
            return {
                isDisabled: false,
                isDisabled1: false,
                randomNumber:'',
                venta_id: 0,
                idcliente:0,
                cliente:'',
                fecha_hora:'',
                tipo_comprobante : 'TICKET',
                total:0.0,
                arrayVenta : [],
                arrayCliente: [],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVenta : 0,
                errorMostrarMsjVenta : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'id',
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                inventariable: 0,
                precio: 0,
                precio1: 0,
                precio2: 0,
                precio3: 0,
                precio4: 0,
                precio5: 0,
                minimo: 0,
                nombre_categoria: '',
                cantidad:0,
                cantidad1:0,
                cantidad2:0,
                granel:0,
                descuento: 0,
                stock:0
            }
        },
        components: {
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            
            calcularInventariable: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayDetalle.length;i++){
                 resultado1=resultado1+(this.arrayDetalle[i].cantidad*this.arrayDetalle[i].precio4)
                }
                return resultado1;
            },
             calcularNoInventariable: function(){
               
                var resultado2=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                 resultado2=resultado2+(this.arrayDetalle[i].cantidad1*this.arrayDetalle[i].precio5)
                }
                return resultado2;
            },
            calcularServicio: function(){
               
                var resultado3=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                 resultado3=resultado3+(this.arrayDetalle[i].cantidad2*this.arrayDetalle[i].precio3)
                }
                return resultado3;
            },
            
            
           
        },
        methods : {
            nextItem () {
    	if (event.keyCode == 38 && this.currentItem > 1) {
      	this.currentItem--
      } else if (event.keyCode == 40 && this.currentItem < 3) {
      	this.currentItem++
      }
            },
          
            cambio: function (){
                var a=parseInt(document.getElementById("txta").value);
                var b=parseInt(document.getElementById("txtb").value);
                
                var c=a*1/b
                document.getElementById("txtc").value=""+c.toFixed(3);
            },
             filas: function() {
  var x = document.getElementById("myTable").rows.length-1;
  document.getElementById("demo").innerHTML = x;
            },
            sum: function () {
        let rows = document.querySelectorAll("table tr td:nth-child(6)");
        let sum = 0;
        for (let i = 0; i < rows.length-1; i++) {
            sum += Number(rows[i].textContent);
        }
 
        document.getElementById("sum").textContent = "$" + sum;
    
    },


             printer: function () {	
            window.print() 
    },
   
            exportTableToExcel : function(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
},




             myFunction5: function () {	
            document.getElementById("myText").value = "Johnny Bravo";
    },
   
                       printDiv: function (divName) {
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;

		},

          imprimir: function (divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    },


            listarVenta (page,buscar,criterio){
                let me=this;
                var url= this.ruta + '/venta?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVenta = respuesta.ventas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open(this.ruta + '/venta/listarPdf','_blank');
            },
            selectCliente(search,loading){
                let me=this;
                loading(true)

                var url= this.ruta + '/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayCliente=respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            getDatosCliente(val1){
                let me = this;
                me.loading = true;
                me.idcliente = val1.id;
            },
            buscarArticulo(){
                let me=this;
                var url= this.ruta + '/articulo/buscarArticuloVenta?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;

                    if (me.arrayArticulo.length>0){
                        me.articulo=me.arrayArticulo[0]['nombre'];
                        me.inventariable=me.arrayArticulo[0]['inventariable'];
                        me.idarticulo=me.arrayArticulo[0]['id'];
                        me.precio=me.arrayArticulo[0]['precio_venta'];
                        me.precio1=me.arrayArticulo[0]['precio_proveedor1'];
                        me.precio_proveedor=me.arrayArticulo[0]['precio_proveedor'];
                        me.precio2=me.arrayArticulo[0]['precio_proveedor'];
                        me.precio3=me.arrayArticulo[0]['precio_venta'];
                        me.precio4=me.arrayArticulo[0]['precio_venta'];
                        me.precio5=me.arrayArticulo[0]['precio_venta'];
                        me.stock=me.arrayArticulo[0]['stock'];
                        me.nombre_categoria=me.arrayArticulo[0]['nombre_categoria'];
                        me.minimo=me.arrayArticulo[0]['minimo'];
                    }
                    else{
                        me.articulo='No existe artículo';
                        me.idarticulo=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            pdfVenta(id){
                window.open(this.ruta + '/venta/pdf/'+ id + ',' + '_blank');
            },
            pdfTicket(id){
                window.open(this.ruta + '/venta/pdfTicket/'+ id + ',' + '_blank');
            },
            pdfTicket1(id){
                window.open(this.ruta + '/venta/pdfTicket1/'+ id + ',' + '_blank');
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarVenta(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idarticulo==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.idarticulo==0 || me.cantidad==0 || me.cantidad1==0 || me.cantidad2==0 || me.granel==0 || me.precio==0 || me.precio1==0 || me.precio2==0 || me.precio3==0 || me.precio4==0 || me.precio5==0 || me.inventariable==0 ){
                }
                else{
                    if(me.encuentra(me.idarticulo)){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       if(me.cantidad>me.stock){
                           swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'NO hay stock disponible!',
                            })
                       } 
                       else{
                           me.arrayDetalle.push({
                                idarticulo: me.idarticulo,
                                articulo: me.articulo,
                                cantidad: me.cantidad,
                                cantidad1: me.cantidad1,
                                cantidad2: me.cantidad2,
                                granel: me.granel,
                                inventariable: me.inventariable,
                                precio3: me.precio3,
                                precio4: me.precio4,
                                precio: me.precio5,
                                precio2: me.precio2,
                                precio1: me.precio1,
                                precio: me.precio,
                                stock: me.stock,
                                nombre_categoria: me.nombre_categoria,
                                minimo: me.minimo
                            });
                            me.codigo="";
                            me.idarticulo=0;
                            me.articulo="";
                            me.nombre_categoria="";
                            me.cantidad=0;
                            me.cantidad1=0;
                            me.cantidad2=0;
                            me.granel=0;
                            me.inventariable=0;
                            me.precio1=0;
                            me.precio2=0;
                            me.precio3=0;
                            me.precio4=0;
                            me.precio5=0;
                            me.precio=0;
                            me.stock=0;
                            me.minimo=0
                       }
                    }
                    
                }

                

            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idarticulo: data['id'],
                            articulo: data['nombre'],
                            cantidad: 0,
                            cantidad1: 0,
                            cantidad2: 0,
                            granel: 0,
                            precio: data['precio_venta'],
                            inventariable: data['inventariable'],
                            precio1: data['precio_proveedor1'],
                            precio2: data['precio_proveedor'],
                            precio3: data['precio_venta'],
                            precio4: data['precio_venta'],
                            precio5: data['precio_venta'],
                            precio_proveedor: data['precio_proveedor'],
                            descuento:0,
                            stock:data['stock'],
                            nombre_categoria:data['nombre_categoria'],
                            minimo:data['minimo']
                        }); 
                    }
            },
            listarArticulo (buscar,criterio){
                let me=this;
                var url= this.ruta + '/articulo/listarArticuloVenta?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarVenta(){
                if (this.validarVenta()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta + '/venta/registrar',{
                    'idcliente': this.idcliente,
                    'tipo_comprobante': this.tipo_comprobante,
                    'total' : this.total,
                    'data': this.arrayDetalle

                 

                }).then(function (response) {
                      swal({
     title: "Ventas",
     text: "Venta Registrada Correctamente",
     type: "success",
     timer: 2000
     });
            
                    me.listado=0;
                    me.listarVenta(1,'','id');
                    me.idcliente=0;
                    me.tipo_comprobante='TICKET';
                    me.total=0.0;
                    me.idarticulo=0;
                    me.articulo='';
                    me.cantidad=0;
                    me.cantidad1=0;
                    me.cantidad2=0;
                    me.granel=0;
                    me.precio=0;
                    me.precio1=0;
                    me.precio2=0;
                    me.precio3=0;
                    me.precio4=0;
                    me.precio5=0;
                    me.stock=0;
                    me.minimo=0;
                    me.inventariable=0;
                    me.codigo='';
                    me.nombre_categoria='';
                    me.arrayDetalle=[];

                    window.open(this.ruta + '/venta/pdf/'+ response.data.id + ',' + '_blank');

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarVenta(){
                let me=this;
                me.errorVenta=0;
                me.errorMostrarMsjVenta =[];
            

                if (me.idcliente==0) me.errorMostrarMsjVenta.push("Seleccione un Cliente");
                if (me.tipo_comprobante==0) me.errorMostrarMsjVenta.push("Seleccione el comprobante");
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjVenta.push("Ingrese detalles");

                if (me.errorMostrarMsjVenta.length) me.errorVenta = 1;

                return me.errorVenta;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idproveedor=0;
                me.tipo_comprobante='TICKET';
                me.total=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.cantidad1=0;
                me.cantidad2=0;
                me.granel=0;
                 me.inventariable=0;
                me.precio=0;
                me.precio1=0;
                me.precio2=0;
                me.precio3=0;
                me.precio4=0;
                me.precio5=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            ocultarDetalle1(){
                this.listado=0;
            },
            
            verVenta(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayVentaT=[];
                var url= this.ruta + '/venta1/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayVentaT = respuesta.venta;

                    me.cliente = arrayVentaT[0]['nombre'];
                    me.fecha_hora = arrayVentaT[0]['fecha_hora'];
                    me.tipo_comprobante=arrayVentaT[0]['tipo_comprobante'];
                    me.total=arrayVentaT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= this.ruta + '/venta1/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            abrirModal(){               
                this.arrayArticulo=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
                this.$nextTick(function () {
                this.$refs.input.focus()
          });
            },
            desactivarVenta(id){
               swal({
                title: 'Esta seguro de anular esta venta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put(this.ruta + '/venta/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarVenta(1,'','id');
                        swal(
                        'Anulado!',
                        'La venta ha sido anulada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
        },
       
        mounted() {
            this.listarVenta(1,this.buscar,this.criterio);
            this.listarArticulo(this.buscarA,this.criterioA);
            document.addEventListener("keydown", function(e){
   if(e.which == 37){
     alert("btn btn-danger btn-sm");
     // here you could write your logic
   }
   if(e.which == 39){
    alert("btn btn-danger btn-sm");
   }
});
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
