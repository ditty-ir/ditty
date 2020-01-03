<template>
    <div class="container">

        <section class="recent-posts">
            <div class="section-title text-right">
                <h2>
                    <span>{{ $root.getPageTitle() }}</span>
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
        mounted() {
            this.getCategory();
        },
        methods: {
            getCategory() {
                let category_id = this.$route.params.id;
                let request = new HttpRequest('/api/v1/categories/' + category_id);
                request.send(
                    (response) => {
                        this.category = response.data;
                        this.$root.setPageTitle('دسته بندی: ' + response.data.title);
                        this.loadPosts();
                    }
                );
            },
            loadPosts(page = 1) {
                let category_id = this.$route.params.id;

                $.get(this.$root.api_url + '/posts?category_id=' + category_id + '&page=' + page, (response) => {
                    if (response.status == 1) {
                        this.posts.items = response.data;
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                });
            }
        },
        watch: {
            '$route.params.id': function() {
                this.getCategory();
            }
        }
    }
</script>
