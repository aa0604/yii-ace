<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2017/1/4 16:32
// +----------------------------------------------------------------------
// | TITLE: this to do?
// +----------------------------------------------------------------------


namespace xing\ace\traits;

use xing\ace\models\AdminRole;
use Yii;
use yii\helpers\ArrayHelper;


trait RbacTrait
{
    /**
     * 放行路由
     * @var array
     */
    public $allowUrl = [
        'site/logout',
        'site/login',
        'index/index',
        'index/main'
    ];

    /**
     * 验证
     * @param string $route 当前路由
     * @param int $type  放回类型，如果是 1 返回bool  2 返回数组
     * @return mixed
     */
    public function verifyRule($route,$type = "1")
    {
        $this->allowUrl = array_merge(Yii::$app->params['allowUrl'] ?? [], $this->allowUrl);
        if (Yii::$app->user->identity->role_id == AdminRole::ADMIN_ID) return true; //如果是超级管理员登录
        $rules = AdminRole::getRule(Yii::$app->user->identity->role_id);
        $rules = ArrayHelper::map($rules, 'id', 'route');
        $rules = array_merge($rules, $this->allowUrl);
        if ($type == "2"){
            return $rules;
        }else{
            return in_array($route, $rules);
        }
    }


}