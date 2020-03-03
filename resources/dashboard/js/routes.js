
export default [
    {
        path: '/dashboard',
        component: require('./components/pages/Index.vue').default,
        name: 'dashboard.index'
    },
    {
        path: '/dashboard/login',
        component: require('./components/pages/Login.vue').default,
        name: 'dashboard.login'
    },
    {
        path: '/dashboard/register',
        component: require('./components/pages/Register.vue').default,
        name: 'dashboard.register'
    },
    {
        path: '/dashboard/register-author',
        component: require('./components/pages/RegisterAuthor.vue').default,
        name: 'dashboard.register-author'
    },
    {
        path: '/dashboard/posts',
        component: require('./components/pages/posts/Index.vue').default,
        name: 'dashboard.posts.index'
    },
    {
        path: '/dashboard/posts/create',
        component: require('./components/pages/posts/Create.vue').default,
        name: 'dashboard.posts.create'
    },
    {
        path: '/dashboard/posts/:post_id/edit',
        component: require('./components/pages/posts/Edit.vue').default,
        name: 'dashboard.posts.edit'
    },
    {
        path: '/dashboard/categories',
        component: require('./components/pages/Categories.vue').default,
        name: 'dashboard.categories'
    },
    {
        path: '/dashboard/comments',
        component: require('./components/pages/Comments.vue').default,
        name: 'dashboard.comments'
    },
    {
        path: '/dashboard/users',
        component: require('./components/pages/Users.vue').default,
        name: 'dashboard.users'
    },
    {
        path: '/dashboard/series',
        component: require('./components/pages/Series.vue').default,
        name: 'dashboard.series'
    },
    {
        path: '/dashboard/profile',
        component: require('./components/pages/Profile.vue').default,
        name: 'dashboard.profile'
    },
    {
        path: '/dashboard/pages',
        component: require('./components/pages/Pages.vue').default,
        name: 'dashboard.pages'
    },
    {
        path: '/dashboard/group-posts',
        component: require('./components/widgets/group_posts/Index.vue').default,
        name: 'dashboard.widgets.group_posts'
    }
];