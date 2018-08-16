<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\assets\AppAsset;
$this->title = '管理员登录-WeAdmin Frame型后台管理系统-WeAdmin 1.0';
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="<?= Url::to('@web/static/favicon.ico', true);?>" type="image/x-icon" />
    <?php $this->head() ?>
</head>

<body class="login-bg">
<?php $this->beginBody() ?>
<div class="login">
    <div class="message">WeAdmin 1.0-管理登录</div>
    <div id="darkbannerwrap"></div>
    <form method="post" class="layui-form" action="<?= Url::to(['site/login'])?>">
        <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken; ?>">
        <input name="info[username]" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" />
        <hr class="hr15">
        <input name="info[password]" lay-verify="required" placeholder="密码"  type="password" class="layui-input" autocomplete="new-password"  />
        <hr class="hr15">
        <input name="info[rememberMe]" title="记住我" lay-skin="primary" checked="" type="checkbox" value="1">
        <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
            <span>记住我</span><i class="layui-icon layui-icon-ok"></i>
        </div>
        <hr class="hr15">
        <input class="loginin" value="登录" lay-submit lay-filter="login" style="width:100%;" type="button">
        <hr class="hr20" >
    </form>
</div>
<?php $this->beginBlock('login') ?>
    layui.extend({
        admin: '<?= Url::to('@web/static/js/admin', true);?>'
    });

    layui.use(['form','admin'], function(){
        var url = '<?= Url::to(['site/login'])?>';
        var form = layui.form
            ,admin = layui.admin;
        // layer.msg('玩命卖萌中', function(){
        //   //关闭后的操作
        //   });
        //监听提交
        form.on('submit(login)', function(datas){
            $.ajax({
                type: 'POST',
                url: url,
                data: datas.field,
                success: function (data) {
                    alert(data);
                },
                error: function (err) {
                    layer.msg('登录失败服务器异常');
                }
            });
            return false;
        });
    });
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['login'], \yii\web\View::POS_END); ?>

<?php $this->endBody() ?>
<!-- 底部结束 -->
</body>
</html>
<?php $this->endPage() ?>

