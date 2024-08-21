<?php

use yii\db\Schema;

class m240819_170101_create_staff_type_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%staff_type}}';
    public bool $addTimestamps = true;

    public function up()
    {

        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'staff_type' => $this->string(20)->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(1)
        ], $this->tableOptions);

        $this->insert($this->tableName, ['staff_type' => 'OPERATOR', 'description' => 'Machine operator']);
        $this->insert($this->tableName, ['staff_type' => 'TURNBOY', 'description' => 'Machine operator assistant']);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
