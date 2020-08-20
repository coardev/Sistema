<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Detalle Salida de Productos
                    </div>
                    <div class="card-body">
                       <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="articulo">Nombre</option>
                                      <option value="created_at">Fecha</option>
                                      
                                      
                                     
                                    </select>
                                    <template v-if="criterio === 'articulo'">
                                    <input v-autofocus type="text" v-model="buscar" @keyup.enter="listarDetalle(1,buscar,criterio); salida3(); importe()" class="form-control" placeholder="Texto a buscar">
                                    </template>
                                    <template v-if="criterio === 'created_at'">
                                    <input type="date" v-model="buscar" class="form-control" placeholder="Texto a buscar">
                                    </template>
                                   
                                     

                                    <button type="submit" @click="listarDetalle(1,buscar,criterio); salida3(); importe()" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div align="right">
                                <button  style="font-size:18px" v-print="printObj">Imprimir Reporte <i class="fa fa-print"></i></button>
                                </div>

                         <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="table_trans" class="table table-bordered table-striped table-sm">
                            <caption><h2>Reporte Salida de Articulos Inventariables</h2></caption>
                            <caption> <h4>Piezas Vendidas</h4>
                              <h4 id="area_total"></h4>
                            </caption>
                            <caption> <h4>Importe Piezas</h4>
                              <h4 id="area_total1"></h4>
                            </caption>
                             <thead>
                                 
                              <tr>  
                                
                                    <th>Fecha de Venta</th>
                                    
                                    <th>Articulo</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Importe</th>
                                    <th>Estado</th>
                                   
                                    
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="historial2 in arrayDetalle" :key="historial2.id">
                                                                       
                                    <td v-text="historial2.created_at"></td>
                                   
                                    <td v-text="historial2.articulo"></td>
                                    <td v-text="historial2.cantidad"></td>
                                    <td v-text="historial2.precio4"></td>
                                    <template v-if="historial2.estado === 'Venta Devuelta'">
                                    <td v-text="historial2.precio4*historial2.cantidad"></td>
                                    </template>
                                    <template v-if="historial2.estado === 'Restado by Admin'">
                                    <td v-text="historial2.precio4*historial2.cantidad"></td>
                                    </template> 
                                    <template v-if="historial2.estado === 'Venta Interna'">
                                    <td v-text="historial2.precio4*historial2.cantidad"></td>
                                    </template>   
                                    <template v-if="historial2.estado === 'Venta Normal'">
                                    <td v-text="historial2.precio4*historial2.cantidad"></td>
                                    </template>
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
                                        <input   type="text" v-model="idarticulo" class="form-control" placeholder="Nombre de artículo">                                        
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
                                        <input   type="number" v-model="precio4" class="form-control" placeholder="Ingrese descripción">
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
                criterio : 'articulo',
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
            salida3: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(3)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total').innerText = total;

                    },
                     importe: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(4)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total1').innerText = total;

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
                                this.idarticulo=data['idarticulo'];
                                this.articulo=data['articulo'];
                                this.inventariable=data['inventariable'];
                                this.precio4=data['precio4'];
                                this.cantidad=data['cantidad'];
                                this.estado=data['estado'];

                                break;
                            }
                            
                           
                        }
                    }
                }
               },
            listarDetalle (page,buscar,criterio){
                let me=this;
                var url= this.ruta + '/salida3?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.historial2.data;
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

                axios.put(this.ruta + '/salida/actualizar',{
                    'idarticulo': this.idarticulo,
                    'articulo': this.articulo,
                    'estado': this.estado,
                    'precio4': this.precio,
                    'cantidad': this.cantidad,
                    'id': this.detalle_id
                    
                    
                }).then(function (response) {
                    swal("La venta del Articulo ha sido Cancelada", "Enter", "success"
                        )
                    me.cerrarModal();
                    me.listarDetalle(1,'','historial2');
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
