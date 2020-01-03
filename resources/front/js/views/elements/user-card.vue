<template>

    <div class="row post-top-meta">
        <div class="col-md-12">
            <author-link :author="user">
                <avatar :user="user"></avatar>
            </author-link>
            <author-link :author="user">
                <span class="link-dark">{{ user.name }}</span>
            </author-link>
            <p class="author-description">{{ user.credentials }}</p>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['user'],
    }
</script>

<style scoped>

</style>
