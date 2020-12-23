import Form from './utilities/Form';
import VueRouter from 'vue-router'
import routes from './routes'

require('./bootstrap');

window.Vue = require('vue');
window.Form = Form;

Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
