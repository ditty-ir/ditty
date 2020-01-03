<template>
    <router-link :to="{ name: 'author.index', params: { username: author.username} }">
        <slot></slot>
    </router-link>
</template>

<script>
    export default {
        props: ['author'],
    }
</script>
