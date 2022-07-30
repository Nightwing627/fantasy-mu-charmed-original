var mucms = {
    init: function (options) {
        if (1 == this.initialized) return !1;
        this.initialized = !0, this.baseUrlScope = options.url ? options.url : {};
        var path = options.path ? options.path : null;
        if (null == path) {
            path = "";
            for (var scripts = document.getElementsByTagName("script"), i = 0; i < scripts.length; i++) scripts[i].src && scripts[i].src.match(/mucms[\.?](.*?)\.js/i) && (path = scripts[i].src.substr(0, scripts[i].src.lastIndexOf("/") + 1))
        }
        //this.publicPath = path, this.include("mucms.extension.js");
        var instance = this;
        $("body").on("click", "*", function (event) {
            var sender = $(this);
            if (sender.attr("disabled")) return !1;
            if (sender.attr("xw-hook-before")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                eval(sender.attr("xw-hook-before"))
            }
            if ("undefined" != sender.attr("xw-submit") && ("" === sender.attr("xw-submit") || sender.attr("xw-submit"))) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                var namedForm = sender.attr("xw-submit"),
                    form = namedForm && namedForm.length > 0 ? "#" == namedForm[0] ? $("#" + namedForm) : $("[name='" + namedForm + "']") : sender.closest("form");
                if (!form || "undefined" === form) throw new Error("Target form not found.");
                var method = form.attr("method") ? form.attr("method").toUpperCase() : "POST",
                    url = form.attr("target") ? form.attr("target") : null;
                if (null == url) throw new Error("URL to submit request is required");
                mucms.sendForm({sender: sender, form: form, method: method, url: url})
            }
            if (sender.attr("xw-form")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                var form = sender.attr("xw-form-name") ? $("[name='" + sender.attr("xw-form-name") + "']") : sender.closest("form");
                if (!form || "undefined" === form) throw new Error("Target form not found.");
                var method = sender.attr("xw-method") ? sender.attr("xw-method").toUpperCase() : "POST",
                    url = sender.attr("xw-form");
                if (null == url) throw new Error("URL to submit request is required");
                mucms.sendForm({sender: sender, form: form, method: method, url: url})
            }
            if (sender.attr("xw-get")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                mucms.sendRequest({sender: sender, method: "GET", url: sender.attr("xw-get")})
            }
            if (sender.attr("xw-post")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                mucms.sendRequest({sender: sender, method: "POST", url: sender.attr("xw-post")})
            }
            if (sender.attr("xw-put")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                mucms.sendRequest({sender: sender, method: "PUT", url: sender.attr("xw-put")})
            }
            if (sender.attr("xw-delete")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                mucms.sendRequest({sender: sender, method: "DELETE", url: sender.attr("xw-delete")})
            }
            if (sender.attr("xw-options")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                mucms.sendRequest({sender: sender, method: "OPTIONS", url: sender.attr("xw-options")})
            }
            if (sender.attr("xw-patch")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                mucms.sendRequest({sender: sender, method: "PATCH", url: sender.attr("xw-patch")})
            }
            if (sender.attr("xw-hook-after")) {
                if (event.preventDefault(event), 0 == instance.checkOperation(sender)) return !1;
                eval(sender.attr("xw-hook-after"))
            }
        })
    },
    run: function () {
        1 == this.aggregationState && (this.checkRoute(), this.checkGlobal())
    },
    checkOperation: function (e) {
        var t = (new Date).getTime();
        return null != this.operation.sender && t <= this.operation.timer ? !1 : (this.operation = {
            sender: e,
            timer: t + 2e3
        }, !0)
    },
    /*include: function (e) {
        this.aggregationState = !1;
        var t = document.createElement("script");
        t.setAttribute("type", "text/javascript"), t.setAttribute("src", this.publicPath + e), document.body.appendChild(t)
    },*/
    aggregate: function () {
        this.aggregationState = !0
    },
    aggregateEnd: function () {
        1 == this.aggregationState && this.checkRoute()
    },
    addRoute: function (e, t) {
        this.routeScope.push({path: e, callback: t})
    },
    checkRoute: function () {
        var e = JSON.parse(JSON.stringify(window.location.href)), t = this.baseUrlScope;
        this.routeScope.forEach(function (r) {
            var n = !1;
            t.forEach(function (t) {
                var o = JSON.parse(JSON.stringify(e)).toString();
                0 == n && -1 != o.indexOf(t) && (o = o.replace(/^https:\/\//, ""), o = o.replace(/^http:\/\//, ""), o = o.replace(/^www\./, ""), o = o.replace(/^\./, ""), o = o.replace(new RegExp(t, "i"), ""), r.path == o && (r.callback(), n = !0))
            })
        })
    },
    isRoute: function (e) {
        var t = url ? url : JSON.parse(JSON.stringify(window.location.href));
        return this.baseUrlScope.forEach(function (r) {
            var n = JSON.parse(JSON.stringify(t)).toString();
            return 0 == routeFound && -1 != n.indexOf(r) && (n = n.replace(/^https:\/\//, ""), n = n.replace(/^http:\/\//, ""), n = n.replace(/^www\./, ""), n = n.replace(/^\./, ""), n = n.replace(new RegExp(r, "i"), ""), e == n) ? !0 : void 0
        }), !1
    },
    addMethod: function (e, t) {
        this.methodScope.push({name: e, callback: t})
    },
    callMethod: function (e, t) {
        this.methodScope.forEach(function (r) {
            r.name.toLowerCase() == e.toLowerCase() && r.callback.apply(this, t)
        })
    },
    sendForm: function (e) {
        var t = e.sender ? e.sender : null, r = e.form ? e.form : null, n = e.method ? e.method : "POST",
            o = e.url ? e.url : null, a = e.onSuccess ? e.onSuccess : null, s = e.onError ? e.onError : null,
            i = e.onBeforeSend ? e.onBeforeSend : null, l = e.onAfterSend ? e.onAfterSend : null;
        if (null != t) {
            if (t.attr("disabled")) return !1;
            t.attr("disabled", !0);
            var d = t.html();
            t.html(t.attr("xw-progress") ? t.attr("xw-progress") : d)
        }
        var c = new FormData;
        return c.append("_METHOD", n), r.find("*").each(function (e, t) {
            if ($(t).attr("name")) if ("checkbox" == $(t).prop("type")) c.append($(t).attr("name"), 0 == $(t).prop("checked") ? "0" : "1"); else if ("file" == $(t).prop("type")) {
                var r = $(t).prop("files");
                void 0 !== r && void 0 !== r[0] && c.append($(t).attr("name"), r[0])
            } else $(t).tagName && "textarea" == $(t).tagName.toLowerCase() ? c.append($(t).attr("name"), null == $(t).html() ? "" : $(t).html()) : c.append($(t).attr("name"), null == $(t).val() ? "" : $(t).val())
        }), $.ajax({
            type: "POST",
            dataType: "json",
            url: o,
            headers: {mucmsRequest: "json"},
            data: c,
            enctype: "multipart/form-data",
            contentType: !1,
            processData: !1,
            beforeSend: function (e) {
                e.setRequestHeader("mucmsRequest", "json"), null != i && i(e)
            },
            success: function (e) {
                return null != a ? a(e) : mucms.protocol(e)
            },
            error: function (e, t) {
                if (null != s) {
                    if (-1 != e.responseText.search("\ufeff") && -1 != e.responseText.indexOf("[[")) return mucms.protocol(JSON.parse(e.responseText.replace("\ufeff", "")));
                    s(e, t)
                } else {
                    if (-1 != e.responseText.search("\ufeff") && -1 != e.responseText.indexOf("[[")) return mucms.protocol(JSON.parse(e.responseText.replace("\ufeff", "")));
                    mucms.debugStart(e.responseText)
                }
            }
        }).always(function (e) {
            null != l && l(e), null != t && (t.attr("disabled", !1), t.html(d))
        }), !0
    },
    sendRequest: function (t) {
        var r = t.sender ? t.sender : null, n = t.method ? t.method : "GET", o = t.url ? t.url : null,
            a = t.async && 0 == t.async ? !1 : !0, s = t.onSuccess ? t.onSuccess : null,
            i = t.onError ? t.onError : null, l = t.onBeforeSend ? t.onBeforeSend : null,
            d = t.onAfterSend ? t.onAfterSend : null;
        if (null != r) {
            if (r.attr("disabled")) return !1;
            r.attr("disabled", !0)
        }
        return $.ajax({
            type: "POST", dataType: "json", url: o, data: {_METHOD: n}, async: a, beforeSend: function (e) {
                e.setRequestHeader("mucmsRequest", "json"), null != l && l(e)
            }, success: function (e) {
                return null != s ? s(e) : mucms.protocol(e)
            }, error: function (e, t) {
                if (null != i) {
                    if (-1 != e.responseText.search("\ufeff") && -1 != e.responseText.indexOf("[[")) return mucms.protocol(JSON.parse(e.responseText.replace("\ufeff", "")));
                    i(e, t)
                } else {
                    if (-1 != e.responseText.search("\ufeff") && -1 != e.responseText.indexOf("[[")) return mucms.protocol(JSON.parse(e.responseText.replace("\ufeff", "")));
                    mucms.debugStart(e.responseText)
                }
            }
        }).always(function () {
            null != d && d(e), null != r && r.attr("disabled", !1)
        }), !0
    },
    protocol: function (e) {
        if (null != e && "" != e && "undefined" !== e) {
            var t = this;
            e.forEach(function (e) {
                var r = e[0], n = e.splice(1, e.length);
                t.callMethod(r, n)
            })
        }
    },
    addGlobal: function (e) {
        this.globalScope.push(e), e()
    },
    checkGlobal: function () {
        this.globalScope.forEach(function (e) {
            e()
        })
    },
    debugStart: function (e) {
        if (0 != confirm("An exception occurred from the server side.\nDo you want to debug?")) if (console.log(e), this.debugBodyContent = $("body").html(), $("body").html(""), 0 == /<(br|basefont|hr|input|source|frame|param|area|meta|!--|col|link|option|base|img|wbr|!DOCTYPE).*?>|<(a|abbr|acronym|address|applet|article|aside|audio|b|bdi|bdo|big|blockquote|body|button|canvas|caption|center|cite|code|colgroup|command|datalist|dd|del|details|dfn|dialog|dir|div|dl|dt|em|embed|fieldset|figcaption|figure|font|footer|form|frameset|head|header|hgroup|h1|h2|h3|h4|h5|h6|html|i|iframe|ins|kbd|keygen|label|legend|li|map|mark|menu|meter|nav|noframes|noscript|object|ol|optgroup|output|p|pre|progress|q|rp|rt|ruby|s|samp|script|section|select|small|span|strike|strong|style|sub|summary|sup|table|tbody|td|textarea|tfoot|th|thead|time|title|tr|track|tt|u|ul|var|video).*?<\/\2>/i.test(e)) {
            var t = "";
            t += '<table style="font-size: 14px;" border="1" cellspacing="0" cellpadding="1">', t += '<tbody><tr><th align="left" bgcolor="#f57900" colspan="5">', t += '<span style="background-color: #cc0000; color: #fce94f; font-size: x-large;">( ! )</span> Unexpected Error: please contact the web master or administrator</th></tr>', t += '<tr><th align="left" bgcolor="#e9b96e" colspan="5"><b>Message:</b></th></tr>', t += '<tr><th bgcolor="#eeeeec" style="font-weight: 100;">', t += e, t += "</th></tr></tbody></table>", t += '<br><input type="button" onclick="mucms.debugClose();" value="Close Debug Mode" style="font-size: 14px; color: black;">', $("body").append(t)
        } else $("body").append(e), $("body").append('<br><input type="button" onclick="mucms.debugClose();" value="Close Debug Mode" style="font-size: 14px; color: black;">')
    },
    debugClose: function () {
        $("body").html(this.debugBodyContent)
    },
    initialized: !1,
    operation: {sender: null, timer: 0},
    publicPath: null,
    globalScope: new Array,
    baseUrlScope: new Array,
    routeScope: new Array,
    methodScope: new Array,
    debugBodyContent: null,
    aggregationState: !0
};