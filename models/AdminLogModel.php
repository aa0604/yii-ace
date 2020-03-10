<?php

namespace xing\ace\models;

use Yii;

/**
 * This is the model class for table "{{%admin_log}}".
 *
 * @property string $id
 * @property integer $level
 * @property integer $status
 * @property string $path
 * @property string $category
 * @property string $message
 * @property string $userip
 * @property string $user_name
 * @property string $create_time
 */
class AdminLogModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'status', 'create_time'], 'integer'],
            [['message', 'create_time'], 'required'],
            [['message'], 'string'],
            [['path', 'user_name'], 'string', 'max' => 255],
            [['category'], 'string', 'max' => 50],
            [['userip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => '0普通 1 ..  2..',
            'status' => '存在审批的话，0 不通过  1 通过 3 没有',
            'path' => '请求路径',
            'category' => '日志标题',
            'message' => '记录的数据',
            'userip' => '请求ip，不存在为空',
            'user_name' => '操作用户',
            'create_time' => '记录创建时间(UNXIX时间戳)',
        ];
    }
}
