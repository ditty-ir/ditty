
/**
 * web routes
 */

export default [
    {
        path: '/',
        component: require('./views/index').default,
        name: 'index',
    },
    {
        path: '/login',
        component: require('./views/auth/Login').default,
        name: 'login',
    },
    {
        path: '/register',
        component: require('./views/auth/Register').default,
        name: 'register',
    },

    // posts

    {
        path: '/posts',
        component: require('./views/posts/Index').default,
        name: 'posts.index',
    },
    {
        path: '/posts/:slug/:id',
        component: require('./views/posts/Single').default,
        name: 'posts.single',
        props: true
    },
    {
        path: '/@:username',
        component: require('./views/author/Index').default,
        name: 'author.index',
        props: true
    },
    {
        path: '/:path',
        component: require('./views/posts/Single').default,
        props: true
    },
    {
        path: '/preview/:id',
        component: require('./views/posts/Single').default,
        name: 'posts.preview',
        props: true
    },
    {
        path: '/tags/:tag',
        component: require('./views/posts/Tags').default,
        name: 'tags.index',
        props: true
    },

    // categories

    {
        path: '/categories/:id/:slug?',
        component: require('./views/posts/Categories').default,
        name: 'categories.index'
    },
    // error pages

    {
        path: '/404',
        component: require('./views/404').default,
        alias: '*',
        name: '404'
    },
];
