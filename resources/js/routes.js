import NotFound from './components/NotFound';

export default {
    mode: 'history',

    routes: [
        {
            path: '*',
            component: NotFound
        },
    ]
}
