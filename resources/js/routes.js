import NotFound from './components/NotFound';
import Main from './views/Main';

export default {
    mode: 'history',

    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            component: Main
        },
    ]
}
