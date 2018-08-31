<?php
namespace common\controllers;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AdminBaseController extends CommonController
{
    //不使用布局
    public $layout = false;
    /**
     * {@inheritdoc}
     * 什么是过滤器？过滤器就是对不同用户角色的控制；
     * 如（游客->最普通的平民，用户->已经注册的用户，管理员->拥有一切权限）
     * 然而 Yii2自带的权限控制默认只支持两个角色：
     * guest（游客，没有登录的，用 ? 表示）
     * authenticated （登录了的，用 @ 表示）
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    //不登录也能访问
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    //登录了才能访问
                    [
                        //'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            //过滤验证，logout使用get访问
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * 设置执行不存在的方法抛出的错误信息
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}