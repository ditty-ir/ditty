<template>

    <div class="mb-3 d-flex align-items-center">
        <img :src="data.cover_image" height="80">
        <div class="pr-3">
            <h2 class="mb-2 h6 font-weight-bold">
                <router-link class="text-dark" :to="{ name: 'posts.single', params: { hash_id: data.hash_id, slug: (data.slug ? data.slug : data.title) } }">
                    {{ data.title }}
                </router-link>
            </h2>
            <div class="card-text text-muted small">
                {{ data.user.name }}
            </div>
            <small class="text-muted">۱۲ اردیبهشت ۹۷ · ۵ دقیقه</small>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['data']
    }
</script>
