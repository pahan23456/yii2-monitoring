<?php

use yii\db\Migration;

/**
 * Class m180921_122136_monitoring
 */
class m180921_122136_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('monitoring_detail', [
            'id' => $this->primaryKey(),
            'message' => $this->string(255)->comment('Сообщение события'),
            'status' => $this->string(10)->comment('Статус события'),
            'data' => $this->text()->comment('Вспомагательная информация JSON'),
            'creationDate' => $this->timestamp()->comment('Дата создания события'),
            'userId' => $this->integer()->comment('Идентификатор юзера, который инициировал событие'),
            'commandId' => $this->integer()->comment('Идентификатор выполняемой команды'),
            'eventId' => $this->integer()->comment('Идентификатор события')
        ]);

        $this->createTable('monitoring_user', [
            'id' => $this->primaryKey(),
            'lastname' => $this->string(50)->comment('Фамилия'),
            'firstname' => $this->string(50)->comment('Имя'),
            'middlename' => $this->string(50)->comment('Отчество'),
            'email' => $this->string(50)->comment('Электронная почта'),
            'telegram' => $this->string(50)->comment('Телеграм'),
            'creationDate' => $this->timestamp()->comment('Дата создания')
        ]);

        $this->createTable('monitoring_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->comment('Название группы'),
            'description' => $this->string(255)->comment('Описание группы'),
            'creationDate' => $this->timestamp()->comment('Дата создания')
        ]);

        $this->createTable('monitoring_command', [
            'id' => $this->primaryKey(),
            'command' => $this->string(255)->comment('Путь команды'),
            'description' => $this->string(255)->comment('Описание команды'),
            'creationDate' => $this->timestamp()->comment('Дата создания')
        ]);
        
        $this->createIndex('idx_monitoring_detail_commandId', 'monitoring_detail', 'commandId');
        $this->addForeignKey('fk_monitoring_detail_commandId', 'monitoring_detail', 'commandId',
            'monitoring_command',
            'id',
            'CASCADE',
            'CASCADE');

        $this->createTable('monitoring_user_command_group',[
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->comment('Идентификатор пользователя'),
            'commandId' => $this->integer()->comment('Идентификатор команды'),
            'groupId' => $this->integer()->comment('Идентификатор группы'),
            'creationDate' => $this->timestamp()->comment('Дата создания')
        ]);

        $this->createIndex('idx_monitoring_user_command_group_userId', 'monitoring_user_command_group', 'userId');
        $this->createIndex('idx_monitoring_user_command_group_commandId', 'monitoring_user_command_group', 'commandId');
        $this->createIndex('idx_monitoring_user_command_group_groupId', 'monitoring_user_command_group', 'groupId');

        $this->addForeignKey('fk_monitoring_user_command_group_userId', 'monitoring_user_command_group', 'userId',
            'monitoring_user',
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey('fk_monitoring_user_command_group_commandId', 'monitoring_user_command_group', 'commandId',
            'monitoring_command',
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey('fk_monitoring_user_command_group_groupId', 'monitoring_user_command_group', 'groupId',
            'monitoring_group',
            'id',
            'CASCADE',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('monitoring_detail');
        $this->dropTable('monitoring_user');
        $this->dropTable('monitoring_group');
        $this->dropTable('monitoring_command');
        $this->dropForeignKey('fk_monitoring_user_command_group_userId', 'monitoring_user_command_group');
        $this->dropForeignKey('fk_monitoring_user_command_group_commandId', 'monitoring_user_command_group');
        $this->dropForeignKey('fk_monitoring_user_command_group_groupId', 'monitoring_user_command_group');

        $this->dropIndex('idx_monitoring_user_command_group_userId', 'monitoring_user_command_group');
        $this->dropIndex('idx_monitoring_user_command_group_commandId', 'monitoring_user_command_group');
        $this->dropIndex('idx_monitoring_user_command_group_groupId', 'monitoring_user_command_group');

        $this->dropTable('monitoring_user_command_group');
    }
}
