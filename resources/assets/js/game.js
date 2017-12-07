require('./bootstrap');
Vue.component('monster_game', require('./components/Game.vue'));

new Vue({
    el: '#game-container'
});