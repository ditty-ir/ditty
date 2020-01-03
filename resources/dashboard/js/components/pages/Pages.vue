<template>
    <div>
        <div class="form-group">
            <button v-b-modal.new-page class="btn btn-success">ثبت صفحه</button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b-card title="صفحات">
                    <multiselect v-model="pages.selected" :options="pages.items" placeholder="دسته‌بندی ها" label="title" track-by="title" @input="showPage"></multiselect>
                </b-card>
            </div>
            <div class="col-md-6">
                <b-card v-if="! $root.isEmptyObject(pages.edit)" :title="'صفحه:' + pages.edit.title">
                    <form method="POST" class="js-submit-form" :action="$root.api_url + '/pages/' + pages.edit.id" data-on-success="pageUpdated">
                        <div class="form-group">
                            <label for="edit-title">عنوان</label>
                            <input id="edit-title" type="text" class="form-control" name="title" :value="pages.edit.title" data-required>
                        </div>
                        <div class="form-group">
                            <label for="edit-path">مسیر</label>
                            <input id="edit-path" type="text" class="form-control" name="path" :value="pages.edit.path" data-required>
                        </div>
                        <div class="form-group">
                            <label for="edit-post_id">شناسه پست</label>
                            <input id="edit-post_id" type="text" class="form-control" name="post_id" :value="pages.edit.post_id" data-required>
                            <div class="mt-2">
                                <a target="_blank" :href="$root.root_url + '/preview/' + pages.edit.post.hash_id">{{ pages.edit.post.title }}</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right">ویرایش</button>
                            <button type="button" class="btn btn-danger float-left" v-on:click="deletePage(pages.edit.id)">حذف</button>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" name="_method" value="PUT">
                    </form>
                </b-card>
            </div>
        </div>

        <b-modal id="new-page" title="ثبت صفحه" hide-footer>
            <form method="POST" class="js-submit-form" :action="$root.api_url + '/pages'" data-on-success="pageCreated">
                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input id="title" type="text" class="form-control" name="title" data-required>
                </div>
                <div class="form-group">
                    <label for="path">مسیر</label>
                    <input id="path" type="text" class="form-control" name="path" data-required>
                </div>
                <div class="form-group">
                    <label for="post_id">شناسه پست</label>
                    <input id="post_id" type="text" class="form-control" name="post_id" data-required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">ثبت</button>
                </div>
            </form>
        </b-modal>
    </div>
</template>


<script>
    export default {
        beforeCreate() {
            if (! this.$root.isAuthenticated()) {
                this.$root.redirectToLogin();
            }
        },
        mounted() {
            if (! this.$root.isAuthenticated()) {
                return this.$root.redirectToLogin();
            }
            this.initializeFunctions();
            this.loadItems();
        },
        data() {
            return {
                functionsInitialized: false,
                pages: {
                    selected: null,
                    items: [],
                    edit: {}
                }
            }
        },
        methods: {
            loadItems: function() {
                $.get(this.$root.api_url + '/pages', (response) => {
                    if (response.status == 1) {
                        this.pages.items = response.data;
                    }
                });
            },
            showPage(item) {
                this.pages.edit = window.clone(item);
            },
            deletePage(id) {
                if (confirm('حذف میشه ها !')) {
                    $.post(this.$root.api_url + '/pages/' + id, { _method: 'delete' }, (response) => {
                        if (response.status == 1) {
                            this.pages.items = this.pages.items.delete(id);
                            this.pages.selected = null;
                            this.pages.edit = {};
                            window.success_notification(response.message);
                        }
                    });
                }
            },
            initializeFunctions() {
                if (! this.functionsInitialized) {
                    window.pageCreated = (response) => {
                        if (response.status == 1) {
                            this.pages.items.push(response.data);
                            this.$root.toggleModal('new-page');
                            window.success_notification(response.message);
                        }
                    }
                    window.pageUpdated = (response) => {
                        if (response.status == 1) {
                            this.pages.items = this.pages.items.update(response.data.id, response.data);
                            this.pages.edit = response.data;
                            this.pages.selected = response.data;
                            window.show_notification('', response.message);
                        }
                    }
                }
            }
        }
    }
</script>