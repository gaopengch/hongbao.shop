<?php


namespace Home\Controller;


class MyBillsController extends BaseController
{
    //个人余额
    public function account_balance()
    {
       $id = $_SESSION['user_id'];
       $username =  M('user')->field('user_name')->where(['id'=>$id])->find();
       $data = M('payment_money')->where(['payment'=>'zfb'])->find();
       $this->assign(['username'=>$username['user_name'],'id'=>$id,'money1'=>$data['money1'],'money2'=>$data['money2'],'money3'=>$data['money3']]);
        $this->display();      
    }
    public function getAccount_balance()
    {
        $id = I('post.id');
        if (empty($id)){
            $data['msg'] = 0;
            $this->ajaxReturn($data);
        }
        $account_balance =  M('user')->field('account_balance')->where(['id'=>$id])->find();
        $data['account_balance'] = $account_balance['account_balance'];
        if (empty($account_balance)){
            $data['msg'] = 0;
            $this->ajaxReturn($data);
        }
        $data['msg'] = 1;
        $this->ajaxReturn($data);
    }
    public function zhifu_balance()
   {
       $id = $_SESSION['user_id'];
       if($id){
           $money = I('post.money');
//          
               $config = C('Alipay');
               //异步通知地址D:\phpstudy\PHPTutorial\WWW\ShopsN_B2C_BIZ_PC
               $config['notify_url'] = "http://".$_SERVER['SERVER_NAME']."/index.php/Home/MyBills/notify_url";
               //同步跳转
               $config['return_url'] = "http://".$_SERVER['SERVER_NAME']."/index.php/Home/MyBills/return_url";
               Vendor('Alipay.pagepay.service.AlipayTradeService');
               Vendor('Alipay.pagepay.buildermodel.AlipayTradePagePayContentBuilder');
               //付款金额，必填
               $total_amount = trim($money);
               //商品描述，可空
//        $body = '余额充值';
               $str = date("Y-m-d H:i:s",time());
               $str1 = str_replace(["-",":"," "], "", $str);
               $ddno='zfb'.$str1.rand(1000,9999);
               //订单名称，必填
               $subject = '充值余额'.time();
               $ud = $id;
               $data = array(
                   'user_id' => $ud,                              //用户id
                   'order_sn' => $ddno,               //商户订单号
                   'winsubject'=>$subject,                  //订单名称
                   'account' => $total_amount,        //付款金额
//            'winbody'=>$body,                        //商品描述
                   'pay_name' => 'zfb',                          //支付方式
                   'pay_status' => '0',                           //是否支付
                   'ctime' => time()                      //交易时间
               );
               M("recharge")->add($data); // 保存交易信息
               //构造参数
               $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
//       $payRequestBuilder->setBody($body);
               $payRequestBuilder->setSubject($subject);
               $payRequestBuilder->setTotalAmount($total_amount);
               $payRequestBuilder->setOutTradeNo($ddno);
               $aop = new \AlipayTradeService($config);

               $response = $aop->pagePay($payRequestBuilder, $config['return_url'], $config['notify_url']);
               //输出表单
               //  var_dump($response);
//           }else{
//               $this->error('金额应大于100');
//           }

       }else{
            $this->redirect('Public/login');
       }

   }
    public function return_url()
    {
        $config = C('Alipay');
        Vendor('Alipay.pagepay.service.AlipayTradeService');
        $arr=$_GET;
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($arr);
        if($result) {//验证成功
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            $total_amount = htmlspecialchars($_GET['total_amount']);
            $trade_no = htmlspecialchars($_GET['trade_no']);
            M()->startTrans();
            $res1 = M('recharge')->where(['order_sn'=>$out_trade_no])->save(['pay_code'=>$trade_no]);

            $res2 = M('recharge')->where(['order_sn'=>$out_trade_no])->save(['pay_time'=>time()]);

            $res3 = M('recharge')->where(['order_sn'=>$out_trade_no])->save(['pay_status'=>'1']);

            $uid = M('recharge')->where(['order_sn'=>$out_trade_no])->getField('user_id');
            $res4 = M('user')->where(['id'=>$uid])->setInc( 'account_balance',$total_amount);
            if(!$res1 || !$res2 || !$res3 || !$res4 || !$uid){
                M()->rollback();
                $this->AliPayPlaceRefund($out_trade_no,$total_amount,$trade_no);
                exit;
            }
            M()->commit();
            $this->redirect('MyBills/account_balance');
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }
    public function notify_url()
    {
        $config = C('Alipay');
        Vendor('Alipay.pagepay.service.AlipayTradeService');
        $arr=$_POST;
        $alipaySevice = new \AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);
        if($result) {
            file_put_contents('./log.txt',$_POST['out_trade_no'],$_POST['trade_no']);

            if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS' ) {
                $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
                $total_amount = htmlspecialchars($_GET['total_amount']);
                $trade_no = htmlspecialchars($_GET['trade_no']);
                M()->startTrans();
                $res1 = M('recharge')->where(['order_sn'=>$out_trade_no])->save(['pay_code'=>$trade_no]);

                $res2 = M('recharge')->where(['order_sn'=>$out_trade_no])->save(['pay_time'=>time()]);

                $res3 = M('recharge')->where(['order_sn'=>$out_trade_no])->save(['pay_status'=>'1']);

                $uid = M('recharge')->where(['order_sn'=>$out_trade_no])->getField('user_id');
                $res4 = M('user')->where(['id'=>$uid])->setInc( 'account_balance',$total_amount);
                if(!$res1 ||!$res2 || !$res3 || !$res4 || !$uid){
                    M()->rollback();
                    $this->AliPayPlaceRefund($out_trade_no,$total_amount,$trade_no);
                    exit;
                }
                M()->commit();
                $this->redirect('MyBills/account_balance');
            }
            echo "success";	//请不要修改或删除
        }else {
            echo "fail";

        }
    }
    //退款接口
   public function AliPayPlaceRefund($out_trade_no,$total_amount,$trade_no){
        Vendor('Alipay.aop.AopClient');
        Vendor('Alipay.aop.request.AlipayTradeFastpayRefundQueryRequest');
        $aop = new \AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipaydev.com/gateway.do';
        $aop->appId = '2016101200669801';
        $aop->rsaPrivateKey = 'MIICXAIBAAKBgQDJ6L9VlC8BqNDqXKYwkGx5yf4/pHYggdKl8bVc0fEs01aOYjaVhLsNmouBoiy++f0/taiA2X4jw2t4qRS3NdY+W57S/QtBKu9cEtmg1FbB2FOAXHQJrD7DOJdiQNi9uSLdSYN+XSqJ7RkSGDed0AIKuPodOoXbC7enD1CLzcP81QIDAQABAoGBALFIs/eojT2fxRCDGUk7BoRJX/zxoucYFqWufdhqXqFFT5LlmZffW36uXCAPDcsCJeNy1emNDrzIMe1YSOA1XU8EBSzJ/8Eaj1bRNmBqV3Lbje/eWrMxbIyQMb5+wPhX0u8pOa7l9LnfMFXZ+463AJmuRyULeAM0UWKNC/pVPKEBAkEA7GK6wulz7Gk3KGkjUmrBb5XsQwHHZzKqtrs3DVKZoUw+iMx23m8y0ExmwWGvNhFzWMdJYA9YrC04FFyqi9aduQJBANqprFJHDQLxsQgiU7iyG98TA+eStdAHKFv/6DfnabQ0+WHmJmyr5RmNDBk5DCpVBhDvgwQ5KGHMUODDzOUBhf0CQG0iU9lDENsX5HhKuh0F3pKW5AI3owkZEknU+2CyPu2CFujvhP3C1vHmJBap88uBmQBm2ZB45VZwdhCoi7COADkCQC0tCPEmxMVq8cxgazOpeKCp6RCa+v0zvV7kjDGgmfIlT7CuQBoLmZWh0nITmzPTxSESmtrwhCtQbxVA3sAhhHECQGWUJAJHwmQbImtV9mQp+UihHN7hkNFVEzGiyaffhq7eiyHeo1u0HM3Eiu1x1ZrsjkoaAJc1jZgTTxIFv4z1b88=';
        $aop->alipayrsaPublicKe='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB';
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA';
        $aop->postCharset='utf-8';
        $aop->format='json';
        $request = new \AlipayTradeFastpayRefundQueryRequest();
        $request->setBizContent("{" .
            "\"out_trade_no\":\"$out_trade_no\"," .
            "\"trade_no\":\"$trade_no\"," .
            "\"refund_amount\":\"$total_amount\"," .
            "\"refund_reason\":\"充值失败退款\"," .
            "\"out_request_no\":\"HZ01RF001\"," .
            "\"operator_id\":\"OP001\"," .
            "\"store_id\":\"NJ_S_001\"," .
            "\"terminal_id\":\"NJ_T_001\"" .
            "  }");
        $result = $aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            $this->success('充值失败',U('MyBills/account_balance'));
        } else {
            $this->success('充值失败,联系买家',U('MyBills/account_balance'));
        }
    }
}