require('./bootstrap');

Vue.component('user_list', require('./components/UserList.vue'));

new Vue({
    el: '#user-list-container'
});