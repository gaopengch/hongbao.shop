<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.yisu.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 亿速网络（http://www.yisu.cn）
// +----------------------------------------------------------------------
// | Author: 王强 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
namespace Common\TraitClass;

use Common\Model\PayModel;

trait DispatcherPayTrait
{
    /**
     * 分发支付
     * @param array $data
     */
    protected function dispatcherPay (array $data)
    {

        try {
            $data[PayModel::$payName_d] = str_replace('/', '\\', $data[PayModel::$payName_d]);

            $obj = new \ReflectionClass($data[PayModel::$payName_d]);
            $instance = $obj->newInstance();

            $obj->getMethod('setPayData')->invoke($instance, $data);//设置支付数据

            $obj->getMethod('pay')->invokeArgs($instance, [$this]);//发起支付

        }catch (\Exception $e) {
            $this->promptParse(false, '参数有误');die();
        }
    }
}