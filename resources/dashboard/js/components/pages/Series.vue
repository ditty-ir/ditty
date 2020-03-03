<template>
    <div>
        <div class="form-group">
            <button v-b-modal.new-item class="btn btn-success">ثبت سری</button>
        </div>

        <b-table
            id="series"
            :items="series.items"
            class="mt-5 bg-white"
            :fields="table_fields"
        >
            <template v-slot:cell(edit)="data">
                <button class="btn btn-primary" v-on:click="editItem(data.index)"><i class="fa fa-edit"></i></button>
            </template>
            <template v-slot:cell(delete)="data">
                <button class="btn btn-danger" v-on:click="deleteItem(data.item.id)">×</button>
            </template>
        </b-table>


        <b-modal id="new-item" title="ثبت سری" hide-footer size="lg">
            <form method="POST" class="js-submit-form" :action="$root.api_url + '/series'" data-on-success="itemCreated">
                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input id="title" type="text" class="form-control" name="title" data-required>
                </div>
                <div class="form-group">
                    <label for="post_ids">پست‌ها</label>
                    <multiselect :close-on-select="false" :clear-on-select="false" deselectLabel="" selectLabel="" selectedLabel="" v-model="series.new.selected_posts" :options="posts" :multiple="true" label="title" track-by="id" placeholder=""></multiselect>
                    <input type="hidden" name="post_ids[]" v-for="item in series.new.selected_posts" :value="item.id">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">ثبت</button>
                </div>
            </form>
        </b-modal>

        <b-modal id="edit-item" title="ویرایش سری" size="lg" hide-footer>
            <div v-if="! $root.isEmptyObject(series.edit)">
                <form method="POST" class="js-submit-form" :action="$root.api_url + '/series/' + series.edit.id" data-on-success="itemUpdated">
                    <div class="form-group">
                        <label for="edit-title">عنوان</label>
                        <input id="edit-title" type="text" class="form-control" name="title" v-model="series.edit.title" data-required>
                    </div>
                    <div class="form-group">
                        <label for="edit-post_ids">پست‌ها</label>
                        <multiselect :close-on-select="false" :clear-on-select="false" deselectLabel="" selectLabel="" selectedLabel="" v-model="series.edit.selected_posts" :options="posts" :multiple="true" label="title" track-by="id" placeholder=""></multiselect>
                        <input type="hidden" name="post_ids[]" v-for="item in series.edit.selected_posts" :value="item.id">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block">ویرایش</button>
                    <input type="hidden" name="_method" value="PUT">
                </form>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    beforeCreate() {
        if (! this.$root.isAdmin()) {
            this.$root.redirectTo('dashboard');
        }
    },
    mounted() {
        if (! this.$root.isAdmin()) {
            return this.$root.redirectTo('dashboard');
        }
        this.initializeFunctions();
        this.loadItems();
        this.loadPosts();
    },
    data() {
        return {
            functionsInitialized: false,
            posts: [],
            series: {
                items: [],
                new: {
                    selected_posts: []
                },
                edit: {}
            },
            table_fields: [
                { key: 'id', label: 'شناسه' },
                { key: 'title', label: 'عنوان' },
                { key: 'created_at', label: 'ایجاد شده' },
                { key: 'edit', label: 'ویرایش' },
                { key: 'delete', label: 'حذف' },
            ]
        }
    },
    computed: {

    },
    methods: {
        loadItems: function() {
            $.get(this.$root.api_url + '/series', (response) => {
                if (response.status == 1) {
                    this.series.items = response.data;
                }
            });
        },
        loadPosts: function() {
            $.get(this.$root.api_url + '/posts/published', (response) => {
                if (response.status == 1) {
                    this.posts = response.data;
                }
            });
        },
        editItem(index) {
            var item = window.clone(this.series.items[index]);
            item.index = index;
            this.series.edit = item;
            this.$root.$emit('bv::toggle::modal', 'edit-item', '#btnToggle');
        },
        deleteItem(id) {
            if (confirm('سری حذف شود؟')) {
                $.post(this.$root.api_url + '/series/' + id, { _method: 'delete' }, (response) => {
                    if (response.status == 1) {
                        this.series.items = this.series.items.delete(id);
                        this.series.edit = {};
                        window.success_notification(response.message);
                    }
                });
            }
        },
        initializeFunctions() {
            if (! this.functionsInitialized) {
                window.itemUpdated = (response) => {
                    if (response.status == 1) {
                        this.$root.$set(this.series.items, this.series.edit.index, response.data);
                        this.$root.toggleModal('edit-item');
                        this.$root.updateTable('series');
                        window.success_notification(response.message);
                    }
                }
                window.itemCreated = (response) => {
                        if (response.status == 1) {
                            this.series.items.push(response.data);
                            this.$root.toggleModal('new-item');
                            window.success_notification(response.message);
                        }
                    }
            }
        }
    }
}
</script>


