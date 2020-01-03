<template>
    <div class="authorpostbox">
        <div class="card text-right">
            <post-link :post="data">
                <img class="img-thumb img-fluid" :src="data.cover_image" alt="">
            </post-link>

            <div class="card-block p-3">
                <h2 class="card-title">
                    <post-link :post="data">{{ data.title }}</post-link>
                </h2>
                <h4 class="card-text">{{ data.brief_text }}</h4>
                <div class="metafooter">
                    <div class="wrapfooter">
                        <span class="meta-footer-thumb">
                            <author-link :author="data.user">
                                <avatar :user="data.user" />
                            </author-link>
                        </span>
                        <span class="author-meta">
                            <span class="post-name">
                                <author-link :author="data.user">{{ data.user.name }}</author-link>
                            </span>
                            <br/>
                            <span class="post-date">{{ data.j_created_at }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['data']
    }
</script>

<style scoped>

</style>
