<template>
    <div>
        <div class="main-wrapper main-wrapper-1">
            <navbar />
            <sidebar />
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>عنوان صفحه</h1>
                    </div>
                </section>
                <slot></slot>
            </div>
            <footer-layout />
            <notifications group="general" />
        </div>
    </div>
</template>


<script>

import navbar from './Navbar.vue';
import sidebar from './Sidebar.vue';
import footerLayout from './Footer.vue';

export default {
    components: {
        navbar, sidebar, footerLayout
    },
    beforeCreate() {
        this.$root.setPageTitle('داشبورد');
    }
}
</script>

