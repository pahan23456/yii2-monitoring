<?php
namespace pahan23456\monitoring\src\notifications\email;

use pahan23456\monitoring\src\models\Detail;
use pahan23456\monitoring\src\models\User;
use pahan23456\monitoring\src\notifications\NotificationInterface;

use yii;

class EmailNotification implements NotificationInterface
{
    /**
     * @var Detail Событие
     */
    public $detail;

    /**
     * @var User Люди, ответственные за выполнение событий
     */
    private $users;

    /**
     * @var string  шаблон письма при ошибках
     */
    private $pathMailError = '../vendor/pahan23456/yii2-monitoring/src/templates/mail/error-view.php';

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
            foreach ($this->users as $user) {
                $this->sendToUser($user, $this->getSubject());
            }
        }
    }

    /**
     * Отправка письма ответственному человеку
     *
     * @param User $user
     * @param $subject
     */
    private function sendToUser(User $user, $subject)
    {
        if (empty($user->email)) {
            return false;
        }

        Yii::$app->mailer->compose($this->pathMailError ,[
            'user' => $user,
            'detail' => $this->detail
        ])
            ->setFrom([Yii::$app->params['mailerEmail'] => 'Retail'])
            ->setTo($user->email)
            ->setSubject($subject)
            ->send();
    }

    /**
     * Воззвращает заголовок письма, в зависимости от статуса события
     *
     * @return string
     */
    public function getSubject()
    {
        if ($this->detail->status === Detail::STATUS_FAIL) {
            return '[' . $_SERVER['SERVER_NAME'] . ']' . ' ' . $this->detail->message;
        }
    }
}