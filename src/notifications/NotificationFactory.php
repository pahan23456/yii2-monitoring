<?php
namespace pahan23456\monitoring\src\notifications;

use pahan23456\monitoring\src\models\Detail;
use pahan23456\monitoring\src\notifications\email\EmailNotification;
use pahan23456\monitoring\src\notifications\telegram\TelegramNotification;

class NotificationFactory
{
    public static function createEmailNotification(Detail $detail)
    {
        return new EmailNotification($detail);
    }

    public static function createTelegramNotification(Detail $detail)
    {
        return new TelegramNotification($detail);
    }
}