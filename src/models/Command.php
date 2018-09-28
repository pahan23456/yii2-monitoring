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
        return '{{%monitoring_command}}';
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

    /**
     * Вспомогательная таблица для связи ManyToMany
     * @return \yii\db\ActiveQuery
     */
    public function getCommandGroup()
    {
        return $this->hasMany(UserCommandGroup::className(), ['commandId' => 'id']);
    }

    /**
     * Возвращает пользователей, которые ответствены за выполнение команды
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])->via('commandGroup');
    }

    /**
     * Возвращает детали выполнения для текущей команды
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLastDetail()
    {
        return $this->hasMany(Detail::className(), ['commandId' => 'id'])->orderBy(['id' => SORT_DESC])->one();
    }
}