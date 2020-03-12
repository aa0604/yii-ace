<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel xing\ace\models\AdminRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '权限';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-rule-index form-inline">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('增加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 不显示搜索框 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($data) {
                    return '<i class="'. $data->icon .'"></i> ' . $data->title;
                }
            ],
            'route',
            [
                'attribute' => 'type',
                'value' => function($data) {
                    return \xing\ace\map\AdminRuleMap::$type[$data->type] ?? '未知';
                }
            ],
//            'pid',
//            'icon',
            //'condition',
            'order',
//            'tips:ntext',
            [
                'attribute' => 'is_show',
                'value' => function($data) {
                    return $data->is_show ? '显示' : '隐藏';
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->status ? '启用' : '禁用';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>