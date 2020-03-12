<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model xing\ace\models\AdminRule */

$this->title = '增加Admin Rule';
$this->params['breadcrumbs'][] = ['label' => '权限', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-rule-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
