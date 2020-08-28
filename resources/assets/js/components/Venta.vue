<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Administrador Ventas
                       <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="fa fa-cog fa-spin"></i>&nbsp;Ventas
                        </button>
                        <button type="button" @click="tableToExcel('table_trans', 'name', 'Reporte.xls')" class="btn btn-info">
                            <i class="fa fa-file-excel-o"></i>&nbsp;Obtener Reporte Excel
                        </button>
                        <button type="button" v-print="printObj" class="btn btn-warning">Imprimir Reporte  <i class="fa fa-print"></i>
                        </button>
                       
                              
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select class="form-control col-md-6" v-model="criterio">
                                    <option value="fecha_hora">Fecha-Inicial</option>
                                    </select>
                                    <input type="date"  v-model="buscar" class="form-control" placeholder="Elige el Dia">
                                    <select class="form-control col-md-6" v-model="criterio1">
                                    <option value="fecha_hora">Fecha-Final</option>
                                    </select>
                                    <input type="date"  v-model="buscar1" class="form-control" placeholder="Elige el Dia">
                                    
                                    <button type="submit" @click="listarVenta(1,buscar,criterio,buscar1,criterio1)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger"  v-on:click="isHidden = !isHidden">Mostrar</button>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table id="table_trans" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                               
                                        <th v-if="!isHidden"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>$ {{ calcularVenta }}</th>
                                        <th>Ventas del Periodo: {{ arrayVenta.length }}</th>
                                       
                                        
                                    </tr>
                                    <tr>
                               
                                        <th v-if="!isHidden">Opciones</th>
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
                                        <td v-if="!isHidden">
                                           <button type="button" @click="verVenta(venta.id)" class="btn btn-success btn-lg">
                                            <i class="icon-eye"></i>
                                            </button>
                                            <!--
                                            <template v-if="venta.tipo_comprobante=='TICKET'">
                                                <button type="button" @click="pdfTicket(venta.id)" class="btn btn-warning btn-lg">
                                                <i class='fas fa-ticket-alt'></i>
                                                </button> &nbsp;
                                            </template>

                                            <template v-if="venta.tipo_comprobante=='TICKET'">
                                                <button type="button" @click="pdfTicket1(venta.id)" class="btn btn-secondary btn-lg">
                                               <i class='fas fa-cash-register'></i>
                                                </button> &nbsp;
                                            </template>

                                            <template v-if="venta.tipo_comprobante=='FACTURA'">
                                                <button type="button" @click="pdfTicket1(venta.id)" class="btn btn-warning btn-lg">
                                                <i class="icon-doc"></i>
                                                </button> &nbsp;
                                            </template>
                                            
                                            <template v-else>
                                                <button type="button" @click="pdfVenta(venta.id)" class="btn btn-danger btn-lg">
                                                <i class="fa fa-file-pdf-o"></i>
                                                </button> &nbsp;
                                            </template>
                                             -->
                                            
                                            
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
                     <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
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
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante(*)</label>
                                    <select class="form-control" v-model="tipo_comprobante">
                                          <option value="TICKET">Generar Documentos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div style="text-align:center;padding:1em 0;"> <h4><a style="text-decoration:none;"><span style="color:gray;">Hora actual en</span><br />Zumpango</a></h4> <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=small&timezone=America%2FMexico_City" width="100%" height="90" frameborder="0" seamless></iframe> </div>
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
                        <div class="form-group row border">
                            <div class="col-md-12">
                                <div align="center" class="form-group">
                                    <label>Artículo <span style="color:red;" v-show="idarticulo==0">(*Seleccione)</span></label>
                                    <div class="col-md-12" align="center">
                                        <button @click="abrirModal()" class="btn btn-primary">Buscar Articulo...</button>
                                        
                                    </div>                                    
                                </div>
                            </div>
                          
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Stock</th>
                                            <th>Artículo</th>
                                            <th>Precio!</th>
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
                                            <td v-text="detalle.stock">
                                            </td>
                                            <td v-text="detalle.articulo">
                                            </td>
                                            <td v-text="detalle.precio1">
                                            </td>
                                             <td>
                                                
                                                <input v-model="detalle.precio" type="number" v-bind:min="detalle.precio2" class="form-control">
                                            </td>
                                            <td>
                                                
                                                <input v-on:keypress.prevent v-model="detalle.cantidad" type="number" v-bind:max="detalle.stock-detalle.minimo" class="form-control">
                                            </td>
                                           
                                            <td>
                                                {{detalle.precio*detalle.cantidad-detalle.descuento}}
                                            </td>
                                        </tr>
                                       
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="6" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total=calcularTotal}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
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
                                    <p v-text="created_at"></p>
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
                                            <td v-text="detalle.precio4">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td v-text="detalle.precio5">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 3">
                                            <td v-text="detalle.precio3">
                                            </td>
                                            </template>
                                           <template v-if="detalle.inventariable === 1">
                                            <td v-text="detalle.cantidad">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td v-text="detalle.cantidad1">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 3">
                                            <td v-text="detalle.cantidad2">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 1">
                                            <td v-text="detalle.cantidad*detalle.precio4">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td v-text="detalle.cantidad1*detalle.precio5">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 3">
                                            <td v-text="detalle.cantidad2*detalle.precio3">
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
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        <option value="codigo">Código</option>
                                        </select>
                                        <input type="text" id="input" ref="input" v-model="buscarA" @keyup.enter="listarArticulo(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarArticulo(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar Articulo</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Precio Proveedor</th>
                                            <th>Precio Promedio</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="articulo.codigo"></td>
                                            <td v-text="articulo.nombre"></td>
                                            <td v-text="articulo.nombre_categoria"></td>
                                            <td v-text="articulo.precio_proveedor"></td>
                                            <td v-text="articulo.precio_proveedor1"></td>
                                            <td v-text="articulo.precio_venta"></td>
                                            <td v-text="articulo.stock"></td>
                                            <td>
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
    import Print from 'vue-print-nb'
    Vue.use(Print);
    export default {
        props : ['ruta'],
        data (){
            return {
                printObj: {
              id: "table_trans",
              popTitle: '',
              extraCss: 'https://www.google.com,https://www.google.com',
              extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>'
            },
            isHidden: true,
                randomNumber:'',
                venta_id: 0,
                idcliente:0,
                cliente:'',
                fecha_hora:'',
                tipo_comprobante : 'BOLETA',
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
                criterio : 'fecha_hora',
                buscar : '',
                criterio1 : 'fecha_hora',
                buscar1 : '',
                criterioA:'nombre',
                buscarA: '',
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 0,
                precio1: 0,
                precio2: 0,
                minimo: 0,
                cantidad:0,
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
            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                }
                return resultado;
            },

            calcularVenta: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayVenta.length;i++){
                    resultado=resultado+(this.arrayVenta[i].total*1)
                }
                return resultado;
            }
        },
        methods : {
                 tableToExcel:  function (table, name, filename) {
        let uri = 'data:application/vnd.ms-excel;base64,', 
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>', 
        base64 = function(s) { return window.btoa(decodeURIComponent(encodeURIComponent(s))) },         format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })}
        
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

        var link = document.createElement('a');
        link.download = filename;
        link.href = uri + base64(format(template, ctx));
        link.click();
            },
            salida: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(6)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total1').innerText = total;

                    },
             filas: function() {
  var x = document.getElementById("table_trans").rows.length-1;
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


            listarVenta (page,buscar,criterio,buscar1,criterio1){
                let me=this;
                var url= this.ruta + '/venta?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&buscar1='+ buscar1 + '&criterio1='+ criterio1;
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
                        me.idarticulo=me.arrayArticulo[0]['id'];
                        me.precio=me.arrayArticulo[0]['precio_venta'];
                        me.precio1=me.arrayArticulo[0]['precio_proveedor1'];
                        me.precio_proveedor=me.arrayArticulo[0]['precio_proveedor'];
                        me.precio2=me.arrayArticulo[0]['precio_proveedor'];
                        me.stock=me.arrayArticulo[0]['stock'];
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
            cambiarPagina(page,buscar,criterio,buscar1,criterio1){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarVenta(page,buscar,criterio,buscar1,criterio1);
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
                if(me.idarticulo==0 || me.cantidad==0 || me.precio==0 || me.precio1==0 || me.precio2==0){
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
                                precio2: me.precio2,
                                precio1: me.precio1,
                                precio: me.precio,
                                stock: me.stock,
                                minimo: me.minimo
                            });
                            me.codigo="";
                            me.idarticulo=0;
                            me.articulo="";
                            me.cantidad=0;
                            me.precio1=0;
                            me.precio2=0;
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
                            cantidad: 1,
                            precio: data['precio_venta'],
                            precio1: data['precio_proveedor1'],
                            precio2: data['precio_proveedor'],
                            precio_proveedor: data['precio_proveedor'],
                            descuento:0,
                            stock:data['stock'],
                            minimo:data['minimo']
                        }); 
                    }
            },
            listarArticulo (buscar,criterio,busca){
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
     timer: 3000
     });
            
                    me.listado=1;
                    me.listarVenta(1,'','id');
                    me.idcliente=0;
                    me.tipo_comprobante='BOLETA';
                    me.total=0.0;
                    me.idarticulo=0;
                    me.articulo='';
                    me.cantidad=0;
                    me.precio=0;
                    me.precio1=0;
                     me.precio2=0;
                    me.stock=0;
                    me.minimo=0;
                    me.codigo='';
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
                me.listado=1;

                me.idproveedor=0;
                me.tipo_comprobante='BOLETA';
                me.total=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.precio=0;
                me.precio1=0;
                me.precio2=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=0;
            },
            verVenta(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayVentaT=[];
                var url= this.ruta + '/venta/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayVentaT = respuesta.venta;

                    me.cliente = arrayVentaT[0]['nombre'];
                    me.created_at = arrayVentaT[0]['created_at'];
                    me.tipo_comprobante=arrayVentaT[0]['tipo_comprobante'];
                    me.total=arrayVentaT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= this.ruta + '/venta/obtenerDetalles?id=' + id;
                
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
        created: function(){
        
},
        mounted() {
            this.listarVenta(1,this.buscar,this.criterio,this.buscar1,this.criterio1);
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
