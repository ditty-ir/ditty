<template>
    <div>
        <b-table
            id="comments"
            :items="comments.items.data"
            class="mt-5 bg-white table-bordered"
            :fields="table_fields"
        >
            <template slot="text" slot-scope="data">
                {{ data.item.text.limit(100) }}
            </template>
            <template slot="edit" slot-scope="data">
                <button class="btn btn-primary" v-on:click="editComment(data.index)"><i class="fa fa-edit"></i></button>
            </template>
            <template slot="delete" slot-scope="data">
                <button class="btn btn-danger" v-on:click="deleteComment(data.item.id)">×</button>
            </template>
            <template slot="status" slot-scope="data">
                <span :class="'badge badge-' + comment_statuses[data.item.status].color">{{ comment_statuses[data.item.status].title }}</span>
            </template>
            <template slot="post" slot-scope="data">
                <a
                    :href="$root.root_url + '/p/' + data.item.commentable.hash_id"
                    target="_blank"
                    :title="data.item.commentable.title"
                    >
                    {{ data.item.commentable.title.limit(50) }}
                </a>
            </template>
        </b-table>
        <pagination :data="comments.items" @pagination-change-page="loadItems"></pagination>

        <b-modal id="edit-comment" title="ویرایش نظر" hide-footer>
            <div v-if="! $root.isEmptyObject(comments.edit)">
                <form :action="$root.api_url + '/comments/' + comments.edit.id" method="POST" class="js-submit-form" data-on-success="commentUpdated">
                    <div class="form-group">
                        <label for="edit-text">متن</label>
                        <textarea id="edit-text" name="text" class="form-control" v-model="comments.edit.text"></textarea>
                    </div>
                    <div v-if="comments.edit.user" class="text-right">
                        <p><strong>کاربر: </strong>{{ comments.edit.user.name }}</p>
                    </div>
                    <div v-else>
                        <div class="form-group">
                            <label for="edit-name">نام</label>
                            <input id="edit-name" name="name" class="form-control" v-model="comments.edit.name">
                        </div>
                        <div class="form-group">
                            <label for="edit-email">ایمیل</label>
                            <input id="edit-email" name="email" class="form-control" v-model="comments.edit.email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-status">وضعیت</label>
                        <select name="status" id="edit-status" class="form-control" v-model="comments.edit.status">
                            <option v-for="(status, status_id) in comment_statuses" :value="status_id">{{ status.title }}</option>
                        </select>
                    </div>
                    <input type="hidden" name="_method" value="PUT">
                    <button class="btn btn-primary">ویرایش</button>
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
            return this.$root.redirectToLogin();
        }
        this.initializeFunctions();
        this.loadItems();
    },
    data() {
        return {
            functionsInitialized: false,
            comments: {
                items: [],
                edit: {}
            },
            table_fields: [
                { key: 'id', label: 'شناسه '},
                { key: 'post', label: 'پست '},
                // { key: 'name', label: 'نام '},
                // { key: 'email', label: 'ایمیل '},
                { key: 'text', label: 'متن '},
                { key: 'status', label: 'وضعیت '},
                { key: 'created_at', label: 'ایجاد شده '},
                { key: 'edit', label: 'ویرایش '},
                { key: 'delete', label: 'حذف' }
            ],
            comment_statuses: {
                1: {title: 'رد شده', color: 'light '},
                2: {title: 'در انتظار تایید', color: 'warning '},
                3: {title: 'تایید شده', color: 'success'}
            },
        }
    },
    methods: {
        loadItems: function(page = 1) {
            $.get(this.$root.api_url + '/comments?page=' + page, (response) => {
                if (response.status == 1) {
                    if (page > 1) {
                        $("html, body").animate({ scrollTop: $('table#comments').offset().top }, "slow");
                    }
                    this.comments.items = response.data;
                }
            });
        },
        editComment(index) {
            var comment = window.clone(this.comments.items.data[index]);
            comment.index = index;
            this.comments.edit = comment;
            this.$root.$emit('bv::toggle::modal', 'edit-comment', '#btnToggle');
        },
        deleteComment(id) {
            if (confirm('نظر حذف شود؟')) {
                $.post(this.$root.api_url + '/comments/' + id, {_method: 'delete'}, (response) => {
                    if (response.status == 1) {
                        this.comments.items.data = this.comments.items.data.delete(id);
                        this.comments.edit = {};
                        window.success_notification(response.message);
                    }
                });
            }
        },
        initializeFunctions() {
            if (! this.functionsInitialized) {
                window.commentUpdated = (response) => {
                    if (response.status == 1) {
                        this.comments.items.data = this.comments.items.data.update(response.data.id, response.data);
                        this.comments.selected = response.data;
                        window.success_notification(response.message);
                        this.$root.toggleModal('edit-comment');
                        this.$root.updateTable('comments');
                    }
                }
            }
        }
    }
}
</script>


