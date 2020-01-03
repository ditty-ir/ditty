<template>
    <div>
        <div class="form-group">
            <button v-b-modal.new-group class="btn btn-success">ثبت گروه جدید</button>
        </div>

        <b-table id="posts" :items="items" class="mt-5 bg-white" :fields="table_fields">
            <template slot="edit" slot-scope="data">
                <button class="btn btn-primary" v-on:click="editGroup(data.index)"><i class="fa fa-edit"></i></button>
            </template>
            <template slot="delete" slot-scope="data">
                <button class="btn btn-danger" v-on:click="deleteGroup(data.index)">×</button>
            </template>
            <template slot="type" slot-scope="data">
                {{ data.item.type == 'tag' ? 'برچسب' : 'دسته‌بندی' }}
            </template>
        </b-table>

        <b-modal id="new-group" title="ثبت گروه جدید" hide-footer>
            <form method="POST" class="js-submit-form" :action="path" data-on-success="groupCreated">
                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input id="title" type="text" class="form-control" name="title" data-required>
                </div>
                <div class="form-group">
                    <label for="type">نوع</label>
                    <select id="type" class="form-control" name="type" v-model="type" data-required>
                        <option value="tag">برچسب</option>
                        <option value="category">دسته‌بندی</option>
                    </select>
                </div>
                <div class="form-group" v-if="type == 'category'">
                    <label for="categories">دسته‌بندی ها</label>
                    <select name="value" id="categories" class="form-control" data-required>
                        <option :value="category.id" v-for="category in categories">{{ category.title }}</option>
                    </select>
                </div>
                <div class="form-group" v-if="type == 'tag'">
                    <label for="tag">برچسب</label>
                    <input id="tag" type="text" name="value" class="form-control" data-required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">ثبت</button>
                </div>
            </form>
        </b-modal>

        <b-modal id="edit-group" title="ویرایش" hide-footer>
            <div v-if="! $root.isEmptyObject(edit)">
                <form method="POST" class="js-submit-form" :action="path + '/' + edit.id" data-on-success="groupUpdated">
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input id="title" type="text" class="form-control" name="title" v-model="edit.title" data-required>
                    </div>
                    <div class="form-group">
                        <label for="type">نوع</label>
                        <select id="type" class="form-control" name="type" v-model="edit.type" data-required>
                            <option value="tag">برچسب</option>
                            <option value="category">دسته‌بندی</option>
                        </select>
                    </div>
                    <div class="form-group" v-if="edit.type == 'category'">
                        <label for="categories">دسته‌بندی ها</label>
                        <select name="value" id="categories" class="form-control" v-model="edit.value" data-required>
                            <option :value="category.id" v-for="category in categories">{{ category.title }}</option>
                        </select>
                    </div>
                    <div class="form-group" v-if="edit.type == 'tag'">
                        <label for="tag">برچسب</label>
                        <input id="tag" type="text" name="value" class="form-control" v-model="edit.value" data-required>
                    </div>

                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                    </div>
                </form>
            </div>
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
                this.$root.redirectToLogin();
            }
            this.initializeFunctions();
            this.getCategories();
            this.loadItems();
        },
        data() {
            return {
                table_fields: [
                    {key: 'id', label: 'شناسه'},
                    {key: 'title', label: 'عنوان'},
                    {key: 'type', label: 'نوع'},
                    {key: 'value', label: 'مقدار'},
                    {key: 'edit', label: 'ویرایش'},
                    {key: 'delete', label: 'حذف'}
                ],
                edit: {},
                items: [],
                functionsInitialized: false,
                categories: [],
                type: null,
                path: this.$root.api_url + '/widgets/group-posts'
            }
        },
        methods: {
            loadItems() {
                $.get(this.path, (response) => {
                    if (response.status == 1) {
                        this.items = response.data;
                    }
                });
            },
            getCategories() {
                $.get(this.$root.api_url + '/categories', (response) => {
                    if (response.status == 1) {
                        this.categories = response.data;
                    }
                });
            },
            editGroup(index) {
                var item = window.clone(this.items[index]);
                item.index = index;
                this.edit = item;
                this.$root.$emit('bv::toggle::modal', 'edit-group', '#btnToggle');
            },
            deleteGroup(index) {
                if (confirm('خذف شود')) {
                    $.post(this.path + '/' +  this.items[index].id, {_method: 'delete'}, (response) => {
                        if (response.status == 1) {
                            this.$root.$delete(this.items, index);
                            window.success_notification('حذف شد');
                        }
                    });
                }
            },
            initializeFunctions() {
                if (! this.functionsInitialized) {
                    window.groupCreated = (response) => {
                        if (response.status == 1) {
                            this.items.push(response.data);
                            this.$root.toggleModal('new-group');
                            window.success_notification('اضافه شد :)');
                        }
                    }
                    window.groupUpdated = (response) => {
                        if (response.status == 1) {
                            this.$root.$set(this.items, this.edit.index, response.data);
                            window.success_notification('ویرایش با موفقیت انجام شد');
                            this.$root.toggleModal('edit-group');
                        }
                    }
                }
            }
        },
    }
</script>