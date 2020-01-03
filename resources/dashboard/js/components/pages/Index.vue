<template>
    <div class="row" v-if="! $root.isEmptyObject(stats)">
        <div class="col-md-3">
            <div class="alert alert-success alert-has-icon">
                <div class="alert-icon"><i class="far fa-file-alt"></i></div>
                <div class="alert-body">
                    <div class="alert-title">{{ stats.posts }}</div>
                    پست منتشر شده
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="alert alert-info alert-has-icon">
                <div class="alert-icon"><i class="far fa-user"></i></div>
                <div class="alert-body">
                    <div class="alert-title">{{ stats.users }}</div>
                    کاربر
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="alert alert-warning alert-has-icon">
                <div class="alert-icon"><i class="far fa-comment"></i></div>
                <div class="alert-body">
                    <div class="alert-title">{{ stats.comments }}</div>
                    نظر تایید نشده
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    beforeCreate() {
        if (! this.$root.isAuthenticated()) {
            this.$root.redirectToLogin();
        }
    },
    mounted() {
        if (! this.$root.isAuthenticated()) {
            return this.$root.redirectToLogin();
        }

        this.loadStats();
    },
    data() {
        return {
            stats: {}
        }
    },
    methods: {
        loadStats: function() {
            $.get(this.$root.api_url + '/stats', (response) => {
                if (response.status == 1) {
                    this.stats = response.data;
                }
            });
        },
    }
}
</script>


