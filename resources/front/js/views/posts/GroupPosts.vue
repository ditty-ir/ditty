<template>
    <div>
        <section v-for="group, title in groups" :key="title" class="listrecent mb-5 mt-5">
            <div class="section-title text-right">
                <h2><span>{{ title }}</span></h2>
            </div>
            <div class="group-posts">
                <div v-for="post in group" class="group-posts-item">
                    <blog-item-style6 :key="post.hash_id" :data="post"/>
                </div>
            </div>
        </section>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                groups: []
            }
        },
        mounted() {
            $.get(this.$root.base_url + '/api/v1/widgets/group-posts', (response) => {
                if (response.status == 1) {
                    let groupPosts = response.data;
                    for (let k in groupPosts) {
                        groupPosts[k] = groupPosts[k].reverse();
                    }
                    this.groups = groupPosts;

                    setTimeout(function() {
                        $('.group-posts').slick({
                            infinite: false,
                            autoplay: true,
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            rtl: true,
                            prevArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                            nextArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                            speed: 500,
                            responsive: [
                                {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                    }
                                },
                                {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1
                                    }
                                }
                            ]
                        });
                    }, 150);
                }
            });
        }
    }
</script>