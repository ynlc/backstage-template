<?php
namespace common\services;

use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class BaseServices extends BaseObject
{
    protected function returnJson($msg = '')
    {
        $status = 1;
        if($msg){
            $status = 0;
        }
        if(is_array($msg)){
            $status = 1;
        }
        $return = ['status'=>$status,'msg'=>$msg ? $msg : '操作成功'];
        return $return;
    }
}