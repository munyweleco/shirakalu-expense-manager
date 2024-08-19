<?php

use yii\db\Schema;

class m240819_170100_create_users_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%users}}';
    public bool $addTimestamps = true;

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'username' => $this->string(20)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'email_verified_at' => $this->timestamp(),
            'password' => $this->string(255)->notNull(),
            'remember_token' => $this->string(100)
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
