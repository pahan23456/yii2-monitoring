<?php
namespace pahan23456\monitoring;


use pahan23456\monitoring\src\models\Detail;
use pahan23456\monitoring\src\models\Group;
use pahan23456\monitoring\src\models\User;
use pahan23456\monitoring\src\repository\RepositoryFactory;
use yii\base\Component;

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
     * @param $message - сообщение события
     * @param $priority - приоритет события
     * @param null $data - вспомогательная информация
     * @return int  $evenId -  идентификатор события
     */
    public function start($message, $data = null)
    {
      $eventId = $this->monitoringRepository->create($message, Detail::STATUS_START, $data);
      return $eventId;
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
        $this->monitoringRepository->create($message, Detail::STATUS_IN_PROCESS, $data, $eventId);
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
        $this->monitoringRepository->create($message, Detail::STATUS_SUCCESS, $data, $eventId);
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
        $this->monitoringRepository->create($message, Detail::STATUS_FAIL, $data, $eventId);
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
        $this->monitoringRepository->create($message, Detail::STATUS_WITH_ERROR, $data, $eventId);
    }
}