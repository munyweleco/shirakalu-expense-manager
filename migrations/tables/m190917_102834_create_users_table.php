<?php

use app\common\migration\BaseMigration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m190917_102834_create_users_table extends BaseMigration
{
    public string $tableName = '{{%users}}';
    public bool $addTimestamps = true;

    public function safeUp(): void
    {

        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(11),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'change_password' => $this->boolean()->defaultValue(true),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)
        ], $this->tableOptions);

    }

    public function safeDown(): void
    {
        $this->dropTable($this->tableName);
    }
}
