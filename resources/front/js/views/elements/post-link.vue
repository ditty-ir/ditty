<template>
    <router-link :to="{ name: 'posts.single', params: { id: post.hash_id, slug: (post.slug ? post.slug : post.title) } }">
        <slot></slot>
    </router-link>
</template>

<script>
    export default {
        props: ['post'],
    }
</script>
