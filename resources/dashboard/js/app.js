
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import Multiselect from 'vue-multiselect';
import BootstrapVue from 'bootstrap-vue';
import Notifications from 'vue-notification';
import Pagination from 'laravel-vue-pagination';

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(Notifications);

Vue.component('main-layout', require('./components/layouts/Main.vue').default);
Vue.component('Pagination', Pagination);
// Vue.directive('b-card', require('bootstrap-vue/es/components/card/card').default);

// Vue.component('b-modal', require('bootstrap-vue/em/components/modal/modal').default);
// Vue.directive('b-modal', require('bootstrap-vue/em/directives/modal/modal').default);

Vue.component('multiselect', Multiselect);

const router = new VueRouter({
    mode: 'history',
    routes
});

window.Vue = new Vue({
    el: '#app',
    router,
    data: {
        base_url: document.head.querySelector('meta[name="base-url"]').content,
        api_url : document.head.querySelector('meta[name="api-url"]').content,
        root_url : document.head.querySelector('meta[name="root-url"]').content,
        user: null,
        isInitializing: true,
        footerStack: []
    },
    mounted() {
        $.get(this.api_url + '/profile', (response) => {
            if (response.status == 1) {
                this.user = response.data.user;
            }
            this.initTemplate();
        }).always(() => {
            this.isInitializing = false;
        });

        this.setPosition();
        $(window).resize(this.setPosition);
    },
    methods: {
        setPosition() {
            $(".main-content").css({
                minHeight: $(window).outerHeight() - 100
            });
        },
        isEmptyObject(object) {
            return $.isEmptyObject(object);
        },
        postUrl(post) {
            return this.root_url + '/p/' + post.hash_id;
        },
        isAuthenticated() {
            return this.user !== null;
        },
        isAdmin() {
            return this.isAuthenticated() && this.user.level == 5;
        },
        redirectIfAuthenticated() {
            if (this.isAuthenticated()) {
                this.$router.push({ name: 'dashboard.index'});

                return true;
            }
            return false;
        },
        toggleModal(modal) {
            this.$emit('bv::toggle::modal', modal, '#btnToggle');
        },
        updateTable(table) {
            setTimeout(() => {
                this.$emit('bv::refresh::table', table);
            }, 50);
        },
        redirectToLogin() {
            this.$router.push({ name: 'dashboard.login' });
        },
        redirectTo(to) {
            this.$router.push({ name: 'dashboard.' + to });
        },
        setPageTitle(title) {
            document.title = title;
        },
        initTemplate() {
            setTimeout(() => {
                window.initTemplate();
            }, 100);
        }
    }
});
