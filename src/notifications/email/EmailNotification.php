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

    /**
     * @var string шаблон письма выполненного события с ошибками
     */
    private $pathMailWithError = '../vendor/pahan23456/yii2-monitoring/src/templates/mail/with-error-view.php';

    /**
     * путь шаблона, которые определяется в зависимости от статуса
     *
     * @var string
     */
    private $pathMail = '';

    public function __construct(Detail $detail)
    {
        $this->detail = $detail;
        $this->users = $this->detail->command->users;
        $this->setPathMail();
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

        if (empty($this->pathMail)) return false;

        Yii::$app->mailer->compose($this->pathMail ,[
            'user' => $user,
            'detail' => $this->detail
        ])->setTo($user->email)
            ->setSubject($subject)
            ->send();
    }

    /**
     * Воззвращает заголовок письма
     *
     * @return string
     */
    public function getSubject()
    {
        return '[' . Yii::$app->id . ']' . ' ' . $this->detail->message;
    }

    /**
     * Устанавливает путь, в зависимости от статуса события
     */
    public function setPathMail()
    {
        switch ($this->detail->status) {
            case Detail::STATUS_FAIL: { $this->pathMail = $this->pathMailError; } break;
            case Detail::STATUS_WITH_ERROR: {
                if ($this->detail->command->command == 'rest1c.commands.DefaultController.actionIndex') {
                    $errors = Detail::find()
                        ->where(['eventId' => $this->detail->eventId])
                        ->andWhere(['status' => Detail::STATUS_IN_PROCESS])
                        ->FilterWhere(['like', 'data', 'error'])
                        ->andFilterWhere(['like', 'data', '"isHidden":0'])
                        ->all();

                    if (!isset($errors) && empty($errors)) return false;
                    $this->pathMail = $this->pathMailWithError;
                }} break;
        }
    }
}