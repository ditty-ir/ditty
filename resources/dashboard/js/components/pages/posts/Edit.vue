<template>
    <div>
        <b-card title="ویرایش پست">
            <form v-if="! loading" :action="$root.api_url + '/posts/' + post.hash_id" method="POST" class="js-submit-form" data-on-success="postEdited">
                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input id="title" type="text" name="title" class="form-control" v-model="post.title" data-required>
                </div>
                <div class="form-group">
                    <label for="slug">اسلاگ</label>
                    <input id="slug" type="text" name="slug" class="dir-ltr text-left form-control" v-model="post.slug">
                </div>
                <div class="form-group">
                    <label for="brief-text">توضیح کوتاه</label>
                    <textarea id="brief-text" name="brief_text" class="form-control" v-model="post.brief_text"></textarea>
                </div>
                <div class="row form-group z-index-501">
                    <div class="col-md-6">
                        <label for="category">دسته بندی</label>
                        <multiselect id="category" v-model="post.category" :options="categories" placeholder="دسته بندی" label="title" track-by="title"></multiselect>
                        <input type="hidden" name="category_id" v-model="post.category.id">
                    </div>
                    <div class="col-md-6">
                        <label for="tags">برچسب ها</label>
                        <tags-input element-id="tags" v-model="post.tags"></tags-input>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text">متن</label>
                    <textarea id="text" name="text" :value="post.text"></textarea>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="cover_image">تصویر کاور</label><br>
                        <input id="cover_image" type="file" name="cover_image">
                    </div>
                    <div class="col-md-6">
                        <label for="status">وضعیت</label>
                        <select name="status" id="status" class="form-control" v-model="post.status">
                            <option v-for="(status, status_id) in post_statuses" :value="status_id">{{ status.title }}</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="_method" value="PUT">
                <div class="clearfix">
                    <button class="float-right btn btn-primary">ویرایش</button>
                    <a :href="'/preview/' + post.hash_id" target="_blank" class="float-left btn btn-default">پیش نمایش</a>
                </div>
            </form>
        </b-card>
    </div>
</template>

<script>

import VoerroTagsInput from '@voerro/vue-tagsinput';

export default {
    components: {
        'tags-input': VoerroTagsInput,

    },
    beforeCreate() {
        if (! this.$root.isAuthenticated()) {
            this.$root.redirectToLogin();
        }
    },
    data() {
        return {
            functionsInitialized: false,
            post: {},
            loading: true,
            categories: [],
            post_statuses: {
                1: {title: 'عدم انتشار', color: 'light'},
                2: {title: 'پیش نویس', color: 'warning'},
                3: {title: 'منتشر شده', color: 'success'}
            },
        }
    },
    mounted() {
        if (! this.$root.isAuthenticated()) {
            return this.$root.redirectToLogin();
        }

        this.initializeFunctions();
        this.$root.setPageTitle('ویرایش پست');
        this.loadCategories();
        this.loadPost();
    },
    methods: {
        initializeFunctions() {
            if (! this.functionsInitialized) {
                window.postEdited = (response) => {
                    if (response.status == 1) {
                        window.success_notification(response.message);
                        $('input#cover_image').val('');
                    }
                }
            }
        },
        loadCategories: function() {
            $.get(this.$root.api_url + '/categories', (response) => {
                if (response.status == 1) {
                    this.categories = response.data;
                }
            });
        },
        loadPost: function() {
            var post_id = this.$route.params.post_id;
            $.get(this.$root.api_url + '/posts/' + post_id, (response) => {
                if (response.status == 1) {
                    this.post = response.data;
                    this.loading = false;

                    setTimeout(() => {
                        if ($('#cke_text-contents').length == 0) {
                            CKEDITOR.replace('text');
                        } else {
                            CKEDITOR.instances['text'].setData(this.post.text);
                        }
                    }, 100);
                }
            });
        }
    },
    beforeRouteLeave(to, from, next) {
        if (confirm('Are you sure you want to leave?')) {
            next();
        }
    }
}
</script>


