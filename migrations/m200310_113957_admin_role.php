<?php

use yii\db\Migration;

/**
 * Class m200310_113957_admin_role
 */
class m200310_113957_admin_role extends Migration
{
    /**
     * @var string 定义表名
     */
    private $table = '{{%admin_role}}';
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB comment "角色表"';
        }

        // 创建表
        $this->createTable($this->table, [
            'id'         => $this->primaryKey()->notNull()->comment('主键'),
            'code'        => $this->string(50)->notNull()->comment('角色编号(只支持两级)'),
            'name'  => $this->string(50)->notNull()->comment('角色名称'),
            'des'      => $this->string(400)->comment('角色描述'),
            'create_user'        => $this->string(50)->comment('创建人'),
            'create_date'     => $this->dateTime()->comment('创建时间'),
            'update_user'       => $this->string(50)->comment('更新人'),
            'update_date' => $this->dateTime()->comment('更新时间'),
            'status' => $this->integer(1)->comment('状态，1正常，0为已删除'),
            'rule' => $this->text()->comment('权限'),
        ], $tableOptions);


        $this->insert($this->table, [
            'code'        => '001',
            'name'  => '超级管理员',
            'des'        => 'admins',
            'status'       => 1,
        ]);


        $this->insert($this->table, [
            'code'        => '002',
            'name'  => '普通管理员',
            'status'       => 1,
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200310_113957_admin_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200310_113957_admin_role cannot be reverted.\n";

        return false;
    }
    */
}
