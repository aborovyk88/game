require('./bootstrap');

import VueRouter from "vue-router";
import routes from './routers/routes_game';

Vue.use(VueRouter);

const router = new VueRouter({
    routes
});


new Vue({
    router
}).$mount('#game-container');