$(document).ready(function() {
    $('body').on('submit', '.js-submit-form', function() {
        var this_obj = $(this);
        var method = $(this).attr('method');
        var formData = method.toUpperCase() == 'POST' ? (new FormData($(this)[0])) : $(this).serialize();
        $(this).find('.errors, .success, .text-danger').remove();

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
});



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


window.clone = function(obj) {
    return JSON.parse( JSON.stringify( obj ) );
  }


Array.prototype.update = function(id, data) {
    for (var i = 0; i < this.length; i++) {
        if (this[i].id == id) {
            this[i] = data;
            break;
        }
    }

    return this;
}

Array.prototype.delete = function(id) {
    return this.filter(item => item.id !== id);
}

String.prototype.limit = function(limit) {
    return this.length > limit ? (this.substr(0, limit) + '...') : this;
}