<?php
namespace pahan23456\monitoring\src\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{monitoring}}".
 *
 * @property integer $id
 * @property string $message
 * @property string $status
 * @property string $data
 * @property integer $priority
 * @property string $creationDate
 * @property integer $userId
 *
 */
class Monitoring extends ActiveRecord
{
    const STATUS_START = 'start';
    const STATUS_IN_PROCESS = 'inProcess';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitoring';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priority', 'userId'], 'integer'],
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
            'priority'     => 'Приоритет события',
            'userId'       => 'Идентификатор пользователя',
            'creationDate' => 'Дата создания события',
        ];
    }
}