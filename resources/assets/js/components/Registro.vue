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
                            <i class="fa fa-cog fa-spin"></i>&nbsp;Registro Completo de Articulos
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
                                    <button type="submit" @click="listarHistorial2(1,buscar2,criterio2,buscar1,criterio1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                               </tr>
                                <tr>
                                    <th>Fecha Entrada/Salida</th>
                                    <th>Nombre</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Existencia</th>
                                    <th>$ Unitario</th>
                                    <th>$ Promedio</th>
                                    <th>$ Entrada</th>
                                    <th>$ Salida</th>
                                    <th>$ Reingreso</th>
                                    <th>$ Total</th>
                                    <th>Estado</th>
                               
                                    
                                    
                                    
                                   
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
                                    <td  v-text="registro.estado"></td>
                                  

                                   

                                    
                                   
                                    
                                </tr>                                
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            
        </main>
</template>

<script>
    export default {
        props : ['ruta'],
        data (){
            return {
                printObj: {
              id: "table_trans",
              popTitle: 'Reporte Articulos',
              extraCss: 'https://www.google.com,https://www.google.com',
              extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>'
            },
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
                criterio2 : 'nombre',
                criterio1 : 'created_at',
                criterio : 'created_at',
                buscar2 : '',
                buscar1 : '',
                buscar : '',
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
            listarHistorial2 (page,buscar2,criterio2,buscar1,criterio1,buscar,criterio){
                let me=this;
                var url= this.ruta + '/registro?page=' + page + '&buscar2='+ buscar2 + '&criterio2='+ criterio2 + '&buscar1='+ buscar1 + '&criterio1='+ criterio1 + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRegistro = respuesta.registro.data;
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
                me.listarHistorial2(page,buscar2,criterio2,buscar1,criterio1,buscar,criterio);
            }
        },
        mounted() {
            this.listarHistorial2(1,this.buscar2,this.criterio2,this.buscar1,this.criterio1,this.buscar,this.criterio);
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
