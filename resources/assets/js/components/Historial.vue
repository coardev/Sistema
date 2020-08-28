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
                            <i class="fa fa-cog fa-spin"></i>&nbsp;Detalle Entrada de Articulos
                        </button>
                        <button type="button" @click="tableToExcel('table_trans', 'name', 'Reporte.xls')" class="btn btn-info">
                            <i class="fa fa-file-excel-o"></i>&nbsp;Obtener Reporte Excel
                        </button>
                        <button type="button" v-print="printObj" class="btn btn-warning">Imprimir Reporte  <i class="fa fa-print"></i>
                        </button>
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12" >
                                <div class="input-group">
                                <select class="form-control col-md-1" v-model="criterio2">
                                      <option value="nombre">Articulo</option>
                                    </select>                                    
                                    <input type="text" v-model="buscar2" class="form-control;col-md-2" placeholder="Escribe el Articulo">
                                    <select class="form-control col-md-2" v-model="criterio1">
                                      <option value="created_at">Fecha Inicial</option>
                                    </select>                                    
                                    <input type="date" v-model="buscar1" class="form-control;col-md-3" placeholder="Escribe el Articulo">
                                     <select class="form-control col-md-2" v-model="criterio">
                                      
                                      <option value="created_at">Fecha Final</option>
                                      
                                    </select>
                                    <input type="date" v-model="buscar"  class="form-control;col-md-2" placeholder="Escribe el Articulo a Buscar">
                                    <button type="submit" @click="listarHistorial(1,buscar2,criterio2,buscar1,criterio1,buscar,criterio);importe()" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                     </div>
                                      </div>
                                      </div>
                               </div>
                                     
                                    
                                   
                                    
                                 

                           
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="table_trans"  class="table table-bordered table-striped table-sm">
                                                      
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th> # {{ calcularEntrada }}</th>
                                    <th> # {{ calcularReingreso }}</th>
                                    <th></th>
                                    <th> $ {{ calcularImporte }}</th>
                                    <th></th>
                                  
                                </tr>
                                <tr>
                                    <th>Fecha de Registro</i></th>
                                    <th>Nombre</i></th>
                                    <th>Entrada</i></th>
                                    <th>Reingreso</i></th>
                                    <th>Precio Proveedor</i></th>
                                    <th>Importe Entrada</i></th>
                                    <th>Estatus</i></th>
                                  
                                  
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="historial in arrayHistorial" :key="historial.id">
                                    
                                    <td v-text="historial.created_at"></td>
                                    <td  v-text="historial.nombre"></td>
                                    <td  v-text="historial.stock"></td>
                                    <td  v-text="historial.stock1"></td>
                                    <td  v-text="historial.precio_proveedor"></td>
                                    <td  v-text="historial.importe"></td>
                                    <td style="color: red;font-size:18px"  v-text="historial.estado"></td>
                                    
                                   
                                    
                                </tr>            
                               

                            </tbody>
                        </table>
                        </div>
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
           
        </main>
</template>

<script>
import Print from 'vue-print-nb'
 
Vue.use(Print);
import Datepicker from 'vuejs-datepicker';
    export default {
        components: {
        Datepicker
    },
        props : ['ruta'],
        data (){
            return {
                printObj: {
              id: "table_trans",
              popTitle: 'Reporte de Entradas - Periodo',
              extraCss: 'https://www.google.com,https://www.google.com',
              extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>'
            },
                historial_id: 0,
                nombre : '',
                stock: '',
                stock1: '',
                precio_proveedor: '',
                arrayHistorial : [],
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
                criterio2 : 'nombre',
                criterio1 : 'created_at',
                criterio : 'created_at',
              
                buscar2 : '',
                buscar1 : '',
                buscar : '',
                
            }
        },
        computed:{
            calcularImporte: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayHistorial.length;i++){
                 resultado1=resultado1+(this.arrayHistorial[i].importe*1)
                }
                return resultado1;
            },
            calcularEntrada: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayHistorial.length;i++){
                 resultado1=resultado1+(this.arrayHistorial[i].stock*1)
                }
                return resultado1;
            },
            calcularReingreso: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayHistorial.length;i++){
                 resultado1=resultado1+(this.arrayHistorial[i].stock1*1)
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
            listarHistorial (page,buscar2,criterio2,buscar1,criterio1,buscar,criterio){
                let me=this;
                var url= this.ruta + '/historial?page=' + page + '&buscar2='+ buscar2 + '&criterio2='+ criterio2 + '&buscar1='+ buscar1 + '&criterio1='+ criterio1 + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayHistorial = respuesta.historial.data;
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
                me.listarHistorial(page,buscar2,criterio2,buscar1,criterio1,buscar,criterio);
            }
        },
        mounted() {
            this.listarHistorial(1,this.buscar2,this.criterio2,this.buscar1,this.criterio1,this.buscar,this.criterio);
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
