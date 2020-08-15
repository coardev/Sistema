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
                        
                        <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>
                        <button type="button"   @click="sum1()" class="btn btn-info">Monetizar Inventario
                              <i class="fa fa-cog fa-spin"></i>
                              </button>
                        <button type="button" id="val2" class="btn btn-info" ></button>
                        <button type="button"   @click="sum()" class="btn btn-info">Calcular Total de Productos 
                             <i class="fa fa-cog fa-spin"></i>
                              </button>
                        <button type="button" id="val" class="btn btn-info" ></button>
                    
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input v-autofocus type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                            </div>
                        </div>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="table" border="3" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    
                                    <th>Opciones</th>
                                    <th>Estado</th>
                                    <th><i class='fas fa-barcode' style='font-size:18px'>&nbsp; Código</i></th>
                                    <th><i class='fas fa-file-alt' style='font-size:18px'>&nbsp; Nombre</i></th>
                                    <th><i class='fas fa-dolly-flatbed' style='font-size:18px'>&nbsp; Stock</i></th>
                                    <th><i class='fas fa-envelope-open-text' style='font-size:18px'>&nbsp; Categoría</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; Precio Proveedor</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; Precio Venta</i></th>
                                    <th><i class='fas fa-dollar-sign' style='font-size:18px'>&nbsp; Utilidad Producto</i></th>
                                    <th><i class='fas fa-balance-scale' style='font-size:18px'>&nbsp; Inversion</i></th>
                                    <th>IVA</th>
                                    <th>IEPS</th>
                                   
                                    <th>Descripción</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                 
                                    <td>
                                        <button type="button" @click="abrirModal('articulo','actualizar',articulo); disabled(); disabled1()" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                       
                                       
                                    </td>
                                    <td>
                                        <div v-if="articulo.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td v-text="articulo.codigo"></td>
                                    <td v-text="articulo.nombre"></td>
                                    <td v-text="articulo.stock"></td>
                                    <td v-text="articulo.nombre_categoria"></td>
                                    <td v-text="articulo.precio_proveedor"></td>
                                    <td v-text="articulo.precio_venta"></td>
                                    <td v-text="articulo.precio_venta - articulo.precio_proveedor"></td>
                                    <td v-text="articulo.precio_proveedor * articulo.stock"></td>
                                    <td v-text="articulo.iva"></td>
                                    <td v-text="articulo.ieps"></td>
                                    
                                    <td v-text="articulo.descripcion"></td>
                                    
                                      
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
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Proveedor:</label>
                                    <div class="col-md-3">
                                        <input type="number" v-model="precio_proveedor" class="form-control" placeholder="">                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio Venta:</label>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" id="mySelect" v-model="precio_venta" class="form-control" placeholder="">                                       
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
                                    <input type="radio" id="uno" value="Si" v-model="ieps">
                                    <label for="uno">&nbsp;    Si</label>  
                                    &nbsp;     
                                    <input type="radio" id="Dos" value="No" v-model="ieps">
                                    <label for="Dos">&nbsp;    No</label>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock:</label>
                                    <div class="col-md-3">
                                        <input type="number" id="mySelect1" v-model="stock" class="form-control" placeholder="">                                        
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">Agregar:</label>
                                    <div class="col-md-3">
                                        <input type="number" v-model="stock1" @keyup.enter="actualizarArticulo()" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Actualizar</button>
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
    import VueBarcode from 'vue-barcode';
    export default {
        props : ['ruta'],
        data (){
            return {
                articulo_id: 0,
                idcategoria : 0,
                nombre_categoria : '',
                codigo : '',
                nombre : '',
                precio_proveedor : 0,
                precio_venta : 0,
                iva : '',
                ieps : '',
                stock : 0,
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

           disabled: function() {
  document.getElementById("mySelect").disabled = true;
},

disabled1: function() {
  document.getElementById("mySelect1").disabled = true;
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
                    'precio_venta': this.precio_venta,
                    'iva': this.iva,
                    'ieps': this.ieps,
                    'stock': this.stock,                  
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
                    'stock1': this.stock1,
                    'precio_proveedor': this.precio_proveedor,
                    'precio_venta': this.precio_venta,
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
                if (!this.nombre) this.errorMostrarMsjArticulo.push("El nombre del artículo no puede estar vacío.");
                if (!this.stock) this.errorMostrarMsjArticulo.push("El stock del artículo debe ser un número y no puede estar vacío.");
                if (!this.precio_venta) this.errorMostrarMsjArticulo.push("El precio venta del artículo debe ser un número y no puede estar vacío.");

                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

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
                this.precio_venta = 0;
                this.iva = '';
                this.ieps = '';
                this.stock = 0;
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
                                this.precio_venta=0;
                                this.iva= '';
                                this.ieps= '';
                                this.stock=0;
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                
                                this.modal=1;
                                this.tituloModal='Agregar Artículo';
                                this.tipoAccion=2;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock=data['stock'];
                                this.stock1=0;
                                this.precio_proveedor=data['precio_proveedor'];
                                this.precio_venta=data['precio_venta'];
                                this.iva = data['iva'];
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
