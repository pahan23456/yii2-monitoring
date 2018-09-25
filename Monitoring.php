<?php
namespace pahan23456\monitoring;

use pahan23456\monitoring\src\models\Detail;
use pahan23456\monitoring\src\notifications\NotificationFactory;
use pahan23456\monitoring\src\repository\RepositoryFactory;
use yii\base\Component;
use yii;

class Monitoring extends Component
{
    public $monitoringRepository;

    public function init()
    {
        parent::init();
        $this->monitoringRepository = RepositoryFactory::createMonitoringRepository();
    }

    /**
     * Создание события со статусом "start", что сигнализирует о старте события
     *
     * @param null $command - команда
     * @param null $message - сообщение события
     * @param null $data - вспомогательная информация
     *
     * @return int  $evenId -  идентификатор события
     */
    public function start($command, $message, $data = null)
    {
      $detail = $this->monitoringRepository->create(Detail::STATUS_START, $message, $data, null, $command);

      return $detail->id;
    }

    /**
     *  Создание события со статусом "inProcess", что сигнализирует о выполнеии события
     *
     * @param $eventId - идентификатор родительского события
     * @param $message - сообщение события
     * @param null $data - вспомогательная информация
     */
    public function inProcess($eventId, $message, $data = null)
    {
        $this->monitoringRepository->create(Detail::STATUS_IN_PROCESS, $message, $data, $eventId);
    }

    /**
     *  Создание события со статусом "success", что сигнализирует о успешном выполнеии события
     *
     * @param $eventId - идентификатор родительского события
     * @param $message - сообщение события
     * @param null $data - вспомогательная информация
     */
    public function success($eventId, $message, $data = null)
    {
        $this->monitoringRepository->create(Detail::STATUS_SUCCESS, $message, $data, $eventId);
    }

    /**
     *  Создание события со статусом "fail", что сигнализирует о неуспешном выполнении события
     *
     * @param $eventId - идентификатор родительского события
     * @param $message - сообщение события
     * @param null $data - вспомогательная информация
     */
    public function fail($eventId, $message, $data = null)
    {
        $detail = $this->monitoringRepository->create(Detail::STATUS_FAIL, $message, $data, $eventId);
        $this->sendNotification($detail);
    }

    /**
     *  Создание события со статусом "withError", что сигнализирует о выполнеии события с ошибкой
     *
     * @param $eventId - идентификатор родительского события
     * @param $message - сообщение события
     * @param null $data - вспомогательная информация
     */
    public function withError($eventId, $message, $data = null)
    {
        $this->monitoringRepository->create(Detail::STATUS_WITH_ERROR, $message, $data, $eventId);
    }

    /**
     * Отправка уведомлений на email и в чат телеграма
     *
     * @param Detail $detail
     */
    private function sendNotification(Detail $detail)
    {
        $emailNotification = NotificationFactory::createTelegramNotification($detail);
        $telegramNotification = NotificationFactory::createTelegramNotification($detail);
        $emailNotification->send();
        $telegramNotification->send();
    }
}