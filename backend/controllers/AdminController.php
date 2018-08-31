<?php
namespace backend\controllers;

use Yii;
use common\controllers\AdminBaseController;
use common\models\LoginForm;
use common\services\AdminService;
use yii\helpers\Json;

/**
 * admin controller
 */
class AdminController extends AdminBaseController
{

    /**
     * 获取列表信息
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $pageSize = (int)Yii::$app->request->get('pageSize',10);
        $page = (int)Yii::$app->request->get('page', 1);
        $name = trim(Yii::$app->request->get('username', ''));
        $start = trim(Yii::$app->request->get('start', ''));
        $end = trim(Yii::$app->request->get('end', ''));
        $service = new AdminService();
        $data = $service->getList($page,$pageSize,$name,$start,$end);
        return $this->render('index',$data);
    }

    /**
     * 添加修改用户
     * @param int id
     * @return string
     */
    public function actionAdd()
    {
        $id = (int)Yii::$app->request->get('id',0);
        $service = new AdminService();
        $data = $service->adminInfo($id);
        return $this->render('add',['data'=>$data]);
    }

    /**
     * 修改停用状态
     * @param int $id
     * @param string $name
     * @param int $value
     */
    public function actionEditStatus()
    {
        $id = (int)Yii::$app->request->post('id',0);
        $status = trim(Yii::$app->request->post('name', ''));
        $value = (int)Yii::$app->request->post('value', 0);
        $service = new AdminService();
        $result = $service->editStatus($id,$status,$value);
        return  Json::encode($result);
    }

    /**
     * 添加管理员
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $id = (int)Yii::$app->request->post('id',0);
        $username = trim(Yii::$app->request->post('username',''));
        $password = trim(Yii::$app->request->post('password',''));
        $repassword = trim(Yii::$app->request->post('repassword',''));
        $service = new AdminService();
        $result = $service->addAdmin($username,$password,$repassword,$id);
        return  Json::encode($result);
    }

    /**
     * 删除信息
     */
    public function actionDel()
    {
        $id = (int)Yii::$app->request->post('id',0);
        $service = new AdminService();
        $result = $service->delAdmin($id);
        return  Json::encode($result);
    }

    /**
     * 批量删除
     * @return string
     */
    public function actionBatchDel()
    {
        $ids = Yii::$app->request->post('id',[]);
        $service = new AdminService();
        $result = $service->batchDelAdmin($ids);
        return  Json::encode($result);
    }

}
