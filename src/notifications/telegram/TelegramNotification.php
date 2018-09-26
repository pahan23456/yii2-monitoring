<?php
namespace pahan23456\monitoring\src\notifications\telegram;

use GuzzleHttp\Client;
use pahan23456\monitoring\src\models\Detail;
use pahan23456\monitoring\src\models\User;
use pahan23456\monitoring\src\notifications\NotificationInterface;

class TelegramNotification implements NotificationInterface
{
    /**
     * @var Detail Событие
     */
    public $detail;

    /**
     * @var User Люди, ответственные за выполнение событий
     */
    private $users;

    public function __construct(Detail $detail)
    {
        $this->detail = $detail;
        $this->users = $this->detail->command->users;
    }

    /**
     * Отправка уведомлений ответственным людям
     *
     * @return mixed|void
     */
    public function send()
    {
        if ($this->detail){
            $this->sendMessage(633664978, 'Тестовое сообщение','657191984:AAFmGcViGItDVmnknDuAFQ_wJHjc7cELdTE');
        }
    }

   private function sendMessage($chatID, $messaggio, $token) {
       $url = "https://api.telegram.org/" . $token . "/sendMessage?chat_id=" . $chatID;
       $url = $url . "&text=" . urlencode($messaggio);
       $ch = curl_init();
       $optArray = array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true
       );
       curl_setopt_array($ch, $optArray);
       $result = curl_exec($ch);
       curl_close($ch);
    }
}