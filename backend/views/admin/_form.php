<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Ad */
?>
<form class="layui-form">
    <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken; ?>">
    <input type="hidden" name="id" value="<?= !empty($data) ? $data['id'] : 0;?>">
    <div class="layui-form-item">
        <label for="username" class="layui-form-label">
            <span class="we-red">*</span>登录名
        </label>
        <div class="layui-input-inline">
            <input type="text" id="username" name="username" required="" lay-verify="required"
                   autocomplete="off" class="layui-input" value="<?= !empty($data) ? $data['username'] : '';?>">
        </div>
        <div class="layui-form-mid layui-word-aux">
            <span class="we-red">*</span>将会成为您唯一的登入名
        </div>
    </div>
    <!--<div class="layui-form-item">
        <label for="phone" class="layui-form-label">
            <span class="we-red">*</span>手机
        </label>
        <div class="layui-input-inline">
            <input type="text" id="phone" name="phone" required="" lay-verify="phone"
                   autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">
            <span class="we-red">*</span>将会成为您唯一的登入名
        </div>
    </div>
    <div class="layui-form-item">
        <label for="L_email" class="layui-form-label">
            <span class="we-red">*</span>邮箱
        </label>
        <div class="layui-input-inline">
            <input type="text" id="L_email" name="email" required="" lay-verify="email"
                   autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">
            <span class="we-red">*</span>
        </div>
    </div>-->
    <!--<div class="layui-form-item">
        <label class="layui-form-label"><span class="we-red">*</span>角色</label>
        <div class="layui-input-block">
            <input type="checkbox" name="like1[write]" lay-skin="primary" title="超级管理员" checked="">
            <input type="checkbox" name="like1[read]" lay-skin="primary" title="编辑人员">
            <input type="checkbox" name="like1[write]" lay-skin="primary" title="宣传人员" checked="">
        </div>
    </div>-->
    <div class="layui-form-item">
        <label for="L_pass" class="layui-form-label">
            <span class="we-red">*</span>密码
        </label>
        <div class="layui-input-inline">
            <input type="password" id="L_pass" name="password" required="" lay-verify="pass"
                   autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">
            <?php
                if(!empty($data)){
                    echo '不修改密码的时候留空,否则请填6到16个字符';
                }else {
                    echo '6到16个字符';
                }
            ?>

        </div>
    </div>
    <div class="layui-form-item">
        <label for="L_repass" class="layui-form-label">
            <span class="we-red">*</span>确认密码
        </label>
        <div class="layui-input-inline">
            <input type="password" id="L_repass" name="repassword" required="" lay-verify="repass"
                   autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label for="L_repass" class="layui-form-label"></label>
        <button  class="layui-btn" lay-filter="add" lay-submit="" type="button">增加</button>
    </div>
</form>