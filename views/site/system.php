<?php

use yii\helpers\ArrayHelper;
$this->title = '登录信息';
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 text-center">
        <h4 class="blue">
            <span class="middle"><i class="ace-icon glyphicon glyphicon-user light-blue bigger-110"></i></span>
            欢迎登陆后台管理系统
        </h4>
        <div class="profile-user-info">
            <div class="profile-info-row">
                <div class="profile-info-name"> 账号</div>
                <div class="profile-info-value">
                    <span><?= $user->username ?></span>
                </div>
            </div>
            <!--<div class="profile-info-row">
                <div class="profile-info-name"> 角色</div>
                <div class="profile-info-value">
                    <span>
                        <?php
/*                        $roles = Yii::$app->authManager->getRolesByUser($user->id);
                        echo implode(',', array_keys($roles));
                        */?>
                    </span>
                </div>
            </div>-->
        </div>
        <div class="hr hr16 dotted"></div>
        <?php if (ArrayHelper::getValue(Yii::$app->params, 'project_open_other')) : ?>
            <h4 class="blue">
                <span class="middle"><i class="fa fa-desktop light-blue bigger-110"></i></span>
                其他信息
            </h4>

            <div class="profile-user-info">
                <div class="profile-info-row">
                    <div class="profile-info-name"> 版本</div>
                    <div class="profile-info-value">
                        <span><?= $yii ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> 上传文件</div>
                    <div class="profile-info-value">
                        <span><?= $upload ?></span>
                    </div>
                </div>
            </div>
            <div class="hr hr-8 dotted"></div>
            <div class="profile-user-info">
                <div class="profile-info-row">
                    <div class="profile-info-name">
                        <i class="fa fa-github-square" aria-hidden="true"></i>
                        GitHub
                    </div>
                    <div class="profile-info-value">
                        <a href="https://github.com/myloveGy" target="_blank">https://github.com/aa0604</a>
                    </div>
                </div>
            </div>

            <div class="hr hr16 dotted"></div>
        <?php endif; ?>
    </div>
</div>