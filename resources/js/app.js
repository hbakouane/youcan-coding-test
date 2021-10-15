/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

/* Plugins */
// Axios
import axios from 'axios';
// Let's do an API base url so that we can consum other version easily when we want
axios.defaults.baseURL = '/api/v1/';


// Bootstrap
require('./bootstrap');
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css"

// FontAwesome
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'


window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('categories', require('./components/categories/AllCategories.vue').default);
Vue.component('categories-table', require('./components/categories/CategoriesTable.vue').default);
Vue.component('products', require('./components/products/AllProducts.vue').default);
Vue.component('products-table', require('./components/products/ProductsTable.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});