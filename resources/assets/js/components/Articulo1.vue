<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card" style="height: 37rem;">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Artículos
                        <button type="button" @click="abrirModal('articulo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        
                        <button type="button" v-print="printObj" class="btn btn-info">
                            <i class="fas fa-file-pdf"></i>&nbsp;Reporte PDF
                        </button>

                        <button type="button" @click="tableToExcel('myTable', 'name', 'Reporte.xls')" class="btn btn-info">
                            <i class="fa fa-file-excel-o"></i>&nbsp;Reporte Excel
                        </button>
                   
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="codigo">Codigo</option>
                                      <option value="idcategoria">Categoria</option>
                                      <option value="inventariable">Tipo de Inventario</option>
                                    </select>
                                    <template v-if="criterio === 'nombre'">
                                    <input v-autofocus type="text" v-model="buscar" @keypress="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    </template>
                                    <template v-if="criterio === 'codigo'">
                                    <input v-autofocus type="text" v-model="buscar" @keypress="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    </template>
                                    <template v-if="criterio === 'idcategoria'">
                                    <select class="form-control" v-model="buscar">
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>  
                                    </template>
                                    <template v-if="criterio === 'inventariable'">
                                         <select class="form-control" v-model="buscar">
                                            <option value="1">Inventariable</option>
                                            <option value="2">No Inventariable</option>
                                            <option value="3">Servicios</option>
                                        </select>  
                                    </template>
                                    <button type="submit" @click="listarArticulo(1,buscar,criterio);filas()" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                     
                                    </div>
                            </div>
                        </div>
                        <button v-on:click="isHidden = !isHidden">Mostrar</button>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="myTable" border="3" class="table table-bordered table-striped table-sm">
                            <caption><h2>Reporte de Articulos en Inventario</h2></caption>
                            <caption><h2>Numero de Articulos:</h2><h2 id="demo"></h2></caption>
                            <thead>
                                <tr>
                                    
                                    <th v-if="!isHidden">Actualizar</th>
                                    <th v-if="!isHidden">Agregar</th>
                                    
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                    <th>Stock Minimo</th>
                                    <th>Categoria</th>
                                    <th>Precio Proveedor</th>
                                    
                                    <th>Precio Venta</th>
                                    <th>IVA</th>
                                    <th>IEPS</th>                                 
                                    <th>Descripcion</th>
                                    <th>$ en Almacen</th>
                                    <th>Tipo</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                 
                                    <td v-if="!isHidden">
                                        <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                                                           
                                       
                                       
                                    </td>
                                    <td v-if="!isHidden">
                                        <template v-if="articulo.inventariable === 1">
                                      <button type="button" class="btn btn-danger btn-sm" @click="abrirModal('articulo','agregar',articulo)">
                                      +
                                      </button>
                                      </template>
                                      
                                      <template v-if="articulo.inventariable === 2">
                                      <button type="button" class="btn btn-danger btn-sm" disabled>
                                      +
                                      </button>
                                      </template>

                                      <template v-if="articulo.inventariable === 3">
                                      <button type="button" class="btn btn-danger btn-sm" disabled>
                                      +
                                      </button>
                                      </template>
                                        
                                    </td>
                                    
                                    <td v-text="articulo.codigo"></td>
                                    <td v-text="articulo.nombre"></td>
                                    <template v-if="articulo.inventariable === 1">
                                    <td v-text="articulo.stock"></td>
                                    </template>
                                    <template v-if="articulo.inventariable === 2">
                                    <td>N/A</td>
                                    </template>
                                    <template v-if="articulo.inventariable === 3">
                                    <td>N/A</td>
                                    </template>
                                    <template v-if="articulo.inventariable === 1">
                                    <td style="color: red" v-text="articulo.minimo"></td>
                                    </template>
                                    <template v-if="articulo.inventariable === 2">
                                    <td style="color: red">N/A</td>
                                    </template>
                                    <template v-if="articulo.inventariable === 3">
                                    <td style="color: red">N/A</td>
                                    </template>
                                    <td v-text="articulo.nombre_categoria"></td>
                                    <td v-text="articulo.precio_proveedor"></td>
                                    
                                    <td v-text="articulo.precio_venta"></td>
                                    <td v-text="articulo.iva"></td>
                                    <td v-text="articulo.ieps"></td>
                                    <td v-text="articulo.descripcion"></td>
                                    <template v-if="articulo.inventariable === 1">
                                    <td v-text="articulo.stock*articulo.precio_proveedor1"></td>
                                    </template>
                                    <template v-if="articulo.inventariable === 2">
                                    <td>N/A</td>
                                    </template>
                                    <template v-if="articulo.inventariable === 3">
                                    <td>N/A</td>
                                    </template>

                                    <td style="color: red" v-text="articulo.inventariable"></td>
                                    
                                      
                                </tr>
                                
                                                          
                            </tbody>
                        </table>
                        </div>
                                          
                    </div>
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                                <template v-if="tituloModal === 'Registrar Artículo'">
                                    <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría:</label>
                                    <div class="col-md-3">
                                        <select id="x"  class="form-control" v-model="idcategoria">
                                            <option value="0">Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                     <label class="col-md-3 form-control-label" for="text-input">Es Inventariable</label>
                                    <div class="col-md-3">
                                    <input type="radio" id="cinco" value="1" v-model="inventariable">
                                    <label for="uno">&nbsp;    Si</label>
                                    &nbsp;     
                                    <input type="radio" id="seis" value="2" v-model="inventariable">
                                    <label for="Dos">&nbsp;    No</label>
                                    <br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-3">
                                        <input id="x1"  type="text" v-model="codigo" class="form-control" placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">Es un Servicio?</label>
                                    <div class="col-md-3">
                                    <input type="radio"  value="3" v-model="inventariable">
                                    <label for="tres">&nbsp;    Si</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Articulo o Servicio</label>
                                    <div class="col-md-3">
                                        <input id="x2"   type="text" v-model="nombre" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-3">
                                        <input id="x5"   type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                    </div>
                               
                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Proveedor:</label>
                                    <div class="col-md-3">
                                        <input type="number" v-model="precio_proveedor" v-bind:min="0" v-on:keypress="isNumber(event)" class="form-control"  placeholder="">                                        
                                 </div>
                                    <div class="col-md-3">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio Venta:</label>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" v-model="precio_venta" v-bind:min="0" v-on:keypress="isNumber(event)" class="form-control" placeholder="">                                       
                                    </div>
                                </div>
                                
                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">El Precio Incluye IVA</label>
                                    <div class="col-md-3">
                                    <input type="radio" id="uno" value="Si" v-model="iva">
                                    <label for="uno">&nbsp;    Si</label>
                                    &nbsp;     
                                    <input type="radio" id="Dos" value="No" v-model="iva">
                                    <label for="Dos">&nbsp;    No</label>
                                    <br>
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">El Precio Incluye IEPS</label>
                                    <div class="col-md-3">
                                    <input type="radio" id="tres" value="Si" v-model="ieps">
                                    <label for="uno">&nbsp;    Si</label>  
                                    &nbsp;     
                                    <input type="radio" id="Cuatro" value="No" v-model="ieps">
                                    <label for="Dos">&nbsp;    No</label>
                                    </div>
                                </div>
                                <template v-if="inventariable === '1'">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock:</label>
                                    <div class="col-md-3">
                                        <input id="x4"  type="number" v-model="stock" v-bind:min="0" v-on:keypress="isNumber(event)" class="form-control"  placeholder="">                                        
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">Stock Minimo:</label>
                                    <div class="col-md-3">
                                        <input id="minimo"  type="number" v-model="minimo" v-bind:min="0" v-on:keypress="isNumber(event)" class="form-control" placeholder="">                                        
                                    </div>
                                                                     
                                </div>
                                </template>
                                
                                 <div class="div-error">
                                <div v-show="errorArticulo" class="alert alert-danger alert-dismissible fade show">
                                    <div class="text-center text-error">
                                        <h4 class="alert-heading"><i class="fa fa-warning"></i>Error al Ingresar la Venta</h4>
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>

                                </template>    
                                <template v-if="tituloModal === 'Modificar Datos de Articulo'">
                                    <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría:</label>
                                    <div class="col-md-3">
                                        <select id="x"  class="form-control" v-model="idcategoria">
                                            <option value="0">Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                     <label class="col-md-3 form-control-label" for="text-input">Es Inventariable</label>
                                    <div class="col-md-3">
                                    <input type="radio" id="cinco" value="1" v-model="inventariable">
                                    <label for="uno">&nbsp;    Si</label>
                                    &nbsp;     
                                    <input type="radio" id="seis" value="2" v-model="inventariable">
                                    <label for="Dos">&nbsp;    No</label>
                                    <br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-3">
                                        <input id="x1"  type="text" v-model="codigo" class="form-control" placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">Es un Servicio?</label>
                                    <div class="col-md-3">
                                    <input type="radio"  value="3" v-model="inventariable">
                                    <label for="tres">&nbsp;    Si</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Articulo o Servicio</label>
                                    <div class="col-md-3">
                                        <input id="x2"   type="text" v-model="nombre" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-3">
                                        <input id="x5"   type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                    </div>
                               
                                
                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Proveedor:</label>
                                    <div class="col-md-3">
                                        <input type="number" v-model="precio_proveedor" v-bind:min="0" v-on:keypress="isNumber(event)" class="form-control"  placeholder="">                                        
                                 </div>
                                    <div class="col-md-3">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio Venta:</label>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" v-model="precio_venta" v-bind:min="0" v-on:keypress="isNumber(event)" class="form-control" placeholder="">                                       
                                    </div>
                                </div>
                                
                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">El Precio Incluye IVA</label>
                                    <div class="col-md-3">
                                    <input type="radio" id="uno" value="Si" v-model="iva">
                                    <label for="uno">&nbsp;    Si</label>
                                    &nbsp;     
                                    <input type="radio" id="Dos" value="No" v-model="iva">
                                    <label for="Dos">&nbsp;    No</label>
                                    <br>
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">El Precio Incluye IEPS</label>
                                    <div class="col-md-3">
                                    <input type="radio" id="tres" value="Si" v-model="ieps">
                                    <label for="uno">&nbsp;    Si</label>  
                                    &nbsp;     
                                    <input type="radio" id="Cuatro" value="No" v-model="ieps">
                                    <label for="Dos">&nbsp;    No</label>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                   
                                    <label class="col-md-3 form-control-label" for="text-input">Stock Minimo:</label>
                                    <div class="col-md-3">
                                        <input id="minimo"  type="number" v-model="minimo" v-bind:min="0" v-on:keypress="isNumber(event)" class="form-control" placeholder="">                                        
                                    </div>
                                                                     
                                </div>
                               
                                
                                <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                                </template>    
                                   <template v-if="tituloModal === 'Agregar Artículo a Inventario'">
                                    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-6">
                                        <input id="x1"  type="text" v-model="codigo" class="form-control" disabled placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Articulo o Servicio</label>
                                    <div class="col-md-3">
                                        <input id="x2"   type="text" v-model="nombre" class="form-control" disabled placeholder="Nombre de artículo">                                        
                                    </div>
                                    
                                    </div>
                               
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock:</label>
                                    <div class="col-md-3">
                                        <input id="x4"  type="number" v-model="stock" v-bind:min="0" class="form-control" disabled placeholder="">                                        
                                    </div>
                                   
                                    <label class="col-md-3 form-control-label" for="text-input">Agregar:</label>
                                    <div class="col-md-3">
<<<<<<< HEAD
                                        <input id="x10" type="number" v-model="stock1" v-bind:min="0" v-on:keypress="isNumber(event)" @keyup.enter="actualizarArticulo1()" class="form-control" placeholder="">                                        
=======
                                        <input id="x10" type="number" v-model="stock1" v-bind:min="1" @keyup.enter="actualizarArticulo1()" class="form-control" placeholder="">                                        
>>>>>>> ebfa3001d5438580579651544eb0b2a7cee56941
                                    </div>
                                                                     
                                </div>
                               
                                
                                <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                                </template>   
                                <template v-if="tituloModal === 'Restar Artículo a Inventario'">
                                    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-6">
                                        <input id="x1"  type="text" v-model="codigo" class="form-control" disabled placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Articulo o Servicio</label>
                                    <div class="col-md-6">
                                        <input id="x2"   type="text" v-model="nombre" class="form-control" disabled placeholder="Nombre de artículo">                                        
                                    </div>
                                    
                                    </div>
                               
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock:</label>
                                    <div class="col-md-3">
                                        <input id="x4"  type="number" v-model="stock" v-bind:min="0" class="form-control" disabled placeholder="">                                        
                                    </div>
                                   
                                    <label class="col-md-3 form-control-label" for="text-input">Restar:</label>
                                    <div class="col-md-3">
                                        <input id="x10" type="number" v-model="stock2" v-bind:min="0" v-on:keypress="isNumber(event)" @keyup.enter="actualizarArticulo2()" class="form-control" placeholder="">                                        
                                    </div>
                                                                     
                                </div>
                               
                                
                                <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                                </template>     
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Actualizar</button>
                            <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="actualizarArticulo1()">Agregar Articulos</button>
                            <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="actualizarArticulo2()">Restar Articulos</button>

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
import Print from 'vue-print-nb'
 
Vue.use(Print);
    import VueBarcode from 'vue-barcode';
    export default {
        props : ['ruta'],
        data (){
            return {
                printObj: {
              id: "myTable",
              popTitle: '',
              extraCss: 'https://www.google.com,https://www.google.com',
              extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>'
            },
                isHidden: false,
                articulo_id: 0,
                idcategoria : 0,
                nombre_categoria : '',
                codigo : '',
                nombre : '',
                precio_proveedor : 0,
                precio_proveedor1 : 0,
                precio_venta : 0,
                iva : '',
                inventariable : '',
                ieps : '',
                stock : 0,
                stock1 : 0,
                stock2 : 0,
                minimo : 0,
                descripcion : '',
                arrayArticulo : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorArticulo : 0,
                errorMostrarMsjArticulo : [],
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
                buscar : '',
                arrayCategoria :[]
            }
        },
        components: {
        'barcode': VueBarcode
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
            isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
      } else {
        return true;
      }
    },
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
            

            busqueda: function (){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
},
 filas: function() {
  var x = document.getElementById("myTable").rows.length-1;
  document.getElementById("demo").innerHTML = x;
            },


            sum: function () {
         var table =document.getElementById("table"), sumVal = 0;
      for(var i = 1; i < table.rows.length; i++)
      {
          sumVal = sumVal + parseInt(table.rows[i].cells[2].innerHTML);
             }
             document.getElementById("val").innerHTML = "#" + sumVal;
    },

    sum1: function () {
      var table =document.getElementById("table"), sumVal = 0;
      for(var i = 1; i < table.rows.length; i++)
      {
          sumVal = sumVal + parseInt(table.rows[i].cells[4].innerHTML);
             }
             document.getElementById("val2").innerHTML = "$" + sumVal;
    },

    imprimir: function () {
        
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
    },
            listarArticulo (page,buscar,criterio){
                let me=this;
                var url= this.ruta + '/articulo?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            delete (){
              
                axios.get(url).then(function (response) {
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open(this.ruta + '/articulo/listarPdf','_blank');
            },
            selectCategoria(){
                let me=this;
                var url= this.ruta + '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias;
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
                me.listarArticulo(page,buscar,criterio);
            },
             registrarArticulo(){
                if (this.validarArticulo()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta + '/articulo/registrar',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'precio_proveedor': this.precio_proveedor,
                    'precio_proveedor1': this.precio_proveedor1,
                    'precio_venta': this.precio_venta,
                    'iva': this.iva,
                    'inventariable': this.inventariable,
                    'ieps': this.ieps,
                    'stock': this.stock,      
                    'minimo': this.minimo,              
                    'descripcion': this.descripcion
                }).then(function (response) {
                    swal("Articulo Registrado en Inventario", "Enter", "success"
                        )
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                }).catch(function () {
                    sweetAlert("Oops...", "El Articulo ya se Encuentra Registrado!!!", "error");
                });
            },
            actualizarArticulo(){
               if (this.validarArticulo()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta + '/articulo/actualizar',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'minimo': this.minimo,
                    'stock1': this.stock1,
                    'precio_proveedor': this.precio_proveedor,
                    'precio_proveedor1': this.precio_proveedor1,
                    'precio_venta': this.precio_venta,
                    'inventariable': this.inventariable,
                    'iva': this.iva,
                    'ieps': this.ieps,
                    'descripcion': this.descripcion,
                    'id': this.articulo_id
                }).then(function (response) {
                    swal("Datos Actualizados de Articulo", "Enter", "success"
                        )
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
             actualizarArticulo1(){
               if (this.validarArticulo()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta + '/articulo/actualizar1',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'minimo': this.minimo,
                    'stock1': this.stock1,
                    'precio_proveedor': this.precio_proveedor,
                    'precio_proveedor1': this.precio_proveedor1,
                    'precio_venta': this.precio_venta,
                    'inventariable': this.inventariable,
                    'iva': this.iva,
                    'ieps': this.ieps,
                    'descripcion': this.descripcion,
                    'id': this.articulo_id
                }).then(function (response) {
                    swal("Se han Agregado los Articulos", "Enter", "success"
                        )
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            actualizarArticulo2(){
               if (this.validarArticulo()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta + '/articulo/actualizar2',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'minimo': this.minimo,
                    'stock1': this.stock1,
                    'stock2': this.stock2,
                    'precio_proveedor': this.precio_proveedor,
                    'precio_proveedor1': this.precio_proveedor1,
                    'precio_venta': this.precio_venta,
                    'inventariable': this.inventariable,
                    'iva': this.iva,
                    'ieps': this.ieps,
                    'descripcion': this.descripcion,
                    'id': this.articulo_id
                }).then(function (response) {
                    swal("Se han Restado los Articulos", "Enter", "success"
                        )
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarArticulo(id){
               swal({
                title: 'Esta seguro de desactivar este artículo?',
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

                    axios.put(this.ruta + '/articulo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
            activarArticulo(id){
               swal({
                title: 'Esta seguro de activar este artículo?',
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

                    axios.put(this.ruta + '/articulo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
            validarArticulo(){
               this.errorArticulo=0;
                this.errorMostrarMsjArticulo =[];

                if (this.idcategoria==0) this.errorMostrarMsjArticulo.push("Seleccione una categoría.");
                if (this.inventariable=='') this.errorMostrarMsjArticulo.push("Seleccion algun Tipo de Articulo");
                if (this.nombre=='') this.errorMostrarMsjArticulo.push("El nombre del Articulo no puede quedar vacio");
                if (this.codigo=='') this.errorMostrarMsjArticulo.push("El codigo del Articulo no puede quedar vacio");
                if (this.precio_venta==0) this.errorMostrarMsjArticulo.push("El precio venta deber ser mayor que 0");
                if (this.precio_proveedor==0) this.errorMostrarMsjArticulo.push("El precio proveedor deber ser mayor que 0");
                if (this.iva==0) this.errorMostrarMsjArticulo.push("Debes seleccionar si el Producto ya incluye IVA");
                if (this.ieps==0) this.errorMostrarMsjArticulo.push("Debes seleccionar si el Producto ya incluye IEPS");

               
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
                setTimeout(() => this.errorArticulo = false, 3500);
                return this.errorArticulo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idcategoria= 0;
                this.nombre_categoria = '';
                this.codigo = '';
                this.nombre = '';
                this.precio_proveedor = 0;
                this.precio_proveedor1 = 0;
                this.precio_venta = 0;
                this.iva = '';
                this.inventariable = '';
                this.ieps = '';
                this.stock = 0;
                this.minimo = 0;
                this.descripcion = '';
		        this.errorArticulo=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "articulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Artículo';
                                this.idcategoria=0;
                                this.nombre_categoria='';
                                this.codigo='';
                                this.nombre= '';
                                this.precio_proveedor=0;
                                this.precio_proveedor1=0;
                                this.precio_venta=0;
                                this.iva= '';
                                this.inventariable = '';
                                this.ieps= '';
                                this.stock=1;
                                this.minimo=0;
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                
                                this.modal=1;
                                this.tituloModal='Modificar Datos de Articulo';
                                this.tipoAccion=2;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                               
                                this.minimo=data['minimo'];
                                this.stock1=0;
                                this.precio_proveedor=data['precio_proveedor'];
                               
                                this.precio_venta=data['precio_venta'];
                                this.iva = data['iva'];
                                this.inventariable = data['inventariable'];
                                this.ieps = data['ieps'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                             case 'agregar':
                            {
                                //console.log(data);
                                
                                this.modal=1;
                                this.tituloModal='Agregar Artículo a Inventario';
                                this.tipoAccion=3;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock=data['stock'];
                                this.minimo=data['minimo'];
                                this.stock1=0;
                                this.stock2=0;
                                this.precio_proveedor=data['precio_proveedor'];
                                this.precio_proveedor1=data['precio_proveedor1'];
                                this.precio_venta=data['precio_venta'];
                                this.iva = data['iva'];
                                this.inventariable = data['inventariable'];
                                this.ieps = data['ieps'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                             case 'restar':
                            {
                                //console.log(data);
                                
                                this.modal=1;
                                this.tituloModal='Restar Artículo a Inventario';
                                this.tipoAccion=4;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock=data['stock'];
                                this.minimo=data['minimo'];
                                this.stock1=0;
                                this.stock2=0;
                                this.precio_proveedor=data['precio_proveedor'];
                                this.precio_proveedor1=data['precio_proveedor1'];
                                this.precio_venta=data['precio_venta'];
                                this.iva = data['iva'];
                                this.inventariable = data['inventariable'];
                                this.ieps = data['ieps'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                            
                           
                        }
                    }
                }
                this.selectCategoria();
            }
        },
        created: function(){
        this.sum()
        this.sum1()
                 },
        mounted() {
            this.listarArticulo(1,this.buscar,this.criterio);
            this.selectCategoria();
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
        
      
        justify-content: center;
      
       position: fixed;
       left: 30%;
       top: 0%;
       z-index: 999;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
