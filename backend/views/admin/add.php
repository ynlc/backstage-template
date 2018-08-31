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
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?= Url::to('@web/static/js/html5.min.js', true);?>"></script>
    <script type="text/javascript" src="<?= Url::to('@web/static/js/respond.min.js', true);?>"></script>
    <![endif]-->
</head>

<body>
<?php $this->beginBody() ?>
<div class="weadmin-body">
    <?= $this->render('_form',['data'=>$data]) ?>
</div>
<?php $this->beginBlock('admin_add') ?>
    var updateData = '<?= !empty($data) ? 1 : 0; ?>';
    if(updateData == 1){
        var hint = '修改成功';
    } else {
        var hint = '增加成功';
    }
    layui.extend({
        admin: '<?= Url::to('@web/static/js/admin', true);?>'
    });
    layui.use(['form','layer','admin'], function(){
        var form = layui.form,
            admin = layui.admin,
            layer = layui.layer;
        //自定义验证规则
        if(updateData == 1 && $('#L_pass').val() == ''){
            form.verify({
                nikename: function(value){
                    if(value.length < 5){
                        return '昵称至少得5个字符啊';
                    }
                }
            });
        } else {
            form.verify({
                nikename: function(value){
                    if(value.length < 5){
                        return '昵称至少得5个字符啊';
                    }
                }
                ,pass: [/(.+){6,12}$/, '密码必须6到12位']
                ,repass: function(value){
                    if($('#L_pass').val()!=$('#L_repass').val()){
                        return '两次密码不一致';
                    }
                }
            });
        }

        var url = '<?= url::to(['admin/signup']);?>';
        //监听提交
        form.on('submit(add)', function(datas){
            $.ajax({
                type: 'POST',
                url: url,
                data: datas.field,
                dataType: 'json',
                success: function (data) {
                    if(data.status == 1){
                        layer.alert(hint, {icon: 6},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                            parent.location.reload();
                        });
                    }else{
                        layer.msg(data.msg);
                    }
                },
                error: function (err) {
                    layer.msg('登录失败服务器异常');
                }
            });
            return false;
        });
    });
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['admin_add'], \yii\web\View::POS_END); ?>
<?php $this->endBody() ?>
</body>


</html>
<?php $this->endPage() ?>