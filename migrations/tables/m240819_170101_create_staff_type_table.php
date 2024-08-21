<?php

use yii\db\Schema;

class m240819_170101_create_staff_type_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%staff_type}}';
    public bool $addTimestamps = true;

    public function up()
    {

        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(11),
            'staff_type' => $this->string(20)->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(1)
        ], $this->tableOptions);
        $this->batchInsert($this->tableName, ['id', 'staff_type', 'description'], [
            [1, 'OPERATOR', 'Machine operator'],
            [2, 'TURNBOY', 'Machine operator assistant'],
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
