import List from './components/User/UserList.vue';
import Create from './components/User/UserCreate.vue';
import Update from './components/User/UserUpdate.vue';

module.exports = [
    {
        path: '/',
        name: 'listUsers',
        component: List
    },
    {
        name: 'createUser',
        path: '/create-manage',
        component: Create
    },
    {
        name: 'updateUser',
        path: '/profile-manage/:id',
        component: Update
    }
];