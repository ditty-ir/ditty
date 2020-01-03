<template>
    <div class="graybg pt-3 pb-1">
        <div class="container">
            <div class="listrecent">
                <div>
                    <h3 title="related articles" class="mb-3 text-center">مطالب مرتبط</h3>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 related-post" v-for="post in related">
                        <div class="row">
                            <div class="col-2 pl-2">
                                <post-link :post="post" v-on:click="getItems()">
                                    <div class="thumbnail-background rounded" :style="{ backgroundImage: 'url('+ post.cover_image +')' }"></div>
                                </post-link>
                            </div>
                            <div class="col-10 pr-0">
                                <post-link class="font-weight-bold text-dark" :post="post">{{ post.title }}</post-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
        export default {
            props: ['post_id'],
            data() {
                return {
                    related: []
                }
            },
            mounted() {
                this.getItems();
            },
            methods: {
                getItems() {
                    let id = this.$props.post_id;

                    $.get(this.$root.base_url + '/api/v1/posts/' + id + '/related', (response) => {
                        if (response.status == 1) {
                            this.related = response.data;
                        }
                    });
                }
            },
            watch: {
                '$props.post_id': function() {
                    this.getItems();
                }
            }
        }
</script>