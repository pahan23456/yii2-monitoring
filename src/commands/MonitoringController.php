<?php
namespace pahan23456\monitoring\src\commands;

use pahan23456\monitoring\src\models\Detail;
use yii\console\Controller;
use Yii;
use pahan23456\monitoring\src\models\Command;
use pahan23456\monitoring\src\jobs\EmailJob;
use pahan23456\monitoring\src\jobs\TelegramJob;
use yii\helpers\Console;

class MonitoringController extends Controller
{
    public function actionIndex()
    {
        $this->stdout("Hello, i'am  a Monitoring extension\n\n", Console::BG_CYAN);
        $this->stdout("You can call next commands:\n", Console::BG_PURPLE);
        $this->stdout("- monitoring/clear (Clearing events in the database)\n",Console::BOLD);
        $this->stdout("- monitoring/check (Checking commands for execution for a given time interval)\n",Console::BOLD);
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
        $this->stdout("Started delete details\n\n", Console::BG_BLUE);

        foreach ($details as $detail) {
            if ($this->isOldDetail($detail, $timeLife))
                $detail->delete();
        }
        $this->stdout("Old details were successfully deleted.\n\n", Console::BG_PURPLE);
    }

    /**
     * Проверка корректности работы команд
     *
     */
    public function actionCheck()
    {
        $commandsFrequencyExecution = $this->getCommandsFrequencyExecution();

        foreach ($commandsFrequencyExecution as $commandName => $frequencyExecution) {
            $command = Command::findOne(['command' => $commandName]);

            if ($this->isNotWorkedCommand($command, $commandName, $frequencyExecution)) {
                $this->sendErrorNotification($command, $frequencyExecution);
            }
        }
    }

    /**
     * Проверка работы команды по частотному времени
     */
    private function isNotWorkedCommand($command, $commandName, $frequencyExecution)
    {
        if (!isset($command)) {
            $this->stdout("Command: {$commandName} don't exists.\n\n", Console::BG_RED);
            return false;
        }
        $detail = $command->lastDetail;

        if (!isset($detail)) {
            $this->stdout("Command: {$commandName} never used.\n", Console::BG_RED);
            return false;
        }


        if ($this->isOldDetail($detail, $frequencyExecution)) {
            $this->stdout("Command: {$commandName} not worked by set time.\nCommand needs be notified.\n", Console::BG_RED);
            return true;
        }
        return false;
    }

    /**
     * Отправка уведомоления с ошибкой о некорректной работе команды
     *
     * @param $command
     * @param $frequencyExecution
     */
    private function sendErrorNotification($command, $frequencyExecution)
    {
        $detail = new Detail();
        $detail->status = Detail::STATUS_FAIL;
        $detail->commandId = $command->id;
        $detail->message = "{$command->description} не работает по заданному интервалу времени - {$frequencyExecution} секунд.";
        $detail->data = json_encode(['error' => "Command must be execution every {$frequencyExecution} seconds"]);
        $detail->creationDate = date('Y.m.d H:i:s');

        if ($detail->save()) {
            Yii::$app->queue->push(new EmailJob([
                'detail' => $detail
            ]));

            Yii::$app->queue->push(new TelegramJob([
                'detail' => $detail
            ]));
            $this->stdout("Notification of a non-working command: {$command->command} sent.\n", Console::BG_PURPLE);
        }
    }

    /**
     * Проверка времени жизни события
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

    /**
     * Возвращает для каждой команды частотное время запуска каждой команды в секунадх
     */
    private function getCommandsFrequencyExecution()
    {
        return [
          'rest1c.commands.DefaultController.actionIndex' => 2700 // 45 минут
        ];
    }
}