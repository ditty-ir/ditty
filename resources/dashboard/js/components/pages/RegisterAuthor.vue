<template>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <b-card title="ثبت نام">
                <form method="POST" class="js-submit-form" :action="$root.api_url + '/register'" data-on-success="successfullRegsiter">
                    <div class="form-group">
                        <label for="name">نام و نام خانوادگی</label>
                        <input id="name" type="text" class="form-control" name="name" data-required>
                    </div>

                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input id="email" type="email" class="form-control" name="email" data-required>
                    </div>

                    <div class="form-group">
                        <label for="username">نام کاربری</label>
                        <input id="username" type="text" class="form-control" name="username" data-required>
                    </div>

                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <input id="password" name="password" type="password" class="form-control" data-required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">تکرار کلمه عبور</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" data-required>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="agree" class="custom-control-input" id="agree" data-required>
                            <label class="custom-control-label" for="agree">با شرایط و قوانین موافقت میکنم</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">ثبت نام</button>
                    </div>
                </form>
            </b-card>
        </div>
    </div>
</template>



<script>
    export default {
        beforeCreate() {
            if (! this.$root.isAuthenticated()) {
                return this.$root.redirectToLogin();
            }
        },
        mounted() {
            if (! this.$root.isAuthenticated()) {
                return this.$root.redirectToLogin();
            }

            this.$root.setPageTitle('ثبت نام');

            if (! window.successfullRegsiter) {
                var root = this;

                window.successfullRegsiter = function(response) {
                    if (response.status == 1) {
                        window.success_notification(response.message);
                    }
                }
            }
        }
    }
</script>
