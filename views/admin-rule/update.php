<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model xing\ace\models\AdminRule */

$this->title = '修改Admin Rule: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '权限', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="admin-rule-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
