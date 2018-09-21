<?php
namespace pahan23456\monitoring;

use pahan23456\monitoring\src\repository\RepositoryFactory;
use yii\base\Component;

class Monitoring extends Component
{
    public $content;

    public function init()
    {
        parent::init();
    }

    public function start($message, $priority, $data = null)
    {
      $monitoringRepository = RepositoryFactory::createMonitoringRepository();
      $monitoringRepository->create($message, \pahan23456\monitoring\src\models\Monitoring::STATUS_START, $priority, $data);
    }

    public function success($message, $priority, $data = null)
    {
        $monitoringRepository = RepositoryFactory::createMonitoringRepository();
        $monitoringRepository->create($message, \pahan23456\monitoring\src\models\Monitoring::STATUS_SUCCESS, $priority, $data);
    }

    public function fail($message, $priority, $data = null)
    {
        $monitoringRepository = RepositoryFactory::createMonitoringRepository();
        $monitoringRepository->create($message, \pahan23456\monitoring\src\models\Monitoring::STATUS_FAIL, $priority, $data);
    }
}