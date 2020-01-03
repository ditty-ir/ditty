<template>
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>4<span>0</span>4</h1>
            </div>
            <h2>صفحه مورد نظر یافت نشد</h2>
            <router-link :to="{ name: 'index' }">برو به صفحه اول</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$root.setPageTitle('404');
            window.httpCode = 200;
        }
    }
</script>

<style scoped>
    #notfound {
        position: relative;
        height: 100vh;
        background: #f6f6f6;
    }

    #notfound .notfound {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .notfound {
        max-width: 767px;
        width: 100%;
        line-height: 1.4;
        padding: 110px 40px;
        text-align: center;
        background: #fff;
        -webkit-box-shadow: 0 15px 15px -10px rgba(0, 0, 0, 0.1);
        box-shadow: 0 15px 15px -10px rgba(0, 0, 0, 0.1);
    }

    .notfound .notfound-404 {
        position: relative;
        height: 180px;
    }

    .notfound .notfound-404 h1 {
        /* font-family: 'Roboto', sans-serif; */
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        font-size: 165px;
        font-weight: 700;
        margin: 0px;
        color: #262626;
        text-transform: uppercase;
    }

    .notfound .notfound-404 h1>span {
        color: #00b7ff;
    }

    .notfound h2 {
        /* font-family: 'Roboto', sans-serif; */
        font-size: 22px;
        font-weight: 400;
        text-transform: uppercase;
        color: #151515;
        margin-top: 0px;
        margin-bottom: 25px;
    }

    @media only screen and (max-width: 767px) {
        .notfound h2 {
            font-size: 18px;
        }
    }

    @media only screen and (max-width: 480px) {
        .notfound .notfound-404 h1 {
            font-size: 141px;
        }
    }
</style>
