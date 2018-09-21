<?php

use yii\db\Migration;

/**
 * Class m180921_122136_monitoring
 */
class m180921_122136_monitoring extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('monitoring', [
            'id' => $this->primaryKey(),
            'message' => $this->string(255)->comment('Сообщение события'),
            'status' => $this->string(10)->comment('Статус события'),
            'data' => $this->text()->comment('Вспомагательная информация JSON'),
            'priority' => $this->integer(2)->comment('Приоритет события'),
            'creationDate' => $this->timestamp()->comment('Дата создания события'),
            'userId' => $this->integer()->comment('Идентификатор юзера, который инициировал событие')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('monitoring');
    }
}
