window.fullresto = window.fullresto || {};

var notify = {SUCCESS: 'success', ERROR: 'error', INFO: '', DEFAULT: ''};
var messages = {
    SUCCESS: {

    }, 
    ERROR: {
        GENERIC: 'Oops! An unexpected error occurred. We are on it now...',
        RATING_RATED: 'Seems like you\'ve already sent your ratings',
        RATING_SELECT: 'Please select your ratings'
    },
    INFO: {
        CURRENT_VIEWING: '1 person is looking into this deal',
        CURRENT_VIEWINGS: '{0} people are looking into this deal',
        CURRENT_BOOKING: 'There is <strong>1</strong> booking made recently',
        CURRENT_BOOKINGS: 'There are <strong>{0}</strong> bookings made recently'
    }
};
var loading = "<div class='spin-loading'><span class='icon icon-spinner icon-spin'></span></div>";
var fb_app_id = 471191849723278;

(function(app){
    var fb_logged_in = false;
    var fb_response = null;
    var process = {
        register: function() {
            $('.register').html('Please wait...').attr('disabled', 'disabled');
            var jqxhr = $.post('register/auth', $('#frmfullresto').serialize(), function(data) {
                    if(data.status == '200') {
                        document.location = $('#call_reference').val();
                    } else if(typeof data.view != 'undefined') {
                        $('.register-pane').children().remove();
                        $('.register-pane').html(data.view);
                        fullresto.setup.login();
                    }
                }, 'json')
                .fail(function() {
                    fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                })
                .always(function() {
                    $('.register').html('Register').removeAttr('disabled');
                });
        },
        login: function() {
            $('.login-pane').find('.login').html('Please wait...').attr('disabled', 'disabled');
            var jqxhr = $.post('login/auth', $('#frmfullresto').serialize(), function(data) {
                    if(data.status == '200') {
                        document.location = $('#call_reference').val();
                    } else if(typeof data.view != 'undefined') {
                        $('.login-pane').children().remove();
                        $('.login-pane').html(data.view);
                        fullresto.setup.login();
                    }
                }, 'json')
                .fail(function() {
                    fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                })
                .always(function() {
                    $('.login-pane').find('.login').html('Login').removeAttr('disabled');
                });
        },
        login_book: function(modal, isConfirm) {
            $(modal).find('.login-message').addClass('hidden');
            $(modal).find('.login').html('Please wait...').attr('disabled', 'disabled');
            var jqxhr = $.post($(document.body).data('base') + 'login/auth-book', $(modal).find('#frmfullresto').serialize(), function(data) {
                    if(data.status == '200') {
                        fullresto.sys.init_head();
                        fullresto.process.deal_proceed(isConfirm);
                        modal.modal('hide');
                    } else if(typeof data.message != 'undefined') {
                        $(modal).find('.login-message').html(data.message).removeClass('hidden');
                    }
                }, 'json')
                .fail(function() {
                    fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                })
                .always(function() {
                    $(modal).find('.login').html('Login').removeAttr('disabled');
                });
        },
        fb_login: function() {
            FB.api('/me', function(response) {
                var fb_data = [];
                var cont = false;
                var email = ''
        		if(response.email) {
                    cont = true;
                    email = response.email;
                } else if(response.id && FB.getAuthResponse()['accessToken']) {
                    cont = true;
                    email = response.id + '@facebook.com';
                }
                if(cont) {
                    var first_name = typeof response.first_name != 'undefined' ? response.first_name : '';
                    var last_name = typeof response.last_name != 'undefined' ? response.last_name : '';
                    var street = city = state = country = zip = '';
                    if(typeof response.address != 'undefined') {
                        street = typeof response.address.street != 'undefined' ? response.address.street : '';
                        city = typeof response.address.city != 'undefined' ? response.address.city : '';
                        state = typeof response.address.state != 'undefined' ? response.address.state : '';
                        country = typeof response.address.country != 'undefined' ? response.address.country : '';
                        zip = typeof response.address.zip != 'undefined' ? response.address.zip : '';
                    }
                    var mobile_phone = typeof response.mobile_phone != 'undefined' ? response.mobile_phone : '';
                    var birthday = typeof response.birthday != 'undefined' ? response.birthday : '';
                    var gender = typeof response.gender != 'undefined' ? response.gender : '';
                    var link = typeof response.link != 'undefined' ? response.link : '';
                    fb_data.push({name: 'accessToken', value: FB.getAuthResponse()['accessToken']});
                    fb_data.push({name: 'id', value: response.id});
                    fb_data.push({name: 'email', value: email});
                    fb_data.push({name: 'first_name', value: first_name});
                    fb_data.push({name: 'last_name', value: last_name});
                    fb_data.push({name: 'address_street', value: street});
                    fb_data.push({name: 'address_city', value: city});
                    fb_data.push({name: 'address_state', value: state});
                    fb_data.push({name: 'address_country', value: country});
                    fb_data.push({name: 'address_zip', value: zip});
                    fb_data.push({name: 'mobile_phone', value: mobile_phone});
                    fb_data.push({name: 'birthday', value: birthday});
                    fb_data.push({name: 'gender', value: gender});
                    fb_data.push({name: 'link', value: link});
                    var jqxhr = $.post('facebook', $.param(fb_data), function(data) {
                            if(data.status == '200') {
                                document.location = $('#call_reference').val();
                            } else {
                                fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                            }
                        }, 'json')
                        .fail(function() {
                            fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                        });
                }
            });
        },
        set_deals: function() {
            $('[data-deal]').removeClass('active');
            $('#bookingdeal').val('');
            $('.panel-form .bookingdeal').removeClass('has-error').removeClass('has-success');
            $('.panel-form .bookingdeal .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
            var day = ($('#bookingdate').val() != '' ? new Date(Date.parse($('#bookingdate').val())).getUTCDay() : '');
            var pax = $('#bookingpax').val();
            var cd = new Date(), bd = new Date($('#bookingdate').val());
            var isToday = (cd.toDateString() === bd.toDateString() ? true : false);
            //0-sunday to 6-saturday
            //0-everyday, 1-monday, 2-tuesday, 3-wednesday, 4-thursday, 5-friday, 6-saturday, 7-sunday, 8-mwf, 9-tth, 10-weekends, 11-weekdays
            //TODO: If merchant allows today booking, check time
            $.each($('[data-deal]'), function(k, deal) {
                var d = parseInt($(deal).attr('data-day')), sp = parseInt($(deal).attr('data-spax')), ep = parseInt($(deal).attr('data-epax')), st = $(deal).attr('data-stime');
                if( (day === '' || (d==0 || 
                        (day==1 && (d==1 || d==8 || d==11)) || 
                        (day==2 && (d==2 || d==9 || d==11)) || 
                        (day==3 && (d==3 || d==8 || d==11)) || 
                        (day==4 && (d==4 || d==9 || d==11)) || 
                        (day==5 && (d==5 || d==8 || d==11)) || 
                        (day==6 && (d==6 || d==10)) || 
                        (day==0 && (d==7 || d==10)) )) && 
                    (pax == '' || (sp <= pax && pax <= ep) || (sp <= pax && ep === 0)) ) {
                    $(deal).show();
                    if(isToday) {
                        bd = new Date($('#bookingdate').val() + ' ' + st);
                        if( cd.getTime() > bd.getTime() || ((bd.getTime() - cd.getTime()) / 3600000) < 4) {
                            $(deal).hide();
                        }
                    }
                } else {
                    $(deal).hide();
                }
            });
        },
        check_deal: function(fld, val) {
            $('.panel-form .'+fld).removeClass('has-error').removeClass('has-success');
            $('.panel-form .'+fld+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
            var valErr = false;
            if($('#'+fld).hasClass('is-number') && isNaN(val)) valErr = true;
            if($('#'+fld).hasClass('is-email') && !fullresto.util.is_email(val)) valErr = true;
            if(val == '' || valErr) {
                $('.panel-form .'+fld).addClass('has-error');
                $('.panel-form .'+fld+' .form-control-feedback').addClass('glyphicon-remove');
                return false;
            } else {
                $('.panel-form .'+fld).addClass('has-success');
                $('.panel-form .'+fld+' .form-control-feedback').addClass('glyphicon-ok');
                if($('.panel-form .has-success').length >= 4) {
                    $('.bookingterms').removeClass('hidden');
                }
                return true;
            }
        },
        sample_menu: function(discount, discountType) {
            $('.discounted').html('&nbsp;<span class="badge">' + discount + '</span>');
            $('.regular-price').css('text-decoration','line-through');
            discount.replace('%', '');
            discount = 1 - (parseFloat(discount)/100);
            $('[data-price]').each(function(k, o) {
                $(this).html(' ' + ($(o).data('price') * discount).toFixed(2));
            });
        },
        deal: function(isConfirm) {
            var fields = ['bookingdate','bookingpax','guestname','guestemail','guestcontactnum'];
            var err = false, valErr = false;
            $('.panel-form .has-feedback').removeClass('has-error').removeClass('has-success');
            $('.panel-form .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
            $.each(fields, function(k, fld) {
                valErr = false;
                if($('#'+fld).hasClass('is-number') && isNaN($('#'+fld).val())) valErr = true;
                if($('#'+fld).hasClass('is-email') && !fullresto.util.is_email($('#'+fld).val())) valErr = true;
                if($('#'+fld).val() == '' || valErr) {
                    err = true;
                    $('.panel-form .'+fld).addClass('has-error');
                    $('.panel-form .'+fld+' .form-control-feedback').addClass('glyphicon-remove');
                } else {
                    $('.panel-form .'+fld).addClass('has-success');
                    $('.panel-form .'+fld+' .form-control-feedback').addClass('glyphicon-ok');
                }
            });
            if($('[data-opted-deal]').attr('data-opted-deal') == '') {
                err = true;
                $('.panel-form .bookingdeal').addClass('has-error');
                $('.panel-form .bookingdeal .form-control-feedback').addClass('glyphicon-remove');
            } else {
                $('.panel-form .bookingdeal').addClass('has-success');
                $('.panel-form .bookingdeal .form-control-feedback').addClass('glyphicon-ok');
            }
            if(err) {
                //TODO: Notify error
                $('.panel-final').hide();
                $('.panel-form').show();
                return false;
            }
            if($('[fullresto]').attr('fullresto') || fullresto.fb_logged_in) {
                fullresto.process.deal_proceed(isConfirm);
            } else {
                $('#booking-login-modal').on('show.bs.modal', function (event) {
                    var modal = $(this);
                    var btn = modal.find('#login');
                    btn.unbind('click').click(function(e) {
                        fullresto.process.login_book(modal, isConfirm);
                    });
                });

                $('#booking-login-modal').modal({backdrop:false}, $(this));
            }
        },
        deal_proceed: function(isConfirm) {
            if(typeof isConfirm != 'undefined' && isConfirm) {
                //TODO: Add preventive measures to counter robots
                $('.panel-process').removeClass('hidden');
                $('[data-btn=confirm]').html('Processing...');
                $('[data-btn=edit], [data-btn=confirm]').addClass('disabled');
                $('[data-btn=edit]').parent().hide();
                var data = [];
                data.push({name: 'date', value: $('#bookingdate').val()});
                data.push({name: 'pax', value: $('#bookingpax').val()});
                data.push({name: 'deal', value: $('[data-opted-deal]').attr('data-opted-deal')});
                data.push({name: 'name', value: $('#guestname').val()});
                data.push({name: 'email', value: $('#guestemail').val()});
                data.push({name: 'contactnum', value: $('#guestcontactnum').val()});
                data.push({name: 'promocode', value: $('#promotioncode').val()});
                if(fullresto.fb_logged_in) {
                    var cont = false;
                    var fb_email = ''
                    if(fullresto.fb_response.email) {
                        cont = true;
                        fb_email = fullresto.fb_response.email;
                    } else if(fullresto.fb_response.id && FB.getAuthResponse()['accessToken']) {
                        cont = true;
                        fb_email = fullresto.fb_response.id + '@facebook.com';
                    }
                    if(cont) {
                        var first_name = typeof fullresto.fb_response.first_name != 'undefined' ? fullresto.fb_response.first_name : '';
                        var last_name = typeof fullresto.fb_response.last_name != 'undefined' ? fullresto.fb_response.last_name : '';
                        var street = city = state = country = zip = '';
                        if(typeof fullresto.fb_response.address != 'undefined') {
                            street = typeof fullresto.fb_response.address.street != 'undefined' ? fullresto.fb_response.address.street : '';
                            city = typeof fullresto.fb_response.address.city != 'undefined' ? fullresto.fb_response.address.city : '';
                            state = typeof fullresto.fb_response.address.state != 'undefined' ? fullresto.fb_response.address.state : '';
                            country = typeof fullresto.fb_response.address.country != 'undefined' ? fullresto.fb_response.address.country : '';
                            zip = typeof fullresto.fb_response.address.zip != 'undefined' ? fullresto.fb_response.address.zip : '';
                        }
                        var mobile_phone = typeof fullresto.fb_response.mobile_phone != 'undefined' ? fullresto.fb_response.mobile_phone : '';
                        var birthday = typeof fullresto.fb_response.birthday != 'undefined' ? fullresto.fb_response.birthday : '';
                        var gender = typeof fullresto.fb_response.gender != 'undefined' ? fullresto.fb_response.gender : '';
                        var link = typeof fullresto.fb_response.link != 'undefined' ? fullresto.fb_response.link : '';
                        data.push({name: 'fb_accessToken', value: FB.getAuthResponse()['accessToken']});
                        data.push({name: 'fb_id', value: fullresto.fb_response.id});
                        data.push({name: 'fb_email', value: fb_email});
                        data.push({name: 'fb_first_name', value: first_name});
                        data.push({name: 'fb_last_name', value: last_name});
                        data.push({name: 'fb_address_street', value: street});
                        data.push({name: 'fb_address_city', value: city});
                        data.push({name: 'fb_address_state', value: state});
                        data.push({name: 'fb_address_country', value: country});
                        data.push({name: 'fb_address_zip', value: zip});
                        data.push({name: 'fb_mobile_phone', value: mobile_phone});
                        data.push({name: 'fb_birthday', value: birthday});
                        data.push({name: 'fb_gender', value: gender});
                        data.push({name: 'fb_link', value: link});
                    }
                }
                var jqxhr = $.post($(document.body).data('base') + 'book/now', $.param(data), function(data) {
                        if(data.status == '200') {
                            fullresto.util.notify(data.message, notify.SUCCESS);
                            $('.panel-process > div:first-child').css('background-color', 'green');
                            $('.panel-process > div:nth-child(2)').html('You are booked!<br/>Please wait, we will redirect you to the confirmation page.');
                            setTimeout(function(){ 
                                document.location = data.link;
                            }, 3000);
                        } else {
                            fullresto.util.notify(data.message, notify.ERROR);
                            $('.panel-process').addClass('hidden');
                        }
                    }, 'json')
                    .fail(function() {
                        fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                    })
                    .always(function() {
                        $('[data-btn=edit]').parent().show();
                        $('[data-btn=confirm]').html('Confirm booking');
                        $('[data-btn=edit], [data-btn=confirm]').removeClass('disabled');
                        $('.panel-final').hide();
                        $('.panel-form').show();
                    });
            }
            if($('.panel-form').is(':visible')) {
                $('.panel-final .bookingdate').val($('#bookingdate option:selected').text());
                $('.panel-final .bookingpax').val($('#bookingpax option:selected').text());
                $('.panel-final .bookingdeal').val($('#bookingdeal').val());
                $('.panel-final .guestname').val($('#guestname').val());
                $('.panel-final .guestemail').val($('#guestemail').val());
                $('.panel-final .guestcontactnum').val($('#guestcontactnum').val());
                $('.panel-final .promotioncode').val($('#promotioncode').val());
                $('.panel-form').hide();
                $('.panel-final').show();
            } else {
                $('.panel-final').hide();
                $('.panel-form').show();
            }
        },
        rate: function(modal, code) {
            if(modal.find('[name=rate1]:checked').length && modal.find('[name=rate2]:checked').length) {
                modal.find('button').addClass('disabled');
                var rate1 = modal.find('[name=rate1]:checked').val();
                var rate2 = modal.find('[name=rate2]:checked').val();
                var jqxhr = $.post('rating/rate', {code: code, rate1: rate1, rate2: rate2}, function(data) {
                    if(data.status == '200') {
                        var r = $('.fullresto-rating[data-id=' + code + ']');
                        r.addClass('rate-' + data.rate1).addClass('price-rate-' + data.rate2);
                        r.children('.ratings').removeClass('hidden');
                        r.children('span').addClass('hidden');
                        modal.modal('hide');
                        //TODO: Say thanks
                    } else {
                        fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                    }
                }, 'json')
                .fail(function() {
                    fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                });
            } else {
                fullresto.util.notify(messages.ERROR.RATING_SELECT, notify.ERROR);
            }
        },
        contact: function() {
            $('.contact-us').html('Please wait...').attr('disabled', 'disabled');
            var data = [];
            data.push({name: 'email', value: $('#email').val()});
            data.push({name: 'name', value: $('#name').val()});
            data.push({name: 'message', value: $('#message').val()});
            data.push({name: 'image', value: $('#image').val()});
            data.push({name: 'in', value: $('[data-in]').attr('data-in')});
            var jqxhr = $.post('contact/send', $.param(data), function(data) {
                    $('.contact-pane').children().remove();
                    if(typeof data.view != 'undefined') {
                        $('.contact-pane').html(data.view);
                    }
                }, 'json')
                .fail(function() {
                    fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                })
                .always(function() {
                    $('.contact-us').html('Send').removeAttr('disabled');
                });
        }
    };
    var setup = {
        login: function() {
            $('.login').unbind('click').click(function(e) {
                e.preventDefault();
                fullresto.process.login();
                return false;
            });
            $('.fb-login').unbind('click').click(function(e) {
                FB.login(function(loginResponse) {
                    if (loginResponse.status == 'connected' && loginResponse.authResponse != null) {
                        fullresto.process.fb_login();
                    }
                }, {
                    scope : 'email,user_birthday', perms: 'user_address, user_mobile_phone'
                });
            });
        },
        register: function() {
            $('.register').unbind('click').click(function(e) {
                e.preventDefault();
                fullresto.process.register();
                return false;
            });
            $('.fb-register').unbind('click').click(function(e) {
                FB.login(function(loginResponse) {
                    if (loginResponse.status == 'connected' && loginResponse.authResponse != null) {
                        fullresto.process.fb_login();
                    }
                }, {
                    scope : 'email,user_birthday', perms: 'user_address, user_mobile_phone'
                });
            });
        },
        contact: function() {
            $('.contact-us').unbind('click').click(function(e) {
                e.preventDefault();
                fullresto.process.contact();
                return false;
            });
        }
    };
    var sys = {
        init: function() {
            $('#keyword').focus();
            fullresto.sys.init_head();
            fullresto.sys.init_favorite();
            fullresto.sys.init_booking();
            fullresto.sys.init_my_booking();
            fullresto.sys.init_my_profile();
            fullresto.sys.init_load_more();
            fullresto.sys.init_search();
            fullresto.sys.init_search_sort();
            fullresto.sys.init_share_booking();
            fullresto.sys.init_scrolls();
        },
        init_head: function() {
            var id = (typeof $('.fullresto-rating').data('id') != 'undefined' ? $('.fullresto-rating').data('id') : '');
            var jqxhr = $.post($(document.body).data('base') + 'sizzle', {id:id}, function(data) {
                $('.fullresto-tools').html(data.tools);
                if(data.fullresto) {
                    $('body').attr('fullresto', data.fullresto);
                    $('.fullresto-footer-register').addClass('hidden');
                    $('.fullresto-footer-find').removeClass('hidden');
                    $('.fullresto-fb-login').addClass('hidden');
                    $('.fullresto-register').addClass('hidden');
                    $('.fullresto-book-now').removeClass('hidden');
                    if(id != '') {
                        $('#guestname').val(data.name);
                        $('#guestemail').val(data.email);
                        $('#guestcontactnum').val(data.contact_number);
                        $('.fullresto-rating').addClass(data.favorite);
                    }
                } else {
                    $('.fullresto-footer-register').removeClass('hidden');
                    $('.fullresto-footer-find').addClass('hidden');
                    $('.fullresto-fb-login').removeClass('hidden');
                    $('.fullresto-register').removeClass('hidden');
                    $('.fullresto-book-now').addClass('hidden');
                }
            }, 'json');
        },
        init_favorite: function() {
            $('[data-mod=favorite]').unbind('click').click(function(e) {
                e.preventDefault();
                if($('[fullresto]').attr('fullresto')) {
                    var o = $(this).closest('.fullresto-rating');
                    var currFavorite = o.hasClass('favorite');
                    if(currFavorite) o.removeClass('favorite'); else o.addClass('favorite');
                    var jqxhr = $.post($(document.body).data('base') + 'favorite', {code: o.attr('data-id')}, function(data) {
                        if(data.status == '200') {
                            if(data.favorite) o.addClass('favorite'); else o.removeClass('favorite');
                            //TODO: Say thanks
                        } else {
                            fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                        }
                    }, 'json')
                    .fail(function() {
                        fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                        if(currFavorite) o.addClass('favorite'); else o.removeClass('favorite');
                    });
                }
                return false;
            });
        },
        init_booking: function() {
            $('[data-btn=facebook-booking]').unbind('click').click(function(e) {
                e.preventDefault();
                var o = $(this);
                FB.login(function(loginResponse) {
                    if (loginResponse.status == 'connected' && loginResponse.authResponse != null) {
                        fullresto.fb_logged_in = true;
                        o.addClass('hidden');
                        $('#booking-fb-logged-in').removeClass('hidden');
                    }
                }, {
                    scope : 'email,user_birthday', perms: 'user_address, user_mobile_phone'
                });
            });
            $('[data-btn=make-reservation]').unbind('click').click(function(e) {
                e.preventDefault();
                $('#bookingdate').focus();
            });
            $('#bookingdate').unbind('change').change(function(e) {
                fullresto.process.check_deal('bookingdate', $(this).val());
                fullresto.process.set_deals();
            });
            $('#bookingpax').unbind('change').change(function(e) {
                fullresto.process.check_deal('bookingpax', $(this).val());
                fullresto.process.set_deals();
            });
            $('[data-deal]').unbind('click').click(function() {
                $('#bookingdeal').val($(this).attr('data-discount') + ' - ' + $(this).attr('data-ftime'));
                $('[data-opted-deal]').attr('data-opted-deal', $(this).attr('data-deal'));
                $('[data-deal]').removeClass('active');
                $(this).addClass('active');
                fullresto.process.check_deal('bookingdeal', $('[data-opted-deal]').attr('data-opted-deal'));
                fullresto.process.sample_menu($(this).attr('data-discount'));
            });
            $('#guestname').unbind('change').change(function(e) { fullresto.process.check_deal('guestname', $(this).val()); });
            $('#guestemail').unbind('change').change(function(e) { fullresto.process.check_deal('guestemail', $(this).val()); });
            $('#guestcontactnum').unbind('change').change(function(e) { fullresto.process.check_deal('guestcontactnum', $(this).val()); });
            $('[data-btn=review]').unbind('click').click(function() { fullresto.process.deal(); });
            $('[data-btn=edit]').unbind('click').click(function() { fullresto.process.deal(); });
            $('[data-btn=confirm]').unbind('click').click(function() {
                fullresto.process.deal(true);
            });
        },
        init_my_booking: function() {
            $('[data-btn=cancel-booking]').unbind('click').click(function(e) {
                e.preventDefault();
                var link = $(this);
                var code = link.closest('.booking-action').data('id');
                var modal = fullresto.util.confirm(
                    'Please confirm',
                    'There\'s no charge for cancellation. Once cancelled, you would not be able to reverse it back.<br/><br/>Do you want to proceed?',
                    function() {
                        var btn = $(this);
                        var lbl = btn.html();
                        btn.attr('disabled','disabled').addClass('disabled').html('Processing...');
                        var data = [];
                        data.push({name: 'booking-number', value: code});
                        var jqxhr = $.post($(document.body).data('base') + 'bookings/cancel', $.param(data), function(data) {
                                if(data.status == '200') {
                                    fullresto.util.notify(data.message, notify.SUCCESS);
                                    link.remove();
                                    //TODO: Change status label
                                    modal.modal('hide');
                                } else {
                                    fullresto.util.notify(data.message, notify.ERROR);
                                }
                            }, 'json')
                            .fail(function() {
                                fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                            })
                            .always(function() {
                                btn.removeAttr('disabled').removeClass('disabled').html(lbl);
                            });
                    },
                    function() {}
                );
            });
            $('[data-btn=booking-detail]').unbind('click').click(function(e) {
                e.preventDefault();
                $('#booking-detail').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var code = button.closest('.booking-action').data('id');
                    var modal = $(this);
                    var body = '';
                    var b = br[code];
                    modal.find('.booking-code').html(b['code']);
                    body += '<tr><td colspan="2">' + b['merchant'] + '</td></tr>';
                    body += '<tr><td colspan="2"></td></tr>';
                    body += '<tr><td><strong>Discount</strong></td><td>' + b['deal'] + '</td></tr>';
                    body += '<tr><td><strong>Date/Time</strong></td><td>' + b['date_booked'] + ' @ ' + b['time_booked_from'] + '</td></tr>';
                    body += '<tr><td><strong>Status</strong></td><td>' + b['status'] + '</td></tr>';
                    body += '<tr><td colspan="2"></td></tr>';
                    body += '<tr><td><strong>Pax</strong></td><td>' + b['pax_booked'] + '</td></tr>';
                    body += '<tr><td><strong>Name</strong></td><td>' + b['booking_name'] + '</td></tr>';
                    body += '<tr><td><strong>Email</strong></td><td>' + b['booking_email'] + '</td></tr>';
                    body += '<tr><td><strong>Contact</strong></td><td>' + b['booking_contact_number'] + '</td></tr>';
                    if(br['promo_code'] != '') {
                        body += '<tr><td><strong>Promo Code</strong></td><td>' + b['promo_code'] + '</td></tr>';
                    }
                    modal.find('.booking-table').html(body);
                });

                $('#booking-detail').modal({backdrop:false}, $(this));
                return false;
            });
            $('[data-btn=booking-rating]').unbind('click').click(function(e) {
                e.preventDefault();
                $('#booking-rating').unbind('show.bs.modal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var code = button.closest('.booking-action').data('id');
                    var modal = $(this);
                    modal.find('button').removeClass('disabled');
                    modal.find('.modal-footer').addClass('hidden');
                    modal.find('.processing + div').addClass('hidden');
                    modal.find('.processing').removeClass('hidden');
                    modal.find('input[type=radio]').prop('checked', false).parent().removeClass('active');
                    var jqxhr = $.get($(document.body).data('base') + 'rating/check', {code: code}, function(data) {
                            if(!data.status) {
                                modal.find('.processing').addClass('hidden');
                                modal.find('.processing + div').removeClass('hidden');
                                modal.find('.modal-footer').removeClass('hidden');
                            } else {
                                fullresto.util.notify(messages.ERROR.RATING_RATED, notify.ERROR);
                                modal.modal('hide');
                                return false;
                            }
                        }, 'json');
                        
                    modal.find('[data-mod=rating-submit]').unbind('click').click(function(e) {
                        fullresto.process.rate(modal, code);
                    });
                });

                $('#booking-rating').modal({backdrop:false}, $(this));
                return false;
            });
        },
        init_my_profile: function() {
            var fields = ['firstname','lastname','email','phone'];
            $.each(fields, function(k, fld) {
                $('#'+fld).unbind('change').change(function(e) {
                    valErr = false;
                    $('[data-form=profile] .'+fld).removeClass('has-error').removeClass('has-success');
                    $('[data-form=profile] .'+fld+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                    if($('#'+fld).hasClass('is-number') && isNaN($('#'+fld).val())) valErr = true;
                    if($('#'+fld).hasClass('is-email') && !fullresto.util.is_email($('#'+fld).val())) valErr = true;
                    if($('#'+fld).val() == '' || valErr) {
                        $('[data-form=profile] .'+fld).addClass('has-error');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-remove');
                    } else {
                        $('[data-form=profile] .'+fld).addClass('has-success');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-ok');
                    }
                });
            });
            
            var fields2 = ['password','password2'];
            $.each(fields2, function(k, fld) {
                $('#'+fld).unbind('change').change(function(e) {
                    var fld2 = (fld == 'password' ? 'password2' : 'password');
                    $('[data-form=profile] .'+fld).removeClass('has-error').removeClass('has-success');
                    $('[data-form=profile] .'+fld+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                    if($(this).val() == '' && $('#'+fld2).val() != '') {
                        $('[data-form=profile] .'+fld).addClass('has-error');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-remove');
                    } else if($(this).val() == '' && $('#'+fld2).val() == '') {
                        $('[data-form=profile] .'+fld2).removeClass('has-error').removeClass('has-success');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                    } else if($(this).val() != '' && $('#'+fld2).val() == '') {
                        $('[data-form=profile] .'+fld2).addClass('has-error');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').addClass('glyphicon-remove');
                    } else if($(this).val() != '' && $('#'+fld2).val() != '' && $(this).val() != $('#'+fld2).val()) {
                        $('[data-form=profile] .'+fld).addClass('has-error');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-remove');
                        $('[data-form=profile] .'+fld2).removeClass('has-error').removeClass('has-success');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                        $('[data-form=profile] .'+fld2).addClass('has-error');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').addClass('glyphicon-remove');
                    } else if($(this).val() != '' && $('#'+fld2).val() != '' && $(this).val() == $('#'+fld2).val()) {
                        $('[data-form=profile] .'+fld).addClass('has-success');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-ok');
                        $('[data-form=profile] .'+fld2).removeClass('has-error').removeClass('has-success');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                        $('[data-form=profile] .'+fld2).addClass('has-success');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').addClass('glyphicon-ok');
                    }
                });
            });
            
            $('[data-btn=save-profile]').unbind('click').click(function() {
                var o = $(this);
                
                var err = false, valErr = false, fld2 = '';
                $('[data-form=profile] .has-feedback').removeClass('has-error').removeClass('has-success');
                $('[data-form=profile] .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                $.each(fields, function(k, fld) {
                    valErr = false;
                    if($('#'+fld).hasClass('is-number') && isNaN($('#'+fld).val())) valErr = true;
                    if($('#'+fld).hasClass('is-email') && !fullresto.util.is_email($('#'+fld).val())) valErr = true;
                    if($('#'+fld).val() == '' || valErr) {
                        err = true;
                        $('[data-form=profile] .'+fld).addClass('has-error');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-remove');
                    } else {
                        $('[data-form=profile] .'+fld).addClass('has-success');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-ok');
                    }
                });
                
                $.each(fields2, function(k, fld) {
                    fld2 = (fld == 'password' ? 'password2' : 'password');
                    if($('#'+fld).val() == '' && $('#'+fld2).val() != '') {
                        err = true;
                        $('[data-form=profile] .'+fld).addClass('has-error');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-remove');
                    } else if($('#'+fld).val() == '' && $('#'+fld2).val() == '') {
                        $('[data-form=profile] .'+fld2).removeClass('has-error').removeClass('has-success');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                    } else if($('#'+fld).val() != '' && $('#'+fld2).val() == '') {
                        err = true;
                        $('[data-form=profile] .'+fld2).addClass('has-error');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').addClass('glyphicon-remove');
                    } else if($('#'+fld).val() != '' && $('#'+fld2).val() != '' && $('#'+fld).val() != $('#'+fld2).val()) {
                        err = true;
                        $('[data-form=profile] .'+fld).addClass('has-error');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-remove');
                        $('[data-form=profile] .'+fld2).removeClass('has-error').removeClass('has-success');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                        $('[data-form=profile] .'+fld2).addClass('has-error');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').addClass('glyphicon-remove');
                    } else if($('#'+fld).val() != '' && $('#'+fld2).val() != '' && $('#'+fld).val() == $('#'+fld2).val()) {
                        $('[data-form=profile] .'+fld).addClass('has-success');
                        $('[data-form=profile] .'+fld+' .form-control-feedback').addClass('glyphicon-ok');
                        $('[data-form=profile] .'+fld2).removeClass('has-error').removeClass('has-success');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
                        $('[data-form=profile] .'+fld2).addClass('has-success');
                        $('[data-form=profile] .'+fld2+' .form-control-feedback').addClass('glyphicon-ok');
                    }
                });
                
                if(err) {
                    return false;
                }
            
                o.attr('disabled','disabled').addClass('disabled').html('Processing...');
                var jqxhr = $.post($(document.body).data('base') + 'profile/update', $('[data-form=profile]').serialize(), function(data) {
                        if(data.status == '200') {
                            fullresto.util.notify(data.message, notify.SUCCESS);
                            //TODO: Remove button
                        } else {
                            fullresto.util.notify(data.message, notify.ERROR);
                        }
                    }, 'json')
                    .fail(function() {
                        fullresto.util.notify(messages.ERROR.GENERIC, notify.ERROR);
                    })
                    .always(function() {
                        o.html('Update Profile');
                        o.removeAttr('disabled').removeClass('disabled');
                    });
            });
            
            $('#country').unbind('change').change(function(e) {
                $('#city option').remove();
                if($(this).val() != '') {
                    var jqxhr = $.get($(document.body).data('base') + 'sizzle/cities', {country: $(this).val()}, function(data) {
                            if(data.status == '200') {
                                $('#city').append('<option value=""></option>');
                                $.each(data.cities, function (i, item) {
                                    $('#city').append('<option value="' + item + '">' + item + '</option>');
                                });
                                $('#city').append('<option value="OTHER">Other city</option>');
                            }
                        }, 'json');
                } else {
                    $('#city').append('<option value=""></option><option value="OTHER">Other city</option>');
                }
            });
            
            $('#city').unbind('change').change(function(e) {
                if($(this).val() == 'OTHER') {
                    $('#othercity').removeClass('hidden').val('');
                } else {
                    $('#othercity').addClass('hidden').val('');
                }
            });
        },
        init_load_more: function() {
            $('#btnloadmore').unbind('click').click(function(e) {
                $.ajax({
				  	method: "POST",
				  	url: "search/more",
				  	data: { 
				  		codes: $("#codes").val(),
				  		searchtype: $("#searchtype").val(),
				  		searchsort: $("#searchsort").val(),
				  		city: $("#city").val(),
				  		latitude: $("#locationlat").val(),
				  		longitude: $("#locationlong").val(),
				  		bookingdate: $("#bookingdate").val(),
				  		bookingpax: $("#bookingpax").val(),
				  		keyword: $("#keyword").val()
				  	},
				  	beforeSend:function(){
				    	$("div.loadmore").html(loading);
					},
				  	success:function(data){
				  		$("#codes, #searchtype, #searchsort, #city, #locationlat, #locationlong, .loadmore, .loadmore-clear").remove();
                        $("#merchantlist").append(data);
				  		
				  		fullresto.sys.init_load_more();
				  	}
			  	});
            });
        },
        init_search: function() {
            $('[data-mod=search], #bookingdate, #bookingpax').unbind('keypress').keypress(function(e) {
                var code = e.keyCode || e.which;
                if(code == 13) {
                    $("#frmmain").submit();
                    return false;
                }
            });
            if(typeof $("[name=bookingdate]").val() != 'undefined') {
                $("#bookingdate").datepicker({dateFormat: 'd M y', minDate: 0 });
            }
            
        	$('.btn-quick-search').unbind('click').click(function(e) {
	        	$('.fullresto-access').find('button').removeClass('active').removeClass('btn-danger');
		        $(this).addClass('active').addClass('btn-danger')
		        
                var searchtype = $(this).val();
				var city = $("#city").val();
				var merchant_lat = $("#locationlat").val();
				var merchant_long = $("#locationlong").val();
                $.ajax({
                    method: "POST",
                    url: "search/quick",
                    data: { searchtype: searchtype, latitude: merchant_lat, longitude: merchant_long, city: city },
                    beforeSend:function(){
                        $("#merchantlist").html(loading);
                    },
                    success:function(data){
                        $("#merchantlist").html(data);								    	
                        fullresto.sys.init_load_more();
                    }
                });
			});
        },
        init_search_sort: function() {
            $('.btn-search-sort').unbind('click').click(function(e) {
            	var searchsort = $(this).val();
            	
            	if(searchsort == "" || searchsort == "0") {
					searchsort = $(this).attr("value");
				}
            	
            	$(".btn-search-sort").removeClass("btn-danger active").addClass("btn-default");
            	$(this).addClass("btn-danger active");
            	
            	if(typeof(searchsort) != "undefined") {
            		$("#searchsort").val(searchsort);
            		$("#sortby").val(searchsort);
            		$("#frmmain").submit();
				}
            });
        },
        init_share_booking: function() {
            $('.share-booking').unbind('click').click(function(e) {
                e.preventDefault();
                var caption = encodeURIComponent('www.fullresto.com');
                var description = encodeURIComponent('Enjoy huge discounts when you eat at your favorite restaurants on off-peak hours. Book your own deals now at fullresto.com.');
                var link = encodeURIComponent($(this).data('url'));
                var name = encodeURIComponent('I just booked a ' + $(this).data('deal') + ' deal with ' + $(this).data('name') + '!');
                var wLeft = window.screenLeft ? window.screenLeft : window.screenX;
                var wTop = window.screenTop ? window.screenTop : window.screenY;
                var left = wLeft + (window.innerWidth / 2) - 274;
                var top = wTop + (window.innerHeight / 2) - 162;
                window.open('https://www.facebook.com/dialog/feed?app_id=' + fb_app_id + '&display=popup&caption=' + caption + '&description=' + description + '&link=' + link + '&name=' + name + '&redirect_uri=' + link,'sharer','toolbar=0,status=0,width=548,height=325,top='+top+',left='+left);
            });
        },
        init_scrolls: function() {
            $('.fullresto-nav').unbind('click').click(function() {
                var dealsscroll = $(this).siblings('.deals').children('.deals-scroll')
                var position = dealsscroll.position();
                var left = 0;
                if($(this).data('nav') == 'left') {
                    left = position.left;
                    left = (left < 0 ? (Math.abs(position.left) - 100) * -1 : left);
                    left = (left > 0 ? 0 : left);
                } else {
                    var scrollwidth = $(dealsscroll).width();
                    var dealswidth = $(dealsscroll).parent('.deals').width();
                    var totalwidth = $(dealsscroll).children('.deal').length * 65;
                    left = (totalwidth > dealswidth ? Math.abs(position.left) + 100 : 0);
                    left = ((left+dealswidth) > totalwidth && totalwidth > dealswidth ? (totalwidth - dealswidth) : left) * -1;
                }
                $(dealsscroll).animate({
                    left: left
                });
            });
        },
        current_views: function() {
            setTimeout(function(){
                $.get($(document.body).data('base') + 'book/viewings', {code: $('[data-id]').attr('data-id'), mode: 1}, function(data) {
                    data.num = parseInt(data.num);
                    if(data.num > 0) {
                        fullresto.util.notify(fullresto.util.replace((data.num > 1 ? messages.INFO.CURRENT_VIEWINGS : messages.INFO.CURRENT_VIEWING), data.num), notify.INFO);
                    }
                }, 'json');
            }, 3000);
            setTimeout(function(){
                $.get($(document.body).data('base') + 'book/viewings', {code: $('[data-id]').attr('data-id'), mode: 2}, function(data) {
                    data.num = parseInt(data.num);
                    if(data.num > 0) {
                        fullresto.util.notify(fullresto.util.replace((data.num > 1 ? messages.INFO.CURRENT_BOOKINGS : messages.INFO.CURRENT_BOOKING), data.num), notify.INFO);
                    }
                }, 'json');
            }, 5000);
        }
    };
    var util = {
        is_email: function(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        },
        set_fb_data: function() {
            $('.facebook-pic').addClass('hidden');
            $('.facebook-pic + span').removeClass('hidden');
            if(typeof $('[fullresto]').attr('fullresto') == 'undefined') {
                FB.api('/me', function(response) {
                    fullresto.fb_response = response;
                    if(response.id && FB.getAuthResponse()['accessToken']) {
                        $('[data-btn=facebook-booking]').addClass('hidden');
                        $('#booking-fb-logged-in').removeClass('hidden');
                        $('.facebook-pic + span').addClass('hidden');
                        $('.facebook-pic').removeClass('hidden').attr('src', 'https://graph.facebook.com/' + response.id + '/picture');
                        $('.facebook-name').html('You\'re logged in as ' + response.name);
                        $('#guestname').val(response.name);
                        $('#guestemail').val(response.email ? response.email : '');
                        $('#guestcontactnum').val(response.mobile_phone ? response.mobile_phone : '');
                    }
                });
            }
        },
        replace: function(message, parameter0, parameter1, parameter2, parameter3) {
            if(typeof parameter0 != 'undefined') {
                message = message.replace("{0}", parameter0);
            }
            if(typeof parameter1 != 'undefined') {
                message = message.replace("{1}", parameter1);
            }
            if(typeof parameter2 != 'undefined') {
                message = message.replace("{2}", parameter2);
            }
            if(typeof parameter3 != 'undefined') {
                message = message.replace("{3}", parameter3);
            }
            return message;
        },
        notify: function(message, type) {
            $.notify.add({text: message, type: type});
        },
        confirm: function(title, message, confirm_callback, cancel_callback) {
            $('#confirmation').unbind('show.bs.modal').on('show.bs.modal', function (event) {
                var modal = $(this);
                modal.find('.modal-title').html(title);
                modal.find('.modal-body').html(message);
                modal.find('[data-mod=yes]').unbind('click').click(confirm_callback);
                modal.find('[data-mod=no]').unbind('click').click(cancel_callback);
            });
            return $('#confirmation').modal({backdrop:false}, $(this));
        },
        share_booking: function(bookingDate, code, name) {
            var today = new Date();
            var bdate = new Date(bookingDate);
            if(bdate.getDate() == today.getDate() && bdate.getMonth() == today.getMonth() && bdate.getFullYear() == today.getFullYear()) {
                $('#booking-detail').on('show.bs.modal', function (event) {
                    var modal = $(this);
                    var body = '';
                    modal.find('.row').hide();
                    title = modal.find('.modal-title').html();
                    modal.find('.modal-title').html('Thanks!');
                    body += '<tr><td colspan="2" align="center" style="font-size:26px;">Thank you for choosing<br/><strong>' + name + '!</strong></td></tr>';
                    body += '<tr><td colspan="2">&nbsp;</td></tr>';
                    body += '<tr><td colspan="2" align="center" style="font-size:16px;">This is your booking reference code: <strong>' + code + '</strong></td></tr>';
                    body += '<tr><td colspan="2" align="center" style="font-size:16px;"><a href="#" onclick="$(\'.share-booking\').click(); return false;">Let your friends on Facebook know about this deal!</a></td></tr>';
                    modal.find('.booking-table').html(body);
                });

                $('#booking-detail').modal({backdrop:false}, $(this));
            }
        }
    };
    
    (function expose() {
        app.fb_logged_in = fb_logged_in;
        app.fb_response = fb_response;
        app.process = process;
        app.setup = setup;
        app.sys = sys;
        app.util = util;
    })();
})(fullresto);

$(function() {
    fullresto.sys.init();
});

$.getScript('http://connect.facebook.net/en_UK/all.js', function() {
    FB.init({
        appId : '',
        status : true,
        xfbml : true
    });
    FB.getLoginStatus(function(response) {
        fullresto.util.set_fb_data();
    });
});

(function($){
    $.notify = {};
    $.notify.add = function(params){
        try {
            return Notify.add(params || {});
        } catch(e) {
            var err = 'Notification Error: ' + e;
            (typeof(console) != 'undefined' && console.error) ?
                console.error(err, params) :
                alert(err);
        }
    }
    var Notify = {
        fade_in_speed: 'medium',
        fade_out_speed: 1000,
        time: 6000,

        /**
         * Add a notification to the screen
         * @param {Object} params The object that contains all the options for drawing the notification
         * @return {Integer} The specific numeric id to that notification
         */
        add: function(params) {
            var notify_message = params.text,
                notify_type = params.type

            if(typeof notify_message == 'undefined' || $.trim(notify_message) == '') {
                return false;
            }
            if(typeof notify_type == 'undefined' || $.trim(notify_type) == '') {
                notify_type = '';
            }

            var number = new Date().getTime();
            var notification = $('<div class="alert ' + notify_type + '">' + notify_message + '</div>');

            notification.fadeIn("slow");

            this._setFadeTimer(notification, number);

            notification.bind('mouseenter mouseleave', function(event) {
                if(event.type == 'mouseenter') {
                    Notify._restoreItemIfFading($(this), number);
                } else {
                    Notify._setFadeTimer($(this), number);
                }
            });

            $('#notify-wrapper').prepend(notification);
        },

        /**
         * Fade out an element after it's been on the screen for x amount of time
         * @private
         * @param {Object} e The jQuery element to get rid of
         * @param {Integer} unique_id The id of the element to remove
         */
        _fade: function(e, unique_id){
            // If this is true, then we are coming from clicking the (X)
            e.unbind('mouseenter mouseleave');

            // Fade it out or remove it
            e.animate({
                opacity: 0
            }, 1000, function() {
                e.animate({ height: 0 }, 300, function() {
                    e.remove();
                });
            });
        },

        /**
         * If the item is fading out and we hover over it, restore it!
         * @private
         * @param {Object} e The HTML element to remove
         * @param {Integer} unique_id The ID of the element
         */
        _restoreItemIfFading: function(e, unique_id){
            clearTimeout(this['_int_id_' + unique_id]);
            e.stop().css({ opacity: '', height: '' });
        },

        /**
         * Set the notification to fade out after a certain amount of time
         * @private
         * @param {Object} item The HTML element we're dealing with
         * @param {Integer} unique_id The ID of the element
         */
        _setFadeTimer: function(e, unique_id){
            this['_int_id_' + unique_id] = setTimeout(function() {
                Notify._fade(e, unique_id);
            }, this.time);
        }
    }
})(jQuery);