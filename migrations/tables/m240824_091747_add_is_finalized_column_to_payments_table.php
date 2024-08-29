<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payments}}`.
 */
class m240824_091747_add_is_finalized_column_to_payments_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%payments}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, column: 'is_finalized', type: $this->boolean()
            ->defaultValue(false)
            ->notNull()
            ->comment("Finalize payment")
            ->after('payment_date'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(table: $this->tableName, column: 'is_finalized');
    }
}
