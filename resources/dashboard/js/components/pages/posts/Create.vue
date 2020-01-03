<template>
    <div>
        <b-card title="پست جدید">
            <form id="create-post" :action="$root.api_url + '/posts'" method="POST" class="js-submit-form" data-on-success="postCreated">
                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input id="title" type="text" name="title" class="form-control" data-required>
                </div>
                <div class="form-group">
                    <label for="slug">اسلاگ</label>
                    <input id="slug" type="text" name="slug" class="dir-ltr text-left form-control">
                </div>
                <div class="form-group">
                    <label for="brief-text">توضیح کوتاه</label>
                    <textarea id="brief-text" name="brief_text" class="form-control"></textarea>
                </div>
                <div class="row form-group z-index-501">
                    <div class="col-md-6">
                        <label for="category">دسته بندی</label>
                        <multiselect id="category" v-model="new_post.cateogry" :options="categories" placeholder="دسته بندی" label="title" track-by="title"></multiselect>
                        <input type="hidden" id="category-id" name="category_id" v-model="new_post.cateogry.id">
                    </div>
                    <div class="col-md-6">
                        <label for="tags">برچسب ها</label>
                        <tags-input element-id="tags"></tags-input>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text">متن</label>
                    <textarea name="text" id="text"></textarea>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="cover_image">تصویر کاور</label><br>
                        <input id="cover_image" type="file" name="cover_image">
                    </div>
                    <div class="col-md-6">
                        <label for="status">وضعیت</label>
                        <select name="status" id="status" class="form-control">
                            <option v-for="(status, status_id) in post_statuses" :value="status_id">{{ status.title }}</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix">
                    <button class="float-right btn btn-success">ثبت</button>
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
            new_post: {
                cateogry: {}
            },
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
        this.$root.setPageTitle('پست جدید');
        this.loadCategories();
        this.loadDraft();
        CKEDITOR.replace('text');

        this.saveDraft();
    },
    methods: {
        initializeFunctions() {
            if (! this.functionsInitialized) {
                window.postCreated = (response) => {
                    if (response.status == 1) {
                        window.success_notification(response.message);
                        this.$router.push({name: 'dashboard.posts.edit', params: { post_id: response.data.hash_id } });
                    }
                }
            }
        },
        loadDraft() {
            $.get(this.$root.api_url + '/posts/get-draft', (response) => {
                if (response.status == 1 && response.data != null) {
                    $('#title').val(response.data.title);
                    $('#brief-text').val(response.data.brief_text);
                    $('#slug').val(response.data.slug);

                    setTimeout(() => {
                        CKEDITOR.instances['text'].setData(response.data.text);
                    }, 100);
                }
            });
        },
        loadCategories() {
            $.get(this.$root.api_url + '/categories', (response) => {
                if (response.status == 1) {
                    this.categories = response.data;
                }
            });
        },
        saveDraft() {
            window.postDraftInterval = setInterval(() => {
                var data = {
                    title: $('#title').val(),
                    brief_text: $('#brief-text').val(),
                    text: CKEDITOR.instances['text'].getData(),
                    slug: $('#slug').val(),
                    tags: $('#tags').val(),
                    category_id: $('#category-id').val(),
                }

                $.post(this.$root.api_url + '/posts/save-draft', { data });
            }, 15000);
        }
    },
    beforeRouteLeave(to, from, next) {
        window.clearInterval(window.postDraftInterval);

        if (typeof CKEDITOR.instances['text'] != 'undefined' && CKEDITOR.instances['text'].getData().length > 0) {
            if (confirm('Unsaved data! Continue?')) {
                next();
            }
        } else {
            next();
        }
    }
}
</script>


