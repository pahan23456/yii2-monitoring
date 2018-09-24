<?php
namespace pahan23456\monitoring\src\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "monitoring_command".
 *
 * @property integer $id
 * @property string $command
 * @property string $description
 * @property string $creationDate
 *
 */
class Command extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitoring_command';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['command', 'description'], 'string', 'max' => 255],
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
            'command'      => 'Путь команды',
            'description'  => 'Описание команды',
            'creationDate' => 'Дата создания',
        ];
    }

    public function getCommandGroup()
    {
        return $this->hasMany(UserCommandGroup::className(), ['commandId' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])->via('commandGroup');
    }
}