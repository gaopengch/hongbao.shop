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

namespace Home\Model;

use Common\Model\BaseModel;
use Common\TraitClass\ModelToolTrait;
use Common\Tool\Tool;

/**
 * 物流模型 
 */
class ExpressModel extends BaseModel{
    /**
     * 获取物流信息
     * @author jim
     * @param String $com 物流公司编号
     * @param String $nu  物流单号，快递单号
     * @param String $show 0表示返回json,1表示返回xml
     * @param String $muti 0表示多行完整信息,1表示一行信息
     * @param String $order desc asc 按时间降序，升序
     * @return Array 
     * status
     * 0:物流单号暂无结果；
     * 3:在途，快递处于运输过程中；
     * 4:揽件，快递已被快递公司揽收并产生了第一条信息；
     * 5:疑难，快递邮寄过程中出现问题；
     * 6:签收，收件人已签收；
     * 7:退签，快递因用户拒签、超区等原因退回，而且发件人已经签收；
     * 8:派件，快递员正在同城派件；
     * 9:退回，货物处于退回发件人途中；
     *
     */
    public function getExpress($com,$nu) { //子类以及子类的子类可以访问
        $post_data = array();
        $post_data["customer"] = 'D3752ED8DAF60459A8B2033C851C3F6B';
        $key= 'ihNjTvGj2333' ;
        $post_data["param"] = "{'com':'$com','num':'$nu'}";
        $url='http://poll.kuaidi100.com/poll/query.do';
        $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
        $post_data["sign"] = strtoupper($post_data["sign"]);
        $o="";


        foreach ($post_data as $k=>$v)
        {
            $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
      $data =json_decode($result,true);
      return $data;
 
    }

    //查询订单物流
    public function getExpressByOrder(array $order){
        if (empty($order)) {
            return false;
        }
        foreach ($order as $key => $value) {
            $where['id'] = $value['exp_id'];
            $res =  $this->field('id,name,tel,code')->where($where)->find();
            $order[$key]['exp_name'] = $res['name'];
        }
        return $order;
    }
}