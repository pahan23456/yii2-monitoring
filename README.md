Monitoring component for yii2
=============================
Monitoring component for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pahan23456/yii2-monitoring "*"

После установки расширения необходимо выполнить миграцию:

 php yii migrate --migrationPath=@pahan23456/monitoring/src/migrations
 
 Для того, чтобы компонент был доступен глобально из Yii::$app, пропишем его в конфиге:
 
 'components' => [
         'monitoring' => [
             'class' => '\pahan23456\monitoring\Monitoring'
         ],
        ]
```

or add

```
"pahan23456/yii2-monitoring": "*"
```

to the require section of your `composer.json` file.

Usage
-----
### 3 параметра, 2 из которых обязательны 
### 1 параметр - Название события
### 2 параметр - Приоритет события
### 3 параметр - Массив вспомогательных данных
### мониторинг события (старт выполнения события)
Yii::$app->monitoring->start('Начало события', 2,);
<!-- Здесь код события -->
### в случае успеха
Yii::$app->monitoring->success('Событие успешно выполнено', 2,['success' => $success]);
### в случае ошибки 
Yii::$app->monitoring->fail('Событие выполнилось с ошибкой', 2,['fail' => $fails]);