<?php

use yii\db\Migration;

/**
 * Class m200310_114058_admin_rule
 */
class m200310_114058_admin_rule extends Migration
{

    /**
     * @var string 定义表名
     */
    private $table = '{{%admin_rule}}';
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB comment "路由权限表"';
        }

        // 创建表
        $this->createTable($this->table, [
            'id'        => $this->primaryKey()->notNull()->comment('主键'),
            'pid'       => $this->integer(11)->comment('上级id'),
            'route'     => $this->string(80)->comment('路由'),
            'title'     => $this->string(20)->comment('名称'),
            'icon'      => $this->string(255)->comment('图标'),
            'type'      => $this->integer(1)->comment('类型'),
            'condition' => $this->string(300)->comment('描述'),
            'order'     => $this->integer(11)->comment('排序'),
            'tips'      => $this->text()->comment('提示'),
            'is_show'   => $this->integer(1)->comment('是否显示'),
            'status'    => $this->integer(1)->comment('状态'),
        ], $tableOptions);



        $this->insert($this->table, [
            'pid'       => 0,
            'title'     => '系统管理',
            'route'     => '',
            'icon'      => 'glyphicon glyphicon-cog blue ',
            'condition' => '权限列表',
            'type'      => 1,
            'is_show'   => 1,
            'status'    => 1
        ]);

        $this->insert($this->table, [
            'pid'       => 1,
            'title'     => '权限列表',
            'route'     => 'admin/admin-rule/index',
            'icon'      => 'glyphicon glyphicon-cog blue ',
            'type'      => 1,
            'is_show'   => 1,
            'status'    => 1
        ]);

        $this->insert($this->table, [
            'pid'       => 1,
            'title'     => '管理员列表',
            'route'     => 'admin/admin-user/index',
            'icon'      => 'glyphicon glyphicon-user ',
            'type'      => 1,
            'is_show'   => 1,
            'status'    => 1
        ]);

        $this->insert($this->table, [
            'pid'       => 1,
            'title'     => '角色列表',
            'route'     => 'admin/admin-role/index',
            'icon'      => 'glyphicon glyphicon-th',
            'type'      => 1,
            'is_show'   => 1,
            'status'    => 1
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200310_114058_admin_rule cannot be reverted.\n";
        $this->dropTable($this->table);
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200310_114058_admin_rule cannot be reverted.\n";

        return false;
    }
    */
}
