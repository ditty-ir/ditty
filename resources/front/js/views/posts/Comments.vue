<template>
    <div id="post-comments" class="container">
        <div class="mx-auto col-md-8 py-3">
            <h3>نظرات ({{ $props.post.comments_count }})</h3>
            <section v-if="items.length > 0">
                <hr>
                <div class="mt-3 media border-bottom border-light comment" v-for="item in items">
                    <avatar :user="item.user ? item.user : {}" />
                    <div class="media-body">
                        <div class="small">
                            <author-link v-if="item.user" :author="item.user">{{ item.user.name }}</author-link>
                            <span class="text-muted font-italic" v-else>{{ item.name }}</span>
                            <span v-if="item.user" class="text-muted font-consolas"> - {{ item.user.username }}@</span>
                            <!-- <span class="text-muted">{{ item.created_at }}</span> -->
                        </div>
                        <div>
                            <p class="text pr-1 mt-1">{{ item.text }}</p>
                        </div>
                    </div>
                </div>
            </section>
            <button class="btn btn-link d-block mt-3 mx-auto" v-if="$props.post.comments_count > 0 && ! loaded" @click="loadComments">نمایش نظرات</button>

            <form :action="$root.api_url + '/posts/' + post_id + '/comments'" method="post" class="js-submit-form mt-3" data-clear-onsuccess="true">
                <textarea class="form-control" name="text" rows="5" maxlength="1000" placeholder="نوبت نظر شماست :) اینجا بنویسید ..." data-required></textarea>
                <div v-if="! $root.isAuthenticated()" class="mt-2">
                    <div class="row">
                        <div class="col-6 pl-1">
                            <input type="text" name="name" class="form-control" placeholder="نام">
                        </div>
                        <div class="col-6 pr-1">
                            <input type="email" name="email" class="form-control" placeholder="ایمیل" data-required>
                        </div>
                    </div>
                    <div data-sitekey="6Lfiu7QUAAAAACc-NypXepF1qaSvQzzW0Ef2vwEA" class="g-recaptcha mt-2"></div>
                </div>
                <button class="btn btn-success mt-1 btn-sm">ارسال</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['post'],
        data() {
            return {
                items: [],
                loaded: false,
            }
        },
        created() {
            if (! this.$root.isAuthenticated()) {
                let recaptcha = document.createElement('script');
                recaptcha.setAttribute('src', "https://www.google.com/recaptcha/api.js?");
                document.head.appendChild(recaptcha);
            }
        },
        computed: {
            post_id: function() {
                return this.$route.params.id
            }
        },
        methods: {
            loadComments() {
                this.loaded = true;

                $.get(this.$root.api_url + '/posts/' + this.post_id + '/comments', (response) => {
                    if (response.status == 1) {
                        this.items = response.data;
                    }

                });
            }
        }
    }
</script>