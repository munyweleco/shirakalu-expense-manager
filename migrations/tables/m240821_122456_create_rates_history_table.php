<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rates_history}}`.
 */
class m240821_122456_create_rates_history_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%rates_history}}';
    public bool $addTimestamps = true;
    public string $operationTable = '{{%operations}}';
    public string $staffTypeTable = '{{%staff_type}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(11),
            'operation_id' => $this->bigInteger(11)->notNull(),
            'role_id' => $this->bigInteger(11)->notNull(),
            'rate' => $this->decimal(10, 2)->notNull(),
            'effective_date' => $this->date()->notNull(),
            'unit' => $this->string(10)->notNull()->defaultValue('acre'),
            'description' => $this->string(100),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-rates-history-operation-id',
            $this->tableName,
            'operation_id',
            $this->operationTable,
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-rates-history-role-id',
            $this->tableName,
            'role_id',
            $this->staffTypeTable,
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk-rates-history-operation-id', $this->tableName);
        $this->dropForeignKey('fk-rates-history-role-id', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
