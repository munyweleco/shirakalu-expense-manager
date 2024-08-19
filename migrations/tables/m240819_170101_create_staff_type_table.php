<?php

use yii\db\Schema;

class m240819_170101_create_staff_type_table extends \app\common\migration\BaseMigration
{
    public $tableName = '{{%staff_type}}';
    public bool $addTimestamps = true;

    public function up()
    {
        
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(20)->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->tinyint(1)->notNull()->defaultValue(1),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
