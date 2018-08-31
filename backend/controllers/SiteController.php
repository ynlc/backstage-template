<?php
namespace backend\controllers;

use backend\models\AdminLoginForm;
use Yii;
use common\controllers\AdminBaseController;

/**
 * Site controller
 */
class SiteController extends AdminBaseController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionWelcome()
    {
        return $this->render('welcome');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new AdminLoginForm();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post(),'info') && $model->login()) {
                return 1;
            } else {
                return 0;
            }
        }else {
            $model->password = '';
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
