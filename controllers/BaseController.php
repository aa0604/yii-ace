<?php


namespace xing\ace\controllers;


use xing\ace\traits\RbacTrait;

class BaseController extends \yii\web\Controller
{

    use RbacTrait;

    public $layout = '@xing/ace/views/layouts/main';
}