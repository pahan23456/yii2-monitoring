Monitoring component with notifications for yii2
=============================
Monitoring component with notifications for yii2
Расширение разрабатывалось для мониторинга событий в любом проекте.
В процессе использования web-приложения, могут возникнуть нештатные ситуации, например из-за
криво написанного кода или к примеру плохого интернет-соединения во время импорта товаров 1С.
И для этого мы всегда сможем узнать какой метод подвел на этот раз. В расширении "Мониторинг",
 так-же разработана фабрика уведомлений, которая отсылает уведомления на email и в телеграм в случае ошибки
 или выполнения события с ошибками.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pahan23456/yii2-monitoring "*"

После установки расширения необходимо выполнить миграцию:

 php yii migrate --migrationPath=@pahan23456/monitoring/src/migrations
 
 Для того, чтобы компонент был доступен глобально из Yii::$app, пропишем его в конфиге
 web.php и console.php
 :
 
 'bootstrap' => ['queue'],
 'components' => [
         'monitoring' => [
             'class' => '\pahan23456\monitoring\Monitoring'
         ],
         'queue' => [
                     'class' => \yii\queue\db\Queue::class,
                     'db' => 'db', // Компонент подключения к БД или его конфиг
                     'tableName' => '{{%queue}}', // Имя таблицы
                     'channel' => 'default', // Выбранный для очереди канал
                     'mutex' => \yii\mutex\MysqlMutex::class, // Мьютекс для синхронизации запросов,
                     'as log' => \yii\queue\LogBehavior::class,
                 ],
        ]
         
 Расширение внутри себя использует расширение yiisoft/yii2-queue, драйвер можно использовать любой, в даном примере используем DbDriver
                Для работы с ним, необходимо раскрыть миграции:
                 'controllerMap' => [
                        'migrate' => [
                            'class' => 'yii\console\controllers\MigrateController',
                            'migrationPath' => null,
                            'migrationNamespaces' => [
                                'yii\queue\db\migrations',
                            ],
                        ],
                    ],
                    
                и затем выполнить yii migrate
                
 Внимание!!! Перед использованием расширения "Мониторинг", необходимо заполнить базу данных:
 User - люди, которым придет уведомление по email в случае ошибки;
 Group - логические группы, к которым принадлежат люди;
 Command - команды, которые необходимо мониторить, пример (rest1C.import);
UserCommandGroup - вспомогательная таблица, которая соединяет связи.
            
```

or add

```
"pahan23456/yii2-monitoring": "*"
```

to the require section of your `composer.json` file.

Usage
-----
### начало события 
$id = Yii::$app->monitoring->start('Команда', 'Начало события');
<!-- Здесь код события -->
### переводим статус события "в процессе" 
Yii::$app->monitoring->start($id, 'Основной процесс события');
<!-- Условия завершения событи -->
### в случае успеха
Yii::$app->monitoring->success($id, 'Успешное завершение события',['success' => $success]);
### в случае ошибки 
### если, произошла ошибка, необходимо оповестить ответственных людей
### отправка уведомлений происходит в отдельном потоке
Yii::$app->monitoring->fail($id, 'Неуспешное завершение события',['fail' => $fails]);
### в случае выполнения с ошибками
Yii::$app->monitoring->withError($id, 'Выполнено с ошибками',['fail' => $fails]);