<?php
namespace pahan23456\monitoring\src\notifications\telegram;

use pahan23456\monitoring\src\models\Detail;
use pahan23456\monitoring\src\models\User;
use pahan23456\monitoring\src\notifications\NotificationInterface;
use yii;

class TelegramNotification implements NotificationInterface
{
    /**
     * bot's token Токен бота телеграм
     *
     * @var string
     */
    private $token = '657191984:AAFmGcViGItDVmnknDuAFQ_wJHjc7cELdTE';
    /**
     * @var Detail Событие
     */
    public $detail;

    /**
     * @var User Люди, ответственные за выполнение событий
     */
    private $users;

    /**
     * @var Сообщение события
     */
    private $message;

    public function __construct(Detail $detail)
    {
        $this->detail = $detail;
        $this->users = $this->detail->command->users;
        $this->setMessage();
    }

    /**
     * Отправка уведомлений ответственным людям
     *
     * @return mixed|void
     */
    public function send()
    {
        if ($this->detail){
            foreach ($this->users as $user) {
                $this->sendToUser($user);
            }
        }
    }

    /**
     * Отправим сообщение выбранному пользователю
     *
     * @param $chatID
     * @param $message
     * @param $token
     */
    private function sendToUser(User $user)
    {
        if (empty($user->telegramChatId)) {
            return false;
        }

        $url = "https://api.telegram.org/bot" . $this->token . "/sendMessage";
        $params = [
            'chat_id' => $user->telegramChatId,
            'text' => $this->message,
        ];
        $ch = curl_init($url);
        $optArray = array(
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_SSL_VERIFYPEER => false,
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        if ($result === false) {
            Yii::error("Отправка уведомления в телеграм закончилась ошибкой: " . curl_error($ch));
        }
        curl_close($ch);
    }

    /**
     * Устанваливает содержание сообщения
     *
     */
    private function setMessage()
    {
            $this->message =  '<b>Мониторинг сайта:</b> ' . Yii::$app->id . '<br>' .
                              'Команда: ' . $this->detail->command->description . '<br>' .
                              'Название команды: ' . $this->detail->command->command . '<br>' .
                              'Статус: ' . $this->detail->status . '<br>' .
                              'Причина: ' . $this->detail->message . '<br>' .
                              'Время события: ' . $this->detail->creationDate . '<br>' .
                              'Подробности: ' . $this->detail->data;
    }
}