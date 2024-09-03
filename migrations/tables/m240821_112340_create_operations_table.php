<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operations}}`.
 */
class m240821_112340_create_operations_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%operations}}';
    public bool $addTimestamps = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(11),
            'name' => $this->string(30)->notNull(),
            'description' => $this->text(),
        ], $this->tableOptions);

        $this->batchInsert($this->tableName, ['id', 'name', 'description'], [
            [1, 'PLOUGHING', 'Preparation of soil by mechanical agitation.'],
            [2, 'HARROWING', 'Breaking up and smoothing out the surface of the soil.'],
            [3, 'FURROWING', 'Creating furrows for planting.'],
            [4, 'TRANSPORT', 'Moving goods or equipment from one location to another.'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable($this->tableName);
    }
}
