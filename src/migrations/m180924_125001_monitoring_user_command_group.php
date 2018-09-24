<?php

use yii\db\Migration;

/**
 * Class m180924_125001_monitoring_user_command_group
 */
class m180924_125001_monitoring_user_command_group extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
        $this->dropForeignKey('fk_monitoring_user_command_group_userId', 'monitoring_user_command_group');
        $this->dropForeignKey('fk_monitoring_user_command_group_commandId', 'monitoring_user_command_group');
        $this->dropForeignKey('fk_monitoring_user_command_group_groupId', 'monitoring_user_command_group');

        $this->dropIndex('idx_monitoring_user_command_group_userId', 'monitoring_user_command_group');
        $this->dropIndex('idx_monitoring_user_command_group_commandId', 'monitoring_user_command_group');
        $this->dropIndex('idx_monitoring_user_command_group_groupId', 'monitoring_user_command_group');

        $this->dropTable('monitoring_user_command_group');
    }
}
