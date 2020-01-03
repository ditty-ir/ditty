<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center card-title">ورود</h3>
                        <div class="text-center">
                            <form method="POST" class="js-submit-form text-right" :action="$root.api_url + '/login'" data-on-success="successfullLogin">
                                <div class="form-group">
                                    <label for="email">ایمیل</label>
                                    <input id="email" type="email" class="form-control" name="email" data-required>
                                </div>

                                <div class="form-group">
                                    <label for="password">رمز عبور</label>
                                    <input id="password" name="password" type="password" class="form-control" data-required>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                                        <label class="custom-control-label" for="remember">به یاد داشتن</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">ورود</button>
                                </div>
                            </form>
                        </div>
                        <router-link class="small" :to="{ name: 'register' }">ثبت نام؟</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </template>

    <script>
        export default {
            mounted() {
                if (this.$root.redirectIfAuthenticated()) {
                    return;
                }
                this.$root.setPageTitle('ورود');
                if (! window.successfullLogin) {
                    window.successfullLogin = (response) => {
                        if (response.status) {
                            Cookies.remove('authorization');

                            var token = 'Bearer ' + response.data.token;
                            Cookies.set('authorization', token, { expires: response.data.remember});

                            $.ajaxSetup({
                                headers: {Authorization: token}
                            });
                            this.$root.$set(this.$root, 'user', response.data.user);
                            this.$router.push({ name: 'index'});
                            // window.show_notification();
                        }
                    }
                }
            }
        }
    </script>