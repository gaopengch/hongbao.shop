webpackJsonp([77],{230:function(e,t,r){var o=r(114)(r(477),r(907),null,null);e.exports=o.exports},307:function(e,t,r){"use strict";var o=Object.prototype.hasOwnProperty,n=Array.isArray,i=function(){for(var e=[],t=0;t<256;++t)e.push("%"+((t<16?"0":"")+t.toString(16)).toUpperCase());return e}(),a=function(e){for(;e.length>1;){var t=e.pop(),r=t.obj[t.prop];if(n(r)){for(var o=[],i=0;i<r.length;++i)void 0!==r[i]&&o.push(r[i]);t.obj[t.prop]=o}}},s=function(e,t){for(var r=t&&t.plainObjects?Object.create(null):{},o=0;o<e.length;++o)void 0!==e[o]&&(r[o]=e[o]);return r},l=function e(t,r,i){if(!r)return t;if("object"!=typeof r){if(n(t))t.push(r);else{if(!t||"object"!=typeof t)return[t,r];(i&&(i.plainObjects||i.allowPrototypes)||!o.call(Object.prototype,r))&&(t[r]=!0)}return t}if(!t||"object"!=typeof t)return[t].concat(r);var a=t;return n(t)&&!n(r)&&(a=s(t,i)),n(t)&&n(r)?(r.forEach(function(r,n){if(o.call(t,n)){var a=t[n];a&&"object"==typeof a&&r&&"object"==typeof r?t[n]=e(a,r,i):t.push(r)}else t[n]=r}),t):Object.keys(r).reduce(function(t,n){var a=r[n];return o.call(t,n)?t[n]=e(t[n],a,i):t[n]=a,t},a)},c=function(e,t){return Object.keys(t).reduce(function(e,r){return e[r]=t[r],e},e)},u=function(e,t,r){var o=e.replace(/\+/g," ");if("iso-8859-1"===r)return o.replace(/%[0-9a-f]{2}/gi,unescape);try{return decodeURIComponent(o)}catch(e){return o}},f=function(e,t,r){if(0===e.length)return e;var o=e;if("symbol"==typeof e?o=Symbol.prototype.toString.call(e):"string"!=typeof e&&(o=String(e)),"iso-8859-1"===r)return escape(o).replace(/%u[0-9a-f]{4}/gi,function(e){return"%26%23"+parseInt(e.slice(2),16)+"%3B"});for(var n="",a=0;a<o.length;++a){var s=o.charCodeAt(a);45===s||46===s||95===s||126===s||s>=48&&s<=57||s>=65&&s<=90||s>=97&&s<=122?n+=o.charAt(a):s<128?n+=i[s]:s<2048?n+=i[192|s>>6]+i[128|63&s]:s<55296||s>=57344?n+=i[224|s>>12]+i[128|s>>6&63]+i[128|63&s]:(a+=1,s=65536+((1023&s)<<10|1023&o.charCodeAt(a)),n+=i[240|s>>18]+i[128|s>>12&63]+i[128|s>>6&63]+i[128|63&s])}return n},p=function(e){for(var t=[{obj:{o:e},prop:"o"}],r=[],o=0;o<t.length;++o)for(var n=t[o],i=n.obj[n.prop],s=Object.keys(i),l=0;l<s.length;++l){var c=s[l],u=i[c];"object"==typeof u&&null!==u&&-1===r.indexOf(u)&&(t.push({obj:i,prop:c}),r.push(u))}return a(t),e},d=function(e){return"[object RegExp]"===Object.prototype.toString.call(e)},y=function(e){return!(!e||"object"!=typeof e)&&!!(e.constructor&&e.constructor.isBuffer&&e.constructor.isBuffer(e))},h=function(e,t){return[].concat(e,t)};e.exports={arrayToObject:s,assign:c,combine:h,compact:p,decode:u,encode:f,isBuffer:y,isRegExp:d,merge:l}},308:function(e,t,r){"use strict";var o=String.prototype.replace,n=/%20/g,i=r(307),a={RFC1738:"RFC1738",RFC3986:"RFC3986"};e.exports=i.assign({default:a.RFC3986,formatters:{RFC1738:function(e){return o.call(e,n,"+")},RFC3986:function(e){return String(e)}}},a)},309:function(e,t,r){"use strict";var o=r(312),n=r(311),i=r(308);e.exports={formats:i,parse:n,stringify:o}},311:function(e,t,r){"use strict";var o=r(307),n=Object.prototype.hasOwnProperty,i={allowDots:!1,allowPrototypes:!1,arrayLimit:20,charset:"utf-8",charsetSentinel:!1,comma:!1,decoder:o.decode,delimiter:"&",depth:5,ignoreQueryPrefix:!1,interpretNumericEntities:!1,parameterLimit:1e3,parseArrays:!0,plainObjects:!1,strictNullHandling:!1},a=function(e){return e.replace(/&#(\d+);/g,function(e,t){return String.fromCharCode(parseInt(t,10))})},s=function(e,t){var r,s={},l=t.ignoreQueryPrefix?e.replace(/^\?/,""):e,c=t.parameterLimit===1/0?void 0:t.parameterLimit,u=l.split(t.delimiter,c),f=-1,p=t.charset;if(t.charsetSentinel)for(r=0;r<u.length;++r)0===u[r].indexOf("utf8=")&&("utf8=%E2%9C%93"===u[r]?p="utf-8":"utf8=%26%2310003%3B"===u[r]&&(p="iso-8859-1"),f=r,r=u.length);for(r=0;r<u.length;++r)if(r!==f){var d,y,h=u[r],m=h.indexOf("]="),g=-1===m?h.indexOf("="):m+1;-1===g?(d=t.decoder(h,i.decoder,p,"key"),y=t.strictNullHandling?null:""):(d=t.decoder(h.slice(0,g),i.decoder,p,"key"),y=t.decoder(h.slice(g+1),i.decoder,p,"value")),y&&t.interpretNumericEntities&&"iso-8859-1"===p&&(y=a(y)),y&&t.comma&&y.indexOf(",")>-1&&(y=y.split(",")),n.call(s,d)?s[d]=o.combine(s[d],y):s[d]=y}return s},l=function(e,t,r){for(var o=t,n=e.length-1;n>=0;--n){var i,a=e[n];if("[]"===a&&r.parseArrays)i=[].concat(o);else{i=r.plainObjects?Object.create(null):{};var s="["===a.charAt(0)&&"]"===a.charAt(a.length-1)?a.slice(1,-1):a,l=parseInt(s,10);r.parseArrays||""!==s?!isNaN(l)&&a!==s&&String(l)===s&&l>=0&&r.parseArrays&&l<=r.arrayLimit?(i=[],i[l]=o):i[s]=o:i={0:o}}o=i}return o},c=function(e,t,r){if(e){var o=r.allowDots?e.replace(/\.([^.[]+)/g,"[$1]"):e,i=/(\[[^[\]]*])/,a=/(\[[^[\]]*])/g,s=r.depth>0&&i.exec(o),c=s?o.slice(0,s.index):o,u=[];if(c){if(!r.plainObjects&&n.call(Object.prototype,c)&&!r.allowPrototypes)return;u.push(c)}for(var f=0;r.depth>0&&null!==(s=a.exec(o))&&f<r.depth;){if(f+=1,!r.plainObjects&&n.call(Object.prototype,s[1].slice(1,-1))&&!r.allowPrototypes)return;u.push(s[1])}return s&&u.push("["+o.slice(s.index)+"]"),l(u,t,r)}},u=function(e){if(!e)return i;if(null!==e.decoder&&void 0!==e.decoder&&"function"!=typeof e.decoder)throw new TypeError("Decoder has to be a function.");if(void 0!==e.charset&&"utf-8"!==e.charset&&"iso-8859-1"!==e.charset)throw new Error("The charset option must be either utf-8, iso-8859-1, or undefined");var t=void 0===e.charset?i.charset:e.charset;return{allowDots:void 0===e.allowDots?i.allowDots:!!e.allowDots,allowPrototypes:"boolean"==typeof e.allowPrototypes?e.allowPrototypes:i.allowPrototypes,arrayLimit:"number"==typeof e.arrayLimit?e.arrayLimit:i.arrayLimit,charset:t,charsetSentinel:"boolean"==typeof e.charsetSentinel?e.charsetSentinel:i.charsetSentinel,comma:"boolean"==typeof e.comma?e.comma:i.comma,decoder:"function"==typeof e.decoder?e.decoder:i.decoder,delimiter:"string"==typeof e.delimiter||o.isRegExp(e.delimiter)?e.delimiter:i.delimiter,depth:"number"==typeof e.depth||!1===e.depth?+e.depth:i.depth,ignoreQueryPrefix:!0===e.ignoreQueryPrefix,interpretNumericEntities:"boolean"==typeof e.interpretNumericEntities?e.interpretNumericEntities:i.interpretNumericEntities,parameterLimit:"number"==typeof e.parameterLimit?e.parameterLimit:i.parameterLimit,parseArrays:!1!==e.parseArrays,plainObjects:"boolean"==typeof e.plainObjects?e.plainObjects:i.plainObjects,strictNullHandling:"boolean"==typeof e.strictNullHandling?e.strictNullHandling:i.strictNullHandling}};e.exports=function(e,t){var r=u(t);if(""===e||null===e||void 0===e)return r.plainObjects?Object.create(null):{};for(var n="string"==typeof e?s(e,r):e,i=r.plainObjects?Object.create(null):{},a=Object.keys(n),l=0;l<a.length;++l){var f=a[l],p=c(f,n[f],r);i=o.merge(i,p,r)}return o.compact(i)}},312:function(e,t,r){"use strict";var o=r(307),n=r(308),i=Object.prototype.hasOwnProperty,a={brackets:function(e){return e+"[]"},comma:"comma",indices:function(e,t){return e+"["+t+"]"},repeat:function(e){return e}},s=Array.isArray,l=Array.prototype.push,c=function(e,t){l.apply(e,s(t)?t:[t])},u=Date.prototype.toISOString,f=n.default,p={addQueryPrefix:!1,allowDots:!1,charset:"utf-8",charsetSentinel:!1,delimiter:"&",encode:!0,encoder:o.encode,encodeValuesOnly:!1,format:f,formatter:n.formatters[f],indices:!1,serializeDate:function(e){return u.call(e)},skipNulls:!1,strictNullHandling:!1},d=function(e){return"string"==typeof e||"number"==typeof e||"boolean"==typeof e||"symbol"==typeof e||"bigint"==typeof e},y=function e(t,r,n,i,a,l,u,f,y,h,m,g,b){var v=t;if("function"==typeof u?v=u(r,v):v instanceof Date?v=h(v):"comma"===n&&s(v)&&(v=v.join(",")),null===v){if(i)return l&&!g?l(r,p.encoder,b,"key"):r;v=""}if(d(v)||o.isBuffer(v)){if(l){return[m(g?r:l(r,p.encoder,b,"key"))+"="+m(l(v,p.encoder,b,"value"))]}return[m(r)+"="+m(String(v))]}var O=[];if(void 0===v)return O;var j;if(s(u))j=u;else{var w=Object.keys(v);j=f?w.sort(f):w}for(var S=0;S<j.length;++S){var x=j[S];a&&null===v[x]||(s(v)?c(O,e(v[x],"function"==typeof n?n(r,x):r,n,i,a,l,u,f,y,h,m,g,b)):c(O,e(v[x],r+(y?"."+x:"["+x+"]"),n,i,a,l,u,f,y,h,m,g,b)))}return O},h=function(e){if(!e)return p;if(null!==e.encoder&&void 0!==e.encoder&&"function"!=typeof e.encoder)throw new TypeError("Encoder has to be a function.");var t=e.charset||p.charset;if(void 0!==e.charset&&"utf-8"!==e.charset&&"iso-8859-1"!==e.charset)throw new TypeError("The charset option must be either utf-8, iso-8859-1, or undefined");var r=n.default;if(void 0!==e.format){if(!i.call(n.formatters,e.format))throw new TypeError("Unknown format option provided.");r=e.format}var o=n.formatters[r],a=p.filter;return("function"==typeof e.filter||s(e.filter))&&(a=e.filter),{addQueryPrefix:"boolean"==typeof e.addQueryPrefix?e.addQueryPrefix:p.addQueryPrefix,allowDots:void 0===e.allowDots?p.allowDots:!!e.allowDots,charset:t,charsetSentinel:"boolean"==typeof e.charsetSentinel?e.charsetSentinel:p.charsetSentinel,delimiter:void 0===e.delimiter?p.delimiter:e.delimiter,encode:"boolean"==typeof e.encode?e.encode:p.encode,encoder:"function"==typeof e.encoder?e.encoder:p.encoder,encodeValuesOnly:"boolean"==typeof e.encodeValuesOnly?e.encodeValuesOnly:p.encodeValuesOnly,filter:a,formatter:o,serializeDate:"function"==typeof e.serializeDate?e.serializeDate:p.serializeDate,skipNulls:"boolean"==typeof e.skipNulls?e.skipNulls:p.skipNulls,sort:"function"==typeof e.sort?e.sort:null,strictNullHandling:"boolean"==typeof e.strictNullHandling?e.strictNullHandling:p.strictNullHandling}};e.exports=function(e,t){var r,o,n=e,i=h(t);"function"==typeof i.filter?(o=i.filter,n=o("",n)):s(i.filter)&&(o=i.filter,r=o);var l=[];if("object"!=typeof n||null===n)return"";var u;u=t&&t.arrayFormat in a?t.arrayFormat:t&&"indices"in t?t.indices?"indices":"repeat":"indices";var f=a[u];r||(r=Object.keys(n)),i.sort&&r.sort(i.sort);for(var p=0;p<r.length;++p){var d=r[p];i.skipNulls&&null===n[d]||c(l,y(n[d],d,f,i.strictNullHandling,i.skipNulls,i.encode?i.encoder:null,i.filter,i.sort,i.allowDots,i.serializeDate,i.formatter,i.encodeValuesOnly,i.charset))}var m=l.join(i.delimiter),g=!0===i.addQueryPrefix?"?":"";return i.charsetSentinel&&("iso-8859-1"===i.charset?g+="utf8=%26%2310003%3B&":g+="utf8=%E2%9C%93&"),m.length>0?g+m:""}},477:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=r(57),n=r(309),i=function(e){return e&&e.__esModule?e:{default:e}}(n),a=window.location.href,s=a.split("?"),l=s[1].split("="),c=l[1];t.default={created:function(){var e=this,t=this.$route.query;if(t.app_user_id&&(sessionStorage.setItem("user_ID",t.app_user_id),localStorage.setItem("user_ID",t.app_user_id),localStorage.setItem("logoin_time_code",t.last_logon_time)),t.data_token){var r=localStorage.getItem("user_ID");this.axios.post(API_URL+"Home/Index/setOpenId",i.default.stringify({app_user_id:r,open_id:c})).then(function(t){if(1!=t.data.status&&(0,o.Toast)("存储openid失败"),sessionStorage.getItem("goods_id"))e.$router.push("/follow");else if(sessionStorage.getItem("groupRouteInfo")){var r=JSON.parse(sessionStorage.getItem("groupRouteInfo"));e.$router.push({path:"/groupDetail",query:{id:r.id,group_id:r.group_id}})}else e.$router.push("/home")}).catch(function(e){console.log(e)})}if(sessionStorage.getItem("goods_id"))this.$router.push("/follow");else if(sessionStorage.getItem("groupRouteInfo")){var n=JSON.parse(sessionStorage.getItem("groupRouteInfo"));this.$router.push({path:"/groupDetail",query:{id:n.id,group_id:n.group_id}})}else this.$router.push("/home")}}},907:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement;return(e._self._c||t)("div")},staticRenderFns:[]}}});
//# sourceMappingURL=77.8933930bd3f048628d19.js.map