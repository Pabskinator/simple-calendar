import routes from './routes'
import VueRouter from 'vue-router'
import Form from './utilities/Form';
import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.css';

require('./bootstrap');

window.Vue = require('vue');
window.Form = Form;

Vue.use(VueRouter)
Vue.use(VueIziToast);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
