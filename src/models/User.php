<?php
namespace pahan23456\monitoring\src\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "monitoring_user".
 *
 * @property integer $id
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $email
 * @property string $telegram
 * @property string $creationDate
 *
 *
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitoring_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lastname, firstname, middlename', 'email', 'telegram'], 'string', 'max' => 50],
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
            'lastname'     => 'Фамилия',
            'fisrtname'    => 'Имя',
            'lastname'     => 'Отчество',
            'email'        => 'Электронная почта',
            'telegram'     => 'Телеграм',
            'creationDate' => 'Дата создания',
        ];
    }

    public function getUserGroup()
    {
        return $this->hasMany(UserCommandGroup::className(), ['userId' => 'id']);
    }

    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['id' => 'groupId'])->via('userGroup');
    }
}