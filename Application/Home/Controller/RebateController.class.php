<?php


namespace Home\Controller;


class RebateController extends BaseController
{
    public function rebate_mlist(){

            $id =  $_SESSION['user_id'];
            $user_name = M('user')->where(['id'=>$id])->getField('user_name');
    $data = M('rebate_log')->where(['pid'=>$id,'status'=>0])->select();
        $month = date('m');
        $year = date('Y');
        $last_month = date('m') - 1;
        if($month == 1){
            $last_month = 12;
            $year = $year - 1;
        }
        $start_time = mktime(0, 0, 0, $last_month, 1, $year);
        $end_time = mktime(0, 0, 0, $month, 1, $year);

          foreach ($data as $k =>$v){
               if( $start_time<$v['time']&&$v['time']<$end_time){
                         M('rebate_log')->where(['id'=>$v['id']])->save(['goqi_status'=>1]);
                  }
            }

    //自购
        $self_rebate=M('rebate_log')->where(['pid' =>$id,'type'=>2,'status'=>0,'goqi_status'=>0] )->getField('sum(total_price)');
        $vip_rebate=M('rebate_log')->where(['pid' =>$id,'type'=>1,'status'=>0,'goqi_status'=>0] )->getField('sum(total_price)');
        //业绩提现M('withdrawal')->where(['uid'=>$this->getUserId(),'status'=>['in',('0,1,2')]])->getField('sum(money)');
        $yeji_tprice = M('withdrawal')->where(['uid'=>$id,'status'=>['in',('0,1,2')],'yeji_status'=>1])->getField('sum(money)');

            $price_rebate =$vip_rebate + $self_rebate;
            $tc_money = 1;
          $date =  M('yeji_base')->select();
          foreach ($date as $k1 =>$v1){
            if($price_rebate>$v1['xd_money']){
                $tc_money = $v1['tc_money'];
            }
          }
          $tixian_money = floor($price_rebate*$tc_money/100)-$yeji_tprice;
            $this->assign('tixian_money',$tixian_money);
            $this->assign('user_name',$user_name);
            $this->assign('price_rebate',$price_rebate);
            $this->display();

    }
    public function yeji_tixian(){
        $tixian_money = $_GET['tixian_money'];
        $this->assign('tixian_money',$tixian_money);
        $this->display();
    }
    public function addyj_Withdrawal(){
        $url  = U( 'Rebate/rebate_mlist' );
        $post = I( 'post.' );
        //支付宝银行卡有一个即可,金额不能为空
        if( !(float)$post[ 'money' ] || ( !$post[ 'bank_num' ] && !$post[ 'ali_account' ] && !$post['wx_account']) ){
            $this->error( '请将页面填写完整,支付宝银行卡微信填写一个即可',$url );
        }
        //银行卡16 或19位数字
        if( $post[ 'bank_num' ] ) \preg_match( '/^[1-9](\d{15})|(\d{18})$/',$post[ 'bank_num' ] ) || $this->error( '银行卡号不正确',$url );
        //支付宝账号 邮箱或者手机号码
        if( $post[ 'ali_account' ] ) \preg_match( '/([a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+)|(1\d{10})/',$post[ 'ali_account' ] ) || $this->error( '支付宝账号不正确',$url );
        $id = $_SESSION['user_id'];
        $uuid = rand(100,999).$id.rand(100,999);
        $post['uid'] = $id;
        $post['drawal_id'] = $uuid;
        $post['status'] = 0;
        $time = time();
        $post['create_time'] = $time;
        $post['last_time'] = $time;
        $post['yeji_status'] = 1;
    $status = M('withdrawal')->add($post);
        //提交申请记录
        $status ? $this->success( '申请成功',$url ) : $this->error( '系统异常',$url );
    }
}