<?php
namespace pahan23456\monitoring\src\notifications;

use pahan23456\monitoring\src\models\Detail;

interface NotificationInterface
{
    /**
     * Отправка уведомления
     *
     * @param Detail $detail
     * @return mixed
     */
    public function send();

}