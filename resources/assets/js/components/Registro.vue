<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Detalle Inventario Salidas + Entrada
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="created_at">Fecha</option>
                                    </select>
                                    <template v-if="criterio === 'nombre'">
                                    <input type="text" v-model="buscar"  class="form-control" placeholder="Escribe el Articulo a Buscar">
                                    </template>
                                    <template v-if="criterio === 'created_at'">
                                    <input type="date" v-model="buscar"  class="form-control" placeholder="Elige la Fecha">
                                    </template>
                                   
                                    <button type="submit" @click="listarHistorial2(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                                              </div>
                            </div>
                        </div>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="table_trans"   class="table table-bordered table-striped table-sm">
                            <thead>
                               <tr>
                              <th></th>
                              <th></th>
                              <th id="area_total"></th>
                              <th id="area_total1"></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th id="area_total2"></th>
                              <th id="area_total3"></th>
                              <th></th>
                               </tr>
                                <tr>
                                    <th><i class='fas fa-file-alt' style='font-size:18px'>&nbsp; Fecha Entrada/Salida</i></th>
                                    <th><i class='fas fa-file-alt' style='font-size:18px'>&nbsp; Nombre</i></th>
                                    <th><i class='fas fa-dolly-flatbed' style='font-size:18px'>&nbsp; Entrada</i></th>
                                    <th><i class='fas fa-dolly-flatbed' style='font-size:18px'>&nbsp; Salida</i></th>
                                    <th><i class='fas fa-dolly-flatbed' style='font-size:18px'>&nbsp; Existencia</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; $ Unitario</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; $ Promedio</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; $ Entrada</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; $ Salida</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; $ Reingreso</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; $ Total</i></th>
                              
                               
                                    
                                    
                                    
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="text-align:center" v-for="registro in arrayRegistro" :key="registro.id">
                                    
                                    <td v-text="registro.created_at"></td>
                                    <td v-text="registro.nombre"></td>
                                    <td style="background-color:#ffd480" v-text="registro.stock"></td>
                                    <td style="background-color:#b3ccff" v-text="registro.cantidad"></td>
                                    <td v-text="registro.existencia"></td>
                                    <td style="background-color:#ffd480" v-text="registro.precio_proveedor"></td>
                                    <td style="background-color:#ff9980" v-text="registro.precio1"></td>
                                    <td style="background-color:#ffd480" v-text="registro.saldo1"></td>
                                    <td style="background-color:#b3ccff" v-text="registro.saldo"></td>
                                    <td style="background-color:#b3ffb6" v-text="registro.reingreso"></td>
                                    <td  v-text="registro.total"></td>
                                  

                                   

                                    
                                   
                                    
                                </tr>                                
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            </div>
        </main>
</template>

<script>
    export default {
        props : ['ruta'],
        data (){
            return {
                registro_id: 0,
                nombre : '',
                stock: '',
                stock1: '',
                precio_proveedor: '',
                arrayRegistro : [],
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
                criterio : 'nombre',
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
              entrada: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(3)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total').innerText = total;

                    },
            salida: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(4)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total1').innerText = total;

                    },

        entrada2: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(8)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total2').innerText = total;

                    },

                     salida1: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(9)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total3').innerText = total;

                    },
             sum1: function () {
      var table =document.getElementById("table"), sumVal = 0;
      for(var i = 1; i < table.rows.length; i++)
      {
          sumVal = sumVal + parseInt(table.rows[i].cells[4].innerHTML);
             }
             document.getElementById("val2").innerHTML = sumVal;
    },
            listarHistorial2 (page,buscar,criterio){
                let me=this;
                var url= this.ruta + '/registro?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRegistro = respuesta.registro.data;
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
                me.listarHistorial2(page,buscar,criterio);
            }
        },
        mounted() {
            this.listarHistorial2(1,this.buscar,this.criterio);
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
