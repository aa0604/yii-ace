<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2016/12/10 15:36
// +----------------------------------------------------------------------
// | TITLE: 用户
// +----------------------------------------------------------------------


namespace xing\ace\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;


class AdminUser extends \common\models\BaseActiveModel implements IdentityInterface
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * 用户修改
     */
    const SCENARIO_USER_UPDATE = 'user_update';

    /**
     * 用户状态
     */
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public $password;

    public function rules()
    {
        return [
            ['username', 'required', 'message' => '名称必须'],
            [['auth_key', 'password_hash', 'password_reset_token'], 'string', 'max' => 400],
            [['created_at', 'updated_at', 'role_id'], 'safe'],
            ['created_at', 'default', 'value' => self::getDate()],
            ['updated_at', 'default', 'value' => self::getDate()],
            ['email', 'email', 'message' => '请填写正确邮箱格式'],
            ['mobile', 'string', 'max' => 15],
            ['mobile', 'match','pattern'=>'/^1[3|4|5|7|8|][0-9]{9}$/','message'=>'{attribute}不是正确的手机号'],
            ['username', 'string', 'max' => 10, 'min' => 2],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];

    }

    public static function tableName()
    {
        return '{{%admin_user}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] =
            [
                'username',
                'auth_key',
                'password_hash',
                'password_reset_token',
                'email',
                'code',
                'created_at',
                'status',
                'role_id',
                'mobile'
            ];

        $scenarios[self::SCENARIO_UPDATE] =
            [
                'username',
                'auth_key',
                'password_hash',
                'password_reset_token',
                'email',
                'created_at',
                'status',
                'role_id',
                'mobile'
            ];
        $scenarios[self::SCENARIO_USER_UPDATE] = [
            'password_hash',
            'email',
            'mobile'
        ];
        return $scenarios;

    }

    public function attributeLabels()
    {

        return [
            'id' => '主键',
            'role_id' => '角色',
            'username' => '用户名称',
            'email' => '邮箱',
            'mobile' => '手机号',
            'status' => '状态',

        ];


    }

    public function attributeValues()
    {
        return [
            'status' => [
                '0' => '停用',
                '1' => '正常',
            ]
        ];

    }

    public static function getDate()
    {
        return date('Y-m-d H:i:s');
    }

    public static function deleteUser($id)
    {
        $model = self::findOne($id);
        if ($model) {
            $model->scenarios(self::SCENARIO_UPDATE);
            $model->status = self::STATUS_DELETED;
            $model->save();
            return ($model->save()) ? true : false;
        } else {
            return false;
        }
    }

    /**
     * 获取用户角色
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getAdminRole()
    {
        return $this->hasOne(AdminRole::className(), ['id' => 'role_id'])->asArray()->one();
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}