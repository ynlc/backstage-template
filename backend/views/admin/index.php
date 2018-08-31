<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\widgets\LinkPager;

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
<div class="weadmin-nav">
			<span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">管理员管理</a>
        <a>
          <cite>管理员列表</cite></a>
      </span>
    <a class="layui-btn layui-btn-sm" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
</div>
<div class="weadmin-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 we-search" method="get" action="<?= Url::to(['admin/index']);?>">
            <div class="layui-inline">
                <input class="layui-input" placeholder="开始日" name="start" id="start" value="<?= Yii::$app->request->get('start');?>" />
            </div>
            <div class="layui-inline">
                <input class="layui-input" placeholder="截止日" name="end" id="end" value="<?= Yii::$app->request->get('end');?>" />
            </div>
            <div class="layui-inline">
                <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input" value="<?= Yii::$app->request->get('username')?>">
            </div>
            <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <div class="weadmin-block">
        <button class="layui-btn layui-btn-danger" onclick="delAll('<?= Url::to(['admin/batch-del'])?>')"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" id="add_admin"><i class="layui-icon"></i>添加</button>
        <span class="fr" style="line-height:40px">共有数据：<?= $count;?> 条</span>
    </div>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>登录名</th>
            <th>手机</th>
            <th>邮箱</th>
            <th>角色</th>
            <th>加入时间</th>
            <th>状态</th>
            <th>操作</th>
        </thead>
        <tbody>
        <?php foreach($list as $k=>$v){?>
        <tr>
            <td>
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<?= $v['id']?>'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td><?= $v['id']?></td>
            <td><?= $v['username']?></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= date('Y-m-d H:i:s',$v['created_at'])?></td>
            <td class="td-status">
                <span class="layui-btn layui-btn-normal layui-btn-xs <?php if(!$v['status']){echo 'layui-btn-disabled';}?>"><?= Html::encode($v['status']) > 0 ? '已启用' : '已停用';?></span></td>
            <td class="td-manage">
                <a href="javascript:;" class="start_clicks" title="启用" data-status="<?= Html::encode($v['updateStatus'])?>">
                    <i class="layui-icon">&#xe601;</i>
                </a>
                <a title="编辑" onclick="WeAdminShow('编辑','<?= Url::to(['admin/add?id='.$v['id']]);?>')" href="javascript:;">
                    <i class="layui-icon">&#xe642;</i>
                </a>
                <a title="删除" onclick="member_del(this,'<?= Url::to(['admin/del']);?>')" href="javascript:;">
                    <i class="layui-icon">&#xe640;</i>
                </a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="page">
        <div>
        <?= LinkPager::widget([
            'pagination' => $pages,
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'nextPageLabel' => false,
            'prevPageLabel' => false,
        ]); ?>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
<?php $this->beginBlock('admin_add_button') ?>
    var addurl = '<?= Url::to(['admin/add']);?>';
    var editurl = '<?= Url::to(['admin/edit-status']);?>';
    var csrfBackend = '<?= Yii::$app->request->csrfToken; ?>';
    layui.extend({
        admin: '<?= Url::to('@web/static/js/admin', true);?>'
    });
    layui.use(['form','layer','admin'], function(){
        var form = layui.form,
            admin = layui.admin,
            layer = layui.layer;
        $('#add_admin').click(function(){
            WeAdminShow('添加用户',addurl);
        });

        $('.start_clicks').click(function(){
            var values = $(this).attr('data-status');
            member_stop($(this),'10001',editurl,'status',values);
        });
    });
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['admin_add_button'], \yii\web\View::POS_END); ?>
<script src="<?= Url::to('@web/static/js/eleDel.js', true);?>" type="text/javascript" charset="utf-8"></script>
</html>
<?php $this->endPage() ?>