<?php

use yii\db\Migration;

/**
 * Class m180924_124210_monitoring_command
 */
class m180924_124210_monitoring_command extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('monitoring_command', [
            'id' => $this->primaryKey(),
            'command' => $this->string(255)->comment('Путь команды'),
            'description' => $this->string(255)->comment('Описание команды'),
            'creationDate' => $this->timestamp()->comment('Дата создания')
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('monitoring_command');
    }
}
