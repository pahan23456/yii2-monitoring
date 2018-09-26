<?php

use yii\db\Migration;

/**
 * Class m180921_122136_monitoring
 */
class m180921_122136_monitoring_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%monitoring_detail}}', [
            'id' => $this->primaryKey(),
            'message' => $this->string(255),
            'status' => $this->string(10),
            'data' => $this->text(),
            'creationDate' => $this->timestamp(),
            'userId' => $this->integer(),
            'commandId' => $this->integer(),
            'eventId' => $this->integer()
        ]);

        $this->createTable('{{%monitoring_user}}', [
            'id' => $this->primaryKey(),
            'lastname' => $this->string(50),
            'firstname' => $this->string(50),
            'middlename' => $this->string(50),
            'email' => $this->string(50),
            'telegram' => $this->string(50),
            'creationDate' => $this->timestamp()
        ]);

        $this->createTable('{{%monitoring_group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'description' => $this->string(255),
            'creationDate' => $this->timestamp()
        ]);

        $this->createTable('{{%monitoring_command}}', [
            'id' => $this->primaryKey(),
            'command' => $this->string(255),
            'description' => $this->string(255),
            'creationDate' => $this->timestamp()
        ]);
        
        $this->createIndex('idx_monitoring_detail_commandId', '{{%monitoring_detail}}', 'commandId');
        $this->addForeignKey('fk_monitoring_detail_commandId', '{{%monitoring_detail}}', 'commandId',
            '{{%monitoring_command}}',
            'id',
            'CASCADE',
            'CASCADE');

        $this->createTable('{{%monitoring_user_command_group}}',[
            'id' => $this->primaryKey(),
            'userId' => $this->integer(),
            'commandId' => $this->integer(),
            'groupId' => $this->integer(),
            'creationDate' => $this->timestamp()
        ]);

        $this->createIndex('idx_monitoring_user_command_group_userId', '{{%monitoring_user_command_group}}', 'userId');
        $this->createIndex('idx_monitoring_user_command_group_commandId', '{{%monitoring_user_command_group}}', 'commandId');
        $this->createIndex('idx_monitoring_user_command_group_groupId', '{{%monitoring_user_command_group}}', 'groupId');

        $this->addForeignKey('fk_monitoring_user_command_group_userId', '{{%monitoring_user_command_group}}', 'userId',
            '{{%monitoring_user}}',
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey('fk_monitoring_user_command_group_commandId', '{{%monitoring_user_command_group}}', 'commandId',
            '{{%monitoring_command}}',
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey('fk_monitoring_user_command_group_groupId', '{{%monitoring_user_command_group}}', 'groupId',
            '{{%monitoring_group}}',
            'id',
            'CASCADE',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_monitoring_user_command_group_userId', '{{%monitoring_user_command_group}}');
        $this->dropForeignKey('fk_monitoring_user_command_group_commandId', '{{%monitoring_user_command_group}}');
        $this->dropForeignKey('fk_monitoring_user_command_group_groupId', '{{%monitoring_user_command_group}}');

        $this->dropIndex('idx_monitoring_user_command_group_userId', '{{%monitoring_user_command_group}}');
        $this->dropIndex('idx_monitoring_user_command_group_commandId', '{{%monitoring_user_command_group}}');
        $this->dropIndex('idx_monitoring_user_command_group_groupId', '{{%monitoring_user_command_group}}');

        $this->dropTable('{{%monitoring_user_command_group}}');

        $this->dropTable('{{%monitoring_detail}}');
        $this->dropTable('{{%monitoring_user}}');
        $this->dropTable('{{%monitoring_group}}');
        $this->dropTable('{{%monitoring_command}}');

    }
}
