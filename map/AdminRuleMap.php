<?php
/**
 * Created by PhpStorm.
 * User: xing.chen
 * Date: 2018/9/18
 * Time: 13:00
 */

namespace xing\ace\map;


class AdminRuleMap
{

    public static $type = [
        '1' => '权限和菜单',
        '2' => '权限',
        '3' => '菜单',
    ];

    public static $status = [
        0 => '关闭',
        1 => '开启'
    ];

    public static $is_show = [
        0 => '隐藏',
        1 => '显示'
    ];
}