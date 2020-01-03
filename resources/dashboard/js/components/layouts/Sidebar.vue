<template>
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="/">LARAVEL</a>
            </div>
          <ul class="sidebar-menu">
            <li class="menu-header">داشبورد</li>
            <li>
                <router-link :to="{ name: 'dashboard.index' }" v-if="$root.isAuthenticated()">
                    <i class="fas fa-fire"></i>داشبورد
                </router-link>
            </li>
            <li class="nav-link" v-if="! $root.isAuthenticated()">
                <router-link :to="{name: 'dashboard.register'}">ثبت نام</router-link>
            </li>
            <li class="nav-link" v-if="! $root.isAuthenticated()">
                <router-link :to="{name: 'dashboard.login'}">ورود</router-link>
            </li>

            <li class="dropdown" v-if="$root.isAuthenticated()">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-fire"></i><span>پست‌ها</span></a>
                <ul class="dropdown-menu">
                    <li><router-link class="nav-link" :to="{name: 'dashboard.posts.index'}">پست ها</router-link></li>
                    <li><router-link class="nav-link" :to="{name: 'dashboard.categories'}">دسته‌بندی ها</router-link></li>
                    <li><router-link class="nav-link" :to="{name: 'dashboard.comments'}" v-if="$root.isAdmin()">نظرات</router-link></li>
                    <li><router-link class="nav-link" :to="{name: 'dashboard.widgets.group_posts'}" v-if="$root.isAdmin()">پست‌های گروهی</router-link></li>
                    <li><router-link class="nav-link" :to="{name: 'dashboard.pages'}" v-if="$root.isAdmin()">صفحات</router-link></li>
                </ul>
            </li>
            <li><router-link :to="{ name: 'dashboard.users' }" v-if="$root.isAdmin()"><i class="fas fa-fire"></i>کاربران</router-link></li>
            <li><router-link :to="{ name: 'dashboard.profile' }" v-if="$root.isAuthenticated()"><i class="fas fa-fire"></i> پروفایل</router-link></li>
          </ul>


        </aside>
      </div>
</template>

<script>
    export default {
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
