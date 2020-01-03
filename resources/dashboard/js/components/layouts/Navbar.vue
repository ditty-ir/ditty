<template>
    <div>
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <ul class="navbar-nav navbar-right mr-auto" v-if="! $root.isEmptyObject($root.user)">
                <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <!-- <img alt="image" src="../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"> -->
                <div class="d-sm-none d-lg-inline-block">سلام {{ $root.user.name }}</div></a>
                <div class="dropdown-menu dropdown-menu-right text-right">
                    <div class="dropdown-item has-icon text-danger" @click="logout">
                        <span>خروج</span>
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                </div>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        mounted() {
            // console.log('Component mounted.')
        },
        methods: {
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
    }
</script>
