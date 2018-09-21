<?php
namespace pahan23456\monitoring\src\repository;

use pahan23456\monitoring\src\models\Monitoring;
use yii;

class MonitoringRepository implements MonitoringRepositoryInterface
{
   public function create($message, $status, $priority = 1, $data = null)
   {
       $monitoring = new Monitoring();
       $monitoring->message = $message;
       $monitoring->status = $status;
       $monitoring->creationDate = date('Y.m.d H:i:s');
       $monitoring->priority = $priority;

       if (is_array($data)) {
           $monitoring->data = json_encode($data);
       }
       if (!Yii::$app->user->isGuest) {
           $monitoring->userId = Yii::$app->user->id;
       }

       if (!$monitoring->validate()) {
          return false;
       }
       $monitoring->save(false);
   }
}