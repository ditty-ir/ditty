<template>
    <div>
        <nav class="topnav navbar navbar-expand-lg navbar-light fixed-top bg-white">
            <div class="container position-relative">
                <router-link class="navbar-brand p-0 nav-hider" :to="{ name: 'index' }">
                    <strong>{{ $root.document.appName }}</strong>
                </router-link>
                <div class="ml-4 mt-1 l-0 position-absolute search-button">
                    <i
                        class="fa fa-search"
                        data-toggle="collapse"
                        href="#search-box"
                        aria-expanded="false"
                        aria-controls="search-box"
                    ></i>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse" id="main-navbar">
                    <ul class="navbar-nav pr-0 ml-auto d-flex align-items-center mr-3">
                        <li class="nav-item nav-hider">
                            <router-link class="nav-link py-0" :to="{ name: 'posts.index' }">
                                <span>جدیدترین ها</span>
                            </router-link>
                        </li>
                        <li v-for="item in categories" class="nav-item nav-hider">
                            <router-link class="nav-link py-0" :to="{ name: 'categories.index', params: { id: item.id, slug: $root.str_slug(item.title) } }">
                                <span>{{ item.title }}</span>
                            </router-link>
                        </li>
                    </ul>
                    <nav class="navbar navbar-expand-lg main-navbar p-0 ml-5">
                        <ul class="navbar-nav navbar-right mr-auto p-0" v-if="$root.user">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="nav-link py-0 dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="d-inline-block small align-middle">سلام {{ $root.user.name }}</div>
                                    <div class="d-inline-block align-middle">
                                        <avatar :user="$root.user" class="author-thumb-xs align-middle"></avatar>
                                    </div>
                                </a>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <div class="dropdown-item has-icon">
                                    <author-link :author="$root.user" class="clearfix nav-hider">
                                        <span class="float-right align-middle">پروفایل</span>
                                        <i class="fas fa-user float-left"></i>
                                    </author-link>
                                </div>
                                <div class="dropdown-item has-icon text-danger clearfix nav-hider" @click="logout">
                                    <span class="float-right">خروج</span>
                                    <i class="fas fa-sign-out-alt float-left"></i>
                                </div>
                            </div>
                            </li>
                        </ul>
                        <div v-else>
                            <router-link class="small nav-hider" :to="{ name: 'login' }">ورود</router-link>
                            <span class="text-light small"> | </span>
                            <router-link class="small nav-hider" :to="{ name: 'register' }">ثبت نام</router-link>
                        </div>
                    </nav>
                </div>
            </div>
        </nav>
        <div class="fixed-top mt-5">
            <div id="search-box" class="collapse bg-light">
                <div class="container p-2">
                    <div class="gcse-search"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HttpRequest from '../../app/Classes/HttpRequest';

    export default {
        data() {
            return {
                categories: [],
            }
        },
        mounted() {
            this.getCategories();

            $('#search-box').on('show.bs.collapse', function () {
                setTimeout(function() {
                    $('input.gsc-input').focus();
                }, 100);
            });
        },
        methods: {
            getCategories() {
                let request = new HttpRequest('/api/v1/categories/in-home');
                request.send(
                    (result) => this.categories = result.data
                );
            },
            logout() {
                var root = this.$root;
                Cookies.remove('authorization');
                $.ajaxSetup({
                    headers: null,
                });
                this.$root.$set(this.$root, 'user', null);
                this.$root.redirectToLogin();

                $.post(root.api_url + '/logout');
            },
        }
    };
</script>