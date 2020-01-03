<template>
    <div class="container">

        <section class="recent-posts">
            <div class="section-title text-right">
                <h2>
                    <span>آخرین مطالب</span>
                </h2>
            </div>
            <div class="listrecent">
                <div class="row">
                    <div class="col-md-4 mb-3" v-for="post of posts.items.data" :key="post.hash_id">
                        <blog-item-style6 :data="post" />
                    </div>
                </div>
            </div>
        </section>
        <pagination :data="posts.items" @pagination-change-page="loadPosts"></pagination>
    </div>
</template>

<script>
    import HttpRequest from '../../app/Classes/HttpRequest';

    export default {
        data() {
            return {
                posts: {
                    items: []
                },
            };
        },
        components: {
            // blogItemStyle1: require("../elements/blog-items/blog-item-style1").default,
            // blogItemStyle2: require("../elements/blog-items/blog-item-style2").default,
            // blogItemStyle3: require("../elements/blog-items/blog-item-style3").default,
            // blogItemStyle4: require("../elements/blog-items/blog-item-style4").default,
            // blogItemStyle5: require("../elements/blog-items/blog-item-style5").default
        },
        mounted() {
            this.$root.setPageTitle('آخرین مطالب');
            this.loadPosts();
        },
        methods: {
            loadPosts: function(page = 1) {
                $.get(this.$root.api_url + '/posts?page=' + page, (response) => {
                    if (response.status == 1) {
                        this.posts.items = response.data;
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                });
            }
        }
    }
</script>
