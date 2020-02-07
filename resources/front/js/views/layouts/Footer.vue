<template>
    <div class="container footer">
        <p class="float-right">
            ساخته شده با
            <a href="https://fa.wikipedia.org/wiki/%D8%B9%D8%B4%D9%82" target="_blank" class="text-red">عشق</a>
            در
            <a href="https://github.com/shetabit" target="_blank">گروه برنامه نویسی شتاب</a>
        </p>
        <div class="float-left">
            <a href="https://t.me/ditty_ir" target="_blank" class="color-tg ml-3"><i class="icon-telegram"></i></a>
            <!-- <router-link :to="{ name: 'contact' }" class="text-primary ml-3"><i class="fa fa-phone"></i></router-link> -->
            <a :href="$root.base_url + '/feed'" class="text-warning"><i class="fa fa-rss"></i></a>
        </div>
        <div class="clearfix"></div>
    </div>
</template>

<script>
    export default {

    }
</script>
