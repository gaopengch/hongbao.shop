<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.yisu.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 亿速网络（http://www.yisu.cn）
// +----------------------------------------------------------------------
// | Author: 王强 <opjklu@126.com>\n
// +----------------------------------------------------------------------

namespace Admin\Model;

use Common\Model\BaseModel;
use Home\Model\IntegralUseModel;


/**
 * 用户等级表
 * @author 王强
 * @version 1.0.1
 */
class UserLevelModel extends BaseModel
{
    private static $obj;


	public static $id_d;	//id

	public static $levelName_d;	//等级名称

	public static $integralSmall_d;	//积分下限

	public static $integralBig_d;	//积分上限

	public static $discountRate_d;	//折扣率

	public static $rebatePercentage_d;	//返利比例

	public static $status_d;	//会员等级状态 1 使用 0弃用

	public static $description_d;	//等级描述


    public static function getInitnation()
    {
        $class = __CLASS__;
        return  static::$obj= !(static::$obj instanceof $class) ? new static() : static::$obj;
    }
    
    protected function _before_insert(& $data, $options)
    {
        $data[static::$status_d] = 1;
        
        return $data;
    }
    
    /**
     * 根据 用户数据 获取等级数据 
     * @param array  $data 用户数据
     * @param string $id   获取id
     */
    public function getLevelByUser(array $data, $id)
    {
        if (empty($data) ||!is_array($data) || empty($id)) {
            return $data;
        }
        $this->getLevel($data);
        return $data;
    }

    /**
     * 查询用户等级,组合数据
     */

    private function getLevel(&$data)
    {
        $IntegralUseModel = new IntegralUseModel();

        foreach($data as $k  => &$v){
            $integral = $IntegralUseModel->valid($v['id']);
            $where = [
                UserLevelModel::$integralSmall_d  => ['ELT',$integral],
                UserLevelModel::$status_d  => ['EQ',1]
            ];
            $level = $this->where($where)->order( UserLevelModel::$integralSmall_d . ' desc')->getField(UserLevelModel::$levelName_d);
            $v[UserLevelModel::$levelName_d] = $level;
        }
    }

    /**
     * 根据会员等级字符串 查询数据 
     * @param array $data 数组数据
     * @return array
     */
    public function getDataByGroup(array $data,  $field, $parkey)
    {
        if (empty($data) ||!is_array($data) || !is_string($field) || !is_string($parkey) ) {
            return array();
        }
        
        $idString = null;
        
        foreach ($data as $key => & $value) {
            if (empty($value[$parkey])) {
                continue;
            }
            
            $idString .= ','.$value[$parkey];
        }
        $idString = substr($idString, 1);
       
        if (empty($idString)) {
            return array();
        }
        
        $userData = $this->where(static::$id_d .' in ('.$idString.')')->getField($field);
        
        if (empty($userData)) {
            return array();
        }
        
        $flag = null;
        foreach ($data as $key => & $value) {
            
            if (empty($value[$parkey])) {
                continue;
            }
            $flag = explode(',', $value[$parkey]);
            if (empty($flag)) {
                continue;
            }
            
            foreach ($flag as $k => $v) 
            {
                if (array_key_exists($v, $userData)) {
                    $value[$parkey] .= ','.$userData[$v];
                    $value[$parkey]  = substr($value[$parkey], 2);
                }
            }
        }
        
        return $data;
    }
}