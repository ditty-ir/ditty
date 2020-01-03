<template>
    <div>
        <section class="latest-comments">
            <div class="section-title text-right">
                <h2><span>آخرین نظرات</span></h2>
            </div>
            <div>
                <ul class="list-group mr-0 pr-0">
                    <li class="list-group-item" v-for="comment in comments">
                        <p class="small mb-1">
                            {{ comment.text.limit(100) }}
                        </p>
                        <span class="small font-italic text-muted">
                            {{ comment.user_id ? comment.user.name : (comment.name ? comment.name : 'ناشناس')  }}
                            در
                            <post-link :post="comment.commentable" :title="comment.commentable.title">{{ comment.commentable.title.limit(30) }}</post-link>
                        </span>
                    </li>
                </ul>
            </div>
        </section>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                comments: []
            }
        },
        mounted() {
            $.get(this.$root.api_url + '/comments/latest', (response) => {
                if (response.status == 1) {
                    this.comments = response.data;

                    if ($(window).width() > 768) {
                        $('section.latest-comments').stick_in_parent({
                            parent: '.latest-items-container',
                            offset_top: 100,
                        });
                    }
                }
            });
        }
    }
</script>