$(document).ready(function() {
    $('body').on('submit', '.js-submit-form', function() {
        var formData = new FormData($(this)[0]);
        var this_obj = $(this);
        var method = $(this).attr('method');
        $(this).find('.errors,.success, .text-danger').remove();

        var empty_inputs = $(this).find('[data-required]').filter(function() {
            return $(this).val() == null || $(this).val() == '';
        });

        if (empty_inputs.length == 0) {
            if ($(this).hasClass('auto-submit')) {
                return true;
            } else {
                $(this).find('.text-danger').remove();

                // if (method == 'post' && $(this_obj).find('input[name="_token"]').length == 0) {
                //     formData.append('_token', App.token);
                // }

                $.ajax({
                    'url': $(this).attr('action'),
                    'data': formData,
                    'type': method,
                    'processData': false,
                    'cache': false,
                    'contentType': false,
                    'success': function(data) {
                        if (typeof $(this_obj).attr('data-on-success') != 'undefined') {
                            var callBackFunction = $(this_obj).attr('data-on-success');
                            window[callBackFunction](data);
                        } else if (data.message) {
                            $(this_obj).prepend('<div class="success alert alert-success form-group alert-dismissable">' + data.message + '</div>');
                        }

                        if (typeof $(this_obj).attr('data-clear-onsuccess') != 'undefined') {
                            $(this_obj).find('input:not([name="_token"]):not([name="_method"]), textarea').val('');
                        }
                    },
                    'beforeSend': function() {
                        // $(this_obj).find('.errors,.success').remove();
                        $(this_obj).find('input, button, select, textarea').prop('disabled', true);
                    },
                    'complete': function() {
                        $(this_obj).find('input, button, select, textarea').prop('disabled', false);
                    },
                    'error': function(data, _status, xhr) {
                        if (xhr.status == 503) {
                            show_notification('error', 'خطایی رخ داد. لطفا دوباره تلاش کنید');
                            return;
                        }
                        if (typeof data.responseJSON != 'undefined') {
                            var errors = data.responseJSON.errors;
                            if (errors) {
                                $(this_obj).prepend('<div class="errors alert alert-danger form-group alert-dismissable"><ul></ul></div>');

                                $.each(errors, function(k) {
                                    for (var i = 0; i < errors[k].length; i++) {
                                        $(this_obj).find('.errors ul').append('<li>' + errors[k][i] + '</li>');
                                    }
                                });
                            }
                            else {
                                if (data.responseJSON.error) {
                                    show_notification('error', data.responseJSON.error);
                                } else {
                                    show_notification('error', 'خطایی رخ داد. لطفا ورودی‌ها را چک و دوباره تلاش کنید');
                                }
                            }
                        }
                    }
                });
            }
        } else {
            $(empty_inputs).each(function() {
                if ($(this).next('p.text-danger').length == 0) {
                    $(this).after('<p class="small text-danger">لطفا این ورودی را تکمیل کنید</p>');
                }
            });
        }

        return false;
    });

    $('nav.navbar').on('click', '.nav-hider', function() {
        $('#main-navbar').collapse('hide');
    });
});


window.renderScripts = () => {
    $('.article-post').find('div.code').each(function() {
        var iframe = document.createElement('iframe');
        $(this).append(iframe);
        $(iframe).on('load', function() {
            this.height = "";
            this.height = this.contentWindow.document.body.scrollHeight + "px";
        });

        // $(this).addClass('embed-responsive embed-responsive-16by9');
        // iframe.width  = iframe.contentWindow.document.body.scrollWidth;
        // iframe.height = iframe.contentWindow.document.body.scrollHeight;

        var doc = iframe.contentWindow.document;
        doc.open();
        doc.write('<script src="' + $(this).attr('title') + '.js">\x3C/script>');
        doc.close();
    });
}

window.highlightSyntaxes = () => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightBlock(block);
        hljs.lineNumbersBlock(block);
    });
}


window.addMeta = (attributeTitle, attributeValue, content) => {
    var meta = document.createElement('meta');
    meta[attributeTitle] = attributeValue;
    meta.content = content;
    document.getElementsByTagName('head')[0].appendChild(meta);
}


window.show_notification = function(type, message) {
    window.Vue.$notify({
        group: 'general',
        title: '',
        position: 'bottom left',
        duration: 30000,
        text: message
    });
}

window.success_notification = function(message) {
    window.Vue.$notify({
        group: 'general',
        title: '',
        position: 'bottom left',
        type: 'success',
        duration: 30000,
        text: message
    });
}


String.prototype.limit = function(limit) {
    if (this.length > limit) {
        return this.substr(0, limit) + '...'
    }

    return this;
}