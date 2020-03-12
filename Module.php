<?php

namespace xing\ace;

use xing\ace\traits\JsonTrait;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UnauthorizedHttpException;

/**
 * ace module definition class
 */
class Module extends \yii\base\Module
{
    use JsonTrait;
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'xing\ace\controllers';

    /**
     * @var string 定义使用布局
     */
    public $layout = '@xing/ace/views/layouts/main';

    /**
     * @var array 不验证的控制器名称
     */
    public $allowControllers = ['site'];

    /**
     * @var bool 权限验证
     */
    public $verifyAuthority = true;

    /**
     * @var bool 左边头部按钮
     */
    public $leftTopButtons = [
    ];

    /**
     * @var array 用户点击相关按钮
     */
    public $userLinks = [
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // 资源处理
        Yii::$app->assetManager->bundles = [
            // 去掉自己的bootstrap 资源
            'yii\bootstrap\BootstrapAsset' => [
                'css' => []
            ],
            // 去掉自己加载的Jquery
            'yii\web\JqueryAsset'          => [
                'sourcePath' => null,
                'js'         => [],
            ],
        ];

        // 设置错误处理页面
        Yii::$app->errorHandler->errorAction = $this->getUniqueId() . '/site/error';
        if (!isset(Yii::$app->i18n->translations['admin'])) {
            Yii::$app->i18n->translations['admin'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath'       => '@xing/ace/messages'
            ];
        }
    }

    /**
     * @param \yii\base\Action $action
     *
     * @return bool|\yii\console\Response|\yii\web\Response
     * @throws UnauthorizedHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeAction($action)
    {
        // 不验证权限和用户登录
        if (in_array($action->controller->id, $this->allowControllers)) {
            return parent::beforeAction($action);
        }

        // 验证用户登录
        if (Yii::$app->user->getIsGuest()) {
            return Yii::$app->response->redirect(Url::toRoute('admin/site/login'));
        }

        // 验证权
        if ($this->verifyAuthority && !Yii::$app->get($this->user)->can($action->getUniqueId())) {
            // 没有权限AJAX返回
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->content = Json::encode($this->error(216));
                return false;
            }

            throw new UnauthorizedHttpException('对不起，您现在还没获得该操作的权限!');
        }

        return true;
    }

    /**
     * 获取登录用户
     *
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public function getUser()
    {
        return Yii::$app->user->identity;
    }

}
