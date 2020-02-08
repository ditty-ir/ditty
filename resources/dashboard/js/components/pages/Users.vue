<template>
    <div>
        <b-table
            id="users"
            :items="users.items"
            class="mt-5 bg-white"
            :fields="table_fields"
        >
            <template v-slot:cell(edit)="data">
                <button class="btn btn-primary" v-on:click="editUser(data.index)"><i class="fa fa-edit"></i></button>
            </template>
            <template v-slot:cell(delete)="data">
                <button class="btn btn-danger" v-on:click="deleteUser(data.item.id)">×</button>
            </template>
        </b-table>

        <b-modal id="edit-user" title="ویرایش نظر" hide-footer>
            <div v-if="! $root.isEmptyObject(users.edit)">
                <form method="POST" class="js-submit-form" :action="$root.api_url + '/users/' + users.edit.id" data-on-success="userUpdated">
                    <div class="form-group">
                        <label for="name">نام و نام خانوادگی</label>
                        <input id="name" type="text" class="form-control" name="name" :value="users.edit.name" data-required>
                    </div>
                    <div class="form-group">
                        <label for="username">نام کاربری</label>
                        <input id="username" type="text" class="form-control" name="username" :value="users.edit.username" data-required>
                    </div>
                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input id="email" type="email" class="form-control" name="email" :value="users.edit.email" data-required>
                    </div>
                    <div class="form-group">
                        <label for="credentials">درباره کوچولو (زیر اسم)</label>
                        <input id="credentials" type="text" class="form-control" name="credentials" :value="users.edit.credentials">
                    </div>
                    <div class="form-group">
                        <label>شبکه‌های اجتماعی</label>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <input type="url" name="social_urls[github]" class="form-control" :value="users.edit.social_urls.github" placeholder="گیت هاب">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="url" name="social_urls[linkedin]" class="form-control" :value="users.edit.social_urls.linkedin" placeholder="لینکدین">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="url" name="social_urls[instagram]" class="form-control" :value="users.edit.social_urls.instagram" placeholder="اینستاگرام">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="url" name="social_urls[telegram]" class="form-control" :value="users.edit.social_urls.telegram" placeholder="تلگرام">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="biography">بیوگرافی</label>
                        <textarea id="biography" class="form-control" name="biography" :value="users.edit.biography"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="avatar">آواتار</label>
                        <div>
                            <input id="avatar" type="file" name="avatar">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="level">سطح</label>
                        <select name="level" id="level" class="form-control" v-model="users.edit.level">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <input id="password" type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">تکرار رمز عبور</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">ویرایش</button>
                    </div>
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
    },
    data() {
        return {
            functionsInitialized: false,
            users: {
                items: [],
                edit: {}
            },
            table_fields: [
                { key: 'id', label: 'شناسه' },
                { key: 'name', label: 'نام' },
                { key: 'username', label: 'نام کاربری' },
                { key: 'email', label: 'ایمیل' },
                // { key: 'status', label: 'وضعیت' },
                { key: 'level', label: 'سطح' },
                { key: 'created_at', label: 'ایجاد شده' },
                { key: 'edit', label: 'ویرایش' },
                // { key: 'delete', label: 'حذف' },
            ]
        }
    },
    methods: {
        loadItems: function() {
            $.get(this.$root.api_url + '/users', (response) => {
                if (response.status == 1) {
                    this.users.items = response.data;
                }
            });
        },
        editUser(index) {
            var user = window.clone(this.users.items[index]);
            user.index = index;
            this.users.edit = user;
            this.$root.$emit('bv::toggle::modal', 'edit-user', '#btnToggle');
        },
        deleteUser(id) {
            if (confirm('کاربر حذف شود؟')) {
                $.post(this.$root.api_url + '/users/' + id, { _method: 'delete' }, (response) => {
                    if (response.status == 1) {
                        this.users.items = this.users.items.delete(id);
                        this.users.edit = {};
                        window.success_notification(response.message);
                    }
                });
            }
        },
        initializeFunctions() {
            if (! this.functionsInitialized) {
                window.userUpdated = (response) => {
                    if (response.status == 1) {
                        this.$root.$set(this.users.items, this.users.edit.index, response.data.user);
                        window.success_notification(response.message);
                        this.$root.toggleModal('edit-user');
                        this.$root.updateTable('users');
                    }
                }
            }
        }
    }
}
</script>


