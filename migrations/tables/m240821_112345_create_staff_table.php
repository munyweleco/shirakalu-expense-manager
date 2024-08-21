<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%people}}`.
 */
class m240821_112345_create_staff_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%staff}}';
    public string $refTable = '{{%staff_type}}';
    public string $fkName = 'fk-staff-role-id';
    public bool $addTimestamps = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(table: $this->tableName, columns: [
            'id' => $this->bigPrimaryKey(11),
            'staff_name' => $this->string(100)->notNull(),
            'staff_role_id' => $this->bigInteger(11)->notNull(),
        ], options: $this->tableOptions);

        $this->addForeignKey(
            name: $this->fkName,
            table: $this->tableName,
            columns: 'staff_role_id',
            refTable: $this->refTable,
            refColumns: 'id',
            delete: 'RESTRICT',
            update: 'CASCADE'
        );

        $this->batchInsert($this->tableName, ['id', 'staff_name', 'staff_role_id'], [
            [1, 'Anthony', 1],
            [2, 'Francis', 1],
            [3, 'Alex', 2],
            [4, 'Timothy', 2],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(name: $this->fkName, table: $this->tableName);
        $this->dropTable(table: $this->tableName);
    }
}
