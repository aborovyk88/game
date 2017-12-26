import Run from '../components/Game/GameRun.vue';
import List from '../components/Game/GameList.vue';

module.exports = [
    {
        name: 'runGame',
        path: '/',
        component: Run
    },
    {
        name: 'manageGame',
        path: '/game-manage',
        component: List
    }
];