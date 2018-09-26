<?php
namespace pahan23456\monitoring\src\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "monitoring_user_command_group".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $commandId
 * @property integer $groupId
 * @property string $creationDate
 *
 */
class UserCommandGroup extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%monitoring_user_command_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'commandId', 'groupId'], 'integer'],
            [['creationDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'userId'       => 'Идентификатор пользователя',
            'commandId'    => 'Идентификатор команды',
            'groupId'      => 'Идентификатор группы',
            'creationDate' => 'Дата создания события',
        ];
    }
}