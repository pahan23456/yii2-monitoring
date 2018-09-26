<?php
namespace pahan23456\monitoring\src\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "monitoring_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $creationDate
 *
 */
class Group extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%monitoring_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 100],
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
            'name'         => 'Название группы',
            'description'  => 'Описание группы',
            'creationDate' => 'Дата создания',
        ];
    }

    /**
     * Вспомогательная таблица для связи ManyToMany
     * @return \yii\db\ActiveQuery
     */
    public function getGroupUser()
    {
        return $this->hasMany(UserCommandGroup::className(), ['groupId' => 'id']);
    }

    /**
     * Возвращает пользователей, которые состоят в текущей группе
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])->via('groupUser');
    }
}