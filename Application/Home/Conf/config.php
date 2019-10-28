<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.yisu.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 亿速网络（http://www.yisu.cn）
// +----------------------------------------------------------------------
// | Author: 王强 <opjklu@126.com>
// +----------------------------------------------------------------------

defined('Server') or define('Server', '');
define('__STATIC_MOUDLE__', 'Home');
return array(
	//'配置项'=>'配置值'
    'LOAD_EXT_CONFIG'    => COMMON_PATH.'Conf/tmpl.php', // 加载配置文件
	//表单令牌
	'form' => 'abc15689iuoiuhkjvg',
     ////江浙沪皖包邮
    'free' => array('江苏省','浙江省','上海市','安徽省'),
    /* 头像图片上传相关配置 */
    'USER_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/user/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）
    'USER_HEADER'       => '/Uploads/user/',
    'SHOW_PAGE_TRACE'   => false,
    'URL_HTML_SUFFIX'   =>'.html',
    'promotion_type'    => [ //0 打折，1,减价优惠,2,固定金额出售
        -1 => 'Home\Strategy\SpecificStrategy\BuySendVouchersActivity',
        'Home\Strategy\SpecificStrategy\DiscountPromotionsActivity',
        'Home\Strategy\SpecificStrategy\DiscountActivity',
        'Home\Strategy\SpecificStrategy\FixedAmountSaleActivity',
        1000000 => 'Home\Strategy\SpecificStrategy\NoActivePrice'
     ],
    
    'cart_type' => [
        1 => 'Home\CartType\Type\OrdinaryCartBuy',
        2 => 'Home\CartType\Type\PackageCartBuy'
    ],
    
    'activity_type_class' =>  [
        'Home\Logical\ActivityDetail\NoActivity',
        'Home\Logical\ActivityDetail\PoopClearanceActivityDetail'
    ],
    
    'pay_type_img' => [
      '/Public/Home/img/wx.png',
      '/Public/Home/img/alipay.png',
      '/Public/Home/img/union_pay.png',
      '/Public/Home/img/balance.png'
    ],
    
    'internetTitle' => [
        'goodsDetail' => '商品详情',
        'goodsList'   => '商品列表',
        'orderList'   => '订单列表',
        'orderCenter' => '订单中心',
        'index'       => '首页',
        'login'       => '登录',
        'register'    => '注册',
        'settlement'  => '结算页',
        'search'      => '搜索'
    ],
    'activity_type' => [
        '没有活动',
        '尾货清仓',
        '最新促销',
        '积分商城',
        '打印耗材'
    ],
    'ad_space_id' => 38, //首页楼层商品中间大图
    "ERROR_PAGE"=>'/Home/Index/404.html',
    "MY_TRACKS_COOKIE_KEY"=>'MY_TRACKS',//保存我的足迹
    "ANNOUNCE_PAGE"=>'10',//公告列表页
    'welcome' => '欢迎来到两天聚清！',

    'qr_image' => './Uploads/qrCode/',
    'supermarket_floor_num' =>10,
    'Alipay' => array (
        //应用ID,您的APPID。
        'app_id' => "2016101200669801",

        //商户私钥
        'merchant_private_key' => "MIICXAIBAAKBgQDJ6L9VlC8BqNDqXKYwkGx5yf4/pHYggdKl8bVc0fEs01aOYjaVhLsNmouBoiy++f0/taiA2X4jw2t4qRS3NdY+W57S/QtBKu9cEtmg1FbB2FOAXHQJrD7DOJdiQNi9uSLdSYN+XSqJ7RkSGDed0AIKuPodOoXbC7enD1CLzcP81QIDAQABAoGBALFIs/eojT2fxRCDGUk7BoRJX/zxoucYFqWufdhqXqFFT5LlmZffW36uXCAPDcsCJeNy1emNDrzIMe1YSOA1XU8EBSzJ/8Eaj1bRNmBqV3Lbje/eWrMxbIyQMb5+wPhX0u8pOa7l9LnfMFXZ+463AJmuRyULeAM0UWKNC/pVPKEBAkEA7GK6wulz7Gk3KGkjUmrBb5XsQwHHZzKqtrs3DVKZoUw+iMx23m8y0ExmwWGvNhFzWMdJYA9YrC04FFyqi9aduQJBANqprFJHDQLxsQgiU7iyG98TA+eStdAHKFv/6DfnabQ0+WHmJmyr5RmNDBk5DCpVBhDvgwQ5KGHMUODDzOUBhf0CQG0iU9lDENsX5HhKuh0F3pKW5AI3owkZEknU+2CyPu2CFujvhP3C1vHmJBap88uBmQBm2ZB45VZwdhCoi7COADkCQC0tCPEmxMVq8cxgazOpeKCp6RCa+v0zvV7kjDGgmfIlT7CuQBoLmZWh0nITmzPTxSESmtrwhCtQbxVA3sAhhHECQGWUJAJHwmQbImtV9mQp+UihHN7hkNFVEzGiyaffhq7eiyHeo1u0HM3Eiu1x1ZrsjkoaAJc1jZgTTxIFv4z1b88=",

        //异步通知地址
//		'notify_url' => "http://wkvfs4.natappfree.cc/alipay/notify_url.php",
//
//		//同步跳转
//		'return_url' => "http://wkvfs4.natappfree.cc/alipay/return_url.php",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA",

        //支付宝网关
//		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
        'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB",
    )
);