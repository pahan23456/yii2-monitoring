<?php
namespace pahan23456\monitoring\src\repository;

use pahan23456\monitoring\src\models\Command;
use pahan23456\monitoring\src\models\Detail;
use yii;

class MonitoringRepository implements MonitoringRepositoryInterface
{
   public function create($status, $message = null, $data = null, $eventId = null, $command = null)
   {
       $detail = new Detail();
       $detail->message = $message;
       $detail->status = $status;
       $detail->creationDate = date('Y.m.d H:i:s');

       if (is_array($data))
           $detail->data = json_encode($data);

       if (!$this->setCommandId($command, $detail))
           return false;

       if (!$this->setEventId($eventId, $detail))
           return false;

       if ($detail->save()) {
           if ($detail->status === Detail::STATUS_START) {
               $detail->eventId = $detail->id;
               $detail->save();
           }
       } else {
           return false;
       }

       return $detail;
   }

    /**
     * Устанаваливает идентификатор родительского события текущему
     *
     * @param $eventId
     * @param $monitoring
     */
   private function setEventId($eventId, &$detail)
   {
       if ($detail->status !== Detail::STATUS_START) {
           $event = Detail::findOne(['id' => $eventId]);

           if (!isset($event)) {
               return false;
           }
           $detail->eventId = $event->id;
           $detail->commandId = $event->commandId;
       }
       return true;
   }

    /**
     * Устанавливает идентификатор команды, при создании события
     *
     * @param $command
     * @param $detail
     * @return bool
     */
   private function setCommandId($command, &$detail)
   {
       if ($detail->status === Detail::STATUS_START) {
           $commandDb = Command::findOne(['command' => $command]);
           
           if (!isset($commandDb)) {
               return false;
           }
           $detail->commandId = $commandDb->id;
       }
       return true;
   }
}