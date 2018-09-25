<?php
namespace pahan23456\monitoring\src\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "monitoring_detail".
 *
 * @property integer $id
 * @property string $message
 * @property string $status
 * @property string $data
 * @property string $creationDate
 * @property integer $userId
 * @property integer $commandId
 * @property integer $eventId
 *
 */
class Detail extends ActiveRecord
{
    const STATUS_START = 'start';
    const STATUS_IN_PROCESS = 'inProcess';
    const STATUS_SUCCESS = 'success';
    const STATUS_WITH_ERROR = 'withError';
    const STATUS_FAIL = 'fail';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitoring_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'eventId', 'commandId'], 'integer'],
            [['message'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 10],
            [['creationDate'], 'safe'],
            [['data'],'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'message'      => 'Сообщения события',
            'status'       => 'Статус события',
            'data'         => 'Вспомогательная информация JSON',
            'userId'       => 'Идентификатор пользователя',
            'creationDate' => 'Дата создания события',
            'eventId'      => 'Идентификатор события',
            'commandId'    => 'Идентификатор команды',
        ];
    }

    /**
     * Возвращает команду
     * @return \yii\db\ActiveQuery
     */
    public function getCommand()
    {
        return $this->hasOne(Command::className(), ['id' => 'commandId']);
    }

}