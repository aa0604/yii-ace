<?php

use yii\db\Migration;

/**
 * Class m200310_114148_admin_user
 */
class m200310_114148_admin_user extends Migration
{
    /**
     * @var string 定义表名
     */
    private $table = '{{%admin_user}}';
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB comment "新后台用户表"';
        }

        // 创建表
        $this->createTable($this->table, [
            'id'        => $this->primaryKey()->notNull()->comment('主键'),
            'username'  => $this->string(255)->comment('用户名'),
            'auth_key'  => $this->string(32)->comment('盐'),
            'password_hash'     => $this->string(255)->comment('密码'),
            'password_reset_token'      => $this->string(255)->comment('重置密码密钥'),
            'email'     => $this->string(255)->comment('邮件'),
            'timezone'  => $this->string(300)->comment('时区，默认8区，东八区，北京/上海'),
            'created_at'=> $this->integer(11)->comment('创建时间'),
            'updated_at'=> $this->text()->comment('提示'),
            'role_id'   => $this->integer(1)->comment('是否显示'),
            'status'    => $this->integer(1)->comment('状态,1 启用 0禁用'),
            'mobile'    => $this->string(15)->comment('手机'),
            'code'      => $this->string(30)->comment('业务员推荐码'),
        ], $tableOptions);


        $this->insert($this->table, [
            'username'  => 'admin',
            'password_hash'     => '$2y$13$iJgThDdz54qxpr.HrK./Bec8LdRCeLWQTasA/pxiZCo7HiwKrfwIy',
            'mobile'      => '13600000000',
            'status'    => 1,
            'role_id' => 1,
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200310_114148_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200310_114148_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
