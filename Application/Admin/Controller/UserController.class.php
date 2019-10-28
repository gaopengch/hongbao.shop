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

namespace Admin\Controller;

use Common\Controller\AuthController;
use Common\Model\BaseModel;
use Admin\Model\UserLevelModel;
use Admin\Model\UserGradeModel;
use Common\Model\RegionModel;
use Common\Tool\Tool;
use Admin\Model\UserModel;
use Home\Model\MemberModel;
use Think\AjaxPage;
use Admin\Model\BalanceModel;
use Common\Model\UserAddressModel;
use Admin\Model\OrderModel;
use Common\Model\OrderGoodsModel;
use Admin\Model\RechargeModel;
use Think\Page;

/**
 * 会员管理
 * @author 王强
 */
class UserController extends AuthController
{

    /**
     * 会员列表
     */
    public function userList()
    {
        $userModel = BaseModel::getInstance(UserModel::class);
        $this->userModel = UserModel::class;
        $this->display();
    }

    /**
     * ajax 返回会员列表
     */
    public function ajaxUserList()
    {
        $userModel = BaseModel::getInstance(UserModel::class);
        
        Tool::isSetDefaultValue($_POST, array(
            'orderBy' => $userModel::$id_d,
            'sort' => BaseModel::DESC
        ));
        
        // 组装搜索条件
        Tool::connect('ArrayChildren');
        
        $where = $userModel->buildSearch($_POST,true, array(UserModel::$mobile_d));
        
        $data = $userModel->getDataByPage(array(
            'field' => array(
                $userModel::$id_d,
                $userModel::$userName_d,
                $userModel::$nickName_d,
                $userModel::$email_d,
                $userModel::$mobile_d,
                $userModel::$createTime_d,
                $userModel::$levelId_d,
                $userModel::$integral_d,
                $userModel::$status_d,
                $userModel::$memberStatus_d
            ),
            'where' => $where,
            'order' => $_POST['orderBy'] . ' ' . $_POST['sort']
        ), 20, false, AjaxPage::class);
        
        // 传递会员等级表 查找对应的等级
        $userLevel = BaseModel::getInstance(UserLevelModel::class);

        Tool::connect('parseString');
        // 组合数据
        $data['data'] = $userLevel->getLevelByUser($data['data'], $userModel::$levelId_d);
        // 传递余额表
        $balanceModel = BaseModel::getInstance(BalanceModel::class);
        
        $data['data'] = $balanceModel->getBalanceByUser($data['data'], $userModel::$id_d);
        $data['data'] = $this->getMemberStatus($data['data']);
//        showData($data,1);
        $this->data = $data;
        $this->balanceModel = BalanceModel::class;
        $this->levelModel = UserLevelModel::class;
        $this->userModel = UserModel::class;
        $this->display();
    }

    public function getMemberStatus($data){
        foreach($data as $k=>$v){
            $userGrade = BaseModel::getInstance(UserGradeModel::class);
            $data[$k]['member_status'] = $userGrade->getRebate($v['member_status']);
        }
        return $data;
    }


    /**
     * 会员详情
     */
    public function detail()
    {
        Tool::checkPost($_GET, array(
            'is_numeric' => array(
                'id'
            )
        ), true, array(
            'id'
        )) ? true : $this->error('参数错误');
        
        $userModel = BaseModel::getInstance(UserModel::class);
        
        $data = $userModel->getAttribute(array(
            'field' => array(
                $userModel::$id_d,
                $userModel::$userName_d,
                $userModel::$nickName_d,
                $userModel::$email_d,
                $userModel::$mobile_d,
                $userModel::$createTime_d,
                $userModel::$integral_d,
                $userModel::$status_d,
                $userModel::$memberStatus_d,
                UserModel::$memberDiscount_d,
                UserModel::$memberStatus_d,
                $userModel::$sex_d,
                $userModel::$twoRebates_d
            ),
            'where' => array(
                $userModel::$id_d => $_GET['id']
            )
        ));
        //获取返利级别
        $rebate = M('user_grade')->field('id,grade_name')->select();
        //获取备注
        $remark = M('user')->field('remark')->where(array(
            $userModel::$id_d => $_GET['id']
        ))->find();

        // 传递余额表
        
        $balanceModel = BaseModel::getInstance(BalanceModel::class);
        
        Tool::connect('parseString');
        
        $data = $balanceModel->getBalanceByUser($data, $userModel::$id_d);

        // 缩减数组
        $data = Tool::connect('Mosaic')->parseToArray($data);

        $this->data = $data;
        
        $this->balanceModel = BalanceModel::class;
        
        $this->userModel = UserModel::class;

        $this->assign('rebate',$rebate);
        $this->assign('remark',$remark);

        $this->display();
    }

    /**
     * 保存详情
     */
    public function saveDetail()
    {

        $validata = array(
            'id',
            'mobile',
            'status'
        );
        
        $must = $validata;
        
//        $must[] = 'email';
        Tool::checkPost($_POST, [
            'is_numeic' => $validata,
            'password'
        ], true, $must) ? true : $this->error('参数错误 不能为空');
        
//        filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?: $this->error('邮箱错误');   : 
        
        $userModel = BaseModel::getInstance(UserModel::class);
        
        if(I('post.integral') == 0){
            unset($_POST['integral']);
        }
        $status = $userModel->saveData($_POST);

        if(empty($status)) 
        $this->error('保存失败') ;
        if(I('post.integral') != 0 && I('post.id')){
            $data['integral'] = I('post.integral');
            $data['user_id'] = I('post.id');
            //调用增加积分
            $result = $userModel->integral_add_user($data);
            if(empty($result)) 
            $this->error('保存失败');
        }
        $this->success('保存成功');
    }

    /**
     * 查看会员收货地址
     */
    public function showUserAddress()
    {
        Tool::checkPost($_GET, array(
            'is_numeric' => array(
                'id'
            )
        ), true, array(
            'id'
        )) ? true : $this->error('参数错误');
        
        $userAddressModel = BaseModel::getInstance(UserAddressModel::class);
        
        $userAddressData = $userAddressModel->getAttribute(array(
            'field' => array(
                $userAddressModel::$createTime_d,
                $userAddressModel::$updateTime_d,
                $userAddressModel::$id_d
            ),
            'where' => array(
                $userAddressModel::$userId_d => $_GET['id']
            ),
            'order' => $userAddressModel::$createTime_d . BaseModel::DESC . ',' . $userAddressModel::$updateTime_d . BaseModel::DESC
        ), true);
        $RegionModel = BaseModel::getInstance(RegionModel::class);
//        showData($userAddressData,1);
        foreach($userAddressData as $k=>$v){
            $userAddressData[$k]['addressQuan'] = $RegionModel->getJoin($v['dist']);
            $userAddressData[$k]['addressQuan'] .= '-'.$v['address'];
        }
        $this->userAddressData = $userAddressData;
        $this->userAddress = UserAddressModel::class;
        $this->display();
    }

    /**
     * 删除会员
     */
    public function deleteUser()
    {
        Tool::checkPost($_POST, array(
            'is_numeic' => array(
                'id'
            )
        ), true, array(
            'id'
        )) ? true : $this->ajaxReturnData(null, 0, '参数错误');
        
        $userModel = BaseModel::getInstance(UserModel::class);
        
        // 删除用户表里的数据
        
//        $userModel->delete(array(
//            'where' => array(
//                $userModel::$id_d => $_POST['id']
//            )
//        ));
        $userModel->where(['id'=>$_POST['id']])->setField('status',0);
        
        // 删除余额表里的数据
        BaseModel::getInstance(BalanceModel::class)->delete(array(
            'where' => array(
                BalanceModel::$userId_d => $_POST['id']
            )
        ));
        // 删除 订单数据
        
        $orderModel = BaseModel::getInstance(OrderModel::class);
        $status     = $orderModel->deleteOrder($_POST['id']);
   
        
        Tool::connect('parseString');
        // 删除订单商品表
        BaseModel::getInstance(OrderGoodsModel::class)->deleteOrderGoodsByUserId($orderModel->getOrderIds(), $orderModel::$id_d);
        
        $this->ajaxReturnData(null);
        // .....
    }

    /**
     * 会员余额记录
     */
    public function userRecharge()
    {
        Tool::checkPost($_GET, array(
            'is_numeric' => array(
                'id'
            )
        ), true, array(
            'id'
        )) ? true : $this->error('参数错误');
        
        $balanceModel = BaseModel::getInstance(BalanceModel::class);
        
        $balanceData = $balanceModel->getDataByPage(array(
            'field' => array(
                $balanceModel::$id_d
            ),
            'where' => array(
                $balanceModel::$userId_d => $_GET['id']
            )
        ), 20, true);
        
        $this->balanceData = $balanceData;
        
        $this->balanceModel = BalanceModel::class;
        
        $this->display();
    }

    /**
     * 会员充值记录
     */
    public function userMoneryLog()
    {
        $userModel = BaseModel::getInstance(UserModel::class);
        $userId = array();
        if (! empty($_POST[$userModel::$userName_d])) {
            $userId = $userModel->getUserNameByName($_POST);
            $this->prompt($userId, null);
        }
        Tool::connect('parseString');
        $recharge = BaseModel::getInstance(RechargeModel::class);


        $where = $recharge->buildActiveSearch($userId, $userModel::$id_d);

        $data = $recharge->getDataByPage(array(
            'field' => array(
                $recharge::$id_d,
                $recharge::$userId_d,
                $recharge::$winsubject_d,
                $recharge::$orderSn_d,
                $recharge::$account_d,
                $recharge::$ctime_d,
                $recharge::$payName_d,
                $recharge::$payStatus_d,
                $recharge::$payCode_d,

            ),
            'where' => $where,
            'order' => $recharge::$ctime_d . BaseModel::DESC,
            $recharge::$payTime_d . BaseModel::DESC
        ), 20, false, AjaxPage::class);
//        echo "<pre>";
//        var_dump($data['data']);
        // 传递用户表
        $data['data'] = $userModel->getUserByRecharge($data['data']);

//, array(
//            $userModel::$id_d . ' as ' . $recharge::$userId_d ,
//            $userModel::$userName_d,
        Tool::isSetDefaultValue($_POST, array(
            'timegap' => 0,
            $userModel::$userName_d => ''
        ));

//        $this->$dayyExcel = $data['data'];
        $this->data = $data;
        $this->userModel = $userModel;
        $this->recharge = $recharge;
        $this->display();
    }
//导出会员记录excel
    public function exportExcel($expTitle,$expCellName,$expTableData){

        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $_SESSION['account'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);

        vendor("PHPExcel.PHPExcel");

        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;


    }
    /**
     *
     * 导出Excel
     */
  public  function expUser(){//导出Excel
      $userModel = BaseModel::getInstance(UserModel::class);
      $userId = array();
      if (! empty($_POST[$userModel::$userName_d])) {
          $userId = $userModel->getUserNameByName($_POST);
          $this->prompt($userId, null);
      }
      Tool::connect('parseString');
      $recharge = BaseModel::getInstance(RechargeModel::class);


      $where = $recharge->buildActiveSearch($userId, $userModel::$id_d);

      $data = $recharge->getDataByPage(array(
          'field' => array(
              $recharge::$id_d,
              $recharge::$userId_d,
              $recharge::$winsubject_d,
              $recharge::$orderSn_d,
              $recharge::$account_d,
              $recharge::$ctime_d,
              $recharge::$payName_d,
              $recharge::$payStatus_d,
              $recharge::$payCode_d,

          ),
          'where' => $where,
          'order' => $recharge::$ctime_d . BaseModel::DESC,
          $recharge::$payTime_d . BaseModel::DESC
      ), 20, false, AjaxPage::class);
//        echo "<pre>";
//        var_dump($data['data']);
      // 传递用户表
      $data['data'] = $userModel->getUserByRecharge($data['data'], $recharge::$userId_d);
//, array(
//            $userModel::$id_d . ' as ' . $recharge::$userId_d ,
//            $userModel::$userName_d,
      Tool::isSetDefaultValue($_POST, array(
          'timegap' => 0,
          $userModel::$userName_d => ''
      ));

        $xlsName  = "User";
        $xlsCell  = array(
            array('user_id','会员ID'),
            array('user_name','会员昵称'),
            array('ctime','提交时间'),
            array('winsubject','订单名称'),
            array('pay_code','充值单号'),
            array('account','充值金额'),
            array('pay_status','支付状态'),
            array('pay_name','支付方式'),

        );
      foreach ($data['data'] as $k => $v)
      {
          $data['data'][$k]['pay_status']=$v['pay_status']==1?'已支付':'待支付';
          $data['data'][$k]['ctime'] = date("Y-m-d H:i:s",$data['data'][$k]['ctime'] );
      }

        $this->exportExcel($xlsName,$xlsCell,$data['data']);

    }
     /**
     * 充值余额查询
     */
  public function setMoneryLog(){
      $data = M('payment_money')->where(['payment'=>'zfb'])->find();
      $this->assign(['data'=>$data]);
      $this->display();
  }
    /**
     * 修改金额
     */
    public function setMoney(){
        $data = I('post.');
        $res = M('payment_money')->where(['payment'=>'zfb'])->save($data);
        if(!$res){
            $this->error('修改失败');
        }else{
            $this->success('修改成功',U('User/setMoneryLog'));
        }
    }
    /**
     * 会员等级
     */ 
    public function grade()
    {
        $userLevelModel = BaseModel::getInstance(UserLevelModel::class);

        $field = $userLevelModel->getDbFields();

        $userLevel = $userLevelModel->getDataByPage(array(
            'field' => array(
                implode(',', $field)
            ),
            'order' => $userLevelModel::$id_d . BaseModel::DESC
        ));

        $this->userLevel = $userLevel;
        
        $this->model = UserLevelModel::class;
        
        $this->display();
    }

    /**
     * 编辑会员等级页面
     */
    public function editLevelHtml()
    {
        Tool::checkPost($_GET, array(
            'is_numeric' => array(
                'level_id'
            )
        ), true, array(
            'level_id'
        )) ? true : $this->error('参数错误');
        
        $class = UserLevelModel::class;
        $userLevelModel = BaseModel::getInstance($class);
        
        $data = $userLevelModel->getAttribute(array(
            'field' => array(
                $userLevelModel::$status_d
            ),
            'where' => array(
                $userLevelModel::$id_d => $_GET['level_id']
            )
        ), true, 'find');
        
        $this->data = $data;
        
        $this->userLevelModel = $class;
        
        $this->display();
    }

    /**
     * 保存会员编辑
     */
    public function saveEditLevel()
    {
        // 检测传值
        self::check();
        
        $userLevelModel = BaseModel::getInstance(UserLevelModel::class);
        $status = $userLevelModel->save($_POST);
        
        $this->updateClient($status, '没有修改数据或操作');
    }

    /**
     * 新增会员等级 页面
     */
    public function levelHtml()
    {
        $class = UserLevelModel::class;
        $userLevelModel = BaseModel::getInstance($class);
        
        $this->userLevelModel = $class;
        
        $this->display();
    }

    /**
     * 添加用户等级
     */
    public function addUserLevel()
    {
        self::check();
        // 是否存在 该等级
        
        $userLevelModel = BaseModel::getInstance(UserLevelModel::class);
        
        $isExit = $userLevelModel->getAttribute(array(
            'field' => array(
                $userLevelModel::$levelName_d
            ),
            'where' => array(
                $userLevelModel::$levelName_d => $_POST[$userLevelModel::$levelName_d]
            ),
            'limit' => 1
        ), false, 'find');
        
        $this->alreadyInDataPjax($isExit);
        
        $status = $userLevelModel->add($_POST);
        
        $this->updateClient($status, '操作');
    }

    /**
     * 删除用户等级
     */
    public function deleteLevelHandle()
    {
        self::checkUserId($_POST, 'id');
        
        $userLevelModel = BaseModel::getInstance(UserLevelModel::class);
        
        $status = $userLevelModel->delete(array(
            'where' => array(
                $userLevelModel::$id_d => $_POST['id']
            )
        ));
        
        $this->updateClient($status, '操作');
    }

    private function checkUserId(array $data, $checkId)
    {
        return Tool::checkPost($data, array(
            'is_numeric' => array(
                $checkId
            )
        ), true, array(
            $checkId
        )) ? true : $this->ajaxReturnData(null, 0, '参数错误');
    }

    /**
     *
     * @return boolean
     */
    private function check()
    {
        return Tool::checkPost($_POST, array(
            'is_numeric' => array(
                'integral_small',
                'integral_big',
                'discount_rate'
            )
        ), true, array(
            'integral_small',
            'integral_big',
            'discount_rate',
            'level_name',
            'description'
        )) ? true : $this->ajaxReturnData(null, 0, '参数错误');
    }

   

    /**
     * 添加用户页面
     */
    public function addUser()
    {
        $model = BaseModel::getInstance(UserModel::class);
        //上级会员
        $userData = $model->getConditionUser();
        //获取返利级别
        $rebate = M('user_grade')->field('id,grade_name')->select();
        
        $this->assign('userData', $userData);
        $this->assign('rebate', $rebate);

        $this->assign('userModel', UserModel::class);
        
        $this->display();
    }

    /**
     * 添加用户
     * Array
     * (
     * [user_name] => jdk
     * [nick_name] => jre
     * [mobile] => 15868985230
     * [password] => Array
     * (
     * [0] => wasd123
     * [1] => wasd123
     * )
     *
     * [member_status] => 0
     * [member_discount] => 100
     * [p_id] => 13
     * )
     */
    public function addUserData()
    {
        $validate = [
            'mobile',
            'member_status',
            'user_name',
            'password',
            'nick_name'
        ];
        
        Tool::checkPost($_POST, array(
            'is_numeric' => [
                'mobile',
                'member_status'
            ],
            'p_id'
        ), true, $validate) ?: $this->ajaxReturnData(null, 0, '操作失败');
        
        // 验证手机号码
        $isValidate = Tool::connect('ParttenTool')->validateData($_POST['mobile'], 'mobile');
        
        $this->promptPjax($isValidate, '验证失败');
        
        $model = BaseModel::getInstance(UserModel::class);
        
        // 是否存在
        
        $isExits = $model->IsExits($_POST);
        
        $this->alreadyInDataPjax($isExits);
        
        $status = $model->addUser($_POST);
        
        $this->updateClient($status, '添加');
    }


    public function expGoods()
    {
        $tj_value = json_decode($_GET['tj_value'], true);
        $cond = [];
        $tj_value['mobile'] ? $cond['mobile'] = $tj_value['mobile'] : false;
        $tj_value['email'] ? $cond['email'] = $tj_value['email'] : false;
        $userModel = BaseModel::getInstance(UserModel::class);
        Tool::isSetDefaultValue($cond, array(
            'orderBy' => $userModel::$id_d,
            'sort' => BaseModel::DESC
        ));
        // 组装搜索条件
        Tool::connect('ArrayChildren');
        $where = $userModel->buildSearch($cond,true, array(UserModel::$mobile_d));

        // 获取p参数
//        $current_page = $tj_value['p'];
        $xlsName = "user";
        $xlsCell = array(
            array('id', 'id'),
            array('user_name', '会员名称'),
            array('nick_name', '会员昵称'),
            array('status', '会员级别'),
            array('num', '下级会员数'),
            array('mobile', '手机号码'),
//            array('account_balance', '余额'),
//            array('lock_balance', '锁定余额'),
//            array('integral', '积分'),
            array('create_time', '注册日期'),
            array('p_id','上级会员ID'),
            array('p_name','上级会员账号')
        );
        $xlsModel = M('User');
        $balanceModel = M('Balance');
        $userLevelModel = M('UserLevel');
//        if ($current_page) { // 当前页导出excel
//            $xlsData = $xlsModel->field('id,user_name,email,mobile,integral,create_time,level_id')
//                ->where($cond)
//                ->page($current_page, 20)
//                ->order('id desc')
//                ->select();
//        } else { // 全部导出excel
//            $xlsData = $xlsModel->field('id,user_name,email,mobile,integral,create_time,level_id')
            $xlsData = $xlsModel->field('id,user_name,nick_name,mobile,create_time,p_id,member_status')
                ->where($where)
                ->order('id desc')
                ->select();
//        }
        $memberStatus = C('MemberStatus');
        $where2['p_id'] = ['in',array_column($xlsData,'id')];
        $xlsData2 = M('user')->where($where2)->group('p_id')->getField('p_id,count(id)');
        
        foreach ($xlsData as &$v) {
//            $v['account_balance'] = $balanceModel->where(['user_id' => $v['id']])->getField('account_balance');
//            $v['lock_balance'] = $balanceModel->where(['user_id' => $v['id']])->getField('lock_balance');
//            $v['level_name'] = $userLevelModel->where(['id' => $v['level_id']])->getField('level_name');
            $v['p_name'] = $xlsModel->where(['id' => $v['p_id']])->getField('user_name');
            $v['status'] = $memberStatus[ $v['member_status'] ];
            $v['create_time'] = date("Y-m-d H:i",$v['create_time']);
            $v['num']    = $xlsData2[$v['id']]?$xlsData2[$v['id']]:0;
        }
        unset($v);
        $this->exportExcel($xlsName, $xlsCell, $xlsData);
    }


    public function ajaxTeamList()
    {
        Tool::checkPost($_GET, array(
            'is_numeric' => array(
                'id'
            )
        ), true, array(
            'id'
        )) ? true : $this->error('参数错误');

        $userModel = BaseModel::getInstance(UserModel::class);

        $oneself = $userModel->getAttribute(array(
            'field' => array(
                $userModel::$id_d,
                $userModel::$pId_d
            ),
            'where' => array(
                $userModel::$id_d => $_GET['id']
            )
        ));
        $top_user = $userModel->getAttribute(array(
            'field' => array(
                $userModel::$id_d,
                $userModel::$userName_d,
                $userModel::$nickName_d,
                $userModel::$mobile_d,
                $userModel::$pId_d
            ),
            'where' => array(
                $userModel::$id_d => $oneself[0]['p_id']
            )
        ));

        $count = M( 'user' )->where( [ 'p_id' => $_GET['id'] ] )->getField( 'COUNT(*)' );
        if( (int)$count !== 0 ){
            $page   = new Page( $count,5 );
            $show = $page->show();
            $offset = max( ( $page->firstRow - 1 ),0 );
            $info   = M( 'user' )->field( 'id,mobile,create_time,user_name,nick_name,rebate_money' )->where( [ 'p_id' => $_GET['id'] ] )->limit( $page->firstRow.','.$page->listRows )->select();
            //查询消费总额
            $str = '';
            foreach( $info as $k1 => $v ){
                $info[ $k1 ][ 'create_time' ] = \date( 'Y-m-d ',$v[ 'create_time' ] );
                $str                          .= $v[ 'id' ] . ',';
            }
            $moneySum = M( 'order' )->where( [ 'user_id' => [ 'IN',\rtrim( $str,',' )],'order_status' => [ 'GT', '0' ] ] )->group( 'user_id' )->getField( "user_id,SUM(price_sum)" );
            foreach( $info as $k => $v2 ){
                if( isset( $moneySum[ $v2[ 'id' ] ] ) ){
                    $info[ $k ][ 'money' ] = $moneySum[ $v2[ 'id' ] ];
                    continue;
                }
                $info[ $k ][ 'money' ] = 0;
            }
            $this->assign( 'data',$info );
            $this->assign( 'page',$page->show() );
        }

        $this->assign( 'top_user',$top_user );
        $this->assign( 'self',$_GET['id'] );
        $this->userModel = UserModel::class;
        $this->display();
    }

    /**
     * 返利会员等级
     */
    public function rebate()
    {
        $userGradeModel = BaseModel::getInstance(UserGradeModel::class);
        $field = $userGradeModel->getDbFields();
        $userLevel = $userGradeModel->getDataByPage(array(
            'field' => array(
                implode(',', $field)
            ),
            'order' => $userGradeModel::$id_d . BaseModel::DESC
        ));

        $this->userLevel = $userLevel;

        $this->model = UserLevelModel::class;

        $this->display();
    }

    /**
     * 新增返利会员等级 页面
     */
    public function rebateAddHtml()
    {
        $class = UserGradeModel::class;
        $userGradeModel = BaseModel::getInstance($class);

        $this->UserGradeModel = $class;

        $this->display();
    }
    /**
     * 编辑返利会员等级页面
     */
    public function rebateEditHtml()
    {
        Tool::checkPost($_GET, array(
            'is_numeric' => array(
                'id'
            )
        ), true, array(
            'id'
        )) ? true : $this->error('参数错误');

        $class = UserGradeModel::class;
        $userGradeModel = BaseModel::getInstance($class);

        $data = $userGradeModel->getAttribute(array(
            'field' => array(
                $userGradeModel::$status_d
            ),
            'where' => array(
                $userGradeModel::$id_d => $_GET['id']
            )
        ), true, 'find');

        $this->data = $data;

        $this->UserGradeModel = $class;

        $this->display();
    }
    /**
     * 添加用户等级
     */
    public function rebateAdd()
    {
        self::checkRebate();
        // 是否存在 该等级

        $userGradeModel = BaseModel::getInstance(UserGradeModel::class);

        $isExit = $userGradeModel->getAttribute(array(
            'field' => array(
                $userGradeModel::$gradeName_d
            ),
            'where' => array(
                $userGradeModel::$gradeName_d => $_POST[$userGradeModel::$gradeName_d]
            ),
            'limit' => 1
        ), false, 'find');

        $this->alreadyInDataPjax($isExit);

        $status = $userGradeModel->add($_POST);

        $this->updateClient($status, '操作');
    }

    /**
     * 删除返利等级
     */
    public function deleteRebate()
    {
        self::checkUserId($_POST, 'id');

        $userGradeModel = BaseModel::getInstance(UserGradeModel::class);

        $status = $userGradeModel->delete(array(
            'where' => array(
                $userGradeModel::$id_d => $_POST['id']
            )
        ));

        $this->updateClient($status, '操作');
    }
    /**
     * 保存会员编辑
     */
    public function saveEditRebate()
    {
        // 检测传值
        self::checkRebate();

        $userGradeModel = BaseModel::getInstance(UserGradeModel::class);
        $status = $userGradeModel->save($_POST);

        $this->updateClient($status);
    }
    /**
     *
     * @return boolean
     */
    private function checkRebate()
    {
        return Tool::checkPost($_POST, array(
            'is_numeric' => array(
                'discount_rate',
                'rebate_ratio'
            )
        ), true, array(
            'discount_rate',
            'rebate_ratio',
            'grade_name',
            'description'
        )) ? true : $this->ajaxReturnData(null, 0, '参数错误');
    }

    //导出下级会员
    public function exportDown()
    {
        $uid = json_decode($_GET['uid'], true);
        $xlsName = "downUser";
        $xlsCell = array(
            array('id', 'id'),
            array('user_name', '下级会员账号'),
            array('mobile', '下级会员手机'),
            array('grade', '下级会员等级'),
            array('money', '消费额（元）'),
            array('rebate_money', '	返利额（元）'),
            array('create_time', '注册时间'),

        );


        $info   = M( 'user' )->field( 'id,mobile,create_time,user_name,rebate_money,member_status' )->where( [ 'p_id' => $uid['uid'] ] )->select();
//        $member_status  = M( 'user' )->where( [ 'p_id' => $uid['uid'] ] )->getField('member_status');

        //会员等级
        $userGrade = M('user_grade')->getField('id,grade_name');
        //查询消费总额
        $str = '';
        foreach( $info as $k1 => $v ){
            $info[ $k1 ][ 'create_time' ] = \date( 'Y-m-d ',$v[ 'create_time' ] );
            $info[ $k1 ][ 'grade' ] = $userGrade[$v['member_status']];
            $str                          .= $v[ 'id' ] . ',';
        }
        $moneySum = M( 'order' )->where( [ 'user_id' => [ 'IN',\rtrim( $str,',' )],'order_status' => [ 'EGT', '1' ] ] )->group( 'user_id' )->getField( "user_id,SUM(price_sum)" );

        //标题参数
//        $title['count'] = count($info);
//        $title['grade'] = $userGrade[$member_status];

        foreach( $info as $k => $v2 ){
            if( isset( $moneySum[ $v2[ 'id' ] ] ) ){
                $info[ $k ][ 'money' ] = $moneySum[ $v2[ 'id' ] ];
                continue;
            }
            $info[ $k ][ 'money' ] = 0;
        }
        unset($v);
        unset($v2);

        $xlsData = $info;
        $this->exportExcel($xlsName, $xlsCell, $xlsData);
    }
    //弹幕列表
    public function tanmuList(){
        $data = M('tanmu')->select();
        $this->assign('data',$data);
        $this->display();
    }

    public function danmu_edit(){
        $m = M('tanmu');
        $data = $m->field('tid,tcontent,tdistance')->find();
        $this->assign('data', $data);
        $this->display();
    }
    //弹幕修改
    public function danmu_save(){
        $tid = I('post.tid');
        $data = I('post.');
        $data['xiugaitime'] = time();
       $l =  M('tanmu')->where(['tid'=>$tid])->save($data);
        if ($l === false) {
            $this->error('修改失败');
        } else {
            $this->success('修改成功');
        }
    }
    //业绩浏览
    public function rebate_list(){
        $id =  $_GET['id'];
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
        $date = M('rebate_log')->where(['pid'=>$id,'goqi_status'=>1])->order('id desc')->select();
      $this->assign('date',$date);
      $this->display();
    }
    //业绩规则
    public function yeji_base(){
       $data = M('yeji_base')->order('tc_money asc')->select();
        $this->assign(['data'=>$data]);
        $this->display();
    }
    //添加业绩
    public function add_yeji(){
     $this->display();
    }
    //保存修改
    public function add_yejiData(){
     $xd_money = I('post.xd_money');
     $tc_money = I('post.tc_money');
     if(!is_numeric($xd_money)){
         $this->error('变量为数字');
         exit();
     }
     if (!(is_numeric($tc_money) && is_int($tc_money + 0) && ($tc_money + 0) > 0)){
         $this->error('变量为正整数');
         exit();
     }
     $data['xd_money'] = $xd_money*10000;
     $data['tc_money'] = $tc_money;
     $dat['gx_time'] = time();

     $l = M('yeji_base')->add($data);
       if(!$l){
           $this->error('添加失败');
       }
        $this->success('添加成功');
    }
    //编辑业绩规则
    public function yeji_edit(){
       $id = $_GET['id'];
       $data = M('yeji_base')->where(['id'=>$id])->find();
       $this->assign(['data'=>$data]);
       $this->display();
    }
    //修改业绩
    public function save_yejibase(){
        $id = I('post.id');
        $data['tc_money'] = I('post.tc_money');
        $data['gx_time'] = time();
       $l =  M('yeji_base')->where(['id'=>$id])->save($data);
       if(!$l){
           $this->error('修改失败');
       }
        $this->success('修改成功');
    }
    //删除业绩规则
    public function del_yeji(){
        $id = I('post.id');
        $l = M('yeji_base')->where(['id'=>$id])->delete();
        if(!$l){
            $this->ajaxReturn(0);
        }
            $this->ajaxReturn(1);
    }
    //个人积分
    public function integral(){
        $integral = M('user')->order('integral desc')->select();
        $this->assign(['data'=>$integral]);
        $this->display();
    }
    //个人红包
    public function redElope(){
        $redElope = M('user')->order('red_elope desc')->select();

        $this->assign(['data'=>$redElope]);
        $this->display();
    }
}