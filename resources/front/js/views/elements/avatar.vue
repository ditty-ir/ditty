<template>
    <img class="author-thumb" :src="$root.base_url + '/assets/images/avatars/' + user.avatar + '.jpg'" v-if="user.avatar">
    <img class="author-thumb" :src="$root.base_url + '/images/default-avatar.jpg'" v-else>
</template>

<script>
    export default {
        props: ['user'],
    }
</script>
