<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center card-title">{{ $root.getPageTitle() }}</h3>
                        <div class="text-center">
                            <form method="POST" class="js-submit-form text-right" :action="$root.api_url + '/contact'" data-clear-onsuccess="true">
                                <div class="form-group">
                                    <label for="name">نام شما</label>
                                    <input id="name" name="name" type="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">ایمیل شما</label>
                                    <input id="email" type="email" class="form-control" name="email" data-required>
                                </div>
                                <div class="form-group">
                                    <label for="text">متن</label>
                                    <textarea name="text" id="text" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <g-recaptcha></g-recaptcha>
                                    <button type="submit" class="btn btn-primary btn-block">پیام من رو بفرست</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$root.setPageTitle('ارتباط با دیتی');
            // this.$root.initializeCaptcha();
        }
    }
</script>
