webpackJsonp([83],{

/***/ 101:
/***/ (function(module, exports) {

// window.API_URL = 'http://api.2tianqc.com/';
// window.API_URL = 'http://www.shopsn_busi_api.com/';
// window.API_URL = 'http://bizapi.shopsn.cn/';
// window.API_URL = 'http://api.shopcns.cn/';
// window.API_URL= 'http://b2capi.shopsn.cn/';
window.API_URL= 'http://bizapi.shopsn.cn/';

(function() {

    //截取当前访问者的url 参数
    this.split_url = function(name) {
            let url = window.location.href;
            let index = url.indexOf(name);
            if (index === -1) {
                return '';
            }
            let urlParam = url.substring(url.indexOf(name) + 1);
            return urlParam;
        },
        window.getInfo = {
            split_url: this.split_url,
        };
})(window);

String.prototype.replaceAll = function(str, bystr) {
    var regExp = new RegExp(str, "g");
    return this.replace(regExp, bystr);
}

/***/ }),

/***/ 103:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function (win) {
    var doc = win.document,
        html = doc.documentElement,
        option = html.getAttribute('data-rem');

    if (option === null) {
        return;
    }

    // defaut baseWidth : 640px；
    var baseWidth = parseInt(option).toString() === 'NaN' ? 640 : parseInt(option);
    //默认 1rem == 100px
    var grids = baseWidth / 100; //转换成类似rem
    var clientWidth = html.clientWidth || 320; //clientWidth = width + padding
    // set rem first
    html.style.fontSize = clientWidth / grids + 'px';

    // create testDom
    var testDom = document.createElement('div');
    var testDomWidth = 0;
    var adjustRatio = 0;
    testDom.style.cssText = 'height:0;width:1rem;';
    doc.body.appendChild(testDom);

    var calcTestDom = function calcTestDom() {
        testDomWidth = testDom.offsetWidth;
        if (testDomWidth !== Math.round(clientWidth / grids)) {
            adjustRatio = clientWidth / grids / testDomWidth;
            var reCalcRem = clientWidth * adjustRatio / grids;
            html.style.fontSize = reCalcRem + 'px';
        } else {
            doc.body.removeChild(testDom);
        }
    };

    // detect if rem calc is working directly
    // if not , recalc and set the rem value
    setTimeout(calcTestDom, 20);

    var reCalc = function reCalc() {
        var newCW = html.clientWidth;
        if (newCW === clientWidth) {
            return;
        }
        clientWidth = newCW;
        html.style.fontSize = newCW * (adjustRatio ? adjustRatio : 1) / grids + 'px';
        // if( testDom ) setTimeout(calcTestDom, 20);
    };

    // Abort if browser does not support addEventListener
    if (!doc.addEventListener) {
        return;
    }

    var resizeEvt = 'orientationchange' in win ? 'orientationchange' : 'resize';

    win.addEventListener(resizeEvt, reCalc, false);
    // detect clientWidth is changed ?
    doc.addEventListener('DOMContentLoaded', reCalc, false);
})(window);

/***/ }),

/***/ 104:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _vue = __webpack_require__(4);

var _vue2 = _interopRequireDefault(_vue);

var _vuex = __webpack_require__(221);

var _vuex2 = _interopRequireDefault(_vuex);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

_vue2.default.use(_vuex2.default);

var state = {
    //创建数据仓库
    /*
        数据
    */
    select_coupon: '', //优惠券
    groupScrollY: 0,
    groupData: [],
    couponStatus: '',
    listData: [],
    listInfo: {},
    changeHomeScrollY: 0,
    rollingNode: 0,
    recruitScrollY: 0,
    link_id: '',
    sliding_data_sw: false, //滑动时没数据的开关
    no_data_sw: false, //第一次没数据时的开关
    load_show: true, //加载状态
    roll_switch: true, //滚动加载数据开关
    slide_switch: false, //避免多次请求开关
    sort_page: 1, //分类分页
    search_value: '', //搜索内容
    sort_status: null, //搜索分类状态
    sort_id: null, //搜索分类id
    search_data: [], //搜索数据
    goods_id: '', //选取规格后的商品id
    show_download: false,
    buy_text_status: '',
    no_data: false,
    page_text: '加载中...',
    loading_status: false,
    page: 1, //订单分页
    goods: '', //结算商品信息
    fit: true, //管理收货地址 开关
    price: '', //结算价格
    order_number: '', //订单号
    footprint: '', //我的足迹
    order: '', //我的订单
    home_data: '', //主页
    braDetails: '', //品拍馆详细
    news_data: '', //我的消息
    news_con: '', //我的消息-内容
    my_wallet: '', //我的钱包
    user_Imag: '', //用户头像
    commodity_val: 1, //商品购买选择个数 默认为1
    commodity_number: '', //商品购买选择个数
    commodity_data: '', //商品详情
    commodity_data1: '',
    catr_number: true, //购物车数量
    transformation_num: null, //转换后的购物车数量
    cart_data: '', //购物车
    cart_computer: '', //感兴趣的物品
    dataLeave: '', //猜你喜欢
    nowTime: '', // 倒计时

    /*
        状态
    */
    const_join: false, //商品详情按钮状态
    load_wrap: true, //home页面加载动画开关
    cart_load: true, //购物车load
    class_load: true, //分类load
    order_load_wrap: true, //订单load动画
    invoice: false, //发票信息 默认为不开发票
    type: 0, //发票状态
    rise: 0, //发票状态
    content: 0, //发票状态
    type_data: [],
    res_data: ['个人', '单位'], //发票抬头
    content_data: ['办公用品', '耗材', '电脑配件', '明细'], //发票内容
    invoice_switch: [{ invoice_title: '普通发票', invoice_type: '个人', content: '办公用品' }], //发票信息 设置默认为个人

    /*
        订单
    */
    order_title: '', //订单头部
    order_load: false, //订单ajax切换状态
    order_status: '', //订单状态 空为全部订单，-1：已取消；0 待付款，1，待处理，3待收货，4已完成
    status: '', //头部展示状态
    order_ommodity: '', //评论商品-商品信息储存
    order_details: '', //订单详情
    logis_data: '', //物流信息
    repair: '', //退货返修

    /*
        退款
    */
    setvuce_data: '', //申请退货数据
    /*
        我的评论
    */
    my_comment: '', //我的评论
    chart_review: '' //有图评论
};
var mutations = {
    changeRecruitScrollY: function changeRecruitScrollY(state, recruitScrollY) {
        state.recruitScrollY = recruitScrollY;
    },
    logis: function logis(state, inf) {
        //变更物流信息
        state.logis_data = inf;
    },
    setvuce: function setvuce(state, inf) {
        //变更退货数据
        state.setvuce_data = inf;
    },
    my_comment: function my_comment(state, inf) {
        //我的评论
        state.my_comment = inf;
    },
    chart_review: function chart_review(state, inf) {
        //有图评论
        state.chart_review = inf;
    },
    value: function value(state, inf) {
        //默认商品购买数量
        state.commodity_val = 1;
    },
    shops_switch: function shops_switch(state, inf) {
        //商品详情按钮开关
        state.const_join = false;
    },
    page_text: function page_text(state, inf) {
        //默认加载更多
        state.page_text = '加载中...';
    },
    clear_page: function clear_page(state, inf) {
        //默认加载更多
        state.page = 1;
    },
    clear_data: function clear_data(state, inf) {
        state.commodity_data = '';
    },
    buy_text: function buy_text(state, inf) {
        state.buy_text_status = inf;
    }
};
var store = new _vuex2.default.Store({
    state: state,
    mutations: mutations
});
exports.default = store;

/***/ }),

/***/ 105:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _vue = __webpack_require__(4);

var _vue2 = _interopRequireDefault(_vue);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = new _vue2.default({});

/***/ }),

/***/ 106:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
var publicMethod = {
    //app保存图片
    savePictures: function savePictures() {
        mui.init({
            //初始化
            gestureConfig: {
                tap: true, //默认为true
                doubletap: true, //默认为false
                longtap: true, //默认为false
                swipe: true, //默认为true
                drag: true, //默认为true
                hold: true, //默认为false，不监听
                release: false //默认为false，不监听
            }
        });
        if (typeof plus == 'undefined') {
            return false;
        }
        setTimeout(function () {
            mui('#imgsul').off().on('longtap', '.saveImg', function () {
                //开启弹框
                mui('#picture').popover('toggle');
                var imgurl = this.src;
                mui('.mui-table-view-cell').off().on('tap', '#saveImg', function () {
                    var imgDtask = plus.downloader.createDownload(imgurl, {
                        method: 'GET'
                    }, function (d, status) {
                        if (status == 200) {
                            plus.gallery.save(d.filename, function () {
                                //保存到相册
                                plus.io.resolveLocalFileSystemURL(d.filename, function (enpty) {
                                    // 关闭弹框
                                    mui('#picture').popover('toggle');
                                    mui.toast('保存成功');
                                });
                            });
                        } else {
                            mui.toast('保存失败');
                        }
                    });
                    imgDtask.start();
                });
            });
        }, 100);
    }
};
exports.default = publicMethod;

/***/ }),

/***/ 107:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _vue = __webpack_require__(4);

var _vue2 = _interopRequireDefault(_vue);

var _App = __webpack_require__(56);

var _App2 = _interopRequireDefault(_App);

var _vueRouter = __webpack_require__(219);

var _vueRouter2 = _interopRequireDefault(_vueRouter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var marketHome = function marketHome(r) {
    return __webpack_require__.e/* require */(2).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(236)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //主页
var brandList = function brandList(r) {
    return __webpack_require__.e/* require */(30).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(227)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //品牌列表
var code = function code(r) {
    return __webpack_require__.e/* require */(50).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(294)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //推荐二维码
var braDetails = function braDetails(r) {
    return __webpack_require__.e/* require */(7).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(228)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //品牌详情页
var latestProm = function latestProm(r) {
    return __webpack_require__.e/* require */(0).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(239)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //最新促销
var poopClearance = function poopClearance(r) {
    return __webpack_require__.e/* require */(5).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(301)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //尾货清仓
var list = function list(r) {
    return __webpack_require__.e/* require */(6).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(281)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //商品列表
var IntegralMall = function IntegralMall(r) {
    return __webpack_require__.e/* require */(17).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(226)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //积分商城-列表
var myIntegral = function myIntegral(r) {
    return __webpack_require__.e/* require */(9).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(252)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的积分
var coupon = function coupon(r) {
    return __webpack_require__.e/* require */(46).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(270)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //优惠券
var couponDetail = function couponDetail(r) {
    return __webpack_require__.e/* require */(55).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(271)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //优惠券详情
var footprint = function footprint(r) {
    return __webpack_require__.e/* require */(28).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(273)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的足迹
var myComment = function myComment(r) {
    return __webpack_require__.e/* require */(53).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(285)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的评论
var feedback = function feedback(r) {
    return __webpack_require__.e/* require */(24).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(262)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //意见反馈
var myNews = function myNews(r) {
    return __webpack_require__.e/* require */(26).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(287)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的消息
var newsConent = function newsConent(r) {
    return __webpack_require__.e/* require */(52).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(288)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的消息-内容
var invoice = function invoice(r) {
    return __webpack_require__.e/* require */(33).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(280)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //发票信息
var repair = function repair(r) {
    return __webpack_require__.e/* require */(35).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(296)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //退货返修
var Search = function Search(r) {
    return __webpack_require__.e/* require */(67).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(302)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //首页热搜
var LogoIn = function LogoIn(r) {
    return __webpack_require__.e/* require */(63).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(244)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //登录
var Register = function Register(r) {
    return __webpack_require__.e/* require */(64).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(247)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //注册
var follow = function follow(r) {
    return __webpack_require__.e/* require */(22).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(243)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //关注公众号
var agreement = function agreement(r) {
    return __webpack_require__.e/* require */(74).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(242)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //协议
var Wxbinding = function Wxbinding(r) {
    return __webpack_require__.e/* require */(66).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(240)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //手机号绑定
var addInfo = function addInfo(r) {
    return __webpack_require__.e/* require */(65).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(241)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //手机号绑定后继续完善信息
var bachWord = function bachWord(r) {
    return __webpack_require__.e/* require */(60).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(249)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //找回密码
var logoInBind = function logoInBind(r) {
    return __webpack_require__.e/* require */(75).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(245)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //绑定
var Notice = function Notice(r) {
    return __webpack_require__.e/* require */(78).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(266)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //公告
var product = function product(r) {
    return __webpack_require__.e/* require */(3).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(292)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //商品详情
var groupProduct = function groupProduct(r) {
    return __webpack_require__.e/* require */(4).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(278)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //团购商品详情
var groupDetail = function groupDetail(r) {
    return __webpack_require__.e/* require */(42).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(275)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //团购详情
var groupOrderDetail = function groupOrderDetail(r) {
    return __webpack_require__.e/* require */(23).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(233)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //团购商品订单详情
var groupList = function groupList(r) {
    return __webpack_require__.e/* require */(25).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(276)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //团购商品列表
var groupOrder = function groupOrder(r) {
    return __webpack_require__.e/* require */(44).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(232)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //团购订单
var prTab = function prTab(r) {
    return __webpack_require__.e/* require */(11).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(268)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //商品详情图
var Cart = function Cart(r) {
    return __webpack_require__.e/* require */(41).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(259)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //购物车
var Order = function Order(r) {
    return __webpack_require__.e/* require */(18).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(269)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //确认订单
var groupConfirmOrder = function groupConfirmOrder(r) {
    return __webpack_require__.e/* require */(19).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(274)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //团购确认订单
var cashier = function cashier(r) {
    return __webpack_require__.e/* require */(13).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(260)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //收银台
var groupPayment = function groupPayment(r) {
    return __webpack_require__.e/* require */(12).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(277)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //团购收银台
var subject = function subject(r) {
    return __webpack_require__.e/* require */(61).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(303)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //主页-分类-购物车-个人中心入口
var tomorrow = function tomorrow(r) {
    return __webpack_require__.e/* require */(70).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(237)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //明日预告
var yesterday = function yesterday(r) {
    return __webpack_require__.e/* require */(69).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(238)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //昨日尾单
var have = function have(r) {
    return __webpack_require__.e/* require */(71).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(235)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //好货
var person = function person(r) {
    return __webpack_require__.e/* require */(1).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(234)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //个人中心
var supermarket = function supermarket(r) {
    return __webpack_require__.e/* require */(59).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(306)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //商超界面
var Home = function Home(r) {
    return __webpack_require__.e/* require */(14).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(304)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //商超首页
var marketClass = function marketClass(r) {
    return __webpack_require__.e/* require */(72).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(305)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //商超分类
var seetin = function seetin(r) {
    return __webpack_require__.e/* require */(45).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(298)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //账户设置
var personalData = function personalData(r) {
    return __webpack_require__.e/* require */(38).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(290)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //个人资料
var modifyPassword = function modifyPassword(r) {
    return __webpack_require__.e/* require */(39).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(283)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //修改密码
var wholeOrder = function wholeOrder(r) {
    return __webpack_require__.e/* require */(62).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(225)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //订单入口
var orderWrap = function orderWrap(r) {
    return __webpack_require__.e/* require */(10).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(257)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //订单
var orderDetails = function orderDetails(r) {
    return __webpack_require__.e/* require */(21).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(258)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //订单详情
var intOrder = function intOrder(r) {
    return __webpack_require__.e/* require */(27).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(279)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //积分订单
var serviceBack = function serviceBack(r) {
    return __webpack_require__.e/* require */(37).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(297)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //申请售后
var evaluate = function evaluate(r) {
    return __webpack_require__.e/* require */(29).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(256)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //商品评价
var logis = function logis(r) {
    return __webpack_require__.e/* require */(54).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(282)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //物流查询
var myCollection = function myCollection(r) {
    return __webpack_require__.e/* require */(31).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(284)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的收藏
var address = function address(r) {
    return __webpack_require__.e/* require */(36).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(267)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //收货地址
var payment = function payment(r) {
    return __webpack_require__.e/* require */(79).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(289)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //付款
var EdiAddress = function EdiAddress(r) {
    return __webpack_require__.e/* require */(34).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(261)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //管理收货地址
var newAddress = function newAddress(r) {
    return __webpack_require__.e/* require */(32).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(286)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //新建收货地址
var customer = function customer(r) {
    return __webpack_require__.e/* require */(20).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(272)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //客户服务
var progress = function progress(r) {
    return __webpack_require__.e/* require */(51).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(293)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //进度查询
var reset = function reset(r) {
    return __webpack_require__.e/* require */(73).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(248)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //重置密码
var team = function team(r) {
    return __webpack_require__.e/* require */(56).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(265)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的团队
var withdrawalList = function withdrawalList(r) {
    return __webpack_require__.e/* require */(47).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(300)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //提现列表
var rebateAbnormal = function rebateAbnormal(r) {
    return __webpack_require__.e/* require */(49).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(295)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //返利异常表

var theTeacher = function theTeacher(r) {
    return __webpack_require__.e/* require */(48).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(299)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //名师专栏
var pickWeek = function pickWeek(r) {
    return __webpack_require__.e/* require */(81).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(291)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //名师推荐
var limitedbuy = function limitedbuy(r) {
    return __webpack_require__.e/* require */(16).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(263)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //限时团购
var phone = function phone(r) {
    return __webpack_require__.e/* require */(43).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(264)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //修改手机号绑定
var myWallet = function myWallet(r) {
    return __webpack_require__.e/* require */(57).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(253)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的钱包
var recharge = function recharge(r) {
    return __webpack_require__.e/* require */(15).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(254)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //充值
var withdr = function withdr(r) {
    return __webpack_require__.e/* require */(40).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(250)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //提现
var apply = function apply(r) {
    return __webpack_require__.e/* require */(58).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(251)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //提现申请
var shares = function shares(r) {
    return __webpack_require__.e/* require */(8).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(255)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //我的股币

var getInfo = function getInfo(r) {
    return __webpack_require__.e/* require */(80).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(229)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //接受请求 
var setUserId = function setUserId(r) {
    return __webpack_require__.e/* require */(77).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(230)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //接受请求 
var wxapppay = function wxapppay(r) {
    return __webpack_require__.e/* require */(76).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(231)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; //接受请求 

var phoneVerify = function phoneVerify(r) {
    return __webpack_require__.e/* require */(68).then(function() { var __WEBPACK_AMD_REQUIRE_ARRAY__ = [__webpack_require__(246)]; (r.apply(null, __WEBPACK_AMD_REQUIRE_ARRAY__));}.bind(this)).catch(__webpack_require__.oe);
}; // 修改密码手机验证


_vue2.default.use(_vueRouter2.default);

var router = new _vueRouter2.default({
    // mode: 'history',
    routes: [{
        path: '/',
        component: _App2.default, //顶层路由，对应index.html
        children: [//二级路由。对应App.vue
        //地址为空时跳转home页面
        {
            path: '',
            redirect: '/subject'
        }, {
            path: '/subject',
            name: 'subject',
            component: subject,
            children: [//地址为/subject跳转home
            {
                path: '/subject',
                redirect: '/home'
            }, { //主页
                path: '/home',
                name: 'home',
                component: Home,
                meta: {
                    keepAlive: true,
                    title: 'ShopsN'

                }
            }, { //拼团商品列表
                path: '/groupList',
                name: 'groupList',
                component: groupList
            }, { //购物车
                path: '/Cart',
                name: 'Cart',
                component: Cart,
                meta: {
                    title: '购物车'
                }
            }, { //个人中心
                path: '/person',
                name: 'person',
                component: person,
                meta: {
                    title: '个人中心'
                }
            }, { //主页
                path: '/marketHome',
                name: 'marketHome',
                component: marketHome,
                meta: {
                    title: '聚清超市',
                    keepAlive: true
                }
            }]
        },
        // { //超市
        //     path: '/supermarket',
        //     name: 'supermarket',
        //     component: supermarket,
        //     children: [{
        //             path: '/supermarket',
        //             redirect: '/marketHome'
        //         },
        //         { //主页
        //             path: '/marketHome',
        //             name: 'marketHome',
        //             component: marketHome,
        //             meta: {
        //                 title: '聚清超市',
        //                 keepAlive: true
        //             },
        //         },
        //         { //分类
        //             path: '/marketClass',
        //             name: 'marketClass',
        //             component: marketClass,
        //             meta: {
        //                 title: '超市分类'
        //             },
        //
        //         },
        //     ]
        // },
        { //登录
            path: '/LogoIn',
            name: 'LogoIn',
            component: LogoIn
        }, { //好货
            path: '/have',
            name: 'have',
            component: have,
            meta: {
                title: '我有好货'
            }
        }, { //我的团队
            path: '/team',
            name: 'team',
            component: team
        }, { //推荐二维码
            path: '/code',
            name: 'code',
            component: code
        }, { //手机号绑定
            path: '/Wxbinding',
            name: 'Wxbinding',
            component: Wxbinding
        }, { //手机号绑定
            path: '/addInfo',
            name: 'addInfo',
            component: addInfo
        }, { //注册
            path: '/Register',
            name: 'register',
            component: Register
        }, { //关注公众号
            path: '/follow',
            name: 'follow',
            component: follow
        }, { //协议
            path: '/agreement',
            name: 'agreement',
            component: agreement
        }, { //找回密码
            path: '/bachWord',
            name: 'bachWord',
            component: bachWord
        }, { //登录绑定
            path: '/logoInBind',
            name: 'logoInBind',
            component: logoInBind
        }, { //公告
            path: '/Notice',
            name: 'Notice',
            component: Notice
        }, { //品牌馆列表
            path: '/brandList',
            name: 'brandList',
            component: brandList
        }, { //品牌馆详情
            path: '/braDetails/:ID',
            name: 'braDetails',
            component: braDetails
        }, { //最新促销
            path: '/latestProm',
            name: 'latestProm',
            component: latestProm
        }, { //尾货清仓
            path: '/poopClearance',
            name: 'poopClearance',
            component: poopClearance
        }, { //热搜商品列表
            path: '/list/:id/:status',
            name: 'list',
            component: list
            // meta: {
            //     keepAlive: true
            // },
        }, { //商品列表
            path: '/comList/:status',
            name: 'comList',
            component: list
        }, { //积分商城-列表
            path: '/IntegralMall',
            name: 'IntegralMall',
            component: IntegralMall
        }, { //优惠券
            path: '/coupon',
            name: 'coupon',
            component: coupon
        }, { //优惠券
            path: '/couponDetail',
            name: 'couponDetail',
            component: couponDetail
        }, { //我的足迹
            path: '/footprint',
            name: 'footprint',
            component: footprint
        }, { //我的评论
            path: '/myComment',
            name: 'myComment',
            component: myComment
        }, { //意见反馈
            path: '/feedback',
            name: 'feedback',
            component: feedback
        }, { //商品详情Tbg
            path: '/tab/:id',
            name: 'tab',
            component: prTab
        }, { //我的消息
            path: '/myNews',
            name: 'myNews',
            component: myNews
        }, { //我的消息-内容
            path: '/newsConent/:id/:status',
            name: 'newsConent',
            component: newsConent
        }, { //搜索页
            path: '/search',
            name: 'search',
            component: Search
        }, { //商品详情
            path: '/product/:id/:status',
            name: 'product',
            component: product
        }, { //拼团商品详情
            path: '/groupProduct',
            name: 'groupProduct',
            component: groupProduct
        }, { //拼团商品详情
            path: '/groupOrder',
            name: 'groupOrder',
            component: groupOrder
        }, { //拼团商品订单详情
            path: '/groupOrderDetail',
            name: 'groupOrderDetail',
            component: groupOrderDetail
        }, { //拼团商品详情
            path: '/groupDetail',
            name: 'groupDetail',
            component: groupDetail
        }, { //积分订单
            path: '/intOrder',
            name: 'intOrder',
            component: intOrder
        }, { //确认订单
            path: '/order/:id',
            name: 'order',
            component: Order
        }, { //确认订单
            path: '/groupConfirmOrder',
            name: 'groupConfirmOrder',
            component: groupConfirmOrder
        },
        // 付款
        {
            path: '/payment',
            name: 'payment',
            component: payment
        }, { //支付
            path: '/cashier/:id/:type',
            name: 'cashier',
            component: cashier
        }, { //团购支付
            path: '/groupPayment',
            name: 'groupPayment',
            component: groupPayment
        }, { //账户管理
            path: '/seetin',
            name: 'seetin',
            component: seetin
        }, { //积分
            path: '/myIntegral',
            name: 'myIntegral',
            component: myIntegral
        }, { //我的收藏
            path: '/Collection',
            name: 'myCollection',
            component: myCollection
        }, { //收货地址
            path: '/address/:status',
            name: 'address',
            component: address
        }, { //编辑收货地址
            path: '/EdiAddress/:status',
            name: 'EdiAddress',
            component: EdiAddress
        }, { //新增收货地址
            path: '/newAddress/:status',
            name: 'newAddress',
            component: newAddress
        }, { //客服服务
            path: '/customer',
            name: 'customer',
            component: customer
        }, { //修改密码
            path: '/mPassword',
            name: 'mPassword',
            component: modifyPassword
        }, { //发票信息
            path: '/invoice',
            name: 'invoice',
            component: invoice
        }, { //订单
            path: '/orderWrap/:status',
            name: 'orderWrap',
            component: orderWrap
        }, { //物流查询
            path: '/logis/:id',
            name: 'logis',
            component: logis
        }, { //订单详情
            path: '/details/:status/:order/:order_type',
            name: 'orderDetails',
            component: orderDetails
        }, { //退货返修
            path: '/repair',
            name: 'repair',
            component: repair
        }, { //进度查询
            path: '/progress/:id',
            name: 'progress',
            component: progress
        }, { //重置密码
            path: '/reset/:user_id',
            name: 'reset',
            component: reset
        }, { //名师专栏
            path: '/theTeacher',
            name: 'theTeacher',
            component: theTeacher
        }, { //名师推荐商品
            path: '/pickWeek',
            name: 'pickWeek',
            component: pickWeek
        }, { //限时团购
            path: '/limitedbuy',
            name: 'limitedbuy',
            component: limitedbuy
        }, { //个人资料
            path: '/personal',
            name: 'personalData',
            component: personalData
        }, { //修改手机号绑定
            path: '/phone',
            name: 'phone',
            component: phone
        }, { //申请售后
            path: '/service/:status/:index',
            name: 'serviceBack',
            component: serviceBack
        }, { //评价商品
            path: '/evaluate/:id',
            name: 'evaluate',
            component: evaluate
        }, { //我的钱包
            path: '/myWallet',
            name: 'myWallet',
            component: myWallet
        }, { //提现列表
            path: '/withdrawalList',
            name: 'withdrawalList',
            component: withdrawalList
        }, { //返利异常列表
            path: '/rebateAbnormal',
            name: 'rebateAbnormal',
            component: rebateAbnormal
        }, { //充值
            path: '/recharge',
            name: 'recharge',
            component: recharge
        }, { //提现
            path: '/withdr',
            name: 'withdr',
            component: withdr
        }, { //提现申请
            path: '/apply/:status',
            name: 'apply',
            component: apply
        }, { //我的股票
            path: '/shares',
            name: 'shares',
            component: shares
        }, { //接受微信请求  ------青菜新增
            path: '/getInfo',
            name: 'getInfo',
            component: getInfo
        }, { //公众号登录设置  ------三千新增
            path: '/setUserId',
            name: 'setUserId',
            component: setUserId
        }, { //接受微信app请求  ------三千新增
            path: '/wxapppay/:userId',
            name: 'wxapppay',
            component: wxapppay
        }, { //修改密码手机验证
            path: '/phoneVerify',
            name: 'phoneVerify',
            component: phoneVerify
        }]
    }]
});
exports.default = router;

/***/ }),

/***/ 109:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 110:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 111:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 113:
/***/ (function(module, exports) {

/*!
 * mescroll -- 精致的下拉刷新和上拉加载js框架  ( a great JS framework for pull-refresh and pull-up-loading )
 * version 1.3.2
 * 2018-01-01
 * 
 * 您如果在vue,angular等环境中,因作用域的问题未能正常引入或初始化Mescroll对象,则可引用mescroll.m.js;
 * mescroll.m.js去掉了mescroll.min.js套的一层模块规范的代码
 * 因为没有闭包限制作用域,所以能解决某些情况下引用mescroll.min.js报'Mescroll' undefined的问题
 * 具体请参考: https://github.com/mescroll/mescroll/issues/56
 */
function MeScroll(a,d){var f=this;f.version="1.3.2";f.isScrollBody=(!a||a=="body");f.scrollDom=f.isScrollBody?document.body:f.getDomById(a);if(!f.scrollDom){return}f.options=d||{};var c=navigator.userAgent;var b=!!c.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);var g=typeof window.orientation=="undefined";var e=c.indexOf("Android")>-1||c.indexOf("Adr")>-1;f.os={ios:b,pc:g,android:e};f.isDownScrolling=false;f.isUpScrolling=false;f.initDownScroll();f.initUpScroll();setTimeout(function(){if(f.optDown.use&&f.optDown.auto){if(f.optDown.autoShowLoading){f.triggerDownScroll()}else{f.optDown.callback&&f.optDown.callback(f)}}f.optUp.use&&f.optUp.auto&&!f.isUpAutoLoad&&f.triggerUpScroll()},30)}MeScroll.prototype.extendDownScroll=function(a){MeScroll.extend(a,{use:true,auto:true,autoShowLoading:false,isLock:false,isBoth:false,offset:80,outOffsetRate:0.2,bottomOffset:20,minAngle:45,hardwareClass:"mescroll-hardware",warpId:null,warpClass:"mescroll-downwarp",resetClass:"mescroll-downwarp-reset",htmlContent:'<p class="downwarp-progress"></p><p class="downwarp-tip">下拉刷新 </p>',inited:function(c,b){c.downTipDom=b.getElementsByClassName("downwarp-tip")[0];c.downProgressDom=b.getElementsByClassName("downwarp-progress")[0]},inOffset:function(b){if(b.downTipDom){b.downTipDom.innerHTML="下拉刷新"}if(b.downProgressDom){b.downProgressDom.classList.remove("mescroll-rotate")}},outOffset:function(b){if(b.downTipDom){b.downTipDom.innerHTML="释放更新"}},onMoving:function(c,e,b){if(c.downProgressDom){var d=360*e;c.downProgressDom.style.webkitTransform="rotate("+d+"deg)";c.downProgressDom.style.transform="rotate("+d+"deg)"}},beforeLoading:function(c,b){return false},showLoading:function(b){if(b.downTipDom){b.downTipDom.innerHTML="加载中 ..."}if(b.downProgressDom){b.downProgressDom.classList.add("mescroll-rotate")}},callback:function(b){b.resetUpScroll()}})};MeScroll.prototype.extendUpScroll=function(a){var b=this.os.pc;MeScroll.extend(a,{use:true,auto:true,isLock:false,isBoth:false,isBounce:true,callback:null,page:{num:0,size:10,time:null},noMoreSize:5,offset:100,toTop:{warpId:null,src:null,html:null,offset:1000,warpClass:"mescroll-totop",showClass:"mescroll-fade-in",hideClass:"mescroll-fade-out",duration:300,supportTap:false},loadFull:{use:false,delay:500},empty:{warpId:null,icon:null,tip:"暂无相关数据~",btntext:"",btnClick:null,supportTap:false},clearId:null,clearEmptyId:null,hardwareClass:"mescroll-hardware",warpId:null,warpClass:"mescroll-upwarp",htmlLoading:'<p class="upwarp-progress mescroll-rotate"></p><p class="upwarp-tip">加载中..</p>',htmlNodata:'<p class="upwarp-nodata">-- END --</p>',inited:function(c,d){},showLoading:function(c,d){d.innerHTML=c.optUp.htmlLoading},showNoMore:function(c,d){d.innerHTML=c.optUp.htmlNodata},onScroll:null,scrollbar:{use:b,barClass:"mescroll-bar"}})};MeScroll.extend=function(b,a){if(!b){return a}for(var key in a){if(b[key]==null){b[key]=a[key]}else{if(typeof b[key]=="object"){MeScroll.extend(b[key],a[key])}}}return b};MeScroll.prototype.initDownScroll=function(){var b=this;b.optDown=b.options.down||{};b.extendDownScroll(b.optDown);b.touchstartEvent=function(c){if(b.isScrollTo){c.preventDefault()}b.startPoint=b.getPoint(c);b.lastPoint=b.startPoint;b.maxTouchmoveY=b.getBodyHeight()-b.optDown.bottomOffset;b.inTouchend=false;if(b.os.pc&&b.getScrollTop()<=0){b.scrollDom.addEventListener("mousemove",b.touchmoveEvent);document.ondragstart=function(){return false}}};b.scrollDom.addEventListener("mousedown",b.touchstartEvent);b.scrollDom.addEventListener("touchstart",b.touchstartEvent);b.touchmoveEvent=function(k){var c=b.getScrollTop();var g=b.getPoint(k);var d=g.y-b.startPoint.y;if(d>0){if(c<=0){if(k.cancelable&&!k.defaultPrevented){k.preventDefault()}if(b.optDown.use&&!b.inTouchend&&!b.isDownScrolling&&!b.optDown.isLock&&(!b.isUpScrolling||(b.isUpScrolling&&b.optUp.isBoth))){var n=Math.abs(b.lastPoint.x-g.x);var m=Math.abs(b.lastPoint.y-g.y);var l=Math.sqrt(n*n+m*m);if(l!=0){var f=Math.asin(m/l)/Math.PI*180;if(f<b.optDown.minAngle){return}}if(b.maxTouchmoveY>0&&g.y>=b.maxTouchmoveY){b.inTouchend=true;b.touchendEvent();return}var o=g.y-b.lastPoint.y;if(!b.downHight){b.downHight=0}if(b.downHight<b.optDown.offset){if(b.movetype!=1){b.movetype=1;b.optDown.inOffset(b);b.downwarp.classList.remove(b.optDown.resetClass);b.scrollDom.classList.add(b.optDown.hardwareClass);b.scrollDom.style.webkitOverflowScrolling="auto";b.isMoveDown=true}b.downHight+=o}else{if(b.movetype!=2){b.movetype=2;b.optDown.outOffset(b);b.downwarp.classList.remove(b.optDown.resetClass);b.scrollDom.classList.add(b.optDown.hardwareClass);b.scrollDom.style.webkitOverflowScrolling="auto";b.isMoveDown=true}if(o>0){b.downHight+=o*b.optDown.outOffsetRate}else{b.downHight+=o}}b.downwarp.style.height=b.downHight+"px";var j=b.downHight/b.optDown.offset;b.optDown.onMoving(b,j,b.downHight)}}}else{if(d<0){var p=b.getScrollHeight();var i=b.getClientHeight();var h=p-i-c;if(!b.optUp.isBounce&&k.cancelable&&!k.defaultPrevented&&h<=0){k.preventDefault()}if(b.optUp.use&&!b.optUp.isLock&&b.optUp.hasNext&&!b.isUpScrolling&&(!b.isDownScrolling||(b.isDownScrolling&&b.optDown.isBoth))&&(i+b.optUp.offset>=p||h<=0)){b.triggerUpScroll()}}}b.lastPoint=g};b.scrollDom.addEventListener("touchmove",b.touchmoveEvent);b.touchendEvent=function(){if(b.optDown.use&&b.isMoveDown){if(b.downHight>=b.optDown.offset){b.triggerDownScroll()}else{b.downwarp.classList.add(b.optDown.resetClass);b.downHight=0;b.downwarp.style.height=0}b.scrollDom.style.webkitOverflowScrolling="touch";b.scrollDom.classList.remove(b.optDown.hardwareClass);b.movetype=0;b.isMoveDown=false}if(b.os.pc){b.scrollDom.removeEventListener("mousemove",b.touchmoveEvent);document.ondragstart=function(){return true}}};b.scrollDom.addEventListener("mouseup",b.touchendEvent);b.scrollDom.addEventListener("mouseleave",b.touchendEvent);b.scrollDom.addEventListener("touchend",b.touchendEvent);b.scrollDom.addEventListener("touchcancel",b.touchendEvent);if(b.optDown.use){b.downwarp=document.createElement("div");b.downwarp.className=b.optDown.warpClass;b.downwarp.innerHTML='<div class="downwarp-content">'+b.optDown.htmlContent+"</div>";var a=b.optDown.warpId?b.getDomById(b.optDown.warpId):b.scrollDom;if(b.optDown.warpId&&a){a.appendChild(b.downwarp)}else{if(!a){a=b.scrollDom}a.insertBefore(b.downwarp,b.scrollDom.firstChild)}setTimeout(function(){b.optDown.inited(b,b.downwarp)},0)}};MeScroll.prototype.getPoint=function(a){return{x:a.touches?a.touches[0].pageX:a.clientX,y:a.touches?a.touches[0].pageY:a.clientY}};MeScroll.prototype.triggerDownScroll=function(){if(!this.optDown.beforeLoading(this,this.downwarp)){this.showDownScroll();this.optDown.callback&&this.optDown.callback(this)}};MeScroll.prototype.showDownScroll=function(){this.isDownScrolling=true;this.optDown.showLoading(this);this.downHight=this.optDown.offset;this.downwarp.classList.add(this.optDown.resetClass);this.downwarp.style.height=this.optDown.offset+"px"};MeScroll.prototype.endDownScroll=function(){this.downHight=0;this.downwarp.style.height=0;this.isDownScrolling=false;if(this.downProgressDom){this.downProgressDom.classList.remove("mescroll-rotate")}};MeScroll.prototype.lockDownScroll=function(a){if(a==null){a=true}this.optDown.isLock=a};MeScroll.prototype.initUpScroll=function(){var b=this;b.optUp=b.options.up||{use:false};b.extendUpScroll(b.optUp);if(b.optUp.scrollbar.use){b.scrollDom.classList.add(b.optUp.scrollbar.barClass)}if(!b.optUp.isBounce){b.setBounce(false)}if(b.optUp.use==false){return}b.optUp.hasNext=true;b.upwarp=document.createElement("div");b.upwarp.className=b.optUp.warpClass;var a;if(b.optUp.warpId){a=b.getDomById(b.optUp.warpId)}if(!a){a=b.scrollDom}a.appendChild(b.upwarp);b.preScrollY=0;b.scrollEvent=function(){var e=b.getScrollTop();var d=e-b.preScrollY>0;b.preScrollY=e;if(!b.isUpScrolling&&(!b.isDownScrolling||(b.isDownScrolling&&b.optDown.isBoth))){if(!b.optUp.isLock&&b.optUp.hasNext){var c=b.getScrollHeight()-b.getClientHeight()-e;if(c<=b.optUp.offset&&d){b.triggerUpScroll()}}var f=b.optUp.toTop;if(f.src||f.html){if(e>=f.offset){b.showTopBtn()}else{b.hideTopBtn()}}}b.optUp.onScroll&&b.optUp.onScroll(b,e,d)};if(b.isScrollBody){window.addEventListener("scroll",b.scrollEvent)}else{b.scrollDom.addEventListener("scroll",b.scrollEvent)}setTimeout(function(){b.optUp.inited(b,b.upwarp)},0)};MeScroll.prototype.setBounce=function(a){if(this.isScrollBody||!this.os.ios){return}if(a==false){this.optUp.isBounce=false;window.addEventListener("touchmove",this.bounceTouchmove)}else{this.optUp.isBounce=true;window.removeEventListener("touchmove",this.bounceTouchmove)}};MeScroll.prototype.bounceTouchmove=function(g){var i=this;var c=g.target;var d=true;while(c!==document.body&&c!==document){var l=c.classList;if(l){if(l.contains("mescroll")||l.contains("mescroll-touch")){d=false;break}else{if(l.contains("mescroll-touch-x")||l.contains("mescroll-touch-y")){var b=g.touches?g.touches[0].pageX:g.clientX;var a=g.touches?g.touches[0].pageY:g.clientY;if(!i.preWinX){i.preWinX=b}if(!i.preWinY){i.preWinY=a}var k=Math.abs(i.preWinX-b);var j=Math.abs(i.preWinY-a);var h=Math.sqrt(k*k+j*j);i.preWinX=b;i.preWinY=a;if(h!=0){var f=Math.asin(j/h)/Math.PI*180;if((f<=45&&l.contains("mescroll-touch-x"))||(f>45&&l.contains("mescroll-touch-y"))){d=false;break}}}}}c=c.parentNode}if(d&&g.cancelable&&!g.defaultPrevented){g.preventDefault()}};MeScroll.prototype.triggerUpScroll=function(){if(!this.isUpScrolling){this.showUpScroll();this.optUp.page.num++;this.isUpAutoLoad=true;this.optUp.callback&&this.optUp.callback(this.optUp.page,this)}};MeScroll.prototype.showUpScroll=function(){this.isUpScrolling=true;this.upwarp.classList.add(this.optUp.hardwareClass);this.upwarp.style.visibility="visible";this.optUp.showLoading(this,this.upwarp)};MeScroll.prototype.showNoMore=function(){this.upwarp.style.visibility="visible";this.optUp.hasNext=false;this.optUp.showNoMore(this,this.upwarp)};MeScroll.prototype.hideUpScroll=function(){this.upwarp.style.visibility="hidden";this.upwarp.classList.remove(this.optUp.hardwareClass);var a=this.upwarp.getElementsByClassName("upwarp-progress")[0];if(a){a.classList.remove("mescroll-rotate")}};MeScroll.prototype.endUpScroll=function(a){if(a!=null){if(a){this.showNoMore()}else{this.hideUpScroll()}}this.isUpScrolling=false};MeScroll.prototype.resetUpScroll=function(b){if(this.optUp&&this.optUp.use){var a=this.optUp.page;this.prePageNum=a.num;this.prePageTime=a.time;a.num=1;a.time=null;if(!this.isDownScrolling&&b!=false){if(b==null){this.removeEmpty();this.clearDataList();this.showUpScroll()}else{this.showDownScroll()}}this.isUpAutoLoad=true;this.optUp.callback&&this.optUp.callback(a,this)}};MeScroll.prototype.setPageNum=function(a){this.optUp.page.num=a-1};MeScroll.prototype.setPageSize=function(a){this.optUp.page.size=a};MeScroll.prototype.clearDataList=function(){var b=this.optUp.clearId||this.optUp.clearEmptyId;if(b){var a=this.getDomById(b);if(a){a.innerHTML=""}}};MeScroll.prototype.endByPage=function(b,d,c){var a;if(this.optUp.use&&d!=null){a=this.optUp.page.num<d}this.endSuccess(b,a,c)};MeScroll.prototype.endBySize=function(c,b,d){var a;if(this.optUp.use&&b!=null){var e=(this.optUp.page.num-1)*this.optUp.page.size+c;a=e<b}this.endSuccess(c,a,d)};MeScroll.prototype.endSuccess=function(c,a,e){if(this.isDownScrolling){this.endDownScroll()}if(this.optUp.use){var d;if(c!=null){var f=this.optUp.page.num;var b=this.optUp.page.size;if(f==1){this.clearDataList();if(e){this.optUp.page.time=e}}if(c<b||a==false){this.optUp.hasNext=false;if(c==0&&f==1){d=false;this.showEmpty()}else{var g=(f-1)*b+c;if(g<this.optUp.noMoreSize){d=false}else{d=true}this.removeEmpty()}}else{d=false;this.optUp.hasNext=true;this.removeEmpty()}}this.endUpScroll(d);this.loadFull()}};MeScroll.prototype.endErr=function(){if(this.isDownScrolling){var a=this.optUp.page;if(a&&this.prePageNum){a.num=this.prePageNum;a.time=this.prePageTime}this.endDownScroll()}if(this.isUpScrolling){this.optUp.page.num--;this.endUpScroll(false)}};MeScroll.prototype.loadFull=function(){var a=this;if(a.optUp.loadFull.use&&!a.optUp.isLock&&a.optUp.hasNext&&a.getScrollHeight()<=a.getClientHeight()){setTimeout(function(){if(a.getScrollHeight()<=a.getClientHeight()){a.triggerUpScroll()}},a.optUp.loadFull.delay)}};MeScroll.prototype.lockUpScroll=function(a){if(a==null){a=true}this.optUp.isLock=a};MeScroll.prototype.showEmpty=function(){var b=this;var c=b.optUp.empty;var a=c.warpId||b.optUp.clearEmptyId;if(a==null){return}var f=b.getDomById(a);if(f){b.removeEmpty();var e="";if(c.icon){e+='<img class="empty-icon" src="'+c.icon+'"/>'}if(c.tip){e+='<p class="empty-tip">'+c.tip+"</p>"}if(c.btntext){e+='<p class="empty-btn">'+c.btntext+"</p>"}b.emptyDom=document.createElement("div");b.emptyDom.className="mescroll-empty";b.emptyDom.innerHTML=e;f.appendChild(b.emptyDom);if(c.btnClick){var d=b.emptyDom.getElementsByClassName("empty-btn")[0];if(c.supportTap){d.addEventListener("tap",function(g){g.stopPropagation();g.preventDefault();c.btnClick()})}else{d.onclick=function(){c.btnClick()}}}}};MeScroll.prototype.removeEmpty=function(){this.removeChild(this.emptyDom)};MeScroll.prototype.showTopBtn=function(){if(!this.topBtnShow){this.topBtnShow=true;var b=this;var c=b.optUp.toTop;if(b.toTopBtn==null){if(c.html){b.toTopBtn=document.createElement("div");b.toTopBtn.innerHTML=c.html}else{b.toTopBtn=document.createElement("img");b.toTopBtn.src=c.src}b.toTopBtn.className=c.warpClass;if(c.supportTap){b.toTopBtn.addEventListener("tap",function(d){d.stopPropagation();d.preventDefault();b.scrollTo(0,b.optUp.toTop.duration)})}else{b.toTopBtn.onclick=function(){b.scrollTo(0,b.optUp.toTop.duration)}}var a;if(c.warpId){a=b.getDomById(c.warpId)}if(!a){a=document.body}a.appendChild(b.toTopBtn)}b.toTopBtn.classList.remove(c.hideClass);b.toTopBtn.classList.add(c.showClass)}};MeScroll.prototype.hideTopBtn=function(){if(this.topBtnShow&&this.toTopBtn){this.topBtnShow=false;this.toTopBtn.classList.remove(this.optUp.toTop.showClass);this.toTopBtn.classList.add(this.optUp.toTop.hideClass)}};MeScroll.prototype.scrollTo=function(f,b){var c=this;var e=c.getScrollTop();var a=f;if(a>0){var d=c.getScrollHeight()-c.getClientHeight();if(a>d){a=d}}else{a=0}c.isScrollTo=true;c.getStep(e,a,function(g){c.setScrollTop(g);if(g==a){c.isScrollTo=false}},b)};MeScroll.prototype.getStep=function(e,c,j,k,g){var h=c-e;if(k==0||h==0){j&&j(c);return}k=k||300;g=g||30;var f=k/g;var b=h/f;var d=0;var a=window.setInterval(function(){if(d<f-1){e+=b;j&&j(e,a);d++}else{j&&j(c,a);window.clearInterval(a)}},g)};MeScroll.prototype.getScrollHeight=function(){return this.scrollDom.scrollHeight};MeScroll.prototype.getClientHeight=function(){if(this.isScrollBody&&document.compatMode=="CSS1Compat"){return document.documentElement.clientHeight}else{return this.scrollDom.clientHeight}};MeScroll.prototype.getBodyHeight=function(){return document.body.clientHeight||document.documentElement.clientHeight};MeScroll.prototype.getScrollTop=function(){if(this.isScrollBody){return document.documentElement.scrollTop||document.body.scrollTop}else{return this.scrollDom.scrollTop}};MeScroll.prototype.getToBottom=function(){return this.getScrollHeight()-this.getClientHeight()-this.getScrollTop()};MeScroll.prototype.setScrollTop=function(a){if(this.isScrollBody){document.documentElement.scrollTop=a;document.body.scrollTop=a}else{this.scrollDom.scrollTop=a}};MeScroll.prototype.getDomById=function(b){var a;if(b){a=document.getElementById(b)}if(!a){console.error('the element with id as "'+b+'" can not be found: document.getElementById("'+b+'")==null')}return a};MeScroll.prototype.removeChild=function(b){if(b){var a=b.parentNode;a&&a.removeChild(b);b=null}};MeScroll.prototype.destroy=function(){var a=this;a.scrollDom.removeEventListener("touchstart",a.touchstartEvent);a.scrollDom.removeEventListener("touchmove",a.touchmoveEvent);a.scrollDom.removeEventListener("touchend",a.touchendEvent);a.scrollDom.removeEventListener("touchcancel",a.touchendEvent);a.scrollDom.removeEventListener("mousedown",a.touchstartEvent);a.scrollDom.removeEventListener("mousemove",a.touchmoveEvent);a.scrollDom.removeEventListener("mouseup",a.touchendEvent);a.scrollDom.removeEventListener("mouseleave",a.touchendEvent);a.removeChild(a.downwarp);if(a.isScrollBody){window.removeEventListener("scroll",a.scrollEvent)}else{a.scrollDom.removeEventListener("scroll",a.scrollEvent)}a.removeChild(a.upwarp);a.removeChild(a.toTopBtn);a.setBounce(true)};window.MeScroll = MeScroll;


/***/ }),

/***/ 155:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

exports.default = {
  name: 'app',
  data: function data() {
    return {};
  },

  computed: {
    cachedRouteNames: function cachedRouteNames() {
      return this.$store.state.cachedRouteNames;
    }
  }
};

/***/ }),

/***/ 156:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _vue = __webpack_require__(4);

var _vue2 = _interopRequireDefault(_vue);

var _axios = __webpack_require__(102);

var _axios2 = _interopRequireDefault(_axios);

var _App = __webpack_require__(56);

var _App2 = _interopRequireDefault(_App);

var _router = __webpack_require__(107);

var _router2 = _interopRequireDefault(_router);

var _index = __webpack_require__(104);

var _index2 = _interopRequireDefault(_index);

var _vueClipboard = __webpack_require__(112);

var _vueClipboard2 = _interopRequireDefault(_vueClipboard);

var _public = __webpack_require__(106);

var _public2 = _interopRequireDefault(_public);

var _jquery = __webpack_require__(32);

var _jquery2 = _interopRequireDefault(_jquery);

__webpack_require__(103);

__webpack_require__(111);

__webpack_require__(110);

var _eventbus = __webpack_require__(105);

var _eventbus2 = _interopRequireDefault(_eventbus);

var _mintUi = __webpack_require__(57);

var _mintUi2 = _interopRequireDefault(_mintUi);

var _vueLazyload = __webpack_require__(55);

var _vueLazyload2 = _interopRequireDefault(_vueLazyload);

var _elementUi = __webpack_require__(108);

var _elementUi2 = _interopRequireDefault(_elementUi);

__webpack_require__(109);

__webpack_require__(113);

__webpack_require__(101);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

// import '../static/css/mui.css';
_vue2.default.use(_elementUi2.default); // The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.

_vue2.default.use(_vueLazyload2.default, {
  preLoad: 1.3,
  error: "./static/ggt@2x.png",
  loading: "./static/ggt@2x.png"
});
//添加过滤器
_vue2.default.filter("keepTwoNum", function (value) {
  value = Number(value);
  var b = value.toFixed(3);
  return b.substring(0, b.toString().length - 1);
});
_vue2.default.filter("formatDate", function (value) {
  var time = new Date(Number(value) * 1000);
  var Y = time.getFullYear();
  var m = time.getMonth() + 1;
  var d = time.getDate();
  var H = time.getHours();
  var mi = time.getMinutes();
  var s = time.getSeconds();
  if (m < 10) {
    m = "0" + m;
  }
  if (d < 10) {
    d = "0" + d;
  }
  if (H < 10) {
    H = "0" + H;
  }
  if (mi < 10) {
    mi = "0" + mi;
  }
  if (s < 10) {
    s = "0" + s;
  }
  return Y + "." + m + "." + d;
});
// import { Spinner } from 'mint-ui'
//常量
var user_id = sessionStorage.getItem("user_ID") || "",

//URl = 'http://www.shopsn_busi.com',
URl = "http://biz.shopsn.cn",
    client_type = 1,
    //1浏览器，2 app
andr_version = "2.2.1",
    //安卓APP版本0801
ios_version = "1.0.0",
    //ios APP版本
load_wrap = true,
    down = true; //true时默认打开下拉刷新

_vue2.default.config.productionTip = false;
_vue2.default.prototype.publicMethod = _public2.default;
_vue2.default.prototype.axios = _axios2.default;
_vue2.default.prototype.URL = URl;
_vue2.default.prototype.load_wrap = load_wrap;
_vue2.default.prototype.user_id = user_id;
_vue2.default.prototype.client_type = client_type;
_vue2.default.prototype.ios_version = ios_version;
_vue2.default.prototype.andr_version = andr_version;
_vue2.default.prototype.down = down;
_vue2.default.prototype.$bus = _eventbus2.default;

_vue2.default.use(_mintUi2.default);
_vue2.default.use(_vueClipboard2.default);

_vue2.default.directive("title", {
  inserted: function inserted(el, binding) {
    document.title = el.innerText;
    el.remove();
  }
});

_router2.default.beforeEach(function (to, from, next) {
  // Indicator.open('加载中...');
  /* 路由发生变化修改页面title */
  if (to.meta.title) {
    document.title = to.meta.title;
  }
  switch (to.path) {
    case "/home":
      sessionStorage.setItem("router_index", 0);
      break;
    case "/marketHome":
      sessionStorage.setItem("router_index", 1);
      break;
    case "/groupList":
      sessionStorage.setItem("router_index", 2);
      break;
    case "/cart":
      sessionStorage.setItem("router_index", 3);
      break;
    case "/person":
      sessionStorage.setItem("router_index", 4);
      break;
  }
  next();
});
_router2.default.afterEach(function (router) {
  setTimeout(function () {
    _mintUi.Indicator.close();
  }, 100);
});

new _vue2.default({
  el: "#app",
  router: _router2.default,
  store: _index2.default,
  template: "<App/>",
  components: { App: _App2.default }
});

/***/ }),

/***/ 218:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('router-view')], 1)
},staticRenderFns: []}

/***/ }),

/***/ 56:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(114)(
  /* script */
  __webpack_require__(155),
  /* template */
  __webpack_require__(218),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ })

},[156]);
//# sourceMappingURL=app.2694305070e631026252.js.map