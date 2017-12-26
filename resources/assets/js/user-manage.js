require('./bootstrap');

import VueRouter from "vue-router";
import routes from './routers/routes_user';

Vue.use(VueRouter);

const router = new VueRouter({
    // mode: 'history',
    routes
});

new Vue({
    router
}).$mount('#user-manage-container');