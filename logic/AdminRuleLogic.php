<?php

namespace xing\ace\logic;

use xing\ace\helper\TreeHelper;
use xing\ace\models\AdminRole;
use xing\ace\models\AdminRule;

class AdminRuleLogic
{



    public static function getNav($roleId)
    {

        $AdminRule = AdminRule::find();
        $AdminRule->where(['pid' => 0, 'status' => 1, 'is_show' => 1, 'type' => [1, 3]])->orderBy('order Asc');
        if (AdminRole::ADMIN_ID != $roleId) {
            $rule = AdminRole::findOne($roleId);
            $AdminRule->andWhere(['id' => explode(',', $rule->rule)]);
        }
        $list = $AdminRule->all();

        $navs = [];
        foreach ($list as $v) {
            $navs[] = static::data2array($v);
        }
        return $navs;
    }

    private static function getChilNav($parentId)
    {
        if (is_null($parentId)) return [];
        $list = AdminRule::readList($parentId);
        $navs = [];
        foreach ($list as $v) {
            $navs[] = static::data2array($v);
        }
        return $navs;
    }

    private static function data2array(AdminRule $adminRule, $level = 1)
    {
        return [
            'id' => $adminRule->id,
            'label' => $adminRule->title,
            'url' => $adminRule->route,
            '_level' => $level,
            'items' => static::getChilNav($adminRule->id, $level + 1),
        ];
    }
}