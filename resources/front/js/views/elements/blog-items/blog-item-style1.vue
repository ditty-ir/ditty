<template>
    <div class="card border-0 mb-4 box-shadow h-xl-300 rtl">
        <div class="cover" :style="{ backgroundImage: 'url(' + data.cover_image + ')' }"></div>
        <div class="card-body px-0 pb-0 d-flex flex-column align-items-start text-right">
            <h2 class="h4 font-weight-bold">
                <router-link class="text-dark" :to="{ name: 'posts.single', params: { hash_id: data.hash_id, slug: (data.slug ? data.slug : data.title) } }">
                    {{ data.title }}
                </router-link>
            </h2>
            <p class="card-text">
                {{ data.brief_text }}
            </p>
            <div>
                <small class="d-block">
                    <author-link :author="data.user">
                        <span class="text-muted">{{ data.user.name }}</span>
                    </author-link>
                </small>
                <small class="text-muted">۱۲ اردیبهشت ۹۷ · ۵ دقیقه</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        mounted() {
            console.log(this.data);
        }
    }
</script>

<style scoped>
    .cover {
        height: 150px;
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>
