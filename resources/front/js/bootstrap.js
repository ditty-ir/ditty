
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    // require('es6-promise/auto');
    require('sticky-kit/dist/sticky-kit.js');

    window.hljs = require("highlight.js/lib/highlight.js");
    require('highlightjs-line-numbers.js');
    require('highlight.js/styles/gruvbox-light.css');
    // require('highlight.js/styles/gruvbox-dark.css');
    hljs.registerLanguage('sql', require('highlight.js/lib/languages/sql'));
    hljs.registerLanguage('html', require('highlight.js/lib/languages/xml'));
    hljs.registerLanguage('css', require('highlight.js/lib/languages/css'));
    hljs.registerLanguage('json', require('highlight.js/lib/languages/json'));
    hljs.registerLanguage('javascript', require('highlight.js/lib/languages/javascript'));
    hljs.registerLanguage('plaintext', require('highlight.js/lib/languages/plaintext'));
    hljs.registerLanguage('typescript', require('highlight.js/lib/languages/typescript'));
    hljs.registerLanguage('php', require('highlight.js/lib/languages/php'));

    require('./custom.js');
    window.Cookies = require('js-cookie');
    window.slick = require('slick-carousel');

} catch (e) {
    console.warn(e);
}


$.ajaxSetup({
    headers: {'Authorization': Cookies.get('authorization')}
});