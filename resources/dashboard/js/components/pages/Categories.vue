<template>
    <div>
        <div class="form-group">
            <button v-b-modal.new-category class="btn btn-success">ثبت دسته‌بندی</button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <b-card title="دسته‌بندی ها">
                    <multiselect v-model="categories.selected" :options="categories.items" placeholder="دسته‌بندی ها" label="title" track-by="title" @input="showCategory"></multiselect>
                </b-card>
            </div>
            <div class="col-md-6">
                <b-card v-if="! $root.isEmptyObject(categories.edit)" :title="'دسته بندی:' + categories.edit.title">
                    <form method="POST" class="js-submit-form" :action="$root.api_url + '/categories/' + categories.edit.id" data-on-success="categoryUpdated">
                        <div class="form-group">
                            <label for="edit-title">عنوان</label>
                            <input id="edit-title" type="text" class="form-control" name="title" v-model="categories.edit.title" data-required>
                        </div>
                        <div class="form-group">
                            <input id="edit-in_home_page" type="checkbox" name="in_home_page" v-model="categories.edit.in_home_page">
                            <label for="edit-in_home_page">نمایش در صفحه اصلی</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right">ویرایش</button>
                            <button type="button" class="btn btn-danger float-left" v-on:click="deleteCategory(categories.edit.id)">حذف</button>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" name="_method" value="PUT">
                    </form>
                </b-card>
            </div>
        </div>

        <b-modal id="new-category" title="ثبت دسته‌بندی" hide-footer>
            <form method="POST" class="js-submit-form" :action="$root.api_url + '/categories'" data-on-success="categoryCreated">
                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input id="title" type="text" class="form-control" name="title" data-required>
                </div>
                <div class="form-group">
                    <input id="in_home_page" type="checkbox" name="in_home_page">
                    <label for="in_home_page">نمایش در صفحه اصلی</label>
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
            categories: {
                selected: null,
                items: [],
                edit: {}
            }
        }
    },
    methods: {
        loadItems: function() {
            $.get(this.$root.api_url + '/categories', (response) => {
                if (response.status == 1) {
                    this.categories.items = response.data;
                }
            });
        },
        showCategory(item) {
            this.categories.edit = window.clone(item);
        },
        deleteCategory(id) {
            $.post(this.$root.api_url + '/categories/' + id, {_method: 'delete'}, (response) => {
                if (response.status == 1) {
                    this.categories.items = this.categories.items.delete(id);
                    this.categories.selected = null;
                    this.categories.edit = {};
                    window.success_notification(response.message);
                }
            });
        },
        initializeFunctions() {
            if (! this.functionsInitialized) {
                window.categoryCreated = (response) => {
                    if (response.status == 1) {
                        this.categories.items.push(response.data);
                        this.$root.toggleModal();
                        window.success_notification(response.message);
                    }
                }
                window.categoryUpdated = (response) => {
                    if (response.status == 1) {
                        this.categories.items = this.categories.items.update(response.data.id, response.data);
                        this.categories.selected = response.data;
                        window.show_notification('', response.message);
                    }
                }
            }
        }
    }
}
</script>


