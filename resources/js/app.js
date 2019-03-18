// import axios from 'axios';
// import VueAxios from 'vue-axios';

//require('bootstrap');
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

// let token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//   window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//   console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }

window.Vue = require("vue");
import Echo from 'laravel-echo';
window.io = require('socket.io-client');
window.socket = io('http://localhost:3000');
// window.Pusher = require('pusher-js');
// Vue.use(VueAxios, axios);
import Autentifications from './components/AuthComponent';
import Login from './components/LoginComponent';
import Register  from './components/RegisterComponent';
import Chat  from './components/ChatComponent';
import Profile  from './components/ProfilComponent';
import Main  from './components/MainComponent';
import Menu  from './components/MenuComponent';
import News  from './components/NewsComponent';

// window.Echo = new Echo({
//   broadcaster:'socket.io',
//   host: window.location.hostname + ':6001'
// });

Vue.component('app', require('./components/App'));
Vue.component('profile', Profile);
Vue.component('prop-component', require('./components/Index'));
Vue.component('json-component', require('./components/jsonComponent'));
Vue.component('menul', Menu);
Vue.component('news', News);
Vue.component('main_page', Main);
Vue.component('autentification', Autentifications);
Vue.component('chat', Chat);
Vue.component('login', Login);
Vue.component('register', Register);

new Vue({
  el: "#app",
});


// $_SESSION["user_id"] = $id;
//
// view('index', controller);
