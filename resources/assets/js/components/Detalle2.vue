<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card" style="height: 50rem;">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Reporte Ventas del Dia
                    </div>
                   <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                            <div align="center" class="input-group">
                                    <select class="form-control col-md-6" v-model="criterio">
                                      <option value="created_at">Fecha del Dia</option>
                                      
                                     
                                    </select>
                                    <input type="date" v-model="buscar" class="form-control" placeholder="Elige el Dia...">
                                    <button type="submit" @click="listarDetalle(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                     &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<button  style="font-size:18px" v-print="printObj">Imprimir Reporte <i class="fa fa-print"></i></button>
                                </div>
                                </div>
                                </div>
                                                        
                         <div >
                        <table id="table_trans" class="table table-bordered table-striped table-sm">
                           
                            <thead> 
                            <tr>
                             <th colspan="4" style="text-align:center">Informe Corte del Dia</th> 
                             </tr>
                             <tr>
                             <th colspan="2" style="text-align:center">Categoria de Producto</th> 
                              <th colspan="2" style="text-align:center">Importe</th>
                             </tr>
                              <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                             <td colspan="2" style="text-align:center" v-text="detalle.categoria"></td>
                               <td colspan="2" style="text-align:center">{{ formatPrice(detalle.importe) }}</td>
                               
                               </tr>
                               <th colspan="2" style="text-align:right">Subtotal:</th>
                               <th colspan="2">$ {{ calcularCorte  }}</th>
                               </thead>
                                <tbody> <tr> <th colspan="2" style="text-align:center">Retiros de Efectivo:</th> 
                               <th></th> <th></th> </tr> <tr>
                                <td><input  type="text" placeholder="Concepto del Retiro..."></td>
                                 <td><input type="number" v-model="Concepto" @focus="onFocus" v-on:keypress="isNumber(event)" v-bind:min="0"></td> <td>
                                 </td>
                                 <td></td> </tr>
                                  <tr> <td><input type="text" placeholder="Concepto del Retiro..."></td>
                                  <td><input type="number" v-model="Concepto1" @focus="onFocus1" v-on:keypress="isNumber(event)" v-bind:min="0"></td> <th>Saldo Inicial del Dia</th>
                                   <td><input  type="number" name="txtn" id="txtn"  v-model="dinero" readonly></td> </tr>
                                   <tr> <td><input type="text" placeholder="Concepto del Retiro..."></td> 
                               <td><input type="number" v-model="Concepto2" @focus="onFocus2" v-on:keypress="isNumber(event)" v-bind:min="0"></td> <th>Efectivo Total en Caja</th>
                                <th><input  type="number" name="txto" id="txto"   v-model="calcularReal" readonly></th> </tr> <tr>
                                <td><input type="text" placeholder="Concepto del Retiro..."></td>
                                 <td><input type="number" v-model="Concepto3" @focus="onFocus3" v-on:keypress="isNumber(event)" v-bind:min="0"></td>
                                  <th>Ingresos Tarjeta</th>
                                 <td><input  type="number" v-model="calcularTarjeta" readonly></td> </tr> <tr>
                                  <td><input  type="text" placeholder="Concepto del Retiro..."></td>
                                  <td><input type="number" v-model="Concepto4" @focus="onFocus4" v-on:keypress="isNumber(event)" v-bind:min="0" ></td> 
                                  <th>Ingresos Vales</th>
                                   <td><input type="number"  v-model="calcularVales" readonly></td>
                                    </tr>
                                  <td><input  type="text" placeholder="Concepto del Retiro..."></td>
                                 <td><input type="number" v-model="Concepto5" @focus="onFocus5" v-on:keypress="isNumber(event)" v-bind:min="0"></td>
                                  <th>Corte del Dia</th>
                                 <td><input type="number"  v-model="calcularCorte" readonly></td> </tr> <tr>
                                  </tr></tr> <tr> </tr>
                                  <th>Subtotal Retiros Efectivo:</th>
                                  <td>$ {{total=calcular1+calcular2+calcular3+calcular4+calcular5+calcular6}}</td>
                                   <td></td> <td></td> </tr>
                                   </tbody>
                                   <tfoot>
                                    <tr> 
                                      <th colspan="3">Gran Total</th> 
                                         <td>$ {{ ganancia=calcularCorte-calcular1-calcular2-calcular3-calcular4-calcular5-calcular6 }}</td> </tr>
                                          </tfoot>


                                  
                                    

                        </table>
                        </div>
                    </div>
                         </div>
                         </div>
                         </div>
                         </div>
                          </div>
                          </div>
                         </div>
                   
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
           
        </main>
</template>

<script>
import Print from 'vue-print-nb'
import Vue from 'vue'
import Vue2Filters from 'vue2-filters'
Vue.use(Vue2Filters);
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
            output: null,
            dinero: '',
            myLocalData: localStorage.getItem('area_total6'),
                myLocalData1: localStorage.getItem('area_total1'),
                myLocalData2: localStorage.getItem('area_total2'),
                myLocalData3: localStorage.getItem('area_total'),
                myLocalData4: localStorage.getItem('area_total5'),
                dinero1: '',
                dinero2: '',
                dinero3: '',
                dinero4: '',
                idarticulo: 0,
                detalle_id: 0,
                idventa: 0,
                estado : '',
                precio : 0,
                total : 0,
                total1 : 0,
                stock2 : 0,
                listado:1,
                precio_proveedor : 0,
                cantidad : 0,
                articulo : '',
                arrayDetalle : [],
                modal : 0,
                Concepto:0,
                Concepto1:0,
                Concepto2:0,
                Concepto3:0,
                Concepto4:0,
                Concepto5:0,
                calcularVales: 0,
                calcularTarjeta: 0,
                calcularReal: 0,
                calcularCorte: 0,
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
            inicio: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.dinero.length;i++){
                 resultado1=+this.dinero
                }
                return resultado1;
            },
            ventas: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.myLocalData.length;i++){
                 resultado1=+this.myLocalData
                }
                return resultado1;
            },
            tarjetas: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.myLocalData1.length;i++){
                 resultado1=+this.myLocalData1
                }
                return resultado1;
            },
            vales: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.myLocalData2.length;i++){
                 resultado1=+this.myLocalData2
                }
                return resultado1;
            },
            ventas1: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.myLocalData.length;i++){
                 resultado1=+this.myLocalData
                }
                return resultado1;
            },
            dia: function(){
                var resultado1=0;
                
                    resultado1=+this.dinero
                
                return resultado1;
            },
            dia1: function(){
                var resultado1=0;
                
                    resultado1=+this.calcularReal
                
                return resultado1;
            },
            dia2: function(){
                var resultado1=0;
                
                    resultado1=+this.calcularTarjeta
                
                return resultado1;
            },
            dia3: function(){
                var resultado1=0;
                
                    resultado1=+this.calcularVales
                
                return resultado1;
            },
            cambios: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.myLocalData4.length;i++){
                 resultado1=+this.myLocalData4
                }
                return resultado1;
            },
            calcular1: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.Concepto.length;i++){
                 resultado1=+this.Concepto
                }
                return resultado1;
            },
            calcular2: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.Concepto1.length;i++){
                 resultado1=+this.Concepto1
                }
                return resultado1;
            },
            calcular3: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.Concepto2.length;i++){
                 resultado1=+this.Concepto2
                }
                return resultado1;
            },
            calcular4: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.Concepto3.length;i++){
                 resultado1=+this.Concepto3
                }
                return resultado1;
            },
            calcular5: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.Concepto4.length;i++){
                 resultado1=+this.Concepto4
                }
                return resultado1;
            },
            calcular6: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.Concepto5.length;i++){
                 resultado1=+this.Concepto5
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
            onFocus() {
      this.Concepto = '';
    },
    onFocus1() {
      this.Concepto1 = '';
    },
    onFocus2() {
      this.Concepto2 = '';
    },
    onFocus3() {
      this.Concepto3 = '';
    },
    onFocus4() {
      this.Concepto4 = '';
    },
    onFocus5() {
      this.Concepto5 = '';
    },
             isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
      } else {
        return true;
      }
    },
            formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },
            printDiv: function() {
         window.frames["print_frame"].document.body.innerHTML = document.getElementById("printableTable").innerHTML;
         window.frames["print_frame"].window.focus();
         window.frames["print_frame"].window.print();
       },
       cambio1: function (){
                var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(2)');

                var total = [].reduce.call(td, function(a, b) {
                return a + parseInt(b.innerText);
                }, 0);
              
                var n=parseInt(document.getElementById('txtn').value);
                var o=parseInt(document.getElementById("txto").value);
               
                var r=n+o;
                document.getElementById("txtr").value=""+r;
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
                var url= this.ruta + '/detalle?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
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
             mostrarDetalle(){
                let me=this;
                me.listado=0;
                
             },
             mostrarDetalle1(){
                let me=this;
                me.listado=1;
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
            if (localStorage.dinero) {
      this.dinero = localStorage.dinero;
    }
    if (localStorage.calcularReal) {
      this.calcularReal = localStorage.calcularReal;
    }
    if (localStorage.calcularTarjeta) {
      this.calcularTarjeta = localStorage.calcularTarjeta;
    }
    if (localStorage.calcularVales) {
      this.calcularVales = localStorage.calcularVales;
    }
    if (localStorage.calcularCorte) {
      this.calcularCorte = localStorage.calcularCorte;
    }
    if (localStorage.dinero1) {
      this.dinero1 = localStorage.dinero1;
    }
    if (localStorage.dinero2) {
      this.dinero2 = localStorage.dinero2;
    }
    if (localStorage.dinero3) {
      this.dinero3 = localStorage.dinero3;
    }
    if (localStorage.dinero4) {
      this.dinero4 = localStorage.dinero4;
    }
            this.listarDetalle(1,this.buscar,this.criterio);
        },
        watch: {
    dinero(newName) {
      localStorage.dinero = newName;
    },
    calcularReal(newName) {
      localStorage.calcularReal = newName;
    },
    calcularTarjeta(newName) {
      localStorage.calcularTarjeta = newName;
    },
    calcularVales(newName) {
      localStorage.calcularVales = newName;
    },
    calcularCorte(newName) {
      localStorage.calcularCorte = newName;
    },
    dinero1(newName) {
      localStorage.dinero1 = newName;
    },
    dinero2(newName) {
      localStorage.dinero2 = newName;
    },
    dinero3(newName) {
      localStorage.dinero3 = newName;
    },
     dinero4(newName) {
      localStorage.dinero4 = newName;
    }
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
