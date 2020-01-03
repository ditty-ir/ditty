<template>
    <div>
        <hr>
        <p class="text-muted small">درباره نویسنده</p>
        <div class="mb-5">
            <div class="media">
                <div class="media-right">
                    <avatar :user="author" />
                </div>
                <div class="media-body">
                    <h4>{{ author.name }}</h4>
                    <p class="author-description text-justify">{{ author.biography }}</p>
                    <div class="social-urls mt-2">
                        <a class="ml-2" :href="url" target="_blank" v-for="(url, item) in author.social_urls" v-if="url">
                            <img :src="$root.base_url + '/images/social_icon-' + item + '.png'">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['author']
    }
</script>