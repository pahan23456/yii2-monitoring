<?php
namespace pahan23456\monitoring\src\models;

use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "monitoring_user".
 *
 * @property integer $id
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $email
 * @property string $telegramChatId
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
        return '{{%monitoring_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lastname, firstname, middlename', 'email', 'telegramChatId'], 'string', 'max' => 50],
            [['creationDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'lastname'       => 'Фамилия',
            'fisrtname'      => 'Имя',
            'lastname'       => 'Отчество',
            'email'          => 'Электронная почта',
            'telegramChatId' => 'Телеграм чат идентификатор',
            'creationDate'   => 'Дата создания',
        ];
    }

    /**
     * Вспомогательнаця таблица
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroup()
    {
        return $this->hasMany(UserCommandGroup::className(), ['userId' => 'id']);
    }

    /**
     * Возвращает группы, в которых состоит пользователь
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['id' => 'groupId'])->via('userGroup');
    }

    /**
     * Возвращает команды, за выполнение которых, ответственен пользователь
     * @return \yii\db\ActiveQuery
     */
    public function getCommands()
    {
        return $this->hasMany(Command::className(), ['id' => 'commandId'])->via('userGroup');
    }

    /**
     * Возвращает инициалы ответственного
     *
     * @return string
     */
    public function getInitials()
    {
        return $this->lastname . ' '
            . StringHelper::truncate($this->firstname,1,'.') . ' '
            . StringHelper::truncate($this->middlename,1,'.') ;
    }
}