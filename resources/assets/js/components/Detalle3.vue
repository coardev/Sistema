<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                     <button type="button" class="btn btn-secondary">
                            <i class="fa fa-cog fa-spin"></i>&nbsp;Detalle Salida Inventario Interno
                        </button>
                        <button type="button" @click="tableToExcel('table_trans', 'name', 'Reporte.xls')" class="btn btn-info">
                            <i class="fa fa-file-excel-o"></i>&nbsp;Reporte Excel
                        </button>
                        <button type="button" v-print="printObj" class="btn btn-warning">Imprimir Reporte  <i class="fa fa-print"></i>
                        </button>
                    </div>
                    <div class="card-body">
                       <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                         <select class="form-control col-md-1" v-model="criterio2">
                                      <option value="articulo">Articulo</option>
                                      <option value="estado">Estado</option>
                                    </select>  
                                    <template v-if="criterio2 === 'articulo'">                                  
                                    <input type="text" v-model="buscar2" class="form-control;col-md-2" placeholder="Escribe el Articulo">
                                    </template>
                                    <template v-if="criterio2 === 'estado'">                                  
                                     <select class="form-control;col-md-2" v-model="buscar2">
                                            <option value="">Completo</option>
                                            <option value="Venta Interna">Ventas Internas</option>
                                            <option value="Venta Cancelada">Ventas Canceladas</option>
                                    </select>  
                                    </template>
                                    <select class="form-control col-md-2" v-model="criterio1">
                                      <option value="created_at">Fecha Inicial</option>
                                    </select>                                    
                                    <input type="date" v-model="buscar1" class="form-control;col-md-3" placeholder="Escribe el Articulo">
                                     <select class="form-control col-md-2" v-model="criterio">
                                      
                                      <option value="created_at">Fecha Final</option>
                                      
                                    </select>
                                    <input type="date" v-model="buscar"  class="form-control;col-md-2" placeholder="Escribe el Articulo a Buscar">
                                    <button type="submit" @click="listarDetalle(1,buscar2,criterio2,buscar1,criterio1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                     </div>
                                      </div>
                                      </div>
                               
                          
                         <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="table_trans" class="table table-bordered table-striped table-sm">
                            <caption><h2>Reporte Salida - Inventario Interno</h2></caption>
                            <thead>
                                 <tr>  
                                   <th></th>
                                    <th></th>
                                    <th># {{ calcularCantidad }}</th>
                                    <th>$ {{ calcularImporte }}</th>
                                    <th></th>
                              </tr> 
                              <tr>  
                                
                                    <th>Fecha de Venta</th>
                                    
                                    <th>Articulo</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                   
                                    
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="historial2 in arrayDetalle" :key="historial2.id">
                                    
                                   
                                    <td v-text="historial2.created_at"></td>
                                   
                                    <td v-text="historial2.articulo"></td>
                                    <td v-text="historial2.cantidad"></td>
                                    <td v-text="historial2.precio4"></td>
                                    <td style="color: red" v-text="historial2.estado"></td>
                                   
                                   
                                </tr>                                
                            </tbody>
                        </table>
                        
                    </div>
               </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
             <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                               
                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sku Articulo:</label>
                                    <div class="col-md-3">
                                        <input   type="text" v-model="estado" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sku Articulo:</label>
                                    <div class="col-md-3">
                                        <input   type="text" v-model="articulo" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sku Articulo:</label>
                                    <div class="col-md-3">
                                        <input   type="text" v-model="cantidad" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sku Articulo:</label>
                                    <div class="col-md-3">
                                        <input   type="text" v-model="idarticulo" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>


                                
                                

                                

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                           
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Cancelar Venta</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </main>
</template>

<script>
import Print from 'vue-print-nb'
 
Vue.use(Print);
    export default {
        props : ['ruta'],
        data (){
            return {
                printObj: {
              id: "table_trans",
              popTitle: 'Reporte Detalle Salida Interna',
              extraCss: 'https://www.google.com,https://www.google.com',
              extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>'
            },
             isHidden: false,
                idarticulo: 0,
                detalle_id: 0,
                idventa: 0,
                estado : '',
                precio4 : 0,
                total : 0,
                stock2 : 0,
                precio_proveedor : 0,
                cantidad : 0,
                articulo : '',
                arrayDetalle : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio2 : 'articulo',
                buscar2 : '',
                criterio1 : 'created_at',
                buscar1 : '',
                criterio : 'created_at',
                buscar : '',
            }
        },
        computed:{
            calcularCantidad: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayDetalle.length;i++){
                 resultado1=resultado1+(this.arrayDetalle[i].cantidad*1)
                }
                return resultado1;
            },
            calcularImporte: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayDetalle.length;i++){
                 resultado1=resultado1+(this.arrayDetalle[i].precio4*1)
                }
                return resultado1;
            },
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
               abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "historial2":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                
                                this.modal=1;
                                this.tituloModal='Cancelar Venta Interna';
                                this.tipoAccion=2;
                                this.detalle_id=data['id'];
                                this.estado=data['estado'];
                                this.cantidad=data['cantidad'];
                                this.articulo=data['articulo'];
                               this.idarticulo=data['idarticulo'];
                                

                                break;
                            }
                            
                           
                        }
                        this.actualizarArticulo();
                        this.cerrarModal();
                    }
                }
               },
            listarDetalle (page,buscar2,criterio2,buscar1,criterio1,buscar,criterio){
                let me=this;
                var url= this.ruta + '/salida2?page=' + page + '&buscar2='+ buscar2 + '&criterio2='+ criterio2 + '&buscar1='+ buscar1 + '&criterio1='+ criterio1 + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.historial2.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar2,criterio2,buscar1,criterio1,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarDetalle(page,buscar2,criterio2,buscar1,criterio1,buscar,criterio);
            },
             cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idarticulo= 0;
                this.idventa= 0;
                this.articulo = '';
                this.estado = '';
                this.precio = 0;    
                this.precio1 = 0;    
                this.total = 0; 
                this.stock2 = 0; 
                this.precio_proveedor = 0;               
                this.cantidad= 0;
     
            },
            actualizarArticulo(){
              
                let me = this;

                axios.put(this.ruta + '/salida2/actualizar',{
                    
                    'estado': this.estado,
                    'id': this.detalle_id,
                    'idarticulo': this.idarticulo,
                    'cantidad': this.cantidad,
                    'articulo': this.articulo
                    
                    
                }).then(function (response) {
                    swal("El Articulo ha sido devuelto", "Enter", "success"
                        )
                    me.cerrarModal();
                    me.listarDetalle(1,'','historial2');
                }).catch(function (error) {
                    console.log(error);
                }); 
            }
        },
        mounted() {
            this.listarDetalle(1,this.buscar2,this.criterio2,this.buscar1,this.criterio1,this.buscar,this.criterio);
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
</style>
