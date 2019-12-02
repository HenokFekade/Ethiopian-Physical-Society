/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


//import swal
import Swal from 'sweetalert2'

import VueProgressBar from 'vue-progressbar'

import { Form, HasError, AlertError } from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


//register the Form as global to use it any where in your application
window.Form = Form;

//register the swal as global to use it any where in your application
window.Swal = Swal;

window.Fire = new Vue();

//define the toast as swal and give it a function to do
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.use(VueProgressBar, options)

//register the toast as global to use it any where in your application
window.toast = Toast;

Vue.filter('capitalize',function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('field-created', require('./components/admin/field/FieldCreated.vue').default);
Vue.component('field-updated', require('./components/admin/field/FieldUpdated.vue').default);
Vue.component('account-updated', require('./components/admin/AccountUpdated.vue').default);
Vue.component('users', require('./components/admin/user/Users.vue').default);
Vue.component('user-deactivated', require('./components/admin/user/UserDeactivated.vue').default);
Vue.component('user-activated', require('./components/admin/user/UserActivated.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
