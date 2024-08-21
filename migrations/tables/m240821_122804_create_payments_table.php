<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payments}}`.
 */
class m240821_122804_create_payments_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%payments}}';
    public bool $addTimestamps = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(table: $this->tableName, columns: [
            'id' => $this->bigPrimaryKey(11),
            'staff_id' => $this->bigInteger(11)->notNull(),
            'operation_id' => $this->bigInteger(11)->notNull(),
            'rate' => $this->decimal(10, 2)->notNull(),
            'acres' => $this->decimal(10, 2)->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'payment_date' => $this->date()->notNull(),
        ], options: $this->tableOptions);

        // Add foreign keys
        $this->addForeignKey(
            name: 'fk-payments-staff-id',
            table: $this->tableName,
            columns: 'staff_id',
            refTable: '{{%staff}}',
            refColumns: 'id',
            delete: 'RESTRICT',
            update: 'CASCADE'
        );

        $this->addForeignKey(
            name: 'fk-payments-operation-id',
            table: $this->tableName,
            columns: 'operation_id',
            refTable: '{{%operations}}',
            refColumns: 'id',
            delete: 'CASCADE',
            update: 'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(name: 'fk-payments-staff-id', table: $this->tableName);
        $this->dropForeignKey(name: 'fk-payments-operation-id', table: $this->tableName);
        $this->dropTable(table: $this->tableName);
    }
}
