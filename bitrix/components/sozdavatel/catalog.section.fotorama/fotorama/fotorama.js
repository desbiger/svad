/*! Fotorama 3.0.5 | http://fotoramajs.com/license/  */
(function (a, b, c, d) {
    function f(a) {
        var b = "bez_" + c.makeArray(arguments).join("_").replace(".", "p");
        if (typeof c.easing[b] != "function") {
            var d = function (a, b) {
                var c = [null, null], d = [null, null], e = [null, null], f = function (f, g) {
                    return e[g] = 3 * a[g], d[g] = 3 * (b[g] - a[g]) - e[g], c[g] = 1 - e[g] - d[g], f * (e[g] + f * (d[g] + f * c[g]))
                }, g = function (a) {
                    return e[0] + a * (2 * d[0] + 3 * c[0] * a)
                }, h = function (a) {
                    var b = a, c = 0, d;
                    while (++c < 14) {
                        d = f(b, 0) - a;
                        if (Math.abs(d) < .001)break;
                        b -= d / g(b)
                    }
                    return b
                };
                return function (a) {
                    return f(h(a), 1)
                }
            };
            c.easing[b] = function (b, c, e, f, g) {
                return f * d([a[0], a[1]], [a[2], a[3]])(c / g) + e
            }
        }
        return b
    }

    function C(a) {
        var b = {};
        for (var c = 0; c < B.length; c++) {
            var d = B[c][0], e = B[c][1];
            if (a) {
                var f = a.attr("data-" + d);
                f && (e == "n" ? (f = Number(f), isNaN(f) || (b[d] = f)) : e == "b" ? f == "true" ? b[d] = !0 : f == "false" && (b[d] = !1) : e == "s" ? b[d] = f : e == "bn" && (f == "true" ? b[d] = !0 : f == "false" ? b[d] = !1 : (f = Number(f), isNaN(f) || (b[d] = f))))
            } else b[d] = B[c][2]
        }
        return b
    }

    function E(a, c) {
        var d = b.createElementNS("http://www.w3.org/2000/svg", a);
        for (var e in c)d.setAttribute(e, c[e]);
        return d
    }

    function F(a, b) {
        var c = {};
        for (var d = 0; d < D.length; d++)c[D[d] + a] = b;
        return c
    }

    function G(a, b, c) {
        if (q && !c)return F("transform", b ? "translate(0," + a + "px)" : "translate(" + a + "px,0)");
        var d = {};
        return d[b ? "top" : "left"] = a, d
    }

    function H(a, b) {
        return a.match(/-?\d+/g)[b == "left" ? 4 : 5]
    }

    function I(a, b, c) {
        return!p || !q || !c ? a.position()[b] : H(a.css("-moz-transform"), b)
    }

    function J(a) {
        return F("transition-duration", a + "ms")
    }

    function K(a) {
        return a = Number(String(a).replace("px", "")), isNaN(a) ? !1 : a
    }

    function L(a, b, c) {
        return Math.max(b, Math[c !== !1 ? "min" : "max"](c, a))
    }

    function M() {
        return!1
    }

    function N(a) {
        a.mousemove(function (a) {
            a.preventDefault()
        }).mousedown(function (a) {
            a.preventDefault()
        })
    }

    function O(c) {
        c.preventDefault();
        if (b.selection && b.selection.empty)b.selection.empty(); else if (a.getSelection) {
            var d = a.getSelection();
            d.removeAllRanges()
        }
    }

    function P(a) {
        var b = c("iframe", a);
        b.size() && b.each(function () {
            var a = c(this).clone(), b = a.attr("src"), d = b.indexOf("?") > 0 ? "&" : "?";
            a.attr("src", b + d + "wmode=opaque").addClass("js-opaque"), c(this).after(a).remove()
        });
        var d = c("object", a);
        d.size() && d.each(function () {
            var a = c(this).clone();
            a.addClass("js-opaque"), c('<param name="wmode" value="opaque">').appendTo(a), c("embed", a).attr({wmode: "opaque"}), c(this).after(a).remove()
        })
    }

    function Q(a, b) {
        a.is(":visible") ? b() : setTimeout(function () {
            Q(a, b)
        }, 100)
    }

    function R(e) {
        function cd() {
            cb = !0, clearTimeout(cc), f().arrows && bX.css(J(0)), bQ.removeClass("fotorama__wrap_mouseout"), setTimeout(function () {
                f().arrows && bX.css(J(f().transitionDuration)), setTimeout(function () {
                    bQ.addClass("fotorama__wrap_mouseover")
                }, 1)
            }, 1)
        }

        function ce() {
            clearTimeout(cc), !bA && !cb && bQ.removeClass("fotorama__wrap_mouseover").addClass("fotorama__wrap_mouseout")
        }

        function cA(a, b, d, e, g, i) {
            var j = c(a);
            e = be.i.test(g) ? bf ? bf : 1 : e;
            var k = f().vertical ? Math.round(cl / e) : Math.round(cl * e);
            h ? (j.remove(), j = c('<canvas class="fotorama__thumb__img"></canvas>'), j.appendTo(cz.eq(i))) : j.addClass("fotorama__thumb__img");
            var l = {};
            l[bO] = k, l[bP] = cl, j.attr(l).css(l).css({visibility: "visible"}), h && !be.i.test(g) && j[0].getContext("2d").drawImage(a, 0, 0, f().vertical ? cl : k, f().vertical ? k : cl), l[bP] = null, cz.eq(i).css(l).data(l), cR()
        }

        function cB(a) {
            !bG && !bD && !bB && !br ? (a || (a = 0), cU(a, cz.eq(a), cA, "thumb"), setTimeout(function () {
                a + 1 < C && cB(a + 1)
            }, 50)) : setTimeout(function () {
                cB(a)
            }, 100)
        }

        function cE(a, b, d) {
            a && (be.no.test(a) || be.px.test(a) ? (T = L(K(a), X, Y), V = T, bd = !1, bc = !1) : be["%"].test(a) ? (ba = Number(String(a).replace("%", "")) / 100, bd = !f().flexible, T || (T = e.width() * (bp ? 1 : ba) - cy, T = L(T, X, Y)), bc = !1) : bc = !0), b && (be.no.test(b) || be.px.test(b) ? (U = L(K(b), Z, _), W = U, bb = !1) : bb = !0);
            if (a == "auto" || !a || b == "auto" || !b) {
                var g = Number(d), h = ck.filter(function () {
                    return c(this).data("state") != "error"
                }).filter(":first").data("srcKey");
                if (isNaN(g) || !g)g = null, h && (g = D[h].imgRatio);
                if (g) {
                    bf = g, bg = g, bh = g;
                    if (h) {
                        if (a == "auto" || !a)T = L(K(D[h].imgWidth), X, Y), V = T, bc = !0;
                        if (b == "auto" || !b)U = L(K(D[h].imgHeight), Z, _), W = U, bb = !0
                    }
                    bb && g && !bc && (U = L(Math.round(T / g), Z, _), W = U), !bb && g && bc && (T = L(Math.round(U * g), X, Y), V = T)
                }
            }
        }

        function cF(a) {
            var b;
            if (f().fitToWindowHeight || bp)b = x.height();
            if (!bf || a)bf = T / U, bg = bf, bh = bf;
            f().thumbs && !cp && (cp = f().vertical ? co.width() : co.height()), bo ? bf = bh : bf = bg, e.css({overflow: bd || bp ? "hidden" : ""}), bd || bp ? (T = e.width() * (bp ? 1 : ba) - (f().vertical && cp && (!bp || !f().hideNavIfFullscreen) ? cp : 0), bp || (T = L(T, X, Y))) : V && (T = V), bp ? (U = b - (!f().vertical && cp && !f().hideNavIfFullscreen ? cp : 0), bf = T / U) : bb ? (U = L(Math.round(T / bf), Z, _), bf = T / U) : (U = W, bf = T / U);
            if (f().fitToWindowHeight && !bp) {
                var c = b - f().fitToWindowHeightMargin - (!f().vertical && cp ? cp : 0);
                U > c && (U = L(c, Z, _), bf = T / U)
            }
        }

        function cH(a, b, d) {
            cF(a), b || (b = 0);
            var e = T != bj || U != bk || bf != bl, h = a || e;
            if (h) {
                f().vertical ? (R = U, S = T) : (R = T, S = U), bQ.add(ck).animate({width: T, height: U}, b), f().thumbs && f().vertical && (f().thumbsOnRight ? co.animate({left: T}, b) : bQ.animate({left: !bp || !f().hideNavIfFullscreen ? cp : 0}, b));
                var i;
                f().touchStyle ? (by = (R + f().margin) * C - f().margin, bz = S, i = {}, i[bO] = by, i[bP] = bz, bR.animate(i, b).data(i).data({minPos: -(by - R), maxPos: 0})) : bR.animate({width: T, height: U}, b), f().thumbs && (f().vertical ? co.animate({height: U}, b) : co.animate({width: T}, b), f().thumbsPreview && e && cR(b, d), co.css({visibility: "visible"})), n && !f().vertical && (f().arrows && bX.animate({top: U / 2}, b), i = {}, i[bL] = S / 2, bS.animate(i, b));
                if (g == "loading" || g == "error")i = {}, i[bK] = (f().touchStyle ? cg : 0) * (R + f().margin) + R / 2, bS.animate(i, b);
                if (cf && f().touchStyle) {
                    var j = -cg * (R + f().margin);
                    cN(bR, j, 0)
                }
                bm = !0;
                var k = 0;
                c(cG).each(function () {
                    clearTimeout(this)
                }), cG = [], cS(cf, cg, b), ck.each(function (a) {
                    if (a != cg) {
                        var b = c(this), d = b.data("img");
                        d && b.data("img").css({visibility: "hidden"});
                        var e = setTimeout(function () {
                            cS(b, a)
                        }, k * 50 + 50);
                        cG.push(e), k++
                    }
                })
            }
            bj = T, bk = U, bl = bf
        }

        function cI() {
            var a = cf.data("srcKey");
            a && D[a].imgWidth && D[a].imgHeight && D[a].imgRatio && (T = D[a].imgWidth, V = T, U = D[a].imgHeight, W = U, bf = D[a].imgRatio, bg = bf, cH(!1, f().transitionDuration))
        }

        function cJ(a, b, c) {
            function d() {
                f().touchStyle || (b = 0), bS.css(bK, b * (R + f().margin) + R / 2), bT = setTimeout(function () {
                    bS.stop().fadeTo(n ? 0 : u, 1)
                }, 100)
            }

            clearTimeout(bT), a == "loading" ? (d(), e.addClass("fotorama_loading").removeClass("fotorama_error"), l.spin(bS[0])) : a == "error" ? (d(), e.addClass("fotorama_error").removeClass("fotorama_loading"), l.stop()) : a == "loaded" && (e.removeClass("fotorama_loading fotorama_error"), bS.stop().fadeTo(Math.min(n ? 0 : u), 0, function () {
                l.stop()
            })), g = a
        }

        function cK() {
            return{index: cg, src: D[cg], img: cf[0], thumb: f().thumbs ? cm[0] : null, caption: ch}
        }

        function cL(a) {
            clearInterval(a.data("backAnimate"))
        }

        function cM() {
            f().onTransitionStop && f().onTransitionStop.call(e[0], cK())
        }

        function cN(a, b, c, d) {
            var e = isNaN(b) ? 0 : Math.round(b);
            cL(a), d ? (e = d, q && f().cssTransitions && a.data({backAnimate: setInterval(function () {
                var e = I(a, bK, f().cssTransitions);
                Math.abs(e - d) < 1 && cN(a, b, Math.max(u, c / 2))
            }, 10)})) : setTimeout(function () {
                cM()
            }, c + 10), c && (clearTimeout(bs), br = !0), q && f().cssTransitions ? (a.css(J(c)), a.css(G(e, f().vertical))) : a.stop().animate(G(e, f().vertical, !f().cssTransitions), c, t, function () {
                d && cN(a, b, Math.max(u, c / 2))
            }), bs = setTimeout(function () {
                br = !1, f().flexible && a == bR && cI()
            }, c)
        }

        function cO() {
            if (cr > R || !f().thumbsCentered)cq.data({minPos: cr > R ? -(cr - R) : f().thumbMargin}), bD || cq.data({maxPos: f().thumbMargin}); else {
                var a = R / 2 - cr / 2;
                cq.data({minPos: a}), bD || cq.data({maxPos: a})
            }
        }

        function cP(a, b, c) {
            a *= 1.1;
            if (cr) {
                if (!c || cr < R)bE = !1;
                var e = cm.position()[bK], g = cm.data()[bO];
                cO();
                if (!g && cx)cw.hide(), cx = !1; else {
                    cx || (cw.show(), cx = !0);
                    if (cr > R) {
                        var h = e + g / 2, i = R / 2, j = cz.index(cm), k = j - cn;
                        cs == d && (cs = cq.position()[bK]);
                        if (bI && b && b > Math.max(36, f().thumbMargin * 2) && b < R - Math.max(36, f().thumbMargin * 2) && (k > 0 && b > i * .75 || k < 0 && b < i * 1.25)) {
                            var l;
                            k > 0 ? l = j + 1 : l = j - 1, l < 0 ? l = 0 : l > C - 1 && (l = C - 1);
                            if (j != l) {
                                var m = cz.eq(l);
                                h = m.position()[bK] + m.data()[bO] / 2, i = b
                            }
                        }
                        var n = -(cr - R), o = Math.round(-(h - i) + f().thumbMargin);
                        if (k > 0 && o > cs || k < 0 && o < cs)e + cs < f().thumbMargin ? o = -(e - f().thumbMargin) : e + cs + g > R ? o = -(e * 2 - R + g + f().thumbMargin) : o = cs;
                        o <= cq.data("minPos") ? o = cq.data("minPos") : o >= f().thumbMargin && (o = f().thumbMargin), cQ(o), bD || cq.data({maxPos: f().thumbMargin})
                    } else o = cq.data("minPos");
                    !bE && !bD ? (cN(cq, o, a, !1), bF && (bE = !0), cs = o) : bF = !0;
                    var p = g - (r ? 0 : f().thumbBorderWidth * 2), s = e;
                    a *= .9, q && f().cssTransitions ? (cw.css(J(a)), cw.css(G(s, f().vertical)).css(bO, p)) : f().vertical ? cw.stop().animate({top: s, height: p}, a, t) : cw.stop().animate({left: s, width: p}, a, t)
                }
            }
        }

        function cQ(a) {
            f().shadows && (cr > R ? (co.addClass("fotorama__thumbs_shadow"), a <= cq.data("minPos") ? co.removeClass("fotorama__thumbs_shadow_no-left").addClass("fotorama__thumbs_shadow_no-right") : a >= f().thumbMargin ? co.removeClass("fotorama__thumbs_shadow_no-right").addClass("fotorama__thumbs_shadow_no-left") : co.removeClass("fotorama__thumbs_shadow_no-left fotorama__thumbs_shadow_no-right")) : co.removeClass("fotorama__thumbs_shadow"))
        }

        function cR(a, b) {
            cr = cq[bO](), cO(), cP(a ? a : 0, !1, !b)
        }

        function cS(a, b, c) {
            var d = a.data("img"), e = a.data("detached");
            c = c ? c : 0;
            if (d && !e) {
                var g = a.data("srcKey"), h = D[g].imgWidth, i = D[g].imgHeight, j = D[g].imgRatio, k = 0, l = 0;
                f().touchStyle && a.css(bK, b * (R + f().margin));
                if (h != T || i != U || f().alwaysPadding || bp) {
                    var m = 0;
                    if (j / bf < .99 || j / bf > 1.01 || f().alwaysPadding || bp)m = f().minPadding * 2;
                    j >= bf ? !bp && !f().cropToFit || bp && !f().cropToFitIfFullscreen ? (h = Math.round(T - m) < h || f().zoomToFit || bp ? Math.round(T - m) : h, i = Math.round(h / j), U - i < 4 && (i += U - i)) : (i = U, h = Math.round(i * j)) : !bp && !f().cropToFit || bp && !f().cropToFitIfFullscreen ? (i = Math.round(U - m) < i || f().zoomToFit || bp ? Math.round(U - m) : i, h = Math.round(i * j), T - h < 4 && (h += T - h)) : (h = T, i = Math.round(h / j))
                }
                if (h && i) {
                    var n = {width: h, height: i};
                    i != U && (k = Math.round((U - i) / 2)), h != T && (l = Math.round((T - h) / 2)), d.attr(n), n.top = k, n.left = l, d.animate(n, c)
                }
                d.css({visibility: "visible"}), cV(a, b)
            } else d && e && a.data({needToResize: !0})
        }

        function cT(a, b) {
            return a === " " ? "ё" + b : a
        }

        function cU(a, b, d, e) {
            function o(c) {
                function k() {
                    h.css({visibility: "hidden"}), g.src = c;
                    if (j == 0) {
                        h.appendTo(b);
                        if (e == "thumb") {
                            var a = f().vertical ? Math.round(cl / (f().aspectRatio ? f().aspectRatio : bf ? bf : 1)) : Math.round(cl * (f().aspectRatio ? f().aspectRatio : bf ? bf : 1));
                            b.css(bO, a).data(bO, a), cR()
                        }
                    }
                }

                function l() {
                    bJ++, bJ == C && (bI = !0)
                }

                function m() {
                    be.i.test(c) || (H[c] = "loaded"), h.unbind("error load").error(function () {
                        h.unbind("error"), g.src = c, D[a].imgRel = !1, cS(ck.eq(a), a)
                    }), setTimeout(function () {
                        Q(b, function () {
                            D[c] || (D[c] = [], D[c].imgWidth = h.width(), D[c].imgHeight = h.height(), D[c].imgWidth || (D[c].imgWidth = b.data("html") ? b.data("html").width() || v : v), D[c].imgHeight || (D[c].imgHeight = b.data("html") ? b.data("html").height() || w : w), D[c].imgRatio = D[c].imgWidth / D[c].imgHeight), b.trigger("fotoramaload").data({state: "loaded"}), d(g, D[c].imgWidth, D[c].imgHeight, D[c].imgRatio, c, a)
                        })
                    }, 100), e == "thumb" && l()
                }

                function n() {
                    m()
                }

                function p(a) {
                    H[c] = "error", h.unbind("error load"), j < i.length && a ? (j++, be.i.test(i[j]) && p(!0), o(i[j])) : (b.trigger("fotoramaerror").data({state: "error"}), e == "thumb" && l())
                }

                if (!H[c])be.i.test(c) ? n() : (H[c] = "loading", h.unbind("error load").bind("error",function () {
                    p(!0)
                }).bind("load", n), k()); else {
                    function q() {
                        H[c] == "error" ? p(!1) : H[c] == "loaded" ? n() : setTimeout(q, 100)
                    }

                    k(), q()
                }
            }

            var g = new Image, h = c(g), i = [], j = 0, k = cT(D[a].imgHref, a), l = cT(D[a].imgSrc, a), m = cT(D[a].thumbSrc, a), n = e == "img" ? "push" : "unshift";
            k && i[n](k), l && i[n](l), m && i[n](m), o(i[j])
        }

        function cV(a, b) {
            var c = a.data("img"), d = a.data("srcKey"), e = D[b].imgRel;
            if (c && e && e != d && !m) {
                var f = c.data("full"), g = a.data("detached");
                (bp && !f || !bp && f) && !g && (c[0].src = bp ? e : d, c.data({full: bp}))
            }
        }

        function cW(a, b) {
            if (!a.data("wraped")) {
                bR.append(a.data({state: "loading"})), b != cg && !f().touchStyle && a.stop().fadeTo(0, 0);
                function d(d, e, g, h, i) {
                    var j = c(d);
                    j.addClass("fotorama__img"), a.data({img: j, srcKey: i});
                    var k = !1;
                    if ((!T || !U) && !bm || !bn && b == f().startImg) {
                        T = e, f().width = e;
                        if (bb)U = g, f().height = g; else if (bc) {
                            var l = e / g;
                            T = Math.round(U * l), f().width = T
                        }
                        f().aspectRatio || (f().aspectRatio = T / U), k = !0, bn = b == f().startImg
                    }
                    k || f().flexible ? cH(!0) : cS(a, b), a.css({visibility: "visible"})
                }

                a.data({wraped: !0, detached: !1});
                if (B && p[b].html && p[b].html.length || f().html && f().html[b] && f().html[b].length) {
                    var e = p[b].html || f().html[b];
                    n && f().html && f().html[b] && f()._html && f()._html[b] && e.html(f()._html[b]);
                    var g = c(e);
                    a.append(e).data({html: g, htmlIsIframe: g.is("iframe")}), P(a)
                }
                cU(b, a, d, "img")
            } else f().detachSiblings && a.data("detached") && (a.data({detached: !1}).appendTo(bR), a.data("needToResize") && (cS(a, b), a.data({needToResize: !1})))
        }

        function cX(a, b) {
            var d = 0, e = !1, g = [], h = [], j = bp ? Math.min(1, f().preload) : f().preload;
            for (i = 0; i < j * 2 + 1; i++) {
                var k = b - j + i;
                if (k >= 0 && k < C && !f().loop || f().loop) {
                    k < 0 && (k = C + k), k > C - 1 && (k = k - C);
                    if (!ck.eq(k).data("wraped") || ck.eq(k).data("detached"))d++, g.push(k);
                    h.push(k)
                } else e = !0
            }
            if (d >= j || e)c(g).each(function (a) {
                var b = a * 50;
                setTimeout(function () {
                    cW(ck.eq(g[a]), g[a])
                }, b)
            }), f().detachSiblings && ck.filter(function (a) {
                var d = c(this), e = !1;
                for (var f = 0; f < h.length && !e; f++)h[f] == a && (e = !0);
                return d.data("state") != "loading" && !e && b != a
            }).data({detached: !0}).detach();
            if (ci.data("htmlIsIframe")) {
                var l = ci.html();
                ci.html("").html(l)
            }
        }

        function cY() {
            (cg == 0 || C < 2) && !f().loop ? bY.addClass("fotorama__arr_disabled").data("disabled", !0) : bY.removeClass("fotorama__arr_disabled").data("disabled", !1), (cg == C - 1 || C < 2) && !f().loop ? bZ.addClass("fotorama__arr_disabled").data("disabled", !0) : bZ.removeClass("fotorama__arr_disabled").data("disabled", !1)
        }

        function cZ() {
            location.replace(location.protocol + "//" + location.host + location.pathname + location.search + "#" + (cg + 1))
        }

        function c$(a) {
            a || (a = 0), clearTimeout(bx), bx = setTimeout(function () {
                cf.data("state") != "loading" ? bw && e.trigger("showimg", [cg + 1, !1, !0]) : cf.bind("fotoramaload fotoramaerror", function () {
                    c$(a)
                })
            }, Math.max(f().autoplay, a * 2))
        }

        function c_(a, b, d, h, i, j, k, l) {
            function o() {
                f().caption && (ch = p[n].caption ? p[n].caption : p[n].title, ch ? cC.html(ch).show() : cC.html("").hide())
            }

            function r() {
                if (f().shadows || !f().touchStyle)ci.removeClass("fotorama__frame_active"), a.addClass("fotorama__frame_active")
            }

            var m, n = ck.index(a);
            ck.each(function () {
                c(this).unbind("fotoramaload fotoramaerror")
            }), typeof i != "number" && (h ? i = 0 : i = f().transitionDuration), !h && b && b.altKey && (i = i * 10);
            var q = a.data("state");
            q == "loading" || !q ? (cJ("loading", n, i), a.one("fotoramaload", function () {
                cJ("loaded", n, i), o()
            }), a.one("fotoramaerror", function () {
                cJ("error", n, i), o()
            })) : q == "error" ? cJ("error", n, i) : q != g && cJ("loaded", n, i), o(), cf ? (ci = cf, m = cg, f().thumbs && (cj = cm)) : (ci = ck.not(a), f().thumbs && (cj = cz.not(cz.eq(n)))), f().thumbs && (cm = cz.eq(n), m && (cn = m), cj.removeClass("fotorama__thumb_selected").data("disabled", !1), cm.addClass("fotorama__thumb_selected").data("disabled", !0)), f().thumbs && f().thumbsPreview && (m != n || h) && cP(i, d);
            if (f().touchStyle) {
                var s = -n * (R + f().margin);
                r(), cN(bR, s, i, j)
            } else if (f().transition == "crossFade")ck.not(ci.stop()).stop().fadeTo(0, 0), a.stop().fadeTo(i, 1), ci.not(a).stop().fadeTo(i, 0, function () {
                cM(), f().flexible && cI()
            }); else if (m != n || h) {
                var t = i, v = 0;
                q != "loaded" && (t = 0, v = i), ck.not(ci.stop()).stop().fadeTo(0, 0), setTimeout(function () {
                    r(), a.stop().fadeTo(t, 1, function () {
                        ci.not(a).stop().fadeTo(v, 0, function () {
                            f().flexible && cI()
                        }), cM()
                    })
                }, 10)
            }
            cf = a, cg = n, f().hash && cZ(), bw && !k && f().stopAutoplayOnAction && (bw = !1), c$(i);
            var w = cK();
            e.data(w), f().arrows && cY();
            var x = a.data("wraped");
            clearTimeout(bv), bv = setTimeout(function () {
                !x && n != f().startImg && (cW(a, n), f().onShowImg && !l && f().onShowImg.call(e[0], w, k)), cX(a, n)
            }, (i ? Math.max(i / 2, u) : 0) * 1.1);
            if (x || n == f().startImg)cW(a, n), f().onShowImg && !l && f().onShowImg.call(e[0], w, k)
        }

        function da(a, b) {
            b.stopPropagation(), b.preventDefault();
            var c = cg + a;
            c < 0 && (c = f().loop ? C - 1 : 0), c > C - 1 && (c = f().loop ? 0 : C - 1), c_(ck.eq(c), b)
        }

        function dc(a, b) {
            clearTimeout(db), db = setTimeout(function () {
                cH(b)
            }, 10)
        }

        function dd() {
            bq || (x.bind("resize", dc), j && a.addEventListener("orientationchange", dc, !1), bq = !0)
        }

        function de(a) {
            a.stopPropagation();
            var b = c(this);
            if (!b.data("disabled")) {
                var d = cz.index(c(this)), e = a[bM] - co.offset()[bK];
                c_(ck.eq(d), a, e)
            }
        }

        function df(a, b, c, d) {
            function z(a, b) {
                return Math.round(a + (b - e) / 1.5)
            }

            function A(c) {
                if ((j || c.which < 2) && cf) {
                    function d() {
                        m = (new Date).getTime(), i = g, k = h, n = [
                            [m, g]
                        ], cL(a), q && f().cssTransitions ? a.css(J(0)) : a.stop(), e = I(a, bK, f().cssTransitions), a.css(G(e, f().vertical, !f().cssTransitions)), l = e, b(), x = !1
                    }

                    j ? j && c.targetTouches.length == 1 ? (g = c.targetTouches[0][bM], h = c.targetTouches[0][bN], d(), a[0].addEventListener("touchmove", B, !1), a[0].addEventListener("touchend", C, !1)) : j && c.targetTouches.length > 1 && c.preventDefault() : (g = c[bM], c.preventDefault(), d(), y.mousemove(B), y.mouseup(C))
                }
            }

            function B(b) {
                function d() {
                    b.preventDefault(), o = (new Date).getTime(), n.push([o, g]);
                    var d = i - g;
                    e = l - d, e > a.data("maxPos") ? (e = z(e, a.data("maxPos")), w = "left") : e < a.data("minPos") ? (e = z(e, a.data("minPos")), w = "right") : w = !1, f().touchStyle && a.css(G(e, f().vertical, !f().cssTransitions)), c(e, d, w)
                }

                j ? j && b.targetTouches.length == 1 && (g = b.targetTouches[0][bM], h = b.targetTouches[0][bN], v ? u === !0 && d() : Math.abs(g - i) - Math.abs(h - k) >= -5 ? (u = !0, v = !0) : Math.abs(h - k) - Math.abs(g - i) >= -5 && (u = "prevent", v = !0)) : (g = b[bM], d())
            }

            function C(b) {
                if ((!j || !b.targetTouches.length) && x === !1) {
                    j ? (a[0].removeEventListener("touchmove", B, !1), a[0].removeEventListener("touchend", C, !1)) : (y.unbind("mouseup"), y.unbind("mousemove")), r = (new Date).getTime();
                    var c = -e, f = r - s, h, i, k, l;
                    for (var m = 0; m < n.length; m++)h = Math.abs(f - n[m][0]), m == 0 && (i = h, k = r - n[m][0], l = n[m][1]), h <= i && (i = h, k = n[m][0], l = n[m][1]);
                    var o = l - g, q = o >= 0, w = r - k, z = w <= s, A = r - t, D = q === p;
                    d(c, w, z, A, D, o, b, u), t = r, p = q, u = !1, v = !1, x = !0
                }
            }

            var e, g, h, i, k, l, m, n = [], o, p, r, t = 0, u = !1, v = !1, w = !1, x;
            j ? a[0].addEventListener("touchstart", A, !1) : a.mousedown(A), !j
        }

        var f = function () {
            return e.data("options")
        };
        f().backgroundColor && !f().background && (f().background = f().backgroundColor), f().thumbsBackgroundColor && !f().navBackground && (f().navBackground = f().thumbsBackgroundColor), f().thumbColor && !f().dotColor && (f().dotColor = f().thumbColor), f().click !== null && (f().pseudoClick = f().click);
        if (f().nav === !0 || f().nav == "true" || f().nav == "thumbs")f().thumbs = !0, f().thumbsPreview = !0; else if (f().nav == "dots")f().thumbs = !0, f().thumbsPreview = !1; else if (f().nav === !1 || f().nav == "false" || f().nav == "none")f().thumbs = !1;
        if (f().transition === "fade" || f().transition === "crossFade")f().touchStyle = !1;
        f().cropToFit && (f().cropToFitIfFullscreen = !0), f().thumbsPreview && f().background && !f().navBackground && (f().navBackground = f().background), f().caption && (f().caption === !0 || f().caption == "true" || f().caption == "simple" ? f().caption = !0 : f().caption != "overlay" && (f().caption = !1)), f().navPosition == "top" ? (f().thumbsOnTop = !0, f().thumbsOnRight = !1) : f().navPosition == "right" ? (f().thumbsOnTop = !1, f().thumbsOnRight = !0) : f().navPosition == "bottom" ? (f().thumbsOnTop = !1, f().thumbsOnRight = !1) : f().navPosition == "left" && (f().thumbsOnTop = !1, f().thumbsOnRight = !1);
        var g;
        f().hash && b.location.hash && (f().startImg = parseInt(b.location.hash.replace("#", "")) - 1);
        var l = new Spinner({length: 8, radius: 6, width: 2, rotate: 15}), p, B = f().data && (typeof f().data == "object" || typeof f().data == "string");
        B ? p = c(f().data).filter(function () {
            return this.img || this.img === " " || this.href || this.href === " "
        }) : p = e.children().filter(function () {
            var a = c(this), b = a.children("img"), d = (a.is("a") && b.length || a.is("img")) && (a.attr("href") || a.attr("href") === " " || a.attr("src") || a.attr("src") === " " || b.attr("src") || b.attr("src") === " "), e = a.is(":empty");
            return d || a.data({html: !0}), d || !e
        });
        var C = p.size();
        e.data({size: C}), f().preload = Math.min(f().preload, C);
        if (f().startImg > C - 1 || typeof f().startImg != "number")f().startImg = 0;
        var D = [];
        p.each(function (a) {
            if (!B) {
                var b = c(this);
                if (!b.data("html")) {
                    var d = b.children();
                    D[a] = {imgHref: b.attr("href"), imgSrc: b.attr("src"), thumbSrc: d.attr("src"), imgRel: b.attr("rel") ? b.attr("rel") : d.attr("rel")}, this.caption = b.attr("alt") || d.attr("alt")
                } else D[a] = {imgHref: b.attr("data-img") || " ", thumbSrc: b.attr("data-thumb"), imgRel: b.attr("data-full")}, this.caption = this.caption || b.attr("data-caption"), f().html || (f().html = {}), f().html[a] = b, n && (f()._html || (f()._html = {}), f()._html[a] = b.html())
            } else D[a] = {imgHref: this.img ? this.img : this.href ? this.href : this.length ? String(this) : null, thumbSrc: this.thumb, imgRel: this.full}
        }), e.html("").addClass("fotorama " + (f().vertical ? "fotorama_vertical" : "fotorama_horizontal")), r && e.addClass("fotorama_quirks");
        if (o || m)var F = e.wrap('<div class="fotorama-outer"></div>').parent();
        f().arrows || (f().loop = !0);
        var H = [], R, S, T, U, V, W, X = K(f().minWidth), Y = K(f().maxWidth), Z = K(f().minHeight), _ = K(f().maxHeight), ba = 1, bb = !0, bc = !0, bd, be = {no: /^[0-9.]+$/, px: /^[0-9.]+px$/, "%": /^[0-9.]+%$/, i: /^ё\d+$/}, bf, bg, bh, bi, bj, bk, bl, bm, bn, bo, bp, bq, br, bs, bt, bu, bv, bw, bx;
        if (f().autoplay === !0 || f().autoplay == "true" || f().autoplay > 0)bw = !0;
        typeof f().autoplay != "number" && (f().autoplay = 5e3);
        if (f().touchStyle)var by = 0, bz, bA = !1, bB = !1, bC;
        if (f().thumbs && f().thumbsPreview)var bD = !1, bE = !1, bF = !1, bG = !1, bH, bI = !1, bJ = 0;
        var bK, bL, bM, bN, bO, bP;
        f().vertical ? (bK = "top", bL = "left", bM = "pageY", bN = "pageX", bO = "height", bP = "width") : (bK = "left", bL = "top", bM = "pageX", bN = "pageY", bO = "width", bP = "height");
        var bQ = c('<div class="fotorama__wrap"></div>').appendTo(e), bR = c('<div class="fotorama__shaft"></div>').appendTo(bQ);
        f().touchStyle || (N(bQ), N(bR));
        var bS = c('<div class="fotorama__state"></div>').appendTo(bR);
        k && c(E("svg", {viewBox: "0 0 32 32"})).append(c(E("g", {fill: "none", stroke: f().spinnerColor, "stroke-width": 2})).append(E("circle", {cx: 16, cy: 16, r: 13})).append(E("line", {x1: 7, y1: 7, x2: 25, y2: 25}))).appendTo(bS), f().noise && c('<div class="fotorama__noise"></div>').prependTo(bQ);
        var bT;
        if (f().fullscreenIcon && !f().fullscreen)var bU = c('<div class="fotorama__fsi"><i class="i1"><i class="i1"></i></i><i class="i2"><i class="i2"></i></i><i class="i3"><i class="i3"></i></i><i class="i4"><i class="i4"></i></i><i class="i0"></i></div>').appendTo(bQ);
        j && e.addClass("fotorama_touch"), m && (f().shadows = !1), f().touchStyle ? bQ.addClass("fotorama__wrap_style_touch") : bQ.addClass("fotorama__wrap_style_fade"), f().shadows && e.addClass("fotorama_shadows"), q && f().cssTransitions && e.addClass("fotorama_csstransitions");
        if (f().arrows) {
            var bV, bW;
            f().vertical ? (bV = f().arrowPrev ? f().arrowPrev : "&#9650;", bW = f().arrowNext ? f().arrowNext : "&#9660;") : (bV = f().arrowPrev ? f().arrowPrev : "&#9664;", bW = f().arrowNext ? f().arrowNext : "&#9654;");
            var bX = c('<i class="fotorama__arr fotorama__arr_prev">' + bV + '</i><i class="fotorama__arr fotorama__arr_next">' + bW + "</i>").appendTo(bQ), bY = bX.eq(0), bZ = bX.eq(1);
            N(bX);
            var b$, b_;

            function ca() {
                clearTimeout(b_), b_ = setTimeout(function () {
                    var a = b$ >= R / 2;
                    bZ[a ? "addClass" : "removeClass"]("fotorama__arr_hover"), bY[a ? "removeClass" : "addClass"]("fotorama__arr_hover"), f().touchStyle || bR.css({cursor: a && bZ.data("disabled") || !a && bY.data("disabled") ? "default" : "pointer"})
                }, 10)
            }

            j || f().pseudoClick && bQ.mousemove(function (a) {
                b$ = a[bM] - bQ.offset()[bK], ca()
            })
        } else!f().touchStyle && f().pseudoClick && C > 1 && bR.css({cursor: "pointer"});
        var cb = !1, cc;
        j || (bQ.mouseenter(function () {
            cd()
        }), bQ.mouseleave(function () {
            cb = !1, ce()
        }));
        var cf, cg, ch, ci, cj, ck = c();
        p.each(function (a) {
            var b = c('<div class="fotorama__frame" style="visibility: hidden;"></div>');
            ck = ck.add(b)
        });
        if (f().thumbs) {
            var cl = Number(f().thumbSize);
            if (isNaN(cl) || !cl)cl = f().vertical ? 64 : 48;
            var cm, cn = 0, co = c('<div class="fotorama__thumbs" style="visibility: hidden;"></div>')[f().thumbsOnTop ? "prependTo" : "appendTo"](e), cp, cq = c('<div class="fotorama__thumbs-shaft"></div>').appendTo(co);
            f().touchStyle || N(co);
            if (f().thumbsPreview) {
                cp = cl + f().thumbMargin * 2, co.addClass("fotorama__thumbs_previews").css(bP, cp);
                var cr = 0, cs = d, ct = cl - (r ? 0 : f().thumbBorderWidth * 2), cu = f().thumbMargin, cv = {};
                cv[bP] = ct, cv[bL] = cu, cv.borderWidth = f().thumbBorderWidth;
                var cw = c('<i class="fotorama__thumb-border"></i>').css(cv).appendTo(cq), cx
            }
            var cy = f().vertical && co ? co.width() : 0;
            e.css({minWidth: X + cy}), p.each(function (a) {
                var b;
                if (f().thumbsPreview) {
                    b = c('<div class="fotorama__thumb"></div>');
                    var d = {};
                    d[bP] = cl, d.margin = f().thumbMargin, b.css(d)
                } else b = c('<i class="fotorama__thumb"><i class="fotorama__thumb__dot"></i></i>');
                b.appendTo(cq)
            });
            var cz = c(".fotorama__thumb", e)
        }
        if (f().caption) {
            var cC = c('<p class="fotorama__caption"></p>');
            if (f().caption == "overlay")cC.appendTo(bQ).addClass("fotorama__caption_overlay"); else {
                cC.appendTo(e);
                var cD = cC.wrap('<div class="fotorama__caption-outer"></div>').parent()
            }
        }
        cE(f().width, f().height, f().aspectRatio);
        var cG = [];
        c_(ck.eq(f().startImg), !1, !1, !0, !1, !1, !0), T && U && (bn = !0, cH()), f().thumbs && f().thumbsPreview && cB(0), f().thumbs && (f().dotColor && !f().thumbsPreview && cz.children().css({backgroundColor: f().dotColor}), f().navBackground && co.css({background: f().navBackground}), f().thumbsPreview && f().thumbBorderColor && cw.css({borderColor: f().thumbBorderColor})), f().background && bQ.add(f().touchStyle ? !1 : ck).css({background: f().background}), f().arrowsColor && f().arrows && bX.css({color: f().arrowsColor});
        var db = !1;
        dd(), e.bind("dblclick", O), e.bind("showimg", function (a, b, c, d) {
            typeof b != "number" && (b == "next" ? b = cg + 1 : b == "prev" ? b = cg - 1 : b == "first" ? b = 0 : b == "last" ? b = C - 1 : (b = cg, d = !0)), b > C - 1 && (b = 0), (!f().touchStyle || !bB) && c_(ck.eq(b), a, !1, !1, c, !1, d)
        }), e.bind("play", function (a, b) {
            bw = !0, b = Number(b), isNaN(b) || (f().autoplay = b), c$(u)
        }), e.bind("pause", function () {
            bw = !1
        }), e.bind("rescale", function (a, b, c, d, e) {
            cE(b, c, d), bf = T / U, bh = bf, bo = !bd, e = Number(e), isNaN(e) && (e = 0), cH(!1, e)
        }), e.bind("fullscreenopen", function () {
            bt = x.scrollTop(), bu = x.scrollLeft(), bp = !0, bU && bU.trigger("mouseleave", !0), x.scrollLeft(0).scrollTop(0), setTimeout(function () {
                z.add(A).addClass("fullscreen"), e.addClass("fotorama_fullscreen"), (o || m) && e.appendTo(A).addClass("fotorama_fullscreen_quirks"), f().caption && !f().caption != "overlay" && cC.appendTo(bQ), f().thumbs && f().hideNavIfFullscreen && co.hide(), dd(), cf && c_(cf, !1, !1, !0, 0, !1, !0, !0), cH(!1, !1, !0), f().onFullscreenOpen && f().onFullscreenOpen.call(e[0], cK())
            }, 0)
        }), e.bind("fullscreenclose", function () {
            bp = !1, bU && bU.trigger("mouseleave", !0), z.add(A).removeClass("fullscreen"), e.removeClass("fotorama_fullscreen"), (o || m) && e.appendTo(F).removeClass("fotorama_fullscreen_quirks"), f().caption && !f().caption != "overlay" && cC.appendTo(cD), bd || (T = f().width, U = f().height), f().thumbs && f().hideNavIfFullscreen && co.show(), cf && c_(cf, !1, !1, !0, 0, !1, !0, !0), f().flexible ? cI() : cH(!1, !1, !0), x.scrollLeft(bu).scrollTop(bt), f().onFullscreenClose && f().onFullscreenClose.call(e[0], cK())
        }), e.bind("reset", function () {
            dc({type: "resize"}, !0)
        }), y.bind("keydown", function (a) {
            bp && (a.keyCode == 27 && !f().fullscreen ? (a.preventDefault(), e.trigger("fullscreenclose")) : a.keyCode == 39 || a.keyCode == 40 ? e.trigger("showimg", cg + 1) : (a.keyCode == 37 || a.keyCode == 38) && e.trigger("showimg", cg - 1))
        }), f().thumbs && cz.bind("click", de), f().arrows && (bY.bind("click", function (a) {
            c(this).data("disabled") || da(-1, a)
        }), bZ.bind("click", function (a) {
            c(this).data("disabled") || da(1, a)
        })), !f().touchStyle && !j && f().pseudoClick && bQ.bind("click", function (a) {
            if (f().html) {
                var b, d;
                b = c(a.target), d = b.filter("a"), d.length || (d = b.parents("a"))
            }
            if (!d || !d.length) {
                var g = a[bM] - bQ.offset()[bK] >= R / 2;
                if (f().onClick)var h = f().onClick.call(e[0], cK());
                h !== !1 && (!a.shiftKey && g && f().arrows || a.shiftKey && !g && f().arrows || !f().arrows && !a.shiftKey ? da(1, a) : da(-1, a))
            }
        }), bU && bU.bind("click",function (a) {
            a.stopPropagation(), e.trigger(bp ? "fullscreenclose" : "fullscreenopen")
        }).bind("mouseenter mouseleave", function (a, b) {
            b && a.stopPropagation(), bU[a.type == "mouseenter" ? "addClass" : "removeClass"]("fotorama__fsi_hover")
        }), f().fullscreen && e.trigger("fullscreenopen");
        if (f().touchStyle || j) {
            var dg = !1;

            function dh() {
                bB = !0
            }

            function di(a, b, d) {
                clearTimeout(bC), bA || (f().shadows && bQ.addClass("fotorama__wrap_shadow"), j || bR.addClass("fotorama__shaft_grabbing"), bA = !0), f().shadows && (d ? bQ.addClass("fotorama__wrap_shadow_no-" + d).removeClass("fotorama__wrap_shadow_no-" + (d == "left" ? "right" : "left")) : f().shadows && bQ.removeClass("fotorama__wrap_shadow_no-left fotorama__wrap_shadow_no-right")), Math.abs(b) >= 5 && !dg && (dg = !0, c("a", bQ).bind("click", M))
            }

            function dj(a, b, d, g, h, i, k, l) {
                bB = !1, bC = setTimeout(function () {
                    !j && f().arrows && ce(), dg = !1, c("a", bQ).unbind("click", M)
                }, s), j || bR.removeClass("fotorama__shaft_grabbing"), f().shadows && bQ.removeClass("fotorama__wrap_shadow");
                var m = !1, n = !1, o, p;
                f().html && (o = c(k.target), p = o.filter("a"), p.length || (p = o.parents("a")));
                if (f().touchStyle)if (bA) {
                    d && (i <= -10 ? m = !0 : i >= 10 && (n = !0));
                    var q = u, r = Math.round(a / (R + f().margin));
                    if (m || n) {
                        i = -i;
                        var t = i / b, v = Math.round(-a + t * 250), w, x, y = .03;
                        m ? (r = Math.ceil(a / (R + f().margin)) - 1, w = -r * (R + f().margin), v > w && (x = Math.abs(v - w), q = Math.abs(q / (t * 250 / (Math.abs(t * 250) - x * (1 - y)))), x = w + x * y)) : n && (r = Math.floor(a / (R + f().margin)) + 1, w = -r * (R + f().margin), v < w && (x = Math.abs(v - w), q = Math.abs(q / (t * 250 / (Math.abs(t * 250) - x * (1 - y)))), x = w - x * y))
                    }
                    r < 0 && (r = 0, x = !1, q = u), r > C - 1 && (r = C - 1, x = !1, q = u), c_(ck.eq(r), k, !1, !1, q, x)
                } else {
                    if (f().html && p.length)return!1;
                    if (f().onClick && l != "prevent")var z = f().onClick.call(e[0], cK());
                    if (z !== !1 && f().pseudoClick && !j && b < s) {
                        var A = k[bM] - bQ.offset()[bK] >= R / 2;
                        !k.shiftKey && A && f().arrows || k.shiftKey && !A && f().arrows || !f().arrows && !k.shiftKey ? da(1, k) : da(-1, k)
                    } else c_(cf, k, !1, !1, !1, !1, !0)
                } else {
                    if (i == 0 && f().html && p.length)return!1;
                    i >= 0 ? da(1, k) : i < 0 && da(-1, k)
                }
                bA = !1
            }

            df(bR, dh, di, dj);
            if (f().touchStyle && f().thumbs && f().thumbsPreview) {
                var dk = !1;

                function dl() {
                    bD = !0, bE = !0
                }

                function dm(a, b) {
                    !bG && Math.abs(b) >= 5 && (cz.unbind("click", de), dk = !0, clearTimeout(bH), bG = !0), cQ(a)
                }

                function dn(a, b, c, d, e, f, g) {
                    bD = !1, bG = !1, bH = setTimeout(function () {
                        dk && (cz.bind("click", de), dk = !1)
                    }, s), a = -a;
                    var h = a, i, j = u * 2;
                    bF && bG && (cP(0, !1, !1), bF = !1);
                    if (a > cq.data("maxPos"))h = cq.data("maxPos"), j = j / 2; else if (a < cq.data("minPos"))h = cq.data("minPos"), j = j / 2; else if (c) {
                        f = -f;
                        var k = f / b;
                        h = Math.round(a + k * 250);
                        var l = .04;
                        h > cq.data("maxPos") ? (i = Math.abs(h - cq.data("maxPos")), j = Math.abs(j / (k * 250 / (Math.abs(k * 250) - i * (1 - l)))), h = cq.data("maxPos"), i = h + i * l) : h < cq.data("minPos") && (i = Math.abs(h - cq.data("minPos")), j = Math.abs(j / (k * 250 / (Math.abs(k * 250) - i * (1 - l)))), h = cq.data("minPos"), i = h - i * l)
                    }
                    g.altKey && (j = j * 10), cs = h, h != a && (cN(cq, h, j, i), cQ(h))
                }

                df(cq, dl, dm, dn)
            }
        }
    }

    var e = function (a, b, c) {
        function z(a) {
            i.cssText = a
        }

        function A(a, b) {
            return z(l.join(a + ";") + (b || ""))
        }

        function B(a, b) {
            return typeof a === b
        }

        function C(a, b) {
            return!!~("" + a).indexOf(b)
        }

        function D(a, b) {
            for (var d in a) {
                var e = a[d];
                if (!C(e, "-") && i[e] !== c)return b == "pfx" ? e : !0
            }
            return!1
        }

        function E(a, b, d) {
            for (var e in a) {
                var f = b[a[e]];
                if (f !== c)return d === !1 ? a[e] : B(f, "function") ? f.bind(d || b) : f
            }
            return!1
        }

        function F(a, b, c) {
            var d = a.charAt(0).toUpperCase() + a.slice(1), e = (a + " " + n.join(d + " ") + d).split(" ");
            return B(b, "string") || B(b, "undefined") ? D(e, b) : (e = (a + " " + o.join(d + " ") + d).split(" "), E(e, b, c))
        }

        var d = "2.6.2", e = {}, f = b.documentElement, g = "modernizr", h = b.createElement(g), i = h.style, j, k = {}.toString, l = " -webkit- -moz- -o- -ms- ".split(" "), m = "Webkit Moz O ms", n = m.split(" "), o = m.toLowerCase().split(" "), p = {svg: "http://www.w3.org/2000/svg"}, q = {}, r = {}, s = {}, t = [], u = t.slice, v, w = function (a, c, d, e) {
            var h, i, j, k, l = b.createElement("div"), m = b.body, n = m || b.createElement("body");
            if (parseInt(d, 10))while (d--)j = b.createElement("div"), j.id = e ? e[d] : g + (d + 1), l.appendChild(j);
            return h = ["&#173;", '<style id="s', g, '">', a, "</style>"].join(""), l.id = g, (m ? l : n).innerHTML += h, n.appendChild(l), m || (n.style.background = "", n.style.overflow = "hidden", k = f.style.overflow, f.style.overflow = "hidden", f.appendChild(n)), i = c(l, a), m ? l.parentNode.removeChild(l) : (n.parentNode.removeChild(n), f.style.overflow = k), !!i
        }, x = {}.hasOwnProperty, y;
        !B(x, "undefined") && !B(x.call, "undefined") ? y = function (a, b) {
            return x.call(a, b)
        } : y = function (a, b) {
            return b in a && B(a.constructor.prototype[b], "undefined")
        }, Function.prototype.bind || (Function.prototype.bind = function (a) {
            var b = this;
            if (typeof b != "function")throw new TypeError;
            var c = u.call(arguments, 1), d = function () {
                if (this instanceof d) {
                    var e = function () {
                    };
                    e.prototype = b.prototype;
                    var f = new e, g = b.apply(f, c.concat(u.call(arguments)));
                    return Object(g) === g ? g : f
                }
                return b.apply(a, c.concat(u.call(arguments)))
            };
            return d
        }), q.canvas = function () {
            var a = b.createElement("canvas");
            return!!a.getContext && !!a.getContext("2d")
        }, q.touch = function () {
            var c;
            return"ontouchstart"in a || a.DocumentTouch && b instanceof DocumentTouch ? c = !0 : w(["@media (", l.join("touch-enabled),("), g, ")", "{#modernizr{top:9px;position:absolute}}"].join(""), function (a) {
                c = a.offsetTop === 9
            }), c
        }, q.csstransforms = function () {
            return!!F("transform")
        }, q.csstransitions = function () {
            return F("transition")
        }, q.svg = function () {
            return!!b.createElementNS && !!b.createElementNS(p.svg, "svg").createSVGRect
        };
        for (var G in q)y(q, G) && (v = G.toLowerCase(), e[v] = q[G](), t.push((e[v] ? "" : "no-") + v));
        return e.addTest = function (a, b) {
            if (typeof a == "object")for (var d in a)y(a, d) && e.addTest(d, a[d]); else {
                a = a.toLowerCase();
                if (e[a] !== c)return e;
                b = typeof b == "function" ? b() : b, typeof enableClasses != "undefined" && enableClasses && (f.className += " " + (b ? "" : "no-") + a), e[a] = b
            }
            return e
        }, z(""), h = j = null, e._version = d, e._prefixes = l, e._domPrefixes = o, e._cssomPrefixes = n, e.testProp = function (a) {
            return D([a])
        }, e.testAllProps = F, e.testStyles = w, e
    }(a, b);
    !function (a, b, c) {
        function g(a, c) {
            var d = b.createElement(a || "div"), e;
            for (e in c)d[e] = c[e];
            return d
        }

        function h(a) {
            for (var b = 1, c = arguments.length; b < c; b++)a.appendChild(arguments[b]);
            return a
        }

        function j(a, b, c, d) {
            var g = ["opacity", b, ~~(a * 100), c, d].join("-"), h = .01 + c / d * 100, j = Math.max(1 - (1 - a) / b * (100 - h), a), k = f.substring(0, f.indexOf("Animation")).toLowerCase(), l = k && "-" + k + "-" || "";
            return e[g] || (i.insertRule("@" + l + "keyframes " + g + "{" + "0%{opacity:" + j + "}" + h + "%{opacity:" + a + "}" + (h + .01) + "%{opacity:1}" + (h + b) % 100 + "%{opacity:" + a + "}" + "100%{opacity:" + j + "}" + "}", i.cssRules.length), e[g] = 1), g
        }

        function k(a, b) {
            var e = a.style, f, g;
            if (e[b] !== c)return b;
            b = b.charAt(0).toUpperCase() + b.slice(1);
            for (g = 0; g < d.length; g++) {
                f = d[g] + b;
                if (e[f] !== c)return f
            }
        }

        function l(a, b) {
            for (var c in b)a.style[k(a, c) || c] = b[c];
            return a
        }

        function m(a) {
            for (var b = 1; b < arguments.length; b++) {
                var d = arguments[b];
                for (var e in d)a[e] === c && (a[e] = d[e])
            }
            return a
        }

        function n(a) {
            var b = {x: a.offsetLeft, y: a.offsetTop};
            while (a = a.offsetParent)b.x += a.offsetLeft, b.y += a.offsetTop;
            return b
        }

        var d = ["webkit", "Moz", "ms", "O"], e = {}, f, i = function () {
            var a = g("style", {type: "text/css"});
            return h(b.getElementsByTagName("head")[0], a), a.sheet || a.styleSheet
        }(), o = {lines: 12, length: 7, width: 5, radius: 10, rotate: 0, corners: 1, color: "#000", speed: 1, trail: 100, opacity: .25, fps: 20, zIndex: 2e9, className: "spinner", top: "auto", left: "auto"};
        Spinner = function p(a) {
            if (!this.spin)return new p(a);
            this.opts = m(a || {}, p.defaults, o)
        }, Spinner.defaults = {}, m(Spinner.prototype, {spin: function (a) {
            this.stop();
            var b = this, c = b.opts, d = b.el = l(g(0, {className: c.className}), {position: "relative", width: 0, zIndex: c.zIndex}), e = c.radius + c.length + c.width, h, i;
            a && (a.insertBefore(d, a.firstChild || null), i = n(a), h = n(d), l(d, {left: (c.left == "auto" ? i.x - h.x + (a.offsetWidth >> 1) : parseInt(c.left, 10) + e) + "px", top: (c.top == "auto" ? i.y - h.y + (a.offsetHeight >> 1) : parseInt(c.top, 10) + e) + "px"})), d.setAttribute("aria-role", "progressbar"), b.lines(d, b.opts);
            if (!f) {
                var j = 0, k = c.fps, m = k / c.speed, o = (1 - c.opacity) / (m * c.trail / 100), p = m / c.lines;
                (function q() {
                    j++;
                    for (var a = c.lines; a; a--) {
                        var e = Math.max(1 - (j + a * p) % m * o, c.opacity);
                        b.opacity(d, c.lines - a, e, c)
                    }
                    b.timeout = b.el && setTimeout(q, ~~(1e3 / k))
                })()
            }
            return b
        }, stop: function () {
            var a = this.el;
            return a && (clearTimeout(this.timeout), a.parentNode && a.parentNode.removeChild(a), this.el = c), this
        }, lines: function (a, b) {
            function e(a, d) {
                return l(g(), {position: "absolute", width: b.length + b.width + "px", height: b.width + "px", background: a, boxShadow: d, transformOrigin: "left", transform: "rotate(" + ~~(360 / b.lines * c + b.rotate) + "deg) translate(" + b.radius + "px" + ",0)", borderRadius: (b.corners * b.width >> 1) + "px"})
            }

            var c = 0, d;
            for (; c < b.lines; c++)d = l(g(), {position: "absolute", top: 1 + ~(b.width / 2) + "px", transform: b.hwaccel ? "translate3d(0,0,0)" : "", opacity: b.opacity, animation: f && j(b.opacity, b.trail, c, b.lines) + " " + 1 / b.speed + "s linear infinite"}), b.shadow && h(d, l(e("#000", "0 0 4px #000"), {top: "2px"})), h(a, h(d, e(b.color, "0 0 1px rgba(0,0,0,.1)")));
            return a
        }, opacity: function (a, b, c) {
            b < a.childNodes.length && (a.childNodes[b].style.opacity = c)
        }}), function () {
            function a(a, b) {
                return g("<" + a + ' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">', b)
            }

            var b = l(g("group"), {behavior: "url(#default#VML)"});
            !k(b, "transform") && b.adj ? (i.addRule(".spin-vml", "behavior:url(#default#VML)"), Spinner.prototype.lines = function (b, c) {
                function f() {
                    return l(a("group", {coordsize: e + " " + e, coordorigin: -d + " " + -d}), {width: e, height: e})
                }

                function k(b, e, g) {
                    h(i, h(l(f(), {rotation: 360 / c.lines * b + "deg", left: ~~e}), h(l(a("roundrect", {arcsize: c.corners}), {width: d, height: c.width, left: c.radius, top: -c.width >> 1, filter: g}), a("fill", {color: c.color, opacity: c.opacity}), a("stroke", {opacity: 0}))))
                }

                var d = c.length + c.width, e = 2 * d, g = -(c.width + c.length) * 2 + "px", i = l(f(), {position: "absolute", top: g, left: g}), j;
                if (c.shadow)for (j = 1; j <= c.lines; j++)k(j, -2, "progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)");
                for (j = 1; j <= c.lines; j++)k(j);
                return h(b, i)
            }, Spinner.prototype.opacity = function (a, b, c, d) {
                var e = a.firstChild;
                d = d.shadow && d.lines || 0, e && b + d < e.childNodes.length && (e = e.childNodes[b + d], e = e && e.firstChild, e = e && e.firstChild, e && (e.opacity = c))
            }) : f = k(b, "animation")
        }(), a.Spinner = Spinner
    }(a, b);
    var g = b.location.hash.replace("#", "") === "quirks", h = e.canvas, j = e.touch, k = e.svg, l = navigator.userAgent.toLowerCase(), m = l.match(/(phone|ipod|ipad|windows ce|netfront|playstation|midp|up\.browser|android|mobile|mini|tablet|symbian|nintendo|wii)/), n = c.browser.msie, o = n && "6.0" === c.browser.version, p = c.browser.mozilla, q = e.csstransforms && e.csstransitions && !g, r = b.compatMode !== "CSS1Compat" && n, s = 300, t = f([.1, 0, .25, 1]), u = 333, v = 500, w = 333, x = c(a), y = c(b), z, A, B = [
        ["width", "s", null],
        ["minWidth", "s", null],
        ["maxWidth", "s", null],
        ["height", "s", null],
        ["minHeight", "s", null],
        ["maxHeight", "s", null],
        ["aspectRatio", "n", null],
        ["transition", "s", "slide"],
        ["touchStyle", "b", !0],
        ["click", "b", null],
        ["pseudoClick", "b", !0],
        ["loop", "b", !1],
        ["autoplay", "bn", !1],
        ["stopAutoplayOnAction", "b", !0],
        ["transitionDuration", "n", u],
        ["background", "s", null],
        ["backgroundColor", "s", null],
        ["margin", "n", 4],
        ["minPadding", "n", 8],
        ["alwaysPadding", "b", !1],
        ["zoomToFit", "b", !0],
        ["cropToFit", "b", !1],
        ["cropToFitIfFullscreen", "b", !1],
        ["flexible", "b", !1],
        ["fitToWindowHeight", "b", !1],
        ["fitToWindowHeightMargin", "n", 20],
        ["fullscreen", "b", !1],
        ["fullscreenIcon", "b", !1],
        ["vertical", "b", !1],
        ["arrows", "b", !0],
        ["arrowsColor", "s", null],
        ["arrowPrev", "s", null],
        ["arrowNext", "s", null],
        ["spinnerColor", "s", "#808080"],
        ["nav", "s", null],
        ["thumbs", "b", !0],
        ["navPosition", "s", null],
        ["thumbsOnTop", "b", !1],
        ["thumbsOnRight", "b", !1],
        ["navBackground", "s", null],
        ["thumbsBackgroundColor", "s", null],
        ["dotColor", "s", null],
        ["thumbColor", "s", null],
        ["thumbsPreview", "b", !0],
        ["thumbSize", "n", null],
        ["thumbMargin", "n", 4],
        ["thumbBorderWidth", "n", 2],
        ["thumbBorderColor", "s", null],
        ["thumbsCentered", "b", !0],
        ["hideNavIfFullscreen", "b", !1],
        ["caption", "s", !1],
        ["preload", "n", 3],
        ["shadows", "b", !0],
        ["noise", "b", !0],
        ["data", "a", null],
        ["html", "a", null],
        ["hash", "b", !1],
        ["startImg", "n", 0],
        ["onShowImg", "f", null],
        ["onFullscreenOpen", "f", null],
        ["onFullscreenClose", "f", null],
        ["onClick", "f", null],
        ["onTransitionStop", "f", null],
        ["detachSiblings", "b", !0],
        ["cssTransitions", "b", !0]
    ], D = ["-webkit-", "-moz-", "-o-", "-ms-", ""];
    c.fn.fotorama = function (a) {
        return typeof fotoramaDefaults == "undefined" && (fotoramaDefaults = {}), this.each(function (b) {
            var d = c(this), e = c.extend(C(), c.extend({}, fotoramaDefaults, c.extend(a, C(d))));
            d.data("ini") || (d.data({ini: !0, options: e}), Q(d, function () {
                R(d)
            }))
        }), this
    }, c(function () {
        z = c("html"), A = c("body"), c(".fotorama").each(function () {
            var a = c(this);
            a.fotorama()
        })
    })
})(window, document, jQuery);