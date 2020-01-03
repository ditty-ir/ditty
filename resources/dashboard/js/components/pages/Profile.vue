<template>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <b-card title="ویرایش پروفایل">
                <form method="POST" class="js-submit-form" :action="$root.api_url + '/profile'" data-on-success="profileUpdated">
                    <div class="form-group">
                        <label for="name">نام و نام خانوادگی</label>
                        <input id="name" type="text" class="form-control" name="name" :value="$root.user.name" data-required>
                    </div>
                    <div class="form-group">
                        <label for="username">نام کاربری</label>
                        <input id="username" type="text" class="form-control" name="username" :value="$root.user.username" data-required>
                    </div>
                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input id="email" type="email" class="form-control" name="email" :value="$root.user.email" data-required>
                    </div>
                    <div class="form-group">
                        <label for="credentials">درباره کوچولو (زیر اسم)</label>
                        <input id="credentials" type="text" class="form-control" name="credentials" :value="$root.user.credentials">
                    </div>
                    <div class="form-group">
                        <label>شبکه‌های اجتماعی</label>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <input type="url" name="social_urls[github]" class="form-control" :value="$root.user.social_urls.github" placeholder="گیت هاب">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="url" name="social_urls[linkedin]" class="form-control" :value="$root.user.social_urls.linkedin" placeholder="لینکدین">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="url" name="social_urls[instagram]" class="form-control" :value="$root.user.social_urls.instagram" placeholder="اینستاگرام">
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="url" name="social_urls[telegram]" class="form-control" :value="$root.user.social_urls.telegram" placeholder="تلگرام">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="biography">بیوگرافی</label>
                        <textarea id="biography" class="form-control" name="biography" :value="$root.user.biography"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="avatar">آواتار</label>
                        <div>
                            <input id="avatar" type="file" name="avatar">
                        </div>
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
            </b-card>
        </div>
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

        this.$root.setPageTitle('پروفایل');

        if (! window.profileUpdated) {
            window.profileUpdated = (response) => {
                if (response.status == 1) {
                    if (response.data.token) {
                        Cookies.set('authorization', 'Bearer ' + response.data.token, { expires: 30});
                    }
                    this.$root.$set(this.$root, 'user', response.data.user);
                    window.success_notification(response.message);
                }
            }
        }
    }
}
</script>


