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

use Think\Model;
use Common\Model\BaseModel;
use Home\Model\UserLevelModel;
use Admin\Model\SystemConfigModel;

/**
 * 积分使用表
 */
class IntegralUseModel extends Model
{

    /**
     * 获取有效积分,使用时间限制
     * @param  int     $user_id 用户id
     * @param  int     $time    限制时间,积分至少得到了多少天后才有效.0是兑换既就有效
     * @param  boolean $detail  显示可用积分列表
     * @return 数组
     */
    public function valid($user_id,$time = 0,$detail = false)
    {
        // 获取还在用户手中的积分,有可能是过期的,但是状态没有改变
        $field = 'id,user_id,integral,goods_id,trading_time,remarks,type,status,used';
        $where = ['type'=>1, 'status'=>1, 'user_id'=>$user_id];
        $list  = $this->field($field)->where($where)->order('id')->select();
        // 更新过期的积分,从现在算起,领取积分一年内有效
        $config = SystemConfigModel::getInitnation()->getValue(['parent_key'=>'integral']); //控制积分的有效时间
        // 判断是限制时间还是快过期时间
        
        $total    = 0;
        $endtal   = 0;
        $validate = [];
        $time_nte = [];
        if (is_array($list) && count($list) > 0) {
            $ids     = [];
            if(empty($config[0]['Integral_time'])){                                         //   过期时间 365    2018/8/31 18:19:8
                $overdue = time() - (365 * 24 * 60 * 60);                                   
            }else{
                $overdue = strtotime('-'.$config[0]['Integral_time'].' day');               //   过期时间 300    2018/11/4 18:17:41
            }
            $time = $time?$time:0;
            $delayed = strtotime('-'.$time.' day');                                         //   当前时间    2019/8/31 19:0:41

            if(empty($config[0]['pay_integral'])){

               $expire_soon = strtotime("+30 day",$overdue);                                //   过期前30天   2018/8/21 18:19:8
            }else{
               $expire_soon = strtotime('-'.$config[0]['pay_integral'].' day',$overdue);    //   过期前20天   2018/10/15 18:17:41
            }

            foreach ($list as $val) {
                
                // 过期
                if ($val['trading_time'] < $overdue) {
                    $ids[] = $val['id'];
                    continue;
                }

                if($val['trading_time'] <= $expire_soon){
                    $time_nte[] = $val;
                    if ($endtal == 0) {
                        $endtal  = $val['integral'];
                    }
                    // unset($val['integral']);
                }
                // 限制时间未到
                if ($val['trading_time'] > $delayed) {
                    continue;
                }
                // 有效的,减去用过的部分
                $total += $val['integral'];
                if ($val['used'] != 0) {
                    $total -= $val['used'];
                }
                // 保存详情
                if ($detail) {
                    $validate[] = $val;
                }
            }
            // 使用过期
            if (is_array($ids) && count($ids) > 0){
                $ids = implode(',', $ids);
                $this->where(['id' => ['in', $ids]])->save(['status' => 3]);
            }
        }
        
        /**
         * @param  int     total   用户有效积分
         * @param  array   list    用户可用积分数据
         * @param  array   expire  用户快过期数据
         * @param  string  end     用户结束时间
         * @param  string  endtal  用户快到期有效积分
         * @return 数组
         */
        //格式化时间
        return $detail ? ['total'=>$total,'list'=>$validate ,'expire' =>$time_nte,'end'=>$expire_soon,'endtal'=>$endtal] : $total;
    }


    /**
     * 使用优惠券,添加标记
     * @param  integer $user_id  用户id
     * @param  integer $integral 使用的过得积分
     * @param  integer $time     使用时间限制
     * @param  array   $data     数据库附带参数:goods_id,remarks
     * @return boolean
     */
    public function used($user_id, $integral, $time = 0, $data = [])
    {
        $ids   = '';
        $total = 0;
        $used  = [];
        $list  = $this->valid($user_id, $time, true);

        if ($integral > $list['total']) {
            return false;
        }
       
        if (is_array($list['list'])) {

            foreach ($list['list'] as $vo) {
                // 减去（user）使用过几分
                $temp = $total + $vo['integral'];
                
               
                if ($vo['used'] != 0) {
                    $temp -= $vo['used'];        //$temp为剩余积分（可以使用的）
                    $add = $temp;               //记录一次值

                }
                // 刚好够
                if ($temp == $integral && $add == 0) {
                    $ids .= ','.$vo['id'];
                    $total += $vo['integral'];
                    break;
                }
                // 判断积分和计算出的
                if ($temp > $integral) {
                    $used['id']   = $vo['id'];
                    //继承计算和多余的积分，然后修改 $temp
                    $used['used'] = $integral - $total + $add;//加下一条记录所得的$temp>$integral,所以103行的$total(此时)必定< $integral ---meng
                    break;                                            //这个订单使用的积分-这条数据以前可以用的积分+这条数据已用的 等于这条用掉的积分
                }
                // 不够继续循环
                $ids   .= ','.$vo['id'];
                $total += $vo['integral'];
            }
           
        }
     
        //添加记录
        if (!empty($ids)) {
            $this->where(['id'=>['in', ltrim($ids, ',')]])->save(['status'=>2, 'used'=>0]);
        }
        // 修改用掉一些的表
        if (count($used) > 0) {
            $this->where(['id'=>$used['id']])->save(['used'=>$used['used']]);
        }
        // 添加一条使用记录
        $info = [
            'user_id'      => $user_id,
            'integral'     => $integral,
            'goods_id'     => $data['goods_id'],
            'trading_time' => time(),
            'remarks'      => $data['remarks'],
            'type'         => 2
        ];
        return $this->add($info);
    }
     //优惠
    public function getDiscount($user_id)
    {
        if(!$user_id){
            return false;
        }
        $integral = $this->valid($user_id);

        $where = [
            'integral_small'  => ['ELT',$integral],
            'status'  => ['EQ',1]
        ];
        $discount_rate = BaseModel::getInstance(UserLevelModel::class)->where($where)->order( UserLevelModel::$integralSmall_d . ' desc')->getField(UserLevelModel::$discountRate_d);
        if($discount_rate){
            return  (float)$discount_rate / 100 ;
        }

        return 1;
    }
}