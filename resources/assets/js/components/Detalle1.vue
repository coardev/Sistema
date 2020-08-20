<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Cancelacion Venta
                    </div>
                    <div class="card-body">
                       <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-6" v-model="criterio">
                                      <option value="idventa">Folio de Venta</option>
                                      <option value="created_at">Fecha de Venta</option>
                                      
                                     
                                    </select>
                                    <template v-if="criterio === 'idventa'">
                                    <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">
                                    </template>
                                    <template v-if="criterio === 'created_at'">
                                    <input type="date" v-model="buscar"  class="form-control" placeholder="Texto a buscar">
                                    </template>
                                    <button type="submit" @click="listarDetalle(1,buscar,criterio);salida3(); importe()" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    
                                </div>
                               
                            </div>
                             <button type="button" @click="tableToExcel('table_trans', 'name', 'Reporte-Cancelaciones.xls')" class="btn btn-info">
                                    <i class="fa fa-file-excel-o"></i>&nbsp;Reporte Excel
                                    </button>
                        </div>
                       
                         <button v-on:click="isHidden = !isHidden">Mostrar</button>
                         <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="table_trans" class="table table-bordered table-striped table-sm">
                            <caption><h2>Cancelacion de Ventas</h2></caption>
                           
                             <thead>
                                 
                              <tr>  <th v-if="!isHidden">Cancelar Articulo</th>
                                    <th>Fecha de Venta</th>
                                    <th>Ticket de Venta</th>
                                    <th>Articulo</th>
                                    <th>Salida</th>
                                    <th>Precio Venta</th>
                                    <th>Importe</th>
                                    <th>Estado de Venta</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                    
                                    <td v-if="!isHidden" align="center">
                                        <template v-if="detalle.estado === 'Venta Concretada'">
                                        <button type="button" @click="abrirModal('detalle','actualizar',detalle)" class="btn btn-danger btn-sm">
                                          Cancelar Venta de Articulo
                                        </button>          
                                         </template>  
                                         <template v-if="detalle.estado === 'Venta Cobrada'">
                                        <button type="button" @click="abrirModal('detalle','actualizar',detalle)" class="btn btn-danger btn-sm">
                                          Cancelar Venta de Articulo
                                        </button>          
                                         </template>      
                                         <template v-if="detalle.estado === 'Venta Cancelada'">
                                        <button type="button"  class="btn btn-primary btn-sm">
                                          Venta ya Cancelada
                                        </button>          
                                         </template>                    
                                    </td>
                                    <td v-text="detalle.created_at"></td>
                                    <td v-text="detalle.idventa"></td>
                                    <td v-text="detalle.articulo"></td>
                                    <template v-if="detalle.inventariable === 1">
                                    <td v-text="detalle.cantidad"></td>
                                    </template>
                                    <template v-if="detalle.inventariable === 2">
                                    <td v-if="detalle.cantidad1>0" v-text="detalle.cantidad1">
                                    </td>
                                    <td v-else="detalle.kilogramos>0" v-text="detalle.kilogramos">
                                     </td>
                                    </template>
                                    <template v-if="detalle.inventariable === 3">
                                    <td v-text="detalle.cantidad2"></td>
                                    </template>
                                    <template v-if="detalle.inventariable === 1">
                                    <td v-text="detalle.precio4"></td>
                                    </template>
                                    <template v-if="detalle.inventariable === 2">
                                    <td v-if="detalle.precio5>0" v-text="detalle.precio5">
                                    </td>
                                    <td v-else="detalle.precio6>0" v-text="detalle.precio6">
                                    </td>
                                    </template>
                                    <template v-if="detalle.inventariable === 3">
                                    <td v-text="detalle.precio3"></td>
                                    </template>
                                    <template v-if="detalle.inventariable === 1">
                                    <td v-text="detalle.cantidad*detalle.precio4"></td>
                                    </template>
                                    <template v-if="detalle.inventariable === 2">
                                    <td v-if="detalle.precio5>0" v-text="detalle.precio5">
                                    </td>
                                    <td v-else="detalle.precio6>0" v-text="detalle.precio6">
                                    </td>
                                    </template>
                                     <template v-if="detalle.inventariable === 3">
                                    <td v-text="detalle.cantidad2*detalle.precio3"></td>
                                    </template>
                                    <td v-text="detalle.estado"></td>
                                   
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
                                        <input   type="text" v-model="idarticulo" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>

                            

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Se vendio en el Ticket:</label>
                                    <div class="col-md-3">
                                        <input   type="text" v-model="idventa" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Articulo:</label>
                                    <div class="col-md-3">
                                        <input   type="text" v-model="articulo" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>
                                
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Precio:</label>
                                    <div class="col-md-3">
                                        <input   type="number" v-model="precio" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Cantidad Vendida:</label>
                                    <div class="col-md-3">
                                        <input   type="number" v-model="cantidad" class="form-control" placeholder="Ingrese descripción">
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
              popTitle: '',
              extraCss: 'https://www.google.com,https://www.google.com',
              extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>'
            },
            isHidden: false,
                idarticulo: 0,
                detalle_id: 0,
                idventa: 0,
                estado : '',
                precio : 0,
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
                criterio : 'created_at',
                buscar : ''
            }
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
            salida3: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(5)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total').innerText = total;

                    },
                     importe: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(7)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total1').innerText = total;

                    },

                    abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "detalle":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                
                                this.modal=1;
                                this.tituloModal='Cancelar Venta de Articulo';
                                this.tipoAccion=2;
                                this.idarticulo=data['idarticulo'];
                                this.idventa=data['idventa'];
                                this.articulo = data['articulo'];
                                this.precio=data['precio'];
                                this.precio1=data['precio1'];
                                this.precio_proveedor=data['precio_proveedor'];
                                this.cantidad=data['cantidad'];
                                this.total=data['total'];
                                this.stock2=data['stock2'];
                                this.detalle_id=data['id'];
                                this.estado=data['estado'];

                                break;
                            }
                            
                           
                        }
                        this.actualizarArticulo();
                        this.cerrarModal();
                    }
                }
               },
            listarDetalle (page,buscar,criterio){
                let me=this;
                var url= this.ruta + '/cancelacion?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalle.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarDetalle(page,buscar,criterio);
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

                axios.put(this.ruta + '/detalle/actualizar',{
                    'idarticulo': this.idarticulo,
                    'idventa': this.idventa,
                    'articulo': this.articulo,
                    'estado': this.estado,
                    'precio': this.precio,
                    'precio1': this.precio1,
                    'total': this.total,
                    'stock2': this.stock2,
                    'precio_proveedor': this.precio_proveedor,
                    'cantidad': this.cantidad,
                    'id': this.detalle_id
                    
                    
                }).then(function (response) {
                    swal({
     title: "Ventas",
     text: "La venta del Articulo ha sido Cancelada",
     type: "success",
     timer: 2000
     });
                   me.cerrarModal();
                   me.listarDetalle(1,me.buscar,me.criterio);
                    
                }).catch(function (error) {
                    console.log(error);
                }); 
            }
        },
        mounted() {
            this.listarDetalle(1,this.buscar,this.criterio);
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
