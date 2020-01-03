<template>

    <span>
        <h6 class="font-weight-bold">
            <router-link class="text-dark" :to="{ name: 'posts.single', params: { hash_id: data.hash_id, slug: (data.slug ? data.slug : data.title) } }">
                {{ data.title }}
            </router-link>
        </h6>
        <p class="text-muted">
            <span>{{ data.user.name }}</span>
        </p>
    </span>

</template>

<script>
    export default {
        props: ['data']
    }
</script>
