<?php

use yii\db\Migration;

/**
 * Class m180924_123742_monitoring_group
 */
class m180924_123742_monitoring_group extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('monitoring_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->comment('Название группы'),
            'description' => $this->string(255)->comment('Описание группы'),
            'creationDate' => $this->timestamp()->comment('Дата создания')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('monitoring_group');
    }
}
