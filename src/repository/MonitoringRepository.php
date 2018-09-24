<?php
namespace pahan23456\monitoring\src\repository;

use pahan23456\monitoring\src\models\Detail;
use yii;

class MonitoringRepository implements MonitoringRepositoryInterface
{
   public function create($message, $status, $data = null, $eventId = null)
   {
       $detail = new Detail();
       $detail->message = $message;
       $detail->status = $status;
       $detail->creationDate = date('Y.m.d H:i:s');

       if (is_array($data)) {
           $detail->data = json_encode($data);
       }

       if (!Yii::$app->user->isGuest) {
           $detail->userId = Yii::$app->user->id;
       }
       $this->setEventId($eventId, $detail);

       if ($detail->save()) {
           if ($detail->status === Detail::STATUS_START) {
               $detail->eventId = $detail->id;
               $detail->save();
           }
       } else {
           return false;
       }

       return $detail->id;
   }

    /**
     * Устанаваливает идентификатор родительского события текущему
     *
     * @param $eventId
     * @param $monitoring
     */
   private function setEventId($eventId, &$monitoring)
   {
       if ($monitoring->status !== Detail::STATUS_START) {
           $event = Detail::findOne(['id' => $eventId]);
           $monitoring->eventId = $event->id;
       }
   }
}