<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2016/12/10 15:43
// +----------------------------------------------------------------------
// | TITLE: 角色
// +----------------------------------------------------------------------


namespace xing\ace\models;


class AdminRole extends \common\models\BaseActiveModel
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * 超级管理员分组
     */
    const ADMIN_ID = 1;

    public static $statusList = [
        1 => '开启',
        0 => '关闭',
    ];

    public static function tableName()
    {
        return 'admin_role';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['code', 'name', 'create_date', 'des','rule'];
        $scenarios[self::SCENARIO_UPDATE] = ['code', 'name', 'update_user', 'des', 'update_date', 'rule'];
        return $scenarios;

    }


    public function rules()
    {
        return [
            ['code', 'required', 'message' => '编号必须'],
            ['name', 'required', 'message' => '名称必须'],
            [['create_date', 'update_date'], 'safe'],
            ['update_date', 'default', 'value' => self::getDate()],
            ['create_date', 'default', 'value' => self::getDate()],
            [['code', 'name', 'create_user', 'update_user'], 'string', 'max' => 50],
            [['des'], 'string', 'max' => 400],
            ['rule', 'string',]
        ];

    }

    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'code' => '角色编号',
            'name' => '角色名称',
            'des' => '角色描述',
            'create_user' => '创建人',
            'create_date' => '创建时间',
            'update_user' => '更新人',
            'update_date' => '更新时间',
            'rule' => '权限',
            'status' => '状态',
        ];
    }

    public static function getDate()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * 转换状态
     * @param $status
     * @return mixed
     */
    public static function status_to_str($status)
    {
        return self::$statusList[$status];
    }

    /**
     * 删除角色
     * @param $id
     * @return bool
     */
    public static function deleteRole($id)
    {
        $model = self::findOne($id);
        if ($model) {
            $model->status = 0;
            $model->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取权限
     * @param int $id 用户角色
     * @param int $type 查询类型，1：所有类型权限，2只列出菜单权限
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRule($id,$type = '1')
    {
        $AdminRule = AdminRule::find();
        $AdminRule->where(['status' => 1]);
        $AdminRule->andWhere(['is_show' => 1]);
        $AdminRule->orderBy('order Asc');
        if ($type == '2'){ //如果是查询菜单，只列出权限菜单
            $AdminRule->andWhere(['in', 'type', [1,3]]);
        }
        if (self::ADMIN_ID != $id) {
            //更改用戶角色可以多选
            $ruleAll = AdminRole::find()->select('rule')->andWhere(['in','id',explode(',',$id)])->createCommand()->queryAll();
            $rule = implode(',',array_column($ruleAll,'rule'));
            $rule = explode(',',$rule);
            $AdminRule->andWhere(['in', 'id', $rule]);
//            echo $AdminRule->createCommand()->getRawSql();
//            die();
        }
        return $AdminRule->asArray()->all();
    }


}