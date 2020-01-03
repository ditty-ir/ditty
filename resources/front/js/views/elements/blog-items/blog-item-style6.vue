<template>
    <div class="card">
        <post-link class="post-cover-image" :post="data">
            <img class="img-fluid" :src="data.cover_image" alt="">
        </post-link>
        <div class="card-block p-4">
            <h2 class="card-title text-right post-title">
                <post-link :post="data">{{ data.title }}</post-link>
            </h2>
            <p
                class="card-text text-justify post-brief-text"
                v-if="typeof data.brief_text == 'string' && $props.no_brief_text !== true"
                :title="data.brief_text"
            >{{ data.brief_text.limit(90) }}</p>
            <div class="metafooter clearfix">
                <div class="wrapfooter">
                    <div v-if="$props.no_user !== true">
                        <span class="meta-footer-thumb">
                            <author-link :author="data.user">
                                <avatar :user="data.user" />
                            </author-link>
                        </span>
                        <span class="author-meta">
                            <span v-if="data.user" class="post-name">
                                <author-link :author="data.user">{{ data.user.name }}</author-link>
                            </span>
                            <br>
                            <span class="post-date">{{ data.j_created_at }}</span>
                        </span>
                    </div>
                    <!-- <span class="post-read-more">
                        <a href="post.html" title="Read Story">
                            <svg class="svgIcon-use" width="25" height="25" viewBox="0 0 25 25">
                                <path d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z" fill-rule="evenodd"></path>
                            </svg>
                        </a>
                    </span> -->
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['data', 'no_brief_text', 'no_user']
    }
</script>

<style scoped>

</style>
