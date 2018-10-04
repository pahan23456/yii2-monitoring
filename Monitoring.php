<?php
namespace pahan23456\monitoring;

use pahan23456\monitoring\src\models\Detail;
use pahan23456\monitoring\src\notifications\NotificationFactory;
use pahan23456\monitoring\src\repository\RepositoryFactory;
use yii\base\Component;
use yii;

class Monitoring extends Component
{
    /**
     * @var RepositoryFactory
     */
    public $monitoringRepository;

    /**
     * @var время жизни хранения событий в БД, в секунадах
     * события хранятся в БД 30 суток!
     */
    private $timeLife = 2592000; // 30 дней = 2592000 секунд

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
      
      if ($detail) {
          return $detail->id;
      }
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
       $detail = $this->monitoringRepository->create(Detail::STATUS_WITH_ERROR, $message, $data, $eventId);
       $this->sendNotification($detail);
    }

    /**
     * Отправка уведомлений на email и в чат телеграма
     *
     * @param Detail $detail
     */
    private function sendNotification($detail)
    {
        if ($detail) {
            $emailNotification = NotificationFactory::createEmailNotification($detail);
            $emailNotification->send();

            $telegramNotification = NotificationFactory::createTelegramNotification($detail);
            $telegramNotification->send();
        }
    }

    /**
     * Возвращает время жизни событий в секундах
     *
     * @return время
     */
    public function getTimeLife()
    {
        return $this->timeLife;
    }
}