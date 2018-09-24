<?php

use yii\db\Migration;

/**
 * Class m180924_123042_monitoring_user
 */
class m180924_123042_monitoring_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('monitoring_user', [
            'id' => $this->primaryKey(),
            'lastname' => $this->string(50)->comment('Фамилия'),
            'firstname' => $this->string(50)->comment('Имя'),
            'middlename' => $this->string(50)->comment('Отчество'),
            'email' => $this->string(50)->comment('Электронная почта'),
            'telegram' => $this->string(50)->comment('Телеграм'),
            'creationDate' => $this->timestamp()->comment('Дата создания')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('monitoring_user');
    }
}
