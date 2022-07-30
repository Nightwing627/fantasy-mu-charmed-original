var serverTime = {
    serverDate: null,
    localDate: null,
    dateOffset: null,
    nowDate: null,
    eleServer: null,
    eleLocal: null,
    init: function (e, c) {
        var f = this;
        f.eleServer = e;
        f.eleLocal = c;
        $.getJSON(baseUrl + "ajax/server_time.php", function (a) {
            f.serverDate = new Date(a.ServerTime);
            f.localDate = new Date();
            f.dateOffset = f.serverDate - f.localDate;
            document.getElementById(f.eleServer).innerHTML = f.dateTimeFormat(f.serverDate);
            document.getElementById(f.eleLocal).innerHTML = f.dateTimeFormat(f.localDate);
            setInterval(function () {
                f.update()
            }, 1000);
        })
    },
    update: function () {
        var b = this;
        b.nowDate = new Date();
        document.getElementById(b.eleLocal).innerHTML = b.dateTimeFormat(b.nowDate);
        b.nowDate.setTime(b.nowDate.getTime() + b.dateOffset);
        document.getElementById(b.eleServer).innerHTML = b.dateTimeFormat(b.nowDate);
    },
    dateTimeFormat: function (e) {
        var c = this;
        var f = [];
        f.push(c.digit(e.getHours()));
        f.push(":");
        f.push(c.digit(e.getMinutes()));
        return f.join("");
    },
    digit: function (b) {
        b = String(b);
        b = b.length == 1 ? "0" + b : b;
        return b;
    }
};

function getLocalTime() {
    var localTime = new Date();
    $("#footerLocalTime")["html"]((localTime["getHours"]() <= 9 ? "0" + localTime["getHours"]() : localTime["getHours"]()) + ":" + (localTime["getMinutes"]() <= 9 ? "0" + localTime["getMinutes"]() : localTime["getMinutes"]()));
    $("#footerLocalDate")["html"]((localTime["getDate"]() <= 9 ? "0" + localTime["getDate"]() : localTime["getDate"]()) + "/" + (localTime["getMonth"]() <= 8 ? "0" + (localTime["getMonth"]() + 1) : (localTime["getMonth"]() + 1)) + "/" + (localTime["getFullYear"]()));
}

$(window)["scroll"](function () {
    if ($(window)["scrollTop"]() > 1) {
        $("#main-navbar")["addClass"]("scrolled")
    } else {
        $("#main-navbar")["removeClass"]("scrolled")
    }
});

(function ($) {

    'use strict';

    $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function (e) {
        var $target = $(e.target);
        var $tabs = $target.closest('.nav-tabs-responsive');
        var $current = $target.closest('li');
        var $parent = $current.closest('li.dropdown');
        $current = $parent.length > 0 ? $parent : $current;
        var $next = $current.next();
        var $prev = $current.prev();
        var updateDropdownMenu = function ($el, position) {
            $el
                .find('.dropdown-menu')
                .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                .addClass('pull-xs-' + position);
        };

        $tabs.find('>li').removeClass('next prev');
        $prev.addClass('prev');
        $next.addClass('next');

        updateDropdownMenu($prev, 'left');
        updateDropdownMenu($current, 'center');
        updateDropdownMenu($next, 'right');
    });

})(jQuery);