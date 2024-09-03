<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%app_cache}}`.
 */
class m210505_074508_create_app_cache_table extends \app\common\migration\BaseMigration
{
    public string $tableName = '{{%app_cache}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->char(80),
            'expire' => $this->integer(11),
            'data' => $this->text(),
        ]);

        $this->addPrimaryKey('pk-cache-id', $this->tableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk-cache-id', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
