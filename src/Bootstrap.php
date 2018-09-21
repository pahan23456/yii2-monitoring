<?php
namespace pahan23456\monitoring;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    //Метод, который вызывается автоматически при каждом запросе
    public function bootstrap($app)
    {
        //Правила маршрутизации
        $app->getUrlManager()->addRules([
            'monitoring' => 'monitoring/Monitoring',
        ], false);
        /*
         * Регистрация модуля в приложении
         * (вместо указания в файле frontend/config/main.php
         */
        $app->setModule('monitoring', 'pahan23456\monitoring\Monitoring');
    }
}