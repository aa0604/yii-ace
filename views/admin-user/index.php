<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel xing\ace\models\AdminUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="love-user-index form-inline">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('增加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 不显示搜索框 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'mobile',
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->status ? '启用' : '禁用';
                }
            ],
            [
                'attribute' => 'role_id',
                'value' => function($data) {

                    $roleids = explode(',',$data->role_id);
                    $role = \xing\ace\models\AdminRole::find()->andWhere(['in', 'id', $roleids])->all();
                    return implode(',',array_column($role,'name'));
                }
            ],
//            'password_reset_token',
            //'email:email',
            //'timezone:datetime',
            //'status',
            //'created_at',
            //'updated_at',
            //'role_id',
            //'mobile',
            //'code',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

