<?php
namespace pahan23456\monitoring\src\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;
use pahan23456\monitoring\src\notifications\NotificationFactory;

class EmailJob extends BaseObject implements JobInterface
{
    public $detail;

    public function init()
    {
        parent::init();
    }

    public function execute($queue)
    {
        if ($this->detail) {
            $emailNotification = NotificationFactory::createEmailNotification($this->detail);
            $emailNotification->send();
        }
    }
}