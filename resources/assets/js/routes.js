import Login from './components/Login.vue';
import Home from './components/Home.vue';
import Register from './components/Register.vue';
import Users from './components/UserList.vue';
import Game from './components/Game.vue';

module.exports = {
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/login',
            component: Login
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/users',
            component: Users,
            props: () => ({
                current_data: '',
                current_columns: '',
                current_page_count: ''
            })
        },
        {
            path: '/game',
            component: Game,
            props: () => ({
                user_id: ''
            })
        }
    ]
};