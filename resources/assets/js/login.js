require('./bootstrap');

Vue.component('login', require('./components/User/Login.vue'));

new Vue({
    el: '#login-container'
});