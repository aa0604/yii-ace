<?php
namespace common\models\admin;

use Yii;


/**
 * Login form
 */
class LoginForm extends \common\models\BaseActiveModel
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;

    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required','message'=>'{attribute}必须'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean', 'message'=>'rememberMe'],
            // password is validated by validatePassword()
            ['password', 'validatePassword', 'message'=>'password'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码不正确');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = AdminUser::findByUsername($this->username);
        }

        return $this->_user;
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '登录用户名',
            'password' => '密码',
        ];
    }
}
