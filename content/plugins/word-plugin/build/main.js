//     Underscore.js 1.4.3
//     http://underscorejs.org
//     (c) 2009-2012 Jeremy Ashkenas, DocumentCloud Inc.
//     Underscore may be freely distributed under the MIT license.
/**
 * @license RequireJS text 2.0.1 Copyright (c) 2010-2012, The Dojo Foundation All Rights Reserved.
 * Available via the MIT or new BSD license.
 * see: http://github.com/requirejs/text for details
 */
/**
 * @license RequireJS i18n 2.0.2 Copyright (c) 2010-2012, The Dojo Foundation All Rights Reserved.
 * Available via the MIT or new BSD license.
 * see: http://github.com/requirejs/i18n for details
 */
var EventEmitter = function() {};
EventEmitter.prototype.setMaxListeners = function(e) {
        this._events || (this._events = {}), this._events.maxListeners = e
    }, Array.isArray = Array.isArray || function(e) {
        return e.sort && e.length && e.slice
    }, EventEmitter.prototype.emit = function(e) {
        if (e === "error")
            if (!this._events || !this._events.error || Array.isArray(this._events.error) && !this._events.error.length) throw arguments[1] instanceof Error ? arguments[1] : new Error("Uncaught, unspecified 'error' event.");
        if (!this._events) return !1;
        var t = this._events[e];
        if (!t) return !1;
        if (typeof t == "function") {
            switch (arguments.length) {
                case 1:
                    t.call(this);
                    break;
                case 2:
                    t.call(this, arguments[1]);
                    break;
                case 3:
                    t.call(this, arguments[1], arguments[2]);
                    break;
                default:
                    var n = Array.prototype.slice.call(arguments, 1);
                    t.apply(this, n)
            }
            return !0
        }
        if (Array.isArray(t)) {
            var n = Array.prototype.slice.call(arguments, 1),
                r = t.slice();
            for (var i = 0, s = r.length; i < s; i++) r[i].apply(this, n);
            return !0
        }
        return !1
    }, EventEmitter.prototype.publish = EventEmitter.prototype.emit, EventEmitter.prototype.addListener = function(e, t) {
        if ("function" != typeof t) throw new Error("addListener only takes instances of Function");
        this._events || (this._events = {}), this.emit("newListener", e, t);
        if (!this._events[e]) this._events[e] = t;
        else if (Array.isArray(this._events[e])) {
            this._events[e].push(t);
            if (!this._events[e].warned) {
                var n;
                this._events.maxListeners !== undefined ? n = this._events.maxListeners : n = 10, n && n > 0 && this._events[e].length > n && (this._events[e].warned = !0, console.error("(node) warning: possible EventEmitter memory leak detected. %d listeners added. Use emitter.setMaxListeners() to increase limit.", this._events[e].length), console.trace())
            }
        } else this._events[e] = [this._events[e], t];
        return this
    }, EventEmitter.prototype.on = EventEmitter.prototype.subscribe = EventEmitter.prototype.addListener, EventEmitter.prototype.once = function(e, t) {
        function n() {
            r.removeListener(e, n), t.apply(this, arguments)
        }
        if ("function" != typeof t) throw new Error(".once only takes instances of Function");
        var r = this;
        return n.listener = t, r.on(e, n), this
    }, EventEmitter.prototype.removeListener = function(e, t) {
        if ("function" != typeof t) throw new Error("removeListener only takes instances of Function");
        if (!this._events || !this._events[e]) return this;
        var n = this._events[e];
        if (Array.isArray(n)) {
            var r = -1;
            for (var i = 0, s = n.length; i < s; i++)
                if (n[i] === t || n[i].listener && n[i].listener === t) {
                    r = i;
                    break
                }
            if (r < 0) return this;
            n.splice(r, 1), n.length == 0 && delete this._events[e]
        } else(n === t || n.listener && n.listener === t) && delete this._events[e];
        return this
    }, EventEmitter.prototype.unsubscribe = EventEmitter.prototype.removeListener, EventEmitter.prototype.removeAllListeners = function(e) {
        return arguments.length === 0 ? (this._events = {}, this) : (e && this._events && this._events[e] && (this._events[e] = null), this)
    }, EventEmitter.prototype.listeners = function(e) {
        return this._events || (this._events = {}), this._events[e] || (this._events[e] = []), Array.isArray(this._events[e]) || (this._events[e] = [this._events[e]]), this._events[e]
    }, EventEmitter.mixin = function(e) {
        for (var t in EventEmitter.prototype) e.prototype[t] || (e.prototype[t] = EventEmitter.prototype[t])
    }, define("vendor/EventEmitter.min", function() {}), define("modules/EventBus", ["EventEmitter"], function() {
        function r(e) {
            this.uid = e
        }
        var e = new EventEmitter,
            t = {},
            n = [].slice;
        return r.prototype.on = function(t, n) {
            e.on(this.uid + t, n)
        }, r.prototype.emit = function(t) {
            var r = n.call(arguments);
            r[0] = this.uid + t, e.emit.apply(e, r)
        }, e.channel = function(e) {
            return t[e] = t[e] || new r(e)
        }, e
    }),
    function() {
        var e = this,
            t = e._,
            n = {},
            r = Array.prototype,
            i = Object.prototype,
            s = Function.prototype,
            o = r.push,
            u = r.slice,
            a = r.concat,
            f = i.toString,
            l = i.hasOwnProperty,
            c = r.forEach,
            h = r.map,
            p = r.reduce,
            d = r.reduceRight,
            v = r.filter,
            m = r.every,
            g = r.some,
            y = r.indexOf,
            b = r.lastIndexOf,
            w = Array.isArray,
            E = Object.keys,
            S = s.bind,
            x = function(e) {
                if (e instanceof x) return e;
                if (!(this instanceof x)) return new x(e);
                this._wrapped = e
            };
        typeof exports != "undefined" ? (typeof module != "undefined" && module.exports && (exports = module.exports = x), exports._ = x) : e._ = x, x.VERSION = "1.4.3";
        var T = x.each = x.forEach = function(e, t, r) {
            if (e == null) return;
            if (c && e.forEach === c) e.forEach(t, r);
            else if (e.length === +e.length) {
                for (var i = 0, s = e.length; i < s; i++)
                    if (t.call(r, e[i], i, e) === n) return
            } else
                for (var o in e)
                    if (x.has(e, o) && t.call(r, e[o], o, e) === n) return
        };
        x.map = x.collect = function(e, t, n) {
            var r = [];
            return e == null ? r : h && e.map === h ? e.map(t, n) : (T(e, function(e, i, s) {
                r[r.length] = t.call(n, e, i, s)
            }), r)
        };
        var N = "Reduce of empty array with no initial value";
        x.reduce = x.foldl = x.inject = function(e, t, n, r) {
            var i = arguments.length > 2;
            e == null && (e = []);
            if (p && e.reduce === p) return r && (t = x.bind(t, r)), i ? e.reduce(t, n) : e.reduce(t);
            T(e, function(e, s, o) {
                i ? n = t.call(r, n, e, s, o) : (n = e, i = !0)
            });
            if (!i) throw new TypeError(N);
            return n
        }, x.reduceRight = x.foldr = function(e, t, n, r) {
            var i = arguments.length > 2;
            e == null && (e = []);
            if (d && e.reduceRight === d) return r && (t = x.bind(t, r)), i ? e.reduceRight(t, n) : e.reduceRight(t);
            var s = e.length;
            if (s !== +s) {
                var o = x.keys(e);
                s = o.length
            }
            T(e, function(u, a, f) {
                a = o ? o[--s] : --s, i ? n = t.call(r, n, e[a], a, f) : (n = e[a], i = !0)
            });
            if (!i) throw new TypeError(N);
            return n
        }, x.find = x.detect = function(e, t, n) {
            var r;
            return C(e, function(e, i, s) {
                if (t.call(n, e, i, s)) return r = e, !0
            }), r
        }, x.filter = x.select = function(e, t, n) {
            var r = [];
            return e == null ? r : v && e.filter === v ? e.filter(t, n) : (T(e, function(e, i, s) {
                t.call(n, e, i, s) && (r[r.length] = e)
            }), r)
        }, x.reject = function(e, t, n) {
            return x.filter(e, function(e, r, i) {
                return !t.call(n, e, r, i)
            }, n)
        }, x.every = x.all = function(e, t, r) {
            t || (t = x.identity);
            var i = !0;
            return e == null ? i : m && e.every === m ? e.every(t, r) : (T(e, function(e, s, o) {
                if (!(i = i && t.call(r, e, s, o))) return n
            }), !!i)
        };
        var C = x.some = x.any = function(e, t, r) {
            t || (t = x.identity);
            var i = !1;
            return e == null ? i : g && e.some === g ? e.some(t, r) : (T(e, function(e, s, o) {
                if (i || (i = t.call(r, e, s, o))) return n
            }), !!i)
        };
        x.contains = x.include = function(e, t) {
            return e == null ? !1 : y && e.indexOf === y ? e.indexOf(t) != -1 : C(e, function(e) {
                return e === t
            })
        }, x.invoke = function(e, t) {
            var n = u.call(arguments, 2);
            return x.map(e, function(e) {
                return (x.isFunction(t) ? t : e[t]).apply(e, n)
            })
        }, x.pluck = function(e, t) {
            return x.map(e, function(e) {
                return e[t]
            })
        }, x.where = function(e, t) {
            return x.isEmpty(t) ? [] : x.filter(e, function(e) {
                for (var n in t)
                    if (t[n] !== e[n]) return !1;
                return !0
            })
        }, x.max = function(e, t, n) {
            if (!t && x.isArray(e) && e[0] === +e[0] && e.length < 65535) return Math.max.apply(Math, e);
            if (!t && x.isEmpty(e)) return -Infinity;
            var r = {
                computed: -Infinity,
                value: -Infinity
            };
            return T(e, function(e, i, s) {
                var o = t ? t.call(n, e, i, s) : e;
                o >= r.computed && (r = {
                    value: e,
                    computed: o
                })
            }), r.value
        }, x.min = function(e, t, n) {
            if (!t && x.isArray(e) && e[0] === +e[0] && e.length < 65535) return Math.min.apply(Math, e);
            if (!t && x.isEmpty(e)) return Infinity;
            var r = {
                computed: Infinity,
                value: Infinity
            };
            return T(e, function(e, i, s) {
                var o = t ? t.call(n, e, i, s) : e;
                o < r.computed && (r = {
                    value: e,
                    computed: o
                })
            }), r.value
        }, x.shuffle = function(e) {
            var t, n = 0,
                r = [];
            return T(e, function(e) {
                t = x.random(n++), r[n - 1] = r[t], r[t] = e
            }), r
        };
        var k = function(e) {
            return x.isFunction(e) ? e : function(t) {
                return t[e]
            }
        };
        x.sortBy = function(e, t, n) {
            var r = k(t);
            return x.pluck(x.map(e, function(e, t, i) {
                return {
                    value: e,
                    index: t,
                    criteria: r.call(n, e, t, i)
                }
            }).sort(function(e, t) {
                var n = e.criteria,
                    r = t.criteria;
                if (n !== r) {
                    if (n > r || n === void 0) return 1;
                    if (n < r || r === void 0) return -1
                }
                return e.index < t.index ? -1 : 1
            }), "value")
        };
        var L = function(e, t, n, r) {
            var i = {},
                s = k(t || x.identity);
            return T(e, function(t, o) {
                var u = s.call(n, t, o, e);
                r(i, u, t)
            }), i
        };
        x.groupBy = function(e, t, n) {
            return L(e, t, n, function(e, t, n) {
                (x.has(e, t) ? e[t] : e[t] = []).push(n)
            })
        }, x.countBy = function(e, t, n) {
            return L(e, t, n, function(e, t) {
                x.has(e, t) || (e[t] = 0), e[t] ++
            })
        }, x.sortedIndex = function(e, t, n, r) {
            n = n == null ? x.identity : k(n);
            var i = n.call(r, t),
                s = 0,
                o = e.length;
            while (s < o) {
                var u = s + o >>> 1;
                n.call(r, e[u]) < i ? s = u + 1 : o = u
            }
            return s
        }, x.toArray = function(e) {
            return e ? x.isArray(e) ? u.call(e) : e.length === +e.length ? x.map(e, x.identity) : x.values(e) : []
        }, x.size = function(e) {
            return e == null ? 0 : e.length === +e.length ? e.length : x.keys(e).length
        }, x.first = x.head = x.take = function(e, t, n) {
            return e == null ? void 0 : t != null && !n ? u.call(e, 0, t) : e[0]
        }, x.initial = function(e, t, n) {
            return u.call(e, 0, e.length - (t == null || n ? 1 : t))
        }, x.last = function(e, t, n) {
            return e == null ? void 0 : t != null && !n ? u.call(e, Math.max(e.length - t, 0)) : e[e.length - 1]
        }, x.rest = x.tail = x.drop = function(e, t, n) {
            return u.call(e, t == null || n ? 1 : t)
        }, x.compact = function(e) {
            return x.filter(e, x.identity)
        };
        var A = function(e, t, n) {
            return T(e, function(e) {
                x.isArray(e) ? t ? o.apply(n, e) : A(e, t, n) : n.push(e)
            }), n
        };
        x.flatten = function(e, t) {
            return A(e, t, [])
        }, x.without = function(e) {
            return x.difference(e, u.call(arguments, 1))
        }, x.uniq = x.unique = function(e, t, n, r) {
            x.isFunction(t) && (r = n, n = t, t = !1);
            var i = n ? x.map(e, n, r) : e,
                s = [],
                o = [];
            return T(i, function(n, r) {
                if (t ? !r || o[o.length - 1] !== n : !x.contains(o, n)) o.push(n), s.push(e[r])
            }), s
        }, x.union = function() {
            return x.uniq(a.apply(r, arguments))
        }, x.intersection = function(e) {
            var t = u.call(arguments, 1);
            return x.filter(x.uniq(e), function(e) {
                return x.every(t, function(t) {
                    return x.indexOf(t, e) >= 0
                })
            })
        }, x.difference = function(e) {
            var t = a.apply(r, u.call(arguments, 1));
            return x.filter(e, function(e) {
                return !x.contains(t, e)
            })
        }, x.zip = function() {
            var e = u.call(arguments),
                t = x.max(x.pluck(e, "length")),
                n = new Array(t);
            for (var r = 0; r < t; r++) n[r] = x.pluck(e, "" + r);
            return n
        }, x.object = function(e, t) {
            if (e == null) return {};
            var n = {};
            for (var r = 0, i = e.length; r < i; r++) t ? n[e[r]] = t[r] : n[e[r][0]] = e[r][1];
            return n
        }, x.indexOf = function(e, t, n) {
            if (e == null) return -1;
            var r = 0,
                i = e.length;
            if (n) {
                if (typeof n != "number") return r = x.sortedIndex(e, t), e[r] === t ? r : -1;
                r = n < 0 ? Math.max(0, i + n) : n
            }
            if (y && e.indexOf === y) return e.indexOf(t, n);
            for (; r < i; r++)
                if (e[r] === t) return r;
            return -1
        }, x.lastIndexOf = function(e, t, n) {
            if (e == null) return -1;
            var r = n != null;
            if (b && e.lastIndexOf === b) return r ? e.lastIndexOf(t, n) : e.lastIndexOf(t);
            var i = r ? n : e.length;
            while (i--)
                if (e[i] === t) return i;
            return -1
        }, x.range = function(e, t, n) {
            arguments.length <= 1 && (t = e || 0, e = 0), n = arguments[2] || 1;
            var r = Math.max(Math.ceil((t - e) / n), 0),
                i = 0,
                s = new Array(r);
            while (i < r) s[i++] = e, e += n;
            return s
        };
        var O = function() {};
        x.bind = function(e, t) {
            var n, r;
            if (e.bind === S && S) return S.apply(e, u.call(arguments, 1));
            if (!x.isFunction(e)) throw new TypeError;
            return n = u.call(arguments, 2), r = function() {
                if (this instanceof r) {
                    O.prototype = e.prototype;
                    var i = new O;
                    O.prototype = null;
                    var s = e.apply(i, n.concat(u.call(arguments)));
                    return Object(s) === s ? s : i
                }
                return e.apply(t, n.concat(u.call(arguments)))
            }
        }, x.bindAll = function(e) {
            var t = u.call(arguments, 1);
            return t.length === 0 && (t = x.functions(e)), T(t, function(t) {
                e[t] = x.bind(e[t], e)
            }), e
        }, x.memoize = function(e, t) {
            var n = {};
            return t || (t = x.identity),
                function() {
                    var r = t.apply(this, arguments);
                    return x.has(n, r) ? n[r] : n[r] = e.apply(this, arguments)
                }
        }, x.delay = function(e, t) {
            var n = u.call(arguments, 2);
            return setTimeout(function() {
                return e.apply(null, n)
            }, t)
        }, x.defer = function(e) {
            return x.delay.apply(x, [e, 1].concat(u.call(arguments, 1)))
        }, x.throttle = function(e, t) {
            var n, r, i, s, o = 0,
                u = function() {
                    o = new Date, i = null, s = e.apply(n, r)
                };
            return function() {
                var a = new Date,
                    f = t - (a - o);
                return n = this, r = arguments, f <= 0 ? (clearTimeout(i), i = null, o = a, s = e.apply(n, r)) : i || (i = setTimeout(u, f)), s
            }
        }, x.debounce = function(e, t, n) {
            var r, i;
            return function() {
                var s = this,
                    o = arguments,
                    u = function() {
                        r = null, n || (i = e.apply(s, o))
                    },
                    a = n && !r;
                return clearTimeout(r), r = setTimeout(u, t), a && (i = e.apply(s, o)), i
            }
        }, x.once = function(e) {
            var t = !1,
                n;
            return function() {
                return t ? n : (t = !0, n = e.apply(this, arguments), e = null, n)
            }
        }, x.wrap = function(e, t) {
            return function() {
                var n = [e];
                return o.apply(n, arguments), t.apply(this, n)
            }
        }, x.compose = function() {
            var e = arguments;
            return function() {
                var t = arguments;
                for (var n = e.length - 1; n >= 0; n--) t = [e[n].apply(this, t)];
                return t[0]
            }
        }, x.after = function(e, t) {
            return e <= 0 ? t() : function() {
                if (--e < 1) return t.apply(this, arguments)
            }
        }, x.keys = E || function(e) {
            if (e !== Object(e)) throw new TypeError("Invalid object");
            var t = [];
            for (var n in e) x.has(e, n) && (t[t.length] = n);
            return t
        }, x.values = function(e) {
            var t = [];
            for (var n in e) x.has(e, n) && t.push(e[n]);
            return t
        }, x.pairs = function(e) {
            var t = [];
            for (var n in e) x.has(e, n) && t.push([n, e[n]]);
            return t
        }, x.invert = function(e) {
            var t = {};
            for (var n in e) x.has(e, n) && (t[e[n]] = n);
            return t
        }, x.functions = x.methods = function(e) {
            var t = [];
            for (var n in e) x.isFunction(e[n]) && t.push(n);
            return t.sort()
        }, x.extend = function(e) {
            return T(u.call(arguments, 1), function(t) {
                if (t)
                    for (var n in t) e[n] = t[n]
            }), e
        }, x.pick = function(e) {
            var t = {},
                n = a.apply(r, u.call(arguments, 1));
            return T(n, function(n) {
                n in e && (t[n] = e[n])
            }), t
        }, x.omit = function(e) {
            var t = {},
                n = a.apply(r, u.call(arguments, 1));
            for (var i in e) x.contains(n, i) || (t[i] = e[i]);
            return t
        }, x.defaults = function(e) {
            return T(u.call(arguments, 1), function(t) {
                if (t)
                    for (var n in t) e[n] == null && (e[n] = t[n])
            }), e
        }, x.clone = function(e) {
            return x.isObject(e) ? x.isArray(e) ? e.slice() : x.extend({}, e) : e
        }, x.tap = function(e, t) {
            return t(e), e
        };
        var M = function(e, t, n, r) {
            if (e === t) return e !== 0 || 1 / e == 1 / t;
            if (e == null || t == null) return e === t;
            e instanceof x && (e = e._wrapped), t instanceof x && (t = t._wrapped);
            var i = f.call(e);
            if (i != f.call(t)) return !1;
            switch (i) {
                case "[object String]":
                    return e == String(t);
                case "[object Number]":
                    return e != +e ? t != +t : e == 0 ? 1 / e == 1 / t : e == +t;
                case "[object Date]":
                case "[object Boolean]":
                    return +e == +t;
                case "[object RegExp]":
                    return e.source == t.source && e.global == t.global && e.multiline == t.multiline && e.ignoreCase == t.ignoreCase
            }
            if (typeof e != "object" || typeof t != "object") return !1;
            var s = n.length;
            while (s--)
                if (n[s] == e) return r[s] == t;
            n.push(e), r.push(t);
            var o = 0,
                u = !0;
            if (i == "[object Array]") {
                o = e.length, u = o == t.length;
                if (u)
                    while (o--)
                        if (!(u = M(e[o], t[o], n, r))) break
            } else {
                var a = e.constructor,
                    l = t.constructor;
                if (a !== l && !(x.isFunction(a) && a instanceof a && x.isFunction(l) && l instanceof l)) return !1;
                for (var c in e)
                    if (x.has(e, c)) {
                        o++;
                        if (!(u = x.has(t, c) && M(e[c], t[c], n, r))) break
                    }
                if (u) {
                    for (c in t)
                        if (x.has(t, c) && !(o--)) break;
                    u = !o
                }
            }
            return n.pop(), r.pop(), u
        };
        x.isEqual = function(e, t) {
            return M(e, t, [], [])
        }, x.isEmpty = function(e) {
            if (e == null) return !0;
            if (x.isArray(e) || x.isString(e)) return e.length === 0;
            for (var t in e)
                if (x.has(e, t)) return !1;
            return !0
        }, x.isElement = function(e) {
            return !!e && e.nodeType === 1
        }, x.isArray = w || function(e) {
            return f.call(e) == "[object Array]"
        }, x.isObject = function(e) {
            return e === Object(e)
        }, T(["Arguments", "Function", "String", "Number", "Date", "RegExp"], function(e) {
            x["is" + e] = function(t) {
                return f.call(t) == "[object " + e + "]"
            }
        }), x.isArguments(arguments) || (x.isArguments = function(e) {
            return !!e && !!x.has(e, "callee")
        }), typeof / . / != "function" && (x.isFunction = function(e) {
            return typeof e == "function"
        }), x.isFinite = function(e) {
            return isFinite(e) && !isNaN(parseFloat(e))
        }, x.isNaN = function(e) {
            return x.isNumber(e) && e != +e
        }, x.isBoolean = function(e) {
            return e === !0 || e === !1 || f.call(e) == "[object Boolean]"
        }, x.isNull = function(e) {
            return e === null
        }, x.isUndefined = function(e) {
            return e === void 0
        }, x.has = function(e, t) {
            return l.call(e, t)
        }, x.noConflict = function() {
            return e._ = t, this
        }, x.identity = function(e) {
            return e
        }, x.times = function(e, t, n) {
            var r = Array(e);
            for (var i = 0; i < e; i++) r[i] = t.call(n, i);
            return r
        }, x.random = function(e, t) {
            return t == null && (t = e, e = 0), e + (0 | Math.random() * (t - e + 1))
        };
        var _ = {
            escape: {
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#x27;",
                "/": "&#x2F;"
            }
        };
        _.unescape = x.invert(_.escape);
        var D = {
            escape: new RegExp("[" + x.keys(_.escape).join("") + "]", "g"),
            unescape: new RegExp("(" + x.keys(_.unescape).join("|") + ")", "g")
        };
        x.each(["escape", "unescape"], function(e) {
            x[e] = function(t) {
                return t == null ? "" : ("" + t).replace(D[e], function(t) {
                    return _[e][t]
                })
            }
        }), x.result = function(e, t) {
            if (e == null) return null;
            var n = e[t];
            return x.isFunction(n) ? n.call(e) : n
        }, x.mixin = function(e) {
            T(x.functions(e), function(t) {
                var n = x[t] = e[t];
                x.prototype[t] = function() {
                    var e = [this._wrapped];
                    return o.apply(e, arguments), F.call(this, n.apply(x, e))
                }
            })
        };
        var P = 0;
        x.uniqueId = function(e) {
            var t = ++P + "";
            return e ? e + t : t
        }, x.templateSettings = {
            evaluate: /<%([\s\S]+?)%>/g,
            interpolate: /<%=([\s\S]+?)%>/g,
            escape: /<%-([\s\S]+?)%>/g
        };
        var H = /(.)^/,
            B = {
                "'": "'",
                "\\": "\\",
                "\r": "r",
                "\n": "n",
                "	": "t",
                "\u2028": "u2028",
                "\u2029": "u2029"
            },
            j = /\\|'|\r|\n|\t|\u2028|\u2029/g;
        x.template = function(e, t, n) {
            var r;
            n = x.defaults({}, n, x.templateSettings);
            var i = new RegExp([(n.escape || H).source, (n.interpolate || H).source, (n.evaluate || H).source].join("|") + "|$", "g"),
                s = 0,
                o = "__p+='";
            e.replace(i, function(t, n, r, i, u) {
                return o += e.slice(s, u).replace(j, function(e) {
                    return "\\" + B[e]
                }), n && (o += "'+\n((__t=(" + n + "))==null?'':_.escape(__t))+\n'"), r && (o += "'+\n((__t=(" + r + "))==null?'':__t)+\n'"), i && (o += "';\n" + i + "\n__p+='"), s = u + t.length, t
            }), o += "';\n", n.variable || (o = "with(obj||{}){\n" + o + "}\n"), o = "var __t,__p='',__j=Array.prototype.join,print=function(){__p+=__j.call(arguments,'');};\n" + o + "return __p;\n";
            try {
                r = new Function(n.variable || "obj", "_", o)
            } catch (u) {
                throw u.source = o, u
            }
            if (t) return r(t, x);
            var a = function(e) {
                return r.call(this, e, x)
            };
            return a.source = "function(" + (n.variable || "obj") + "){\n" + o + "}", a
        }, x.chain = function(e) {
            return x(e).chain()
        };
        var F = function(e) {
            return this._chain ? x(e).chain() : e
        };
        x.mixin(x), T(["pop", "push", "reverse", "shift", "sort", "splice", "unshift"], function(e) {
            var t = r[e];
            x.prototype[e] = function() {
                var n = this._wrapped;
                return t.apply(n, arguments), (e == "shift" || e == "splice") && n.length === 0 && delete n[0], F.call(this, n)
            }
        }), T(["concat", "join", "slice"], function(e) {
            var t = r[e];
            x.prototype[e] = function() {
                return F.call(this, t.apply(this._wrapped, arguments))
            }
        }), x.extend(x.prototype, {
            chain: function() {
                return this._chain = !0, this
            },
            value: function() {
                return this._wrapped
            }
        })
    }.call(this), define("vendor/underscore", function() {}), define("modules/Utils", ["./EventBus", "underscore"], function(e) {
        function i(e) {
            return e = e || event, e.preventDefault || (e.preventDefault = function() {
                this.returnValue = !1
            }), e.stopPropagation || (e.stopPropagation = function() {
                this.cancelBubble = !0
            }), e
        }

        function o(e, t) {
            e.className += " " + t
        }

        function u(e, t) {
            e.className = v((" " + e.className + " ").replace(" " + t, ""))
        }

        function f(t, n) {
            require(["text!" + c(t) + "?a=" + (new Date).getTime()], function(t) {
                e.emit("data.arrived", t, n)
            })
        }

        function l(t, n) {
            e.emit("data.arrived", t.innerHTML, n)
        }

        function c(e) {
            return location.href.split("/").slice(0, -1).join("/") + "/" + e
        }

        function h(e, t) {
            return parseInt(Math.random() * (t - e + 1)) + e
        }

        function p(e) {
            return e.charAt(h(0, e.length - 1))
        }

        function d(e) {
            return e[h(0, e.length - 1)] || e[0]
        }

        function v(e) {
            return e.replace(/^\s+|\s+$/g, "")
        }

        function m(e) {
            return document.getElementById(e)
        }

        function g(e) {
            var t = 0,
                n = 0,
                r = +document.documentElement.offsetTop || 0;
            if (e.offsetParent)
                do t += e.offsetLeft, n += e.offsetTop; while (e = e.offsetParent);
            return {
                x: t,
                y: n + r
            }
        }

        function y() {
            if (location.query) return;
            var e = location.search.replace(/^[?]/, "").split("&"),
                t = 0,
                n = e.length,
                r, i = {};
            for (; t < n; t++) {
                if (!e[t]) continue;
                r = e[t].split("="), i[unescape(r[0])] = decodeURI(r[1])
            }
            return i
        }

        function w(e) {
            var t = e.length,
                n = t,
                r;
            for (r = 0; r < t; r++) b.test(e.charAt(r)) && n--;
            return n
        }

        function E(e) {
            var t = e.length,
                n = [],
                r;
            for (r = 0; r < t; r++) b.test(e.charAt(r)) ? n[n.length - 1] += e.charAt(r) : n.push(e.charAt(r));
            return n
        }

        function S() {
            document.documentElement.scrollHeight < window.outerHeight / window.devicePixelRatio ? (document.body.style.height = window.outerHeight / window.devicePixelRatio + 1 + "px", setTimeout(function() {
                window.scrollTo(1, 1)
            }, 0)) : window.scrollTo(1, 1)
        }
        var t, n = "ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch,
            r = {
                click: "touchstart",
                mousedown: "touchstart",
                mousemove: "touchmove",
                mouseup: "touchend"
            },
            s = function() {
                return document.addEventListener ? function(t, n, i) {
                    if (!t) return;
                    r[n] && t.addEventListener(r[n], i, !1), t.addEventListener(n, i, !1)
                } : function(t, n, r) {
                    if (!t) return;
                    t.attachEvent("on" + n, function(e) {
                        return e = i(e), r.call(e.target || e.srcElement, e)
                    })
                }
            }(),
            a = document.createElement("a"),
            b = /[\u0300-\u036F\u1DC0-\u1DFF\u20D0-\u20FF\uFE20-\uFE2F\u0483-\u0489\u0591-\u05BD]/;
        return {
            fullScreen: S,
            isTouchDevice: n,
            $: m,
            stringLength: w,
            splitString: E,
            addClass: o,
            removeClass: u,
            parseQueryString: y,
            getData: l,
            on: s,
            randint: h,
            randchar: p,
            choice: d,
            trim: v,
            position: g,
            now: function() {
                return (new Date).getTime()
            }
        }
    }), define("vendor/require-plugins/text", ["module"], function(e) {
        var t = ["Msxml2.XMLHTTP", "Microsoft.XMLHTTP", "Msxml2.XMLHTTP.4.0"],
            n = /^\s*<\?xml(\s)+version=[\'\"](\d)*.(\d)*[\'\"](\s)*\?>/im,
            r = /<body[^>]*>\s*([\s\S]+)\s*<\/body>/im,
            i = typeof location != "undefined" && location.href,
            s = i && location.protocol && location.protocol.replace(/\:/, ""),
            o = i && location.hostname,
            u = i && (location.port || undefined),
            a = [],
            f = e.config && e.config() || {},
            l, c;
        return l = {
            version: "2.0.1",
            strip: function(e) {
                if (e) {
                    e = e.replace(n, "");
                    var t = e.match(r);
                    t && (e = t[1])
                } else e = "";
                return e
            },
            jsEscape: function(e) {
                return e.replace(/(['\\])/g, "\\$1").replace(/[\f]/g, "\\f").replace(/[\b]/g, "\\b").replace(/[\n]/g, "\\n").replace(/[\t]/g, "\\t").replace(/[\r]/g, "\\r").replace(/[\u2028]/g, "\\u2028").replace(/[\u2029]/g, "\\u2029")
            },
            createXhr: f.createXhr || function() {
                var e, n, r;
                if (typeof XMLHttpRequest != "undefined") return new XMLHttpRequest;
                if (typeof ActiveXObject != "undefined")
                    for (n = 0; n < 3; n += 1) {
                        r = t[n];
                        try {
                            e = new ActiveXObject(r)
                        } catch (i) {}
                        if (e) {
                            t = [r];
                            break
                        }
                    }
                return e
            },
            parseName: function(e) {
                var t = !1,
                    n = e.indexOf("."),
                    r = e.substring(0, n),
                    i = e.substring(n + 1, e.length);
                return n = i.indexOf("!"), n !== -1 && (t = i.substring(n + 1, i.length), t = t === "strip", i = i.substring(0, n)), {
                    moduleName: r,
                    ext: i,
                    strip: t
                }
            },
            xdRegExp: /^((\w+)\:)?\/\/([^\/\\]+)/,
            useXhr: function(e, t, n, r) {
                var i = l.xdRegExp.exec(e),
                    s, o, u;
                return i ? (s = i[2], o = i[3], o = o.split(":"), u = o[1], o = o[0], (!s || s === t) && (!o || o.toLowerCase() === n.toLowerCase()) && (!u && !o || u === r)) : !0
            },
            finishLoad: function(e, t, n, r) {
                n = t ? l.strip(n) : n, f.isBuild && (a[e] = n), r(n)
            },
            load: function(e, t, n, r) {
                if (r.isBuild && !r.inlineText) {
                    n();
                    return
                }
                f.isBuild = r.isBuild;
                var a = l.parseName(e),
                    c = a.moduleName + "." + a.ext,
                    h = t.toUrl(c),
                    p = f.useXhr || l.useXhr;
                !i || p(h, s, o, u) ? l.get(h, function(t) {
                    l.finishLoad(e, a.strip, t, n)
                }, function(e) {
                    n.error && n.error(e)
                }) : t([c], function(e) {
                    l.finishLoad(a.moduleName + "." + a.ext, a.strip, e, n)
                })
            },
            write: function(e, t, n, r) {
                if (a.hasOwnProperty(t)) {
                    var i = l.jsEscape(a[t]);
                    n.asModule(e + "!" + t, "define(function () { return '" + i + "';});\n")
                }
            },
            writeFile: function(e, t, n, r, i) {
                var s = l.parseName(t),
                    o = s.moduleName + "." + s.ext,
                    u = n.toUrl(s.moduleName + "." + s.ext) + ".js";
                l.load(o, n, function(t) {
                    var n = function(e) {
                        return r(u, e)
                    };
                    n.asModule = function(e, t) {
                        return r.asModule(e, u, t)
                    }, l.write(e, o, n, i)
                }, i)
            }
        }, typeof process != "undefined" && process.versions && !!process.versions.node ? (c = require.nodeRequire("fs"), l.get = function(e, t) {
            var n = c.readFileSync(e, "utf8");
            n.indexOf("﻿") === 0 && (n = n.substring(1)), t(n)
        }) : l.createXhr() ? l.get = function(e, t, n) {
            var r = l.createXhr();
            r.open("GET", e, !0), f.onXhr && f.onXhr(r, e), r.onreadystatechange = function(i) {
                var s, o;
                r.readyState === 4 && (s = r.status, s > 399 && s < 600 ? (o = new Error(e + " HTTP status: " + s), o.xhr = r, n(o)) : t(r.responseText))
            }, r.send(null)
        } : typeof Packages != "undefined" && (l.get = function(e, t) {
            var n = "utf-8",
                r = new java.io.File(e),
                i = java.lang.System.getProperty("line.separator"),
                s = new java.io.BufferedReader(new java.io.InputStreamReader(new java.io.FileInputStream(r), n)),
                o, u, a = "";
            try {
                o = new java.lang.StringBuffer, u = s.readLine(), u && u.length() && u.charAt(0) === 65279 && (u = u.substring(1)), o.append(u);
                while ((u = s.readLine()) !== null) o.append(i), o.append(u);
                a = String(o.toString())
            } finally {
                s.close()
            }
            t(a)
        }), l
    }), define("vendor/require-plugins/text!assets/template/word-list.html", [], function() {
        return '<% _.each(words, function(word) { %>\n<span id="html5-wordsearch-<%= uid %>-<%= word.replace(/ /g, "-").toLowerCase() %>"><%= word %>\n</span>\n<% }); %>'
    }),
    function() {
        function t(e, t, n, r, i, s) {
            t[e] && (n.push(e), (t[e] === !0 || t[e] === 1) && r.push(i + e + "/" + s))
        }

        function n(e, t, n, r, i) {
            var s = r + t + "/" + i;
            require._fileExists(e.toUrl(s + ".js")) && n.push(s)
        }

        function r(e, t, n) {
            var i;
            for (i in t) t.hasOwnProperty(i) && (!e.hasOwnProperty(i) || n) ? e[i] = t[i] : typeof t[i] == "object" && r(e[i], t[i], n)
        }
        var e = /(^.*(^|\/)nls(\/|$))([^\/]*)\/?([^\/]*)/;
        define("vendor/require-plugins/i18n", ["module"], function(i) {
            var s = i.config ? i.config() : {};
            return {
                version: "2.0.1+",
                load: function(i, o, u, a) {
                    a = a || {}, a.locale && (s.locale = a.locale);
                    var f, l = e.exec(i),
                        c = l[1],
                        h = l[4],
                        p = l[5],
                        d = h.split("-"),
                        v = [],
                        m = {},
                        g, y, b = "";
                    l[5] ? (c = l[1], f = c + p) : (f = i, p = l[4], h = s.locale, h || (h = s.locale = typeof navigator == "undefined" ? "root" : (navigator.language || navigator.userLanguage || "root").toLowerCase()), d = h.split("-"));
                    if (a.isBuild) {
                        v.push(f), n(o, "root", v, c, p);
                        for (g = 0; g < d.length; g++) y = d[g], b += (b ? "-" : "") + y, n(o, b, v, c, p);
                        o(v, function() {
                            u()
                        })
                    } else o([f], function(e) {
                        var n = [],
                            i;
                        t("root", e, n, v, c, p);
                        for (g = 0; g < d.length; g++) i = d[g], b += (b ? "-" : "") + i, t(b, e, n, v, c, p);
                        o(v, function() {
                            var t, i, s;
                            for (t = n.length - 1; t > -1 && n[t]; t--) {
                                s = n[t], i = e[s];
                                if (i === !0 || i === 1) i = o(c + s + "/" + p);
                                r(m, i)
                            }
                            u(m)
                        })
                    })
                }
            }
        })
    }(), define("modules/WordList", ["./EventBus", "./Utils", "text!../assets/template/word-list.html", "i18n!../nls/wordsearch", "underscore"], function(e, t, n, r) {
        function s(n) {
            this.list = t.$("html5-wordsearch-list-" + n.uid), this.options = n;
            var r = e.channel(n.uid);
            r.on("board.resize", _.bind(u, this)), r.on("word.found", _.bind(f, this, "good")), r.on("word.hint", _.bind(f, this, "bad")), r.on("board.created", _.bind(a, this)), r.on("options.change", _.bind(o, this))
        }

        function o(e) {
            var n = e.showSolveButton ? "removeClass" : "addClass";
            t[n](document.body, "disable-hints")
        }

        function u(e) {
            this.list.style.top = e + 10 + "px", this.list.style.width = e + "px";
            var t = this;
            setTimeout(function() {
                t.list.parentNode.style.height = e + t.list.offsetHeight + 15 + "px"
            })
        }

        function a(e) {
            this.words = _.invoke(e.words, "toLowerCase"), this.list.innerHTML = i({
                words: e.words,
                locale: r,
                uid: this.options.uid
            })
        }

        function f(e, n) {
            n = n.toLowerCase();
            if (_.indexOf(this.words, n) === -1) return;
            var r = "html5-wordsearch-" + this.options.uid + "-" + l(n),
                i = t.$(r);
            i.className = "crossed " + e, this.words.splice(_.indexOf(this.words, n), 1)
        }

        function l(e) {
            return e.replace(/ /g, "-")
        }
        var i = _.template(n);
        return s
    }), define("ModalWindow/Utils", ["underscore"], function() {
        function i(e) {
            return e = e || event, e.preventDefault || (e.preventDefault = function() {
                this.returnValue = !1
            }), e.stopPropagation || (e.stopPropagation = function() {
                this.cancelBubble = !0
            }), e
        }

        function o(e, t) {
            e.className += " " + t
        }

        function u(e, t) {
            e.className = e.className.replace(" " + t, "")
        }

        function a(e, t) {
            return parseInt(Math.random() * (t - e + 1)) + e
        }

        function f(e) {
            return e.charAt(a(0, e.length - 1))
        }

        function l(e) {
            return e[a(0, e.length - 1)] || e[0]
        }

        function c(e) {
            return e.replace(/^\s+|\s+$/g, "")
        }

        function h(e) {
            return document.getElementById(e)
        }

        function p(e) {
            var t = 0,
                n = 0;
            if (e.offsetParent)
                do t += e.offsetLeft, n += e.offsetTop; while (e = e.offsetParent);
            return {
                x: t,
                y: n
            }
        }

        function d() {
            if (location.query) return;
            var e = location.search.replace(/^[?]/, "").split("&"),
                t = 0,
                n = e.length,
                r, i = {};
            for (; t < n; t++) {
                if (!e[t]) continue;
                r = e[t].split("="), i[unescape(r[0])] = decodeURI(r[1])
            }
            return i
        }

        function v() {
            document.documentElement.scrollHeight < window.outerHeight / window.devicePixelRatio ? (document.body.style.height = window.outerHeight / window.devicePixelRatio + 1 + "px", setTimeout(function() {
                window.scrollTo(1, 1)
            }, 0)) : window.scrollTo(1, 1)
        }
        var e, t = navigator.userAgent.match(/mobile/i),
            n = t && ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch),
            r = {
                click: "touchstart",
                mousedown: "touchstart",
                mousemove: "touchmove",
                mouseup: "touchend"
            },
            s = function() {
                return document.addEventListener ? function(e, t, i) {
                    if (!e) return;
                    t = n ? r[t] : t, e.addEventListener(t, i, !1)
                } : function(e, t, s) {
                    if (!e) return;
                    t = n ? r[t] : t, e.attachEvent("on" + t, function(e) {
                        return e = i(e), s.call(e.target || e.srcElement, e)
                    })
                }
            }();
        return {
            fullScreen: v,
            isTouchDevice: n,
            $: h,
            addClass: o,
            removeClass: u,
            parseQueryString: d,
            on: s,
            randint: a,
            randchar: f,
            choice: l,
            trim: c,
            position: p,
            now: function() {
                return (new Date).getTime()
            }
        }
    }), define("vendor/require-plugins/normalize", ["require", "module"], function(e, t) {
        function s(e, t, n) {
            return e = r(e), e.match(/^\/|([^\:\/]*:)/) ? e : u(o(e, t), n)
        }

        function o(e, t) {
            e.substr(0, 2) == "./" && (e = e.substr(2));
            var n = t.split("/"),
                r = e.split("/");
            n.pop();
            while (curPart = r.shift()) curPart == ".." ? n.pop() : n.push(curPart);
            return n.join("/")
        }

        function u(e, t) {
            var n = t.split("/");
            n.pop(), t = n.join("/") + "/", i = 0;
            while (t.substr(i, 1) == e.substr(i, 1)) i++;
            while (t.substr(i, 1) != "/") i--;
            t = t.substr(i + 1), e = e.substr(i + 1), n = t.split("/");
            var r = e.split("/");
            out = "";
            while (n.shift()) out += "../";
            while (curPart = r.shift()) out += curPart + "/";
            return out.substr(0, out.length - 1)
        }
        var n = /(^\/+)|([^:])\/+/g,
            r = function(e) {
                return e.replace(n, "$2/")
            },
            a = function(e, t, n) {
                t = r(t), n = r(n);
                var i = /(url\(\s*"([^\)]*)"\s*\))|(url\(\s*'([^\)]*)'\s*\))|(url\(\s*([^\)]*)\s*\))/g,
                    o, u, e;
                while (o = i.exec(e)) {
                    u = o[2] || o[4] || o[6];
                    var a = s(u, t, n),
                        f = o[2] || o[4] ? 1 : 0;
                    e = e.substr(0, i.lastIndex - u.length - f - 1) + a + e.substr(i.lastIndex - f - 1), i.lastIndex = i.lastIndex + (a.length - u.length)
                }
                var l = /(@import\s*'(.*)')|(@import\s*"(.*)")/g;
                while (o = l.exec(e)) {
                    u = o[2] || o[4];
                    var a = s(u, t, n);
                    e = e.substr(0, l.lastIndex - u.length - 1) + a + e.substr(l.lastIndex - 1), l.lastIndex = l.lastIndex + (a.length - u.length)
                }
                return e
            };
        return a.convertURIBase = s, a
    }), define("vendor/require-plugins/css", ["./normalize"], function(e) {
        if (typeof window == "undefined") return {
            load: function(e, t, n) {
                n()
            }
        };
        var t = document.getElementsByTagName("head")[0],
            n = ["Msxml2.XMLHTTP", "Microsoft.XMLHTTP", "Msxml2.XMLHTTP.4.0"],
            r = function(e, t, r) {
                var i, s, o;
                if (typeof XMLHttpRequest != "undefined") i = new XMLHttpRequest;
                else if (typeof ActiveXObject != "undefined")
                    for (s = 0; s < 3; s += 1) {
                        o = n[s];
                        try {
                            i = new ActiveXObject(o)
                        } catch (u) {}
                        if (i) {
                            n = [o];
                            break
                        }
                    }
                i.open("GET", e, requirejs.inlineRequire ? !1 : !0), i.onreadystatechange = function(n) {
                    var s, o;
                    i.readyState === 4 && (s = i.status, s > 399 && s < 600 ? (o = new Error(e + " HTTP status: " + s), o.xhr = i, r(o)) : t(i.responseText))
                }, i.send(null)
            },
            i = {};
        i.pluginBuilder = "./css-builder";
        var s = document.createElement("style");
        s.type = "text/css", t.appendChild(s), s.styleSheet ? i.inject = function(e) {
            s.styleSheet.cssText += e
        } : i.inject = function(e) {
            s.appendChild(document.createTextNode(e))
        }, i.inspect = function() {
            if (s.styleSheet) return s.styleSheet.cssText;
            if (s.innerHTML) return s.innerHTML
        };
        var o = {};
        return i.normalize = function(e, t) {
            var n;
            return e.substr(e.length - 1, 1) == "!" && (n = !0), n && (e = e.substr(0, e.length - 1)), e.substr(e.length - 4, 4) == ".css" && (e = e.substr(0, e.length - 4)), e = t(e), n && (o[e] = n), e
        }, i.load = function(n, s, u, a, f) {
            var l = o[n];
            l && delete o[n];
            var c = n;
            c.substr(c.length - 4, 4) != ".css" && !f && (c += ".css"), c = s.toUrl(c);
            if (c.substr(0, 7) == "http://" || c.substr(0, 8) == "https://") {
                if (f) throw "Cannot preprocess external css.";
                var h = document.createElement("link");
                h.type = "text/css", h.rel = "stylesheet", h.href = c, t.appendChild(h), u(i)
            } else r(c, function(t) {
                var n = window.location.pathname.split("/");
                n.pop(), n = n.join("/") + "/", c.substr(0, 1) != "/" && (c = "/" + e.convertURIBase(c, n, "/")), t = e(t, c, n), f && (t = f(t)), i.inject(t), l || u(i)
            }), l && u(i)
        }, i
    }), define("vendor/require-plugins/css!ModalWindow/modal", [], function() {}), define("ModalWindow/main", ["./Utils", "css!./modal.css"], function(e) {
        function o() {
            t = e.$("modal-window"), n = e.$("modal-window-msg"), r = e.$("modal-window-close"), i = e.$("modal-window-overlay"), e.on(r, "click", f)
        }

        function u(e, t) {
            var n;
            for (n in t) t.hasOwnProperty(n) && (e = e.replace(new RegExp("{" + n + "}", "gi"), t[n]));
            return e
        }

        function a(r, o) {
            var a = t.style,
                f = e.$(r);
            f.className = "", f.nodeName == "SCRIPT" || o ? (n.innerHTML = u(f.innerHTML, o), s = null) : (f.style.display = "block", s = f, n.appendChild(f));
            var l = t.offsetWidth;
            a.marginLeft = -l / 2 + "px", t.className = "modal " + r, i.className = ""
        }

        function f(e) {
            e && e.preventDefault(), t.className = "modal hide", i.className = "hide";
            var r = s;
            return setTimeout(function() {
                if (!r) {
                    n.innerHTML = "";
                    return
                }
                r.style.display = "none", document.body.appendChild(r)
            }, 600), !1
        }
        var t, n, r, i, s;
        return {
            init: o,
            open: a,
            close: f
        }
    }), define("ModalWindow", ["ModalWindow/main"], function(e) {
        return e
    }), define("vendor/require-plugins/text!assets/template/tmpl.html", [], function() {
        return '<div class="html5-wordsearch">\n    <canvas class="grid" id="html5-wordsearch-grid-<%= uid %>"></canvas>\n    <canvas class="lines" id="html5-wordsearch-lines-<%= uid %>"></canvas>\n    <canvas class="layer" id="html5-wordsearch-layer-<%= uid %>"></canvas>\n    <div class="list" id="html5-wordsearch-list-<%= uid %>"></div>\n    <div class="description" id="html5-wordsearch-description-<%= uid %>"></div>\n</div>'
    }), define("vendor/require-plugins/text!assets/template/template.html", [], function() {
        return '<!-- MODAL WINDOW -->\n<div class="hide" id="modal-window-overlay"></div>\n<div id="modal-window" class="hide">\n    <div id="modal-window-msg"></div>\n    <a href="#" id="modal-window-close" class="button"><%= _[\'Close\'] %></a>\n</div>\n\n<script id="congratulation" type="text/template">\n    <h1><%= _[\'Congratulations!\'] %></h1>\n    <h2><%= _[\'Your score is\'] %></h2>\n    <h3>{score}</h3>\n    <form method="post" action="score.php" target="save-score" id="save-score-form">\n        <label>\n        Your Name: <input type="text" name="name" id="save-score-input"/>\n        </label>\n        <input type="submit" value="Save score" class="button"/>\n        <input type="hidden" name="time" value="{time}"/>\n        <input type="hidden" name="score" value="{score}"/>\n    </form>\n</script>\n\n<iframe id="save-score" name="save-score" style="display: none"></iframe>\n\n<!-- help -->\n<div class="modal-hidden" id="help">\n    <h1><%= _[\'How to play!\'] %></h1>\n    <p id="puzzle-description" class="hide"></p>\n    <ul>\n    <li><%= _[\'Find and mark all the words inside the box before your points fall to zero.\'] %></li>\n    <li><%= _[\'The words may be horizontally, vertically, diagonally and even backwards.\'] %></li>\n    <li><%= _[\'If you give up searching for a word use the button next to the word.\'] %></li>\n    </ul>\n    <h3><%= _[\'Good Luck\'] %></h3>\n</div>\n'
    }), define("modules/UI", ["./WordList", "ModalWindow", "./EventBus", "./Utils", "text!../assets/template/tmpl.html", "text!../assets/template/template.html", "i18n!../nls/wordsearch", "underscore"], function(e, t, n, r, i, s, o) {
        function f(i) {
            var s = this;
            h(), this.Modal = t, this.container = document.getElementById(i.container), this.container.innerHTML = u({
                uid: i.uid
            }), this.channel = n.channel(i.uid), this.wordlist = new e(i), r.addClass(document.body, i.showForm ? "" : "hide-form"), this.channel.on("options.change", _.bind(l)), this.channel.on("board.resize", _.bind(c, this)), this.channel.on("board.created", function() {
                setTimeout(function() {
                    r.removeClass(s.container.parentNode, "loading"), r.removeClass(document.body, "loading")
                }, 500)
            }), d(this, i)
        }

        function l(e) {
            if (!e.puzzleDescription) return;
            var t = r.$("puzzle-description");
            r.removeClass(t, "hide"), t && (t.innerHTML = unescape(e.puzzleDescription.replace(/[+]/g, " ")))
        }

        function c(e) {
            this.container.style.width = e + "px"
        }

        function p(e, t) {
            var n = e.replace(a, "");
            t.emit("word.request.hint", r.trim(n))
        }

        function d(e, n) {
            r.on(r.$("html5-wordsearch-list-" + n.uid), "click", function(t) {
                t.preventDefault();
                var n = t.target || t.srcElement;
                n.nodeName == "A" && p(n.parentNode.innerHTML, e.channel)
            }), r.on(document, "submit", function() {
                t.close(), e.channel.emit("form.sent")
            })
        }
        var u = _.template(i),
            a = /<a href=.*/i,
            h = _.once(function() {
                var e = document.createElement("div");
                e.innerHTML = _.template(s)({
                    _: o
                });
                while (e.children.length) document.body.appendChild(e.children[0]);
                t.init()
            });
        return f
    }), define("vendor/require-plugins/text!assets/template/custom-template.html", [], function() {
        return '<div class="html5-wordsearch-game-options">\n<ul>\n    <li><b id="html5-wordsearch-timer-<%= uid %>" class="html5-wordsearch-timer button">00:00:00</b></li>\n    <li><b id="html5-wordsearch-score-<%= uid %>" class="html5-wordsearch-score button"><%= _[\'You have %d points\'] %></b></li>\n    <li><a href="#" data-toggle="modal" data-target="#help-box" id="show-help-<%= uid %>" class="button help left" title="<%= _[\'Help\'] %>"><%= _[\'Help\'] %></a></li>\n    <li><a href="#" id="restart-<%= uid %>" class="button right" title="<%= _[\'Restart\'] %>"><%= _[\'Restart\'] %></a></li>\n    <li><a href="#" id="download-puzzle" class="button" title=""><span>&#x21e9;</span> <%= _[\'Download\'] %></a></li>\n</ul>\n</div>\n<div id="soup-<%= uid %>" class="html5-wordsearch-soup"></div>\n'
    }), define("modules/CustomUI", ["./UI", "text!../assets/template/custom-template.html", "i18n!../nls/wordsearch", "./Utils", "underscore"], function(e, t, n, r) {
        function s(t) {
            var s = document.createElement("div"),
                o = document.createDocumentFragment();
            s.innerHTML = i({
                _: n,
                uid: t.uid
            }), s.className = "wordsearch";
            var u = document.getElementById(t.container) || document.body;
            t.container && typeof t.container != "string" && (u = t.container), u === document.body && (u.innerHTML = ""), r.addClass(u, "wordsearch"), u.parentNode.insertBefore(s, u), s.parentNode.removeChild(u), t.container = "soup-" + t.uid, t.oldContainer = s, e.call(this, t)
        }
        var i = _.template(t);
        return s.prototype = e.prototype, s
    }), define("modules/Selector", ["./Utils", "EventEmitter"], function(e) {
        function t() {
            this.x = -1, this.y = -1, this.col = -1, this.row = -1
        }

        function n(e, t) {
            return e && t && e.row == t.row && e.col == t.col
        }

        function r(t, n) {
            this.element = t, this.cellSize = n, e.on(t, "mousedown", _.bind(o, this)), e.on(t, "mousemove", _.bind(a, this)), e.on(t, "mouseup", _.bind(u, this))
        }

        function s(e) {
            return e.touches && e.touches.length ? e.touches[0] : e
        }

        function o(t) {
            f(t), t = s(t), this.isMousedown = !0, this.pos = e.position(this.element);
            var r = this.getPosition(t);
            this.start && !n(r, this.start) && this.emit("stop", this.start, r), this.emit("clear"), this.emit("start", r), this.start = r
        }

        function u(e) {
            f(e), this.isMousedown = !1;
            if (!this.mousemove) return;
            this.mousemove = !1, e = s(e), this.emit("stop", this.start, this.end), this.start = this.end
        }

        function a(e) {
            f(e);
            if (!this.isMousedown) return;
            this.mousemove = !0, e = s(e), this.end = this.getPosition(e), this.emit("move", this.start, this.end)
        }

        function f(e) {
            e.stopPropagation(), e.preventDefault()
        }
        EventEmitter.mixin(r);
        var i = r.prototype;
        return i.setCellSize = function(e) {
            this.cellSize = e
        }, i.getPosition = function(e) {
            var n = new t;
            return n.x = (e.pageX - this.pos.x + 1 || e.offsetX + 1) - 1, n.y = (e.pageY - this.pos.y + 1 || e.offsetY + 1) - 1, n.col = ~~(n.x / this.cellSize), n.row = ~~(n.y / this.cellSize), n
        }, r
    }), define("modules/Grid", ["./Utils"], function(e) {
        function o(t, n) {
            var i = e.choice(r);
            this.word = e.splitString(t), this.ydir = i.charAt(0), this.xdir = i.charAt(1), this.start = {
                col: e.randint(0, n - 1),
                row: e.randint(0, n - 1)
            }
        }

        function a(t) {
            r = u(t.directions);
            var n = _.map(_.range(t.size), function() {
                    return {}
                }),
                i = 0,
                s = t.words.slice(0),
                o = {},
                a = t.totalWords,
                h = e.now();
            while (s.length && i < a && e.now() - h < 200) {
                var d = l(s, n, t.tries || 5),
                    v = _.max(d, c);
                v.score > 0 && (i++, v.end = p(v, n), v.word = v.word.join(""), o[v.word] = v, s.splice(_.indexOf(s, v.word), 1))
            }
            return {
                grid: f(t.alphabet, n),
                used: o
            }
        }

        function f(t, n) {
            var r, i, s = n.length,
                o = e.splitString(t);
            for (r = 0; r < s; r++) {
                o = _.shuffle(o);
                for (i = 0; i < s; i++) n[r][i] = (n[r][i] || e.choice(o)).toUpperCase()
            }
            return n
        }

        function l(t, n, r) {
            var i = {},
                s;
            for (s = 0; s < r; s++) {
                var u = e.choice(t),
                    a = new o(u, n.length);
                a.score = h(a, n);
                if (i[a.word] && i[u].score > a.score) continue;
                i[u] = a
            }
            return i
        }

        function c(e) {
            return e.score
        }

        function h(e, t) {
            var n = 1,
                r = t.length,
                o = e.xdir,
                u = e.ydir,
                a = e.start.row,
                f = e.start.col;
            if (s[o](e, r) || s[u](e, r)) return 0;
            if (o == "W" || u == "N" || "SW SO NO NW".indexOf(u + o) != -1) n += 1;
            var l, c = e.word.length;
            for (l = 0; l < c; l++) {
                var h = e.word[l];
                if (t[a][f] && t[a][f] !== h) return 0;
                t[a][f] === h && n++, a += i[u], f += i[o]
            }
            return n
        }

        function p(e, t) {
            var n = e.start.row,
                r = e.start.col,
                s = e.word.length,
                o;
            for (o = 0; o < s; o++) t[n][r] = e.word[o], n += i[e.ydir], r += i[e.xdir];
            return {
                row: n - i[e.ydir],
                col: r - i[e.xdir]
            }
        }
        var t = {
                vertical: "S_",
                horizontal: "_O",
                diagonal: "SO NO"
            },
            n = {
                vertical: "N_",
                horizontal: "_W",
                diagonal: "SW NW"
            },
            r, i = {
                S: 1,
                N: -1,
                W: -1,
                O: 1,
                _: 0
            },
            s = {
                S: function(e, t) {
                    return e.start.row + e.word.length > t
                },
                O: function(e, t) {
                    return e.start.col + e.word.length > t
                },
                N: function(e) {
                    return e.start.row - e.word.length < 0
                },
                W: function(e) {
                    return e.start.col - e.word.length < 0
                },
                _: function() {
                    return !1
                }
            },
            u = _.once(function(r) {
                r = _.isArray(r) ? r : [], r = _.invoke(_.map(r, String), "toLowerCase");
                var i = _.map(r, function(e) {
                    return t[e]
                }).join(" ");
                return _.contains(r, "reverse") && (i += _.map(r, function(e) {
                    return n[e]
                }).join(" ")), e.trim(i) || (i = "_O S_ SO NO _W N_ SW NW"), e.trim(i).split(" ")
            });
        return {
            create: a
        }
    }), define("modules/Board", ["./Selector", "./Grid", "./Utils", "./EventBus", "EventEmitter"], function(e, t, n, r, i) {
        function c(e) {
            e.clearRect(0, 0, e.canvas.width, e.canvas.height)
        }

        function h(e) {
            var t = n.$(e);
            return !t.getContext && window.G_vmlCanvasManager && G_vmlCanvasManager.initElement(t), t.getContext("2d")
        }

        function p(e) {
            e.width = e.height = this.boardSize
        }

        function d(t) {
            this.setOptions(t), this.words = this.options.words, this.founds = [], this.channel = r.channel(this.options.uid), this.boardCtx = h("html5-wordsearch-grid-" + t.uid), this.linesCtx = h("html5-wordsearch-lines-" + t.uid), this.selectorCtx = h("html5-wordsearch-layer-" + t.uid), this.canvases = [this.boardCtx.canvas, this.linesCtx.canvas, this.selectorCtx.canvas], this.selector = new e(this.selectorCtx.canvas), this.selector.on("start", _.bind(y, this)), this.selector.on("clear", _.bind(c, this, this.selectorCtx)), this.selector.on("move", _.bind(b, this)), this.selector.on("stop", _.bind(c, this, this.selectorCtx)), this.selector.on("stop", _.bind(N, this)), this.channel.on("time.finish", _.bind(this.stop, this)), this.channel.on("word.found", _.bind(E, this)), this.channel.on("word.hint", _.bind(E, this)), this.channel.on("word.request.hint", _.bind(T, this)), this.channel.on("options.change", _.bind(this.setOptions, this)), n.on(window, "resize", _.bind(this.redraw, this))
        }

        function m(e) {
            var t = /[\s']+/ig;
            return _.object(_.map(e, function(e, n) {
                return [n.toLowerCase().replace(t, ""), e]
            }))
        }

        function g(e, t) {
            e.lineCap = "round", e.strokeStyle = t || this.options.selectColor, e.globalAlpha = .5, e.lineWidth = this.cellSize * .8
        }

        function y(e) {
            var t = this.cellSize,
                n = ~~(t / 2);
            this.selectorCtx.beginPath(), g.call(this, this.selectorCtx), this.selectorCtx.lineWidth = ~~(t / 4), this.selectorCtx.arc(e.col * t + n, e.row * t + n, n, 0, Math.PI * 2, !0), this.selectorCtx.closePath(), this.selectorCtx.stroke()
        }

        function b(e, t) {
            c(this.selectorCtx), g.call(this, this.selectorCtx);
            var n = this.cellSize,
                r = ~~(n / 2),
                i = this.selectorCtx;
            i.beginPath(), i.moveTo(e.col * n + r, e.row * n + r), i.lineTo(t.x, t.y), i.stroke(), i.closePath()
        }

        function w(e, t, n) {
            var r = this.cellSize,
                i = ~~(r / 2);
            e.moveTo(t.col * r + i, t.row * r + i), e.lineTo(n.col * r + i, n.row * r + i)
        }

        function E() {
            var e, t = this.founds.length;
            c(this.linesCtx), g.call(this, this.linesCtx, "red"), this.linesCtx.beginPath(), this.linesCtx.moveTo(-100, -100), this.linesCtx.lineTo(-110, -110), this.linesCtx.stroke();
            for (e = 0; e < t; e += 2) w.call(this, this.linesCtx, this.founds[e], this.founds[e + 1]);
            this.linesCtx.stroke(), this.linesCtx.closePath()
        }

        function S() {
            !this._gameFinish_ && this._totalWords_ === 0 && this.stop()
        }

        function x(e, t, n) {
            return this.data.used[e] ? (this._totalWords_--, this.founds.push(t, n), setTimeout(_.bind(S, this)), delete this.data.used[e], !0) : !1
        }

        function T(e) {
            if (this._gameFinish_ || !this.options.showSolveButton) return;
            var t = this.hints[e];
            x.call(this, t.word, t.start, t.end) && this.channel.emit("word.hint", e)
        }

        function N(e, t) {
            if (this._gameFinish_) return;
            var n = C(this.data.grid, e, t),
                r = n.join("").toLowerCase(),
                i = n.reverse().join("").toLowerCase(),
                s = this.data.used[r] ? r : i;
            x.call(this, s, e, t) && this.channel.emit("word.found", this.words[s].toLowerCase())
        }

        function C(e, t, n) {
            var r = n.col > -1 && n.col < e.length,
                i = n.row > -1 && n.row < e.length,
                s = o(t.col - n.col) === o(t.row - n.row),
                u = t.row == n.row,
                a = t.col == n.col;
            if (!r || !i || !s && !u && !a) return [];
            var f = n.col - t.col,
                l = n.row - t.row,
                c = f > 0 ? 1 : f < 0 ? -1 : 0,
                h = l > 0 ? 1 : l < 0 ? -1 : 0,
                p = t.col,
                d = t.row,
                v = n.col + c,
                m = n.row + h,
                g = [];
            while (p !== v || d !== m) g.push(e[d][p]), p += p !== v ? c : 0, d += d !== m ? h : 0;
            return g
        }
        var s = {
                alphabet: "abcdefghijklmnopqrstuvwxyz",
                fontSize: 14,
                showSolveButton: !0,
                fontFamily: "Arial",
                color: "black",
                selectColor: "blue",
                size: 20,
                totalWords: 20,
                wordDirections: ["horizontal", "vertical", "diagonal", "reverse"]
            },
            o = Math.abs,
            u = 1.8,
            a = .75,
            f, l;
        EventEmitter.mixin(d);
        var v = d.prototype;
        return v.setOptions = function(e) {
            this.options = _.defaults(e || {}, s)
        }, v.restart = function() {
            this.calcSizes(), this.founds.length = 0, this.data = t.create({
                alphabet: this.options.alphabet,
                size: this.options.size,
                words: _.keys(this.words),
                directions: this.options.wordDirections,
                totalWords: this.options.totalWords
            }), this.hints = _.object(_.map(this.data.used, function(e, t) {
                return [this.words[t], e]
            }, this));
            var e = _.pluck(this.data.used, "word");
            this._totalWords_ = e.length, this._gameFinish_ = !1, this.channel.emit("board.created", {
                grid: this.data.grid,
                words: _.values(_.pick(this.words, e)),
                solutions: this.hints
            }), this.draw()
        }, v.start = v.restart, v.stop = function() {
            this._gameFinish_ = !0, this.channel.emit("game.finish")
        }, v.calcSizes = function() {
            this.options.fontSize = this._originalFontSize || this.options.fontSize, this.cellSize = ~~(this.options.fontSize * u), this.boardSize = this.cellSize * this.options.size;
            var e = this.options.oldContainer.offsetWidth;
            e < this.boardSize && (this._originalFontSize = this.options.fontSize, this.options.fontSize = ~~(e / this.options.size / u), this.cellSize = ~~(this.options.fontSize * u), this.boardSize = this.cellSize * this.options.size), this.selector.setCellSize(this.cellSize), _.each(this.canvases, p, this), this.channel.emit("board.resize", this.boardSize)
        }, v.redraw = function() {
            this.calcSizes(), this.draw(), E.call(this)
        }, v.draw = function() {
            var e = this.data.grid,
                t = this.cellSize,
                n = this.options.fontSize,
                r = parseInt(n * a),
                i = parseInt(n * u * a, 10);
            this.boardCtx.fillStyle = this.options.color, this.boardCtx.font = n + "px " + this.options.fontFamily + ", Arial", this.boardCtx.textAlign = "center";
            for (var s = 0; s < this.options.size; s++)
                for (var o = 0; o < this.options.size; o++) this.boardCtx.fillText(e[s][o], t * o + r, t * s + i)
        }, v.setWords = function(e) {
            this.words = m.call(this, e), this.restart()
        }, d
    }), define("modules/Score", ["./EventBus", "underscore"], function(e) {
        function t(e) {
            return document.getElementById(e)
        }

        function i(n) {
            this.setOptions(n), this.e_clock = t(this.options.timer + "-" + this.options.uid), this.e_point = t(this.options.score + "-" + this.options.uid), this.channel = e.channel(this.options.uid), this.e_point && (this.layout = this.e_point.innerHTML || "%d points"), this.channel.on("options.change", _.bind(this.setOptions, this)), this.restart()
        }
        var n = 0,
            r = {
                initialScore: 0,
                every: Infinity,
                deduct: 0
            },
            s = i.prototype;
        return s.setOptions = function(e) {
            this.options = _.clone(_.defaults(e || {}, r)), this.options.every = this.options.every * 1e3 || Infinity, _.isNumber(e.maxTime) && e.maxTime > 0 ? this.options.maxTime = e.maxTime * 60 * 1e3 : this.options.maxTime = Infinity
        }, s.now = function() {
            return (new Date).getTime()
        }, s.restart = function() {
            this.start = this.stopTime = this.last = this.now(), this.points = _.isNumber(this.options.initialScore) ? this.options.initialScore : 0, this.updatePoints(), this.startTime()
        }, s.updatePoints = function() {
            this.e_point && (this.e_point.innerHTML = this.layout.replace("%d", this.points)), this.channel.emit("score.change", this.points)
        }, s.startTime = function() {
            var e = this;
            this.uuid = n,
                function t() {
                    if (e.uuid !== n) return;
                    var r = e.stopTime = e.now();
                    e.e_clock && (e.e_clock.innerHTML = e.time()), r - e.last > e.options.every && (e.last = r, e.scoreDown(-e.options.deduct)), r - e.start >= e.options.maxTime && e.channel.emit("time.finish"), setTimeout(t, 1e3)
                }()
        }, s.stop = function() {
            ++n
        }, s.scoreUp = function(e) {
            _.isNumber(e) && e > 0 && (this.points += e, this.updatePoints())
        }, s.scoreDown = function(e) {
            _.isNumber(e) && e < 0 && (this.points += e, this.updatePoints())
        }, s.getScore = function() {
            return this.points
        }, s.time = function() {
            var e = this.options.maxTime,
                t = this.stopTime - this.start,
                n = e > 0 && e < Infinity ? e - t : t,
                r = n % 1e3,
                i = ~~(n / 1e3),
                s = i % 60,
                o = ~~(i / 60),
                u = ~~(o / 60);
            return o %= 60, (u > 9 ? u : "0" + u) + ":" + (o > 9 ? o : "0" + o % 60) + ":" + (s > 9 ? s : "0" + s)
        }, i
    }), define("vendor/require-plugins/text!assets/template/description.html", [], function() {
        return '<span class="word"><%= word %></span>\n<span class="separator">:</span>\n<span class="description"><%= description %></span>'
    }), define("modules/Description", ["./EventBus", "./Utils", "text!../assets/template/description.html", "underscore"], function(e, t, n) {
        function i(n) {
            this.descriptions = [], this.enabled = n.showDescriptions, this.description = t.$("html5-wordsearch-description-" + n.uid);
            var r = e.channel(n.uid);
            r.on("data.processed", _.bind(u, this)), r.on("game.restart", _.bind(o, this)), r.on("word.found", _.bind(a, this)), r.on("word.hint", _.bind(a, this)), r.on("board.resize", _.bind(f, this)), r.on("options.change", _.bind(s, this))
        }

        function s(e) {
            this.enabled = e.showDescriptions
        }

        function o() {
            this.description.innerHTML = ""
        }

        function u(e) {
            this.descriptions = _.object(_.map(e, function(e) {
                return [(e.inList || e.inBoard).toLowerCase(), e]
            }))
        }

        function a(e) {
            e = e.toLowerCase();
            if (!this.enabled || !(e in this.descriptions)) return;
            if (!this.descriptions[e].description) return o.call(this);
            this.description.innerHTML = r({
                word: this.descriptions[e].inList,
                description: this.descriptions[e].description
            })
        }

        function f(e) {
            this.description.style.top = e + 10 + "px", this.description.style.width = e + "px"
        }
        var r = _.template(n);
        return i
    }), define("modules/Data", ["./EventBus", "./Utils", "underscore"], function(e, t) {
        function i(e) {
            return String(e)
        }

        function s(e) {
            return parseInt(e, 10) || 0
        }

        function o(e) {
            return e = e.toLowerCase(), e == "true" ? !0 : e == "false" ? !1 : !!s(e)
        }

        function u(e, r) {
            e = t.trim(e);
            var i = e.split(n),
                s = _.compact(_.map(i, l)),
                o = _.object(_.compact(_.map(i, f)));
            r.emit("data.processed", s, o)
        }

        function a(e) {
            return t.trim(e).charAt(0) === "#"
        }

        function f(e) {
            if (!a(e)) return;
            var n = e.replace("#", "").split(":"),
                s = t.trim(n[0]),
                o = t.trim(n[1]);
            return o = (r[s] || i)(o), [s, o]
        }

        function l(e) {
            if (a(e)) return;
            var n = e.split("|"),
                r = n[0].split(":");
            return {
                inBoard: t.trim(r[0]),
                inList: t.trim(r[1] || r[0]),
                description: t.trim(n[1] || "")
            }
        }
        var n = /\r\n|\n/g,
            r = {
                alphabet: i,
                totalWords: s,
                size: s,
                showSolveButton: o,
                showDescriptions: o,
                every: s,
                deduct: s,
                initialScore: s
            };
        e.on("data.arrived", u)
    }), requirejs.config({
        urlArgs: "bust=" + (new Date).getTime(),
        packages: ["ModalWindow"],
        map: {
            "*": {
                EventEmitter: "vendor/EventEmitter.min",
                underscore: "vendor/underscore",
                json: "vendor/json2",
                i18n: "vendor/require-plugins/i18n",
                text: "vendor/require-plugins/text",
                css: "vendor/require-plugins/css",
                "css-builder": "vendor/require-plugins/css-builder",
                normalize: "vendor/require-plugins/normalize"
            }
        },
        pragmas: {
            excludeDownload: !0
        },
        skipDirOptimize: !0,
        dir: "../build",
        name: "main",
        include: ["EventEmitter", "./modules/EventBus"],
        exclude: ["nls/wordsearch.js"],
        shim: {
            json: {
                exports: "JSON"
            },
            underscore: {
                exports: "_"
            }
        }
    }), define("main", ["./modules/CustomUI", "./modules/Board", "./modules/Score", "./modules/Description", "./modules/EventBus", "./modules/Utils", "./modules/Data"], function(e, t, n, r, i, s, o) {
        function f(o) {
            this.options = o = _.defaults(o || {}, a), o.uid = (new Date).getTime() + _.uniqueId(), this.channel = i.channel(o.uid), this.ui = new e(o), this.board = new t(o), this.timer = new n(o), this.description = new r(o), s.isTouchDevice && (document.body.overflow = "auto", s.on(window, "resize", s.fullScreen)), s.fullScreen(), this.channel.on("game.finish", _.bind(c, this)), this.channel.on("word.found", _.bind(this.timer.scoreUp, this.timer, f.points.ON_FOUND)), this.channel.on("word.hint", _.bind(this.timer.scoreDown, this.timer, f.points.ON_HINT)), this.channel.on("data.processed", _.bind(this.setWords, this)), p(this), s.getData(this.options.oldContainer.previousSibling, this.channel)
        }

        function c() {
            this.timer.stop(),  
            time= this.timer.time(),
            score= this.timer.getScore(),
            jQuery('#congrats-banner').removeClass('hidden');
            //this.ui.Modal.open("congratulation", {})
        }

        function h(e, t) {
            return function(n) {
                n.preventDefault(), e.board.options.fontSize += t, e.board.redraw()
            }
        }

        function p(e) {
            s.on(s.$("show-help-" + e.options.uid), "click", function(t) {
                t.preventDefault(), e.ui.Modal.open("help")
            }), s.on(s.$("restart-" + e.options.uid), "click", function(t) {
                t.preventDefault(), e.restart()
            }), s.on(s.$("font-size-up"), "click", h(e, 1)), s.on(s.$("font-size-down"), "click", h(e, -1))
        }
        var u = {
                ON_FOUND: 10,
                ON_HINT: -10
            },
            a = {
                timer: "html5-wordsearch-timer",
                score: "html5-wordsearch-score",
                url: "words/default.txt",
                allowDownload: !1,
                showDescriptions: !0
            },
            l = f.prototype;
        return l.setWords = function(e, t) {
            _.isObject(t) && (this.options = _.defaults(t, this.options), this.channel.emit("options.change", this.options), this.timer.restart()), this.board.setWords(_.object(_.map(e, function(e) {
                return [e.inBoard, e.inList]
            })))
        }, l.restart = function() {
            this.board.restart(), this.timer.restart(), this.channel.emit("game.restart")
        }, l.stop = function() {
            this.board.stop(), this.timer.stop(), this.channel.emit("game.stop")
        }, f.points = u, f.GET = s.parseQueryString(), f
    }),
    function(e) {
        function t(e, t) {
            for (var n = 0, r = e.length; n < r; n++)
                if (e[n] === t) return n;
            return -1
        }
        e._cssWritten = e._cssWritten || [];
        if (t(e._cssWritten, "main") != -1) return;
        e._cssWritten.push("main");
        for (var n in requirejs.s.contexts) requirejs.s.contexts[n].nextTick = function(e) {
            e()
        };
        require(["css", "vendor/require-plugins/normalize", "require"], function(e, t, n) {
            var r = window.location.pathname.split("/");
            r.pop(), r = r.join("/") + "/";
            var i = n.toUrl("base_url").split("/");
            i.pop();
            var s = i.join("/") + "/";
            s = t.convertURIBase(s, r, "/"), s.substr(0, 1) != "/" && (s = "/" + s), s.substr(s.length - 1, 1) != "/" && (s += "/"), e.inject(t("\ndiv#modal-window h1,\ndiv#modal-window h2,\ndiv#modal-window h3,\ndiv#modal-window h4,\ndiv#modal-window h5,\ndiv#modal-window h6 { text-align: center; margin-bottom: 5px; }\n.modal-hidden { display: none; }\ndiv#modal-window-overlay {\n    position: fixed;\n    background: #000;\n    top: 0;\n    left: 0;\n    right: 0;\n    bottom: 0;\n    filter: alpha(opacity=50);\n    opacity: .5;\n    z-index: 500;\n    cursor: pointer;\n}\ndiv#modal-window-overlay.hide { display: none; }\ndiv#modal-window {\n    font-family: Helvetica, Arial, sans-serif;\n    position: fixed;\n    top: -3px;\n    left: 50%;\n    z-index: 1000;\n    background: #fefefe;\n    padding: 20px;\n    box-shadow: 0 0 10px #333;\n    -webkit-transition: top .4s ease-in-out;\n    -moz-transition: top .4s linear;\n    -o-transition: top .4s linear;\n    -ms-transition: top .4s linear;\n    transition: top .4s linear;\n    width: 400px;\n    border: 2px solid #333;\n    color: #333;\n}\ndiv#modal-window.hide { top: -1000px; display: block; }\ndiv#modal-window .button {\n    float: right;\n    margin: 3px 0;\n    cursor: pointer;\n    text-decoration: none;\n    font-size: 13px;\n    padding: 4px 10px 4px;\n    color: #333333;\n    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);\n    background-color: #ffffff;\n    background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6);\n    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));\n    background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);\n    background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);\n    background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);\n    border: 1px solid #cccccc;\n    border-color: #e6e6e6 #e6e6e6 #e6e6e6;\n    border-bottom-color: #e6e6e6;\n    -webkit-border-radius: 4px;\n    -moz-border-radius: 4px;\n    border-radius: 4px;\n    filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ffffff', endColorstr='#e6e6e6', GradientType=0);\n    filter: progid:dximagetransform.microsoft.gradient(enabled=false);\n    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);\n    -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);\n    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);\n}\n", s, r))
        });
        for (var n in requirejs.s.contexts) requirejs.s.contexts[n].nextTick = requirejs.nextTick
    }(this);