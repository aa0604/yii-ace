<?php
namespace xing\ace\controllers;

use xing\ace\models\Menu;
use xing\ace\helper\Tree;
use xing\ace\logic\AdminRuleLogic;
use xing\ace\models\AdminRole;
use xing\ace\models\AdminRule;
use xing\ace\models\ChangeForm;
use xing\ace\models\AdminUser;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use xing\ace\models\LoginForm;
use xing\ace\models\PasswordResetRequestForm;
use xing\ace\models\ResetPasswordForm;
use xing\ace\models\SignupForm;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $layout = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user'  => ArrayHelper::getValue($this->module, 'user'),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => [
                            'logout', 'index', 'system',
                            'update', 'create', 'switch-login',
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
//        $this->layout = false;
        $menu = AdminRuleLogic::getNav(Yii::$app->user->identity->role_id);
//        $menu = AdminRole::buildNav($menu);
        return $this->render('index',['menu' => $menu]);
    }

    /**
     * 显示首页系统信息
     *
     * @return string
     */
    public function actionSystem()
    {
        // 获取用户信息
        return $this->render('system', [
            'yii'    => Yii::getVersion(),                         // Yii 版本
            'upload' => ini_get('upload_max_filesize'),             // 上传文件大小,
            'user'   => Yii::$app->user->identity,
        ]);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
//    public function actionSignup()
//    {
//        $model = new SignupForm();
//        if ($model->load(Yii::$app->request->post())) {
//            if ($user = $model->signup()) {
//                if (Yii::$app->getUser()->login($user)) {
//                    return $this->goHome();
//                }
//            }
//        }
//
//        return $this->render('signup', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionChangePass()
    {
        $model = new ChangeForm();
        if($model->load(Yii::$app->request->post()))
        {
            $user = AdminUser::getByPK(Yii::$app->user->id);
            if((md5($model->original) === $user->password))
            {
                if($model->validate())
                {
                    $user->password = md5($model->password);
                    if($user->save())
                        return $this->render('success');
                }
            }
            else
                $model->addError('original', '原密码错误');
        }

        return $this->render('change', ['model'=>$model]);
    }
}
