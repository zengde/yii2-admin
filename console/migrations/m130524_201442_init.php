<?php

use yii\db\Migration;
use common\models\User;

class m130524_201442_init extends Migration
{
    public function up()
    {
		$auth=Yii::$app->authManager;
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'roleid' => $this->smallInteger(),
            'groupid' => $this->smallInteger(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'realname' => $this->string(),
            'phone' => $this->string(),
            'qq' => $this->string(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_ip' => $this->string(),
            'updated_ip' => $this->string(),
        ], $tableOptions);
		
		$user=new User();
		$model->setPassword('admin');
        $model->generateAuthKey();
		$model->roleid=$model::ROLE_ADMIN;
		if($model->save(false)){
			//分配角色
			$role = $auth->createRole('超级管理员'); //创建角色对象
			$auth->revokeAll($model['id']);//先删除已分配的
			$auth->assign($role, $model['id']);//添加对应关系
		}
		
		$this->createIndex(
            'idx-post_tag-post_id',
            'post_tag',
            'post_id'
        );
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
