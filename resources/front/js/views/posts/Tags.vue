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
                    <div class="col-md-4 mb-3" v-for="post of posts.data" :key="post.hash_id">
                        <blog-item-style6 :data="post" />
                    </div>
                </div>

            </div>
        </section>

    </div>
</template>

<script>
    import HttpRequest from '../../app/Classes/HttpRequest';

    export default {
        data() {
            return {
                posts: [],
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
            let tag = this.$route.params.tag;
            this.$root.setPageTitle('برچسب‌: ' + tag);
            this.getPosts();

        },
        methods: {
            getPosts() {
                let tag = this.$route.params.tag;
                let request = new HttpRequest('/api/v1/tags/' + tag);

                request.send(
                    (result) => this.posts = result.data
                );
            }
        }
    }
</script>
