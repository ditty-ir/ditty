try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js').default;
    require('bootstrap');
    require('jquery.nicescroll');
    window.moment = require('moment');
    window.Cookies = require('js-cookie');
} catch (e) {
    console.log(e);
}



$.ajaxSetup({
    headers: {'Authorization': Cookies.get('authorization')}
});

// require('../js/template/stisla.js');
require('../js/template/scripts.js');
require('../js/template/custom.js');