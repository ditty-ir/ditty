const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath('public_html/');

mix.js('resources/front/js/app.js', 'public_html/js/front')
   .sass('resources/front/sass/app.scss', 'public_html/css/front').version();;

mix.js('resources/dashboard/js/app.js', 'public_html/js/dashboard')
   .sass('resources/dashboard/sass/app.scss', 'public_html/css/dashboard').version();;