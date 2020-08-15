
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.$ = window.jQuery = require('jquery'); 

window.Vue = require('vue');



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('articulo', require('./components/Articulo.vue'));
Vue.component('articulo1', require('./components/Articulo1.vue'));
Vue.component('cliente', require('./components/Cliente.vue'));
Vue.component('proveedor', require('./components/Proveedor.vue'));
Vue.component('rol', require('./components/Rol.vue'));
Vue.component('detalle', require('./components/Detalle.vue'));
Vue.component('detalle3', require('./components/Detalle3.vue'));
Vue.component('detalle1', require('./components/Detalle1.vue'));
Vue.component('detalle2', require('./components/Detalle2.vue'));
Vue.component('historial', require('./components/Historial.vue'));
Vue.component('historial2', require('./components/Historial2.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('ingreso', require('./components/Ingreso.vue'));
Vue.component('venta', require('./components/Venta.vue'));
Vue.component('venta1', require('./components/Venta1.vue'));
Vue.component('venta3', require('./components/Venta3.vue'));
Vue.component('venta4', require('./components/Venta4.vue'));
Vue.component('interna', require('./components/Interna.vue'));
Vue.component('venta2', require('./components/Venta2.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('consultaingreso', require('./components/ConsultaIngreso.vue'));
Vue.component('consultaventa', require('./components/ConsultaVenta.vue'));
Vue.component('ayuda', require('./components/Ayuda.vue'));
Vue.component('acerca', require('./components/Acerca.vue'));

$('.input-daterange input').each(function() {
    $(this).datepicker('clearDates');
  });

const app = new Vue({
    el: '#app',
  
    data :{
        randomNumber:'',
        menu : 0,
        ruta: 'http://192.168.1.23/sistema/public/'
    },
    methods:{
        myFunction: function () {		
            this.randomNumber = Math.random();
        }   
       }       
});
