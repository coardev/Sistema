<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Caja - Cobro de Ventas         
                    </div>
                    <!-- Listado-->
                   
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-6" v-model="criterio">
                                    <option value="id">Numero de Compra</option>
                                    <option value="created_at">Corte del Dia</option>
                                    </select>
                                    <template v-if="criterio === 'id'">
                                     <input type="text" v-model="buscar"  class="form-control" placeholder="Escribe el Numero de Venta a Buscar...">
                                    </template>
                                    <template v-else-if="criterio === 'created_at'">
                                    <input type="date" v-model="buscar"  class="form-control" placeholder="Escribe la Fecha a Buscar...">
                                    </template>
                                    <button type="submit" @click="listarVenta(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                                
                                </div>
                                </div>
                               
                            </div>
                            <div class="form-group row border">
                            <div align="center" class="col-md-2">
                            <label for="">Saldo Inicial:</label> 
                            <div>
                            <img src="img/cash.png"  class="img-responsive" height="100" width="100" alt="">
                            </div>
                            <div class="form-group">  
                            <input name="txtm" id="txtm" type="number"  v-model="dinero">
                            </div></div>
                            <div align="center" class="col-md-2">
                            <div>
                            <label for="Name">Saldo Al Corte:</label>  
                            </div>       
                            <img src="img/corte.png"  class="img-responsive" height="100" width="100" alt="">
                             <div class="form-group">
                            <input type="text" name="txtr" id="txtr" v-model="calcularCorte1" readonly />
                            </div></div>
                            <div align="center" class="col-md-2">
                            <div>
                            <label for="Name">Efectivo:</label> 
                            </div>      
                            <img src="img/money.png" class="img-responsive" height="100" width="100" alt="">
                            <div class="form-group">
                            <p>${{calcularReal}}</p>
                            </div></div>
                            <div align="center" class="col-md-2">
                            <div> 
                            <label for="Name">Con Tarjeta:</label>
                            </div>       
                            <img src="img/card2.png" class="img-responsive" height="100" width="100" alt="">
                            <div class="form-group">
                            <p>${{calcularTarjeta}}</p>
                            </div></div>
                            <div align="center" class="col-md-2">
                            <div>
                              <label for="Name">Con Vales:</label>  
                            </div>
                            <img src="img/vale.png" class="img-responsive" height="100" width="100" alt="">
                            <div class="form-group">
                            <p>${{calcularVales}}</p>
                            </div></div>
                            <div align="center" class="col-md-2">
                            <div>
                              <label for="Name">Num. de Ventas:</label>  
                            </div>
                            <img src="img/bag.png" class="img-responsive" height="100" width="100" alt="">
                            <div class="form-group">
                            <h2>{{ arrayVenta.length }}</h2>
                            </div></div>
                            
                            
                            </div>
                        
                                <div id="printMe">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table id="table_trans" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>$ {{ calcularEfectivo }}</th>
                                    <th>$ {{ calcularTarjeta }}</th>
                                    <th>$ {{ calcularVales }}</th>
                                    <th>$ {{ calcularCambio }}</th>
                                    <th>$ {{ calcularCorte }}</th>
                                    <th>$ {{ calcularReal }}</th>
                                    <th></th>
                             
                               </tr>
                                    <tr>
                               
                                        <th>Opciones</th>
                                        <th>Ticket</th>
                                        <th>Usuario</th>
                                        <th>Cliente</th>
                                        <th>Fecha Hora</th>
                                        <th>Con Efectivo</th>
                                        <th>Con Tarjeta</th>
                                        <th>Con Vales</th>
                                        <th>Cambio Entregado</th>
                                        <th>Total</th>
                                        <th>Efectivo en Caja</th>
                                        <th>Estado</th>
                                                                            
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="venta in arrayVenta" :key="venta.id">
                                        <td>
                                           <button type="button" @click="verVenta(venta.id)" class="btn btn-success btn-lg">
                                            <i class="icon-eye"></i>
                                            </button> 
                                            <template v-if="venta.estado === 'Venta Registrada'">
                                            <button type="button" @click="pdfTicket(venta.id)" class="btn btn-warning btn-lg" disabled>
                                                <i class='fas fa-ticket-alt'></i>
                                                </button> &nbsp;  
                                            </template>
                                            <template v-if="venta.estado === 'Venta Cobrada'">
                                            <button type="button" @click="pdfTicket(venta.id)" class="btn btn-warning btn-lg">
                                                <i class='fas fa-ticket-alt'></i>
                                                </button> &nbsp;  
                                            </template>
                                        </td>
                                        <td v-text="venta.id"></td>
                                        <td v-text="venta.usuario"></td>
                                        <td v-text="venta.nombre"></td>
                                        <td v-text="venta.created_at"></td>
                                        <td v-text="venta.efectivo"></td>
                                        <td v-text="venta.tarjeta"></td>
                                        <td v-text="venta.vales"></td>
                                        <td v-text="venta.cambio"></td>
                                        <td v-text="venta.total"></td>
                                        <td v-text="venta.efectivo1"></td>
                                        <td v-text="venta.estado"></td>
                                       
                                        
                                        
                                    </tr>                                
                                </tbody>
                            </table>
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
                                    <label for="">Folio de Ticket</label>
                                    <p v-text="id"></p>
                                </div>
                            </div>
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante</label>
                                    <p v-text="estado"></p>
                                    
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
                                            <td v-show="detalle.precio5>0" v-text="detalle.precio5">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td v-show="detalle.precio6>0" v-text="detalle.precio6">
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
                                            <td v-show="detalle.cantidad1>0" v-text="detalle.cantidad1">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td v-show="detalle.kilogramos>0" v-text="detalle.kilogramos">
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
                                            <td v-show="detalle.precio5>0" v-text="detalle.precio5">
                                            </td>
                                            </template>
                                            <template v-if="detalle.inventariable === 2">
                                            <td v-show="detalle.precio6>0" v-text="detalle.precio6">
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
                        <div class="form-group row">
                            <div class="col-md-12">
                                <template v-if="estado === 'Venta Registrada'">
                                <button type="button" @click="abrirModal()"  class="btn btn-secondary">Cobrar Venta</button>
                                </template>
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                
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
                             <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                       
                                        <tr>
                                        <th>Efectivo&nbsp;&nbsp;&nbsp;<i class="fa fa-money" style="font-size:24px"></i>
                                       </th>
                                        <th>Tarjeta&nbsp;&nbsp;&nbsp;<i class="fa fa-cc-visa" style="font-size:24px"></i>
                                       </th>
                                        <th>Vales&nbsp;&nbsp;&nbsp;<i class="fa fa-sticky-note-o" style="font-size:24px"></i>
                                       </th>
                                       
                                        
                                       
                                       <th>Total
                                       </th>
                                        <th>Imprimir Ticket
                                       </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <td style="background-color: #CEECF5"><input  v-bind:min="0" v-model="efectivo" v-on:keypress="isNumber(event)" placeholder="0" ref="test" @blur="onBlur" type="number"></td>
                                            <td style="background-color: #CEECF5"><input placeholder="0" ref="test1" @blur="onBlur1" v-bind:min="0" v-model="tarjeta" v-on:keypress="isNumber(event)" type="number"></td>
                                            <td style="background-color: #CEECF5"><input placeholder="0" ref="test2" @blur="onBlur2"  v-bind:min="0" v-model="vales" v-on:keypress="isNumber(event)" type="number"></td>
                                            <td style="background-color: #CEECF5">
                                                <input name="txtb" id="txtb" v-bind:value="total" v-on:input="somethingElse = $event.target.value" readonly /></td>
                                            <td  style="background-color: #CEECF5">
                                                <button type="button" @click="actualizarVenta('venta','actualizar',venta);pdfTicket(id)" class="btn btn-warning btn-lg">
                                                <i class='fas fa-ticket-alt'></i>
                                                </button> &nbsp;
                                            </td>
                                            <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Cambio:</strong></td>
                                            <td style="background-color: #CEECF5">{{cambio=calcularTotal+(calcularTotal1+calcularTotal2)}}</td>
                                        </tr>
                                            

                                       
                                          
                                       
                                        
                                    </tbody>
                                                                     
                                </table>
                            </div>
                        </div>
                            
                               
                               
                            </div>
                          
                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="actualizarVenta()">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            
            <!--Fin del modal-->
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    import Vue from "vue";
    import Vue2Filters from 'vue2-filters'
     Vue.use(Vue2Filters);
    import autofocus from "vue-autofocus-directive";

    export default {
        props : ['ruta'],
        data (){
            return {
                output: null,
                estado: '',
                dinero: '',
                dinero1: '',
                dinero2: '',
                dinero3: '',
                dinero4: '',
                myLocalData: localStorage.getItem('area_total6'),
                myLocalData1: localStorage.getItem('area_total1'),
                myLocalData2: localStorage.getItem('area_total2'),
                myLocalData3: localStorage.getItem('area_total'),
                randomNumber:'',
                venta_id: 0,
                e: 0,
                t: 0,
                v: 0,
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
                criterio : 'created_at',
                buscar : '',
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
                 stock:0
            }
        },
        components: {
            vSelect
        },
        computed:{
            efectivo: {
      get() {
        return Number(this.e)
      },
      set(val) {
        this.e = Number(val) || 0
      }
    },
    tarjeta: {
      get() {
        return Number(this.t)
      },
      set(val) {
        this.t = Number(val) || 0
      }
    },
    vales: {
      get() {
        return Number(this.v)
      },
      set(val) {
        this.v = Number(val) || 0
      }
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
            },
            calcularCambio: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado1=resultado1+(this.arrayVenta[i].cambio*1)
                }
                return resultado1.toFixed(2);
            },
            calcularReal: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado1=resultado1+(this.arrayVenta[i].efectivo - this.arrayVenta[i].cambio)
                }
                return resultado1;
            },
            calcularEfectivo: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado1=resultado1+(this.arrayVenta[i].efectivo*1)
                }
                return resultado1;
            },
            calcularTarjeta: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado1=resultado1+(this.arrayVenta[i].tarjeta*1)
                }
                return resultado1;
            },
            calcularVales: function(){
                var resultado1=0.0;
                
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado1=resultado1+(this.arrayVenta[i].vales*1)
                }
                return resultado1;
            },
            calcularCorte: function(){
                var resultado1=0.0;
                var resultado2=0.0;
                var resultado3=0.0;
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado1=resultado1+=(this.arrayVenta[i].tarjeta*1)
                }
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado2=resultado2+=(this.arrayVenta[i].vales*1)
                }
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado3=resultado3+=(this.arrayVenta[i].efectivo1*1)
                }
                return resultado1+resultado2+resultado3;
            },
            calcularCorte1: function(){
                var resultado1=0.0;
                var resultado2=0.0;
                var resultado3=0.0;
                var resultado4=0.0;
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado1=resultado1+=(this.arrayVenta[i].tarjeta*1)
                }
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado2=resultado2+=(this.arrayVenta[i].vales*1)
                }
                for(var i=0;i<this.arrayVenta.length;i++){
                 resultado3=resultado3+=(this.arrayVenta[i].efectivo1*1)
                }
                resultado4=resultado4+(this.dinero*1)
                return resultado1+resultado2+resultado3+resultado4;
            },
            calcularTotal: function(){
                var resultado=0.0;
                
                    resultado=resultado+(this.efectivo-this.total)
                
                return resultado;
            },
            calcularTotal1: function(){
                var resultado1=0;
                
                    resultado1=+this.tarjeta
                
                return resultado1;
            },
            calcularTotal2: function(){
                var resultado2=0;
                
                    resultado2=+this.vales
                
                return resultado2;
            }
        },
        methods : {
            onBlur() {
      this.$refs.test.value = this.efectivo
    },
    onBlur1() {
      this.$refs.test1.value = this.tarjeta
    },
    onBlur2() {
      this.$refs.test2.value = this.vales
    },
            onFocus() {
      this.efectivo = '';
    },
    onFocus1() {
      this.tarjeta = '';
    },
    onFocus2() {
      this.vales = '';
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
            print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    },
             salida1: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(6)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total').innerText = total;
localStorage.setItem('area_total', JSON.stringify(total));

                    },
                    salida2: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(7)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total1').innerText = total;
localStorage.setItem('area_total1', JSON.stringify(total));
                    },
                    obtener: function () {
               var total = localStorage.getItem('area_total6');

                this.myLocalData = JSON.parse(total);

                    },
                    obtener1: function () {
               var total = localStorage.getItem('area_total1');

                this.myLocalData1 = JSON.parse(total);

                    },
                    obtener2: function () {
               var total = localStorage.getItem('area_total2');

                this.myLocalData2 = JSON.parse(total);

                    },
                     obtener3: function () {
               var total = localStorage.getItem('area_total');

                this.myLocalData3 = JSON.parse(total);

                    },
                    obtener4: function () {
               var total = localStorage.getItem('area_total5');

                this.myLocalData4 = JSON.parse(total);

                    },
                    salida3: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(8)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total2').innerText = total;
localStorage.setItem('area_total2', JSON.stringify(total));
                    },
                    salida4: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(10)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total4').innerText = total;

                    },
                    salida5: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(9)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total5').innerText = total;
localStorage.setItem('area_total5', JSON.stringify(total));
                    },
                    salida6: function () {
               var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(11)');

var total = [].reduce.call(td, function(a, b) {
    return a + parseInt(b.innerText);
}, 0);

document.getElementById('area_total6').innerText = total;
localStorage.setItem('area_total6', JSON.stringify(total));
                    },
                    
            cambio: function (){
                var a=parseInt(document.getElementById("txta").value);
                var b=parseInt(document.getElementById("txtb").value);
                var d=parseInt(document.getElementById("txtd").value);
                var e=parseInt(document.getElementById("txte").value);
                var c=a-b+(d+e);
                document.getElementById("txtc").value=""+c;
            },
            cambio1: function (){
                var td = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(6)');
                var td1 = document.querySelectorAll('#table_trans > tbody > tr > td:nth-child(10)');
                var total = [].reduce.call(td, function(a, b) {
                return a + parseInt(b.innerText);
                }, 0);
                var total1 = [].reduce.call(td1, function(a, b) {
                return a + parseInt(b.innerText);
                }, 0);
                var m=parseInt(document.getElementById("txtm").value);
                var n=parseInt(document.getElementById('area_total').innerText = total);
                var o=parseInt(document.getElementById('area_total4').innerText = total1);
                var r=m+o;
                document.getElementById("txtr").value=""+r;
            },
             filas: function() {
  var x = document.getElementById("table_trans").rows.length-1;
  document.getElementById("demo").innerHTML = x-1;
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


            listarVenta (page,buscar,criterio){
                let me=this;
                var url= this.ruta + '/venta2?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVenta = respuesta.ventas.data;
                    me.pagination= respuesta.pagination;
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
             mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idproveedor=0;
                me.tipo_comprobante='BOLETA';
                me.total=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.precio=0;
                me.precio1=0;
                me.precio2=0;
                me.minimo=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
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

                    me.id = arrayVentaT[0]['id'];
                    me.cliente = arrayVentaT[0]['nombre'];
                    me.created_at = arrayVentaT[0]['created_at'];
                    me.tipo_comprobante=arrayVentaT[0]['tipo_comprobante'];
                    me.total=arrayVentaT[0]['total'];
                    me.estado=arrayVentaT[0]['estado'];
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
                this.tituloModal = 'Cobrar Venta';
            },
            actualizarVenta(){
              
                let me = this;

                axios.put(this.ruta + '/venta/actualizar',{

                    'tarjeta': this.tarjeta,
                    'vales': this.vales,
                    'efectivo': this.efectivo,
                    'cambio': this.cambio,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.ocultarDetalle();
                    me.listarVenta(1,me.buscar,me.criterio);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            abrirModal2(modelo, accion, data = []){
                switch(modelo){
                    case "venta":
                    {
                        switch(accion){
                           case 'actualizar':
                            {
                                //console.log(data);
                                
                                this.modal=1;
                                this.tituloModal='Cobrar Venta';
                                this.tarjeta=data['tarjeta'];
                                this.vales=data['vales'];
                               this.efectivo=data['efectivo'];
                               this.cambio=data['cambio'];
                                this.id=data['id'];
                               
                                break;
                            }
                                                      
                           
                        }
                    }
                }
               
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
                        me.verVenta(id);
                        me.pdfTicket(id)
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
        this.myFunction()
        this.randomString()
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
            this.listarVenta(1,this.buscar,this.criterio);
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
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
