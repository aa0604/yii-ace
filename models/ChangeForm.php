<?php
/**
 * Created by PhpStorm.
 * User: liyuping
 * Date: 15/6/22
 * Time: 下午6:11
 */

namespace xing\ace\models;

use Yii;
use yii\base\Model;

class ChangeForm extends Model
{
    public $original;
    public $password;
    public $password_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['original', 'password', 'password_repeat'], 'required'],
            [['original', 'password', 'password_repeat'], 'string', 'max' => 20],
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'original' => '原密码',
            'password' => '密码',
            'password_repeat' => '重复密码',
        ];
    }

}
