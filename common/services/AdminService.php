<?php
namespace common\services;
use common\models\CAdminUser;
use yii\db\Exception;
use yii\data\Pagination;
use yii\helpers\Url;

class AdminService extends BaseServices
{
    public function addAdmin($username,$password,$repassword,$id)
    {
        if(!$username){
            return $this->returnJson('用户名字不能为空');
        }
        if($id && empty($password)){
            if(!CAdminUser::findOne(['id'=>$id])){
                return $this->returnJson('管理员不存在');
            }
        } else {
            if($password != $repassword){
                return $this->returnJson('两次密码不一致');
            }
        }
        if(!$id && CAdminUser::findByUsername($username)){
            return $this->returnJson('管理员已存在');
        }
        $result = CAdminUser::add($username,$password,$id);
        if(!$result){
            return $this->returnJson('添加失败');
        }
        return $this->returnJson();
    }

    /**
     * 获取列表
     * @param $currentPage
     * @param $pageSize
     */
    public function getList($page,$pageSize,$name,$start,$end)
    {
        $offset = ($page - 1)* $pageSize;
        $query = CAdminUser::find()->where('1');
        if($name){
            $query->andWhere(['like','username',$name]);
        }
        if($start && $end){
            $start = strtotime($start);
            $end = strtotime($end.' 23:59:59');
            $query->andWhere(['between','created_at',$start, $end]);
        }
        $count = $query->count();
        if($count){
            $list = $query->select('id,username,created_at,status')->orderBy('id desc')->offset($offset)->limit($pageSize)->asArray()->all();
            foreach ($list as $k=>$v){
                if($v['status'] > 0){
                    $list[$k]['statusName'] = '已启用';
                    $list[$k]['updateStatus'] = 0;
                } else {
                    $list[$k]['statusName'] = '已停用';
                    $list[$k]['updateStatus'] = 10;
                }
            }
        }
        $pagination = new Pagination([
            'defaultPageSize' => $pageSize,
            'totalCount' => $count,
            //'route' => 'admin/index'
        ]);
        return ['count'=>$count,'list'=>isset($list) ? $list : [],'pages'=>$pagination];
    }

    /**
     * 修改停用状态
     * @param int $id
     * @param string $name
     * @param int $value
     */
    public function editStatus($id,$name,$value)
    {
        $data = CAdminUser::findOne(['id'=>$id]);
        if(!$data){
            return $this->returnJson('数据不存在');
        }
        $return[$name]  = $data->$name;
        $data->$name = $value;
        if(!$data->save()){
            return $this->returnJson('修改失败');
        }
        return $this->returnJson($return);
    }

    /**
     * 获取详情
     * @param $id
     */
    public function adminInfo($id)
    {
        if(!$id){
            return [];
        }
        return CAdminUser::find()->select('id,username')->where(['id'=>$id])->asArray()->one();
    }

    /**
     * 删除信息
     * @param $id
     */
    public function delAdmin($id)
    {
        if(!$id){
            return $this->returnJson('参数错误');
        }
        $object = CAdminUser::findOne(['id'=>$id]);
        if(!$object){
            return $this->returnJson('数据不存在');
        }
        if(!$object->delete()){
            return $this->returnJson('删除失败');
        }
        return $this->returnJson();
    }

    /**
     * 批量删除
     * @param $ids
     */
    public function batchDelAdmin($ids)
    {
        if(!CAdminUser::deleteAll(['id'=>$ids])){
            return $this->returnJson('删除失败');
        }
        return $this->returnJson();
    }
}