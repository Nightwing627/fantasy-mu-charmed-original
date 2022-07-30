$(function () {
    mucms.aggregate();
    mucms.addMethod('Redirect', function (url) {
        window.location = url;
    });
    mucms.addMethod('Refresh', function () {
        window.location.reload();
    });
    mucms.addMethod('Toggle', function (element, type) {
        switch (type.toLowerCase()) {
            case"show":
                $(element).show();
                break;
            case"hide":
                $(element).hide();
                break;
            default:
                $(element).toggle();
                break;
        }
    });
    mucms.addMethod('Eval', function (code) {
        eval(code);
    });
    mucms.addMethod('Message', function (type, text, time, sufix) {
        var target = '#xw-message';
        if (sufix && $('#xw-message-' + sufix.toLowerCase()).length) {
            target = '#xw-message-' + sufix.toLowerCase();
        }
        target = $(target);
        target.removeClass();
        if (typeof XWMessageTimer === 'undefined') {
            var XWMessageTimer;
        }
        clearTimeout(XWMessageTimer);
        switch (type) {
            case'Info':
                target.addClass('xw-message-info');
                break;
            case'Success':
                target.addClass('xw-message-success');
                break;
            case'Warning':
                target.addClass('xw-message-warning');
                break;
            case'Error':
                target.addClass('xw-message-error');
                break;
        }
        target.html(text);
        if (target.offset() !== 'undefined') {
            if (((target.offset().top + target.height()) > ($(window).scrollTop() + $(window).height())) || (target.offset().top < $(window).scrollTop())) {
                $('html, body').animate({scrollTop: target.offset().top}, 1000);
            }
        }
        target.fadeIn('slow');
        if (time > 0) {
            XWMessageTimer = setTimeout(function () {
                target.fadeOut('slow');
            }, time * 1000);
        }
    });
    mucms.aggregateEnd();
});