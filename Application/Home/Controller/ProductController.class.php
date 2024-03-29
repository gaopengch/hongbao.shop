<?php
namespace Home\Controller;

use Common\Tool\Tool;
use Home\Model\GoodsSoldtimeModel;
use Think\Page;
use Common\Model\BaseModel;
use Home\Model\GoodsModel;

class ProductController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    
        $this->intnetTitle = $this->intnetTitle.' - '.C('internetTitle.goodsList');

    }
    
    
    
    public function index()
    {
        //检测传值
        Tool::checkPost($_GET, array('is_numeric'=> array('sid')), true, array('sid')) === false ? $this->error('当前操作异常', U('Index/index')) : true;

        $this->display();
    }

    /**
     * 商品分类列表
     *    分为2种商品分类列表：
     *    1商品分类点击进来的
     *      a.通过cid进行选择商品
     *      b.对应不同的条件
     *
     *     2商品搜索进来的
     *      a,通过show关键词来表示选择商品
     *      b.对应不同的条件
     */
//    public function ProductList(){
//        $goodsModel = M("Goods");
////        $goodsClassModel = M("GoodsClass");
//        $soldtimeModel = M("GoodsSoldtime");
//        $sid = I("get.sid");
//        $cid = I("get.cid");
//        $id  = I("get.id");
//        //获取时段名称
//        $soldname = $soldtimeModel->field('name,id,starttime')->where('status=1')->select();
////        showData($soldname,1);
//
//        //通过关键词来表示搜索商品
//        $show = I("get.show");
//         if(I("get.keyword")){
//             $arrs = explode(' ',I("get.keyword"));
//             foreach($arrs as $arr){
//                 $arr_keyword[] = '%'.$arr.'%';
//             }
//
//             $cond['title']=['like',$arr_keyword,'and'];
//         }
//
//        $begin_price = I("get.begin_price");
//        $end_price = I("get.end_price");
//        $this->assign("show",$show);
//        if($begin_price&&$end_price){
//            $cond['price_market']=['between', [$begin_price,$end_price]];
//        }elseif(!$begin_price&&$end_price){
//
//            //假如文本框输入的开始值为空，就赋值从0开始，尾值就是结束值
//            $cond['price_market']=['between', [0,$end_price]];
//        }else{
//
//            //假如文本框输入的结束值为空,取值就大于第一个文本框的值
//            $cond['price_market'] = ['egt',$begin_price];
//        }
//        $starttime = strtotime(date('Y-m-d', strtotime("-1 day")))-1;
//        $endtime = strtotime(date('Y-m-d', strtotime("+1 day")))+1;
//        $cond['sold_date'] = ['between',[$starttime,$endtime]];
//
//        $cond['is_clear'] = 1;
//        //通过id的方式来选择商品
//
//        //查询条件
//        (I('get.brand')=="all")?false:($cond['brand_id']=I('get.brand'));
//        if(!$cond['brand_id']){
//            unset($cond['brand_id']);
//        }
//
//        I("get.id")?$cond['class_id']=I("get.id"):false;
//
//        ( I("get.goods_spec")=="all")?false:$aj_goods_spec =I("get.goods_spec");
//        if($aj_goods_spec){
//            $goods_type = $this->ajaxGoodsSpec($aj_goods_spec);
//            $goods_type?$cond['goods_type']=['in',$goods_type]:false;
//
//        }
//        (I("get.price")=="all")?false:$price=I("get.price");
//        $line = "-";
//
//
//        if($price){
//            if(strpos($price, $line) !== false){
//                $arr_num = explode("-",$price);
//                $begin_price = $arr_num[0];
//                $end_price = $arr_num[1];
//                //文本框都有值时
//                if($begin_price&&$end_price){
//                    $cond['price_market']=['between', [$begin_price,$end_price]];
//                }elseif(!$begin_price){
//                    //假如文本框输入的开始值为空，就赋值从0开始，尾值就是结束值
//                    $cond['price_market']=['between', [0,$end_price]];
//                }else{
//                    //假如文本框输入的结束值为空,取值就大于第一个文本框的值
//                    $cond['price_market'] = ['egt',$begin_price];
//                }
//
//            }else{
//                $count_price=(int)$price;
//                $cond['price_market'] = ['egt',$count_price];
//            }
//        }
//
//
//
//       //畅销排行top10
//        $ranks = $this->rankingList();
//        $this->assign('ranks',$ranks);
//
//        //商品列表广告图
//        $goods_ad = M("Ad")->field("ad_link,id,pic_url")->where(['ad_space_id'=>36])->order("id desc")->find();
//        $this->assign("goods_ad",$goods_ad);
//
//
//        //分类搜索
//        //针对2种情况，第1种是从商品三级分类进到商品分类列表 id>0
//        //             第2种是搜索页面进入商品列表  id为空
//        if($id) {
//            //顶部菜单
//            $goodsClassModel = M("GoodsClass");
//            $result = $goodsClassModel->field('fid,class_name,id')->find($id);
//            if ($result['fid'] == 0) {
//                $str = $this->getCategory($id);
//                $str = rtrim($str, ",");
//                $str ? $str1['class_id'] = array('in', $str) : false;
//                $results = $goodsClassModel->field('id,fid,class_name')->where($str1)->select();
//
//                // 该id的商品
//                $ids = $this->getCategory($id);
//                $ids = trim($ids, ",");
//                //品牌
//                $brand_list = $this->brandClassList($ids);
//                //考虑在mysql查询数据的时候只能出现一次in,商品要查分类和扩展分类
//                //所以通过分类和扩展分类分别查出数据 进行累加
//                $cond['shelves'] = ['eq', 1];
//                //扩展分类
//                $excond = $cond;
//                $ids ? $excond['extend'] = array('in', $ids) : false;
//                unset($excond['class_id']);
//                //分类
//                $ids ? $cond['class_id'] = array('in', $ids) : false;
//
//                if (I("get.sortCond") == "价格") {
//                    $sortcond = "price_market";
//                    $resultGoods = $this->allGoods($cond, $sortcond);
//                    //扩展分类商品
//                    $exResultGoods = $this->allGoods($excond, $sortcond);
//                    $resultGoods = array_merge($resultGoods, $exResultGoods);
//                    $resultGoods = $this->remove_duplicate($resultGoods);
//                } elseif (I("get.sortCond") == "评论数") {
//                    $sortcond = "comment_member desc";
//                    $resultGoods = $this->allGoods($cond, $sortcond);
//                    $exResultGoods = $this->allGoods($excond, $sortcond);
//                    $resultGoods = array_merge($resultGoods, $exResultGoods);
//                    $resultGoods = $this->remove_duplicate($resultGoods);
//                } elseif (I("get.sortCond") == "上架时间") {
//                    $sortcond = "id desc";
//                    $resultGoods = $this->allGoods($cond, $sortcond);
//                    $exResultGoods = $this->allGoods($excond, $sortcond);
//                    $resultGoods = array_merge($resultGoods, $exResultGoods);
//                    $resultGoods = $this->remove_duplicate($resultGoods);
//                } else {
//                    $sortcond = "sales_sum desc";
//                    $resultGoods = $this->allGoods($cond, $sortcond);
//                    //扩展分类商品
//                    $exResultGoods = $this->allGoods($excond, $sortcond);
//                    $resultGoods = array_merge($resultGoods, $exResultGoods);
//                    $resultGoods = $this->remove_duplicate($resultGoods);
//                }
//
//                $reGoodsImgs = $this->allGoodsImgs($resultGoods);
//
//
//                $count = count($reGoodsImgs);
//                $page = new Page($count, C("PRODUCT_PAGE"));
//
//                $resultGoodsImgs = array_slice($reGoodsImgs, $page->firstRow, $page->listRows);
//                $page_show = $page->show();
//                $this->assign('page_show', $page_show);
//
//                if (IS_AJAX) {
//                    $data = array('data' => $resultGoodsImgs, 'page' => $page_show);
//                    $this->ajaxReturn($data);
//                }
//
//                //类型全部
//                $all_right_id = $id;
//
//                $this->assign('all_right_id', $all_right_id);
//                $this->assign("cid", $id);
//                //顶级菜单
//                $top_cate = M("GoodsClass")->field("id,fid,class_name")->find($id);
//                //当前位置
//                $local_position = $top_cate['class_name'];
//                $this->assign("local_position", $local_position);
//
//                //猜一猜
//                $guess_goods = $this->guess();
//
//                $this->assign("guess_goods", $guess_goods);
//
//
//                $this->assign("top_cate", $top_cate);
//                //右边的分类
//                $this->assign("results", $results);
//                //规格
//                $this->assign("goods_speces", $this->goodsSpec());
//                //商品分类
//                $this->assign("resultGoodsImgs", $resultGoodsImgs);
//
//                //品牌数据
//                $this->assign("brand_list", $brand_list);
//
//                //选择类型id
//                $this->assign('all_id', $id);
//
//                $this->display();
//                exit;
//            } else {
//                $result1 = $goodsClassModel->field('fid,class_name,id')->find($result['fid']);
//
//                //二级菜单
//                if ($result1['fid'] == 0) {
//
//                    $str = $this->getCategory($result1['id']);
//                    $str = rtrim($str, ",");
//                    $str ? $str2['class_id'] = array('in', $str) : false;
//                    $results = M("GoodsClass")
//                        ->field('id,fid,class_name')
//                        ->where($str2)
//                        ->select();
//                    // 该id的商品
//                    $ids = $this->getCategory($id);
//                    $ids = trim($ids, ",");
//                    //品牌
//                    $brand_list = $this->brandClassList($ids);
//
//                    $cond['shelves'] = ['eq', 1];
//                    //扩展分类
//                    $excond = $cond;
//                    $ids ? $excond['extend'] = array('in', $ids) : false;
//                    unset($excond['class_id']);
//                    //分类
//                    $ids ? $cond['class_id'] = array('in', $ids) : false;
//
//                    if (I("get.sortCond") == "价格") {
//                        $sortcond = "price_market";
//                        $resultGoods = $this->allGoods($cond, $sortcond);
//                        $exResultGoods = $this->allGoods($excond, $sortcond);
//                        $resultGoods = array_merge($resultGoods, $exResultGoods);
//                        $resultGoods = $this->remove_duplicate($resultGoods);
//                    } elseif (I("get.sortCond") == "评论数") {
//                        $sortcond = "comment_member desc";
//                        $resultGoods = $this->allGoods($cond, $sortcond);
//                        $exResultGoods = $this->allGoods($excond, $sortcond);
//                        $resultGoods = array_merge($resultGoods, $exResultGoods);
//                        $resultGoods = $this->remove_duplicate($resultGoods);
//                    } elseif (I("get.sortCond") == "上架时间") {
//                        $sortcond = "id desc";
//                        $resultGoods = $this->allGoods($cond, $sortcond);
//                        $exResultGoods = $this->allGoods($excond, $sortcond);
//                        $resultGoods = array_merge($resultGoods, $exResultGoods);
//                        $resultGoods = $this->remove_duplicate($resultGoods);
//                    } else {
//                        $sortcond = "sales_sum desc";
//                        $resultGoods = $this->allGoods($cond, $sortcond);
//                        //扩展分类商品
//                        $exResultGoods = $this->allGoods($excond, $sortcond);
//                        $resultGoods = array_merge($resultGoods, $exResultGoods);
//                        $resultGoods = $this->remove_duplicate($resultGoods);
//                    }
//                    $reGoodsImgs = $this->allGoodsImgs($resultGoods);
//
//                    //去除商品相册为空的数据
//                    $resultGoodsImgs = $this->removeNullImgs($reGoodsImgs);
//
//                    $count = count($resultGoodsImgs);
//                    $page = new Page($count, C("PRODUCT_PAGE"));
//
//                    $resultGoodsImgs = array_slice($resultGoodsImgs, $page->firstRow, $page->listRows);
//                    $page_show = $page->show();
//                    $this->assign('page_show', $page_show);
//
//                    if (IS_AJAX) {
//
//                        $data = array('data' => $resultGoodsImgs, 'page' => $page_show);
//
//                        $this->ajaxReturn($data);
//                    }
//
//
//
//                    //顶级菜单
//                    $top_cate = $goodsClassModel->field("id,fid,class_name")->find($result1['id']);
//
//                    //当前点击的二次菜单
//                    $current_cat = $goodsClassModel->field("id,fid,class_name")->find($id);
//
//                    //当前位置
//                    $local_position = $top_cate['class_name'] . ">" . $current_cat['class_name'];
//                    $this->assign('local_position', $local_position);
//
//                    //全部
//                    $all_right_id = $current_cat['fid'];
//                    $this->assign('all_right_id', $all_right_id);
//                    $this->assign("current_cat", $current_cat);
//
//                    //猜一猜
//                    $guess_goods = $this->guess();
//                    $this->assign("guess_goods", $guess_goods);
//
//
//                    $this->assign("top_cate", $top_cate);
//                    //右边的分类
//                    $this->assign("results", $results);
//                    //规格
//                    $this->assign("goods_speces", $this->goodsSpec());
//                    //商品分类
//                    $this->assign("resultGoodsImgs", $resultGoodsImgs);
//
//                    //品牌数据
//                    $this->assign("brand_list", $brand_list);
//
//                    //选择类型id
//                    $this->assign("all_id", $result1['fid']);
//                    $this->display();
//                    exit;
//                } else {//三级分类
//                    //品牌
//                    $brand_list = $this->brandClassList($id);
//                    $str = $this->getCategory($result1['fid']);
//                    $str = rtrim($str, ",");
//                    $str ? $str3['class_id'] = array('in', $str) : false;
//                    $results = $goodsClassModel
//                        ->field('id,fid,class_name')
//                        ->where($str3)
//                        ->select();
//
//                    if (I("get.sortCond") == "价格") {
//                        $sortcond = "price_market";
//
//                    } elseif (I("get.sortCond") == "评论数") {
//                        $sortcond = "comment_member desc";
//
//                    } elseif (I("get.sortCond") == "上架时间") {
//                        $sortcond = "id desc";
//
//                    } else {
//
//                    }
//
//                    $cond['p_id'] = ['gt', 0];
//                    $cond['shelves'] = ['eq', 1];
//                    //扩展分类
//                    $excond = $cond;
//                    $excond['extend'] = $excond['class_id'];
//                    unset($excond['class_id']);
//                    // 该id的商品
//                    if ($sortcond) {
//                        $resultGoods = $goodsModel
//                            ->field('id,title,price_market,price_member,p_id,class_id,comment_member,sales_sum')
//                            ->where($cond)
//                            ->order($sortcond)
//                            ->group('p_id')
//                            ->select();
//                        $exResultGoods = $goodsModel
//                            ->field('id,title,price_market,price_member,p_id,class_id,comment_member,sales_sum')
//                            ->where($excond)
//                            ->order($sortcond)
//                            ->group('p_id')
//                            ->select();
//                        $resultGoods = array_merge($resultGoods, $exResultGoods);
//                        $resultGoods = $this->remove_duplicate($resultGoods);
//
//                    } else {
//                        $resultGoods = $goodsModel
//                            ->field('id,title,p_id,class_id,price_market,price_member,comment_member,sales_sum')
//                            ->where($cond)
//                            ->group("p_id")
//                            ->order("sales_sum")
//                            ->select();
//                        $exResultGoods = $goodsModel
//                            ->field('id,title,p_id,class_id,price_market,price_member,comment_member,sales_sum')
//                            ->where($excond)
//                            ->group("p_id")
//                            ->order("sales_sum")
//                            ->select();
//                        $resultGoods = array_merge($resultGoods, $exResultGoods);
//                        $resultGoods = $this->remove_duplicate($resultGoods);
//
//                    }
//
//
//                    $reGoodsImgs = $this->allGoodsImgs($resultGoods);
//
//                    //去除商品相册为空的数据
//                    $resultGoodsImgs = $this->removeNullImgs($reGoodsImgs);
//
//
//                    $count = count($resultGoodsImgs);
//                    $page = new Page($count, C("PRODUCT_PAGE"));
//                    $resultGoodsImgs = array_slice($resultGoodsImgs, $page->firstRow, $page->listRows);
//                    $page_show = $page->show();
//                    if (IS_AJAX) {
//                        $data = array('data' => $resultGoodsImgs, 'page' => $page_show);
//                        $this->ajaxReturn($data);
//                    }
//
//
//                    //考虑到点击第3级菜单的时候，商品列表中显示的菜单和以前的不一样，要显示出自己和兄弟出来
//                    //先找到父亲，通过父亲查找子类显示出来
//                    $third_parent = M("GoodsClass")->field("fid")->find($id);
//                    $third_parent_id = $third_parent['fid'];
//
//                    $third_brother = $this->getCategory($third_parent_id);
//                    $third_brother = rtrim($third_brother, ",");
//                    $third_brother ? $cond2['class_id'] = array('in', $third_brother) : false;
//                    $third_parent_childs = M("GoodsClass")
//                        ->field("id,class_name,fid")
//                        ->where($cond2)
//                        ->select();
//
//                    //猜一猜
//                    $guess_goods = $this->guess();
//
//                    $this->assign("guess_goods", $guess_goods);
//
//                    $this->assign("third_parent_id", $third_parent_id);
//                    $this->assign("third_parent_childs", $third_parent_childs);
//                    $this->assign('page_show', $page_show);
//
//                    //当前菜单的父级菜单
//                    $top_cate = $goodsClassModel->field("id,fid,class_name")->find($result1['fid']);
//
//                    //二级菜单
//                    $two_cate = $goodsClassModel->where(['id' => $top_cate['id']])->getField('class_name');
//
//                    //当前点击的三次菜单
//                    $current_third_cat = M("GoodsClass")->field("id,fid,class_name")->find($id);
//                    //全部
//                    $all_right_id = $current_third_cat['fid'];
//
//                    //当前位置
//                    $local_position = $top_cate['class_name'] . ">" . $two_cate . ">" . $current_third_cat['class_name'];
//
//                    $this->assign('local_position', $local_position);
//                    $this->assign('all_right_id', $all_right_id);
//
//                    $this->assign("current_third_cat", $current_third_cat);
//                    $this->assign("top_cate", $top_cate);
//                    //右边的分类
//                    $this->assign("results", $results);
//                    //商品分类
//                    $this->assign("resultGoodsImgs", $resultGoodsImgs);
//
//                    //品牌数据
//                    $this->assign("brand_list", $brand_list);
//
//                    //规格
//                    $this->assign("goods_speces", $this->goodsSpec());
//
//                    //选择类型id
//                    $this->assign("all_id", $result1['id']);
//                    $this->display();
//                    exit;
//                }
//
//            }
//        }
//
//
//        //时段搜索
//        if($cid){
//            $cond['shelves'] = 1;
//            $result = $soldtimeModel->field('name,id')->find($sid);
//
//            if (I("get.sortCond") == "价格") {
//                $sortcond = "price_market";
//                $resultGoods = $this->getGoodsBySold($cond, $sortcond,$cid,$sid);
//            } elseif (I("get.sortCond") == "评论数") {
//                $sortcond = "comment_member desc";
//                $resultGoods = $this->getGoodsBySold($cond, $sortcond,$cid,$sid);
//            } else {
//
//                $sortcond = "sales_sum desc";
//                $resultGoods = $this->getGoodsBySold($cond, $sortcond,$cid,$sid);
//            }
//
//        }else{//搜索页面
////            showData($cond,1);
//            $cond['shelves']=['eq',1];
//            //新品
//            if(I("get.sortCond") == "价格") {
//                $sortcond = "price_market";
//                $resultGoods = $this->allGoods($cond, $sortcond);
//            }elseif(I("get.sortCond") == "评论数"){
//                $sortcond = "comment_member desc";
//                $resultGoods = $this->allGoods($cond, $sortcond);
//            }elseif(I("get.sortCond") == "上架时间"){
//                $sortcond = "id desc";
//                $resultGoods = $this->allGoods($cond, $sortcond);
//            }else{
//                $sortcond = 'sales_sum desc';
//                $resultGoods = $this->allGoods($cond, $sortcond);
//            }
//
//        }
//        $reGoodsImgs = $this->allGoodsImgs($resultGoods);
//        foreach($reGoodsImgs as &$v){
//            $v['price_member']= $v['price_clear'];
//        }
////        $reGoodsImgs = $this->add_water($reGoodsImgs);
//        $count = count($reGoodsImgs);
//        $page = new Page($count, C("PRODUCT_PAGE"));
//
//        $resultGoodsImgs = array_slice($reGoodsImgs, $page->firstRow, $page->listRows);
//        $page_show = $page->show();
//        $this->assign('page_show', $page_show);
//
//        if (IS_AJAX) {
//            $data = array('data' => $resultGoodsImgs, 'page' => $page_show);
//            $this->ajaxReturn($data);
//        }
////            showData($resultGoodsImgs,1);
//        //类型全部
//
//        $this->assign('all_right_id', $sid);
//        $this->assign("sid", $sid);
//        $this->assign("ssid", $sid);
//        $this->assign("soldname", $soldname);
//
//        //猜一猜
//        $guess_goods = $this->guess();
//
//        $this->assign("guess_goods", $guess_goods);
//
//        $this->assign("top_cate", $result);
//        //规格
//        $this->assign("goods_speces", $this->goodsSpec());
//        //商品分类
//        $this->assign("resultGoodsImgs", $resultGoodsImgs);
//
//        //选择类型id
//        $this->assign('all_id', $sid);
//        $this->assign('sid', $sid);
//        $this->assign('cid', $cid);
//
//
//        $this->display();
//
//        exit;
//
//    }

    public function ProductList(){
        $user_id = $_SESSION['user_id'];
        $goodsModel = BaseModel::getInstance(GoodsModel::class);

        //获取时段
        $soldTimeModel = BaseModel::getInstance(GoodsSoldtimeModel::class);
        $soldname = $soldTimeModel->newGetSoldTime();
        //今日
        $time = time();

        $flag = 0;
        $aa = 0;
        foreach($soldname as $k=>$v){
            if($time>($soldname[$aa]['starttime']) && $time<($v['starttime'])){
                $flag = $aa;
            }
            $aa = $k;
        }
        if(!$flag){
            if($time>$soldname[$aa]['starttime']){
                $flag = $aa;
            }else{
                $flag = 0;
            }
        }
        //倒计时
        $starttime = $soldname[$flag]['starttime'];
        $flag = $soldname[$flag]['id'];

        if($starttime>$time){
            $flagShow = 1;
        }else{
            $flagShow = 0;
        }
        //今日清仓
        $page=I('post.page');
        if($user_id){
            $today_clear = $goodsModel->getClearGoods(1,$flag,$user_id,$page);
        }else{
            $today_clear = $goodsModel->getClearGoods(1,$flag,'',$page);
        }

        $todayData   = array(
            'today_clear'   => $today_clear,
            'starttime'     => $starttime,
            'time'          => $time,
            'flag'          => $flag,
            'flagShow'      => $flagShow,
        );

//        showData($todayData);
//        showData($soldname,1);

        $this->assign('todayData',$todayData);
        $this->assign('soldnames',$soldname);

        $this->display();
    }



    /**
     * 寻找子类的id
     * @param integer $category_id 父级分类
     * @return string $category_ids 该父级分类的子类
     */
    private  function getCategory($category_id ){
        $category_ids = $category_id.",";
        $child_category = M("GoodsClass") -> field("id,class_name")->where(['fid'=>$category_id])->select();
        foreach( $child_category as $key => $val ){
            $category_ids .= $this->getCategory( $val["id"] );
        }
        return $category_ids;
    }

    /**
     * 获取全部分类的商品基本信息
     * @param string $categoy 商品分类的id
     * @return mixed  商品的基本信息
     */
    private function allGoods($category,$sortcond){
        $feild = ['id,title,stock,price_market,price_member,p_id,comment_member,sales_sum,sold_date,sold_time,price_clear'];
        $cond = $category;
        $cond['p_id'] = ['gt',0];
        if($sortcond){
            $categoryGoods =M('Goods')->field($feild)
                ->where($cond)
                ->group("p_id")
                ->order($sortcond)
                ->select();
        }else{
            $sortcond = "sales_sum desc";
            $categoryGoods=M('Goods')
                ->field($feild)
                ->where($cond)
                ->group("p_id")
                ->order($sortcond)
                ->select();

        }


        return $categoryGoods;

    }
    /**
     * 根据清仓类型选取商品
     * @param $cond where条件
     * @param $sortcond 排序
     * @param $cid 清仓时间  1、当日 2、昨日 3、明天
     * @param $sid 清仓时段
     * @return mixed
     */
    public function getGoodsBySold($cond=[],$sortcond,$cid,$sid=''){
        $feild = ['id,title,stock,price_market,price_member,p_id,comment_member,sales_sum,sold_date,sold_time,price_clear'];
        $where = $cond;
        $where['shelves'] = 1;
        $where['status'] = 0;
        $where['p_id'] = ['gt',1];
        $today = strtotime(date('Y-m-d', time()));
        switch($cid){
            case 1:
                $where['sold_date'] =array('eq',$today);
                $where['sold_time'] = $sid;
                break;
            case 2:
                $where['sold_date'] =array('eq',$today-86400);
                break;
            case 3:
                $where['sold_date'] =array('eq',$today+86400);
                $where['sold_time'] = $sid;
                break;
        }

        $goods = M('Goods')->field($feild)->where($where)->group("p_id")->order($sortcond)->select();

        return $goods;

    }



    /**
     * 获取全部商品分类的商品信息
     * @param array $allgoods 商品基本信息
     * @return mixed 返回商品相册信息
     */
    private function allGoodsImgs($allgoods){
        foreach($allgoods as &$allgood){
            $pic_url = M("GoodsImages")->where(['goods_id'=>$allgood['p_id']])->limit(1)->find();
            $allgood['pic_url'] = $pic_url['pic_url'];
            //用父商品名称
            $allgood['title']=M('goods')->where(['id'=>$allgood['p_id']])->getField('title');
            $allgood['stock']=M('goods')->where(['id'=>$allgood['p_id']])->getField('stock');
        }
       unset($allgood);

       return $allgoods;
    }

    /**
     * 去除商品信息中商品相册为空的数据
     * @param array $reGoodsImgs 商品相册信息
     * @return mixed $reGoodsImgs 返回商品信息：商品相册不为空的数据
     */
    private function removeNullImgs($reGoodsImgs){
        foreach($reGoodsImgs as $k=>$reGoodsImg){
            if(empty($reGoodsImg['pic_url'])){
                unset($reGoodsImgs[$k]);
            }
        }
     return $reGoodsImgs;
    }


    /**
     * 猜一猜
     *
     * 登录的数据
     *     1.当有cookie时，就从cookie里面取
     *     2.如果没有cookie,就随机取
     * 未登录的数据
     *     1.随机取数据
     * @return mixed array 返回数据
     */
    public function guess(){
        $goods_model = M("Goods");
        //没有登陆的情况下
         if(empty(session("user_id"))){
             $goods_recs = $this->notLoginGuess();
             return $goods_recs;
         }else{//用户登录的情况
             $key      = C('MY_TRACKS_COOKIE_KEY');
             $my_tracks = cookie($key);
             if($_COOKIE['user_id']==$my_tracks['user_id']){//当登录的用户是cookie里面取的用户
                 unset($my_tracks['user_id']);
                 $my_tracks = array_unique($my_tracks);
                 $goodsModel = M("Goods");
                 $cond['id'] = ['in',$my_tracks];

                 //查出父类的id
                 $p_ids = $goodsModel->where($cond)->getField("title,p_id");
                 $p_ids = array_values($p_ids);
                 $p_ids = array_unique($p_ids);
                 $my_tracks = implode(',',$my_tracks);
                 $p_ids = implode(',',$p_ids);

                 if($p_ids&$my_tracks){
                     //在条件中：p_id 要用到2次。考虑到tp不足，采用原生来拼接语句
                     $sql = "SELECT `id`,`title`,`p_id`,`price_market`,`price_member`,`comment_member` FROM `db_goods` WHERE `p_id` IN ($p_ids) AND `id` NOT IN ($my_tracks) AND `p_id`>0 AND `recommend`=1 GROUP BY p_id ORDER BY rand() limit 5";

                     $goods = M()->query($sql);
                     //取出商品的id，然后再去取对应的图片。
                     $goods_img_model = M("GoodsImages");
                     foreach($goods as &$good){
                         $pic_url = $goods_img_model->where(['goods_id'=>$good['p_id']])->order("rand()")->find();
                         $good['pic_url'] = $pic_url['pic_url'];
                     }
                 }else{
                     $goods = $this->notLoginGuess();
                 }

                 unset($goods1);
                 if(IS_AJAX){
                     $this->assign('guess_goods',$goods);
                     $this->display("ajaxGuessLike");
                     exit;
                 }

                  return $goods;
             }else{//如果用户登录后，没有浏览商品的商品详情，就随机分配数据给用户
                 $goods = $this->notLoginGuess();
                 return $goods;
             }
         }
    }


    /**
     * 没有登陆的猜一猜
     * @return mixed array 返回数据
     */
    protected function notLoginGuess(){
        $goodsModel = M("Goods");
        $rec = [
            'recommend'=>1,
            'p_id'=>['gt',0]
        ];
        $goods_recs = $goodsModel->field("id,title,p_id,price_market,price_member,comment_member")
            ->where($rec)
            ->group("p_id")
            ->order('rand()')
            ->limit(5)
            ->select();
        //取出商品的id，然后再去取对应的图片。
        $goods_img_model = M("GoodsImages");
        foreach($goods_recs as &$goods_rec){
            $pic_url =$goods_img_model->where(['goods_id'=>$goods_rec['p_id']])->limit(1)->find();
            $goods_rec['pic_url'] = $pic_url['pic_url'];
        }
        if(IS_AJAX){
            $this->assign('guess_goods',$goods_recs);
            $this->display("ajaxGuessLike");
            exit;
        }


        return $goods_recs;
    }

    /**
     * 畅销排行Top10
     * @return mixed array
     */
    public function rankingList(){
        //前10名订单
        return D("PromotionGoods")->careSelect();
    }

    /**
     * 一级分类的对应的品牌
     * @param integer $id 分类id
     * @return array mixed  返回的品牌
     */
    public function brandClassList($id){
        $goodsClassModel = M("GoodsClass");
        $result1 = $goodsClassModel->field("id,fid")->where(['id'=>$id])->find();
        if($result1['fid'] == 0){
           $fid = $id;
        }else{
            $result2 = $goodsClassModel->field("id,fid")->where(['id'=>$result1['fid']])->find();
            if($result2['fid']==0){
                $fid = $result2['id'];
            }else{
                $fid = $result2['fid'];
            }
        }
        $str = $this->getCategory($fid);
        $str = rtrim($str,",");
        $where_brand['goods_class_id'] = ['in',$str];
        $brand_list = M("Brand")->field("id,brand_name")
                    ->where($where_brand)
                    ->select();
        return $brand_list;
    }


    /**
     * 规格项数据
     * @return mixed array
     */
    public function goodsSpec(){
        $goodsSpec =M("GoodsSpec")->distinct(true)->field("name")->select();
        return $goodsSpec;
    }

    public function ajaxGoodsSpec($aj_goods_spec){
        $goods_types = M("GoodsSpec")->distinct("type_id")->where(['name'=>$aj_goods_spec])->getField("type_id",true);
        return $goods_types;
    }


    /**
     * 当用户搜索商品的时候，跳到这个页面的时候，类型显示为所有的商品分类
     * @return mixed 返回的数据
     */
    public function getGooodsClass(){
        $goodsclassModel = M("goodsClass");
        $topGoodsClass = $goodsclassModel->field("id,class_name")->where(['fid'=>0])->select();
        return $topGoodsClass;
    }

    /**
     * 搜索的时候，显示所有的品牌
     * @return mixed
     */
    public function searchBrandLists(){
        $brandlist = M("Brand")->field("id,brand_name")->select();
        return $brandlist;
    }


    /**
     * 二维数组去掉重复值
     * @param $array2D
     * @return array
     */

    function remove_duplicate($array){
        $result=array();
        for($i=0;$i<count($array);$i++){
            $source=$array[$i];
            if(array_search($source,$array)==$i && $source<>"" ){
                $result[]=$source;
            }
        }
        return $result;
    }

    /**
     * 售罄的商品添加水印
     * @param array $resultGoodsImgs 商品信息列表
     * @return array
     */
    function add_water($resultGoodsImgs) {
        foreach($resultGoodsImgs as $index=>$goods) {
            if(intval($goods["stock"]) <= 0) {
                $imageUrl = __SERVER__.$goods["pic_url"];
                $ext = pathinfo($imageUrl)["extension"];
                $image_sellout = explode('.'.$ext, strstr($imageUrl,"Uploads"))[0];
                $pic_url =  __SERVER__.'/'.$image_sellout."_sellout".'.'.$ext;
                $image_sellout = $_SERVER["DOCUMENT_ROOT"].'/'.$image_sellout."_sellout".'.'.$ext;
                if(file_exists($image_sellout)) {
                    goto edit;
                }
                $imginfo = getimagesize($imageUrl);
                $type = image_type_to_extension($imginfo[2], false);
                $x = $imginfo[0] * 0.2;
                $y = $imginfo[1] * 0.2;
                $imgcreate = "imagecreatefrom{$type}";
                $image = $imgcreate($imageUrl);
                $water_url = __SERVER__."/Public/Home/img/sellout.jpg";
                $imginfo_water = getimagesize($water_url);
                $type_water = image_type_to_extension($imginfo_water[2], false);
                $createWater = "imagecreatefrom{$type_water}";
                $water = $createWater($water_url);
                imagecopymerge($image, $water, $x, $y, 0, 0, $imginfo_water[0], $imginfo_water[1], 35);
                $saving = "image{$type}";
                $saving($image, $image_sellout);
                edit:
                $resultGoodsImgs[$index]["pic_url"] = $pic_url;
            }
        }
        return $resultGoodsImgs;
    }

}

