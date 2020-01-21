<template>
    <div :data-sitekey="site_key" class="g-recaptcha form-group"></div>
</template>

<script>
    export default {
        created() {
            let recaptcha = document.createElement('script');
            recaptcha.setAttribute('src', "https://www.google.com/recaptcha/api.js?");
            document.head.appendChild(recaptcha);
        },
        computed: {
            site_key: function() {
                return document.head.querySelector('meta[name="g-recaptcha-site_key"]').content;
            }
        }
    }
</script>