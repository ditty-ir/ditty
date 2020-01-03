<template>
    <div class="graybg">
        <div class="container">
            <div class="listrecent">
                <div class="row">
                    <div class="col-md-4 mb-3" v-for="post in related">
                        <blog-item-style6 :key="post.hash_id" :data="post" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
        export default {
            props: ['post_id'],
            components: {
                blogItemStyle6: require("../elements/blog-items/blog-item-style6").default,
            },
            data() {
                return {
                    related: []
                }
            },
            mounted() {
                let id = this.$props.post_id;
                $.get(this.$root.base_url + '/api/v1/posts/' + id + '/related', (response) => {
                    if (response.status == 1) {
                        this.related = response.data;
                    }
                });
            }
        }
</script>