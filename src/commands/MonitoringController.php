<?php
namespace pahan23456\monitoring\src\commands;

use pahan23456\monitoring\src\models\Detail;
use yii\console\Controller;
use Yii;

class MonitoringController extends Controller
{
    public function actionIndex()
    {
        echo 'Hello from Monitoring extention';
    }

    /**
     * Очищение событий, если истек срок жизни
     *
     */
    public function actionClear()
    {
        $timeLife = Yii::$app->monitoring->getTimeLife();

        if (!is_numeric($timeLife))
            return false;

        $details = Detail::find()->all();
        echo "Started delete details\n";

        foreach ($details as $detail) {
            if ($this->isOldDetail($detail, $timeLife))
                $detail->delete();
        }
        echo "Old details were successfully deleted\n";
    }

    /**
     * Проверка временижизни с
     *
     * @param Detail $detail
     * @param $timeLife
     * @return bool
     */
    private function isOldDetail(Detail $detail, $timeLife)
    {
        $timeLifeDetailAtTheMoment = strtotime($detail->creationDate) + $timeLife;
        $nowTime = time();

        if ($timeLifeDetailAtTheMoment < $nowTime) {
            return true;
        }
        return false;
    }
}