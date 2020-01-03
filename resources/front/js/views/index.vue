<template>
    <div class="container">
        <!-- we will use these sections in near future!

        <div class="row">
            <div class="col-lg-6">
                <blog-item-style1 :data="post"/>
            </div>
            <div class="col-lg-6">
                <div class="flex-md-row mb-4 box-shadow h-xl-300 rtl text-right">
                    <blog-item-style2 :data="post"/>
                    <blog-item-style2 :data="post"/>
                    <blog-item-style2 :data="post"/>
                </div>
            </div>
        </div>


        <div class="row justify-content-between text-right rtl">
            <div class="col-md-8">
                <h5 class="font-weight-bold spanborder">
                    <span>جدیدترین نوشته ها</span>
                </h5>
                <blog-item-style3 :data="post" />
            </div>
            <div class="col-md-4 pr-4">
                <h5 class="font-weight-bold spanborder">
                    <span>محبوب ترین ها</span>
                </h5>
                <ol class="list-featured px-0">
                    <li>
                        <blog-item-style4 :data="post" />
                    </li>
                    <li>
                        <blog-item-style4 :data="post" />
                    </li>
                </ol>
            </div>
        </div>
    -->
        <section class="featured-posts">
            <div class="section-title text-right">
                <h2><span>مطالب داغ</span></h2>
            </div>
            <div class="listfeaturedtag">
                <div class="row">
                    <div class="col-md-6" v-for="(post, index) of featured" :key="post.hash_id">
                        <blog-item-style5 :data="post" />
                    </div>
                </div>
            </div>
        </section>

        <group-posts></group-posts>
        <br>

        <div class="latest-items-container">
            <div class="row">
                <div class="col-md-8">
                    <section class="recent-posts">
                        <div class="section-title text-right">
                            <h2><span>آخرین مطالب</span></h2>
                        </div>
                        <div class="listrecent">
                            <div class="row">
                                <div class="col-md-6 mb-3" v-for="post of posts.data" :key="post.hash_id" >
                                    <blog-item-style6 :data="post" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <router-link class="btn btn-default border w-100" :to="{ name: 'posts.index' }">
                                <span>همه پست‌ها</span>
                            </router-link>
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <latest-comments></latest-comments>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import HttpRequest from '../app/Classes/HttpRequest';

    export default {
        data() {
            return {
                posts: [],
                featured: []
            };
        },
        components: {
            // blogItemStyle1: require("./elements/blog-items/blog-item-style1").default,
            // blogItemStyle2: require("./elements/blog-items/blog-item-style2").default,
            // blogItemStyle3: require("./elements/blog-items/blog-item-style3").default,
            // blogItemStyle4: require("./elements/blog-items/blog-item-style4").default,
            groupPosts: require("./posts/GroupPosts.vue").default,
            LatestComments: require("./elements/latest-comments.vue").default,
        },
        mounted() {
            this.$root.setPageTitle('دیتــی');
            this.getPosts();
            this.featuredPosts();
        },
        methods: {
            getPosts() {
                let request = new HttpRequest('/api/v1/posts/home');
                request.send(
                    (result) => this.posts = result.data
                );
            },
            featuredPosts() {
                $.get(this.$root.api_url + '/posts/featured-posts', (response) => {
                    if (response.status == 1) {
                        this.featured = response.data;
                    }
                });
            }
        }
    }
</script>
