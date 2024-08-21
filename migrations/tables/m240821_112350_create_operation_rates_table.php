<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operation_rates}}`.
 */
class m240821_112350_create_operation_rates_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%operation_rates}}';
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
            'fk-operation-rates-operation-id',
            $this->tableName,
            'operation_id',
            $this->operationTable,
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-operation-rates-role-id',
            $this->tableName,
            'role_id',
            $this->staffTypeTable,
            'id',
            'RESTRICT',
            'CASCADE'
        );

        // Insert initial data into operation_rates table
        $effectiveDate = new \yii\db\Expression('NOW()');
        $this->batchInsert($this->tableName, ['operation_id', 'role_id', 'rate', 'effective_date', 'description'], [
            [1, 1, 250.00, $effectiveDate, 'Ploughing rate for Operator'], // Ploughing rate for Operator
            [2, 1, 200.00, $effectiveDate, 'Harrowing rate for Operator'], // Harrowing rate for Operator
            [3, 1, 150.00, $effectiveDate, 'Furrowing rate for Operator'], // Furrowing rate for Operator
            [4, 1, 150.00, $effectiveDate, 'Transport rate for Operator'], // Transport rate for Operator

            [1, 2, 100.00, $effectiveDate, 'Ploughing rate for Turnboy'], // Ploughing rate for Turnboy
            [2, 2, 100.00, $effectiveDate, 'Harrowing rate for Turnboy'],  // Harrowing rate for Turnboy
            [3, 2, 50.00, $effectiveDate, 'Furrowing rate for Turnboy'],  // Furrowing rate for Turnboy
            [4, 2, 50.00, $effectiveDate, 'Transport rate for Turnboy'], // Transport rate for Turnboy


        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk-operation-rates-operation-id', $this->tableName);
        $this->dropForeignKey('fk-operation-rates-role-id', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
